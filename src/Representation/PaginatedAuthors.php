<?php

declare(strict_types=1);

namespace App\Representation;

use App\Entity\Author;

class PaginatedAuthors
{
    private int $totalPages;

    /**
     * @var Author[]
     */
    private array $items;

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     * @return PaginatedAuthors
     */
    public function setTotalPages(int $totalPages): PaginatedAuthors
    {
        $this->totalPages = $totalPages;
        return $this;
    }

    /**
     * @return Author[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Author[] $items
     * @return PaginatedAuthors
     */
    public function setItems(array $items): PaginatedAuthors
    {
        $this->items = $items;
        return $this;
    }
}