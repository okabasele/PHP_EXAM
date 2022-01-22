<?php
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/user.php';
require_once 'assets/css/style.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
session_start();

$name = "";
if (isset($_GET['u']) && !empty($_GET['u'])) {
  $get_token = htmlspecialchars($_GET['u']);
  $userData = User::getUserByToken($connect,$get_token);
  $name = $userData["username"];
  $articles = Article::getAllArticlesByUserID($connect, $userData["idUsers"]);
  var_dump($articles);}

  // for ($i=0; $i < ; $i++) { 
  //     # code...
  // }

  if($idUser == $idAuteur){
      echo $name;
      echo $userData;
      echo $articles;
  }



//quand on essaye d'aller sur la page
$modeEdition = 0;
if (isset($_GET["u"]) && !empty($_GET["u"])) {
    $modeEdition = 1;
    $userToken = htmlspecialchars($_GET["u"]);
    $userAccount = Controller::fetchData($connect, "*", "users", "WHERE token=?", [$userToken]);

    if ($userAccount) {
        $name = $userAccount['username'];
        $email = $userAccount['email'];
        $password = $userAccount['password'];
        //quand tu clique sur le boutton
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    //VERIF INPUT


    if (isset($_POST['modifie'])) {
        if ($_POST['modifie'] === "send") {
            $account = User::updateData($connect, $_POST['username'], $_POST['password']);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
</head>
<style>
    input.inputError {
        box-shadow: 0 0px 6px 0 #FB3640;
        border-color: #FB3640;
        background-image: url("https://cdn.pixabay.com/photo/2017/02/12/21/29/false-2061132_960_720.png");
        background-size: 20px;
        background-position: 250px 10px;
        background-repeat: no-repeat;
    }
</style>

<body>
    <div class="container">


    
    <h1>Your Articals</h1>
    <article class="<?php echo $articles ?>">
    </article>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            Name: <input type="text" name="name" value="<?php echo $name; ?>">
            <br><br>
            E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
            <br><br>
            <div>

                <label for="pass">Current Password:</label>
                <input type="password" id="pass" name="password" minlength="8" required>
            </div>
            <br><br>
            <div>

                <label for="pass">New Password:</label>
                <input type="password" id="pass" name="password" minlength="8" required>
            </div>
            <br><br>
            <div>

                <label for="pass">New Password confirmation:</label>
                <input type="password" id="pass" name="password" minlength="8" required>
            </div>
            <br><br>
            <button name="modifie" type="submit" value="send">MODIFIER</button>
</body>
</form>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
</form>
</div>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</html>