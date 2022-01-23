<?php
require_once 'class/database-connection.php';
require_once 'class/controller.php';
require_once 'class/util.php';
require_once 'class/user.php';
require_once 'class/article.php';
require_once 'class/categorie.php';
session_start();
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

if (isset($_SESSION["token"]) && !empty($_SESSION["token"]) && isset($_SESSION["logged-in"]) && $_SESSION["logged-in"]) {
    $user = User::getUserByToken($connect, $_SESSION["token"]);
    if (!$user) {
        Util::redirect("login.php");
    } else {
        //STYLE
        require_once 'assets/css/style-edit.php';
    }
} else {
    Util::redirect("login.php");
}

// define variables and set to empty values
$titleErr = "";
$title =  "";
$description = "";
$publish = "";
$dateToAdd =  date("Y-m-d H:i:s");
$categories = "";
$categoriesErr = "";
//quand on essaye d'aller sur la page
$modeEdition = 0;
if (isset($_GET["edit"]) && !empty($_GET["edit"])) {
    $modeEdition = 1;
    $editToken = htmlspecialchars($_GET["edit"]);
    $editArticle = Controller::fetchData($connect, "*", "articles", "WHERE token=?", [$editToken]);

    if ($editArticle) {
        $title = $editArticle['title'];
        $description = $editArticle['description'];

        //quand tu clique sur le boutton
    } else {
        die('Erreur :l\'article concerné n\'existe pas...');
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

    //VERIF INPUT
    if (empty($_POST["title"])) {
        $titleErr = "Name is required";
    } else {
        $title = Util::testInput($_POST["title"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $title)) {
            $titleErr = "Only letters and white space allowed";
        }
    }
    if (empty($_POST["description"])) {
        $description = "";
    } else {
        $description = Util::testInput($_POST["description"]);
    }
    if (empty($_POST["categories"])) {
        $categoriesErr = "Please select a categorie";
    } else {
        $categories = Util::testInput($_POST["categories"]);
    }

    //modifier l'article
    $editToken = $_POST["editToken"];
    if ($_POST['edit'] === "send") {
        $edit = Controller::updateData($connect, "articles", "title=\"" . $title . "\",description=\"" . $description . "\",publicationDate=\"" . $dateToAdd . "\" WHERE token=\"" . $editToken . "\"");
        $editArticle = Controller::fetchData($connect, "*", "articles", "WHERE token=?", [$editToken]);
        //supprimer id ancienne cat
        if (isset($_POST["prevCat"]) && !empty($_POST["prevCat"])) {
            $catArticle = Article::getCategorieByArticleID($connect, $editArticle["idArticles"]);
            Categorie::deleteArticleIdFromCategorie($connect, $catArticle["id"], $editArticle["idArticles"]);
        }
        //ajouter a nouvel cat
        Categorie::insertArticleIdIntoCategorie($connect, $categories, $editArticle["idArticles"]);
        Util::redirect("http://localhost/php_exam/details.php?art=$editToken");
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edition</title>
    <meta charset="utf-8">
</head>

<body>

    <h2>Edition</h2>
    <div class=card>
        <!-- <p><span class="error">* required field</span></p> -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Title: <input type="text" name="title" value="<?php echo $title ?>" required>
            <span class="error">* <?php echo $titleErr; ?></span>
            <br><br>
            Description: <textarea name="description" rows="20" cols="70"><?php echo $description ?></textarea>
            <br><br>
            <input type="hidden" name="editToken" value="<?php echo $editToken ?>">
            <div>
                Categories:
                <?php
                $catArticle = Article::getCategorieByArticleID($connect, $editArticle["idArticles"]);
                $arrayCat = Controller::fetchData($connect, "id,name", "categories", "");
                foreach ($arrayCat as $cat) {
                    if ($catArticle) {
                        if ($cat["name"] == $catArticle["name"]) {
                            echo '<input type="hidden" name="prevCat" value="' . $cat["id"] . '">';
                            echo '<input type="radio" name="categories" value="' . $cat["id"] . '" checked>' . ucfirst($cat["name"]);
                        } else {

                            echo '<input type="radio" name="categories" value="' . $cat["id"] . '">' . ucfirst($cat["name"]);
                        }
                    } else {
                        echo '<input type="radio" name="categories" value="' . $cat["id"] . '">' . ucfirst($cat["name"]);
                    }
                }
                ?>
            </div>
            <button name="edit" type="submit" value="send">Update</button>

        </form>
</body>

</html>