<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Citizen; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // API Register (Pour l'Admin qui crée un Agent)
    public function register(Request $request)
    {
        $request->validate([
            'national_id' => 'required|exists:citizens,national_id', 
            'email'       => 'required|email|unique:users',          
            'password'    => 'required|min:8|confirmed',
            'role'        => 'required|in:admin,agent'
        ]);

        // On récupère le citoyen correspondant au National ID
        $citizen = Citizen::where('national_id', $request->national_id)->first();

        // VERIFICATION CRITIQUE : L'email saisi doit être celui du citoyen enrôlé
     
        if ($citizen->email !== $request->email) {
            return response()->json([
                'message' => 'Erreur : Cet email ne correspond pas à l\'adresse enregistrée pour ce National ID.'
            ], 403);
        }

        // Si tout est bon, on crée l'utilisateur (le compte de connexion)
        $user = User::create([
            'name'        => $citizen->first_name . ' ' . $citizen->last_name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'national_id' => $request->national_id,
            'role'        => $request->role,
        ]);

        return response()->json([
            'message' => 'Compte ' . $request->role . ' créé avec succès',
            'user'    => $user
        ], 201);
    }

    // API Login 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

      
        $token = $user->createToken('api-token', [$user->role])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // API Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}