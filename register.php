<?php
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/user.php';
require_once 'assets/css/style.php';

//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

//Si on clique sur le bouton "SIGN UP" on essaye d'ajouter un utilisateur dans la BDD
// en utilisant les données entrées dans le formulaire
if (isset($_POST['register'])) {
	if ($_POST['register'] === "send") {
		$email = htmlspecialchars($_POST['email']);
		$user = htmlspecialchars($_POST['username']);
		$password = $_POST['password'];
		$password2 = $_POST['passwordConfirm'];
		$token = Util::generateToken(20); //on crée un token d'authentification unique pour l'utilisateur
		$registered = User::addUserInDatabase($connect, $user, $password, $password2, $email, $token);
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up</title>
</head>

<body>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label for="">register</label>
		<input id="regUid" name="username" placeholder="USERNAME" type="text" require_onced>
		<input id="regEmail" name="email" placeholder="EMAIL" type="text" require_onced>
		<input id="regPwd" name="password" placeholder="PASSWORD" type="password" require_onced>
		<input id="regPwd2" name="passwordConfirm" placeholder="PASSWORD CONFIRMATION" type="password" require_onced>
		<button name="register" type="submit" value="send">SIGN UP</button>
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
			Util::redirect("./auth/login.php");
			break;
	}
}
?>

</html>