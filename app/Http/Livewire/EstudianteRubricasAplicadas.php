<?php

namespace App\Http\Livewire;

use App\Models\Estudiante;
use App\Models\RubricaAplicada;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EstudianteRubricasAplicadas extends Component
{
    public $currentPage = 1;
    public $searchTerm;

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $estudiante = Estudiante::where('email',Auth::user()->email)->first();
        $rubricas = RubricaAplicada::where('id_estudiante',$estudiante->id)->where('titulo','LIKE',$searchTerm)
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

}
