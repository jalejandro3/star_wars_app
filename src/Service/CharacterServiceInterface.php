<?php

namespace App\Service;

use App\Entity\Film;
use GuzzleHttp\Exception\GuzzleException;

interface CharacterServiceInterface
{
    /**
     * @param object $character
     * @return array
     * @throws GuzzleException
     */
    public function getSpecies(object $character): array;

    /**
     * @param Film $film
     * @return void
     * @throws GuzzleException
     */
    public function importCharactersByFilm(Film $film);
}
