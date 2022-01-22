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

//quand on essaye d'aller sur la page
$modeEdition = 0;
if (isset($_GET["edit"]) && !empty($_GET["edit"])) {
    $modeEdition = 1;
    $editToken = htmlspecialchars($_GET["edit"]);
    $editAccount = Controller::fetchData($connect, "*", "users", "WHERE token=?", [$editToken]);

    if ($editAccount) {
        $name = $editAccount['usermane'];
        $email = $editAccount['email'];
        $password = $editAccount['password'];
        //quand tu clique sur le boutton
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    //VERIF INPUT


    if (isset($_POST['modifie'])) {
        if ($_POST['modifie'] === "send") {
            $account = User::isUserInDatabase($connect, $_POST['username'], $_POST['password']);
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

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input id="name" name="username" placeholder="USERNAME" type="text" required>
            <input id="password" name="password" placeholder="PASSWORD" type="password" required>
            <p>Forgot password?</p>
            <button name="modifie" type="submit" value="send">MODIFIER</button>
            Name: <input type="text" name="name" value="<?php echo $name; ?>">
            <br><br>
            Email:E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
            <br><br>
            <div>
                Password:
                <label for="pass">Password (8 characters minimum):</label>
                <input type="password" id="pass" name="password" minlength="8" required>
            </div>
</body>
</form>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
</form>
</div>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</html>