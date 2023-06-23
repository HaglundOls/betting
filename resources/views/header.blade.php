<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BETTING</title>
    <link rel="stylesheet" href="{{ url('/css/betStart.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/betNavbar.css') }}">
    <script src="{{ url('/js/betScript.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <div class="navbar">
        <div class="navbarItems">
            <span style="" class="headerMenu" onclick="openNav()">&#9776; Meny</span>
        </div>
        <div class="navbarItems navMiddle">
            <a href="http://betting.degig.se/" class="headerTitle">Affe's betting</a>
        </div>
        <div class="navbarItems navbarCenter">
            <p>{{ Auth::user()->balance }} Coins</p>
        </div>

    </div>

    {{-- <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="close" onclick="closeModal()">&times;</span>
            <h2 class="modalTitle">Logga in eller skapa konto</h2>
            <form action="" method="post">
                <div class="formSection">
                    <label for="email">Mejl: </label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="formSection">
                    <label for="Username">Användarnamn: </label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="formSection">
                    <label for="password">Lösenord: </label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="formSec">
                    <input type="submit" id="loginButton" value="Logga in">
                </div>
            </form>
            <a href="" id="noAccountText">Har du inte ett konto? Klicka här för att skapa ett</a>
        </div>
    </div> --}}


    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <button onclick="showDropdown('hockeyDropdown')" class="dropbtn">Hockey</button>
        <div id="hockeyDropdown" class="dropdown-content">

            @foreach (App\Models\Country::allCountries() as $c)
                @if (isset($c->hockey_id))
                    <a href="{{ url('/country') . '/' . $c->id . '/sport' . '/' . 'hockey'}}">{{ $c->name }}</a>
                @endif
            @endforeach
        </div>

        <button onclick="showDropdown('fotbollDropdown')" class="dropbtn">Fotboll</button>
        <div id="fotbollDropdown" class="dropdown-content">
            @foreach (App\Models\Country::allCountries() as $c)
                @if (isset($c->soccer_id))
                    <a href="{{route('sport.show', [$c->id, 'soccer'])}}">{{$c->name}}</a>
                @endif
            @endforeach
        </div>
    </div>

    {{-- @foreach (App\Models\Country::allCountries() as $c)
            <a href="">{{$c->name}}</a>
        @endforeach --}}
    </div>
