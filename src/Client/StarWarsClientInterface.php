<?php

namespace App\Client;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

interface StarWarsClientInterface
{
    /**
     * Execute a Star Wars (https://swapi.dev/) request.
     *
     * @param string $request The Star Wars request endpoint.
     * @param string $requestType The Star Wars request type.
     * @return mixed
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function exec(string $request, string $requestType);

    /**
     * Execute a complete Star Wars url request.
     *
     * @param string $fullRequestUrl
     * @param string $requestType
     * @return mixed
     *
     * @throws Exception
     * @throws GuzzleException
     */
    public function execFullRequest(string $fullRequestUrl, string $requestType);
}