<?php

namespace App\DataFixtures;

use App\Client\StarWarsClientInterface;
use App\Entity\Film;
use App\Repository\FilmRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use GuzzleHttp\Exception\GuzzleException;

class FilmFixtures extends Fixture
{
    /**
     * @var FilmRepository
     */
    private FilmRepository $filmRepository;

    /**
     * @var StarWarsClientInterface
     */
    private StarWarsClientInterface $starWarsClient;

    /**
     * @param FilmRepository $filmRepository
     * @param StarWarsClientInterface $starWarsClient
     */
    public function __construct(
        FilmRepository $filmRepository,
        StarWarsClientInterface $starWarsClient
    )
    {
        $this->filmRepository = $filmRepository;
        $this->starWarsClient = $starWarsClient;
    }

    /**
     * @throws GuzzleException
     */
    public function load(ObjectManager $manager): void
    {
        $films = $this->filmRepository->findAll();

        if (count($films) === 0) {
            $apiFilms = $this->starWarsClient->exec('films', 'GET')->results;

            foreach ($apiFilms as $apiFilm) {
                $newFilm = new Film();
                $newFilm->setTitle($apiFilm->title)
                    ->setDirector($apiFilm->director)
                    ->setReleaseDate($apiFilm->release_date);

                $manager->persist($newFilm);
                $manager->flush();
            }
        }
    }
}
