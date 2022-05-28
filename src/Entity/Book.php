<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Book
{
    public int $id;

    public string $title;

    /**
     * @SerializedName("release_date")
     */
    public \DateTime $releaseDate;

    public string $description;

    public string $isbn;

    public string $format;

    public int $numberOfPages;

    public ?Author $author;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle(string $title): Book
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate(): \DateTime
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     * @return Book
     */
    public function setReleaseDate(\DateTime $releaseDate): Book
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Book
     */
    public function setDescription(string $description): Book
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     * @return Book
     */
    public function setIsbn(string $isbn): Book
    {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return Book
     */
    public function setFormat(string $format): Book
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfPages(): int
    {
        return $this->numberOfPages;
    }

    /**
     * @param int $numberOfPages
     * @return Book
     */
    public function setNumberOfPages(int $numberOfPages): Book
    {
        $this->numberOfPages = $numberOfPages;
        return $this;
    }

    /**
     * @return Author|null
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * @param Author|null $author
     * @return Book
     */
    public function setAuthor(?Author $author): Book
    {
        $this->author = $author;
        return $this;
    }
}