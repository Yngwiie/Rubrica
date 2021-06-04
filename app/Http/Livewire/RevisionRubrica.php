<?php

namespace App\Http\Livewire;

use App\Models\Estudiante;
use App\Models\RubricaAplicada;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RevisionRubrica extends Component
{
    public RubricaAplicada $rubrica_aplicando;
    public Estudiante $estudiante;
    
    public function render()
    {
        return view('livewire.revision-rubrica');
    }

    public function mount($id_rubrica){
        $this->rubrica_aplicando = RubricaAplicada::findOrFail($id_rubrica);
        $this->estudiante = Estudiante::find($this->rubrica_aplicando->id_estudiante);
        if($this->rubrica_aplicando->estudiante->email != Auth::user()->email ){//Evitar que puedan acceder a la revision de una rubrica de otro estudiante.
            $this->rubrica_aplicando = "";
            abort(401);
        }
    }
}
