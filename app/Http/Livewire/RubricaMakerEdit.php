<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Rubrica;
use App\Models\Dimension;
use App\Models\Aspecto;
use App\Models\NivelDesempeno;
use App\Models\Criterio;

class RubricaMakerEdit extends Component
{
    public $id_rubrica;
    public Rubrica $rubrica;
    public $id_dim;
    public $id_aspecto;

    protected $rules = [
        'rubrica.descripcion' => 'required|string',
        'rubrica.titulo' => 'required|string',
    ];

    protected $listeners = ['update','deleteAspecto','storeAspecto','storeDimension','deleteDimension'];

    public function render()
    {
        
        return view('livewire.rubrica-maker-edit');
    }

    public function mount($id_rubrica)
    {
        $this->rubrica = Rubrica::find($id_rubrica);
        $this->id_rubrica = $id_rubrica;
    }

    public function updateAll()
    {
        $this->emit('update');
    }
    public function update()
    {
        $this->validate();
        $this->rubrica->save();
        session()->flash('success','Salvado.'); 
        return redirect()->route('rubric.edit', $this->id_rubrica); 
        
    }
    public function storeAspecto($id_dimension)
    {
        $this->validate();
        $this->rubrica->save();
        $dimension = Dimension::findOrFail($id_dimension);
        $aspecto = Aspecto::create([
            'nombre' => 'aspecto',
            'porcentaje' => '100',
            'id_dimension' => $dimension->id,
            'porcentaje' => 0,
        ]);
        $num_niveles = NivelDesempeno::where('id_dimension','=',$id_dimension)->count();
        for ($i=0; $i < $num_niveles; $i++) { 
            Criterio::create([
                'descripcion' => 'Criterio',
                'id_aspecto' => $aspecto->id,
            ]);
        }
        
        session()->flash('success','Aspecto agregado con éxito.'); 
        return redirect()->route('rubric.edit', $this->id_rubrica); 
    }
    /**
     * Método para eliminar un aspecto.
     */
    public function deleteAspecto($id_aspecto)
    {
        $this->validate();
        $this->rubrica->save();
        $aspecto = Aspecto::find($id_aspecto);
        $aspecto->delete();
        session()->flash('success','Aspecto eliminado con éxito.');
        return redirect()->route('rubric.edit', $this->id_rubrica);
        
    }
    /**
     * 
     */
    public function storeNivel($id_dimension){
      
    }
    /**
     * Metodo para crear una nueva dimensión
     */
    public function storeDimension(){
        $this->rubrica->save();
        $dimension = Dimension::create([
            'nombre' => 'Nueva Dimensión',
            'porcentaje' => 0,
            'id_rubrica' => $this->rubrica->id,
        ]);
        for($i = 1; $i <= 3; $i++){
            NivelDesempeno::create([
                'nombre' => 'nivel '.$i,
                'ordenJerarquico' => $i,
                'id_dimension' => $dimension->id,
            ]);
        }
        session()->flash('success','Dimension agregada.');
        return redirect()->route('rubric.edit', $this->id_rubrica);
    }

    public function setDimension($id_dimension)
    {      
        $this->id_dim = $id_dimension;
    }
    public function deleteDimension($id_dimension){
        $this->validate();
        $this->rubrica->save();
        $dimension = Dimension::find($id_dimension);
        $dimension->delete();
        
        session()->flash('success','Dimensión eliminada con éxito.');
        return redirect()->route('rubric.edit', $this->id_rubrica);
    }
}
