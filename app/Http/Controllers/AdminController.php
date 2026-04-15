<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Citizen;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalCitizens = Citizen::count();
        $totalAgents = User::where('role', 'agent')->count();
        
        $agents = User::where('role', 'agent')->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('totalCitizens', 'totalAgents', 'agents'));
    }

    public function searchCitizen($nn) {
        $citizen = Citizen::where('national_id', $nn)->first();
        if($citizen) {
            return response()->json([
                'success' => true,
                'name' => $citizen->first_name . ' ' . $citizen->last_name,
                'info' => 'Né le ' . $citizen->birth_date . ' à ' . $citizen->birth_place
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function promote(Request $request)
    {
        $citizen = Citizen::where('national_id', $request->nn)->first();

        if (!$citizen) {
            return back()->with('error', 'Numéro National introuvable.');
        }

        $user = User::where('email', $citizen->email)->first();

        if (!$user) {
            return back()->with('error', 'Le citoyen existe mais aucun compte utilisateur n\'est lié à l\'adresse : ' . $citizen->email);
        }

        $user->role = 'agent';
        $user->save();

        return back()->with('success', "L'agent {$user->name} a été promu avec succès !");
    }
}