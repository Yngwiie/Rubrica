<?php

use Illuminate\Support\Facades\Route;
use App\http\LiveWire\Modulos;
use App\http\LiveWire\Show_modulo;
use App\http\LiveWire\RubricaMakerDesdeCero;
use App\http\LiveWire\ShowRubricas;
use App\http\LiveWire\RubricaMakerEdit;
use App\Http\Controllers\ControladorRubricas;
use App\Http\Livewire\EstadisticasRubrica;
use App\Http\Livewire\EstudianteRubricasAplicadas;
use App\Http\Livewire\EstudiantesAplicacion;
use App\Http\Livewire\Plantilla;
use App\Http\Livewire\RevisionRubrica;
use App\Http\Livewire\RubricaAplicando;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', Modulos::class)->name('dashboard');
/* Route::middleware(['auth:sanctum', 'verified'])->get('/evaluaciones', Evaluaciones::class)->name('evaluaciones'); */
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/show_modulo/{id_modulo}', Show_modulo::class)->name('show.modulo');
    Route::get('/rubrica/{id_rubrica}', EstudiantesAplicacion::class)->name('apply.rubrica');
    Route::get('/misrubricasaplicadas',EstudianteRubricasAplicadas::class)->name('rubricas.aplicadas');
    Route::get('/revision/{id_rubrica}',RevisionRubrica::class)->name('revision');
    Route::get('/rubricaAplicando/{id_rubrica}', RubricaAplicando::class)->name('applying.rubrica');
    Route::get('/makerindex', [ControladorRubricas::class,'index'])->name('rubric.index');
    Route::get('/plantillas', [ControladorRubricas::class,'plantillas'])->name('rubric.plantillas');
    Route::get('/makerindex/cero', RubricaMakerDesdeCero::class)->name('rubric.cero');
    Route::get('/misrubricas', ShowRubricas::class)->name('misrubricas');
    Route::get('/plantillas', Plantilla::class)->name('plantillas');
    Route::get('/makeredit/{id_rubrica}', RubricaMakerEdit::class)->name('rubric.edit');
    Route::get('/estadisticas/{id_rubrica}', EstadisticasRubrica::class)->name('estadisticas');
    /* Route::view('/rubricview', 'export.rubricaPDF', ['rubrica' => Rubrica::find(12)]);
    Route::view('/rubricexcel', 'export.rubricaEXCEL', ['rubrica' => Rubrica::find(12)]); */
});
