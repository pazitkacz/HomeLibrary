<?php

namespace controllers;

use controllers\Controller;
use dto\BookDto;
use models\BookKeeper;

class BookEditorController extends Controller
{
    /**
     * @var BookDto
     */
    public BookDto $bookDto;

    /**
     * @param array $parameters
     * @return void
     * @throws \Exception
     * function that enables change or adding new book into database, shows editor with filled or empty data according to URL
     */
    function process(array $parameters): void
    {
        $bookKeeper = new BookKeeper();
        $this->bookDto = new BookDto();
        if ($_POST){

            $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) : null;
            $title = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : null;
            $author = isset($_POST['author']) ? trim(htmlspecialchars($_POST['author'])) : null;
            $language = isset($_POST['language']) ? trim(htmlspecialchars($_POST['language'])) : null;
            $category = isset($_POST['category']) ? trim(htmlspecialchars($_POST['category'])) : null;
            $series = isset($_POST['series']) ? trim(htmlspecialchars($_POST['series'])) : null;
            $image = isset($_POST['image']) ? trim(htmlspecialchars($_POST['image'])) : null;
            $description = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : null;
            // Checking for valid path and existing of file
            if (strpos($image, '..') !== false || !preg_match('/^[a-zA-Z0-9_\-\/.]+$/', $image)) {
                $this->addMessage('Zadana neplatna adresa obrazku.');}
            if (!file_exists($image)) {
                $this->addMessage('Zadana neplatna adresa obrazku.');}

            $this->bookDto
                ->setId($id)
                ->setTitle($title])
                ->setAuthor($author)
                ->setLanguage($language)
                ->setCategory($category)
                ->setSeries($series)
                ->setImage($image)
                ->setDescription($description);

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