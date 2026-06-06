<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use \App\Models\ChargilyPayment;
use \App\Models\Chambre;
use App\Models\Heberg;
use App\Models\User;
use App\Models\politique_annulation;
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
        
        
                $newprix=(int)$request->prix_total;
                $oldprix=(int)$payment->amount;
            //mode paiment 
            $mode_payment=$request->mode_paiement;
          
            //pending
          
        if($mode_payment=="a_larrivee"){  
            
                $reservation->update([
                'date_debut' => $request->date_arrivee,
                'date_fin' => $request->date_depart,
                'nom_complet' => $request->name,
                'idCarteNational' => $request->idCarteNationel,
                'addresse' => $request->adresse,
                'NumTelephone' => $request->numTel,
                
            ]);
            $payment->update([
                'amount' =>$newprix
            ]);


            }elseif($mode_payment=="en_ligne"){
               

            
          

            
            //paid 

                if($newprix>$oldprix){
                    $prixcaurant=$newprix-$oldprix;
                  //  dd($newprix,$oldprix,$prixcaurant);

                    if ($payment) {
                      //  dd("tu es en enligne et je lance le paiement en ligne  ");
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
                    $reservation->update([
                        'date_debut' => $request->date_arrivee,
                        'date_fin' => $request->date_depart,
                        'nom_complet' => $request->name,
                        'idCarteNational' => $request->idCarteNationel,
                        'addresse' => $request->adresse,
                        'NumTelephone' => $request->numTel,
                        
                    ]);
                    $payment->update([
                        'amount' =>$newprix
                    ]);
                    return redirect()->route('reservations.index')->with("succes","la réservation a été modifier  et remobourser $refund DZD maintenant"); 
        
        
                   

                   
                }
                /*
                $payment->update([
                  
                    "amount"   => $prixcaurant,
                ]);
                */
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
        //redirect
    public function redirect(Request $request,$idchambre )
    {
        $chambre = Chambre::findOrFail($idchambre); 
        $heberg = Heberg::findOrFail($chambre->Hebergs_id);
        $politique_annulation=politique_annulation::where('Hebergs_id',$heberg->id)->first();

        $modePaiment=$request->mode_paiement;
    if($modePaiment=='a_larrivee'){

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
            'politiqueAnnulations_id'=>$politique_annulation->id,
        ]);
       
   

       

        $payment = ChargilyPayment::create([
            "users_id"  => $user->id,
            "reservations_id"=>$reservation->id,
            "status"   => "pending",
            "currency" => $currency,
            "amount"   => $amount,
        ]);

        $chambre->decrement('Quantite', 1);

           
       
        
        //$heberg->decrement('nombre_chambre', 1);

        // ✅ Récupérer client et hôte depuis la BDD
        $client = User::findOrFail($reservation->users_id);

        $hebergData = DB::table('chambres')
            ->join('Hebergs', 'chambres.Hebergs_id', '=', 'Hebergs.id')
            ->where('chambres.id', $chambre->id)
            ->select('Hebergs.users_id')
            ->first();
        $hote = User::findOrFail($hebergData->users_id);

        // Broadcast + notification
        broadcast(new faitreservation($client->name, " a été réserver chambre ", $chambre->typeChambres));
        $hote->notify(new Reservations("{$client->name} est réserver une chambre {$chambre->typeChambres}"));


       

       
       

           
        return redirect('/client/mesReservations')->with('succes',"la réservation a été effectuer maintenant avec succés ");

    }else{


   
       
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
            'politiqueAnnulations_id'=>$politique_annulation->id,
        ]);
       
   

       

        $payment = ChargilyPayment::create([
            "users_id"  => $user->id,
            "reservations_id"=>$reservation->id,
            "status"   => "pending",
            "currency" => $currency,
            "amount"   => $amount,
        ]);
    
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
               // "webhook_endpoint" => route("chargilypay.webhook_endpoint"),
                "webhook_endpoint" =>"https://seisable-prerectal-anisa.ngrok-free.dev/chargilypay/webhook",
               // "webhook_endpoint" => env('CHARGILY_WEBHOOK_URL', 'https://example.com/webhook'),
            ]);
        
            if ($checkout) {
                return redirect($checkout->getUrl());
            }
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

              // paiement terminé
            if ($checkout->getStatus() === "paid") {

                return redirect()->route('reservations.index')->with("succes","la réservation a été fais maintenant"); 
        
            }
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
             $checkout = $webhook->getData();
     
             if ($checkout && $checkout instanceof \Chargily\ChargilyPay\Elements\CheckoutElement) {
     
                 $metadata    = $checkout->getMetadata();
                 $payment     = ChargilyPayment::find($metadata['payment_id']);
     
                 if (!$payment) {
                     return response()->json(["status" => false, "message" => "Payment not found"], 404);
                 }
     
                 $reservation = Reservation::find($payment->reservations_id);

                 //modiifre la réservation 
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

                    $chambre = Chambre::findOrFail($reservation->chambres_id);
                  
    
                    
    
                    // ✅ Récupérer client et hôte depuis la BDD
                    $client = User::findOrFail($reservation->users_id);
    
                    $hebergData = DB::table('chambres')
                        ->join('Hebergs', 'chambres.Hebergs_id', '=', 'Hebergs.id')
                        ->where('chambres.id', $chambre->id)
                        ->select('Hebergs.users_id')
                        ->first();
                    $hote = User::findOrFail($hebergData->users_id);
    
                    // Broadcast + notification
                    broadcast(new faitreservation($client->name, " est modifier la réservation chambre ", $chambre->typeChambres));
                    $hote->notify(new Reservations("{$client->name} est modifier la réservation chambre {$chambre->typeChambres}"));
    
                    return redirect()->route('reservations.index')->with("succes","la réservation a été modifier avec succes maintenant"); 
        
                }

     
                 if ($checkout->getStatus() === "paid") {
     
                     $payment->status = "paid";
                     $payment->save();
     
                     $chambre = Chambre::findOrFail($reservation->chambres_id);
                     $chambre->decrement('Quantite', 1);
     
                     
     
                     // ✅ Récupérer client et hôte depuis la BDD
                     $client = User::findOrFail($reservation->users_id);
     
                     $hebergData = DB::table('chambres')
                         ->join('Hebergs', 'chambres.Hebergs_id', '=', 'Hebergs.id')
                         ->where('chambres.id', $chambre->id)
                         ->select('Hebergs.users_id')
                         ->first();
                     $hote = User::findOrFail($hebergData->users_id);
     
                     // Broadcast + notification
                     broadcast(new faitreservation($client->name, " a été réserver chambre ", $chambre->typeChambres));
                     $hote->notify(new Reservations("{$client->name} est réserver une chambre {$chambre->typeChambres}"));
     
                     return response()->json(["status" => true, "message" => "Payment completed"]);
     
                 } elseif (in_array($checkout->getStatus(), ["failed", "canceled"])) {
     
                     $payment->status = "failed";
                     $payment->save();
     
                     return response()->json(["status" => true, "message" => "Payment canceled"]);
                 }
             }
         }
     
         return response()->json(["status" => false, "message" => "Invalid Webhook"], 403);
     }
    
    /**
     * Just a shortcut
     */
    protected function chargilyPayInstance()
    {
        return new \Chargily\ChargilyPay\ChargilyPay(new \Chargily\ChargilyPay\Auth\Credentials([
            "mode" => "test",
            
            "public" => "test_pk_DDaTN2LMDMCZPce19KZDsqXHHjoBOV8VRKnnmzNf",
            "secret" => "test_sk_kfkckbGdhEjoYvwdu9oRGfKajsWRaLN0pbd9MiBb",
        ]));
    }
}