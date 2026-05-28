<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
use Illuminate\Support\Facades\DB;
use App\Events\HeberegRquest;
use App\Events\ReponseReqHote;
use App\Models\User;
use App\Notifications\ReqHebNotification;

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
  
    public function confirme($agent_name,$idHeb){
       DB::table('Hebergs')
        ->where('id',$idHeb)
        ->update(['status'=>'valide']);

       

        //broadcast
        $message=" est accepter votre demande";
        broadcast(new ReponseReqHote($agent_name,$message) );

        $heb=DB::table('Hebergs')
        ->where('id',$idHeb)
        ->select('users_id','nomHeberg')
        ->first();
       

        //notifier
        $messageNotification= "agent $agent_name est accepter l'ajoute l'hebergement $heb->nomHeberg ";
         

        $hote=User::where('role','hote')
        ->where('id',$heb->users_id)
        ->first();

       
        $hote->notify(new ReqHebNotification($messageNotification));
        
    
       
      
           
        
         
        return $this->indexAgent();
    }
    public function refuse($agent_name,$idHeb){
        DB::table('Hebergs')
        ->where('id',$idHeb)
        ->update(['status'=>'refuse']);

        $message=" est refuser votre demande";
        broadcast(new ReponseReqHote($agent_name,$message) );

        $heb=DB::table('Hebergs')
        ->where('id',$idHeb)
        ->select('users_id','nomHeberg')
        ->first();
       

        //notifier
        $messageNotification= "agent $agent_name est refuser l'ajoute l'hebergement $heb->nomHeberg ";
         

        $hote=User::where('role','hote')
        ->where('id',$heb->users_id)
        ->first();

       
        $hote->notify(new ReqHebNotification($messageNotification));
        
    
       
         
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
        ->select('Hebergs.*','users.name as hote_name','users.id as hote_id')
        ->first();

        return view('agent.showHeb',compact('heb'));

    }
    public function index_Heb_Valide($idheb){
        $heb= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idheb)
        ->select('Hebergs.*','users.name as hote_name','users.id as hote_id')
        ->first();
        $pollitique_Annulation=DB::table('politiqueAnnulations')
        ->where('Hebergs_id',$heb->id)
        ->select('*')
        ->first();
        return view('agent.showHeb',compact('heb','pollitique_Annulation'));

    }
  

    
}
