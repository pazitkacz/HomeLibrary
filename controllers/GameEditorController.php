<?php

namespace controllers;

use controllers\Controller;
use dto\GameDto;
use models\GameKeeper;

class GameEditorController extends Controller
{
    /**
     * @var GameDto
     */
    public GameDto $gameDto;

    /**
     * @param array $parameters
     * @return void
     * @throws \Exception
     * function that enables change or adding new game into database, shows editor with filled or empty data according to URL
     */
    function process(array $parameters): void
    {
        $gameKeeper = new GameKeeper();
        $this->gameDto = new GameDto();
        if ($_POST){
            // Sanitize and validate input data
            $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) : null;
            $name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : null;
            $note = isset($_POST['note']) ? trim(htmlspecialchars($_POST['note'])) : null;
            $minPlayer = isset($_POST['minPlayer']) ? filter_var($_POST['minPlayer'], FILTER_VALIDATE_INT) : null;
            $maxPlayer = isset($_POST['maxPlayer']) ? filter_var($_POST['maxPlayer'], FILTER_VALIDATE_INT) : null;
            $image = isset($_POST['image']) ? trim(htmlspecialchars($_POST['image'])) : null;
            $description = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : null;
            // Checking for valid path and existing of file
            if (strpos($image, '..') !== false || !preg_match('/^[a-zA-Z0-9_\-\/.]+$/', $image)) {
                $this->addMessage('Zadana neplatna adresa obrazku.');}
            if (!file_exists($image)) {
                $this->addMessage('Zadana neplatna adresa obrazku.');}

            $this->gameDto
                ->setId($id)
                ->setName($name)
                ->setNote($note)
                ->setMinPlayer($minPlayer)
                ->setMaxPlayer($maxPlayer)
                ->setImage($image)
                ->setDescription($description);

            if (!$this->gameDto->isDataAvailable())
            {
                $this->addMessage('Nebyly zadane potrebne udaje.');
                return;
            }
            $gameKeeper->saveGame($this->gameDto);
            $this->addMessage('Hra byla vlozena do knihovny.');
            $this->route('books/' . $this->gameDto->getId());
        }
        else if (!empty($parameters[0])) {
            $loadedBook = $gameKeeper->getGame($parameters[0]);
            if ($loadedBook)
                $this->gameDto = $loadedBook[0];
            else
                $this->addMessage('Hra nebyla nalezena v knihovne.');
        }
        $this->view = 'gameEditor';
    }
}