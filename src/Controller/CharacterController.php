<?php

namespace App\Controller;

use App\Repository\CharacterRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
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
    public function index(Request $request): Response
    {
        $page = $request->query->get('page') ?: 1;
        $queryBuilder = $this->characterRepository->createAllCharactersQueryBuilder();
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));

        $pagerfanta->setMaxPerPage(10)
            ->setCurrentPage($page);

        return $this->render('character/index.html.twig', [
            'pager' => $pagerfanta,
            'has_previous_page' => !$pagerfanta->hasPreviousPage() ? 'disabled' : '',
            'has_next_page' => !$pagerfanta->hasNextPage() ? 'disabled' : ''
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
