<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estudiante_evaluacion extends Model
{
    use HasFactory;
    
    protected $table = 'estudiante_evaluaciones';

    protected $fillable = [
        'id_estudiante','id_evaluacion','nota'
    ];

    public function estudiante(){
        return $this->belongsTo('App\Models\Estudiante','id_estudiante');
    }
    public function evaluacion(){
        return $this->belongsTo('App\Models\Evaluacion','id_evaluacion');
    }
}
