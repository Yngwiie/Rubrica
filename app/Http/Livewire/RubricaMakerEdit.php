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
    public function render()
    {
       /*  $rubrica = Rubrica::find($this->id_rubrica); */
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
    public function storeAspect($id_dimension)
    {
        $dimension = Dimension::findOrFail($id_dimension);
        $aspecto = Aspecto::create([
            'nombre' => 'aspecto',
            'porcentaje' => '100',
            'id_dimension' => $dimension->id,
        ]);
        $num_niveles = NivelDesempeno::where('id_dimension','=',$id_dimension)->count();
        for ($i=0; $i < $num_niveles; $i++) { 
            Criterio::create([
                'descripcion' => 'Criterio',
                'id_aspecto' => $aspecto->id,
            ]);
        }
        
        return redirect()->route('rubric.edit', $this->id_rubrica);
    }
}
