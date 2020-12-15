<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dimension;

class DimensionComponent extends Component
{
    public Dimension $dimension;
    public $nombre;
    public $id_dim;

    protected $listeners = ['update'];

    public function mount(Dimension $dimension){
        $this->dimension = $dimension;
        $this->nombre = $dimension->nombre;
        $this->id_dim = $dimension->id;
    }

    public function render()
    {
        return view('livewire.dimension-component');
    }

    public function update(){

        $dimension = dimension::find($this->dimension->id);
        $dimension->nombre = $this->nombre;
        $dimension->save();

    }
}
