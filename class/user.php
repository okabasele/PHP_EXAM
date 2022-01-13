<?php
// Classe qui contient des fonctions statiques qui s'occupe des utilisateurs (création, vérification, erreur)
class User extends Controller
{

    //Ajouter un utlisateur dans la base de données (REGISTER)
    public static function addUserInDatabase(mysqli $connect, string $username, string $password, string $email, string $token): int
    {
        //Verifier si l'utilisateur n'est pas déja dans la BDD
        if (self::checkUsername($connect, $username, $password)) //Username deja utilisé
        {
            return -1;
        } else if  (self::checkEmail($connect, $email)) //Email deja utilisé
        {
            return -2;
        }
        //Ajouter l'utilisateur
        self::insertData($connect, "users", "username=?,password=?,email=?,token=?", [$username, $password, $email, $token]);
        return 1;

    }


    //Vérifie si l'utilisateur existe dans la base de données (LOGIN)
    public static function isUserInDatabase(mysqli $connect, string $username, string $password): int
    {
        //On verifie que le mot de passe, le nom d'utilisateur entrés sont stockés dans la DBB
        
        if (!self::checkUsername($connect, $username)) //Nom utilisateur incorrect 
        {
            return -1;
        } else if (!self::checkPassword($connect, $username, $password)) //Mot de passe incorrect
        {
            return -2;
        }

        return 1;
    }


    static function passwordMatch(string $password, string $passwordConfirm)
    {
        # code...
    }

    //Verifie si le mot de passe entré est le même que celui stocké dans la BDD	
    static function checkPassword(mysqli $connect, string $username, string $passwordToCheck): bool
    {
        if ($res = self::fetchData($connect, "password", "users", "WHERE username=?", [$username])) {
            //On verifie qu'on a qu'un seul resultat rendu
            if (sizeof($res) == 1) {
                if (password_verify($passwordToCheck, $res["password"])) {
                    return true;
                }
            }
        }
        return false;
    }

    //Verifie si le nom d'utilisateur entré est déjà dans la BDD
    static function checkUsername(mysqli $connect, string $username): bool
    {
        if (self::fetchData($connect, "*", "users", "WHERE username=?", [$username])) {
            return true;
        }
        return false;
    }

    //Verifie si l'adresse mail entré est déjà dans la BDD
    static function checkEmail(mysqli $connect, string $email): bool
    {
        if (self::fetchData($connect, "*", "users", "WHERE email=?", [$email])) {
            return true;
        }
        return false;
    }
}
