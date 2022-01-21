
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
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
session_start();
// define variables and set to empty values
$titleErr = "";
$title =  "";
$description = "";
$publish = "" ;
$dateToAdd =  date("Y-m-d H:i:s") ;
$categories = "";
$categoriesErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //ajout article
  if (empty($_POST["title"])) {
    $titleErr = "Name is required";
  } else {
    $title = Util::testInput($_POST["title"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$title)) {
      $titleErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["description"])) {
    $description = "";
  } else {
    $description = Util::testInput($_POST["description"]);
  }
  if ($_POST['publish'] === "send") {
    $array= Controller::fetchData($connect, "id", "users", "WHERE token=?", [$_SESSION['token']]);
    $idAuthor = $array["idUsers"];
    $token = Util::generateToken(20);
    $publish =Controller::insertData($connect, "articles", "title=?,description=?,publicationDate=?,idUsers=?,token=?", [$title, $description,$dateToAdd,$idAuthor,$token]) ;
  }
  if (empty($_POST["categories"])) {
    $categoriesErr = "Please select a categorie";
  } else {
    $categories = Util::testInput($_POST["categories"]);
  }

}
//ça fonctionne :)

?>
<h2>Add new artical</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Title: <input type="text" name="title" required>
  <span class="error">* <?php echo $titleErr;?></span>
  <br><br>
  Description: <textarea name="description" rows="20" cols="70"></textarea>
  <br><br>
  <div>
    Categories:
    <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"]=="health") echo "checked";?> value="health">Health
    <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"]=="politics") echo "checked";?> value="politics">Politics
    <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"]=="environment") echo "checked";?> value="environment">Environment
    <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"]=="beauty") echo "checked";?> value="beauty">Beauty
    <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"]=="fashion") echo "checked";?> value="fashion">Fashion
    <input type="radio" name="categories" <?php if (isset($_POST["categories"]) && $_POST["categories"]=="food") echo "checked";?> value="food">Food
    <span class="error">* <?php echo $categoriesErr;?></span>
    <br><br>
  </div>
  <button name="publish" type="submit" value="send">Publish</button>
</form>
  </body>
</html>