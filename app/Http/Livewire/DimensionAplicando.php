<?php

namespace App\Http\Livewire;

use App\Models\Dimension;
use Livewire\Component;

class DimensionAplicando extends Component
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
        return view('livewire.dimension-aplicando');
    }
}
