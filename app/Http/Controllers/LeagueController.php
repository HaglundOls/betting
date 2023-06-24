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
        $upcomingGames = Game::where('liga_id', $league->id)->whereNull('match_klar')->where('start_datum', '>=', date('Y-m-d'))->orderBy('start_datum', 'asc')->take(5)->get();
        $sport = $league::where('id', $league->id)->value('sport');
        $leagueArray = League::where('id', $league->id)->get()->toArray()[0];
        $forge = new RapidApi();

        if (count($upcomingGames) < 4) {
            if ($sport == 'soccer') {
                $matchRequest = new SoccerNextMatches($leagueArray['id'], $leagueArray['säsong_id']);
                $matchResponse = $forge->send($matchRequest);
            } elseif ($sport == 'hockey') {
                $leagueArray = League::where('id', $league->id)->get()->toArray()[0];
                $forge = new RapidApi();
                $matchRequest = new HockeyNextMatches($leagueArray['id'], $leagueArray['säsong_id']);
                $matchResponse = $forge->send($matchRequest);
            }

            if ($matchResponse->body()) {
                $leagueData = $matchResponse->json()['events'];
                // dd($leagueData);

                foreach ($leagueData as $item) {
                    Game::updateOrCreate(
                        ['match_id' => $item['id']],
                        ['hemma_lag' => $item['homeTeam']['name'], 'borta_lag' => $item['awayTeam']['name'], 'liga_id' => $item['tournament']['uniqueTournament']['id'], 'start_datum' => gmdate("Y-m-d", $item['startTimestamp']), 'start_tid' => gmdate("H:i:s", $item['startTimestamp'])]
                    );
                }
            }
            $upcomingGames = Game::where('liga_id', $league->id)->whereNull('match_klar')->where('start_datum', '>=', date('Y-m-d'))->orderBy('start_datum', 'asc')->take(5)->get();
        }




        $lastGame = Game::where('liga_id', $league->id)->where('start_datum', '<', date('Y-m-d'))->orderBy('start_datum', 'desc')->take(1)->get();
        // dd($matchResponse->json()['events']);
        // dd($lastGame[0]['start_datum']);

        $playedGames = Game::where('liga_id', $league->id)
            ->where('start_datum', '<', date('Y-m-d'))
            ->whereNull('match_klar')
            ->get()->toArray();
        // dd($playedGames);

            foreach($playedGames as $item){
                $game_id = $item['match_id'];
                $matchRequest = new SoccerMatch($game_id);
                $matchResponse = $forge->send($matchRequest);
                $data = ($matchResponse->json()['event']);
                Game::updateOrCreate(
                    ['match_id' => $data['id']],
                    ['hemma_poäng' => $data['homeScore']['current'], 'borta_poäng' => $data['awayScore']['current']]
                    // ['hemma_lag' => $item['homeTeam']['name'], 'borta_lag' => $item['awayTeam']['name'], 'liga_id' => $item['tournament']['uniqueTournament']['id'], 'start_datum' => gmdate("Y-m-d", $item['startTimestamp']), 'start_tid' => gmdate("H:i:s", $item['startTimestamp'])]
                );
            }

        // if (!empty($playedGames)) {
        //     // dd('hej');
        //     $page = 0;
        //     while (true) {
        //         $forge = new RapidApi();
        //         $leagueArray = League::where('id', $league->id)->get()->toArray()[0];
        //         $matchRequest = new HockeyNextMatches($leagueArray['id'], $leagueArray['säsong_id']);
        //         if ($matchResponse->body()) {
        //             $matchResponse = $forge->send($matchRequest);
        //             $data = $matchResponse->json()['events'];
        //             foreach ($data as $item) {
        //                 dd($item);
        //                 Game::updateOrCreate(
        //                     ['match_id' => $item['match_id']],
        //                     ['hemma_poäng' => $item['hemma_poäng'], 'borta_poäng' => $item['borta_poäng'], 'hemma_lag' => $item['hemmaLag'], 'borta_lag' => $item['bortaLag'], 'liga_id' => $item['ligaId'], 'start_datum' => $item['startDate'], 'start_tid' => $item['startTime'], 'match_klar' => 1]
        //                 );
        //             }
        //             if ($data->hasNextPage == false) {
        //                 break;
        //             }

        //         } else {
        //             break;
        //         }

        //         $page++;
        //     }
        // }


        // $upcomingGames = Game::where([
        //     ['liga_id', $league->id],
        //     ['match_klar', null]
        // ])->orderBy('start_datum', 'asc')->take(3)->get();


        if (count($upcomingGames) === 0) {
            return view('start', ['league' => $league, 'foundGames' => false]);
        }

        return view('start', ['league' => $league, 'leagueData' => $upcomingGames, 'foundGames' => true]);
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
