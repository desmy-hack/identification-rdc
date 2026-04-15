<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'agent') {
            return redirect()->route('agent.dashboard');
        }
        return redirect()->route('dashboard'); 
    }
    return redirect()->route('login');
})->name('welcome');


Route::middleware('auth')->group(function () {
    
    // Gestion du Profil (Le "Sas de sécurité")
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');
});

Route::middleware(['auth', 'force.password'])->group(function () {

    Route::get('/dashboard', [CitizenController::class, 'index'])->name('dashboard');

 
    Route::get('/ma-carte', [CitizenController::class, 'showMyCard'])->name('citizen.my-card');
    Route::get('/card/{id}', [CitizenController::class, 'generateCard'])->name('citizen.card');


    Route::middleware(['agent'])->prefix('agent')->name('agent.')->group(function () {
        Route::get('/dashboard', [AgentController::class, 'index'])->name('dashboard');
        Route::get('/enrollement', [AgentController::class, 'create'])->name('create');
        Route::post('/enrollement', [AgentController::class, 'store'])->name('store');
    });

 
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/statistiques', [AdminController::class, 'stats'])->name('stats');
        Route::post('/promote', [AdminController::class, 'promote'])->name('promote');
    });
});

require __DIR__.'/auth.php';