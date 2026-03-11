<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user();
    
    if ($user->role == 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($user->role == 'client') {
        return redirect()->route('client.space');
    }   
    if ($user->role == 'host') {
        return redirect()->route('host.dashboard');
    }
    
    if ($user->role == 'agent') {
        return redirect()->route('agent.dashboard');
    }
    if ($user->role == 'pro') {
        return redirect()->route('pro.dashboard');
    }
    return redirect()->route('dashboard');
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    
    
}