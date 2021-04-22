<?php

namespace App\Http\Livewire;

use App\Models\Aspecto;
use App\Models\Criterio;
use App\Models\Dimension;
use App\Models\Estudiante;
use App\Models\NivelDesempeno;
use App\Models\Rubrica;
use App\Models\RubricaAplicada;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RubricaAplicando extends Component
{
    public RubricaAplicada $rubrica_aplicando;
    public Rubrica $rubrica;
    public Estudiante $estudiante;

    protected $listeners = ['updated2'];
    
    public function render()
    {

        return view('livewire.rubrica-aplicando');
    }

    public function mount($id_rubrica)
    {
        $this->rubrica_aplicando = RubricaAplicada::find($id_rubrica);
        $this->rubrica = $this->rubrica_aplicando->evaluacion->rubrica;
        $this->estudiante = Estudiante::find($this->rubrica_aplicando->id_estudiante);
        if($this->rubrica_aplicando->evaluacion->rubrica->id_usuario != Auth::user()->id ){//Evitar que puedan acceder a rubricas aplicadas de otros usuarios
            $this->rubrica_aplicando = "";
            abort(401);
        }
    }
    public function updated2()
    {
        $this->rubrica_aplicando->save();
        $this->emit('addScroll');
    }
    
    public function aplicarRubrica()
    {
        $porcentaje_nota_dimension = 0;
        foreach($this->rubrica_aplicando->dimensiones as $dimension)
        {
            $primer_nivel = $dimension->nivelesDesempeno->first();
            $ultimo_nivel = $dimension->nivelesDesempeno->last();
            $num_aspectos = $dimension->aspectos->count();

            /* $puntaje_total_dimension = $nivel->puntaje*$num_aspectos; */
            $sumas_puntajes_obtenido = 0;
            $sumas_totales_aspectos = 0;
            foreach($dimension->aspectos as $aspecto){
                
                foreach($aspecto->criterios as $criterio){
                    if($criterio->aplicado == true){
                        $sumas_puntajes_obtenido+=(($criterio->nivel->puntaje - $primer_nivel->puntaje)*$aspecto->porcentaje);
                        break;
                    }
                }
                $sumas_totales_aspectos+=($ultimo_nivel->puntaje - $primer_nivel->puntaje)*$aspecto->porcentaje;
            }

            $porcentaje_nota_dimension +=($sumas_puntajes_obtenido*$dimension->porcentaje)/$sumas_totales_aspectos;
            
        }
        if($this->rubrica_aplicando->escala_notas = "1-7"){
            $this->rubrica_aplicando->nota = $this->redondeado(($porcentaje_nota_dimension/100)*7,1);
            $this->rubrica_aplicando->save();
            $this->emit('addScroll');
            $this->emit("notaAplicada");
        }
        
    }
    public function redondeado ($numero, $decimales) 
    {
        $factor = pow(10, $decimales);
        return (round($numero*$factor)/$factor); 
     }
}
