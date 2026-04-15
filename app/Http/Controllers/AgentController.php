<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Citizen; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function index()
    {
        $citizens = Citizen::with('user')->latest()->take(10)->get();
        $totalEnrolled = Citizen::count();
        $myEnrollements = Citizen::where('agent_id', Auth::id())->count();

        return view('agent.dashboard', compact('citizens', 'totalEnrolled', 'myEnrollements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'province' => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:users,email',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $tempPassword = Str::random(10);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => 'citizen',
            'must_change_password' => true, 
        ]);

        $nn = date('Y') . rand(100, 999) . str_pad($user->id, 4, '0', STR_PAD_LEFT);

        $user->citizenProfile()->create([
            'last_name'    => $request->last_name,
            'first_name'   => $request->first_name,
            'middle_name'  => $request->middle_name,
            'gender'       => $request->gender,
            'email'        => $request->email,
            'birth_date'   => $request->birth_date,
            'birth_place'  => $request->birth_place,
            'province'     => $request->province,
            'territory'    => $request->territory,
            'sector'       => $request->sector,
            'address'      => $request->address,
            'father_name'  => $request->father_name,
            'mother_name'  => $request->mother_name,
            'phone'        => $request->phone,
            
            'health_record_number'   => $request->health_record_number,
            'criminal_record_number' => $request->criminal_record_number,
            'social_security_number' => $request->social_security_number,
            'tax_id_number'          => $request->tax_id_number,
            'student_card_number'    => $request->student_card_number,
            'passport_number'        => $request->passport_number,

            'national_id'  => $nn,
            'photo'        => $photoPath,
            'agent_id'     => Auth::id(),
        ]);

        return redirect()->route('agent.dashboard')->with('success', "Enrôlement réussi ! NN: $nn | MOT DE PASSE : $tempPassword");
    }

    public function create()
    {
        return view('citizens.create');
    }
}