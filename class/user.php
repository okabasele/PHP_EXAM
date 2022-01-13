<?php
// Classe qui contient des fonctions statiques qui s'occupe des utilisateurs (création, vérification, erreur)
class User
{

    public static function addUserInDatabase(mysqli $connect, string $username, string $password, string $email, string $token): bool
    {
        //verifier si l'utilisateur n'est pas déja dans la BDD
        //ajouter user
        return false;
    }


    //Vérifie si l'utilisateur existe dans la base de données
    public static function isUserInDatabase(mysqli $connect, string $username, string $password, string $email): bool
    {
        //verifier mdp

        //verifier email

        //verifier username

        return false;
    }



    //Verifie si le mot de passe entré est le même que celui stocké dans la BDD	
    function checkPassword(mysqli $connect, string $username, string $passwordToCheck): bool
    {
        if ($res = Controller::fetchData($connect, "password", "users", "WHERE username=?", [$username])) {
            //On verifie qu'on a qu'un seul resultat rendu
            if (sizeof($res) == 1) {
                if (password_verify($passwordToCheck, $res["password"])) {
                    return true;
                }
            }
        }
        return false;
    }
}
