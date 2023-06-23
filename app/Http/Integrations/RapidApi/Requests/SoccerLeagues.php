<?php

namespace App\Http\Integrations\RapidApi\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SoccerLeagues extends Request
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
        return '/example';
    }
}
