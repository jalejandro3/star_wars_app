<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use App\Service\FilmServiceInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @var FilmRepository
     */
    private FilmRepository $filmRepository;

    /**
     * @var FilmServiceInterface
     */
    private FilmServiceInterface $filmService;

    /**
     * @param FilmRepository $filmRepository
     * @param FilmServiceInterface $filmService
     */
    public function __construct(
        FilmRepository $filmRepository,
        FilmServiceInterface $filmService
    )
    {
        $this->filmRepository = $filmRepository;
        $this->filmService = $filmService;
    }

    #[Route('/film', name: 'film')]
    public function index(): Response
    {
        $films = $this->filmRepository->findAll();

        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    #[Route('/film/detail/{id}', name: 'film_detail')]
    public function detail(int $id): Response
    {
        $film = $this->filmService->getFilmById($id);

        return $this->render('film/detail.html.twig', [
            'film' => $film
        ]);
    }
}
