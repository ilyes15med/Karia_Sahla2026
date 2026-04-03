<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
use App\Models\Chambre;
use Illuminate\Support\Facades\DB;

class HebergClientController extends Controller
{
    //
    public function index_Hebs(){
        $hebs=DB::table('Hebergs')
        ->where('Hebergs.status','valide')
        ->select('Hebergs.*')
        ->get();
        $count_heb=count($hebs);
        
        return view('client.front-end.hébergements',compact('hebs','count_heb'));
        
    }
    public function index_Hebs_home(){
        $hebs=DB::table('Hebergs')
        ->where('Hebergs.status','valide')
        ->select('Hebergs.*')
        ->get();
        $count_heb=count($hebs);
        
        return view('client.front-end.home',compact('hebs','count_heb'));
        
    }
    public function index_Heb($idHeb){
        $heb=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->first();
        $chambres= DB::table('chambres')->where('Hebergs_id',$idHeb)
        ->select('chambres.*')
        ->get();

      

        return view('client.front-end.HebShow',compact('heb','chambres'));
    }
    public function search(Request $req){
        $destination=$req->destination;
        $nombrePersonne =$req->adultes+$req->enfants;
        $hebs=DB::table('Hebergs')
        ->join('chambres','Hebergs.id',"=",'chambres.Hebergs_id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.addresse','LIKE','%'.$destination.'%')
        ->where('chambres.nombre_lit','>=',$nombrePersonne)
        ->select('Hebergs.*')
        ->get();
        $count_heb=count($hebs);
        return view('client.front-end.search',compact('hebs','count_heb'));


    }
    public function filter(Request $req){
        $query=Heberg::query();
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
        $hebs=$query->get();
        $count_heb=count($hebs);

        return view('client.front-end.result-filter',compact('hebs','count_heb'));



    }

}
