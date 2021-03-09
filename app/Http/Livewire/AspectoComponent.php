<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dimension;
use App\Models\Aspecto;

class AspectoComponent extends Component
{
    public Aspecto $aspecto;
    public $nombre;
    public $porcentaje;
    public $id_aspecto;
    protected $listeners = ['refrescar'=>'$refresh'];

    protected $rules = [
        'aspecto.nombre' => 'required|string',
        'aspecto.porcentaje' => 'required|integer|min:0|max:100'
    ];

    public function mount(Aspecto $aspecto){
        $this->aspecto = $aspecto;
        $this->nombre = $aspecto->nombre;
        $this->id_aspecto = $aspecto->id;
        $this->porcentaje = $aspecto->porcentaje;
    }

    public function render()
    {
        return view('livewire.aspecto-component');
    }
    
   /*  public function update(){
        $this->validate();
        $this->aspecto->save();
        
    } */
    public function updated()
    {
        $this->validate();
        $this->aspecto->save();
    }
}
