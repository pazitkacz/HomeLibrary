<?php

namespace models;

use dto\BookDto;

class BookKeeper
{
    /**
     * @param string $id
     * @return BookDto[]
     * function returns one record from the table that meets the criteria (id)
     */
    public function getBook(string $id): array
    {
        return [new BookDto(Database::requestOne('SELECT * FROM `books` WHERE `id` = ?', array($id)))];
    }

    /**
     * @return array
     *  function gets list of all items in the table
     */
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

    /**
     * @param BookDto $book
     * @return BookDto
     * @throws \Exception
     *  function saves changes or inserts new row into table according to condition
     */
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

    /**
     * @param int $id
     * @return void
     * fucntion deletes row from the table
     */
    public function deleteBook(int $id): void
    {
        Database::request('DELETE FROM `books` WHERE `id` = ?', array($id));
    }
}