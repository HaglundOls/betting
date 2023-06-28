<?php

namespace App\Http\Controllers;

use App\Http\Integrations\RapidApi\RapidApi;
use App\Http\Integrations\RapidApi\Requests\HockeyNextMatches;
use App\Http\Integrations\RapidApi\Requests\SoccerNextMatches;
use App\Http\Integrations\RapidApi\Requests\SoccerMatch;
use App\Models\League;
use App\Models\Game;
use Illuminate\Http\Request;

class LeagueController extends Controller
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
        return 'skapa';
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
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function show(League $league)
    {
        // $upcomingGames = Game::where('liga_id', $league->id)->whereNull('match_klar')->where('start_datum', '>=', date('Y-m-d'))->orderBy('start_datum', 'asc')->take(5)->get();
        $sport = League::where('id', $league->id)->value('sport');
        $leagueArray = League::where('id', $league->id)->get()->toArray();
        $leagueArray = $leagueArray[0];
        $forge = new RapidApi();


        if (count($league->upcomingGames()->get()) < 4) {   //if there are less than 4 games in the DB it will
            if ($sport == 'soccer') {                       //check the API for the upcoming games
                $matchRequest = new SoccerNextMatches($leagueArray['id'], $leagueArray['säsong_id']);
                $matchResponse = $forge->send($matchRequest);
            } elseif ($sport == 'hockey') {
                $leagueArray = League::where('id', $league->id)->get()->toArray()[0];
                $matchRequest = new HockeyNextMatches($leagueArray['id'], $leagueArray['säsong_id']);
                $matchResponse = $forge->send($matchRequest);
            }

            if ($matchResponse->body()) { //Check if the response has a body
                $leagueData = $matchResponse->json()['events'];
                foreach ($leagueData as $item) { //Every upcoming game will be stored in the DB
                    Game::updateOrCreate(
                        ['match_id' => $item['id']],
                        ['hemma_lag' => $item['homeTeam']['name'], 'borta_lag' => $item['awayTeam']['name'], 'liga_id' => $item['tournament']['uniqueTournament']['id'], 'start_datum' => gmdate("Y-m-d", $item['startTimestamp']), 'start_tid' => gmdate("H:i:s", $item['startTimestamp'])]
                    );
                }
            }
        }
        $upcomingGames = $league->upcomingGames()->get();
        $playedGames = $league->finishedGames($league->id);

        foreach ($playedGames as $item) {
            $game_id = $item['match_id'];
            $matchRequest = new SoccerMatch($game_id);
            $matchResponse = $forge->send($matchRequest);
            $data = ($matchResponse->json());
            $data = $data['event'];
            Game::updateOrCreate(
                ['match_id' => $data['id']],
                [
                    'hemma_poäng' => $data['homeScore']['current'] ?? null,
                    'borta_poäng' => $data['awayScore']['current']?? null,
                    'match_klar' => 1
                ]
            );
        }

        if (count($upcomingGames) === 0) {
            return view('start', ['league' => $league, 'foundGames' => false]);
        }
        else{
            return view('start', ['league' => $league, 'foundGames' => true]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function edit(League $league)
    {
        return "editera" . $league->id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, League $league)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\League  $league
     * @return \Illuminate\Http\Response
     */
    public function destroy(League $league)
    {
        //
    }
}
