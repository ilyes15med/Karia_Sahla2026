<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use App\Models\reservation;
use Stringable;
use Carbon\Carbon;

class getMaReservationNow implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return "Récupère les réservations actuelles de l'utilisateur connecté. 
-'now','actuelle','en cours' => active
-'finished', 'terminé' => finished

Utilisez cet outil lorsque l'utilisateur demande ses réservations, 
ses réservations en cours ou finished et les détails de ses réservations.";
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        //
       
        //la réservation de heb ex:zianides
       
        $ReservationStatus=$request['status'];
       
     
       
        if($ReservationStatus){
            $User=auth()->user();
            $result=$User->reservations->where('status',$ReservationStatus)->get();


        }
        return $result;

    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
          
            
            'status'=>$schema->string()->required()->description('status de réservation active ou finished'),
        ];
    }
}
