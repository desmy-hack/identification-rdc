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
/**
     * Handle an incoming authentication request.
        */

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();
        $roleHint = $request->input('role_hint');

        // 1. ADMIN : Toujours vers son dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // On retire intended()
        }

        // 2. AGENT : On respecte scrupuleusement son choix d'onglet
        if ($user->role === 'agent') {
            if ($roleHint === 'agent') {
                return redirect()->route('agent.dashboard');
            }
            // S'il a choisi citoyen ou rien, on l'envoie sur le dashboard citoyen
            return redirect()->route('dashboard');
        }

        // 3. CITOYEN : Toujours vers son dashboard
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
