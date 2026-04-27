<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChargilyPayment extends Model
{
    //
    use HasFactory;
    protected $fillable = 
    ["users_id","status","currency","amount","reservations_id"];

    public function reservation(){

        return $this->belongsTo(Reservation::class,'reservations_id');
    }
}

