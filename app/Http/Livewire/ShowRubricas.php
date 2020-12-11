<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Rubrica;
use Illuminate\Pagination\Paginator;

class ShowRubricas extends Component
{
    public $currentPage = 1;
    public $rubrica_id ;


    public function render()
    {
        $rubricas = Rubrica::paginate(6);
        return view('livewire.show-rubricas',['rubricas' => $rubricas]);
    }

    public function resetInputFields()
    {
        $this->rubrica_id= '';
    }

     /**
     * setear datos de la Rubrica que se eliminara
     */
    public function delete($id)
    {   
       $data =   Rubrica::findOrFail($id); 

       $this->rubrica_id = $id;
    }
    /**
     * Eliminar rubrica con los datos seteados.
     */
    public function destroy()
    {
        Rubrica::destroy($this->rubrica_id);
        session()->flash('success','Rúbrica eliminada con éxito.');
        $this->resetInputFields();
        $this->emit('rubricaEliminada');
    }
    public function setPage($url)
    {
        $this->currentPage = explode('page=',$url)[1];

        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }
}
