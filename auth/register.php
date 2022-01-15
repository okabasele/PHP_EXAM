<?php
require './class/database-connection.php';
require './class/util.php';
require './class/controller.php';
require './class/user.php';

//Recuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

if (isset($_POST['register'])) {
	if (!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		if ($_POST['register'] === "send") {
			$email = htmlspecialchars($_POST['email']);
			$user = htmlspecialchars($_POST['username']);
			$password = $_POST['password'];
			$password2 = $_POST['passwordConfirm'];
			$token = Util::generateToken(20);
			$registered = User::addUserInDatabase($connect, $user, $password,$password2, $email, $token);
		}
	}
}

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
	<title>Document</title>
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
		<label for="">register</label>
		<input id="regUid" name="username" placeholder="USERNAME" type="text" required>
		<input id="regEmail" name="email" placeholder="EMAIL" type="text" required>
		<input id="regPwd" name="password" placeholder="PASSWORD" type="password" required>
		<input id="regPwd2" name="passwordConfirm" placeholder="PASSWORD CONFIRMATION" type="password" required>
		<input type="submit" name="register" value="send">
	</form>
	<form id="logForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="">login</label>
		<input id="logUid" name="username" placeholder="USERNAME" type="text" required>
		<input id="logPwd" name="password" placeholder="PASSWORD" type="password" required>
		<input type="submit" name="login" value="send">
	</form>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
//Register
if (isset($registered)) {
	switch ($registered) {
		case -1:
			echo '<script>
			swal("Authentification failed", "Choose another username.", "error");
			regUid.classList.add("inputError");
			</script>';
			break;
		case -2:
			echo '<script>
			swal("Authentification failed", "The email is already taken.", "error");
			regEmail.classList.add("inputError");
			</script>';
			break;
		case -3:
			echo '<script>
			swal("Authentification failed", "The email is not valid.", "error");
			regEmail.classList.add("inputError");
			</script>';
			break;
		case -4:
			echo '<script>
			swal("Authentification failed", "Your password is incorrect.", "error");
			regPwd.classList.add("inputError");
			</script>';
			break;
		case 1:
			echo '<script>
			swal("Welcome!", "Now you can sign in.", "success");
			console.log("Auth ok")
			</script>';
			break;
	}
}

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