<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Formulaire de connexion (GET /login)
Route::get('/login', function () {
  $csrf = csrf_token();

  return <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h2>Connexion</h2>
        <form method="POST" action="/login">
            <input type="hidden" name="_token" value="{$csrf}">
            <label>Email : <input type="email" name="email" /></label><br>
            <label>Mot de passe : <input type="password" name="password" /></label><br>
            <button type="submit">Se connecter</button>
        </form>
    </body>
    </html>
    HTML;
});

// Traitement de la connexion (POST /login)
Route::post('/login', function (Request $request) {
  $credentials = $request->only('email', 'password');

  if (Auth::attempt($credentials)) {
    $request->session()->regenerate();
    return redirect('/dashboard');
  }

  return back()->withErrors([
    'email' => 'Identifiants invalides.',
  ]);
});

// Page dashboard protégée (GET /dashboard)
Route::get('/dashboard', function () {
  $user = Auth::user();
  $csrf = csrf_token();

  return <<<HTML
    <!DOCTYPE html>
    <html>
    <head><meta charset="UTF-8"><title>Dashboard</title></head>
    <body>
        <h1>Bienvenue, {$user->name} !</h1>
        <form method="POST" action="/logout">
            <input type="hidden" name="_token" value="{$csrf}">
            <button type="submit">Se déconnecter</button>
        </form>
    </body>
    </html>
    HTML;
})->middleware('auth');

// Déconnexion (POST /logout)
Route::post('/logout', function (Request $request) {
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();

  return redirect('/login');
});

// API pour voir l'utilisateur connecté (GET /me)
Route::get('/me', function (Request $request) {
  return $request->user()
    ? response()->json($request->user())
    : response()->json(['message' => 'Non authentifié'], 401);
});

// Catch-all pour ton frontend Vue
Route::get('/{any}', function () {
  return view('test');
})->where('any', '.*');
