<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    use HasFactory;

    protected $table = 'criterios';

    protected $fillable = [
        'descripcion','id_nivelDesempeno',
    ];

    public function nivelDesempeno(){
        return $this->belongsTo('App\Models\NivelDesempeno','id_nivelDesempeno');
    }
}
