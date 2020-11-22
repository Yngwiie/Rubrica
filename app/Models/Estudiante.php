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
}
