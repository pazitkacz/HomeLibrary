<?php

namespace controllers;

use controllers\Controller;
use dto\GameDto;
use models\GameKeeper;

class GamesController extends Controller
{
    /**
     * @var GameDto
     */
    protected GameDto $singleGame;
    /**
     * @var array
     */
    protected array $multipleGames;

    /**
     * @param array $parameters
     * @return void
     * function shows all of the requested games or detail of one according to URL
     */
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