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
                ->setCategory($book['category'])
                ->setLanguage($book['language'])
                ->setSeries($book['series']);
            $out[] = $bookDto;
        }
        return $out;
    }

    public function saveBook(BookDto $book): BookDto
    {
        if(!$book->getId())
            Database::insertNew(
                table:'books',
                dto: $book
            );
        else {
            Database::changeFromObject(
                table: 'books',
                dto: $book,
                condition: $book->getVariableName('getId'),
                conditionParameter: $book->getId()
            );
        }
        return $book;
    }

    public function deleteBook(int $id): void
    {
        Database::request('DELETE FROM `books` WHERE `id` = ?', array($id));
    }
}