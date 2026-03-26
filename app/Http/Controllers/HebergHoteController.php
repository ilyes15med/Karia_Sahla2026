<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HebergHoteController extends Controller
{
    //
    public function index_Hebs(){
        $Heb_valide= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->select('Hebergs.*','users.name as hote_name')
        ->get();

        return view('hote.Hebergements.mesHebs',compact('Heb_valide'));
    }
    public function index_Hebergement($idHeb){
        $heb= DB::table('Hebergs')
        ->join('users','Hebergs.users_id','=','users.id')
        ->where('Hebergs.status','valide')
        ->where('Hebergs.id',$idHeb)
        ->select('Hebergs.*','users.name as hote_name')
        ->first();

        return view('hote.Hebergements.showHeb',compact('heb'));





    }
}
