<?php

namespace App\Controller;

use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @var CharacterRepository
     */
    private CharacterRepository $characterRepository;

    /**
     * @param CharacterRepository $characterRepository
     */
    public function __construct(CharacterRepository $characterRepository)
    {
        $this->characterRepository = $characterRepository;
    }

    #[Route('/character', name: 'character')]
    public function index(): Response
    {
        $characters = $this->characterRepository->findAll();

        return $this->render('character/index.html.twig', [
            'characters' => $characters,
        ]);
    }

    #[Route('/character/detail/{id}', name: 'character_detail')]
    public function detail(int $id): Response
    {
        $character = $this->characterRepository->findOneBy(['id' => $id]);

        return $this->render('character/detail.html.twig', [
            'character' => $character,
            'has_species' => count($character->getSpecies()) > 0
        ]);
    }
}
