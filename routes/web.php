<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HebergController;
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


Route::get('/client/espace', function () {
    return view('client.front-end.home');
})->middleware(['auth'])->name('client.space');

Route::get('/client/hebergements',function(){
    return view('client.front-end.hébergements');
});
Route::get('/client/Hebergement',function(){
    return view('client.front-end.HebShow');
});
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

Route::get('/client/reservation/Heb', function () {
    return view('client.front-end.Réservation.réserver');
});


//hote

Route::get('/hote/dashboard', function () {
    return view('hote.dashboard');
})->middleware(['auth','verified'])->name('hote.dashboard');

Route::get('/hote/dashboard/showHeb', function () {
    return view('hote.HebShow');
});

Route::get('/hote/dashboard/Heb',[HebergController::class,'create']);

Route::post('/hote/dashboard/Heb',[HebergController::class,'store'])->name('hebergement.store');


//admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth','verified'])->name('admin.dashboard');



//agent

Route::get('/agent/dashboard',[HebergController::class,'indexAgent'])->middleware(['auth'])->name('agent.dashboard');


//client
//require __DIR__.'/client.php';


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//require __DIR__.'/admin_auth.php';