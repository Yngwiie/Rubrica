<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\NivelDesempeno;

class NivelDesempenoComponent extends Component
{

    public NivelDesempeno $nivel;
    public $nombre;
    protected $listeners = ['refrescar'=>'$refresh'];


    public function mount(NivelDesempeno $nivel){
        $this->nivel = $nivel;
        $this->nombre = $nivel->nombre;
    }
    public function render()
    {
        return view('livewire.nivel-desempeno-component');
    }

    /* public function update(){

        $nivel = NivelDesempeno::find($this->nivel->id);
        $nivel->nombre = $this->nombre;
        $nivel->save();

    } */
    public function updated(){

        $nivel = NivelDesempeno::find($this->nivel->id, ['id', 'nombre']);
        $nivel->nombre = $this->nombre;
        $nivel->save();

    }
}
