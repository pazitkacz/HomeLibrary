<?php

namespace models;

class GameKeeper
{

    public function getGame(string $id): array
    {
        return Database::requestOne('
        SELECT `id`, `name`, `image`, `minPlayer`, `maxPlayer`, `description` 
        FROM `games` WHERE `id` = ?', array($id));
    }

    public function getAllGames(): array
    {
        return Database::requestAll('SELECT * FROM `games` ORDER BY `id` DESC');
    }

    public function saveGame(int|bool $id, array $game): void
    {
        if(!$id)
            Database::insert('games', $game);
        else
            Database::change('games', $game, 'WHERE `id` = ?', array($id));
    }

    public function deleteGame(int $id): void
    {
        Database::request('DELETE FROM `games` WHERE `id` = ?', array($id));
    }

}