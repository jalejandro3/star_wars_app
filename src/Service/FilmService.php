<?php

namespace App\Service;

use App\Client\StarWarsClientInterface;
use App\Entity\Film;
use App\Repository\FilmRepository;
use Doctrine\Persistence\ManagerRegistry;

class FilmService extends Service implements FilmServiceInterface
{
    /**
     * @var CharacterServiceInterface
     */
    private CharacterServiceInterface $characterService;

    /**
     * @var FilmRepository
     */
    private FilmRepository $filmRepository;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @param StarWarsClientInterface $starWarsClient
     * @param CharacterServiceInterface $characterService
     * @param FilmRepository $filmRepository
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(
        StarWarsClientInterface $starWarsClient,
        CharacterServiceInterface $characterService,
        FilmRepository $filmRepository,
        ManagerRegistry $managerRegistry
    )
    {
        parent::__construct($starWarsClient);
        $this->characterService = $characterService;
        $this->filmRepository = $filmRepository;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @inheritDoc
     */
    public function getAllFilms(): array
    {
        $films = $this->filmRepository->findAll();

        if (empty($films)) {
            $films = [];
            $entityManager = $this->managerRegistry->getManager();
            $apiFilms = $this->starWarsClient->exec('films', 'GET')->results;

            foreach ($apiFilms as $apiFilm) {
                $newFilm = new Film();
                $newFilm->setTitle($apiFilm->title)
                    ->setDirector($apiFilm->director)
                    ->setReleaseDate($apiFilm->release_date);

                $entityManager->persist($newFilm);
                $entityManager->flush();

                $films[] = $newFilm;
            }
        }

        return $films;
    }

    /**
     * @inheritDoc
     */
    public function getFilmById(int $id): ?Film
    {
        $film = $this->filmRepository->findOneBy(['id' => $id]);

        if ($film && $film->getCharacters()->count() === 0) {
            $this->characterService->importCharactersByFilm($film);
        }

        return $film;
    }
}
