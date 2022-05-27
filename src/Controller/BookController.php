<?php

namespace App\Controller;

use App\Service\BookProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private BookProvider $bookProvider;

    public function __construct(BookProvider $bookProvider)
    {
        $this->bookProvider = $bookProvider;
    }

    /**
     * @Route("/books/{id}", name="app_books_delete", methods={"DELETE"})
     */
    public function delete(int $id, Request $request): Response
    {
        $submittedToken = $request->request->get('token');

        // 'delete-book' is the same value used in the template to generate the token
        if ($this->isCsrfTokenValid('delete-book', $submittedToken)) {
            $this->bookProvider->deleteBook($id);

            $this->addFlash(
                'notice',
                'Book was deleted!'
            );
            return $this->redirectToRoute('app_authors');
        }
    }
}
