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

    protected $rules = [
        'criterio.descripcion' => 'required|string',
    ];

    public function mount(Criterio $criterio){
        $this->id_subcriterio = -1;
        $this->criterio = $criterio;
        $this->descripcion = $criterio->descripcion;
        $this->id_criterio = $criterio->id;
        $this->deshabilitado = $criterio->deshabilitado;
        $this->aplicado = $criterio->aplicado;
        $this->descripcion_avanzada = json_decode($criterio->descripcion_avanzada);
        if($criterio->descripcion==null){
            $this->criterio_avanzado = TRUE;
        }else{
            $this->criterio_avanzado = FALSE;
        }
    }
    protected function getListeners()
    {
        return ['updated_2'.$this->criterio->id_aspecto => 'updated_2'];
    }
    public function render()
    {
        return view('livewire.criterio-aplicando');
    }
    public function updated()
    {
        $this->criterio->aplicado = $this->aplicado;
        $aspecto = Aspecto::find($this->criterio->id_aspecto);
        foreach($aspecto->criterios as $criterio){
            if($criterio->id != $this->criterio->id){
                $criterio->aplicado = 0;
                $criterio->save();
                
            }
        }
        
        $this->emitUp("updated2");
        $this->criterio->save();
    }
}
