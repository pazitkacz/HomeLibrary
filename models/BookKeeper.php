<?php

namespace models;

use dto\BookDto;

class BookKeeper
{
    public function getBook(string $id): array
    {
        return [new BookDto(Database::requestOne('SELECT * FROM `books` WHERE `id` = ?', array($id)))];
    }

    public function getAllBooks(): array
    {
        $out = [];
        foreach (Database::requestAll('SELECT * FROM `books` ORDER BY `id` DESC') as $book)
        {
            $bookDto = (new BookDto())
                ->setTitle($book['title'])
                ->setAuthor($book['author'])
                ->setId($book['id'])
                ->setImage($book['image'])
                ->setCategory($book['category'])
                ->setDescription($book['description'])
                ->setLanguage($book['language'])
                ->setSeries($book['series']);
            $out[] = $bookDto;
        }
        return $out;
    }

    public function saveBook(int|bool $id, array $book): void
    {
        if(!$id)
            Database::insert('books', $book);
        else
            Database::change('books', $book, 'WHERE `id` = ?', array($id));
    }

    public function deleteBook(int $id): void
    {
        Database::request('DELETE FROM `books` WHERE `id` = ?', array($id));
    }
}