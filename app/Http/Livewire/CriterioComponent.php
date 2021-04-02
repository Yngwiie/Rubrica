<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Criterio;
use phpDocumentor\Reflection\PseudoTypes\False_;

class CriterioComponent extends Component
{

    public Criterio $criterio;
    public $descripcion;
    public $descripcion_avanzada = [];
    public $id_criterio;
    protected $listeners = ['refrescar'=>'$refresh'];
    public $criterio_avanzado;
    public $deshabilitado;

    protected $rules = [
        'criterio.descripcion' => 'required|string',
    ];

    public function mount(Criterio $criterio){
        $this->criterio = $criterio;
        $this->descripcion = $criterio->descripcion;
        $this->id_criterio = $criterio->id;
        $this->deshabilitado = $criterio->deshabilitado;
        $this->descripcion_avanzada = json_decode($criterio->descripcion_avanzada);
        if($criterio->descripcion==null){
            $this->criterio_avanzado = TRUE;
        }else{
            $this->criterio_avanzado = FALSE;
        }
        
        /* $this->nombre = $dimension->nombre;
        $this->id_dim = $dimension->id; */
    }

    public function render()
    {
        return view('livewire.criterio-component');
    }
    /**
     * Metodo para guardar cambios del criterio.
     */
    /* public function update()
    {  
        $this->validate();
        $this->criterio->save();
      
    } */

    /**
     * Remove sub criteria
     */
    public function removeSubCriteria($index)
    {
        unset($this->descripcion_avanzada[$index]);
        $this->descripcion_avanzada = array_values($this->descripcion_avanzada);
        $this->updated();

    }

    /**
     * Add sub criteria to array.
     */
    public function addSubcriteria()
    {
        array_push($this->descripcion_avanzada, ['text'=>"nuevo"]);
        $this->updated();
    }
    public function updated()
    {
        if(!$this->criterio_avanzado){
            $this->validate();
        }else{
            $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
            $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
        }
        $this->criterio->deshabilitado = $this->deshabilitado;
        $this->criterio->save();
    }
}
