<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubrica;
use App\Models\Evaluacion;

class ControladorRubricas extends Controller
{
    public function index()
    {
        return view('rubrica.index');
    }

    public function plantillas()
    {
        $plantillas = Rubrica::where('plantilla',TRUE)->get();
        $evaluaciones = Evaluacion::doesntHave('rubrica')->get();
        return view('rubrica.plantillas')->with('plantillas',$plantillas)->with('evaluaciones',$evaluaciones);
    }
}
