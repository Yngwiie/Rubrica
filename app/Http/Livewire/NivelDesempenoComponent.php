<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\NivelDesempeno;
use App\Models\Rubrica;
use App\Models\Dimension;

class NivelDesempenoComponent extends Component
{

    public NivelDesempeno $nivel;
    public Rubrica $rubrica;
    public $nombre;
    public $id_nivel;
    public $puntaje_minimo;
    public $puntaje_maximo;
    public $puntaje;

    protected $listeners = ['nivel_updated'];

    public function mount(NivelDesempeno $nivel,Rubrica $rubrica){
        $this->nivel = $nivel;
        $this->puntaje = $nivel->puntaje;
        $this->puntaje_minimo = $nivel->puntaje_minimo;
        $this->puntaje_maximo = $nivel->puntaje_maximo;
        $this->nombre = $nivel->nombre;
        $this->id_nivel = $nivel->id;
        $this->rubrica = $rubrica;
    }
    protected $rules = [
        'puntaje' => 'required|numeric|min:0|max:1000'
    ];
    public function render()
    {
        return view('livewire.nivel-desempeno-component');
    }

    public function updated()
    {
        
        if($this->rubrica->tipo_puntaje == "unico"){
            $this->validate();
            $old_puntaje = $this->nivel->puntaje;
            $this->nivel->puntaje = $this->puntaje;
            $this->nivel->nombre = $this->nombre;
            $this->nivel->save();
            $nivel_anterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','<',$this->nivel->id)
                                            ->orderBy('id','desc')->first();
            $nivel_posterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','>',$this->nivel->id)
                                            ->orderBy('id','asc')->first();
            if($nivel_anterior==null){
                if(($nivel_posterior->puntaje < $this->nivel->puntaje)){
                    $this->addError('orden_rangos', 'Los puntajes no estan en orden.');
                    $this->nivel->puntaje = $old_puntaje;
                    $this->nivel->save();
                    return;
                }
            }elseif($nivel_posterior==null){
                if(($nivel_anterior->puntaje > $this->nivel->puntaje)){
                    $this->addError('orden_rangos', 'Los puntajes no estan en orden.');
                    $this->nivel->puntaje = $old_puntaje;
                    $this->nivel->save();
                    return;
                }
            }else{
                if(($nivel_anterior->puntaje > $this->nivel->puntaje) or ($nivel_posterior->puntaje < $this->nivel->puntaje)){
                    $this->addError('orden_rangos', 'Los puntajes no estan en orden.');
                    $this->nivel->puntaje = $old_puntaje;
                    $this->nivel->save();
                    return;
                }
            }
        }else{
            $this->validate([
                'puntaje_minimo' =>'required|lte:puntaje_maximo|max:1000|min:0',
                'puntaje_maximo' =>'required|max:1000|min:0',
            ]);
            $old_puntaje_minimo = $this->nivel->puntaje_minimo;
            $old_puntaje_maximo = $this->nivel->puntaje_maximo;
            $this->nivel->puntaje_minimo = $this->puntaje_minimo;
            $this->nivel->puntaje_maximo = $this->puntaje_maximo;
            $this->nivel->nombre = $this->nombre;
            $this->nivel->save();
            
            $nivel_anterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','<',$this->nivel->id)
                                            ->orderBy('id','desc')->first();
            $nivel_posterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','>',$this->nivel->id)
                                            ->orderBy('id','asc')->first();
            if($nivel_anterior==null){
                if(($nivel_posterior->puntaje_minimo < $this->nivel->puntaje_maximo)){
                    $this->addError('orden_rangos', 'Los rangos no estan en orden.');
                    $this->nivel->puntaje_minimo = $old_puntaje_minimo;
                    $this->nivel->puntaje_maximo = $old_puntaje_maximo;
                    $this->nivel->save();
                    return;
                }
            }elseif($nivel_posterior==null){
                if(($nivel_anterior->puntaje_maximo > $this->nivel->puntaje_minimo)){
                    $this->addError('orden_rangos', 'Los rangos no estan en orden.');
                    $this->nivel->puntaje_minimo = $old_puntaje_minimo;
                    $this->nivel->puntaje_maximo = $old_puntaje_maximo;
                    $this->nivel->save();
                    return;
                }
            }else{
                if(($nivel_anterior->puntaje_maximo > $this->nivel->puntaje_minimo) or ($nivel_posterior->puntaje_minimo < $this->nivel->puntaje_maximo)){
                    $this->addError('orden_rangos', 'Los rangos no estan en orden.');
                    $this->nivel->puntaje_minimo = $old_puntaje_minimo;
                    $this->nivel->puntaje_maximo = $old_puntaje_maximo;
                    $this->nivel->save();
                    return;
                }
            }
        }
        $this->emit('newversion');
        $this->emit('nivel_updated');
        $this->resetErrorBag();
        
    }
    public function nivel_updated()
    {
        if($this->rubrica->tipo_puntaje == "unico"){
            $this->validate();
            $old_puntaje = $this->nivel->puntaje;
            $this->nivel->puntaje = $this->puntaje;
            $this->nivel->nombre = $this->nombre;
            $this->nivel->save();
            $nivel_anterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','<',$this->nivel->id)
                                            ->orderBy('id','desc')->first();
            $nivel_posterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','>',$this->nivel->id)
                                            ->orderBy('id','asc')->first();
            if($nivel_anterior==null){
                if(($nivel_posterior->puntaje < $this->nivel->puntaje)){
                    $this->addError('orden_rangos', 'Los puntajes no estan en orden.');
                    return;
                }
            }elseif($nivel_posterior==null){
                if(($nivel_anterior->puntaje > $this->nivel->puntaje)){
                    $this->addError('orden_rangos', 'Los puntajes no estan en orden.');
                    return;
                }
            }else{
                if(($nivel_anterior->puntaje > $this->nivel->puntaje) or ($nivel_posterior->puntaje < $this->nivel->puntaje)){
                    $this->addError('orden_rangos', 'Los puntajes no estan en orden.');
                    $this->nivel->puntaje = $old_puntaje;
                    $this->nivel->save();
                    return;
                }
            }

        }else{
            $this->validate([
                'puntaje_minimo' =>'required|lte:puntaje_maximo|max:1000|min:0',
                'puntaje_maximo' =>'required|max:1000|min:0',
            ]);
            $old_puntaje_minimo = $this->nivel->puntaje_minimo;
            $old_puntaje_maximo = $this->nivel->puntaje_maximo;
            $this->nivel->puntaje_minimo = $this->puntaje_minimo;
            $this->nivel->puntaje_maximo = $this->puntaje_maximo;
            $this->nivel->nombre = $this->nombre;
            $this->nivel->save();
            
            $nivel_anterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','<',$this->nivel->id)
                                            ->orderBy('id','desc')->first();
            $nivel_posterior = NivelDesempeno::where('id_dimension',$this->nivel->id_dimension)
                                            ->where('id','>',$this->nivel->id)
                                            ->orderBy('id','asc')->first();
            if($nivel_anterior==null){
                if(($nivel_posterior->puntaje_minimo < $this->nivel->puntaje_maximo)){
                    $this->addError('orden_rangos', 'Los rangos no estan en orden.');
                    return;
                }
            }elseif($nivel_posterior==null){
                if(($nivel_anterior->puntaje_maximo > $this->nivel->puntaje_minimo)){
                    $this->addError('orden_rangos', 'Los rangos no estan en orden.');
                    return;
                }
            }else{
                if(($nivel_anterior->puntaje_maximo > $this->nivel->puntaje_minimo) or ($nivel_posterior->puntaje_minimo < $this->nivel->puntaje_maximo)){
                    $this->addError('orden_rangos', 'Los rangos no estan en orden.');
                    $this->nivel->puntaje_minimo = $old_puntaje_minimo;
                    $this->nivel->puntaje_maximo = $old_puntaje_maximo;
                    $this->nivel->save();
                    return;
                }
            }
        }
        $this->resetErrorBag();
    }
}
