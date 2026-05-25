<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Chambre;


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
        'status',
        'politiqueAnnulations_id'
    ];
    public function user(){

        return $this->belongsTo(User::class,'users_id');
        
    }
    public function chambre(){
        return $this->belongsTo(Chambre::class,'chambres_id');
    }
    public function payment(){

        return $this->hasOne(ChargilyPayment::class);
    }
}

