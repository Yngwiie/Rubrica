<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dimension;

class DimensionComponent extends Component
{
    public Dimension $dimension;
    public $nombre;
    public $id_dim;
    public $porcentaje;

    public function mount(Dimension $dimension){
        $this->dimension = $dimension;
        $this->nombre = $dimension->nombre;
        $this->id_dim = $dimension->id;
        $this->porcentaje = $dimension->porcentaje;
    }

    public function render()
    {
        return view('livewire.dimension-component');
    }
    
    public function updated(){
        $this->validate([
            'porcentaje' => 'required|integer|min:1|max:100',
            'nombre' => 'required'
        ]);
        $dimension = dimension::find($this->dimension->id);
        $dimension->nombre = $this->nombre;
        $dimension->porcentaje = $this->porcentaje;
        $dimension->save();
       
    }
}
