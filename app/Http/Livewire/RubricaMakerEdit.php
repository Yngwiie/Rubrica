<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Rubrica;
use App\Models\Dimension;
use App\Models\Aspecto;
use App\Models\NivelDesempeno;
use App\Models\Criterio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RubricaMakerEdit extends Component
{
    public $id_rubrica;
    public Rubrica $rubrica;
    public $id_dim;
    public $id_aspecto;
    public $sub_criterios = [];
    public $sub_criterio;
    public $magnitud_subcriterio;
    public $porcentaje_subcriterio;
    public $nombre_aspecto;
    public $porcentaje_restante;

    protected $rules = [
        'rubrica.descripcion' => 'required|string',
        'rubrica.titulo' => 'required|string',
        'rubrica.escala_notas' => 'required',
        'rubrica.tipo_puntaje' => 'required',
    ];

    protected $listeners = ['update','deleteAspecto','storeAspecto','storeDimension','deleteDimension',
                            'storeAspectoAvanzado','deleteLevel','storeNivel','setIdAspecto','addSubcriterios','newversion'];

    public function render()
    {

        return view('livewire.rubrica-maker-edit');
    }

    public function mount($id_rubrica)
    {
        $rubrica = Rubrica::find($id_rubrica);
        if($rubrica->id_usuario != Auth::user()->id && $rubrica->plantilla == false){//evitar acceder a rubricas de otros usuarios
            abort(401);
        }
        $this->rubrica = $rubrica;
        $this->id_rubrica = $id_rubrica;
        $this->porcentaje_restante = 100;
    }
    /**
     * add new sub criteria
     */
    public function addSubcriterio()
    {   
        $suma_porcentajes = 0;
        foreach($this->sub_criterios as $subcriterio){
            $suma_porcentajes += intval($subcriterio["porcentaje"]);
        }
        $suma_porcentajes += intval($this->porcentaje_subcriterio);
        if($this->porcentaje_subcriterio==""){
            $this->addError('subcriterio_porcentaje', 'Porcentaje del subcriterio es obligatorio.');
        }
        if($suma_porcentajes>100){
            $this->addError('subcriterio_porcentaje', 'La suma de los porcentajes es mayor a 100%.');
        }
        if($this->sub_criterio==""){
            $this->addError('subcriterio_descripcion', 'La descripción es obligatoria.');
        }
        if($this->magnitud_subcriterio==""){
            $this->addError('subcriterio_magnitud', 'El tipo de magnitud es obligatorio.');
        }
        if($this->getErrorBag()->isNotEmpty()){
            return;
        }
        $this->resetErrorBag();
        if($this->magnitud_subcriterio=="porcentaje1"){
            array_push($this->sub_criterios, ['id'=>"",'text'=>$this->sub_criterio,'magnitud'=>$this->magnitud_subcriterio,'porcentaje_magnitud'=>0,'porcentaje'=>intval($this->redondeado($this->porcentaje_subcriterio,0))]);
        }elseif($this->magnitud_subcriterio=="escala"){
            array_push($this->sub_criterios, ['id'=>"",'text'=>$this->sub_criterio,'magnitud'=>$this->magnitud_subcriterio,'escala_magnitud'=>0,'porcentaje'=>intval($this->redondeado($this->porcentaje_subcriterio,0))]);
        }elseif($this->magnitud_subcriterio=="porcentaje2"){
            array_push($this->sub_criterios, ['id'=>"",'text'=>$this->sub_criterio,'magnitud'=>$this->magnitud_subcriterio,'porcentaje_magnitud'=>0,'porcentaje'=>intval($this->redondeado($this->porcentaje_subcriterio,0))]);
        }elseif($this->magnitud_subcriterio=="rango_asc"){
            array_push($this->sub_criterios, ['id'=>"",'text'=>$this->sub_criterio,'magnitud'=>$this->magnitud_subcriterio,'valor_min'=>0,'valor_max'=>0,'porcentaje'=>intval($this->redondeado($this->porcentaje_subcriterio,0))]);
        }
        else{
            array_push($this->sub_criterios, ['id'=>"",'text'=>$this->sub_criterio,'magnitud'=>$this->magnitud_subcriterio,'porcentaje'=>intval($this->redondeado($this->porcentaje_subcriterio,0))]);
        }
        $this->porcentaje_restante-=intval($this->redondeado($this->porcentaje_subcriterio,0));
        $this->sub_criterio = "";
        $this->magnitud_subcriterio = "";
        $this->porcentaje_subcriterio = "";
    }
    function redondeado ($numero, $decimales)
    {
        $factor = pow(10, $decimales);
        return (round($numero*$factor)/$factor); 
    }
    /**
     * Remove sub criteria
     */
    public function removeSubcriterio($index)
    {
        unset($this->sub_criterios[$index]);
        $this->sub_criterios = array_values($this->sub_criterios);

    }

    public function updateAll()
    {
        $this->emit('update');
    }
    public function updated()
    {
        $this->rubrica->version+=0.001;
        $this->rubrica->save();
    }

    public function update()
    {
        $this->validate();
        $this->rubrica->save();
        $porcentaje_total = 0;
        $dimensiones = Dimension::where('id_rubrica',$this->rubrica->id)->get();
        $message = "";
        foreach ($dimensiones as $dimension) {  
            $porcentaje_total = 0;
            foreach ($dimension->aspectos as $aspecto) {
                $porcentaje_total += $aspecto->porcentaje;
            }
            if($porcentaje_total>100){
                $message .= '¡Cuidado!, Los aspectos de la dimension "'.$dimension->nombre.'" sobrepasa el 100% <br>';
            }elseif($porcentaje_total<100){
                $message .= '¡Cuidado!, Los aspectos de la dimension "'.$dimension->nombre.'" no suman el 100% <br>';
            }
        }
        if($message != ""){
            session()->flash('warning',$message); 
        }
        session()->flash('success','Salvado.'); 
        $this->newversion();
        $this->emit("salvado");
        /* return redirect()->route('rubric.edit', $this->id_rubrica);  */
        
    }
    public function storeAspecto($id_dimension)
    {
        /* $this->validate();
        $this->rubrica->save(); */
        $dimension = Dimension::findOrFail($id_dimension);
        $aspecto = Aspecto::create([
            'nombre' => 'aspecto',
            'id_dimension' => $dimension->id,
            'porcentaje' => 1,
        ]);
        $niveles = NivelDesempeno::where('id_dimension','=',$id_dimension)->get();
        foreach($niveles as $nivel){
            Criterio::create([
                'descripcion' => 'Criterio',
                'id_aspecto' => $aspecto->id,
                'id_nivel' => $nivel->id,
            ]);
        }
        session()->flash('success','Aspecto agregado con éxito.'); 
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica); 
    }
    /**
     * store an aspect with criteria associated(Advanced version)
     */
    public function storeAspectoAvanzado()
    {
        $num_niveles = NivelDesempeno::where('id_dimension','=',$this->id_dim)->count();
        $sum_porcentajes = 0;
        foreach($this->sub_criterios as $subs){
            $sum_porcentajes+=$subs["porcentaje"];
            
        }
        if($sum_porcentajes<100){
            $this->emit('quitarLoading');
            $this->addError('porcentajes_subs', 'Los porcentajes de los subcriterios no suman 100%.');
            return;
        }
        $this->emit('closeModalAspectosAvanzados');
        $this->resetErrorBag();
        $this->rubrica->save();
        $dimension = Dimension::findOrFail($this->id_dim);
        $aspecto = Aspecto::create([
            'nombre' => $this->nombre_aspecto,
            'id_dimension' => $dimension->id,
            'porcentaje' => 1,
        ]);
        $num_niveles = NivelDesempeno::where('id_dimension','=',$this->id_dim)->count();
        $niveles = NivelDesempeno::where('id_dimension','=',$this->id_dim)->get();

        $array_1 = [40,70,100];
        $array_2 = [20,50,70,100];
        $array_3 = [20,40,60,80,100];
        $array_4 = [10,30,50,70,90,100];
        $array_5 = [0,15,30,45,70,85,100];

        $array_escala_1 = [1,2,3];
        $array_escala_2 = [1,2,3,4];
        $array_escala_3 = [1,2,3,4,5];
        $array_escala_4 = [1,2,3,4,5,6];
        $array_escala_5 = [1,2,3,4,5,6,7];

        $array_descendiente_1 = [100,70,40];
        $array_descendiente_2 = [100,70,50,20];
        $array_descendiente_3 = [100,80,60,40,20];
        $array_descendiente_4 = [100,90,70,50,30,10];
        $array_descendiente_5 = [100,85,70,45,30,15,0];


        $i = 0;
        foreach ($niveles as $nivel) {
            $z = 0;
            foreach($this->sub_criterios as $subs){
                $subs['id']=$z;
                if($subs["magnitud"] == "porcentaje1"){
                    if($num_niveles==3){
                        $subs["porcentaje_magnitud"] = $array_1[$i];
                    }elseif($num_niveles==4){
                        $subs["porcentaje_magnitud"] = $array_2[$i];
                    }elseif($num_niveles==5){
                        $subs["porcentaje_magnitud"] = $array_3[$i];
                    }elseif($num_niveles==6){
                        $subs["porcentaje_magnitud"] = $array_4[$i];
                    }elseif($num_niveles==7){
                        $subs["porcentaje_magnitud"] = $array_5[$i];
                    }
                    $this->sub_criterios[$z] = $subs;
                }
                if($subs["magnitud"] == "escala"){
                    if($num_niveles==3){
                        $subs["escala_magnitud"] = $array_escala_1[$i];
                    }elseif($num_niveles==4){
                        $subs["escala_magnitud"] = $array_escala_2[$i];
                    }elseif($num_niveles==5){
                        $subs["escala_magnitud"] = $array_escala_3[$i];
                    }elseif($num_niveles==6){
                        $subs["escala_magnitud"] = $array_escala_4[$i];
                    }elseif($num_niveles==7){
                        $subs["escala_magnitud"] = $array_escala_5[$i];
                    }
                    $this->sub_criterios[$z] = $subs;
                }
                if($subs["magnitud"] == "porcentaje2"){
                    if($num_niveles==3){
                        $subs["porcentaje_magnitud"] = $array_descendiente_1[$i];
                    }elseif($num_niveles==4){
                        $subs["porcentaje_magnitud"] = $array_descendiente_2[$i];
                    }elseif($num_niveles==5){
                        $subs["porcentaje_magnitud"] = $array_descendiente_3[$i];
                    }elseif($num_niveles==6){
                        $subs["porcentaje_magnitud"] = $array_descendiente_4[$i];
                    }elseif($num_niveles==7){
                        $subs["porcentaje_magnitud"] = $array_descendiente_5[$i];
                    }
                    $this->sub_criterios[$z] = $subs;
                }
                if($subs["magnitud"] == "rango_asc"){
                    if($num_niveles==3){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==4){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==5){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==6){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==7){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }
                    $this->sub_criterios[$z] = $subs;
                }
                $z+=1;
            }
            $json = json_encode($this->sub_criterios);
            Criterio::create([
                'descripcion_avanzada' => $json,
                'id_aspecto' => $aspecto->id,
                'id_nivel' => $nivel->id,
                'last_id_subcriterio' => ($z-1),
            ]);
            $i++;
        }
        
        session()->flash('success','Aspecto agregado con éxito.'); 
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica); 
    }

    /**
     * Delete specific aspect.
     */
    public function deleteAspecto($id_aspecto)
    {
        $this->rubrica->save();
        $aspecto = Aspecto::find($id_aspecto);
        $aspecto->delete();
        session()->flash('success','Aspecto eliminado con éxito.');
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica);
        
    }
    /**
     * 
     */
    public function deleteLevel($id_nivel)
    {
        $nivel = NivelDesempeno::find($id_nivel);

        $nivel->delete();
        session()->flash('success','Nivel eliminado con éxito.');
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica);
    }
    /**
     * 
     */
    public function storeNivel($id_dimension){

        $cantidad_niveles = NivelDesempeno::where('id_dimension',$id_dimension)->count();
        $last_nivel = NivelDesempeno::where('id_dimension',$id_dimension)->orderBy('id','DESC')->first();
        $puntaje = (($last_nivel->puntaje)+1);
        $nivel = NivelDesempeno::create([
            'nombre' => 'nivel '.($cantidad_niveles+1),
            'puntaje' => $puntaje,
            'ordenJerarquico' =>  ($cantidad_niveles+1),
            'id_dimension' => $id_dimension,
        ]);
        $aspectos = Aspecto::where('id_dimension',$id_dimension)->get();

        foreach($aspectos as $aspecto){
            $ultimo_criterio = Criterio::where('id_aspecto',$aspecto->id)->orderBy('id','DESC')->first();
            $criterio = Criterio::create([
                'descripcion' => $ultimo_criterio->descripcion,
                'descripcion_avanzada' => $ultimo_criterio->descripcion_avanzada,
                'id_aspecto' => $aspecto->id,
                'id_nivel' => $nivel->id,
            ]);
            
        }
        session()->flash('success','Nivel agregado.');
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica);
    }
    /**
     * Create a new dimension
     */
    public function storeDimension(){
        $this->rubrica->save();
        $dimension = Dimension::create([ 
            'nombre' => 'Nueva Dimensión',
            'porcentaje' => 1,
            'id_rubrica' => $this->rubrica->id,
        ]);
        for($i = 1; $i <= 3; $i++){
            NivelDesempeno::create([
                'nombre' => 'nivel '.$i,
                'ordenJerarquico' => $i,
                'id_dimension' => $dimension->id,
                'puntaje' => $i,
            ]);
        }
        session()->flash('success','Dimension agregada.');
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica);
    }

    public function setDimension($id_dimension)
    {      
        $this->id_dim = $id_dimension;
        $this->emit('addScroll');
    }

    public function deleteDimension()
    {
        $this->rubrica->save();
        $dimension = Dimension::find($this->id_dim);
        $dimension->delete();
        
        session()->flash('success','Dimensión eliminada con éxito.');
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica);
    }

    public function setIdAspecto($id_aspecto)
    {
        $this->id_aspecto = $id_aspecto;
        $this->emit('addScroll');
    }

    public function addSubcriterios()
    {
       
        $aspecto = Aspecto::find($this->id_aspecto);
        
        $num_niveles = NivelDesempeno::where('id_dimension','=',$aspecto->dimension->id)->count();

        $array_1 = [40,70,100];
        $array_2 = [20,50,70,100];
        $array_3 = [20,40,60,80,100];
        $array_4 = [10,30,50,70,90,100];
        $array_5 = [0,15,30,45,70,85,100];
        
        $array_escala_1 = [1,2,3];
        $array_escala_2 = [1,2,3,4];
        $array_escala_3 = [1,2,3,4,5];
        $array_escala_4 = [1,2,3,4,5,6];
        $array_escala_5 = [1,2,3,4,5,6,7];

        $array_descendiente_1 = [100,70,40];
        $array_descendiente_2 = [100,70,50,20];
        $array_descendiente_3 = [100,80,60,40,20];
        $array_descendiente_4 = [100,90,70,50,30,10];
        $array_descendiente_5 = [100,85,70,45,30,15,0];
        $i = 0;
        $criterios = Criterio::where('id_aspecto',$aspecto->id)->get();
        foreach ($criterios as $criterio) {
            $desc_avanzada = json_decode($criterio->descripcion_avanzada);
            $last_id = $criterio->last_id_subcriterio;
            foreach($this->sub_criterios as $subs){
                $last_id+=1;
                $subs["id"] = $last_id;
                if($subs["magnitud"] == "porcentaje1"){
                    if($num_niveles==3){
                        $subs["porcentaje_magnitud"] = $array_1[$i];
                    }elseif($num_niveles==4){
                        $subs["porcentaje_magnitud"] = $array_2[$i];
                    }elseif($num_niveles==5){
                        $subs["porcentaje_magnitud"] = $array_3[$i];
                    }elseif($num_niveles==6){
                        $subs["porcentaje_magnitud"] = $array_4[$i];
                    }elseif($num_niveles==7){
                        $subs["porcentaje_magnitud"] = $array_5[$i];
                    }
                    
                }
                if($subs["magnitud"] == "escala"){
                    if($num_niveles==3){
                        $subs["escala_magnitud"] = $array_escala_1[$i];
                    }elseif($num_niveles==4){
                        $subs["escala_magnitud"] = $array_escala_2[$i];
                    }elseif($num_niveles==5){
                        $subs["escala_magnitud"] = $array_escala_3[$i];
                    }elseif($num_niveles==6){
                        $subs["escala_magnitud"] = $array_escala_4[$i];
                    }elseif($num_niveles==7){
                        $subs["escala_magnitud"] = $array_escala_5[$i];
                    }
                }
                if($subs["magnitud"] == "porcentaje2"){
                    if($num_niveles==3){
                        $subs["porcentaje_magnitud"] = $array_descendiente_1[$i];
                    }elseif($num_niveles==4){
                        $subs["porcentaje_magnitud"] = $array_descendiente_2[$i];
                    }elseif($num_niveles==5){
                        $subs["porcentaje_magnitud"] = $array_descendiente_3[$i];
                    }elseif($num_niveles==6){
                        $subs["porcentaje_magnitud"] = $array_descendiente_4[$i];
                    }elseif($num_niveles==7){
                        $subs["porcentaje_magnitud"] = $array_descendiente_5[$i];
                    }
                }
                if($subs["magnitud"] == "rango_asc"){
                    if($num_niveles==3){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==4){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==5){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==6){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }elseif($num_niveles==7){
                        $subs["valor_min"] = $i;
                        $subs["valor_max"] = $i+1;
                    }
                }
                array_push($desc_avanzada, $subs);
            }
            $criterio->last_id_subcriterio = $last_id;
            $criterio->descripcion_avanzada = json_encode($desc_avanzada);
            $criterio->save();
           /*  $json = json_encode($this->sub_criterios); */
            

            $i++;
        }
        
        session()->flash('success','Subcriterio(s) agregado(s) con éxito.'); 
        $this->newversion();
        return redirect()->route('rubric.edit', $this->id_rubrica); 
    }
    
    public function newversion()
    {
        $this->rubrica->version+=0.001;
        $this->rubrica->save();
    }
}
