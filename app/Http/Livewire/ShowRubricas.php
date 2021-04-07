<?php

namespace App\Http\Livewire;

use App\Exports\RubricExport;
use Livewire\Component;
use App\Models\Rubrica;
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
    public $searchTerm;

    public function render()
    {
        $user = Auth::user();
        $searchTerm = '%'.$this->searchTerm.'%';
        $rubricas = Rubrica::where('titulo','LIKE',$searchTerm)
                            ->where('id_usuario',$user->id)
                            ->where('plantilla',0)->orderBy('id', 'DESC')->paginate(6);
        return view('livewire.show-rubricas', ['rubricas' => $rubricas]);
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

    }
    
    public function setIdRubrica($rubrica_id)
    {
        $this->rubrica_id = $rubrica_id;
    }

    public function exportPDF()
    {
        $rubrica = Rubrica::find($this->rubrica_id);
        $pdf = PDF::setPaper('A3', 'landscape')->loadView('export.rubricaPDF',['rubrica' => $rubrica])->output();;
        
        
        return response()->streamDownload(
            fn () => print($pdf),
            "rubrica.pdf"
       );
        /* return (new RubricExport($this->rubrica_id))->download('rubrica.pdf', \Maatwebsite\Excel\Excel::DOMPDF); */
    }
}
