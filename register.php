<?php
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/user.php';
require_once 'assets/css/style.php';
require_once 'assets/css/style-register.php';


//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

//Si on clique sur le bouton "SIGN UP" on essaye d'ajouter un utilisateur dans la BDD
// en utilisant les données entrées dans le formulaire
if (isset($_POST['register'])) {
	if ($_POST['register'] === "send") {
		$email = Util::testInput($_POST['email']);
		$user = Util::testInput($_POST['username']);
		$password = $_POST['password'];
		$password2 = $_POST['passwordConfirm'];
		$token = Util::generateToken(20); //on crée un token d'authentification unique pour l'utilisateur
		$status = "user";
		$registered = UseraddUserInDatabase($connect, $user, $password, $password2, $email, $token,$status);
	}
}
if (isset($_POST['login'])) {
	if ($_POST['login'] === "Login here") {
		Util::redirect("login.php");
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
	<div class="card">
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input style="margin-right:10px;" id="regUid" name="username" placeholder="USERNAME" type="text" required>
		<input id="regEmail" name="email" placeholder="EMAIL" type="text" required>
		<div style="display: flex; justify-content:center;">
		<input style="margin-right:10px;" id="regPwd" name="password" placeholder="PASSWORD" type="password" minlength="8" required>
		<input  id="regPwd2" name="passwordConfirm" placeholder="PASSWORD CONFIRMATION" type="password" minlength="8" required>
      </div>

		<div class="text">
			By clicking the Sign up button you agree to our <a href="">Terms and Conditions</a> and <a href="">Policy Privacy</a>
		</div>
		<button name="register" type="submit" value="send">SIGN UP</button>
	</form>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<div>
			Already have an account?
			<input class="link" name="login" type="submit" value="Login here">
		</div>
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
			Util::redirect("login.php");
			break;
	}
}
?>

</html>