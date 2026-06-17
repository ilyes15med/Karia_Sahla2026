<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
use App\Models\Chambre;
use App\Models\Reservation;
use App\Models\User;
use App\Models\evaluation;
use Illuminate\Support\Facades\DB;
use \App\Models\ChargilyPayment;
use App\Events\faitreservation;
use App\Notifications\Reservations;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvitehebergController extends Controller
{
    //
    public function index_Hebs(){
        $hebs = Heberg::withAvg('evaluations', 'nombre_etoile')
        ->where('status','valide')
        ->get();

        $count_heb=count($hebs);
      
        
        
      
        
        return view('invité.front-end.hébergements',compact('hebs','count_heb'));
        
    }
    public function index_Hebs_home(){
        $hebs = Heberg::withAvg('evaluations', 'nombre_etoile')
        ->where('status','valide')
        ->get();

        $count_heb=count($hebs);
        
        return view('invité.front-end.home',compact('hebs','count_heb'));
        
    }
    public function index_Heb($idHeb){
      
      
        $heb=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name','users.id as hote_id')
        ->first(); 
    if(Auth::check()){
        $client=auth()->user();
      /*  $reservations=DB::table('reservations')
        ->where('users_id',$client->id)
        ->select('reservations.canEval as canEvalue')
        ->first();*/
        $reservations = DB::table('reservations')
        ->join('chambres','reservations.chambres_id','=','chambres.id')
        ->where('reservations.users_id',$client->id)
        ->where('chambres.Hebergs_id',$idHeb)
        ->where('reservations.canEval',1)
        ->first();

    }else{
            $reservations=null;

    }

        $chambres= DB::table('chambres')->where('Hebergs_id',$idHeb)
        ->select('chambres.*')
        ->get();

      
        

        $evaluations=DB::table('evaluations')
        ->join('users','evaluations.users_id','=','users.id')
        ->where('Hebergs_id',$idHeb)
        ->select('nombre_etoile','commentaire','users.name as nomclient','evaluations.id as Evaluation_id','users.id as id_client')
       ->get();
       
        $EvalTotale = evaluation::where('Hebergs_id', $idHeb)
        ->avg('nombre_etoile');

        $pollitique_Annulation=DB::table('politiqueAnnulations')
        ->where('Hebergs_id',$heb->id)
        ->select('*')
        ->first();
      //  dd($pollitique_Annulation);
    
      

     

        return view('invité.front-end.HebShow',compact('heb','chambres','reservations','evaluations','EvalTotale','pollitique_Annulation'));
    }
        
    public function search(Request $req){
        $destination=$req->destination;
        $nombrePersonne =$req->adultes+$req->enfants;
        session([
            'date_arrivee' => $req->date_arrivee,
            'date_depart' => $req->date_depart,
        ]);
        
        $hebs=DB::table('Hebergs')
        ->join('chambres','Hebergs.id',"=",'chambres.Hebergs_id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.addresse','LIKE','%'.$destination.'%')
        ->where('chambres.nombre_lit','>=',$nombrePersonne)
        ->where('chambres.nombre_chambre','>',0)
        ->select('Hebergs.*')
        ->distinct()
        ->get();
     
        $count_heb=count($hebs);
       
        return view('invité.front-end.search',compact('hebs','count_heb'));


    }
    public function filter(Request $req){
        $query=Heberg::query()->withAvg('evaluations','nombre_etoile')
        ->where('status','valide');

       
        if($req->type){

            $query->where('typeHeberg',$req->type);
        }
        if($req->price){

            $query->where('prix','<=',$req->price);
        }
        if($req->wilaya){

            $query->where('addresse','LIKE','%'.$req->wilaya.'%');
        }
        if($req->equipement){

            $query->where(function($q) use ($req){
                foreach($req->equipement as $eq){
                    $q->WhereJsonContains('service',$eq);

                    
                }
               

            });
         
           
        }

        if ($req->stars) {
            $query->having('evaluations_avg_nombre_etoile', '>=', $req->stars);
        }
     
        $hebs=$query->get();
        $count_heb=count($hebs);

       

    


        return view('invité.front-end.result-filter',compact('hebs','count_heb'));



    }
}




