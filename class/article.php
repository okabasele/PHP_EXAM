<?php
class Article extends Controller
{
    static function getAllArticles(mysqli $connect) : array|false
    {
        return self::fetchData($connect,"*","articles","");
    }
    static function getCategorieByArticleID(mysqli $connect,int $artID) :array|false
    {
        $categories = Categorie::getAllCategories($connect);
        if ($categories) {
            foreach ($categories as $cat) {
                foreach ($cat["articles"] as $article) {
                    if ($article["idArticles"] == $artID) {
                        return $cat;
                    }
                }
            }
        }
        return false;
    }
    static function getAllArticlesByUserID(mysqli $connect,int $userID) : array|false
    {
        return self::fetchData($connect,"*","articles","WHERE idUsers=?",[$userID]);
    }

    static function getArticleByToken($connect,$token) : array|false
    {
        return self::fetchData($connect, "*", "articles", "WHERE token=?", [$token]);
    }


    static function deleteArticleByToken($connect,$token) : array|false
    {
        return self::deleteData($connect, "*", "articles", "WHERE token=?", [$token]);
    }


}
