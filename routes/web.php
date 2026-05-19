<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HebergController;
use App\Http\Controllers\HebergHoteController;
use App\Http\Controllers\InvitehebergController;
use App\Http\Controllers\HebergClientController;
use App\Http\Controllers\ChargilyPayController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ratingController;
use App\Http\Controllers\AiAgentAssistant;
use App\Http\Controllers\StatistiqueController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Livewire\Chat;
use App\Livewire\Chatbot;



//invite

Route::get('/',[InvitehebergController::class,'index_Hebs_home'] )->name('invite');

Route::get('/hebergements',[InvitehebergController::class,'index_Hebs']);
Route::get('/hebergement/{id}',[InvitehebergController::class,'index_Heb']);

Route::get('/about-us',function(){
    return view('invité.front-end.about-us');
});

Route::get('/search',[InvitehebergController::class,'search']);
Route::get('/filter-hebergement',[InvitehebergController::class,'filter']);

//require __DIR__.'/invite.php';

//client

Route::post('chargilypay/redirect/{chambre}', [ChargilyPayController::class, "redirect"])->name("chargilypay.redirect");
Route::get('chargilypay/back', [ChargilyPayController::class, "back"])->name("chargilypay.back");
Route::post('chargilypay/webhook', [ChargilyPayController::class, "webhook"])->name("chargilypay.webhook_endpoint");

Route::middleware(['auth','verified'])->group(function () {

Route::get('/client/filter-heberg',[HebergClientController::class,'filter']);
Route::get('/client/search',[HebergClientController::class,'search']);

Route::get('/client/espace',[HebergClientController::class,'index_Hebs_home'])->name('client.space');

Route::get('/client/hebergements',[HebergClientController::class,'index_Hebs']);
Route::get('/client/Hebergement/{id}',[HebergClientController::class,'index_Heb']);
Route::get('/client/about-us',function(){
  return view('client.front-end.about-us');
});

Route::get('/client/message', function () {
    return view('client.front-end.message');
});
Route::get('/client/notification', function () {
    return view('client.front-end.Notification');
});
///client/reservation/Heb/{{ $heb->id }}/chambre->id}}
Route::get('/client/reservation/Heb/{idheb}/chambre/{idch}',[ReservationController::class,'added_reservation_show']);
Route::post('/client/reservation/Heb/{idheb}/chambre/{idch}',[ReservationController::class,'store_reservation'])->name("Reservation.update");
//modifier la réservation
Route::get('/client/reservation/{idreservation}/edit',[ReservationController::class,'edit_reservation_show']);

Route::post('chargilypay/edit/{reservation}',[ChargilyPayController::class,'store_edit_reservation'])->name("Reservation.update");

//Route::post('/client/reservation/{idreservation}/edit',[ReservationController::class,'store_edit_reservation'])->name("Reservation.update");
//anuller la réservation
Route::get('/client/reservation/{idreservation}/delete',[ReservationController::class,'delete_reservation'])->name('Reservation.delete');

//paiment
//Route::post('chargilypay/redirect/{chambre}',[ChargilyPayController::class, "store_edit_reservation"])->name("chargilypay.redirect");

///reservation


//Route::get('/client/search', function () {
  //  return view('client.front-end.search');
//});

Route::get('/client/reservation/Heb', function () {
    return view('client.front-end.Réservation.réserver');
});
//Reservation
Route::get('/client/mesReservations',[ReservationController::class,'Reservations_index'])->name('reservations.index');
Route::get('/reservation/{id}/ticket', [ReservationController::class,'downloadTicket'])
    ->name('reservation.ticket');
Route::get('/reservation/{id}/ticket', [ReservationController::class,'downloadTicket'])->name('reservation.ticket');
//evaluation
Route::post('/client/rating/heb/{id}',[ratingController::class,'store_rating'])->name('rating.added');
  //edit
Route::get('/client/rating/heb/{idh}/rating/{ideval}/edit',[ratingController::class,'show_edit_rating'])->name('update_rating.show');
Route::put('/client/rating/heb/{idh}/rating/{ideval}/edit',[ratingController::class,'store_edit_rating'])->name('update.rating');

  //delete evaluation
Route::get('/client/rating/heb/{idh}/rating/{ideval}/delete',[ratingController::class,'destroy_rating'])->name('rating.delete');
 //Ai assistant
/*
Route::get('/Ai-assistant', function(){
return view('client.front-end.Ai-agent.Assistant');
});

Route::post('/invoke-agent',[AiAgentAssistant::class,'invoke_agent']);
*/

Route::livewire('/Ai/assistant','ai-assistant.chat-ai');


});

//hote

Route::get('/hote/dashboard',[HebergHoteController::class,'indexHote'])->middleware(['auth','verified'])->name('hote.dashboard');

Route::get('/hote/Hebergement/{id}',[HebergHoteController::class,'show_demande'])->name('hebergement.show');

Route::get('/hote/dashboard/Heb',[HebergHoteController::class,'create']);

Route::post('/hote/dashboard/Heb',[HebergHoteController::class,'store'])->name('hebergement.store');

Route::get('/hote/Hebergement/{id}/edit',[HebergHoteController::class,'edit_demande'])->name('hebergement.edit');

Route::put('/hote/Hebergement/{id}',[HebergHoteController::class,'update_demande'])->name('hebergement.update');

Route::get('/hote/Hebergement/{id}/delete',[HebergHoteController::class,'destroy_demande'])->name('hebergement.delete');

Route::get('/hote/Hebs',[HebergHoteController::class,'index_Hebs']);

Route::get('/hote/MonHebergement/{id}',[HebergHoteController::class,'index_Hebergement'])->name('Heb.index');

Route::post('/hote/MonHebergement/{id}/chambre',[HebergHoteController::class,'chambre_added'])->name('chambre.added');
Route::get('/hote/MonHebergement/{idHeb}/chambre/{idC}/edit',[HebergHoteController::class,'form_update_show'])->name('forme-update.show');
Route::put('/hote/MonHebergement/{idHeb}/chambre/{idC}/edit',[HebergHoteController::class,'chambre_update'])->name('chambre.update');
Route::get('/hote/MonHebergement/{idHeb}/chambre/{idC}/delete',[HebergHoteController::class,'delete_chambre'])->name('chambre.delete');
//Reservations:
Route::get('/hote/mesReservations',[ReservationController::class,'hote_Reservations_index'])->name('reservations.index');
Route::get('/reservation/{id}/ticket', [ReservationController::class,'downloadTicket'])->name('reservation.ticket');

//statistique

Route::get('/hote/heb/{id}/statistique',[StatistiqueController::class,'statistique_heb']);

//admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth','verified'])->name('admin.dashboard');



//agent

Route::get('/agent/dashboard',[HebergController::class,'indexAgent'])->middleware(['auth'])->name('agent.dashboard');

//Demande refuser:
Route::get('/agent/dashboard/Demandes/refuse',
[HebergController::class,'Demande_refuse']  
)->middleware(['auth'])->name('demandes.refuse');

//demande valide:
Route::get('/agent/dashboard/Demandes/valide',
  [HebergController::class,'Demande_valide']  
)->middleware(['auth'])->name('demandes.valide');
Route::get('/agent/dashboard/Demandes/index/{id}',
  [HebergController::class,'index_Heb']  
)->middleware(['auth'])->name('demandes.affiche');


//demande a valide

Route::get('/agent/dashboard',[HebergController::class,'indexAgent'])->middleware(['auth'])->name('agent.dashboard');
Route::get('/agent/{name}/dashboard/Hebergs/{id}/accept',[HebergController::class,'confirme'])->middleware(['auth'])->name('heberge.edit');
Route::get('/agent/{name}/dashboard/Hebergs/{id}/refuse',[HebergController::class,'refuse'])->middleware(['auth'])->name('heberge.edit');
//show demande valider
Route::get('/agent/dashboard/Hebergs/{id}/show',[HebergController::class,'index_Heb_Valide'])->middleware(['auth']);

//client
//require __DIR__.'/client.php';
 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
    Route::get('chat/user/{idUser}',Chat::class);
    Route::get('chat',Chat::class)->name('chat');
  
});

require __DIR__.'/auth.php';

//require __DIR__.'/admin_auth.php';
