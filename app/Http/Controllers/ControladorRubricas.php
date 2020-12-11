<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorRubricas extends Controller
{
    public function index(){
        return view('rubrica.index');
    }
}
