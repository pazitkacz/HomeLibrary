<?php

namespace models;

class Database
{
    private static PDO $connection;
    private static array $settings = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,];

    /*
     * metoda provede pripojeni do databaze, spojeni zustane otevrene pro vsechny dalsi kroky a dotazy
     */
    public static function connect(string $host, string $user, string $password, string $database): void
    {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO(
                "mysql:host=$host;dbname=$database",
                $user,
                $password,
                self::$settings);
        }
    }

    /*
     * metoda provede vypis vsech polozek z tabulky
     * @return array|bool
     */
    public static function requestAll(string $request, array $parameters = array()): array|bool
    {
        $return = self::$connection->prepare($request);
        $return->execute($parameters);
        return $return->fetchAll();

    }

    public static function requestOne(string $request, array $parameters = array()): array|bool
    {
        $return = self::$connection->prepare($request);
        $return->execute($parameters);
        return $return->fetch();
    }

    /*
     * obecny dotaz pro praci s daty, vraci pocet ovlivnenych radku
     * @return int
     */
    public static function request(string $request, array $parameters = array()): int
    {
        $return = self::$connection->prepare($request);
        $return->execute($parameters);
        return $return->rowCount();
    }

    /*
     * metoda vlozi novy zapis do tabulky
     * @return bool
     */
    public static function insert(string $table, array $parameters = array()): bool
    {
        return self::request("INSERT INTO `$table` (`" .
            implode('`, `', array_keys($parameters)) .
            "`) VALUES (" . str_repeat('?,', sizeOf($parameters) - 1) . "?)",
            array_values($parameters));

    }

    public static function change(string $table, array $values, string $condition, array $parameters = array()): bool
    {
        return self::request("UPDATE `$table` SET `" . implode('` = ?, `', array_keys($values)) .
            "` = ? " . $condition, array_merge(array_values($values), $parameters));
    }

}