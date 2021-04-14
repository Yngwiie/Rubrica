<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrica extends Model
{
    use HasFactory;

    protected $table = 'rubricas';

    protected $fillable = [
        'titulo','descripcion','id_evaluacion','plantilla','id_usuario','escala_notas','tipo_puntaje'
    ];

    public function evaluacion(){
        return $this->belongsTo('App\Models\Evaluacion','id_evaluacion');
    }
    public function dimensiones(){
        return $this->hasMany('App\Models\Dimension','id_rubrica');
    }
    public function usuario(){
        return $this->belongsTo('App\Models\User','id_usuario');
    }
}
