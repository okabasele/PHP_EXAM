<?php
require_once 'class/database-connection.php';
require_once 'class/controller.php';
require_once 'class/util.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
session_start();

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
    var_dump($_POST);
    $editToken = $_POST["editToken"];
    echo $editToken;
    if ($_POST['edit'] === "send") {
        $edit = Controller::updateData($connect, "articles", "title=\"".$title."\",description=\"".$description."\",publicationDate=\"".$dateToAdd."\" WHERE token=\"".$editToken."\"");
        Util::redirect("http://localhost/php_exam/details.php?art=$editToken");
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <meta charset="utf-8">
</head>

<body>
    <h2>Edition</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Title: <input type="text" name="title" value="<?php echo $title ?>" required>
        <span class="error">* <?php echo $titleErr; ?></span>
        <br><br>
        Description: <textarea name="description" rows="20" cols="70"><?php echo $description ?></textarea>
        <br><br>
        <input type="hidden" name="editToken" value="<?php echo $editToken?>">
        <div>
            Categories:
            <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"] == "health") echo "checked"; ?> value="health">Health
            <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"] == "politics") echo "checked"; ?> value="politics">Politics
            <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"] == "environment") echo "checked"; ?> value="environment">Environment
            <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"] == "beauty") echo "checked"; ?> value="beauty">Beauty
            <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"] == "fashion") echo "checked"; ?> value="fashion">Fashion
            <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"] == "food") echo "checked"; ?> value="food">Food
            <span class="error">* <?php echo $categoriesErr; ?></span>
            <br><br>
        </div>
        <button name="edit" type="submit" value="send">Update</button>
    </form>
</body>

</html>