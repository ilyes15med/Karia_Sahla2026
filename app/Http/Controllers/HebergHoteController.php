<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Heberg;
use App\Models\Chambre;

use App\Models\User;
use App\Events\HebRequest;
use App\Notifications\ReqHebNotification;


class HebergHoteController extends Controller

{
    //
    public function create(){

        return view('hote.demande');
    }
    public function store(Request $request){
       

        $images=[];
        $adresseheb=$request->commune.", ".$request->wilaya;
       // $NombreLtTotale=$request->nb_lits*$request->nb_chambres;

        if($request->hasFile('images')){
            foreach($request->file('images') as $image){
    
                $path = $image->store('assets','public');
                $images[]=$path;
    
              
            }
        }
     
        Heberg::create([
            'nomHeberg' => $request->nom_Heb,
            'typeHeberg' => $request->type_Heb,
            'addresse' => $adresseheb,
            'prix' => $request->prix,
            'latitude' => $request->Latitude,
            'longitude' => $request->Longitude,
            'service' => json_encode($request->services),
            'Description' => $request->description,
            //'nombre_chambre' => $request->nb_chambres,
           // 'nombre_lit' => $NombreLtTotale,
            'status' => 'en cours',
            'users_id' =>$request->id,
            'images'=>json_encode($images)
        ]);
          /* 
          $HebergCours=DB::table('Hebergs')
          ->join('users','Hebergs.users_id','=','users.id')
          ->where('Hebergs.nomHeberg',$request->nom_Heb)
          ->where('Hebergs.status','en cours')
          ->select('Hebergs.*','users.name as hote_name')
          ->first();
        broadcast(new HebRequest(" est demander en cours ",$HebergCours->hote_name,$HebergCours->updated_at,$HebergCours->nomHeberg));
       
          */
         
          $HebergCours=DB::table('Hebergs')
          ->join('users','Hebergs.users_id','=','users.id')
          ->where('Hebergs.nomHeberg',$request->nom_Heb)
          ->where('Hebergs.status','en cours')
          ->select('Hebergs.*','users.name as hote_name')
          ->first();

          broadcast(new HebRequest(" est demander en cours ",$HebergCours->hote_name,$HebergCours->updated_at,$HebergCours->nomHeberg));
          

          $message="hote $HebergCours->hote_name est demander l'ajoute l'hebergement $HebergCours->nomHeberg ";
         
        $agents=User::where('role','agent')->get();
        foreach ($agents as $agent) {
            $agent->notify(new ReqHebNotification($message));
        }


         
       

        return $this->indexHote();
      // return back();


        
    }
    public function indexHote(){
        $idhote=Auth()->id();
        $HebergCours=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->where('Hebergs.users_id',$idhote)
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
        $idhote=Auth()->id();
        $Heb_valide= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.users_id',$idhote)
        ->select('Hebergs.*','users.name as hote_name')
        ->get();

        return view('hote.Hebergements.mesHebs',compact('Heb_valide'));
    }
    public function index_Hebergement($idHeb){

        $heb= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        //->join('chambres','Hebergs.id','=','chambres.Hebergs_id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->first();

        $chambres = DB::table('chambres')
       ->where('Hebergs_id', $idHeb)
        ->get();
      

        return view('hote.Hebergements.showHeb',compact('heb','chambres'));


    }
    public function chambre_added(Request $req,$idHeb){
        $images=[];
      
       
        if($req->hasFile('images')){
            foreach($req->file('images') as $image){
    
                $path = $image->store('assets','public');
                $images[]=$path;
    
              
            }
        }
     
        Chambre::create([
            'typeChambres'=>$req->type_chambre,
            'prix'=>$req->prix,
            'Description' =>$req->description,
            'services'=>json_encode($req->services),
            'nombre_lit'=>$req->nombre_lit,
            'nombre_chambre'=>$req->nombre_chambre,
            'images_chambres'=>json_encode($images),
            'Hebergs_id'=>$idHeb


        ]);
       
        $heb=Heberg::findOrFail($idHeb);
        $nombreChambre_precedent=$heb->nombre_chambre;
        $nombrech= (int)$nombreChambre_precedent+(int)$req->nombre_chambre;
     
     

       $heb->update([
        'nombre_chambre'=>$nombrech


       ]);
        return redirect()->back()->with('succes',"la chambre a été ajouter ");


    }
    public function form_update_show($idHeb,$idchambre){
        
         $chambre=Chambre::findOrFail($idchambre);

         $heb=Heberg::findOrFail($idHeb);

        return view('hote.Hebergements.chambre.update-form',compact('heb','chambre'));
    }
    public function chambre_update(Request $req ,$idHeb,$idchambre){
       $chambre=Chambre::findOrFail($idchambre);
       
       $images=[];
       if($req->hasFile('images')){
           foreach($req->file('images') as $image){
   
               $path = $image->store('assets','public');
               $images[]=$path;
   
             
           }
       }

        $chambre->update([
            'typeChambres'=>$req->type_chambre,
            'prix'=>$req->prix,
            'Description' =>$req->description,
            'services'=>json_encode($req->services),
            'nombre_lit'=>$req->nombre_lit,
            'nombre_chambre'=>$req->nombre_chambre,
            'images_chambres'=>json_encode($images),
            'Hebergs_id'=>$idHeb


        ]);
        $chambres=Chambre::where('Hebergs_id',$idHeb)->get();
        $heb=Heberg::findOrFail($idHeb);
  

        return view('hote.Hebergements.showHeb',compact('heb','chambres'));



    }
    function delete_chambre($idHeb,$idchambre){

        $heb=Heberg::findOrFail($idHeb);
        $nombreChambreCaurantHeb=$heb->nombre_chambre;
        $chambre= DB::table('chambres')
        ->where('id', $idchambre)
        ->select('chambres.nombre_chambre as nbrChambre')
        ->first();

       $nombrech= (int)$nombreChambreCaurantHeb-(int)$chambre->nbrChambre;
      
        $heb->update([
            'nombre_chambre'=>$nombrech


        ]);
     



         Chambre::findOrFail($idchambre)->delete();
       

        

       return redirect()->back()->with('succes',"le chambre a été supprimer");
    }
}
