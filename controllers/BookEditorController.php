<?php

namespace controllers;

use controllers\Controller;
use dto\BookDto;
use models\BookKeeper;

class BookEditorController extends Controller
{
    public BookDto $bookDto;
    function process(array $parameters): void
    {
        $bookKeeper = new BookKeeper();
        $this->bookDto = new BookDto();
        if ($_POST){
            $this->bookDto
                ->setId($_POST['id'])
                ->setTitle($_POST['title'])
                ->setAuthor($_POST['author'])
                ->setLanguage($_POST['language'])
                ->setCategory($_POST['category'])
                ->setSeries($_POST['series'])
                ->setImage($_POST['image'])
                ->setDescription($_POST['description']);

            if (!$this->bookDto->isDataAvailable())
            {
                $this->addMessage('Nebyly zadane potrebne udaje.');
                return;
            }
            $bookKeeper->saveBook($this->bookDto);
            $this->addMessage('Kniha byla vlozena do knihovny.');
            $this->route('books/' . $this->bookDto->getId());
        }
        else if (!empty($parameters[0])) {
            $loadedBook = $bookKeeper->getBook($parameters[0]);
            if ($loadedBook)
                $this->bookDto = $loadedBook[0];
            else
                $this->addMessage('Kniha nebyla nalezena v knihovne.');
        }
        $this->view = 'bookEditor';
    }
}