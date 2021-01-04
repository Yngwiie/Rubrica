<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Criterio;

class CriterioComponent extends Component
{

    public Criterio $criterio;
    public $descripcion;
    public $id_criterio;
    protected $listeners = ['refrescar'=>'$refresh'];

    protected $rules = [
        'criterio.descripcion' => 'required|string',
    ];

    public function mount(Criterio $criterio){
        $this->criterio = $criterio;
        $this->descripcion = $criterio->descripcion;
        $this->id_criterio = $criterio->id;
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
    public function updated()
    {
        $this->validate();
        $this->criterio->save();
    }
}
