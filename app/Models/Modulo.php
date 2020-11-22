<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $table = 'modulos';
    
    protected $fillable = [
        'nombre','id_usuario',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function evaluacion(){
        return $this->hasMany('App\Models\Evaluacion','id_modulo');
    }
    public function modulo_estudiante(){
        return $this->hasMany('App\Models\modulo_estudiante','id_modulo');
    }
}
