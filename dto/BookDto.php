<?php

namespace dto;

class BookDto
{
    private string $title;
    private string $author;
    private string $language;
    private int $id;
    private ?string $series;
    private string $category;
    private ?string $image;
    private ?string $description;

    /**
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        if ($data) {
            $this->title = $data['title'];
            $this->author = $data['author'];
            $this->language = $data['language'];
            $this->id = $data['id'];
            $this->series = $data['series'];
            $this->category = $data['category'];
            $this->image = $data['image'];
            $this->description = $data['description'];
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): BookDto
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): BookDto
    {
        $this->author = $author;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): BookDto
    {
        $this->language = $language;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): BookDto
    {
        $this->category = $category;
        return $this;
    }

    public function getSeries(): string
    {
        return $this->series;
    }

    public function setSeries(?string $series): BookDto
    {
        $this->series = $series;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): BookDto
    {
        $this->id = $id;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(?string $img): BookDto
    {
        $this->image = $img;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): BookDto
    {
        $this->description = $description;
        return $this;
    }
}