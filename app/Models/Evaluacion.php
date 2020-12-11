<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'fecha','nombre','id_modulo',
    ];

    public function modulo(){
        return $this->belongsTo('App\Models\Modulo','id_modulo');
    }

    public function rubrica(){
        return $this->hasOne('App\Models\Rubrica','id_evaluacion');
    }
}
