<?php
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/user.php';
require_once 'assets/css/style.php';

//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

if (isset($_POST['login'])) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		if ($_POST['login'] === "send") {
			$loggedIn = User::isUserInDatabase($connect, $_POST['username'], $_POST['password']);
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign In</title>
</head>
<style>
	input.inputError{
    box-shadow: 0 0px 6px 0 #FB3640;
    border-color:#FB3640 ;
    background-image: url("https://cdn.pixabay.com/photo/2017/02/12/21/29/false-2061132_960_720.png");
    background-size: 20px;
    background-position: 250px 10px;
    background-repeat: no-repeat;
}
</style>
<body>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="">login</label>
		<input id="logUid" name="username" placeholder="USERNAME" type="text" require_onced>
		<input id="logPwd" name="password" placeholder="PASSWORD" type="password" require_onced>
        <button name="login" type="submit" value="send">SIGN IN</button>
	</form>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
//Login
if (isset($loggedIn)) {
	switch ($loggedIn) {
		case -1:
			echo '<script>swal("Authentification failed", "The user is not found.", "error");
			logUid.classList.add("inputError");
			</script>';
			break;
		case -2:
			echo '<script>
			swal("Authentification failed", "Your password is incorrect.", "error");
			logPwd.classList.add("inputError");
			</script>';
			break;
		case 1:
		echo '<script>console.log("Auth ok")</script>';
			break;
	}
}
?>
</html>