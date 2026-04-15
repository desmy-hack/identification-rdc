<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CitizenMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Si l'utilisateur n'est pas connecté, on le laisse aller vers /login 
        // sans appliquer la vérification du rôle "citizen".
        if (!Auth::check()) {
            return $next($request);
        }

        // 2. S'il est connecté et que c'est un citoyen, on le laisse passer.
        if (Auth::user()->role === 'citizen') {
            return $next($request);
        }

        // 3. S'il est connecté mais n'est PAS un citoyen (ex: c'est un agent ou admin),
        // on le redirige vers sa page respective pour éviter qu'il reste bloqué.
        $role = Auth::user()->role;
        return redirect()->route($role . '.dashboard')->with('error', 'Accès non autorisé.');
    }
}