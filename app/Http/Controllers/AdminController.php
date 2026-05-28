<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


use App\Models\Heberg;
use App\Models\Reservation;
use App\Models\User;

class AdminController extends Controller
{
    //
    public function statistique(){

        $hebs=Heberg::count();
        $reservation=Reservation::count();
        $hote=User::where('role','hote')->count();
        $clients=User::where('role','client')->count();
        $agents=User::where('role','agent')->count();

        return view('admin.dashboard',compact('hebs','reservation','hote','clients','agents'));


    }
    public function registre_agent(){

        return view('admin.auth.register');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'max:255'],

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        event(new Registered($user));

       // Auth::login($user);
       //return redirect()->route('login');
       // return view('auth.login');
       return redirect()
       ->route('admin.dashboard')
       ->with('succes', 'Vous êtes inscrit an agent avec succès');
    }
    
}
