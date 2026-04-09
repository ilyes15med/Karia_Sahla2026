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

class ChargilyPayController extends Controller
{
    /**
     * The client will be redirected to the ChargilyPay payment page
     *
     */
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

                    if ($payment) {
                        if ($checkout->getStatus() === "paid") {
                            //update payment status in database
                            $payment->status = "paid";
                            $payment->update();
                            /////
                            ///// Confirm your order
                            /////
                            //event
$user = auth()->user();

// جيب reservation الصحيح (مثلاً من payment)
$res = Reservation::findOrFail($payment->reservations_id);

// chambre
$chambre = Chambre::findOrFail($res->chambres_id);

// hebergement
$heb = Heberg::findOrFail($chambre->Hebergs_id);

// hote
$hote = User::findOrFail($heb->users_id);

// الاسماء
$hote_name = $hote->name;
$clientname = $user->name;

// broadcast event
broadcast(new faitreservation(" a été réserver maintenant ", $clientname, $payment));
$message="$clientname a été réserver maintenant ";

// notification
$hote->notify(new ReqHebNotification($message));
          
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
