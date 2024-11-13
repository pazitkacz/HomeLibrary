<?php

namespace models;

use Exception;
use InvalidArgumentException;
use PDO;
use ReflectionClass;
use ReflectionProperty;

class Database
{
    private static PDO $connection;
    private static array $settings = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,];

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
     * @return ?int
     */

    public static function insertNew(string $table, object $dto): ?int
    {
        $reflectionClass = new ReflectionClass($dto);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);

        $columns = [];
        $placeholders = [];
        $values = [];

        foreach ($properties as $property) {
            $columns[] = $property->getName();
            $placeholders[] = ':' . $property->getName();
            $values[$property->getName()] = $property->getValue($dto);
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(", ", $columns),
            implode(", ", $placeholders)
        );

        $stmt = self::$connection->prepare($sql);

        foreach ($values as $placeholder => $value) {
            $stmt->bindValue(":$placeholder", $value);
        }

        if ($stmt->execute()) {
            return self::getLastInsertId($table);
        } else {
            throw new Exception("Failed to insert DTO.");
        }
    }

    public static function changeFromObject(string $table, object $dto, string $condition, mixed $conditionParameter): bool {

        $reflectionClass = new ReflectionClass($dto);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);

        $setClauses = [];
        $values = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($dto);

            if ($propertyName === 'id') {
                continue;
            }

            $setClauses[] = "$propertyName = :$propertyName";
            $values[$propertyName] = $propertyValue;
        }

        $sql = "UPDATE " . $table . " SET " . implode(", ", $setClauses) . " WHERE " . $condition . " = :conditionParameter";

        $stmt = self::$connection->prepare($sql);
        $stmt->bindValue(":conditionParameter", $conditionParameter);
        foreach ($values as $placeholder => $value) {
            $stmt->bindValue(":$placeholder", $value);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function change(string $table, array $values, string $condition, int $parameters): bool
    {
        return self::request("UPDATE `$table` SET `" . implode('` = ?, `', array_keys($values)) .
            "` = ? " . $condition, array_merge(array_values($values), $parameters));
    }

    public static function getLastInsertId(string $table): ?int {
        $query = "SELECT `id` FROM `$table` ORDER BY `id` DESC LIMIT 1";
        $return = self::$connection->prepare($query);
        $return->execute();
        $data = $return->fetch(\PDO::FETCH_ASSOC);
        return (int)$data['id'];
    }

}