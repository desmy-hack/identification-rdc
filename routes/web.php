<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Dashboard protégé
Route::get('/dashboard', function () {
    return "Connecté en tant que : " . Auth::user()->name;
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour login automatique
Route::get('/test-login/{id}', function ($id) {
    $user = App\Models\User::find($id);

    if (!$user) {
        return "Utilisateur non trouvé";
    }

    DB::table('sessions')->where('user_id', $user->id)->delete();

    // Connexion utilisateur
    Auth::login($user);

    // Nouvelle session sécurisée
    session()->regenerate();
    session()->save();

    return [
        'message' => "Utilisateur connecté : " . Auth::user()->name,
        'sessions' => DB::table('sessions')->get()
    ];
});

Route::get('/profile/{id}', function ($id) {
    $user = User::find($id);
    if (!$user) {
        abort(404, "Utilisateur non trouvé.");
    }
    return view('profile', ['user' => $user]);
})->middleware('auth');

// Auth routes
require __DIR__.'/auth.php';
