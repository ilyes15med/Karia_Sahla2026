<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Heberg;
use App\Models\Chambre;
use App\Models\evaluation;
use App\Models\politique_annulation;

use App\Models\User;
use App\Events\HebRequest;
use App\Notifications\ReqHebNotification;
use Illuminate\Support\Facades\Auth;


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
    //si un agent quelqoune existe 
      $count_agent=User::where('role','agent')->count();   
    if($count_agent>0){
     
        $hebergement=Heberg::create([
            'nomHeberg' => $request->nom_Heb,
            'typeHeberg' => $request->type_Heb,
            'addresse' => $adresseheb,
            'prix' => $request->prix,
            'latitude' => $request->Latitude,
            'nombre_chambre'=>$request->Nmbr_chambres ?? 0,
            'nombre_lit'=>$request->Nmbr_lits ?? 0,
            'longitude' => $request->Longitude,
            'service' => json_encode($request->services),
            'Description' => $request->description,
            'politiqueHeb'=>$request->condition,
            'payment_method'=>$request->payment,
            'montant_taxe_sejour'=>$request->taxe,
            'code_promo'=>$request->code_Promo,
            'pourcentage_codepromo'=>$request->Pourcentage_code_Promo,
            'status' => 'en cours',
            'users_id' =>$request->id_hote,
            'images'=>json_encode($images)
        ]);

        if($hebergement->typeHeberg=="Appartement" || $hebergement->typeHeberg=="Maison" || $hebergement->typeHeberg=="Villa" || $hebergement->typeHeberg=="Chambre_hotes"){
            Chambre::create([

                'typeChambres'=>$hebergement->typeHeberg,
                'prix'=>$hebergement->prix,
                'Quantite'=>1,
                'nombre_chambre'=>$request->Nmbr_chambres ?? 0,
                'nombre_lit'=>$request->Nmbr_lits ?? 0,
                'Hebergs_id'=>$hebergement->id,
               
            ]);


        }
        

if($hebergement){
        politique_annulation::create([
            
        'type_anullation' =>$request->type_annulation,
        'nombre_jour'=>$request->nb_jours_annulation,
        'pourcentage_recuperation'=>$request->pourcentage_remboursement,
        'Hebergs_id'=>$hebergement->id,
        
        ]);
}

        

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


         
       

      //  return $this->indexHote();
      // return back();
      return redirect()
        ->route('hote.dashboard')
        ->with('succes', 'votre demande est en cours validation ');
    }else{
      
        return redirect()->with('succes',"votre demande est refuser car aucun agent maintent pour accepter");


    }


        
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

        $Heb=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
      //  ->where('Hebergs.status','en cours')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->first();
        $politique_annulation=DB::table('politiqueAnnulations')
        ->where('Hebergs_id',$Heb->id)
        ->select('*')
        ->first();

        return view ('hote.Demande.ModifierHeb',compact('Heb','politique_annulation'));
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
        $adresseheb=$request->commune.", ".$request->wilaya;
     
        $hebergement->update([
            'nomHeberg' => $request->nom_Heb,
            'typeHeberg' => $request->type_Heb,
            'addresse' => $adresseheb,
            'prix' => $request->prix,
            'latitude' => $request->Latitude,
            'nombre_chambre'=>$request->Nmbr_chambres ?? 0,
            'nombre_lit'=>$request->Nmbr_lits ?? 0,
            'longitude' => $request->Longitude,
            'service' => json_encode($request->services),
            'Description' => $request->description,
            'politiqueHeb'=>$request->condition,
            'payment_method'=>$request->payment,
            'montant_taxe_sejour'=>$request->taxe,
            'code_promo'=>$request->code_Promo,
            'pourcentage_codepromo'=>$request->Pourcentage_code_Promo,
            'status' => 'en cours',
            'users_id' =>Auth::id(),
            'images'=>json_encode($images)
        ]);
        $politique_annulation=politique_annulation::where('Hebergs_id',$hebergement->id)
        ->select('*')
        ->first();
        
        $politique_annulation->update([
            
            'type_anullation' =>$request->type_annulation,
            'nombre_jour'=>$request->nb_jours_annulation,
            'pourcentage_recuperation'=>$request->pourcentage_remboursement,
            'Hebergs_id'=>$hebergement->id,
        ])   ;

       
      
       
       

     //   return $this->indexHote();
     return redirect()
     ->route('hote.dashboard')
     ->with('succes', 'Hébergement est modifier  avec succès');


        
    }
    public function destroy_demande($idHeb){
        $delete_Heb=Heberg::where('id',$idHeb)->delete();

        return redirect()
        ->route('hote.dashboard')
        ->with('succes', 'le demande ajouter hébergement est supprimer  avec succès');


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

        $hote=Auth()->user();
        $heb=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name','users.id as hote_id')
        ->first();
        $chambres= DB::table('chambres')->where('Hebergs_id',$idHeb)
        ->select('chambres.*')
        ->get();

        $pollitique_Annulation=politique_annulation::where('Hebergs_id',$heb->id)->first();
       
        $evaluations=DB::table('evaluations')
        ->join('users','evaluations.users_id','=','users.id')
        ->where('Hebergs_id',$idHeb)
        ->select('nombre_etoile','commentaire','users.name as nomclient','evaluations.id as Evaluation_id','users.id as id_client')
       ->get();
        $EvalTotale = evaluation::where('Hebergs_id', $idHeb)
        ->avg('nombre_etoile');
    
      

      

        return view('hote.Hebergements.showHeb',compact('heb','chambres','evaluations','EvalTotale','pollitique_Annulation'));
      

      


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
            'Quantite'=>$req->nombre_chambre,
           
            'images_chambres'=>json_encode($images),

            
            'Hebergs_id'=>$idHeb


        ]);
       
        $heb=Heberg::findOrFail($idHeb);
        $nombreChambre_precedent=$heb->nombre_chambre;
        $nombrech= (int)$nombreChambre_precedent+(int)$req->nombre_chambre;
      //  dd($heb,$nombreChambre_precedent,$nombrech);
     
     

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
       $heb=Heberg::findOrFail($idHeb);
       
       $images=[];
       if($req->hasFile('images')){
           foreach($req->file('images') as $image){
   
               $path = $image->store('assets','public');
               $images[]=$path;
   
             
           }
       }

   
        //nombre chambre dans table hebergs
        $NbrChHeb=$heb->nombre_chambre;
        //nombre de chambre dans table chambres
        $N1=$chambre->nombre_chambre;

        //nombre de chambre dans requete

        $N2=$req->nombre_chambre;
        //desagmauntation
        
        if($N1>$N2){
           $nbrDesaugmenter=$N1-$N2;
           $chambre->update([
            

            'typeChambres'=>$req->type_chambre,
            'prix'=>$req->prix,
            'Description' =>$req->description,
            'services'=>json_encode($req->services),
            'nombre_lit'=>$req->nombre_lit,
            'nombre_chambre'=>$N1-$nbrDesaugmenter,
            'Quantite'=>$N1-$nbrDesaugmenter,
            'images_chambres'=>json_encode($images),
            'Hebergs_id'=>$idHeb

           ]);
           $heb->update([
            'nombre_chambre'=>$NbrChHeb-$nbrDesaugmenter

           ]);
        }
        //augmantaion
         elseif($N1<$N2){
            $nbrAugmenter=$N2-$N1;
            $chambre->update([
             
             'typeChambres'=>$req->type_chambre,
             'prix'=>$req->prix,
             'Description' =>$req->description,
             'services'=>json_encode($req->services),
             'nombre_lit'=>$req->nombre_lit,
             'nombre_chambre'=>$N1+$nbrAugmenter,
             'Quantite'=>$N1+$nbrAugmenter,
             'images_chambres'=>json_encode($images),
             'Hebergs_id'=>$idHeb
 
            ]);
            $heb->update([
                'nombre_chambre'=>$NbrChHeb+$nbrAugmenter
    
               ]);
         }
         elseif($N1==$N2){
            $chambre->update([
            

                'typeChambres'=>$req->type_chambre,
                'prix'=>$req->prix,
                'Description' =>$req->description,
                'services'=>json_encode($req->services),
                'nombre_lit'=>$req->nombre_lit,
                'nombre_chambre'=>$req->nombre_chambre,
                'Quantite'=>$req->nombre_chambre,
                'images_chambres'=>json_encode($images),
                'Hebergs_id'=>$idHeb
    
               ]);
            

         }

        $chambres=Chambre::where('Hebergs_id',$idHeb)->get();
        
  

      //  return view('hote.Hebergements.showHeb',compact('heb','chambres'))->with('succes',"la chambre a été modifier");;

      // return redirect()->back()
      return redirect()->route('Heb.index',$heb->id)
      ->with('heb', $heb)
      ->with('chambres', $chambres)
      ->with('succes', 'Chambre mise à jour avec succès');

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
