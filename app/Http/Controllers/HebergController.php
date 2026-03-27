<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
use Illuminate\Support\Facades\DB;
use App\Events\HeberegRquest;

class HebergController extends Controller
{
    //
   
  
    public function indexAgent(){
        $HebergCours=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();

        $nombre_Heb_enCours=$HebergCours->count();
        return view('agent.dashboard',compact('HebergCours','nombre_Heb_enCours'));

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
    public function index_Heb($idHeb){
        $heb= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','en cours')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->first();

        return view('agent.showHeb',compact('heb'));

    }
  

    
}
