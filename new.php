<!DOCTYPE HTML>
<html>

<head>
  <style>
    .error {
      color: #FF0000;
    }
  </style>
</head>

<body>

  <?php
  //CLASSES
  require_once 'class/database-connection.php';
  require_once 'class/controller.php';
  require_once 'class/categorie.php';
  require_once 'class/article.php';
  require_once 'class/util.php';
  session_start();
  //Récuperer la connection à la bdd
  $dbconnect = Util::getDatabaseConnection();
  $connect = $dbconnect->conn;
  
  if (isset($_SESSION["token"]) && !empty($_SESSION["token"]) && isset($_SESSION["logged-in"]) && $_SESSION["logged-in"]) {
      $user = UsergetUserByToken($connect, $_SESSION["token"]);
      if (!$user) {
          Util::redirect("login.php");
      } else {
          //STYLE
          require_once 'assets/css/style-new.php';
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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //ajout article
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
    if ($_POST['publish'] === "send") {
      //ajout article
      $array = Controller::fetchData($connect, "idUsers", "users", "WHERE token=?", [$_SESSION['token']]);
      $idAuthor = $array["idUsers"];
      $token = Util::generateToken(20);
      $publish = Controller::insertData($connect, "articles", "title=?,description=?,publicationDate=?,idUsers=?,token=?", [$title, $description, $dateToAdd, $idAuthor, $token]);
      //ajout article id dans la table categories
      $artID = Article::getArticleByToken($connect,$token)["idArticles"];
      Categorie::insertArticleIdIntoCategorie($connect,$categories,$artID);
      //redirection vers details
        Util::redirect("http://localhost/php_exam/details.php?art=$token");
      
    }
  }
  ?>
  
  <h2>Add new artical</h2>
  <div class="card">
  <!-- <p><span class="error">* required field</span></p> -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Title: <input type="text" name="title" required>
    <span class="error">* <?php echo $titleErr; ?></span>
    <br><br>
    Description: <textarea name="description" rows="20" cols="70"></textarea>
    <br><br>
    <div>
      Categories:
      <?php
      $arrayCat = Controller::fetchData($connect,"id,name","categories","");
      foreach ($arrayCat as $cat) {
        echo '<input type="radio" name="categories" value="'.$cat["id"].'">'.ucfirst($cat["name"]);
      }
      ?>
      <span class="error">* <?php echo $categoriesErr; ?></span>
      <br><br>
    </div>
    <button name="publish" type="submit" value="send">Publish</button>
  </form>
</body>

</html>