<?php

namespace App\Http\Livewire;

use App\Models\estudiante_evaluacion;
use App\Models\RubricaAplicada;
use Livewire\Component;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class EstadisticasRubrica extends Component
{
    public $rubrica_aplicada;
    public $colores = [];
/*     protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
    ]; */

    public function mount($id_rubrica)
    {
        $this->rubrica_aplicada = RubricaAplicada::find($id_rubrica);
    }
/* 
    public function handleOnSliceClick($slice)
    {
        dd($slice);
    } */
    
    public function render()
    {
        $estudiantes_aprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','>=','4')->where('nota','!=','-1')->count();
        $estudiantes_reprobados = estudiante_evaluacion::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->where('nota','<','4')->where('nota','!=','-1')->count();
        $pieChartModel = (new PieChartModel())
                        ->setTitle('Estudiantes Aprobados/Reprobados')
                        ->setAnimated(true)
                        ->withOnSliceClickEvent('onSliceClick')
                        ->addSlice('Aprobados', $estudiantes_aprobados, '#03CA1E')
                        ->addSlice('Reprobados', $estudiantes_reprobados, '#FF0000')
                        ->withDataLabels();
        $columnChartModel = (new ColumnChartModel())
                            ->setTitle('Promedio notas en dimensiónes de aspectos')
                            ->setAnimated(true)
                            ->withDataLabels();
        if($this->rubrica_aplicada->tipo_puntaje == "unico"){
            $rubricas_aplicadas = RubricaAplicada::where('id_evaluacion',$this->rubrica_aplicada->id_evaluacion)->get();
            $total_rubricas = $rubricas_aplicadas->count();
            $suma_notas_dimensiones = [];
            foreach($this->rubrica_aplicada->dimensiones as $dimension){
                array_push($suma_notas_dimensiones,["nombre" => $dimension->nombre,"suma_total" => 0]);
            }
    
                
            foreach($rubricas_aplicadas as $rubrica){
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
        
        return view('livewire.estadisticas-rubrica',['pieChartModel' => $pieChartModel,'columnChartModel' => $columnChartModel]);
    }
    public function redondeado ($numero, $decimales) 
    {
        $factor = pow(10, $decimales);
        return (round($numero*$factor)/$factor); 
    }
}
