<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dimension;

class DimensionComponent extends Component
{
    public Dimension $dimension;
    public $nombre;
    public $id_dim;

    protected $listeners = ['refrescar'=>'$refresh'];

    public function mount(Dimension $dimension){
        $this->dimension = $dimension;
        $this->nombre = $dimension->nombre;
        $this->id_dim = $dimension->id;
    }

    public function render()
    {
        return view('livewire.dimension-component');
    }
    /**
     * Metodo para guardar cambios de la dimension.
     */
    /* public function update(){
        $dimension = dimension::find($this->dimension->id);
        $dimension->nombre = $this->nombre;
        $dimension->save();
    } */
    public function updated(){
        $dimension = dimension::find($this->dimension->id);
        $dimension->nombre = $this->nombre;
        $dimension->save();
       
    }
}
