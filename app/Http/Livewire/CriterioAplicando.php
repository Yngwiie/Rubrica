<?php

namespace App\Http\Livewire;

use App\Models\Aspecto;
use App\Models\Criterio;
use Livewire\Component;

class CriterioAplicando extends Component
{
    public Criterio $criterio;
    public $descripcion;
    public $descripcion_avanzada = [];
    public $id_criterio;
    public $criterio_avanzado;
    public $deshabilitado;
    public $id_subcriterio;
    public $aplicado;
    public $revision;
    public $aspecto;

    protected $rules = [
        'criterio.descripcion' => 'required|string',
    ];

    public function mount(Criterio $criterio, $revision = null){
        $this->revision = $revision;
        $this->id_subcriterio = -1;
        $this->criterio = $criterio;
        $this->descripcion = $criterio->descripcion;
        $this->id_criterio = $criterio->id;
        $this->deshabilitado = $criterio->deshabilitado;
        $this->aplicado = $criterio->aplicado;
        $this->aspecto = Aspecto::find($this->criterio->id_aspecto);
        $this->descripcion_avanzada = json_decode($criterio->descripcion_avanzada);
        if($criterio->descripcion==null){
            $this->criterio_avanzado = TRUE;
        }else{
            $this->criterio_avanzado = FALSE;
        }
    }
    protected function getListeners()
    {
        return ['updated_2'.$this->criterio->id_aspecto => 'updated_2',
                'aplicar'.$this->criterio->id_aspecto => 'aplicarSubcriterio',
                'updated_aplicado'.$this->criterio->id => "mount"];
    }
    public function render()
    {
        return view('livewire.criterio-aplicando');
    }
    public function updated()
    {
        $this->criterio->aplicado = $this->aplicado;
        foreach($this->aspecto->criterios as $criterio){
            if($criterio->id != $this->criterio->id){
                if($criterio->aplicado == 1){
                    $criterio->aplicado = 0;
                    $criterio->save();
                    $this->emit("updated_aplicado".$criterio->id,$criterio);
                }
                
            }
        }
        
        $this->criterio->save();
        
    }
    public function upd(){
        $this->criterio->save();
    }
    public function aplicarSubcriterio($aplicados)
    {
        $aux = json_decode($this->criterio->descripcion_avanzada);
        foreach($aplicados as $key => $aplicado){
            if($aplicado["id_criterio"] == $this->criterio->id){
                $aux[$key]->aplicado = true;
            }else{
                $aux[$key]->aplicado = false;
            }
        }
        $this->criterio->descripcion_avanzada = json_encode($aux);
        $this->criterio->save();
        $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
    }
}
