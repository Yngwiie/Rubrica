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
    protected function getListeners()
    {
        return ['updated_2'.$this->criterio->id_aspecto => 'updated_2',
                'removeSubCriteria'.$this->criterio->id_aspecto => 'removeSubCriteria',
                'updatePorcentajeSubcriterio'.$this->criterio->id_aspecto => 'updatePorcentajeSubcriterio',
                'setIdSubcriterio'.$this->criterio->id => 'setIdSubcriterio'];
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
        $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
        $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
        
        $this->criterio->deshabilitado = $this->deshabilitado;
        $this->criterio->save();
        /* $this->updated(); */
        
    }
    /**
     * Set id subcriterio.
     */
    public function setIdSubcriterio($id)
    {
        
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
    public function updatedIdSubcriterio(){
        $this->resetErrorBag();
        if($this->criterio_avanzado){
            $desc_antigua = $this->criterio->descripcion_avanzada;
            
            $criterios = Criterio::where('id_aspecto',$this->criterio->id_aspecto)
                                 ->where('deshabilitado',0)
                                 ->get();
            $desc_avanzada_primera = json_decode($this->criterio->descripcion_avanzada);
            foreach($desc_avanzada_primera as $descripcion){
                $this->id_subcriterio = $descripcion->id;
                $magnitud_inicial = 0;
                $magnitud_inicial_mayor = 100;
                foreach($criterios as $key => $criterio){
                    $desc_avanzada = json_decode($criterio->descripcion_avanzada);
    
                    foreach($desc_avanzada as $descripcion){
                        
                        if($descripcion->id == $this->id_subcriterio){
                            if($descripcion->magnitud == "porcentaje1"){
                                if($descripcion->porcentaje_magnitud == ""){
                                    $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                    $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();

                                }
                                if($magnitud_inicial <= $descripcion->porcentaje_magnitud){
                                    $magnitud_inicial = $descripcion->porcentaje_magnitud;
                                }else{//On error case I do a rollback.
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                }
                            }elseif($descripcion->magnitud == "escala"){
                                if($descripcion->escala_magnitud == ""){
                                    $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                    $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();

                                }
                                if($magnitud_inicial <= $descripcion->escala_magnitud){
                                    $magnitud_inicial = $descripcion->escala_magnitud;
                                }else{//On error case I do a rollback.
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                }
                            }elseif($descripcion->magnitud == "porcentaje2"){
                                
                                if($descripcion->porcentaje_magnitud == ""){
                                    $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                    $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();

                                }
                                if($magnitud_inicial_mayor >= $descripcion->porcentaje_magnitud){
                                    $magnitud_inicial_mayor = $descripcion->porcentaje_magnitud;
                                }else{//On error case I do a rollback.
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                }
                            }elseif($descripcion->magnitud == "rango_asc"){
                                if($descripcion->valor_min == "" or $descripcion->valor_max == ""){
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();

                                }
                                if($descripcion->valor_min > $descripcion->valor_max){
                                    $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                    $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' no estan en orden. 
                                                                    El valor mín. no puede ser mayor a '.$descripcion->valor_max);
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();

                                }
    
                                if($key == 0){
                                    $magnitud_inicial=$descripcion->valor_max;
                                }elseif($magnitud_inicial <= $descripcion->valor_min){
                                    $magnitud_inicial = $descripcion->valor_max;
                                }else{
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                }
                             }elseif($descripcion->magnitud == "frecuencia"){//para validar los subcriterios de tipo frecuencia.
                                $criterio_anterior = Criterio::where('id_aspecto',$this->criterio->id_aspecto)
                                                ->where('id','<',$criterio->id)
                                                ->where('deshabilitado',0)
                                                ->orderBy('id','desc')->first();
                                $criterio_posterior = Criterio::where('id_aspecto',$this->criterio->id_aspecto)
                                                ->where('id','>',$criterio->id)
                                                ->where('deshabilitado',0)
                                                ->orderBy('id','asc')->first();
                                
                                if($criterio_anterior==null){
                                    $desc_avanzada_posterior = json_decode($criterio_posterior->descripcion_avanzada);
                                    if($descripcion->frecuencia == "Nunca"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Casi nunca"){
                                        
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Ocasionalmente"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "A veces"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Generalmente"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Usualmente"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Siempre"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Siempre"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }
    
                                }elseif($criterio_posterior==null){//si es el ultimo criterio. 
                                    $desc_avanzada_anterior = json_decode($criterio_anterior->descripcion_avanzada);
                                    if($descripcion->frecuencia == "Siempre"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Usualmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Generalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "A veces"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Ocasionalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Casi nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Nunca" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }
                                }else{//criterios que esten en el medio.
                                    $desc_avanzada_anterior = json_decode($criterio_anterior->descripcion_avanzada);
                                    $desc_avanzada_posterior = json_decode($criterio_posterior->descripcion_avanzada);
                                    
                                    if($descripcion->frecuencia == "Siempre"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Generalmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Siempre"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Usualmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente" 
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Generalmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Generalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Generalmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "A veces"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Ocasionalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"){
                                                
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Casi nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" 
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"){
    
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }elseif($descripcion->frecuencia == "Nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca"){
                                                
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
        
                                        }
                                    }
                                }
                            }
    
                            break;
                        }
                    }
                
                }
            }
            if($this->getErrorBag()->isNotEmpty()){
                return;
            }
            $this->emit('updated_2'.$this->criterio->id_aspecto);
            
        }  
    }
    public function updated()
    {
        if(!$this->criterio_avanzado){
            $this->validate();
            $this->criterio->deshabilitado = $this->deshabilitado;
            $this->criterio->save();
        }else{
            $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
            $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
            $this->criterio->deshabilitado = $this->deshabilitado;
        }
        /* else{
            $magnitud_inicial = 0;
            $magnitud_inicial_mayor = 100;
            $desc_antigua = $this->criterio->descripcion_avanzada;
            $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
            $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
            $this->criterio->deshabilitado = $this->deshabilitado;
            $this->criterio->save();
            $criterios = Criterio::where('id_aspecto',$this->criterio->id_aspecto)
                                 ->where('deshabilitado',0)
                                 ->get();;
            foreach($criterios as $key => $criterio){
                $desc_avanzada = json_decode($criterio->descripcion_avanzada);

                foreach($desc_avanzada as $descripcion){
                    if($descripcion->id == $this->id_subcriterio){
                        if($descripcion->magnitud == "porcentaje1"){
                            if($descripcion->porcentaje_magnitud == ""){
                                $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }
                            if($magnitud_inicial <= $descripcion->porcentaje_magnitud){
                                $magnitud_inicial = $descripcion->porcentaje_magnitud;
                            }else{//On error case I do a rollback.
                                $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                            }
                        }elseif($descripcion->magnitud == "escala"){
                            if($descripcion->escala_magnitud == ""){
                                $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }
                            if($magnitud_inicial <= $descripcion->escala_magnitud){
                                $magnitud_inicial = $descripcion->escala_magnitud;
                            }else{//On error case I do a rollback.
                                $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                            }
                        }elseif($descripcion->magnitud == "porcentaje2"){
                            if($descripcion->porcentaje_magnitud == ""){
                                $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }
                            if($magnitud_inicial_mayor >= $descripcion->porcentaje_magnitud){
                                $magnitud_inicial_mayor = $descripcion->porcentaje_magnitud;
                            }else{//On error case I do a rollback.
                                $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                            }
                        }elseif($descripcion->magnitud == "rango_asc"){
                            if($descripcion->valor_min == "" or $descripcion->valor_max == ""){
                                $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }
                            if($descripcion->valor_min > $descripcion->valor_max){
                                $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' no estan en orden. 
                                                                El valor mín. no puede ser mayor a '.$descripcion->valor_max);
                                $this->criterio->descripcion_avanzada = $desc_antigua;
                                $this->criterio->save();
                                return;
                            }

                            if($key == 0){
                                $magnitud_inicial=$descripcion->valor_max;
                            }elseif($magnitud_inicial <= $descripcion->valor_min){
                                $magnitud_inicial = $descripcion->valor_max;
                            }else{
                                $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                            }
                         }
                        break;
                    }
                }
            
            }
            $this->emit('updated_2'.$this->criterio->id_aspecto);
            $this->resetErrorBag();
        }      */ 
        
        
    }
    public function updated_2()
    {
        
        if(!$this->criterio_avanzado){
            $this->validate();
            $this->criterio->deshabilitado = $this->deshabilitado;
            $this->criterio->save();
        }else{
            $this->resetErrorBag();
            $desc_antigua = $this->criterio->descripcion_avanzada;
            $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
            $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
            $this->criterio->deshabilitado = $this->deshabilitado;
            $this->criterio->save();
            $criterios = Criterio::where('id_aspecto',$this->criterio->id_aspecto)
                                 ->where('deshabilitado',0)
                                 ->get();
            $desc_avanzada_primera = json_decode($this->criterio->descripcion_avanzada);
            foreach($desc_avanzada_primera as $descripcion){
                $this->id_subcriterio = $descripcion->id;
                $magnitud_inicial = 0;
                $magnitud_inicial_mayor = 100;
                foreach($criterios as $key =>   $criterio){
                    $desc_avanzada = json_decode($criterio->descripcion_avanzada);
                    foreach($desc_avanzada as $descripcion){
                        if($descripcion->id == $this->id_subcriterio){
                            if($descripcion->magnitud == "porcentaje1"){
                                if($descripcion->porcentaje_magnitud == ""){
                                    $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                    $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();
                                    
                                }
                                if($magnitud_inicial <= $descripcion->porcentaje_magnitud){
                                    $magnitud_inicial = $descripcion->porcentaje_magnitud;
                                }else{//On error case I do a rollback.
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                    
                                }
                            }elseif($descripcion->magnitud == "escala"){
                                if($descripcion->escala_magnitud == ""){
                                    $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                    $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();
                                    
                                }
                                if($magnitud_inicial <= $descripcion->escala_magnitud){
                                    $magnitud_inicial = $descripcion->escala_magnitud;
                                }else{//On error case I do a rollback.
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                    
                                }
                            }elseif($descripcion->magnitud == "porcentaje2"){
                                if($descripcion->porcentaje_magnitud == ""){
                                    $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
                                    $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();
                                    
                                }
                                if($magnitud_inicial_mayor >= $descripcion->porcentaje_magnitud){
                                    $magnitud_inicial_mayor = $descripcion->porcentaje_magnitud;
                                }else{//On error case I do a rollback.
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                    
                                }
                            }elseif($descripcion->magnitud == "rango_asc"){
                                if($descripcion->valor_min == "" or $descripcion->valor_max == ""){
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' son obligatorias.');
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();
                                    
                                }
                                if($descripcion->valor_min > $descripcion->valor_max){
                                    $this->addError('subcriterio'.$descripcion->id, 'Las magnitudes del subcriterio ID#'.$this->id_subcriterio.' no estan en orden. 
                                                                    El valor mín. no puede ser mayor a '.$descripcion->valor_max);
                                    $this->criterio->descripcion_avanzada = $desc_antigua;
                                    $this->criterio->save();
                                    
                                }
                                
                                if($key == 0){
                                    $magnitud_inicial=$descripcion->valor_max;
                                }elseif($magnitud_inicial <= $descripcion->valor_min){
                                    $magnitud_inicial = $descripcion->valor_max;
                                }else{
                                    $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                    
                                }
                            }elseif($descripcion->magnitud == "frecuencia"){
                                $criterio_anterior = Criterio::where('id_aspecto',$this->criterio->id_aspecto)
                                                ->where('id','<',$criterio->id)
                                                ->where('deshabilitado',0)
                                                ->orderBy('id','desc')->first();
                                $criterio_posterior = Criterio::where('id_aspecto',$this->criterio->id_aspecto)
                                                ->where('id','>',$criterio->id)
                                                ->where('deshabilitado',0)
                                                ->orderBy('id','asc')->first();
                                
                                if($criterio_anterior==null){
                                    $desc_avanzada_posterior = json_decode($criterio_posterior->descripcion_avanzada);
                                    if($descripcion->frecuencia == "Nunca"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Casi nunca"){
                                        
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Ocasionalmente"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "A veces"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Generalmente"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Usualmente"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Siempre"){
                                        if($desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Siempre"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }

                                }elseif($criterio_posterior==null){//si es el ultimo criterio. 
                                    $desc_avanzada_anterior = json_decode($criterio_anterior->descripcion_avanzada);
                                    if($descripcion->frecuencia == "Siempre"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Usualmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Generalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "A veces"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces"  ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Ocasionalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Casi nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Nunca" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }
                                }else{//criterios que esten en el medio.
                                    $desc_avanzada_anterior = json_decode($criterio_anterior->descripcion_avanzada);
                                    $desc_avanzada_posterior = json_decode($criterio_posterior->descripcion_avanzada);
                                    
                                    if($descripcion->frecuencia == "Siempre"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Generalmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Siempre"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Usualmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente" 
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Generalmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Usualmente"){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Generalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Generalmente" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "A menudo"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A menudo" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "A veces"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "A veces" ){
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Ocasionalmente"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"){
                                                
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Casi nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca" or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca" 
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Casi nunca"){

                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }elseif($descripcion->frecuencia == "Nunca"){
                                        if($desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Siempre" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Usualmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Generalmente" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A menudo"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "A veces" or  $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Ocasionalmente"
                                            or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Casi nunca" or $desc_avanzada_anterior[$this->id_subcriterio]->frecuencia == "Nunca"
                                            or $desc_avanzada_posterior[$this->id_subcriterio]->frecuencia == "Nunca"){
                                                
                                            $this->returnErrorInfoMagnitude($descripcion->id,$desc_antigua);
                                            
                                        }
                                    }
                                }
                            }
                            break;
                        }
                    }
                
                }  
            }
            if($this->getErrorBag()->isNotEmpty()){
                return;
            }
        }
        
    }

    public function returnErrorInfoMagnitude($id_subcriterio,$desc_antigua){
        $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
        $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
        $this->addError('subcriterio'.$id_subcriterio, 'Magnitudes de los subcriterios ID#'.$id_subcriterio.' no estan en orden.');
        $this->criterio->descripcion_avanzada = $desc_antigua;
        $this->criterio->save();
    }

    public function porcentajeChange($index){
        $this->emit('updatePorcentajeSubcriterio'.$this->criterio->id_aspecto,$index,$this->descripcion_avanzada[$index]->porcentaje);
        
    }

    public function updatePorcentajeSubcriterio($index,$porcentaje){
        if($this->descripcion_avanzada[$index]->porcentaje != $porcentaje){
            $this->descripcion_avanzada[$index]->porcentaje = $porcentaje;

            $this->criterio->descripcion_avanzada = json_encode($this->descripcion_avanzada);
            $this->descripcion_avanzada = json_decode($this->criterio->descripcion_avanzada);
            
            $this->criterio->deshabilitado = $this->deshabilitado;
            $this->criterio->save();
        }
        
    }
}
