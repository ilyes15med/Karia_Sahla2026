<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use App\Models\Heberg;


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
        'taxe',
        'anullation',
        'payment',
        'code_promo',
        'pourcentage_codepromo',
        'Hebergs_id'
   ];
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
    public function Heb(){
        return $this->belongsTo(Heberg::class);


    }
}
