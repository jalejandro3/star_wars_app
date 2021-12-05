<?php

namespace App\Service;

use App\Entity\Film;
use GuzzleHttp\Exception\GuzzleException;

interface FilmServiceInterface
{
    /**
     * @return array
     * @throws GuzzleException
     */
    public function getAllFilms(): array;

    /**
     * @param int $id Film id
     * @return Film|null
     * @throws GuzzleException
     */
    public function getFilmById(int $id): ?Film;
}
