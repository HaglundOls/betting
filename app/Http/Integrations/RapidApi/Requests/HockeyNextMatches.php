<?php

namespace App\Http\Integrations\RapidApi\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class HockeyNextMatches extends Request
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
        return '/ice-hockey/tournament/'.$this->id.'/season/'.$this->season.'/matches/next/0';
    }

        public function __construct(
        protected int $id,
        protected int $season,

    ) { }
}
