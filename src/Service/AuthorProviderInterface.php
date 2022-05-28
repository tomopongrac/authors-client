<?php

namespace App\Service;

use App\Entity\Author;
use App\Representation\PaginatedAuthors;

interface AuthorProviderInterface
{
    public function getAuthors(?string $page = null): PaginatedAuthors;

    public function getAuthor(int $id): Author;

    public function createAuthor(Author $author, string $token = null): bool;

    public function deleteAuthor(int $id): bool;
}