<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RubricaAplicada extends Model
{
    use HasFactory;

    protected $table = 'rubrica_aplicada';

    protected $fillable = [
        'titulo','descripcion','id_evaluacion','id_estudiante','escala_notas','tipo_puntaje','version','nota'
    ];

    public function evaluacion(){
        return $this->belongsTo('App\Models\Evaluacion','id_evaluacion');
    }

    public function estudiante(){
        return $this->belongsTo('App\Models\Estudiante','id_estudiante');
    }

    public function dimensiones(){
        return $this->hasMany('App\Models\Dimension','id_rubricaAplicada');
    }
}
