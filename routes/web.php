<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HebergController;
use App\Http\Controllers\HebergHoteController;
use App\Http\Controllers\HebergClientController;
//invite

Route::get('/', function () {
    if (Auth::check()) {
        if(Auth::user()->role='client'){  
          return redirect('/client/espace');
        }
        if(Auth::user()->role='admin'){  
            return redirect('/admin/dashboard');
        }
          if(Auth::user()->role='hote'){  
            return redirect('/hote/dashboard');;
        }
    }
    return view('invité.front-end.home');
});
Route::get('/Hebergement', function () {
    return view('invité.front-end.HebShow');
});
Route::get('/Hebergements', function () {
    return view('invité.front-end.hébergements');
});


//require __DIR__.'/invite.php';

//client


Route::get('/client/espace',[HebergClientController::class,'index_Hebs_home'])->middleware(['auth'])->name('client.space');

Route::get('/client/hebergements',[HebergClientController::class,'index_Hebs']);
Route::get('/client/Hebergement/{id}',[HebergClientController::class,'index_Heb'])->middleware(['auth']);

Route::get('/client/message', function () {
    return view('client.front-end.message');
});
Route::get('/client/notification', function () {
    return view('client.front-end.Notification');
});

Route::get('/client/reservation', function () {
    return view('client.front-end.reservation');
});

Route::get('/client/search', function () {
    return view('client.front-end.search');
});
Route::get('/client/search',[HebergClientController::class,'search'])->middleware(['auth']);


Route::get('/filter-heberg',[HebergClientController::class,'filter']);
Route::get('/client/reservation/Heb', function () {
    return view('client.front-end.Réservation.réserver');
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

Route::get('/hote/MonHebergement/{id}',[HebergHoteController::class,'index_Hebergement']);

Route::post('/hote/MonHebergement/{id}/chambre',[HebergHoteController::class,'chambre_added'])->name('chambre.added');
Route::get('/hote/MonHebergement/{idHeb}/chambre/{idC}/edit',[HebergHoteController::class,'form_update_show'])->name('forme-update.show');
Route::put('/hote/MonHebergement/{idHeb}/chambre/{idC}/edit',[HebergHoteController::class,'chambre_update'])->name('chambre.update');
Route::get('/hote/MonHebergement/{idHeb}/chambre/{idC}/delete',[HebergHoteController::class,'delete_chambre'])->name('chambre.delete');


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
//client
//require __DIR__.'/client.php';


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//require __DIR__.'/admin_auth.php';