<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//invité

Route::get('/', function () {
    return view('invité.front-end.home');
});
Route::get('/Hebergement', function () {
    return view('invité.front-end.HebShow');
});
Route::get('/Hebergements', function () {
    return view('invité.front-end.hébergements');
});


Route::get('/pro/dashboard', function () {
    return view('pro.dashboard');
})->middleware(['auth','verified'])->name('pro.dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth','verified'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/agent/dashboard', function () {
    return view('agent.dashboard');
})->middleware(['auth'])->name('agent.dashboard');

//client
Route::get('/client/espace', function () {
    return view('client.front-end.home');
})->middleware(['auth'])->name('client.space');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//require __DIR__.'/admin_auth.php';