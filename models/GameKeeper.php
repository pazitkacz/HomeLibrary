<?php

namespace models;

use dto\GameDto;


class GameKeeper
{

    /**
     * @param string $id
     * @return GameDto[]
     * function returns one record from the table that meets the criteria (id)
     */
    public function getGame(string $id): array
    {
        return [new GameDto(Database::requestOne('SELECT * FROM `games` WHERE `id` = ?', array($id)))];
    }

    /**
     * @return array
     * function gets list of all items in the table
     */
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

    /**
     * @param GameDto $game
     * @return GameDto
     * @throws \Exception
     * function saves changes or inserts new row into table according to condition
     */
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

    /**
     * @param int $id
     * @return void
     * fucntion deletes row from the table
     */
    public function deleteGame(int $id): void
    {
        Database::request('DELETE FROM `games` WHERE `id` = ?', array($id));
    }

}