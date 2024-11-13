<?php

namespace models;

use dto\GameDto;

class GameKeeper
{

    public function getGame(string $id): array
    {
        return [new GameDto(Database::requestOne('SELECT * FROM `games` WHERE `id` = ?', array($id)))];
    }

    public function getAllGames(): array
    {
        $out = [];
        foreach (Database::requestAll('SELECT * FROM `games` ORDER BY `id` ASC') as $game)
        {
            $gameDto = (new GameDto())
                ->setName($game['name'])
                ->setId($game['id'])
                ->setImage($game['image'])
                ->setDescription($game['description'])
                ->setMaxPlayer($game['maxPlayer'])
                ->setMinPlayer($game['minPlayer']);
            $out[] = $gameDto;
        }
        return $out;
    }

    public function saveGame(GameDto $game): GameDto
    {
        if(!$game->getId())
            Database::insertNew(
                table:'games',
                dto: $game
            );
        else {
            Database::changeFromObject(
                table: 'games',
                dto: $game,
                condition: $game->getVariableName('getId'),
                conditionParameter: $game->getId()
            );
        }
        return $game;
    }

    public function deleteGame(int $id): void
    {
        Database::request('DELETE FROM `games` WHERE `id` = ?', array($id));
    }

}