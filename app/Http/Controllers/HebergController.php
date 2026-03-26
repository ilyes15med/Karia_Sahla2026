<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
use Illuminate\Support\Facades\DB;
use App\Events\HeberegRquest;

class HebergController extends Controller
{
    //
    public function create(){

        return view('hote.demande');
    }
    public function store(Request $request){
        $status="en cours";
        $images=[];

        if($request->hasFile('images')){
            foreach($request->file('images') as $image){
    
                $path = $image->store('assets','public');
                $images[]=$path;
    
              
            }
        }
     
        Heberg::create([
            'nomHeberg' => $request->nom_Heb,
            'typeHeberg' => $request->type_Heb,
            'addresse' => $request->addresee,
            'prix' => $request->prix,
            'latitude' => $request->Latitude,
            'longitude' => $request->Longitude,
            'service' => json_encode($request->services),
            'Description' => $request->description,
            'nombre_chambre' => $request->nb_chambres,
            'nombre_lit' => $request->nb_lits,
            'status' => 'en cours',
            'users_id' =>$request->id,
            'images'=>json_encode($images)
        ]);

       
        broadcast(new HeberegRquest("Nouvelle hébergement"));
       
       

        return $this->indexHote();


        
    }
   
    public function indexAgent(){
        $HebergCours=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();

        $nombre_Heb_enCours=$HebergCours->count();
        return view('agent.dashboard',compact('HebergCours','nombre_Heb_enCours'));

    }
    public function indexHote(){
        $HebergCours=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();

        $nombre_Heb_enCours=$HebergCours->count();
        return view('hote.dashboard',compact('HebergCours','nombre_Heb_enCours'));

    }
    public function confirme($idHeb){
        DB::table('Hebergs')
        ->where('id',$idHeb)
        ->update(['status'=>'valide']);
         
        return $this->indexAgent();
    }
    public function refuse($idHeb){
        DB::table('Hebergs')
        ->where('id',$idHeb)
        ->update(['status'=>'refuse']);
         
        return $this->indexAgent();
    }
    public function Demande_refuse(){
        $Hebergrefuse=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','refuse')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();
         
        $nombre_Heb_refuse=$Hebergrefuse->count();
        
        return view('agent.Demande_refuse',compact('Hebergrefuse','nombre_Heb_refuse'));

      
    }
    public function Demande_valide(){

        $HebergValide=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();
        $nombre_Heb_valide=$HebergValide->count();
        return view('agent.Demande_valide',compact('HebergValide','nombre_Heb_valide'));

    }
    public function show_demande($idHeb){
        $HebergCours=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->get();
         return view('hote.Demande.HebShow',compact('HebergCours'));


    }
    public function edit_demande($idHeb){
        $HebergCours=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->get();

        return view ('hote.Demande.ModifierHeb',compact('HebergCours'));
    }
   
    public function update_demande(Request $request,$idHeb){
        $status="en cours";
        $images=[];

        if($request->hasFile('images')){
            foreach($request->file('images') as $image){
    
                $path = $image->store('assets','public');
                $images[]=$path;
    
              
            }
        }
        $hebergement=Heberg::findOrFail($idHeb);
     
        $hebergement->update([
            'nomHeberg' => $request->nom_Heb,
            'typeHeberg' => $request->type_Heb,
            'addresse' => $request->addresee,
            'prix' => $request->prix,
            'latitude' => $request->Latitude,
            'longitude' => $request->Longitude,
            'service' => json_encode($request->services),
            'Description' => $request->description,
            'nombre_chambre' => $request->nb_chambres,
            'nombre_lit' => $request->nb_lits,
            'status' => 'en cours',
            'users_id' =>$request->id,
            'images'=>json_encode($images)
        ]);

       
      
       
       

        return $this->indexHote();


        
    }
    public function destroy_demande($idHeb){
        $delete_Heb=Heberg::where('id',$idHeb)->delete();

        return $this->indexHote();


    }
    

    

    
}
