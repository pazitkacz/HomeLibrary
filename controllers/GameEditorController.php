<?php //todo projit cely kontroler a zkontrolovat funkcnost

namespace controllers;

use controllers\Controller;
use dto\GameDto;
use models\GameKeeper;

class GameEditorController extends Controller
{
    public GameDto $gameDto;
    function process(array $parameters): void
    {
        $gameKeeper = new GameKeeper();
        $this->gameDto = new GameDto();
        if ($_POST){
            $this->gameDto
                ->setId($_POST['id'])
                ->setName($_POST['name'])
                ->setNote($_POST['note'])
                ->setMinPlayer($_POST['minPlayer'])
                ->setMaxPlayer($_POST['maxPlayer'])
                ->setImage($_POST['image'])
                ->setDescription($_POST['description']);

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