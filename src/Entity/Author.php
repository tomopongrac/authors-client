<?php

declare(strict_types=1);

namespace App\Entity;

class Author
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private \DateTime $birthday;

    private string $gender;

    private string $placeOfBirth;

    /**
     * @var Book[]
     */
    private ?array $books;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Author
     */
    public function setId(int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName(string $firstName): Author
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName(string $lastName): Author
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     * @return Author
     */
    public function setBirthday(\DateTime $birthday): Author
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Author
     */
    public function setGender(string $gender): Author
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string $placeOfBirth
     * @return Author
     */
    public function setPlaceOfBirth(string $placeOfBirth): Author
    {
        $this->placeOfBirth = $placeOfBirth;
        return $this;
    }

    /**
     * @return Book[]
     */
    public function getBooks(): ?array
    {
        return $this->books;
    }

    /**
     * @param Book[] $books
     * @return Author
     */
    public function setBooks(?array $books): Author
    {
        $this->books = $books;
        return $this;
    }
}