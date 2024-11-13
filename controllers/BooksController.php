<?php

namespace controllers;

use dto\BookDto;
use models\BookKeeper;

class BooksController extends Controller
{
    /**
     * @var BookDto
     */
    protected BookDto $singleBook;
    /**
     * @var array
     */
    protected array $multipleBooks;

    /**
     * @param array $parameters
     * @return void
     * function shows all of the requested books or detail of one according to URL
     */
    public function process(array $parameters): void
    {
        $bookKeeper = new BookKeeper();
        if (!empty($parameters[0]) && !empty($parameters[1]) == 'delete') {
            $bookKeeper->deleteBook($parameters[0]);
            $this->addMessage('Kniha byla odstranena z knihovny.');
            $this->route('Books');
        }
        else if (!empty($parameters[0])) {
            $book = $bookKeeper->getBook($parameters[0]);
            if (!$book)
                $this->route('error');

            $this->singleBook = $book[0];
            $this->view = 'bookDetail';
        }
        else {
            $books = $bookKeeper->getAllBooks();
            $this->multipleBooks = $books;
            $this->view = 'Books';
        }
    }
}