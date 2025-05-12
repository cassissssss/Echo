<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
</head>

<body>
  <h2>Connexion</h2>
  @if ($errors->has('email'))
  <p style="color: red;">{{ $errors->first('email') }}</p>
  @endif
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <label>Email : <input type="email" name="email" /></label><br>
    <label>Mot de passe : <input type="password" name="password" /></label><br>
    <button type="submit">Se connecter</button>
  </form>
</body>

</html>