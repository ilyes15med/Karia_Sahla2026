<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\evaluation;




class ratingController extends Controller
{
    //
    public function store_rating(Request $req,$idheb){
        evaluation::create([
            'nombre_etoile'=>$req->nombre_starts,
            'commentaire'=>$req->commentaire,
            'Hebergs_id'=> $req->heb_id,
            'users_id'=>$req->client_id


        ]);
        return redirect()->back()->with("succes","l'évaluation a été ajouter");





    }

}
