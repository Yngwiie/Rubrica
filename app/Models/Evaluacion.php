<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'fecha','nombre','id_modulo','id_rubrica',
    ];

    public function modulo(){
        return $this->belongsTo('App\Models\Modulo','id_modulo');
    }

    public function rubricasAplicadas()
    {
        return $this->hasMany('App\Models\RubricaAplicada','id_evaluacion');
    }
    public function rubrica(){
        return $this->hasOne('App\Models\Rubrica','id_evaluacion');
    }
    public function estudiantes(){
        return $this->belongsToMany(Estudiante::class,'estudiante_evaluaciones','id_evaluacion','id_estudiante')->withPivot('nota');
    }
}
