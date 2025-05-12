<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Formulaire de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

//Soumission du formulaire de connexion
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route protégée accessible que si l’utilisateur est connecté
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

// Catch-all pour frontend Vue
Route::get('/{any}', function () {
  return view('test');
})->where('any', '.*');
