<?php

use Illuminate\Support\Facades\Route;
use App\http\LiveWire\Modulos;
use App\http\LiveWire\Show_modulo;
use App\http\LiveWire\RubricaMaker;
use App\http\LiveWire\ShowRubricas;
use App\Http\Controllers\ControladorRubricas;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', Modulos::class)->name('dashboard');
/* Route::middleware(['auth:sanctum', 'verified'])->get('/evaluaciones', Evaluaciones::class)->name('evaluaciones'); */
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/show_modulo/{id_modulo}', Show_modulo::class)->name('show.modulo');
    Route::get('/makerindex', [ControladorRubricas::class,'index'])->name('rubric.index');
    Route::get('/makerindex/cero', RubricaMaker::class)->name('rubric.cero');
    Route::get('/misrubricas', ShowRubricas::class)->name('misrubricas');
});
