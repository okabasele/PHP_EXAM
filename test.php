<?php 

if(isset($_POST['sub'])) {
	if(!empty($_POST['lorem']) and !empty($_POST['ipsum'])) {
		if ($_POST['sub'] === "send") {
			$tab = (login($_POST['ipsum'], $_POST['lorem']));
			var_dump($tab['token']);
		}
	}
}

function login($email, $password) {
	$pdo = new PDO("mysql:dbname=forum_geu; host=localhost", "root", "");
	
	$res = $pdo->prepare('SELECT * FROM contact WHERE email=? and message=?');
	$res->execute([$email, $password]);

	return $res->fetch();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form method="POST">
		<input name="ipsum" type="text">
		<input name="lorem" type="text">
		<input type="submit" name="sub" value="send">
	</form>
</body>
</html>