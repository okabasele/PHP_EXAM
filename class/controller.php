<?php

//Classe qui s'occupe des manipulations de données dans la base de données

class Controller
{
    //Envoyer une requête
    public static function sendQuery(mysqli $connect, string $query, array $values = null): mysqli_result|bool
    {
        if (isset($values)) {
            $res = $connect->prepare($query);
            $res->execute($values);
            return $res->get_result();
        }
        return $connect->query($query);
    }

    //Insérer des données
    public static function insertData(mysqli $connect, string $table, string $conditions, array $values = null): bool
    {
        return self::sendQuery($connect, "INSERT INTO $table SET $conditions", $values);
    }

    //Récupérer des données
    public static function fetchData(mysqli $connect, string $data, string $table, string $conditions, array $values = null): array|false
    {

        $res = self::sendQuery($connect, "SELECT $data FROM $table $conditions", $values);
        if ($res->num_rows == 1) {
            return $res->fetch_assoc();
        } else if ($res->num_rows > 1) {
            return $res->fetch_all(MYSQLI_ASSOC);
        }

        return false;
    }
}
