<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CitizenController;


// --- ROUTES PUBLIQUES 
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-otp', [CitizenController::class, 'sendVerificationCode']);
Route::post('/confirm-identity', [CitizenController::class, 'confirmAndRegister']);

// --- ROUTES PROTÉGÉES 
Route::middleware('auth:sanctum')->group(function () {
    
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']);

    // Gestion des Citoyens (Accès Agents/Admins)
    Route::get('/citizens', [CitizenController::class, 'index']);
    Route::get('/citizens/{id}', [CitizenController::class, 'show']);
    Route::post('/citizens', [CitizenController::class, 'store']); // Enrôlement
    Route::delete('/citizens/{id}', [CitizenController::class, 'destroy']); // Réservé Admin normalement

    // Création de compte Agent/Admin (Réservé Admin)
    Route::post('/admin/register-staff', [AuthController::class, 'register']);
});

// Retourne les infos de l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});