<?php

namespace App\Http\Livewire;

use App\Models\Dimension;
use Livewire\Component;
use App\Models\Rubrica;
use App\Models\Evaluacion;
use App\Models\NivelDesempeno;
use App\Models\Aspecto;
use App\Models\Criterio;
use Illuminate\Support\Facades\Auth;

class Plantilla extends Component
{
    public $id_evaluacion;
    public $id_rubrica;

    protected $rules = [
        'id_evaluacion' => 'required', 
    ];

    protected $messages = [
        'id_evaluacion.required' => 'La evaluación es obligatoria.',
    ];

    protected $listeners = ['copyTemplate'];

    public function render()
    {
        $plantillas = Rubrica::where('plantilla',TRUE)->get();
        $evaluaciones = Evaluacion::doesntHave('rubrica')->get();
        return view('livewire.plantilla',[
            'evaluaciones' => $evaluaciones, 
            'plantillas' => $plantillas,
        ]);
    }

    public function setIdRubrica($idrubrica)
    {
        $this->id_rubrica = $idrubrica;
    }

    public function resetInputFields(){
        $this->id_evaluacion = "";
        $this->id_rubrica = "";
    }

    public function copyTemplate()
    {
        $this->validate();

        $rubrica = Rubrica::find($this->id_rubrica);

        $newRubrica = Rubrica::create([
            'titulo' => $rubrica->titulo,
            'descripcion' => $rubrica->descripcion,
            'plantilla' => FALSE,
            'id_usuario' => Auth::user()->id,
            'id_evaluacion' => $this->id_evaluacion,
        ]);
        $dimensiones = Dimension::where('id_rubrica',$rubrica->id)->get();
        foreach($dimensiones as $dimension){
            $dim = Dimension::create([
                'nombre' => $dimension->nombre,
                'id_rubrica' => $newRubrica->id,
                'porcentaje' => $dimension->porcentaje,
            ]);
            $niveles = NivelDesempeno::where('id_dimension',$dimension->id)->get();
            $niveles_aux = [];
            foreach($niveles as $nivel){
                $niv = NivelDesempeno::create([
                    'nombre' => $nivel->nombre,
                    'ordenJerarquico' => $nivel->ordenJerarquico,
                    'id_dimension' => $dim->id,
                    'puntaje' => $nivel->puntaje,
                ]);
                array_push($niveles_aux,$niv->id);
            }
            $aspectos = Aspecto::where('id_dimension',$dimension->id)->get();
            foreach($aspectos as $aspecto){
                $asp = Aspecto::create([
                    'nombre' => $aspecto->nombre,
                    'id_dimension' => $dim->id,
                    'porcentaje' => $aspecto->porcentaje,
                ]);
                $criterios = Criterio::where('id_aspecto',$aspecto->id)->get();
                $i = 0;
                foreach($criterios as $criterio){
                    Criterio::create([
                        'descripcion' => $criterio->descripcion,
                        'descripcion_avanzada' => $criterio->descripcion_avanzada,
                        'deshabiltiado' => $criterio->deshabilitado,
                        'id_aspecto' => $asp->id,
                        'id_nivel' => $niveles_aux[$i],
                    ]);
                    $i++;
                }
            }

        }
        session()->flash('success','Rúbrica asociada a su evaluación.');
        $this->resetInputFields();
        return redirect()->route('rubric.edit', $newRubrica->id);

    }
}
