<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class evaluation extends Model
{
    //
    protected $fillable=['nombre_etoile',
            'commentaire',
            'Hebergs_id',
            'users_id'];
}
