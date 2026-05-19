<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\Chambre;
use App\Models\Heberg;
use Illuminate\Support\Facades\DB;

class checkReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-reservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(){
        //
        
        $now=Carbon::now();
        $reservations=Reservation::where('status','active')
        ->whereDate('date_fin','<=',$now)
        ->get();
       
     
        foreach($reservations as $reservation){
            $heberg = DB::table('chambres')
            ->join('Hebergs', 'chambres.Hebergs_id', '=', 'Hebergs.id')
            ->where('chambres.id', $reservation->chambres_id)
            ->select('Hebergs.id as heberg_id')
            ->first();
          
            $reservation->update([
                
                'status'=>"finished"
            ]);
            Chambre::where('id',$reservation->chambres_id)->increment('nombre_chambre',1);
            Heberg::where('id', $heberg->heberg_id)->increment('nombre_chambre',1);

          
         
        }
       
        
    }
}
