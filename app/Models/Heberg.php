<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heberg extends Model
{
    //
    protected $table = 'Hebergs';
    protected $fillable = [
        
        'nomHeberg',
        'typeHeberg',
        'prix',
        'addresse',
        'latitude',
        'longitude',
        'service',
        'Description',
      'nombre_chambre',
     'nombre_lit',
        'status',
        'users_id',
        'images'
    ];
}
