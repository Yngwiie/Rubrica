<?php

namespace App\Http\Livewire;

use App\Models\Aspecto;
use App\Models\Criterio;
use App\Models\Dimension;
use App\Models\Estudiante;
use App\Models\Evaluacion;
use App\Models\Modulo;
use App\Models\NivelDesempeno;
use App\Models\Rubrica;
use App\Models\RubricaAplicada;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class EstudiantesAplicacion extends Component
{
    public Rubrica $rubrica;
    public $rubrica_aplicando;
    public $currentPage = 1;
    public $searchTerm;
    public $id_estudiante;
    public $nombre_modulo;

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $evaluacion = Evaluacion::find($this->rubrica->id_evaluacion);
        return view('livewire.estudiantes-aplicacion',['estudiantes' => $evaluacion->estudiantes()->where('nombre','LIKE',$searchTerm)
                                                                                                  ->paginate(6)]);
    }

    public function mount($id_rubrica)
    {
        $this->rubrica = Rubrica::find($id_rubrica);
        if($this->rubrica->id_usuario != Auth::user()->id ){//Evitar que puedan acceder a modulos de otros usuarios
            $this->rubrica = "";
            abort(401);
        }
        $this->nombre_modulo = $this->rubrica->evaluacion->modulo->nombre;
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];

        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }

    public function aplicar($id_estudiante)
    {
        $this->id_estudiante = $id_estudiante;
        $this->rubrica_aplicando = RubricaAplicada::where('id_evaluacion',$this->rubrica->id_evaluacion)->where('id_estudiante',$id_estudiante)->first();
        if($this->rubrica_aplicando == null){
            $this->copyRubric();
            return redirect()->route('applying.rubrica', ['id_rubrica' => $this->rubrica_aplicando->id]);
        }else{
            if($this->rubrica->version != $this->rubrica_aplicando->version){
                $this->emit('alertaNuevaVersion');
            }else{
                return redirect()->route('applying.rubrica', ['id_rubrica' => $this->rubrica_aplicando->id]);
            }
        }
        
    }
    public function copyRubric()
    {

        $rubrica = $this->rubrica;

        $newRubrica = RubricaAplicada::create([
            'titulo' => $rubrica->titulo,
            'descripcion' => $rubrica->descripcion,
            'id_estudiante' => $this->id_estudiante,
            'id_evaluacion' => $this->rubrica->id_evaluacion,
            'escala_notas' => $this->rubrica->escala_notas,
            'version' => $this->rubrica->version,
            'tipo_puntaje' => $this->rubrica->tipo_puntaje,
        ]);
        $dimensiones = Dimension::where('id_rubrica',$rubrica->id)->get();
        foreach($dimensiones as $dimension){
            $dim = Dimension::create([
                'nombre' => $dimension->nombre,
                'id_rubricaAplicada' => $newRubrica->id,
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
                    'puntaje_minimo' => $nivel->puntaje_minimo,
                    'puntaje_maximo' => $nivel->puntaje_maximo,
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
                        'deshabilitado' => $criterio->deshabilitado,
                        'id_aspecto' => $asp->id,
                        'id_nivel' => $niveles_aux[$i],
                    ]);
                    $i++;
                }
            }

        }
        $this->rubrica_aplicando = $newRubrica;
    }
    public function nuevaVersion()
    {
        $this->rubrica_aplicando->delete();
        $this->copyRubric();
        return redirect()->route('applying.rubrica', ['id_rubrica' => $this->rubrica_aplicando->id]);
    }
    public function versionAntigua()
    {
        return redirect()->route('applying.rubrica', ['id_rubrica' => $this->rubrica_aplicando->id]);
    }

}
