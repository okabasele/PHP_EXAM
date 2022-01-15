<?php
//Classe qui contient des fonctions statiques utilitaires
require_once "./class/database-connection.php";

class Util
{
    static ?DatabaseConnection $connection = null;

    static function getDatabaseConnection(): DatabaseConnection
    {
        //S'il n'y a pas de connection à la base de données on en crée une
        if (!self::$connection) {
            self::$connection = new DatabaseConnection('root', '', 'php_exam_db');
        }
        //Sinon on retourne la connection déjà existante (évite les connections/déconnection répétitive)
        return self::$connection;
    }

    static function generateToken(int $length): string
    {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

    static function redirect($url)
    {
        header('Location: ' . $url);
        die();
    }
}
