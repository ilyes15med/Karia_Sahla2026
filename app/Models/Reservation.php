<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Reservation extends Model
{
    //
    protected $fillable=[
        'date_debut' ,
        'date_fin' ,
        'nom_complet' ,
        'idCarteNational',
        'addresse',
        'NumTelephone',
        'users_id' ,
        'chambres_id',
        'canEval',
        'status'
    ];
    public function user(){

        return $this->belongsTo(User::class,'users_id');
        
    }
}
