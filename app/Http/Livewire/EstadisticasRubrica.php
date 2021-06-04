<?php

namespace App\Http\Livewire;

use App\Models\Estudiante;
use App\Models\estudiante_evaluacion;
use App\Models\Evaluacion;
use App\Models\modulo_estudiante;
use App\Models\RubricaAplicada;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Facades\Auth;

class EstadisticasRubrica extends Component
{
    public $rubrica_aplicada;
    public $colores = [];
    public $misRubricas;
    public Evaluacion $evaluacion;
    public $tipo_puntaje;
    public $estudiante_no_percenece_al_modulo;

    public function mount($id_evaluacion, $misRubricas = null,$id_rubrica = null)
    {
        $this->misRubricas = $misRubricas;//Para identificar si el profesor esta consultando estadisticas o el estudiante.
        $this->evaluacion = Evaluacion::findOrFail($id_evaluacion);

        $this->rubrica_aplicada = RubricaAplicada::where('id_evaluacion',$id_evaluacion)->where('nota','!=',-1)->first();

        if($this->rubrica_aplicada != null){
            $this->tipo_puntaje = $this->rubrica_aplicada->tipo_puntaje;
        }
        
        
    }
/* 
    public function handleOnSliceClick($slice)
    {
        dd($slice);
    } */
    
    public function render()
    {
        $pieChartModel = 0;
        $columnChartModel = 0;
    
        if($this->rubrica_aplicada == null)
        {
            $this->rubrica_aplicada = $this->evaluacion->rubrica;
            return view('livewire.estadisticas-rubrica',['pieChartModel' => $pieChartModel,'columnChartModel' => $columnChartModel,'pocosDatos' => true]);
        }
        $estudiante = Estudiante::where('email',Auth::user()->email)->first();
        $modulo_estudiante = modulo_estudiante::where('id_estudiante',$estudiante->id)->where('id_modulo',$this->rubrica_aplicada->evaluacion->modulo->id)->first();
        if($modulo_estudiante == null & $this->misRubricas==null){//validar si el estudiante aun pertenece al curso, para poder ver estadisticas.
            $this->estudiante_no_percenece_al_modulo = true;
            $this->rubrica_aplicada = $this->evaluacion->rubrica;
            return view('livewire.estadisticas-rubrica',['pieChartModel' => $pieChartModel,'columnChartModel' => $columnChartModel,'pocosDatos' => true]);
        }
        if($this->rubrica_aplicada->escala_notas == "1-7"){
            $estudiantes_aprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','>=',$this->rubrica_aplicada->nota_aprobativa)->where('nota','!=','-1')->count();
            $estudiantes_reprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','<',$this->rubrica_aplicada->nota_aprobativa)->where('nota','!=','-1')->count();
        }elseif($this->rubrica_aplicada->escala_notas == "1-100"){
            $estudiantes_aprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','>=',$this->rubrica_aplicada->nota_aprobativa)->where('nota','!=','-1')->count();
            $estudiantes_reprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','<',$this->rubrica_aplicada->nota_aprobativa)->where('nota','!=','-1')->count();
        }else{
            $estudiantes_aprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','>=',$this->rubrica_aplicada->nota_aprobativa)->where('nota','!=','-1')->count();
            $estudiantes_reprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','<',$this->rubrica_aplicada->nota_aprobativa)->where('nota','!=','-1')->count();
        }
        
        $pieChartModel = (new PieChartModel())
                        ->setAnimated(true)
                        ->addSlice('Aprobados', $estudiantes_aprobados, '#03CA1E')
                        ->addSlice('Reprobados', $estudiantes_reprobados, '#FF0000')
                        ->withDataLabels();
        $columnChartModel = (new ColumnChartModel())
                            ->setAnimated(true)
                            ->withDataLabels();
        if($this->rubrica_aplicada->tipo_puntaje == "unico"){//calcular estadisticas de las rubricas que esten aplicadas con puntaje único.
            $rubricas_aplicadas = RubricaAplicada::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where("nota","!=",-1)->get();
            $total_rubricas = $rubricas_aplicadas->count();
            $suma_notas_dimensiones = [];
            foreach($this->rubrica_aplicada->dimensiones as $dimension){
                array_push($suma_notas_dimensiones,["nombre" => $dimension->nombre,"suma_total" => 0]);
            }
    
                
            foreach($rubricas_aplicadas as $rubrica){
                if($rubrica->tipo_puntaje == "rango"){
                    $this->tipo_puntaje = "rango";
                    return view('livewire.estadisticas-rubrica',['pieChartModel' => $pieChartModel,'columnChartModel' => $columnChartModel,'pocosDatos' => false]);
                }
                $i = 0;
                foreach($rubrica->dimensiones as $dimension){
                    $suma_notas_dimensiones[$i]["suma_total"] += $dimension->notaAsociada;
                    $i++;
                }
            }
            foreach($suma_notas_dimensiones as $suma){
                
                $color = substr(md5(rand()), 0, 6);
                while(in_array($color,$this->colores)){
                    $color = substr(md5(rand()), 0, 6);;
                }
                array_push($this->colores,$color);
                $columnChartModel->addColumn($suma["nombre"],$this->redondeado($suma["suma_total"]/$total_rubricas,1),"#".$color);
            }
        }
        
        return view('livewire.estadisticas-rubrica',['pieChartModel' => $pieChartModel,'columnChartModel' => $columnChartModel,'pocosDatos' => false]);
    }
    public function redondeado ($numero, $decimales) 
    {
        $factor = pow(10, $decimales);
        return (round($numero*$factor)/$factor); 
    }
}
