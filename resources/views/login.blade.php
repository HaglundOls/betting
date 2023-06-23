<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BETTING</title>
    <link rel="stylesheet" href="{{ url('/css/betStart.css') }}">
    <link rel="stylesheet" href="{{ url('/css/betNavbar.css') }}">
    <link rel="stylesheet" href="{{ url('/css/login.css') }}">

    <script src="{{ url('/js/betScript.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container"
        style=" height:150px; display: flex; flex-direction:column; align-items:center; justify-content:space-between;">
        <h1 class="yellow">Vänligen logga in eller skapa ett konto</h1>

        <div class="loginButtons">
            <div class="loginButton">
                <a id="myBtn" class="openLogin" href="/auth/google">Logga in</a>
            </div>
            <div class="loginButton">
                <a id="myBtn" class="openLogin" href="/auth/google">Skapa konto</a>
            </div>
        </div>

    </div>
</body>

</html>
