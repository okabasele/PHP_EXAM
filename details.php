<?php
require_once 'class/database-connection.php';
require_once 'class/controller.php';
require_once 'class/util.php';
require_once 'class/user.php';
require_once 'assets/css/style-details.php';
require_once 'class/article.php';
require_once 'class/categorie.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
session_start();

$currentUser = User::getUserByToken($connect, $_SESSION["token"]);
$idUser = $currentUser["idUsers"];

if (isset($_GET['art']) && !empty($_GET['art'])) {
   $get_token = htmlspecialchars($_GET['art']);
   $article = Controller::fetchData($connect, "*", "articles", "WHERE token=?", [$get_token]);
   // var_dump($article); //affiche les tableaux
   if ($article) {
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
   var_dump($_POST);
   $article = Article::getArticleByToken($connect,$_POST["articleToken"]);
   if (isset($_POST["del"]) && $_POST["del"]==="delete" ) {
      //si c'est dans une categorie > supprime id article dans categorie
      $catArticle = Article::getCategorieByArticleID($connect, $article["idArticles"]);
      if ($catArticle) {
         Categorie::deleteArticleIdFromCategorie($connect, $catArticle["id"], $article["idArticles"]);
      }
      //supprimer article
      article::deleteArticleByToken($connect,$_POST["articleToken"]);
      Util::redirect("home.php");
   }
}
?>
<!DOCTYPE html>
<html>

<head>
   <title>Accueil</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<div class="menu__group">
   <a href="home.php">
      <button class="button"><i class="fa fa-home"></i> Home</button>

   </a>
 </div>
   <div class="card">
      <h1><?php echo $titre ?></h1>
      <div class="contenu"><?php echo $contenu ?></div>
      <p><?php echo $publicationDate ?></p>
      <p><?php echo User::getUserByID($connect, $idAuteur)["username"]; ?></p>

      <div style="display: flex; justify-content:center;">

         <?php
         if ($idUser == $idAuteur) {
            echo '<a style="margin-right:10px;" href="edit.php?edit=' . $get_token . '"><button class="btn">Editer</button></a>';
         }
         ?>
         <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="articleToken" value="<?php echo $get_token ?>">
            <input type="hidden" name="del" value="delete">
            <button name="delete" class="buttondelete btn" type="submit" value="delete">Delete</button>
         </form>
      </div>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script>
document.querySelector('#form1').addEventListener('submit', function(e) {
  var form = this;

  e.preventDefault(); // <--- prevent form from submitting

  swal({
      title: "Are you sure?",
      text: "You will not be able to recover!",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        swal({
          title: 'Deleted!',
          text: 'The article is successfully deleted!',
          icon: 'success'
        }).then(function() {
          form.submit(); // <--- submit form programmatically
        });
      } else {
        swal("Cancelled", "The article is safe :)", "info");
      }
    })
});
</script>
</html>