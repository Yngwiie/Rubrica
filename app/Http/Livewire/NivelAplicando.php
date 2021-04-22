<?php

namespace App\Http\Livewire;

use App\Models\NivelDesempeno;
use App\Models\Rubrica;
use App\Models\RubricaAplicada;
use Livewire\Component;

class NivelAplicando extends Component
{
    public NivelDesempeno $nivel;
    public RubricaAplicada $rubrica;
    public $nombre;
    public $id_nivel;
    public $puntaje_minimo;
    public $puntaje_maximo;
    public $puntaje;

    protected $listeners = ['nivel_updated'];

    public function mount(NivelDesempeno $nivel,RubricaAplicada $rubrica){
        $this->nivel = $nivel;
        $this->puntaje = $nivel->puntaje;
        $this->puntaje_minimo = $nivel->puntaje_minimo;
        $this->puntaje_maximo = $nivel->puntaje_maximo;
        $this->nombre = $nivel->nombre;
        $this->id_nivel = $nivel->id;
        $this->rubrica = $rubrica;
    }
    protected $rules = [
        'puntaje' => 'required|numeric|min:0|max:1000'
    ];

    public function render()
    {
        return view('livewire.nivel-aplicando');
    }
}
