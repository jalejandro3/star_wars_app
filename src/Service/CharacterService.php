<?php

namespace App\Service;

use App\Client\StarWarsClientInterface;
use App\Entity\Character;
use App\Entity\Film;
use App\Repository\CharacterRepository;
use Doctrine\Persistence\ManagerRegistry;
use GuzzleHttp\Exception\GuzzleException;

class CharacterService extends Service implements CharacterServiceInterface
{
    /**
     * @var CharacterRepository
     */
    private CharacterRepository $characterRepository;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @param StarWarsClientInterface $starWarsClient
     * @param CharacterRepository $characterRepository
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(
        StarWarsClientInterface $starWarsClient,
        CharacterRepository $characterRepository,
        ManagerRegistry $managerRegistry
    )
    {
        parent::__construct($starWarsClient);
        $this->characterRepository = $characterRepository;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @inheritDoc
     */
    public function getSpecies(object $character): array
    {
        $species = [];

        foreach ($character->species as $speciesUrl) {
            $apiSpecies = $this->starWarsClient->execFullRequest($speciesUrl, 'GET');
            $species[] = $apiSpecies->name;
        }

        return $species;
    }

    /**
     * @inheritDoc
     */
    public function importCharactersByFilm(Film $film)
    {
        $entityManager = $this->managerRegistry->getManager();
        $apiFilms = $this->starWarsClient->exec("films/{$film->getId()}", 'GET');

        foreach ($apiFilms->characters as $characterUrl) {
            $apiCharacter = $this->starWarsClient->execFullRequest($characterUrl, 'GET');
            $species = $this->getSpecies($apiCharacter);
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
