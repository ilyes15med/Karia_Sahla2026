<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Heberg;
use App\Events\HebRequest;


class HebergHoteController extends Controller

{
    //
    public function create(){

        return view('hote.demande');
    }
    public function store(Request $request){
       

        $images=[];
        $NombreLtTotale=$request->nb_lits*$request->nb_chambres;

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
            'nombre_lit' => $NombreLtTotale,
            'status' => 'en cours',
            'users_id' =>$request->id,
            'images'=>json_encode($images)
        ]);
          /*$hote_name=DB::table('users')
          ->where('id',$request->id)
          ->select('name');
          */
          $HebergCours=DB::table('Hebergs')
          ->join('users','Hebergs.users_id','=','users.id')
          ->where('Hebergs.nomHeberg',$request->nom_Heb)
          ->where('Hebergs.status','en cours')
          ->select('Hebergs.*','users.name as hote_name')
          ->first();
        broadcast(new HebRequest("un demande en cours ",$HebergCours->hote_name,$HebergCours->updated_at,$HebergCours->nomHeberg));
       
       

        return $this->indexHote();
      // return back();


        
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
      //  ->where('Hebergs.status','en cours')
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
    

    
    public function index_Hebs(){
        $Heb_valide= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();

        return view('hote.Hebergements.mesHebs',compact('Heb_valide'));
    }
    public function index_Hebergement($idHeb){
        $heb= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->first();

        return view('hote.Hebergements.showHeb',compact('heb'));


    }
}
