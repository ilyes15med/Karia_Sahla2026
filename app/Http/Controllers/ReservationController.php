<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heberg;
use App\Models\Chambre;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use \App\Models\ChargilyPayment;
use App\Events\faitreservation;
use App\Notifications\Reservations;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class ReservationController extends Controller
{
    

    //reservation des client

    public function added_reservation_show($idheb,$idChambre){
        $chambre=Chambre::findOrFail($idChambre);
        $heb=Heberg::findOrfail($idheb);

        return view('client.front-end.Réservation.réserver',compact('chambre','heb'));
    }
    public function store_reservation(Request $request,$idheb,$idchambre){
        $heberg=DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.id',$idheb)
        ->select('users.id as hote_id')
        ->first();
        // elequent
      //  $heb=Hebergs::findOrFail($idheb);
       // $chambre=Chambres::findOrfail($idchambre);

        $hote=User::findOrFail($heberg->hote_id);
       

        $user = auth()->user();
        $clientname = $user->name;
 
        $currency = "dzd";
        $amount =$request->prix_total;
    
        //   $amount=$request->prix_totale;
        
        $reservation=Reservation::create([
            'date_debut' => $request->date_arrivee,
            'date_fin' => $request->date_depart,
            'nom_complet' => $request->name,
            'idCarteNational' => $request->idCarteNationel,
            'addresse' => $request->adresse,
            'NumTelephone' => $request->numTel,
            'users_id' => $user->id, // utilisateur connecté/client
            'chambres_id' => $idchambre ,
            'canEval'=>1
        ]);
    if($reservation){

       

        $payment = ChargilyPayment::create([
            "users_id"  => $user->id,
            "reservations_id"=>$reservation->id,
            "status"   => "paid",
            "currency" => $currency,
            "amount"   => $amount,
        ]);
    }
    




//chambre
$chambre=Chambre::findOrFail($idchambre);
$chambre_type=$chambre->typeChambres;
// broadcast event
broadcast(new faitreservation($clientname," a été réserver chambre ",$chambre_type));
//notification
$message="$clientname est réserver une chambre $chambre_type ";
$hote->notify(new Reservations($message));
   
return redirect()->back()->with("succes","la réservation a été fait maintenant"); 
}

public function Reservations_index(){
    $client=Auth()->user();
    $reservations=DB::table('reservations')
    ->join('chargily_payments','reservations.id','=','chargily_payments.reservations_id')
    ->join('chambres','reservations.chambres_id','=','chambres.id')
    ->where('chargily_payments.status','paid')
    ->where('reservations.users_id',$client->id)
    ->select('reservations.id as Rid','reservations.nom_complet as Rnom','reservations.date_debut as Rdate_debut','reservations.date_fin as Rdate_fin','chargily_payments.amount as amount','chambres.typeChambres as typeChambres')
    ->get();

//error   
// $chambre=Chambre::findOrFail($reservations->chambre_id);
//$heb=Heberg::findOrFail($chambre->Hebergs_id);
    return view('client.front-end.Réservation.showReservations',compact('reservations'));
}

public function downloadTicket($id)
{

  
    $reservation=DB::table('reservations')
    ->join('chargily_payments','reservations.id','=','chargily_payments.reservations_id')
    ->join('chambres','reservations.chambres_id','=','chambres.id')
    
    ->where('reservations.id',$id)
    ->select('reservations.date_debut' ,'reservations.date_fin','reservations.nom_complet as nom_complet','chambres.typeChambres','chargily_payments.amount','reservations.idCarteNational')
    ->first();

    $pdf = Pdf::loadView('client.front-end.Réservation.tiket', compact('reservation'));

    return $pdf->download('ticket_'.$reservation->nom_complet.'.pdf');
}
public function edit_reservation_show($idR){
      
  $reservation=Reservation::findOrFail($idR);
  $chambre=Chambre::findOrfail($reservation->chambres_id);
  
return view('client.front-end.Réservation.edit_reservation',compact('reservation','chambre')); 

}
public function store_edit_reservation(Request $request,$idR){

$user = auth()->user();
$clientname = $user->name;
$reservation=Reservation::findOrFail($idR);
$chambre=Chambre::findOrFail($reservation->chambres_id);

$heberg = DB::table('chambres')
->join('Hebergs', 'chambres.Hebergs_id', '=', 'Hebergs.id')
->where('chambres.id', $chambre->id)
->select('Hebergs.id as heberg_id', 'Hebergs.users_id')
->first();


$hote = User::findOrFail($heberg->users_id);
$payment=ChargilyPayment::where('reservations_id',$reservation->id)->first();

//verifier le temps 
$start = Carbon::parse($reservation->date_debut);
$now = Carbon::now();


if($start<=$now){// 24h
        
return redirect()->route('reservations.index')->with("succes","impossible modifier maintenant"); 

}
       
        
    
        $newprix=(int)$request->prix_total;
        $oldprix=(int)$payment->amount;
     
        if($newprix>$oldprix){
            $prixcaurant=$oldprix+($newprix-$oldprix);
           
           

        }elseif($newprix=$oldprix){
            $prixcaurant=$newprix;
          

        }elseif($newprix<$oldprix){
            $refund=$oldprix-$newprix;
            dd("refund");
           
        }
        $payment->update([
          
            "amount"   => $prixcaurant,
        ]);
        if($payment){
            $reservation->update([
                'date_debut' => $request->date_arrivee,
                'date_fin' => $request->date_depart,
                'nom_complet' => $request->name,
                'idCarteNational' => $request->idCarteNationel,
                'addresse' => $request->adresse,
                'NumTelephone' => $request->numTel,
                
            ]);


        }
        
      
  



//chambre

    $chambre_type=$chambre->typeChambres;

// broadcast event

    broadcast(new faitreservation($clientname," a été modifier la  réservation de chambre ",$chambre_type));
//notification

    $message="$clientname est modifier la  réservation de chambre $chambre_type ";
    $hote->notify(new Reservations($message));
   
    return redirect()->route('reservations.index')->with("succes","la réservation a été modifier maintenant"); 
}
public function delete_reservation($idR){
    Reservation::where('id',$idR)->delete();
    $reservation=DB::table('reservations')
    ->join('chambres','reservations.chambres_id','=','chambres.id')
    ->select('chambres.typeChambres as typechambre','chambres.id as idCh')
    ->first();
    $clientname=Auth()->user()->name;
    $heberg = DB::table('chambres')
    ->join('Hebergs', 'chambres.Hebergs_id', '=', 'Hebergs.id')
    ->where('chambres.id', $reservation->idCh)
    ->select('Hebergs.id as heberg_id', 'Hebergs.users_id')
    ->first();
    $hote = User::findOrFail($heberg->users_id);

   

   // broadcast event

    broadcast(new faitreservation($clientname," a été supprimer la réservation de chambre ",$reservation->typechambre));

    //notification

    $message="$clientname est supprimer la  réservation de chambre $reservation->typechambre ";
    $hote->notify(new Reservations($message));
    return redirect()->route('reservations.index')->with("succes","la réservation a été annuller maintenant"); 
}



}
