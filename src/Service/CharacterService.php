<?php

namespace App\Service;

class CharacterService extends Service implements CharacterServiceInterface
{
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
}