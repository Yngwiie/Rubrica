<?php

namespace App\Http\Livewire;

use App\Models\Aspecto;
use App\Models\Criterio;
use Livewire\Component;

class AspectoAplicando extends Component
{
    public Aspecto $aspecto;
    public $nombre;
    public $porcentaje;
    public $id_aspecto;
    public $revision;
    public $criterios;
    public $aspecto_avanzado = FALSE;
    public $aplicados = [];
    public $tipo_puntaje;

    protected $rules = [
        'aspecto.nombre' => 'required|string',
        'aspecto.comentario' => 'string',
        'aspecto.porcentaje' => 'required|integer|min:0|max:100'
    ];

    public function mount(Aspecto $aspecto,$revision = null){
        $this->revision = $revision;
        $this->aspecto = $aspecto;
        $this->nombre = $aspecto->nombre;
        $this->id_aspecto = $aspecto->id;
        $this->tipo_puntaje = $this->aspecto->dimension->rubrica_aplicando->tipo_puntaje;
        $this->porcentaje = $aspecto->porcentaje;
        if($aspecto->criterios->first()->descripcion==null){
            $this->aspecto_avanzado = TRUE;
            $this->criterios = $aspecto->criterios;
            foreach(json_decode($this->criterios->first()->descripcion_avanzada) as $desc){
                array_push($this->aplicados,["id_criterio" => 0]);
            }
        }
        
    }

    public function render()
    {
        return view('livewire.aspecto-aplicando');
    }

    public function updated()
    {
        $this->validate();
        $this->aspecto->save();
        
    }

    public function aplicarAspectoAvanzado()
    {   
        $suma_puntaje = 0;
        $suma_puntaje_minimo = 0;
        $suma_puntaje_maximo = 0;
        if($this->aspecto->dimension->rubrica_aplicando->tipo_puntaje == "unico"){
            foreach($this->aplicados as $key => $aplicado){
                $criterio = Criterio::find($aplicado["id_criterio"]);
                $suma_puntaje+=json_decode($criterio->descripcion_avanzada)[$key]->porcentaje*$criterio->nivel->puntaje;
            }
            $this->aspecto->puntaje_obtenido = ($suma_puntaje/100);
        }else{
            foreach($this->aplicados as $key => $aplicado){
                $criterio = Criterio::find($aplicado["id_criterio"]);
                $suma_puntaje_minimo+=json_decode($criterio->descripcion_avanzada)[$key]->porcentaje*$criterio->nivel->puntaje_minimo;
                $suma_puntaje_maximo+=json_decode($criterio->descripcion_avanzada)[$key]->porcentaje*$criterio->nivel->puntaje_maximo;
            }
            $this->aspecto->puntaje_minimo = ($suma_puntaje_minimo/100);
            $this->aspecto->puntaje_maximo = ($suma_puntaje_maximo/100);
        }
        
        
        $this->aspecto->save();
        $this->emit('aplicar'.$this->aspecto->id,$this->aplicados);
    }

}
