<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dimension;
use App\Models\Aspecto;

class AspectoComponent extends Component
{
    public Aspecto $aspecto;
    public $nombre;
    protected $listeners = ['update'];

    public function mount(Aspecto $aspecto){
        $this->aspecto = $aspecto;
        $this->nombre = $aspecto->nombre;
    }

    public function render()
    {
        return view('livewire.aspecto-component');
    }
    

    public function update(){
        $aspecto = Aspecto::find($this->aspecto->id);
        $aspecto->nombre = $this->nombre;
        $aspecto->save();
        
    }

}
