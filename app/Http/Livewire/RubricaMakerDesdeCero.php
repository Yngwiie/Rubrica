<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evaluacion;
use App\Models\Rubrica;
use App\Models\Dimension;
use App\Models\NivelDesempeno;

class RubricaMakerDesdeCero extends Component
{
    public $titulo;
    public $descripcion;
    public $id_evaluacion;

    public function render()
    {
        
        $evaluaciones = Evaluacion::doesntHave('rubrica')->get();
        return view('livewire.rubrica-makerDesdeCero',['evaluaciones' => $evaluaciones]);
    }

    public function resetInputFields()
    {
        $this->nombre= '';
        $this->descripcion= '';
        $this->id_evaluacion= '';
    }

    public function store()
    {
        
        $validateData = $this->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required',
            'id_evaluacion' => 'required',
        ]);
       
        $rubrica = Rubrica::create([
            'id_evaluacion' => $this->id_evaluacion,
            'titulo' => $validateData['titulo'],
            'descripcion' => $validateData['descripcion'],
        ]);
        $dimension = Dimension::create([
            'nombre' => 'Dimension 1',
            'id_rubrica' => $rubrica->id,
            'porcentaje' => 0,
        ]);
        for($i = 1; $i <= 3; $i++){
            NivelDesempeno::create([
                'nombre' => 'nivel '.$i,
                'ordenJerarquico' => $i,
                'id_dimension' => $dimension->id,
            ]);
        }
        
        session()->flash('success','Rúbrica asociada a su evaluación.');
        $this->resetInputFields();
        return redirect()->route('rubric.edit', $rubrica->id);
    }
}
