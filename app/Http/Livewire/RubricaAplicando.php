<?php

namespace App\Http\Livewire;

use App\Models\Estudiante;
use App\Models\estudiante_evaluacion;
use App\Models\Rubrica;
use App\Models\RubricaAplicada;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class RubricaAplicando extends Component
{
    public RubricaAplicada $rubrica_aplicando;
    public Rubrica $rubrica;
    public Estudiante $estudiante;
    public $nota_minima;
    public $nota_maxima;
    public $nota_sugerida;
    public $nota_final;
    
    
    public function render()
    {

        return view('livewire.rubrica-aplicando');
    }

    public function mount($id_rubrica)
    {
        $this->rubrica_aplicando = RubricaAplicada::findOrFail($id_rubrica);
        $this->rubrica = $this->rubrica_aplicando->evaluacion->rubrica;
        $this->estudiante = Estudiante::find($this->rubrica_aplicando->id_estudiante);
        if($this->rubrica_aplicando->evaluacion->rubrica->id_usuario != Auth::user()->id ){//Evitar que puedan acceder a rubricas aplicadas de otros usuarios
            $this->rubrica_aplicando = "";
            abort(401);
        }
    }
    /**
     * Método para aplicar/ejecutar una rúbrica, donde se calcula la nota final.
     */
    public function aplicarRubrica()
    {
        try {
            if($this->rubrica_aplicando->tipo_puntaje == "unico"){//si el tipo de puntaje es único
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
                        if($aspecto->criterios->first()->descripcion!=null){//sumar puntaje obtenido de un aspecto normal.
                            $contador_criterios_sin_aplicar = 0;
                            
                            foreach($aspecto->criterios as $criterio){
                                if($criterio->aplicado == true){
                                    $sumas_puntajes_obtenido+=(($criterio->nivel->puntaje - $primer_nivel->puntaje)*$aspecto->porcentaje);
                                    break;
                                }
                                $contador_criterios_sin_aplicar+=1;
                            }
                            
                            if($contador_criterios_sin_aplicar == $aspecto->criterios->count()){
                                $this->emit('aspectosNoAplicados');
                                return;
                            }
                            
                        }else{//sumar puntaje obtenido de un aspecto avanzado.
                            if($aspecto->puntaje_obtenido != -1){
                                $sumas_puntajes_obtenido+=(($aspecto->puntaje_obtenido - $primer_nivel->puntaje)*$aspecto->porcentaje);
                            }else{
                                $this->emit('aspectosNoAplicados');
                                return;
                            }
                        }
                        $sumas_totales_aspectos+=($ultimo_nivel->puntaje - $primer_nivel->puntaje)*$aspecto->porcentaje;
                    }
                    $porcentaje_nota_dimension +=($sumas_puntajes_obtenido*$dimension->porcentaje)/$sumas_totales_aspectos;
                    if($this->rubrica_aplicando->escala_notas == "1-7"){
                        $dimension->notaAsociada = $this->redondeado(((($sumas_puntajes_obtenido/$sumas_totales_aspectos))*6)+1,1);
                        $dimension->save();
                    }elseif($this->rubrica_aplicando->escala_notas == "1-5"){
                        $dimension->notaAsociada = $this->redondeado(((($sumas_puntajes_obtenido/$sumas_totales_aspectos))*4)+1,1);
                        $dimension->save();
                    }elseif($this->rubrica_aplicando->escala_notas == "1-6"){
                        $dimension->notaAsociada = $this->redondeado(((($sumas_puntajes_obtenido/$sumas_totales_aspectos))*5)+1,1);
                        $dimension->save();
                    }elseif($this->rubrica_aplicando->escala_notas == "1-10"){
                        $dimension->notaAsociada = $this->redondeado(((($sumas_puntajes_obtenido/$sumas_totales_aspectos))*9)+1,1);
                        $dimension->save();
                    }elseif($this->rubrica_aplicando->escala_notas == "1-12"){
                        $dimension->notaAsociada = $this->redondeado(((($sumas_puntajes_obtenido/$sumas_totales_aspectos))*11)+1,1);
                        $dimension->save();
                    }elseif($this->rubrica_aplicando->escala_notas == "1-20"){
                        $dimension->notaAsociada = $this->redondeado(((($sumas_puntajes_obtenido/$sumas_totales_aspectos))*19)+1,1);
                        $dimension->save();
                    }elseif($this->rubrica_aplicando->escala_notas == "1-100"){
                        $dimension->notaAsociada = $this->redondeado(((($sumas_puntajes_obtenido/$sumas_totales_aspectos))*99)+1,1);
                        $dimension->save();
                    }
                    
                }
                //se multiplica por el puntaje maximo dependiendo la escala elegida.
                if($this->rubrica_aplicando->escala_notas == "1-7"){
                    $this->rubrica_aplicando->nota = $this->redondeado((($porcentaje_nota_dimension/100)*6)+1,1);
                    $this->rubrica_aplicando->save();
                }elseif($this->rubrica_aplicando->escala_notas == "1-5"){
                    $this->rubrica_aplicando->nota = $this->redondeado((($porcentaje_nota_dimension/100)*4)+1,1);
                    $this->rubrica_aplicando->save();
                }elseif($this->rubrica_aplicando->escala_notas == "1-6"){
                    $this->rubrica_aplicando->nota = $this->redondeado((($porcentaje_nota_dimension/100)*5)+1,1);
                    $this->rubrica_aplicando->save();
                }elseif($this->rubrica_aplicando->escala_notas == "1-10"){
                    $this->rubrica_aplicando->nota = $this->redondeado((($porcentaje_nota_dimension/100)*9)+1,1);
                    $this->rubrica_aplicando->save();
                }elseif($this->rubrica_aplicando->escala_notas == "1-12"){
                    $this->rubrica_aplicando->nota = $this->redondeado((($porcentaje_nota_dimension/100)*11)+1,1);
                    $this->rubrica_aplicando->save();
                }elseif($this->rubrica_aplicando->escala_notas == "1-20"){
                    $this->rubrica_aplicando->nota = $this->redondeado((($porcentaje_nota_dimension/100)*19)+1,1);
                    $this->rubrica_aplicando->save();
                }elseif($this->rubrica_aplicando->escala_notas == "1-100"){
                    $this->rubrica_aplicando->nota = $this->redondeado((($porcentaje_nota_dimension/100)*99)+1,1);
                    $this->rubrica_aplicando->save();
                }
                $this->emit('addScroll');
                $this->emit("notaAplicada");
                $estudiante = estudiante_evaluacion::where('id_estudiante',$this->rubrica_aplicando->id_estudiante)->where('id_evaluacion',$this->rubrica_aplicando->id_evaluacion)->first();
                $estudiante->nota = $this->rubrica_aplicando->nota;
                $estudiante->save();
            }else{//Aplicar rubrica con tipo de puntaje en rangos
                $porcentaje_nota_dimension_minimo = 0;
                $porcentaje_nota_dimension_maximo = 0;
                $porcentaje_nota_dimension_sugerido = 0;
                foreach($this->rubrica_aplicando->dimensiones as $dimension)
                {
                    $primer_nivel = $dimension->nivelesDesempeno->first();
                    $ultimo_nivel = $dimension->nivelesDesempeno->last();
                    
                    $sumas_puntajes_obtenido_minimo = 0;
                    $sumas_puntajes_obtenido_maximo = 0;
                    $sumas_puntajes_obtenido_sugerido = 0;
                    $sumas_totales_aspectos = 0;
                    foreach($dimension->aspectos as $aspecto){
                        if($aspecto->criterios->first()->descripcion!=null){//sumar puntaje obtenido de un aspecto normal.
                            $cantidad_criterios_aplicados = 0;
                            foreach($aspecto->criterios as $criterio){
                                if($criterio->aplicado == true){
                                    $sumas_puntajes_obtenido_minimo+=(($criterio->nivel->puntaje_minimo - $primer_nivel->puntaje_minimo)*$aspecto->porcentaje);
                                    $sumas_puntajes_obtenido_maximo+=(($criterio->nivel->puntaje_maximo - $primer_nivel->puntaje_minimo)*$aspecto->porcentaje);
                                    $sumas_puntajes_obtenido_sugerido+=(((($criterio->nivel->puntaje_maximo+$criterio->nivel->puntaje_minimo)/2) - $primer_nivel->puntaje_minimo)*$aspecto->porcentaje);
                                    break;
                                    
                                }
                                $cantidad_criterios_aplicados+=1;
                            }
                            if($cantidad_criterios_aplicados == $aspecto->criterios->count()){
                                $this->emit('aspectosNoAplicados');
                                return;
                            }
                            
                        }else{//sumar puntaje obtenido de un aspecto avanzado.
                            
                            if($aspecto->puntaje_minimo != -1 and $aspecto->puntaje_maximo != -1){
                                $sumas_puntajes_obtenido_sugerido+=(((($aspecto->puntaje_maximo + $aspecto->puntaje_minimo)/2) - $primer_nivel->puntaje_minimo)*$aspecto->porcentaje);
                                $sumas_puntajes_obtenido_minimo+=(($aspecto->puntaje_minimo - $primer_nivel->puntaje_minimo)*$aspecto->porcentaje);
                                $sumas_puntajes_obtenido_maximo+=(($aspecto->puntaje_maximo - $primer_nivel->puntaje_minimo)*$aspecto->porcentaje);
                            }else{
                                $this->emit('aspectosNoAplicados');
                                return;
                            }
                        }
                        $sumas_totales_aspectos+=($ultimo_nivel->puntaje_maximo - $primer_nivel->puntaje_minimo)*$aspecto->porcentaje;
                    }
                     
                    $porcentaje_nota_dimension_minimo +=($sumas_puntajes_obtenido_minimo*$dimension->porcentaje)/$sumas_totales_aspectos;
                    $porcentaje_nota_dimension_maximo +=($sumas_puntajes_obtenido_maximo*$dimension->porcentaje)/$sumas_totales_aspectos;
                    $porcentaje_nota_dimension_sugerido +=($sumas_puntajes_obtenido_sugerido*$dimension->porcentaje)/$sumas_totales_aspectos;       
                }
                //se multiplica por el puntaje maximo dependiendo la escala elegida.
                if($this->rubrica_aplicando->escala_notas == "1-7"){
                    
                    $this->nota_minima = $this->redondeado((($porcentaje_nota_dimension_minimo/100)*6)+1,1);
                    $this->nota_maxima = $this->redondeado((($porcentaje_nota_dimension_maximo/100)*6)+1,1);
                    $this->nota_sugerida = $this->redondeado((($porcentaje_nota_dimension_sugerido/100)*6)+1,1);
                }elseif($this->rubrica_aplicando->escala_notas == "1-5"){
                    $this->nota_minima = $this->redondeado((($porcentaje_nota_dimension_minimo/100)*4)+1,1);
                    $this->nota_maxima = $this->redondeado((($porcentaje_nota_dimension_maximo/100)*4)+1,1);
                    $this->nota_sugerida = $this->redondeado((($porcentaje_nota_dimension_sugerido/100)*4)+1,1);
                }elseif($this->rubrica_aplicando->escala_notas == "1-6"){
                    $this->nota_minima = $this->redondeado((($porcentaje_nota_dimension_minimo/100)*5)+1,1);
                    $this->nota_maxima = $this->redondeado((($porcentaje_nota_dimension_maximo/100)*5)+1,1);
                    $this->nota_sugerida = $this->redondeado((($porcentaje_nota_dimension_sugerido/100)*5)+1,1);
                }elseif($this->rubrica_aplicando->escala_notas == "1-10"){
                    $this->nota_minima = $this->redondeado((($porcentaje_nota_dimension_minimo/100)*9)+1,1);
                    $this->nota_maxima = $this->redondeado((($porcentaje_nota_dimension_maximo/100)*9)+1,1);
                    $this->nota_sugerida = $this->redondeado((($porcentaje_nota_dimension_sugerido/100)*9)+1,1);
                }elseif($this->rubrica_aplicando->escala_notas == "1-12"){
                    $this->nota_minima = $this->redondeado((($porcentaje_nota_dimension_minimo/100)*11)+1,1);
                    $this->nota_maxima = $this->redondeado((($porcentaje_nota_dimension_maximo/100)*11)+1,1);
                    $this->nota_sugerida = $this->redondeado((($porcentaje_nota_dimension_sugerido/100)*11)+1,1);
                }elseif($this->rubrica_aplicando->escala_notas == "1-20"){
                    $this->nota_minima = $this->redondeado((($porcentaje_nota_dimension_minimo/100)*19)+1,1);
                    $this->nota_maxima = $this->redondeado((($porcentaje_nota_dimension_maximo/100)*19)+1,1);
                    $this->nota_sugerida = $this->redondeado((($porcentaje_nota_dimension_sugerido/100)*19)+1,1);
                }elseif($this->rubrica_aplicando->escala_notas == "1-100"){
                    $this->nota_minima = $this->redondeado((($porcentaje_nota_dimension_minimo/100)*99)+1,1);
                    $this->nota_maxima = $this->redondeado((($porcentaje_nota_dimension_maximo/100)*99)+1,1);
                    $this->nota_sugerida = $this->redondeado((($porcentaje_nota_dimension_sugerido/100)*99)+1,1);
                }
                $this->emit('addScroll');//agregar doble scroll nuevamente.
                $this->emit('eleccionNota');//abrir modal de elección de nota final.
            }
        } catch (Throwable $e) {
            $this->emit('ErrorCalculo');
        }
        
    }
    
    public function redondeado ($numero, $decimales) 
    {
        $factor = pow(10, $decimales);
        return (round($numero*$factor)/$factor); 
    }

    public function aplicarNotaFinal()
    {
        $this->validate([
            'nota_final' =>'required|gte:nota_minima|lte:nota_maxima',
        ]);
        $this->rubrica_aplicando->nota = $this->nota_final;
        $this->rubrica_aplicando->save();
        $estudiante = estudiante_evaluacion::where('id_estudiante',$this->rubrica_aplicando->id_estudiante)->where('id_evaluacion',$this->rubrica_aplicando->id_evaluacion)->first();
        $estudiante->nota = $this->rubrica_aplicando->nota;
        $estudiante->save();
        $this->emit("notaFinalAplicada");
    }
}
