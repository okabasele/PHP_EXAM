<?php
class Categorie extends Controller
{
    static function insertArticleIdIntoCategorie(int $artID) : void
    {

    }
    static function getAllArticlesByCategorieID(mysqli $connect, int $idCat): array|false
    {
        $articlesID = self::fetchData($connect, "idArticles", "categories", "WHERE id=?", [$idCat]);
        $articles = [];
        foreach ($articlesID["idArticles"] as $artID) {
            array_push($articles, self::fetchData($connect, "*", "articles", "WHERE idArticles=?", [$artID]));
        }
        if (sizeof($articles) > 0) {
            return $articles;
        }
        return false;
    }
}
