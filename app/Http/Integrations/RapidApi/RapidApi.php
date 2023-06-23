<?php

namespace App\Http\Integrations\RapidApi;

use Saloon\Http\Connector;

class RapidApi extends Connector
{
    /**
     * The Base URL of the API
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return 'https://allsportsapi2.p.rapidapi.com/api';
    }

    /**
     * Default headers for every request
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'X-RapidAPI-Key' => 'c0a1783a8amsh9d9b4288b4a005dp1af8ffjsnab9f7af5b8d8',
            'X-RapidAPI-Host' => 'allsportsapi2.p.rapidapi.com'
        ];
    }

    /**
     * Default HTTP client options
     *
     * @return string[]
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}

// football categories
// footbal category tournaments

//england id: 1
//europe id : 1465
//champions league id: 7
//champions league säsong 22/23 id: 41897


