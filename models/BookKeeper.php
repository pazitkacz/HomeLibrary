<?php

namespace models;

use dto\BookDto;

class BookKeeper
{
    public function getBook(string $id): array //todo prepsat stejne jako fci getALL
    {
        $out = [];
        foreach (Database::requestOne('SELECT * FROM `books` WHERE `id` = ?', array($id)) as $book)
            {
                $bookDto = (new BookDto())
                    ->setTitle($book['title'])
                    ->setAuthor($book['author']);
                //todo doplnit ostatni polozky z tabulky
                $out[] = $bookDto;
            }
        return $out;
    }

    public function getAllBooks(): array
    {
        $out = [];
        foreach (Database::requestAll('SELECT * FROM `books` ORDER BY `id` DESC') as $book)
        {
            $bookDto = (new BookDto())
                ->setTitle($book['title'])
                ->setAuthor($book['author']);//todo doplnit vsechny polozky z databaze a jeho setter

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