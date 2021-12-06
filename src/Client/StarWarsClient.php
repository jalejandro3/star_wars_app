<?php

namespace App\Client;

class StarWarsClient extends Client implements StarWarsClientInterface
{
    /**
     * @inheritDoc
     */
    public function exec(string $request, string $requestType, array $payload = null)
    {
        $this->verifyRequestType($requestType);
        $this->setBaseUrl('https://swapi.dev/api/');
        $this->setUrl($request);

        $response = $this->getClient()->request($requestType, $this->getUrl(), $this->getOptions());

        $this->setResponseHeaders($response->getHeaders());

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @inheritDoc
     */
    public function execFullRequest(string $fullRequestUrl, string $requestType)
    {
        $this->verifyRequestType($requestType);

        $response = $this->getClient()->request($requestType, $fullRequestUrl, $this->getOptions());

        $this->setResponseHeaders($response->getHeaders());

        return json_decode($response->getBody()->getContents());
    }
}
