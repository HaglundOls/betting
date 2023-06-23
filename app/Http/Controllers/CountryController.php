<?php

namespace App\Http\Controllers;

use App\Http\Integrations\RapidApi\RapidApi;
use App\Http\Integrations\RapidApi\Requests\HockeyLeagues;
use App\Http\Integrations\RapidApi\Requests\HockeySeasons;
use App\Models\Country;
use App\Models\League;
use Illuminate\Http\Request;

class CountryController extends Controller
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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country, $country_id, $sport)
    {
        $leagueData = League::where('country_id', $country_id)->where('sport', $sport)->get();
        if($sport=='soccer'){
            $sportId = Country::Where('id', $country_id)->value('soccer_id');
        }
        else{
            $sportId = Country::Where('id', $country_id)->value('hockey_id');
        }
        if (count($leagueData) === 0) {
            $forge = new RapidApi();
            $leagueRequest = new HockeyLeagues($sportId);
            $leagueResponse = $forge->send($leagueRequest)->json();
            foreach ($leagueResponse['groups'][0]['uniqueTournaments'] as $d) {
                $seasonRequest = new HockeySeasons($d['id']);
                $seasonData = ($forge->send($seasonRequest))->json();
                // dd($seasonData);
                if (isset($seasonData['seasons'])) {
                    League::updateOrCreate(
                        ['id' => $d['id']],
                        ['liga' => $d['name'], 'säsong' => $seasonData['seasons'][0]['name'], 'säsong_id' => $seasonData['seasons'][0]['id'], 'country_id' => $country_id, 'sport' => $sport]
                    );
                }
            }
        }
        //fixa så att den bara tar ligor för vald sport
        $leagueData = League::where([
            ['sport', $sport],
            ['country_id', $country_id]
        ])->get();

        // $forge = new RapidApi();
        // foreach ($leagueData as $t) {
        //     $leagueRequest = new HockeyLeagues($t->hockey_id);
        //     $leagueResponse = $forge->send($leagueRequest);
        //     $leagueData = $leagueResponse->json();
        //     if(isset($leagueData['groups'])){
        //         foreach($leagueData['groups'][0]['uniqueTournaments'] as $d){
        //             $seasonRequest = new HockeySeasons($d['id']);
        //             $seasonData = ($forge->send($seasonRequest))->json();
        //             // dd($seasonData);
        //             if(isset($seasonData['seasons'])){
        //                 League::updateOrCreate(
        //                     ['id' => $d['id']],
        //                     ['liga' => $d['name'], 'säsong' => $seasonData['seasons'][0]['name'], 'säsong_id' => $seasonData['seasons'][0]['id'], 'country_id' => $t->hockey_id]
        //                 );
        //             }

        //         }
        //     }

        // }
        // dd('hej');
        return view('start', ['countryData' => $leagueData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
