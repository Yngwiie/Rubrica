<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'email','nombre','apellido',
    ];
    public function estudiante_evaluacion(){
        return $this->hasMany('App\Models\estudiante_evaluacion','id_estudiante');
    }
    public function modulo_estudiante(){
        return $this->hasMany('App\Models\modulo_estudiante','id_estudiante');
    }
    //ARREGLANDO..
    public function modulos(){
        return $this->belongsToMany(Modulo::class,'modulo_estudiantes','id_estudiante','id_modulo');
    }
    public function evaluaciones(){
        return $this->belongsToMany(Evaluacion::class,'estudiante_evaluaciones','id_estudiante','id_evaluacion')->withPivot('nota');
    }

    public function rubrica_aplicada(){
        return $this->hasMany('App\Models\RubricaAplicada','id_estudiante');
    }
}
