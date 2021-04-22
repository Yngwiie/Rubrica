<?php

namespace App\Http\Livewire;

use App\Imports\StudentsImport;
use Livewire\Component;
use App\Models\Estudiante;
use App\Models\estudiante_evaluacion;
use App\Models\Evaluacion;
use App\Models\Modulo_estudiante;
use App\Models\Modulo;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Estudiantes extends Component
{
    use WithFileUploads;

    public $id_modulo;
    public $nombre;
    public Modulo $modulo;
    public $apellido;
    public $searchTerm;
    public $email;
    public $id_estudiante;
    public $currentPage = 1;
    public $fileImport;


    public function mount($id_modulo){
        $this->id_modulo = $id_modulo;
        $this->modulo = Modulo::find($id_modulo);
        if($this->modulo->id_usuario != Auth::user()->id ){//Evitar que puedan acceder a modulos de otros usuarios
            $this->id_modulo = "";
            abort(401);
        }
    }
    public function render()
    {
        /* dd($this->modulo->estudiantes()); */
        /* $searchTerm = '%'.$this->searchTerm.'%';
        $estudiantes = $this->modulo->estudiantes()->where('nombre','LIKE',$searchTerm)
                                                   ->paginate(10); */
        
        $estudiantes = Modulo_estudiante::where('id_modulo','=',$this->id_modulo)
                                        ->whereHas('estudiante',function($q){
                                            $searchTerm = '%'.$this->searchTerm.'%';
                                            $q->where('nombre','LIKE',$searchTerm);
                                            $q->orwhere('email','LIKE',$searchTerm);
                                        })
                                        ->orderBy('id','DESC')->paginate(10);
        
        return view('livewire.estudiantes',['estudiantes' => $estudiantes]);
    }
    
    public function resetInputFields()
    {
        $this->id_estudiante = '';
        $this->nombre = '';
        $this->email = '';
        $this->apellido = '';
    }

    public function store()
    {
        
        $validateData = $this->validate([
            'nombre' => 'required|string|max:40',
            'apellido' => 'required',
            'email' => 'required|email'
        ]);

        $estudiante = Estudiante::create([
            'nombre' => $validateData['nombre'],
            'apellido' => $validateData['apellido'],
            'email' => $validateData['email'],
        ]);
        
        modulo_estudiante::create([
            'id_modulo' => $this->id_modulo,
            'id_estudiante' => $estudiante->id,
        ]);

        $evaluaciones_modulo = Evaluacion::where('id_modulo',$this->id_modulo)->get();

        foreach($evaluaciones_modulo as $evaluacion){
            estudiante_evaluacion::create([
                'id_estudiante' => $estudiante->id,
                'id_evaluacion' => $evaluacion->id,
            ]);
        }

        session()->flash('success','Estudiante agregado con éxito.');
        $this->resetInputFields();
        $this->emit('estudianteAgregado');
    }

    /**
     * Setear datos del estudiante que se editará
     */
    public function edit($id)
    {   
       $data =   Estudiante::findOrFail($id); 

       $this->id_estudiante = $id;
       $this->email = $data->email;
       $this->nombre= $data->nombre;
       $this->apellido= $data->apellido;
    }

    /**
     * Metodo para actualizar datos de un estudiante
     */
    public function update()
    {
        $validateData = $this->validate([
            'nombre' => 'required|string|max:40',
            'apellido' => 'required',
            'email' => 'required|email'
        ]);
        $data = Estudiante::find($this->id_estudiante);
        
        $data->update([
            'nombre' => $this->nombre,
            'apellido' =>$this->apellido,
            'email' => $this->email,
        ]);
        session()->flash('success','Estudiante actualizado con éxito.');
        $this->resetInputFields();
        $this->emit('estudianteUpdate');
    }

    /**
     * setear datos del estudiante que se eliminara
     */
    public function delete($id)
    {   
       $data = Estudiante::findOrFail($id); 

       $this->id_estudiante = $id;
    }
    /**
     * Eliminar estudiante con los datos seteados.
     */
    public function destroy()
    {
        Estudiante::destroy($this->id_estudiante);
        session()->flash('success','Estudiante eliminado con éxito.');
        $this->resetInputFields();
        $this->emit('estudianteEliminado');
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=',$url)[1];

        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }

    public function import()
    {
        $this->validate([
            'fileImport' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new StudentsImport($this->id_modulo), $this->fileImport);

        session()->flash('success','Estudiante importados con éxito.');
        $this->resetInputFields();
        $this->emit('estudiantesImportados');
    }
}
