<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body> 
<?php
require_once 'class/database-connection.php';
require_once 'class/controller.php';
require_once 'class/article.php';
$name = "";

$userData= Controller:: fetchData($connect, "*", "users","WHERE token=?", [$_SESSION['token']]);
$name = $userData["username"];
$articles = Article::getAllArticlesByUserID($connect,$userData["id"]);
var_dump($articles);




  //modifier les informations perso
  if ($_POST['edit'] === "send") {
   $edit = Controller::updateData($connect, "userName", "password=?,email=?,idUsers=?", [$name, $userData]);
 
} 
?>
<!DOCTYPE html>
<html>
<head>
 <title>Profil</title>
 <meta charset="utf-8">
</head>
<body>
 <h1><?php echo $name ?></h1>
 <p><?php echo $articles ?></p>
 <button name="edit" type="submit" value="send">Editer</button>
 
</body>
</html>
