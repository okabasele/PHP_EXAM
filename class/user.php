<?php
// Classe qui contient des fonctions statiques qui s'occupe des utilisateurs (création, vérification, erreur)
class User extends Controller
{

    //Ajouter un utlisateur dans la base de données (REGISTER)
    public static function addUserInDatabase(mysqli $connect, string $username, string $password, string $password2, string $email, string $token, string $status): int
    {
        //Verifier si l'utilisateur n'est pas déja dans la BDD
        if (self::checkUsername($connect, $username, $password)) //Username deja utilisé
        {
            return -1;
        } else if (self::checkEmail($connect, $email)) //Email deja utilisé
        {
            return -2;
        }

        //On verifie les entrées utilisateurs
        if (!self::isEmailValid($email)) //adresse email invalide
        {
            return -3;
        } else if (!self::passwordMatch($password, $password2)) //mot de passe incorrect
        {
            return -4;
        }

        //On ajoute l'utilisateur
        //Crypté le mot de passe avant de le stocker
        $password = password_hash($password, PASSWORD_BCRYPT);
        //Ajouter l'utilisateur dans la BDD
        self::insertData($connect, "users", "username=?,password=?,email=?,token=?,status=?", [$username, $password, $email, $token, $status]);
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

    //Changer les données de l'utilisateur
    public static function updateAccount(mysqli $connect, string $username, string $email, string $prevPassword, string $newPassword, string $confPassword, string $tokenUser): int
    {
        $user = User::getUserByToken($connect, $tokenUser);
        $changed = 0;
        //Si l'utilisateur change l'adresse mail
        if (isset($email) && !empty($email)) {
            if ($email != $user["email"]) {
                if (!self::isEmailValid($email)) { //adresse email invalide

                    return -1;
                } else {

                    self::updateData($connect, "users", "email='$email' WHERE token ='$tokenUser'");
                    $changed++;
                }
            }
        }
        //changer de mot de passe
        if (isset($prevPassword) && !empty($prevPassword) && isset($newPassword) && !empty($newPassword) && isset($confPassword) && !empty($confPassword)) {
            if (!self::passwordMatch($prevPassword, $newPassword)) { //pas entre la meme chose

                if (!self::checkPasswordByUserToken($connect, $tokenUser, $prevPassword)) { //current password pas valide
                    return -2;
                } elseif (!self::passwordMatch($newPassword, $confPassword)) { //nouveau mot de passe incorrect
                    return -3;
                } else {
                    //Crypté le mot de passe avant de le stocker
                    $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                    self::updateData($connect, "users", "password='$newPassword' WHERE token ='$tokenUser'");
                    $changed++;
                }
            }
        }
        //changer username
        if (isset($username) && !empty($username)) {
            if ($username != $user["username"]) {
                self::updateData($connect, "users", "username='$username' WHERE token ='$tokenUser'");
                $changed++;
            }
        }
        return $changed;
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
    //Verifie si le mot de passe entré est le même que celui stocké dans la BDD	
    static function checkPasswordByUserToken(mysqli $connect, string $token, string $passwordToCheck): bool
    {
        if ($res = self::fetchData($connect, "password", "users", "WHERE token=?", [$token])) {
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

    //Verifier les entrées utilisateurs

    //Verifier si le mot de passe et la confirmation du mot de passe sont égaux
    static function passwordMatch(string $password1, string $password2): bool
    {
        if (strcmp($password1, $password2) == 0) {
            return true;
        }
        return false;
    }

    //Verifier si l'adresse mail entré est bien une adresse mail
    static function isEmailValid(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    static function getUserByToken(mysqli $connect, string $token): array|false
    {
        return self::fetchData($connect, "*", "users", "WHERE token=?", [$token]);
    }
    static function getUserByID(mysqli $connect, int $userID): array|false
    {
        return self::fetchData($connect, "*", "users", "WHERE idUsers=?", [$userID]);
    }
}
