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

  <a href="/" style="
    display: inline-block;
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    border: 1px solid #333;
    background: none;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.2s;
  ">
    ← Retour à l'histoire
  </a>
</body>

</html>