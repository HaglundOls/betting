@include('header')
<div class="container">
    <div class="sportsUpper">
        <h2 id="sportsHeader">Populära ligor</h2>
        <div class="sportsBoxes">
            <div class="sportBox">
                <a href="{{ url('/league/261') }} ">SHL</a>
            </div>
            <div class="sportBox">
                <a href="{{ url('/league/7') }} ">Champions League</a>
            </div>
            <div class="sportBox">
                <h4>Allsvenskan</h4>
            </div>
            <div class="sportBox">
                <h4>NFL</h4>
            </div>
            <div class="sportBox">
                <h4>Premier League</h4>
            </div>
        </div>
    </div>

    @if (isset($countryData))
        <div class="leagueLinks">
            @foreach ($countryData as $item)
                <a href="{{url('/league') . '/' . $item['id']}}" class="leagueLink">{{$item['liga']}}</a>
            @endforeach
        </div>
    @endif

    @if (isset($league->upcomingGames) && $foundGames)
        {{-- <div class="betsBox"> --}}
        @foreach ($league->upcomingGames as $item)
            <div class="games">
                <div class="gamesInfo">
                    <div class="gamesUpper">
                        <h4>{{ $item->hemma_lag }}</h4>
                        <p> - </p>
                        <h4>{{ $item->borta_lag }}</h4>
                    </div>
                    <div class="gamesLower">
                        <p>{{ $item->start_datum }}</p>
                        <p>{{ $item->start_tid }}</p>
                    </div>
                </div>
                <form action="" method="post" class="bettingForm">
                    <input type="button" value="1">
                    <input type="button" value="2">
                </form>
            </div>
        @endforeach
        {{-- </div> --}}

    @endif
    @if (isset($foundGames))
        @if ($foundGames == false)
            <h2>Inga matcher</h2>
        @endif
    @endif
</div>
</body>

</html>
