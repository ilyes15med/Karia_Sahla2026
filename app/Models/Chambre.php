<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    //
    protected $fillable=[
        'typeChambres',
        'prix',
        'Description',
        'services',
        'nombre_lit',
        'nombre_chambre',
        'images_chambres',
        'Hebergs_id'


    ];
}
