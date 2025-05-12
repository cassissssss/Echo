<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <h1>Bienvenue, {{ Auth::user()->name }} !</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Se déconnecter</button>
    </form>
</body>

</html>