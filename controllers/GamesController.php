<?php

namespace controllers;

use controllers\Controller;
use dto\GameDto;
use models\GameKeeper;

class GamesController extends Controller
{
    protected GameDto $singleGame;
    protected array $multipleGames;
    function process(array $parameters): void
    {
        $gameKeeper = new GameKeeper();
        if (!empty($parameters[0]) && !empty($parameters[1]) == 'delete') {
            $gameKeeper->deleteGame($parameters[0]);
            $this->addMessage('Hra byla odstranena z knihovny.');
            $this->route('Games');
        }
        else if (!empty($parameters[0])) {
            $game = $gameKeeper->getGame($parameters[0]);
            if (!$game)
                $this->route('error');

            $this->singleGame = $game[0];
            $this->view = 'gameDetail';
        }
        else {
            $games = $gameKeeper->getAllGames();
            $this->multipleGames = $games;
            $this->view = 'Games';
        }
    }
}