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

class HebergClientController extends Controller
{
    //
    public function index_Hebs(){
        $hebs = Heberg::withAvg('evaluations', 'nombre_etoile')
        ->where('status','valide')
        ->get();

        $count_heb=count($hebs);
        
        
      
        
        return view('client.front-end.hébergements',compact('hebs','count_heb'));
        
    }
    public function index_Hebs_home(){
        $hebs = Heberg::withAvg('evaluations', 'nombre_etoile')
        ->where('status','valide')
        ->get();

        $count_heb=count($hebs);
       // dd($count_heb,$hebs);
        return view('client.front-end.home',compact('hebs','count_heb'));
        
    }
    public function index_Heb($idHeb){
        $client=Auth()->user();
        $heb=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name','users.id as hote_id')
        ->first();
        $chambres= DB::table('chambres')->where('Hebergs_id',$idHeb)
        ->select('chambres.*')
        ->get();
        $reservations=DB::table('reservations')
        ->where('users_id',$client->id)
        ->select('reservations.canEval as canEvalue')
        ->first();
        $evaluations=DB::table('evaluations')
        ->join('users','evaluations.users_id','=','users.id')
        ->where('Hebergs_id',$idHeb)
        ->select('nombre_etoile','commentaire','users.name as nomclient','evaluations.id as Evaluation_id','users.id as id_client')
       ->get();
        $EvalTotale = evaluation::where('Hebergs_id', $idHeb)
        ->avg('nombre_etoile');
    
      

      

        return view('client.front-end.HebShow',compact('heb','chambres','reservations','client','evaluations','EvalTotale'));
    }
    public function search(Request $req){
        $destination=$req->destination;
        $nombrePersonne =$req->adultes+$req->enfants;
       
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
        
        return view('client.front-end.search',compact('hebs','count_heb'));


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
                $query->having('evaluations_avg_nombre_etoile', '<=', $req->stars);
        }
         
           
     
     
        
        $hebs=$query->get();
        //dd($hebs);
        $count_heb=count($hebs);

        return view('client.front-end.result-filter',compact('hebs','count_heb'));



    }
}




