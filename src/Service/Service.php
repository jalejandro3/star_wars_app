<?php

namespace App\Service;

use App\Client\StarWarsClientInterface;

abstract class Service
{
    /**
     * @var StarWarsClientInterface
     */
    protected StarWarsClientInterface $starWarsClient;

    /**
     * @param StarWarsClientInterface $starWarsClient
     */
    public function __construct(StarWarsClientInterface $starWarsClient)
    {
        $this->starWarsClient = $starWarsClient;
    }
}