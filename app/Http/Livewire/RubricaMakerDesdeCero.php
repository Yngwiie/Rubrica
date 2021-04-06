<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evaluacion;
use App\Models\Rubrica;
use App\Models\Dimension;
use App\Models\NivelDesempeno;
use Illuminate\Support\Facades\Auth;

class RubricaMakerDesdeCero extends Component
{
    public $titulo;
    public $descripcion;
    public $id_evaluacion;

    protected $rules = [
        'titulo' => 'required|string|max:200',
        'descripcion' => 'required',
        'id_evaluacion' => 'required', 
    ];

    protected $messages = [
        'titulo.required' => 'El título es obligatorio.',
        'id_evaluacion.required' => 'La evaluación es obligatoria.',
    ];

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
        
        $validateData = $this->validate();
       
        $rubrica = Rubrica::create([
            'id_evaluacion' => $this->id_evaluacion,
            'titulo' => $validateData['titulo'],
            'descripcion' => $validateData['descripcion'],
            'id_usuario' => Auth::user()->id,
        ]); 
        $dimension = Dimension::create([
            'nombre' => 'Dimension 1',
            'id_rubrica' => $rubrica->id,
            'porcentaje' => 1,
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
