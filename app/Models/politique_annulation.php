<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class politique_annulation extends Model
{
    //
    protected $table='politiqueAnnulations';
    protected $fillable=[
        'id',
        'type_anullation',
        'nombre_jour',
        'pourcentage_recuperation',
        'Hebergs_id',
        
    ];
}
