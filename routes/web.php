<?php

use Illuminate\Support\Facades\Route;
use App\http\LiveWire\Modulos;
use App\http\LiveWire\Show_modulo;
use App\http\LiveWire\RubricaMakerDesdeCero;
use App\http\LiveWire\ShowRubricas;
use App\http\LiveWire\RubricaMakerEdit;
use App\Http\Controllers\ControladorRubricas;
use App\Http\Livewire\Plantilla;
use App\Models\Rubrica;

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
    Route::get('/plantillas', [ControladorRubricas::class,'plantillas'])->name('rubric.plantillas');
    Route::get('/makerindex/cero', RubricaMakerDesdeCero::class)->name('rubric.cero');
    Route::get('/misrubricas', ShowRubricas::class)->name('misrubricas');
    Route::get('/plantillas', Plantilla::class)->name('plantillas');
    Route::get('/makeredit/{id_rubrica}', RubricaMakerEdit::class)->name('rubric.edit');
    Route::view('/rubricview', 'export.rubricaPDF', ['rubrica' => Rubrica::find(12)]);
    Route::view('/rubricexcel', 'export.rubricaEXCEL', ['rubrica' => Rubrica::find(12)]);
});
