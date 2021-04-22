<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evaluacion;
use App\Models\Modulo;
use App\Models\Estudiante;
use App\Models\estudiante_evaluacion;
use App\Models\modulo_estudiante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class Show_modulo extends Component
{
    public $nombre;
    public $fecha;
    public $searchTerm;
    public $id_modulo;
    public $evaluacion_id;
    public $currentPage = 1;

    public function resetInputFields()
    {
        $this->nombre= '';
        $this->fecha= '';
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $modulo = Modulo::find($this->id_modulo);
        $evaluaciones = Evaluacion::where('nombre','LIKE',$searchTerm)
                        ->where('id_modulo','=',$this->id_modulo)
                        ->orderBy('id','DESC')->paginate(6);
        return view('livewire.show_modulo',
                [
                    'evaluaciones' => $evaluaciones, 
                    'modulo' => $modulo,
                ]);
    }

    public function mount($id_modulo){
        $this->id_modulo = $id_modulo;
        $modulo = Modulo::find($id_modulo);
        if($modulo->id_usuario != Auth::user()->id ){//Evitar que puedan acceder a modulos de otros usuarios
            $this->id_modulo = "";
            abort(401);
        }
    }
    /**
     * Guardar evaluacion
     */
    public function store()
    {
        $validateData = $this->validate([
            'nombre' => 'required|string|max:40',
            'fecha' => 'required',
        ]);
        
        $evaluacion = Evaluacion::create([
            'id_modulo' => $this->id_modulo,
            'nombre' => $validateData['nombre'],
            'fecha' => $validateData['fecha'],
        ]);
        
        $modulo = Modulo::find($this->id_modulo);
        $estudiantes = $modulo->estudiantes;
        /* $estudiantes = Estudiante::where('id_modulo',$this->id_modulo)->get(); */

        foreach($estudiantes as $estudiante){
            estudiante_evaluacion::create([
                'id_evaluacion' => $evaluacion->id,
                'id_estudiante' => $estudiante->id,
            ]);
        }

        session()->flash('success','Evaluación creada con éxito.');
        $this->resetInputFields();
        $this->emit('evaluacionAgregada');
    }
    /**
     * setear datos de la evaluacion que se eliminara
     */
    public function delete($id)
    {   
       $data =   Evaluacion::findOrFail($id); 

       $this->evaluacion_id = $id;
       $this->nombre = $data->nombre;
    }
    /**
     * Eliminar evaluación con los datos seteados.
     */
    public function destroy()
    {
        Evaluacion::destroy($this->evaluacion_id);
        session()->flash('success','Evaluación eliminada con éxito.');
        $this->resetInputFields();
        $this->emit('evaluacionEliminada');
    }
    /**
     * Setear datos de la evaluación que se editará
     */
    public function edit($id)
    {   
       $data =   Evaluacion::findOrFail($id); 

       $this->evaluacion_id = $id;
       $this->nombre = $data->nombre;
       $this->fecha = $data->fecha;
    }
    /**
     * Metodo para actualizar datos de una evaluación
     */
    public function update()
    {
        $validateData = $this->validate([
            'nombre' => 'required|string|max:40',
            'fecha' => 'required',
        ]);
        $data = Evaluacion::find($this->evaluacion_id);
        
        $data->update([
            'fecha' =>$this->fecha,
            'nombre' => $this->nombre,
            'id_modulo' => $this->id_modulo,
        ]);
        session()->flash('success','Evaluación actualizada con éxito.');
        $this->resetInputFields();
        $this->emit('evaluacionEditada');
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=',$url)[1];

        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }
}
