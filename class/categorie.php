<?php
class Categorie extends Controller
{
    static function getArticlesIDByCategorieID(mysqli $connect, int $idCat): string
    {
        $articlesID = self::fetchData($connect, "idArticles", "categories", "WHERE id=?", [$idCat]);
        if ($articlesID) {
            return $articlesID["idArticles"];
        }
        return "";
    }

    static function insertArticleIdIntoCategorie(mysqli $connect, int $idCat, int $artID): void
    {
        $articlesID = self::getArticlesIDByCategorieID($connect, $idCat);
        if (strlen($articlesID) == 0) {
            self::updateData($connect, "categories", "idArticles=? WHERE id=?", [$artID, $idCat]);
        } elseif (strlen($articlesID) > 0) {
            self::updateData($connect, "categories", "idArticles=? WHERE id=?", [$articlesID . "," . $artID, $idCat]);
        }
    }

    static function deleteArticleIdFromCategorie(mysqli $connect, int $idCat, int $artID):void
    {
        $categorie = self::getCategorieByID($connect,$idCat);
        if ($categorie) {
            $articlesID = explode(",",$categorie["article"]);
            foreach ($articlesID as $id) {
                if ($id==$artID) {
                    unset($id);
                }
            }
            $articlesID = implode(",",$articlesID);
            self::updateData($connect, "categories", "idArticles=? WHERE id=?", [$articlesID, $idCat]);
        }
    }
    static function getAllArticlesByCategorieID(mysqli $connect, int $idCat): array
    {
        $articlesID = self::getArticlesIDByCategorieID($connect, $idCat);
        $articles = [];
        if ($articlesID) {
            if (strlen($articlesID) == 1) {
                array_push($articles, self::fetchData($connect, "*", "articles", "WHERE idArticles=?", [$articlesID]));
            } elseif (strlen($articlesID) > 1) {
                $articlesID = explode(',', $articlesID);
                foreach ($articlesID as $artID) {
                    array_push($articles, self::fetchData($connect, "*", "articles", "WHERE idArticles=?", [$artID]));
                }
            }
        }

        return $articles;
    }




    static function getAllCategories(mysqli $connect): array|false
    {
        $categories = self::fetchData($connect, "*", "categories", "");
        if ($categories) {
            $allCat = [];
            $tmpCat = [];
            foreach ($categories as $cat) {
                $tmpCat["id"] = $cat["id"];
                $tmpCat["name"] = $cat["name"];
                $tmpCat["articles"] = self::getAllArticlesByCategorieID($connect, $cat["id"]);
                array_push($allCat, $tmpCat);
                $tmpCat = [];
            }
            return $allCat;
        }
        return false;
    }

    static function getCategorieByID(mysqli $connect, int $catID): array|false
    {
        $cat = self::fetchData($connect, "*", "categories", "WHERE id=?", [$catID]);
        if ($cat) {
            $arrayCat = [];
            $arrayCat["id"] = $cat["id"];
            $arrayCat["name"] = $cat["name"];
            $arrayCat["articles"] = self::getAllArticlesByCategorieID($connect, $catID);

            return $arrayCat;
        }
        return false;
    }
}
