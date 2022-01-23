<?php
require_once 'class/database-connection.php';
require_once 'class/controller.php';
require_once 'class/util.php';
require_once 'class/user.php';
require_once 'class/categorie.php';

require_once 'assets/css/style-details.php';
require_once 'class/article.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
session_start();

$currentUser = User::getUserByToken($connect,$_SESSION["token"]);
$idUser = $currentUser["idUsers"];

if(isset($_GET['art']) && !empty($_GET['art'])) {
   $get_token = htmlspecialchars($_GET['art']);
$article = Controller::fetchData($connect,"*","articles","WHERE token=?",[$get_token]);
// var_dump($article); //affiche les tableaux
if($article) {
    $titre = $article['title'];
    $contenu = $article['description'];
    $publicationDate = $article['publicationDate'];
    $idAuteur = $article['idUsers'];
   
 } else {
     //redirection acceuil
     Util::redirect("home.php");
    die('Cet article n\'existe pas !');
 }

} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

   if (isset($_POST["delete"]) && !empty($_POST["delete"]) ) {
      //supprime id article dans categorie
      $catArticle = Article::getCategorieByArticleID($connect, $article["idArticles"]);
      Categorie::deleteArticleIdFromCategorie($connect, $catArticle["id"], $article["idArticles"]);
      //supprimer article
      article::deleteArticleByToken($connect,$_POST["articleToken"]);
      //   Util::redirect("home.php");
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
   <div class="card">
 <h1><?php echo $titre ?></h1>
 <p><?php echo $contenu ?></p>
 <p><?php echo $publicationDate ?></p>
 <p><?php echo User::getUserByID($connect,$idAuteur)["username"]; ?></p>
 <p><?php 
 $cat = Article::getCategorieByArticleID($connect, $article["idArticles"]);
 if ($cat) {
   echo '<a href="categorie.php?cat=' . $cat["id"] . '">#' . $cat["name"] . '</a>';
}
 
 ?></p>
 

 <div style="display:flex; justify-content:center;">
 <?php
 if ($idUser == $idAuteur) {
    echo '<a style="margin-right:5px;" href="edit.php?edit='.$get_token.'"><button>Editer</button></a>';
    echo ' <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>
    <input type="hidden" name="articleToken" value="<?php echo $editToken?>">
       <button name="delete" class="buttondelete"  type="submit" value="delete">Delete</button>
    </form>';
 }
 ?>

 </div>
</body>
</html>
