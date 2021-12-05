<?php

namespace App\Service;

use App\Entity\Film;
use GuzzleHttp\Exception\GuzzleException;

interface FilmServiceInterface
{
    /**
     * @param int $id
     * @return Film|null
     * @throws GuzzleException
     */
    public function getFilmById(int $id): ?Film;
}