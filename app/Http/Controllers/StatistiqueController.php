<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Chambre;
use App\Models\ChargilyPayment;

class StatistiqueController extends Controller
{
    //
    public function statistique_heb($idheb){
        $hote=auth()->user();

        //heb de hote 
    if($hote){ 
        $hebergement = $hote->heb()
        ->where('id', $idheb)
        ->first();
        
        //chambre
        $chambres=$hebergement->chambres;

        //nombre de réservation de heb aujourdhuit :
       
        $Reservation_par_jour = Reservation::whereHas('chambre', function ($query) use ($hebergement) {
            $query->where('Hebergs_id', $hebergement->id);
        })->join('chambres', 'reservations.chambres_id', '=', 'chambres.id')
        ->whereDate('reservations.updated_at', Carbon::today())
        ->selectRaw('chambres.typeChambres as type, COUNT(reservations.id) as total')
        ->groupBy('type')
        ->get(); // get()retourner un objet et pluck est retourner une arraylist
     
       
       
        //nombrede réservations par semaine
        $debut_semaine=Carbon::now()->startOfWeek();
        $fin_semaine=Carbon::now()->endOfWeek();
        $reservation_par_semaine=Reservation::whereHas('chambre',function($query) use ($hebergement){
            $query->where('Hebergs_id', $hebergement->id);
        })
        ->whereBetween('updated_at',[$debut_semaine, $fin_semaine])
        ->selectRaw('DAYOFWEEK(updated_at) as day, COUNT(*) as total')
        ->groupBy('day')
        ->pluck('total', 'day');
        
        //transforme a day:
            $labels = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
            $data = [];
            
            for ($i = 1; $i <= 7; $i++) {
                $data[] = $reservation_par_semaine[$i] ?? 0;
            }

    //nombre revenue par semaine
    $revenue_par_semaine = ChargilyPayment::where('status', 'paid')
    ->whereHas('reservation.chambre', function ($query) use ($hebergement) {
        $query->where('Hebergs_id', $hebergement->id);
    })
    ->whereBetween('updated_at', [$debut_semaine, $fin_semaine])
    ->selectRaw('DAYOFWEEK(updated_at) as day, SUM(amount) as total')
    ->groupBy('day')
    ->pluck('total', 'day');
    
    //transforme a day:
       
        $dataRevenue = [];
        
        for ($i = 1; $i <= 7; $i++) {
            $dataRevenue[] = $revenue_par_semaine[$i] ?? 0;
        }

      

     
      
        //
        $todayRevenue = ChargilyPayment::where('status', 'paid')
        ->whereDate('created_at', Carbon::today())
        ->whereHas('reservation.chambre', function ($query) use ($hebergement) {
        $query->where('Hebergs_id', $hebergement->id);
        })->sum('amount');

     
        //dd($Reservation_par_jour);
        
        //dd($hebergement);
        return view('hote.Hebergements.statistique',compact('hebergement','Reservation_par_jour','chambres','todayRevenue','labels','data','dataRevenue','revenue_par_semaine'));
    }

    }
}
