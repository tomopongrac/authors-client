<?php

namespace App\Controller;

use App\Entity\Author;
use App\Service\AuthorProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/authors/{id}", name="app_authors_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        return $this->render('authors/show.html.twig', [
            'author' => $this->authorProvider->getAuthor($id),
        ]);
    }

    /**
     * @Route("/authors/{id}", name="app_authors_delete", methods={"DELETE"})
     */
    public function delete(int $id, Request $request): Response
    {
        $submittedToken = $request->request->get('token');

        /** @var Author $author */
        $author = $this->authorProvider->getAuthor($id);
        if ($author->getBooks() && count($author->getBooks()) > 0) {
            $this->addFlash(
                'notice',
                'Author with book cannot be deleted!'
            );

            return $this->redirectToRoute('app_authors');
        }

        // 'delete-author' is the same value used in the template to generate the token
        if ($this->isCsrfTokenValid('delete-author', $submittedToken)) {
            $this->authorProvider->deleteAuthor($id);

            $this->addFlash(
                'notice',
                'Author was deleted!'
            );
            return $this->redirectToRoute('app_authors');
        }
    }
}
