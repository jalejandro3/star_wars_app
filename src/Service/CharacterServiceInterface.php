<?php

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;

interface CharacterServiceInterface
{
    /**
     * @param object $character
     * @return array
     * @throws GuzzleException
     */
    public function getSpecies(object $character): array;
}