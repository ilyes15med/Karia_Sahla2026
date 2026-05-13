<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Chambre;

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
       //'nombre_lit',
        'status',
        'users_id',
        'images'
    ];
    public function chambres(){
        return $this->hasMany(Chambre::class,'Hebergs_id');
    }
    public function hote(){
        $this->belongsTo(User::class);
    }
    public function evaluations(){

        return $this->hasMany(evaluation::class,'Hebergs_id');
    }
}
