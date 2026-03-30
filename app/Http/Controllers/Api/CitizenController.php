<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; // Ici on prend User comme exemple "citizen"
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    // GET /api/citizens
    public function index()
    {
        return response()->json(User::all());
    }

    // GET /api/citizens/{id}
    public function show($id)
    {
        $citizen = User::find($id);
        if (!$citizen) {
            return response()->json(['message' => 'Citizen not found'], 404);
        }
        return response()->json($citizen);
    }

    // POST /api/citizens
    public function store(Request $request)
    {
        $citizen = User::create($request->only('name','email','password'));
        return response()->json($citizen, 201);
    }

    // PUT /api/citizens/{id}
    public function update(Request $request, $id)
    {
        $citizen = User::find($id);
        if (!$citizen) return response()->json(['message'=>'Citizen not found'],404);

        $citizen->update($request->only('name','email','password'));
        return response()->json($citizen);
    }

    // DELETE /api/citizens/{id}
    public function destroy($id)
    {
        $citizen = User::find($id);
        if (!$citizen) return response()->json(['message'=>'Citizen not found'],404);

        $citizen->delete();
        return response()->json(['message'=>'Citizen deleted']);
    }
}
