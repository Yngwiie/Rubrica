<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelDesempeno extends Model
{
    use HasFactory;

    protected $table = 'nivel_desempenos';

    protected $fillable = [
        'nombre','ordenJerarquico','id_dimension',
    ];

    public function dimension(){
        return $this->belongsTo('App\Models\Dimension','id_dimension');
    }

    public function criterios(){
        return $this->hasMany('App\Models\Criterio','id_nivelDesempeno');
    }

}
