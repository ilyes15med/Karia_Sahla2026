<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
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
        $hebs=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)

        ->select('Hebergs.*','users.name as hote_name')
        ->get();

      

        return view('client.front-end.HebShow',compact('hebs'));
    }
    public function search(Request $req){
        $destination=$req->destination;
        $nombrePersonne =$req->adultes+$req->enfants;
        $hebs=DB::table('Hebergs')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.addresse','LIKE','%'.$destination.'%')
        ->where('Hebergs.nombre_lit','>=',$nombrePersonne)
        ->select('Hebergs.*')
        ->get();
        $count_heb=count($hebs);
        return view('client.front-end.search',compact('hebs','count_heb'));


    }
    

}
