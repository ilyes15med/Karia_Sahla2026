<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\evaluation;
use App\Models\Reservation;
use App\Models\Heberg;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Events\rating;
use App\Notifications\ratingNotification;


class ratingController extends Controller
{
    //
    public function store_rating(Request $req,$idheb){

        $message="est faire une evaluation pour votre hébergement";
        $clientname=Auth()->user()->name;
    
        $heb=DB::table('Hebergs')
        ->where('id',$idheb)
        ->select('Hebergs.nomHeberg as nomHeb','Hebergs.users_id as hote_id')
        ->first();
        //name heb
        $nomheb=$heb->nomHeb;
        //hote
        $hote=User::findOrfail($heb->hote_id);
        $reservation=Reservation::where('users_id',$req->client_id)->first();

        
        evaluation::create([
            'nombre_etoile'=>$req->nombre_starts,
            'commentaire'=>$req->commentaire,
            'Hebergs_id'=> $idheb,
            'users_id'=>$req->client_id


        ]);

        $reservation->update([
            'canEval'=>0
   
        ]);
        broadcast(new rating($clientname,$message,$nomheb));
        $message_Notification="$clientname $message $nomheb ";
        $hote->notify(new ratingNotification($message_Notification) );

        return redirect()->back()->with("succes","l'avis a été ajouter");





    }
    public function show_edit_rating($idheb,$ideval){
        $evaluation=evaluation::where('id',$ideval)->first();
        $heb=Heberg::findOrFail($idheb);
     
        return view('partials.rating.update_rating',compact('evaluation','heb'));


    }
    public function store_edit_rating(Request $req,$idheb,$ideval){

        $message="est faire une modification de evaluation précedent pour votre hébergement";
        $clientname=Auth()->user()->name;
        $heb=DB::table('Hebergs')
        ->where('id',$idheb)
        ->select('Hebergs.nomHeberg as nomHeb','Hebergs.users_id as hote_id')
        ->first();
        //name heb
        $nomheb=$heb->nomHeb;
        //hote
        $hote=User::findOrfail($heb->hote_id);
        $evaluation=evaluation::where('id',$ideval)->first();
        $evaluation->update([
            'nombre_etoile'=>$req->nombre_starts,
            'commentaire'=>$req->commentaire,
            


        ]);
        broadcast(new rating($clientname,$message,$nomheb));
        $message_Notification="$clientname $message $nomheb ";
        $hote->notify(new ratingNotification($message_Notification) );

        return redirect()->back()->with("succes","l'avis a été ajouter"); 

    }
    public function destroy_rating($idheb,$ideval){
        $client_id=Auth()->user()->id;
        $message="est faire une supression de evaluation précedent pour votre hébergement";
        $clientname=Auth()->user()->name;
        $heb=DB::table('Hebergs')
        ->where('id',$idheb)
        ->select('Hebergs.nomHeberg as nomHeb','Hebergs.users_id as hote_id')
        ->first();
        //name heb
        $nomheb=$heb->nomHeb;
        //hote
        $hote=User::findOrfail($heb->hote_id);
        evaluation::findOrfail($ideval)->delete();
        $reservation=Reservation::where('users_id',$client_id)->first();
        $reservation->update([
            'canEval'=>1
   
        ]);
        broadcast(new rating($clientname,$message,$nomheb));
        $message_Notification="$clientname $message $nomheb ";
        $hote->notify(new ratingNotification($message_Notification) );


        return redirect()->back()->with("succes","l'avis a été supprimer"); 



    }
   

}
