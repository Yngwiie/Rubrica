<?php

namespace App\Http\Livewire;

use App\Models\Aspecto;
use Livewire\Component;

class AspectoAplicando extends Component
{
    public Aspecto $aspecto;
    public $nombre;
    public $porcentaje;
    public $id_aspecto;
    public $revision;

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
        $this->porcentaje = $aspecto->porcentaje;
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

}
