<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modulo_estudiante extends Model
{
    use HasFactory;

    protected $table = 'modulo_estudiantes';

    protected $fillable = [
        'id_modulo','id_estudiante',
    ];

    public function modulo(){
        return $this->belongsTo('App\Models\Modulo','id_modulo');
    }
    public function estudiante(){
        return $this->belongsTo('App\Models\Estudiante','id_estudiante');
    }
}
