<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Modulo;
/* use Livewire\WithPagination; */
use Illuminate\Pagination\Paginator;

class Modulos extends Component
{

    public $nombre;
    public $data_id;
    public $searchTerm;
    public $currentPage = 1;

    public function resetInputFields()
    {
        $this->nombre= '';
    }

    public function render()
    {   
        $searchTerm = '%'.$this->searchTerm.'%';
        $modulos = Modulo::where('nombre','LIKE',$searchTerm)
                        ->where('id_usuario','=',auth()->user()->id)
                        ->orderBy('id','DESC')->paginate(5);
        return view('livewire.modulos',['modulos' => $modulos]);
    }
    /**
     * Método para registrar un módulo.
     */
    public function store()
    {
        $validateData = $this->validate([
            'nombre' => 'required|string|max:100',
        ]);

        Modulo::create([
            'id_usuario' => auth()->user()->id,
            'nombre' => $validateData['nombre'],
        ]);
        session()->flash('success','Módulo creado con éxito.');
        $this->resetInputFields();
        $this->emit('moduloAgregado');
    }
    /**
     * Metodo para setear datos que se editarán.
     */
    public function edit($id)
    {   
       $data =   Modulo::findOrFail($id); 

       $this->data_id = $id;
       $this->nombre = $data->nombre;
    }
    /**
     * Método para actualizar datos de un módulo.
     */
    public function update()
    {
        $validateData = $this->validate([
            'nombre' => 'required|string|max:100',
        ]);
        $data = Modulo::find($this->data_id);
        
        $data->update([
            'nombre' => $this->nombre,
            'id_usuario' => auth()->user()->id,
        ]);
        session()->flash('success','Módulo actualizado con éxito.');
        $this->resetInputFields();
        $this->emit('moduloAgregado');
    }
    /**
     * Método para setear los datos de un módulo que se eliminará.
     */
    public function delete($id)
    {   
       $data =   Modulo::findOrFail($id); 

       $this->data_id = $id;
       $this->nombre = $data->nombre;
    }
    /**
     * Método para eliminar un módulo.
     */
    public function destroy()
    {
        Modulo::destroy($this->data_id);
        session()->flash('success','Módulo eliminado con éxito.');
        $this->resetInputFields();
        $this->emit('moduloEliminado');
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=',$url)[1];

        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }
}
