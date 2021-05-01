<?php

namespace App\Http\Livewire;

use App\Models\Estudiante;
use App\Models\Rubrica;
use App\Models\RubricaAplicada;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EstudianteRubricasAplicadas extends Component
{
    public $currentPage = 1;
    public $searchTerm;
    public $rubrica_id;

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $estudiante = Estudiante::where('email',Auth::user()->email)->first();
        $rubricas = RubricaAplicada::where('id_estudiante',$estudiante->id)->where('titulo','LIKE',$searchTerm)
                                                                           ->orderBy('id','DESC')
                                                                           ->paginate(10);
        return view('livewire.estudiante-rubricas-aplicadas',['rubricas' => $rubricas]);
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=',$url)[1];

        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }

    public function setIdRubrica($idRubrica)
    {
        $this->rubrica_id = $idRubrica;
    }
    /**
     * Exportar resultados en PDF.
     */
    public function exportPDF()
    {
        $rubrica = RubricaAplicada::find($this->rubrica_id);
        $pdf = PDF::setPaper('A3', 'landscape')->loadView('export.rubricaPDFrevision',['rubrica' => $rubrica])->output();;
        
        return response()->streamDownload(
            fn () => print($pdf),
            "resultado.pdf"
       );
    }

}
