<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Criterio;
use App\Models\Aspecto;
use phpDocumentor\Reflection\PseudoTypes\False_;

class CriterioComponent extends Component
{

    public Criterio $criterio;
    public $descripcion;
    public $descripcion_avanzada = [];
    public $id_criterio;
    protected $listeners = ['setIdSubcriterio'];
    public $criterio_avanzado;
    public $deshabilitado;
    public $id_subcriterio;

    protected $rules = [
        'criterio.descripcion' => 'required|string',
    ];

    public function mount(Criterio $criterio){
        $this->id_subcriterio = -1;
        $this->criterio = $criterio;
        $this->descripcion = $criterio->descripcion;
        $this->id_criterio = $criterio->id;
        $this->deshabilitado = $criterio->deshabilitado;
        $this->descripcion_avanzada = json_decode($criterio->descripcion_avanzada);
        if($criterio->descripcion==null){
            $this->criterio_avanzado = TRUE;
        }else{
            $this->criterio_avanzado = FALSE;
        }
    
    }

    public function render()
    {
        return view('livewire.criterio-component');
    }

    /**
     * Remove sub criteria
     */
    public function removeSubCriteria($index)
    {
        unset($this->descripcion_avanzada[$index]);
        $this->descripcion_avanzada = array_values($this->descripcion_avanzada);
        $this->updated();

    }
    /**
     * Set id subcriterio.
     */
    public function setIdSubcriterio($id)
    {
        dd("hola");
        $this->id_subcriterio = $id;
        
    
    }
    /**
     * Add sub criteria to array.
     */
    public function addSubcriteria()
    {
        array_push($this->descripcion_avanzada, ['text'=>"nuevo"]);
        $this->updated();
    }
    public function updated()
    {
        if(!$this->criterio_avanzado){
            $this->validate();
            $this->criterio->deshabilitado = $this->deshabilitado;
            $this->criterio->save();
        }else{
            
            $magnitud_inicial = 0;
            $magnitud_inicial_mayor = 100;
            $desc_antigua = $this->criterio->descripcion_avanzada;
            $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
            $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);

            $this->criterio->deshabilitado = $this->deshabilitado;
            $this->criterio->save();
            $criterios = Criterio::where('id_aspecto',$this->criterio->id_aspecto)->get();

            foreach($this->descripcion_avanzada as $descripcion){
                if($descripcion->id == $this->id_subcriterio){

                }
            }
            foreach($criterios as $criterio){
                $desc_avanzada = json_decode($criterio->descripcion_avanzada);

                foreach($desc_avanzada as $descripcion){
                    if($descripcion->id == $this->id_subcriterio){
                        if($descripcion->magnitud == "porcentaje1"){
                            if($magnitud_inicial <= $descripcion->porcentaje_magnitud){
                                $magnitud_inicial = $descripcion->porcentaje_magnitud;
                            }else{//On error case I do a rollback.
                                $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                $this->addError('subcriterio', 'Magnitudes de los subcriterios ID#'.$this->id_subcriterio.' no estan en orden.');
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }
                        }
                        if($descripcion->magnitud == "escala"){
                            if($magnitud_inicial <= $descripcion->porcentaje_magnitud){
                                $magnitud_inicial = $descripcion->porcentaje_magnitud;
                            }else{//On error case I do a rollback.
                                $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                $this->addError('subcriterio', 'Magnitudes de los subcriterios ID#'.$this->id_subcriterio.' no estan en orden.');
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }
                        }
                        if($descripcion->magnitud == "porcentaje2"){
                            if($magnitud_inicial_mayor >= $descripcion->porcentaje_magnitud){
                                $magnitud_inicial_mayor = $descripcion->porcentaje_magnitud;
                            }else{//On error case I do a rollback.
                                $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                $this->addError('subcriterio', 'Magnitudes de los subcriterios ID#'.$this->id_subcriterio.' no estan en orden.');
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }
                        }
                        break;
                    }
                }
            
                
            }
            $this->resetErrorBag();
        }
        
    }
}
