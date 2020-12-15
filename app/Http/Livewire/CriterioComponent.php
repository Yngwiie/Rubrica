<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Criterio;

class CriterioComponent extends Component
{

    public Criterio $criterio;
    public $descripcion;
    protected $listeners = ['update'];

    protected $rules = [
        'criterio.descripcion' => 'required',
    ];

    public function mount(Criterio $criterio){
        $this->criterio = $criterio;
        $this->descripcion = $criterio->descripcion;
        /* $this->nombre = $dimension->nombre;
        $this->id_dim = $dimension->id; */
    }

    public function render()
    {
        return view('livewire.criterio-component');
    }
    public function update(){
        $this->criterio->save();
    }
}
