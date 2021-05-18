<?php

namespace App\Http\Livewire;

use App\Exports\RubricExport;
use Livewire\Component;
use App\Models\Rubrica;
use App\Models\Dimension;
use App\Models\Criterio;
use App\Models\Aspecto;
use App\Models\NivelDesempeno;
use App\Models\Evaluacion;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ShowRubricas extends Component
{
    public $currentPage = 1;
    public $rubrica_id;
    public $nombre_copia;
    public $descripción_copia;
    public $id_evaluacion;
    public $searchTerm;

    protected $rules = [
        'id_evaluacion' => 'required', 
    ];

    protected $listeners = ['copyRubric'];
    
    public function render()
    {
        $user = Auth::user();
        $searchTerm = '%'.$this->searchTerm.'%';
        $rubricas = Rubrica::where('titulo','LIKE',$searchTerm)
                            ->where('id_usuario',$user->id)
                            ->where('plantilla',0)->orderBy('id', 'DESC')->paginate(6);
        $evaluaciones = Evaluacion::doesntHave('rubrica')->get();
        return view('livewire.show-rubricas', ['rubricas' => $rubricas, 'evaluaciones' => $evaluaciones]);
    }

    public function resetInputFields()
    {
        $this->rubrica_id = '';
    }

    /**
     * setear datos de la Rubrica que se eliminara
     */
    public function delete($id)
    {
        $data = Rubrica::findOrFail($id);

        $this->rubrica_id = $id;
    }
    /**
     * Eliminar rubrica con los datos seteados.
     */
    public function destroy()
    {
        Rubrica::destroy($this->rubrica_id);
        session()->flash('success', 'Rúbrica eliminada con éxito.');
        $this->resetInputFields();
        $this->emit('rubricaEliminada');
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];

        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }

    public function copyRubric()
    {
        $this->validate();

        $rubrica = Rubrica::find($this->rubrica_id);

        $newRubrica = Rubrica::create([
            'titulo' => $rubrica->titulo,
            'descripcion' => $rubrica->descripcion,
            'plantilla' => FALSE,
            'id_usuario' => Auth::user()->id,
            'id_evaluacion' => $this->id_evaluacion,
            'escala_notas' => $rubrica->escala_notas,
            'nota_aprobativa' => $rubrica->nota_aprobativa,
            'tipo_puntaje' => $rubrica->tipo_puntaje,
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
                        'deshabilitado' => $criterio->deshabilitado,
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
    
    public function setIdRubrica($rubrica_id)
    {
        $this->rubrica_id = $rubrica_id;
        $this->emit('addTooltip');
        
    }

    public function exportPDF()
    {
        $rubrica = Rubrica::find($this->rubrica_id);
        $pdf = PDF::setPaper('A3', 'landscape')->loadView('export.rubricaPDF',['rubrica' => $rubrica])->output();;
        
        
        return response()->streamDownload(
            fn () => print($pdf),
            "rubrica.pdf"
       );
    }
    public function exportEXCEL()
    {
        return Excel::download(new RubricExport($this->rubrica_id), 'rubrica.xlsx');
    }
}
