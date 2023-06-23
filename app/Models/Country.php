<?php

namespace App\Models;

use App\Http\Integrations\RapidApi\RapidApi;
use App\Http\Integrations\RapidApi\Requests\HockeyLeagues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public $fillable = ['hockey_id', 'soccer_id', 'name'];

    public static function allCountries()
    {
        $allContries = Country::all()->sortBy('name');
        return $allContries;
    }
    public static function getAllHockeyLeagues()
    {
        return(Country::whereNotNull('hockey_id')->get());
    }
    public static function getLeagues($id)
    {
        $forge = new RapidApi();
        $request = new HockeyLeagues($id);

        $response = $forge->send($request);
        return(($response->json())['groups'][0]['uniqueTournaments']);
    }
}
