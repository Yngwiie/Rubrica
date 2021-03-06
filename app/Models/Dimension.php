<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    use HasFactory;

    protected $table = 'dimensiones';

    protected $fillable = [
        'nombre','id_rubrica','porcentaje','id_rubricaAplicada','notaAsociada',
    ];

    public function rubrica(){
        return $this->belongsTo('App\Models\Rubrica','id_rubrica');
    }
    public function rubrica_aplicando(){
        return $this->belongsTo('App\Models\RubricaAplicada','id_rubricaAplicada');
    }
    public function aspectos(){
        return $this->hasMany('App\Models\Aspecto','id_dimension');
    }
    public function nivelesDesempeno(){
        return $this->hasMany('App\Models\NivelDesempeno','id_dimension');
    }
}
