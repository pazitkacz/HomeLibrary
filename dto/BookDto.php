<?php

namespace dto;

class BookDto extends BaseDto
{
    private ?string $title = null;
    private ?string $author = null;
    private ?string $language = null;
    private ?int $id = null;
    private ?string $series = null;
    private ?string $category = null;
    private ?string $image = null;
    private ?string $description = null;

    /**
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        if ($data) {
            $this->title = $data['title'] ?? null;
            $this->author = $data['author'] ?? null;
            $this->language = $data['language'] ?? null;
            $this->id = $data['id'] ?? null;
            $this->series = $data['series'] ?? null;
            $this->category = $data['category'] ?? null;
            $this->image = $data['image'] ?? null;
            $this->description = $data['description'] ?? null;
        }
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): BookDto
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): BookDto
    {
        $this->author = $author;
        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): BookDto
    {
        $this->language = $language;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): BookDto
    {
        $this->category = $category;
        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(?string $series): BookDto
    {
        $this->series = $series;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): BookDto
    {
        $this->id = $id;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $img): BookDto
    {
        $this->image = $img;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): BookDto
    {
        $this->description = $description;
        return $this;
    }

    public function isDataAvailable(): bool {
        return ($this->category && $this->title && $this->author && $this->language);
    }
}