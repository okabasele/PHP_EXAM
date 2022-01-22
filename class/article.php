<?php
class Article extends Controller
{
    static function getAllArticles(mysqli $connect) : array|false
    {
        return self::fetchData($connect,"*","articles","");
    }
    static function getCategorieByArticleID(mysqli $connect,int $artID) :array|false
    {
        return self::fetchData($connect,"*")
    }
    static function getAllArticlesByUserID(mysqli $connect,int $userID) : array|false
    {
        return self::fetchData($connect,"*","articles","WHERE idUsers=?",[$userID]);
    }
}
