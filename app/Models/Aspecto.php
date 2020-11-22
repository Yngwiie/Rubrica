<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspecto extends Model
{
    use HasFactory;

    protected $table = 'aspectos';

    protected $fillable = [
        'nombre','id_dimension', 'porcentaje',
    ];

    public function dimension(){
        return $this->belongsTo('App\Models\Dimension','id_dimension');
    }

}
