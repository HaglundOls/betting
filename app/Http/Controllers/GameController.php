<?php

namespace App\Http\Controllers;

use App\Http\Integrations\RapidApi\RapidApi;
use App\Http\Integrations\RapidApi\Requests\ChampionsLeagueNextMatches;
use App\Http\Integrations\RapidApi\Requests\HockeyCountries;
use App\Http\Integrations\RapidApi\Requests\SoccerCountries;
use App\Models\Country;
use App\Models\Game;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

function handleNextMatchesResponses($response)
{
    $array = [
        [
            "hemmaLag" => null,
            "bortaLag" => null,
            "matchId" => null,
            "ligaId" => null,
            "startDate" => null,
            "startTime" => null
        ]
    ];

    $index = 0;
    // dd($response);

    foreach ($response['events'] as $item) {
        $array[$index]['hemmaLag'] = $item['homeTeam']['name'];
        $array[$index]['bortaLag'] = $item['awayTeam']['name'];
        $array[$index]['matchId'] = $item['id'];
        $array[$index]['ligaId'] = $item['tournament']['uniqueTournament']['id'];
        $array[$index]['startDate'] = gmdate("Y-m-d", $item['startTimestamp']);
        $array[$index]['startTime'] = gmdate("H:i:s", $item['startTimestamp'] + 60 * 60);
        $index++;
    }
    foreach ($array as $item) {
        Game::updateOrCreate(
            ['match_id' => $item['matchId']],
            ['hemma_lag' => $item['hemmaLag'], 'borta_lag' => $item['bortaLag'], 'liga_id' => $item['ligaId'], 'start_datum' => $item['startDate'], 'start_tid' => $item['startTime']]
        );
    }
}


class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $countries = Country::all()->sortBy('name');
        return view('start', ['countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
