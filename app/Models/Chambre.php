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
       
        'images_chambres',
        'Quantite',
        
        'Hebergs_id'
   ];
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
    public function Heb(){
        return $this->belongsTo(Heberg::class);


    }
}
