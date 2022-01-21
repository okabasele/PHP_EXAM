<?php
require_once 'class/database-connection.php';
require_once 'class/controller.php';
require_once 'class/util.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
session_start();

if(isset($_GET['art']) && !empty($_GET['art'])) {
   $get_token = htmlspecialchars($_GET['art']);
$article = Controller::fetchData($connect,"*","articles","WHERE token=?",[$get_token]);
var_dump($article);
   if($article) {
      $titre = $article['titre'];
      $contenu = $article['contenu'];
      $publicationDate;
      $auteur;
   } else {
       //redirection acceuil
       Util::redirect("home.php");
      die('Cet article n\'existe pas !');
   }
} else {
   die('Erreur');
}
?>
<!DOCTYPE html>
<html>
<head>
   <title>Accueil</title>
   <meta charset="utf-8">
</head>
<body>
   <h1><?php echo $titre ?></h1>
   <p><?php echo $contenu ?></p>
</body>
</html>
