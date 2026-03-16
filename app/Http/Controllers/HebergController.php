<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
use Illuminate\Support\Facades\DB;

class HebergController extends Controller
{
    //
    public function create(){

        return view('hote.demande');
    }
    public function store(Request $request){
        $status="en cours";

        if($request->hasFile('images')){
            foreach($request->file('images') as $image){
    
                $path = $image->store('assets','public');
    
              
            }
        }
     
        Heberg::create([
            'nomHeberg' => $request->nom_Heb,
            'typeHeberg' => $request->type_Heb,
            'addresse' => $request->addresee,
            'latitude' => $request->Latitude,
            'longitude' => $request->Longitude,
            'service' => json_encode($request->services),
            'Description' => $request->description,
            'nombre_chambre' => $request->nb_chambres,
            'nombre_lit' => $request->nb_lits,
            'status' => 'en cours',
            'users_id' =>$request->id,
            'images'=>$path
        ]);

    
        return redirect('/hote/dashboard');


        
    }
    public function indexAgent(){
        $Hebergs=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();
        $nombre_Heb=$Hebergs->count();
        return view('agent.dashboard',compact('Hebergs','nombre_Heb'));



    }

    
}
