<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        // Si l'utilisateur est connecté et que son flag est à 1
        if (Auth::check() && Auth::user()->must_change_password) {
            
            // On autorise UNIQUEMENT les routes de modification du profil
            // pour éviter de bloquer la page où il doit changer son mot de passe
            if (!$request->routeIs('profile.*') && !$request->is('logout')) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Pour votre première connexion, vous devez sécuriser votre compte.');
            }
        }

        return $next($request);
    }
}