<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\BookFormType;
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
     * @Route("/books/new", name="app_books_new")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(BookFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $book = $form->getData();
            $this->bookProvider->createBook($book);

            $this->addFlash('success', 'Book Created!');

            return $this->redirectToRoute('app_authors');
        }

        return $this->render('books/new.html.twig', [
            'bookForm' => $form->createView()
        ]);
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
