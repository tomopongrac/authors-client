<?php

namespace App\Service;

use App\Entity\Book;

interface BookProviderInterface
{
    public function createBook(Book $book): bool;

    public function deleteBook(int $id): bool;
}