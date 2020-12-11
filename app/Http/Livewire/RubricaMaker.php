<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Evaluacion;
use App\Models\Rubrica;

class RubricaMaker extends Component
{
    public $titulo;
    public $descripcion;
    public $id_evaluacion;

    public function render()
    {
        $evaluaciones = Evaluacion::doesntHave('rubrica')->get();
        return view('livewire.rubrica-maker',['evaluaciones' => $evaluaciones]);
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
       
        Rubrica::create([
            'id_evaluacion' => $this->id_evaluacion,
            'titulo' => $validateData['titulo'],
            'descripcion' => $validateData['descripcion'],
        ]);
        session()->flash('success','Rúbrica asociada a su evaluación.');
        $this->resetInputFields();
    }
}
