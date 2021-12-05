<?php

namespace App\Service;

use App\Client\StarWarsClientInterface;
use App\Entity\Character;
use App\Entity\Film;
use App\Repository\CharacterRepository;
use App\Repository\FilmRepository;
use Doctrine\Persistence\ManagerRegistry;
use GuzzleHttp\Exception\GuzzleException;

class FilmService extends Service implements FilmServiceInterface
{
    /**
     * @var CharacterServiceInterface
     */
    private CharacterServiceInterface $characterService;

    /**
     * @var CharacterRepository
     */
    private CharacterRepository $characterRepository;

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
     * @param CharacterRepository $characterRepository
     * @param FilmRepository $filmRepository
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(
        StarWarsClientInterface $starWarsClient,
        CharacterServiceInterface $characterService,
        CharacterRepository $characterRepository,
        FilmRepository $filmRepository,
        ManagerRegistry $managerRegistry
    )
    {
        parent::__construct($starWarsClient);
        $this->characterService = $characterService;
        $this->characterRepository = $characterRepository;
        $this->filmRepository = $filmRepository;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @inheritDoc
     */
    public function getFilmById(int $id): ?Film
    {
        $film = $this->filmRepository->findOneBy(['id' => $id]);

        if ($film && $film->getCharacters()->count() === 0) {
            $this->importCharactersByFilm($film);
        }

        return $film;
    }

    /**
     * @param Film $film
     * @return void
     * @throws GuzzleException
     */
    private function importCharactersByFilm(Film $film)
    {
        $entityManager = $this->managerRegistry->getManager();
        $apiFilms = $this->starWarsClient->exec("films/{$film->getId()}", 'GET');

        foreach ($apiFilms->characters as $characterUrl) {
            $apiCharacter = $this->starWarsClient->execFullRequest($characterUrl, 'GET');
            $species = $this->characterService->getSpecies($apiCharacter);
            $character = $this->characterRepository->findOneBy(['name' => $apiCharacter->name]);

            if (!$character) {
                $newCharacter = new Character();
                $newCharacter->setName($apiCharacter->name)
                    ->setGender($apiCharacter->gender)
                    ->setSpecies($species);

                $entityManager->persist($newCharacter);
                $entityManager->flush();

                $character = $newCharacter;
            }

            $film->addCharacter($character);
        }
    }
}