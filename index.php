<?php
require_once 'class/util.php';

//Si on clique sur le bouton "SIGN UP" on est redirigé vers la page register.php
if (isset($_POST['register'])) {
    echo $_POST['register'];
    if ($_POST['register'] === "send") {
        Util::redirect("register.php");
    }
}

//Si on clique sur le bouton "SIGN IN" on est redirigé vers la page login.php
if (isset($_POST['login'])) {
    echo $_POST['login'];
    if ($_POST['login'] === "send") {
        Util::redirect("login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>

<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <button name="register" type="submit" value="send">SIGN UP</button>
        <button name="login" type="submit" value="send">SIGN IN</button>
    </form>
</body>

</html>