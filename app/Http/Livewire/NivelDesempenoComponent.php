<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\NivelDesempeno;

class NivelDesempenoComponent extends Component
{

    public NivelDesempeno $nivel;
    public $nombre;
    public $id_nivel;


    public function mount(NivelDesempeno $nivel){
        $this->nivel = $nivel;
        $this->nombre = $nivel->nombre;
        $this->id_nivel = $nivel->id;
    }
    protected $rules = [
        'nivel.puntaje' => 'required',
    ];
    public function render()
    {
        return view('livewire.nivel-desempeno-component');
    }

    /* public function update(){

        $nivel = NivelDesempeno::find($this->nivel->id);
        $nivel->nombre = $this->nombre;
        $nivel->save();

    } */
    public function updated()
    {
        $this->validate();
        $this->nivel->nombre = $this->nombre;
        $this->nivel->save();
    }
}
