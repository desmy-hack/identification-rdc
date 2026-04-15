<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

public function handle(Request $request, Closure $next, string $role): Response
{
    // On vérifie si l'utilisateur est connecté ET s'il a le bon rôle
    if (!$request->user() || $request->user()->role !== $role) {
        // Si ce n'est pas le bon rôle, on redirige (évite l'erreur 500)
        return redirect('/')->with('error', 'Accès non autorisé.');
    }

    return $next($request);
}

}
