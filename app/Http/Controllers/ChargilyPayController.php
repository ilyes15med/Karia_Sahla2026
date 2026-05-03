<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use \App\Models\ChargilyPayment;
use \App\Models\Chambre;
use App\Models\Heberg;
use App\Models\User;
use App\Events\faitreservation;
use App\Notifications\ReqHebNotification;
use App\Notifications\Reservations;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChargilyPayController extends Controller
{ 
    /**
     * The client will be redirected to the ChargilyPay payment page
     *
     */
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
                    $prixcaurant=$newprix-$oldprix;
                  //  dd($newprix,$oldprix,$prixcaurant);

                    if ($payment) {
                       
                        $checkout = $this->chargilyPayInstance()->checkouts()->create([
                            "metadata" => [
                                "payment_id" => $payment->id,
                                "type"=>"update",
                                'date_debut' => $request->date_arrivee,
                                'date_fin' => $request->date_depart,
                                'nom_complet' => $request->name,
                                'idCarteNational' => $request->idCarteNationel,
                                'addresse' => $request->adresse,
                                'NumTelephone' => $request->numTel,
                                'prixactuelle'=>$newprix
                               
                            ],
                            "locale" => "ar",
                            "amount" => $prixcaurant,
                            "currency" => $payment->currency,
                            "description" => "Payment ID={$payment->id}",
                            "success_url" => route("chargilypay.back"),
                            "failure_url" => route("chargilypay.back"),
                            "webhook_endpoint" => route("chargilypay.webhook_endpoint"),
                        ]);
                        if ($checkout) {
                            return redirect($checkout->getUrl());
                        }
                    }
                    return dd("Redirection failed");
                   
                   
        
                }elseif($newprix==$oldprix){
                   
                   
                 
                        $reservation->update([
                            'date_debut' => $request->date_arrivee,
                            'date_fin' => $request->date_depart,
                            'nom_complet' => $request->name,
                            'idCarteNational' => $request->idCarteNationel,
                            'addresse' => $request->adresse,
                            'NumTelephone' => $request->numTel,
                            
                        ]);
            
            
                
                  
        
                }elseif($newprix<$oldprix){
                    $refund=$oldprix-$newprix;
                    dd("refund");
                   
                }
                /*
                $payment->update([
                  
                    "amount"   => $prixcaurant,
                ]);
                */
              
              
          
        
        
        
        //chambre
        
            $chambre_type=$chambre->typeChambres;
        
        // broadcast event
        
            broadcast(new faitreservation($clientname," a été modifier la  réservation de chambre ",$chambre_type));
        //notification
        
            $message="$clientname est modifier la  réservation de chambre $chambre_type ";
            $hote->notify(new Reservations($message));
           
            return redirect()->route('reservations.index')->with("succes","la réservation a été modifier maintenant"); 
        }
        //redirect
    public function redirect(Request $request,$idchambre )
    {
        $user = auth()->user();
        $currency = "dzd";
        $amount =$request->prix_total;
    
        //   $amount=$request->prix_totale;
        
        $reservation=Reservation::create([
            'date_debut' => $request->date_arrivee,
            'date_fin' => $request->date_depart,
            'nom_complet' => $request->name,
            'canEval'=>"1",
            'idCarteNational' => $request->idCarteNationel,
            'addresse' => $request->adresse,
            'NumTelephone' => $request->numTel,
            'users_id' => $user->id, // utilisateur connecté/client
            'chambres_id' => $idchambre ,
        ]);
    if($reservation){

       

        $payment = ChargilyPayment::create([
            "users_id"  => $user->id,
            "reservations_id"=>$reservation->id,
            "status"   => "pending",
            "currency" => $currency,
            "amount"   => $amount,
        ]);
    }
        if ($payment) {
            $checkout = $this->chargilyPayInstance()->checkouts()->create([
                "metadata" => [
                    "payment_id" => $payment->id,
                ],
                "locale" => "ar",
                "amount" => $payment->amount,
                "currency" => $payment->currency,
                "description" => "Payment ID={$payment->id}",
                "success_url" => route("chargilypay.back"),
                "failure_url" => route("chargilypay.back"),
                "webhook_endpoint" => route("chargilypay.webhook_endpoint"),
            ]);
            if ($checkout) {
                return redirect($checkout->getUrl());
            }
        }
        return dd("Redirection failed");
    }
    /**
     * Your client you will redirected to this link after payment is completed ,failed or canceled
     *
     */
    public function back(Request $request)
    {
        $user = auth()->user();
        $checkout_id = $request->input("checkout_id");
        $checkout = $this->chargilyPayInstance()->checkouts()->get($checkout_id);
        $payment = null;

        if ($checkout) {
            $metadata = $checkout->getMetadata();
            $payment = ChargilyPayment::find($metadata['payment_id']);
            ////
            //// Is not recomended to process payment in back page / success or fail page
            //// Doing payment processing in webhook for best practices
            ////
        }
        dd($checkout,$payment);
    }
    /**
     * This action will be processed in the background
     */
    public function webhook()
    {
        $webhook = $this->chargilyPayInstance()->webhook()->get();
        if ($webhook) {
            $user = auth()->user();
            //
            $checkout = $webhook->getData();
            //check webhook data is set
            //check webhook data is a checkout
            if ($checkout and $checkout instanceof \Chargily\ChargilyPay\Elements\CheckoutElement) {
                if ($checkout) {
                    $metadata = $checkout->getMetadata();
                    $payment = ChargilyPayment::find($metadata['payment_id']);
                    $reservation = Reservation::find($payment->reservations_id);
           

                    if (($metadata['type'] ?? '') === "update") {

                     
                        $reservation->update([
                            'date_debut' => $metadata['date_debut'],
                            'date_fin'   => $metadata['date_fin'],
                            'nom_complet' =>$metadata['nom_complet'],
                            'idCarteNational' =>$metadata['idCarteNational'],
                            'addresse' =>$metadata['addresse'],
                            'NumTelephone' =>$metadata['NumTelephone'],


                        ]);
                        $payment->update([
                            'amount'=>$metadata['prixactuelle']
                        ]);
                    }

                    if ($payment) {
                        if ($checkout->getStatus() === "paid") {
                            //update payment status in database
                            $payment->status = "paid";
                            $payment->update();
                            /////
                            ///// Confirm your order
                            /////
                            //event
                            $payment->status = "paid";
                            $payment->update();
                        
                            $res = Reservation::findOrFail($payment->reservations_id);
                        
                            $chambre = Chambre::findOrFail($res->chambres_id);
                            $chambre->decrement('nombre_chambre', 1);
                        
                            $heberg = Heberg::findOrFail($chambre->Hebergs_id);
                            $heberg->decrement('nombre_chambre', 1);
                            

                            $clientname = $user->name;


// broadcast event
broadcast(new faitreservation($clientname," a été réserver chambre ",$chambre->typeChambres));
//notification
$message="$clientname est réserver une chambre $chambre->typeChambres ";
$hote->notify(new Reservations($message));
   
return redirect()->back()->with("succes","la réservation a été fait maintenant"); 



          
                            return response()->json(["status" => true, "message" => "Payment has been completed"]);
                        } else if ($checkout->getStatus() === "failed" or $checkout->getStatus() === "canceled") {
                            //update payment status in database
                            $payment->status = "failed";
                            $payment->update();
                            /////
                            /////  Cancel your order
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been canceled"]);
                        }
                    }
                }
            }
        }
        return response()->json([
            "status" => false,
            "message" => "Invalid Webhook request",
        ], 403);
    }

    /**
     * Just a shortcut
     */
    protected function chargilyPayInstance()
    {
        return new \Chargily\ChargilyPay\ChargilyPay(new \Chargily\ChargilyPay\Auth\Credentials([
            "mode" => "test",
            "public" => "test_pk_Wb7912rJZiuRAzK5kNIOKAuEpO9SdWruxGK6MXmt",
            "secret" => "test_sk_LWx0sVAWkCaOi7YWQNbQtwa9DljszwgxLW1AdcbE",
        ]));
    }
}
