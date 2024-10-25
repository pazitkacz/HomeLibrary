<?php

namespace dto;

class BookDto
{
    private string $title;
    private string $author;

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
}