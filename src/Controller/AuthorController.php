<?php

namespace App\Controller;

use App\Service\AuthorProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private AuthorProvider $authorProvider;

    public function __construct(AuthorProvider $authorProvider)
    {
        $this->authorProvider = $authorProvider;
    }

    /**
     * @Route("/authors", name="app_authors")
     */
    public function index(): Response
    {
        return $this->render('authors/index.html.twig', [
            'paginatedAuthors' => $this->authorProvider->getAuthors(),
        ]);
    }
}
