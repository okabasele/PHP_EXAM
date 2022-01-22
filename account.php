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
require_once 'class/util.php';
$name = "";

$userData= Controller:: fetchData($connect, "*", "users","WHERE token=?", [$_SESSION['token']]);
$name = $userData["username"];
$articles = Article::getAllArticlesByUserID($connect,$userData["id"]);
var_dump($articles)

?>

<h2>Profile Page</h2>
    <table>
        <tr><td><?php echo $userName ?> <td><tr>
        <tr><td>Your Articles</td><?php echo $articles ?> <td><tr>    
    <table>
</body>
</html>