<?php

namespace App\Http\Integrations\RapidApi\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ChampionsLeagueNextMatches extends Request
{
    /**
     * Define the HTTP method
     *
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * Define the endpoint for the request
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/tournament/7/season/41897/matches/next/0';
    }
}
