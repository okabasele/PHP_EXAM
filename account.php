<?php
//CLASSES
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/article.php';
require_once 'class/categorie.php';
require_once 'class/user.php';

session_start();
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

if (isset($_SESSION["token"]) && !empty($_SESSION["token"]) && isset($_SESSION["logged-in"]) && $_SESSION["logged-in"]) {
    $user = User::getUserByToken($connect, $_SESSION["token"]);
    if (!$user) {
        Util::redirect("login.php");
    } else {
        //STYLE
        require_once 'inc/bootstrap.php';
        require_once 'assets/css/style.php';
        require_once 'assets/css/style-account.php';
    }
} else {
    Util::redirect("login.php");
}

$articles = "";
$name = "";
if (isset($_GET['u']) && !empty($_GET['u'])) {
    $get_token = htmlspecialchars($_GET['u']);
    $userData = User::getUserByToken($connect, $get_token);
    $name = $userData["username"];
    $articles = Article::getAllArticlesByUserID($connect, $userData["idUsers"]);
    //   var_dump($articles);
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
            $update = User::updateAccount($connect, $_POST['name'], $_POST['email'], $_POST['prevPassword'], $_POST['newPassword'], $_POST['confPassword'], $_POST['tokenUser']);
            Util::redirect("account.php?u=" . $_POST['tokenUser']);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
        <div class="menu__group">
            <a href="home.php" class="menu__link r-link text-underlined"><button class="button">Home</button></a>
            <a href="login.php" class="menu__link r-link text-underlined"><button class="button">Déconnexion</button></a>
            </li>
        </div>
        <div class="card">
            <?php

            if ($user["token"] === $userAccount["token"]) {
                // var_dump($user);
                echo '
                        <div class="left">
                        <form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '";">
<input type="hidden" name="tokenUser" value="' . $userToken . '">
Name: <input id="upName" type="text" name="name" value="' . $name . '">
<br><br>
E-mail: <input type="text" id="upEmail" name="email" value="' . $email . '">
<br><br>
<button type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Change password
</button>
<div class="collapse" id="collapseExample">

    <div>
        <label for="pass">Current Password:</label>
        <input id="upPP" type="password" name="prevPassword" minlength="8">
    </div>
    <br><br>
    <div>

        <label for="pass">New Password:</label>
        <input id="upNP" type="password" name="newPassword" minlength="8">
    </div>
    <br><br>
    <div>

        <label for="pass">Confirmation New Password:</label>
        <input id="upCP" type="password" name="confPassword" minlength="8">
    </div>

</div>
<br><br>
<button name="modifie" type="submit" value="send">Change</button>
</form>

</div>


<div class="right">

    <div class="articles">
    <h1>Your Articles</h1>


';
                $articles = Article::getAllArticlesByUserID($connect, $userData["idUsers"]);
                //parcourt du tableau "$articles"
                if ($articles) {
                    foreach ($articles as $art) {
                        $cat = Article::getCategorieByArticleID($connect, $art["idArticles"]);
                        echo ' <div class="article-block row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                        <div class="row align-items-center">
                            <div class=" mb-3 mb-sm-0">
                                <h5>
                                <a href="details.php?art=' . $art["token"] . '" class="text-primary">' . $art["title"] . '</a>
                                </h5>
                                <div class="text-sm op-5">';
                        if ($cat) {
                            echo '<a class="text-black mr-2" href=categorie.php?cat="' . $cat["id"] . '">#' . $cat["name"] . '</a>';
                        }
                        echo '</div></div></div></div>';
                    }

                    echo '            </div>
    <div class="pagination">
        <nav aria-label="...">
            <ul id="pagin" class="pagination">';
                    $sizeArticles = sizeof($articles);
                    $maxPage = 4;
                    $sizePage = ceil($sizeArticles / $maxPage);
                    for ($i = 0; $i < $sizePage; $i++) {
                        if ($i == 0) {
                            echo '<li class="page-item active"><a class="page-link" href="#">' . ($i + 1) . '</a></li> ';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="#">' . ($i + 1) . '</a></li> ';
                        }
                    }
                    echo '
            </ul>
        </nav>
    </div>';
                }
            } else {
                echo '            <div style="display:flex;align-items:center;justify-content:center;" class="top">
                <p>Name : ' . $name . '</p>
            </div>
            <div class="bottom">
                <div class="articles">

                    <h1>Your Articles</h1>';

                $articles = Article::getAllArticlesByUserID($connect, $userData["idUsers"]);
                //parcourt du tableau "$articles"
                if ($articles) {
                    foreach ($articles as $art) {
                        $cat = Article::getCategorieByArticleID($connect, $art["idArticles"]);
                        echo ' <div class="article-block row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                <div class="row align-items-center">
                    <div class=" mb-3 mb-sm-0">
                        <h5>
                        <a href="details.php?art=' . $art["token"] . '" class="text-primary">' . $art["title"] . '</a>
                        </h5>
                        <div class="text-sm op-5">';
                        if ($cat) {
                            echo '<a class="text-black mr-2" href=categorie.php?cat="' . $cat["id"] . '">#' . $cat["name"] . '</a>';
                        }
                        echo '</div></div></div></div>';
                    }
                }

                echo '            </div>
    <div class="pagination">
        <nav aria-label="...">
            <ul id="pagin" class="pagination">';
                $sizeArticles = sizeof($articles);
                $maxPage = 4;
                $sizePage = ceil($sizeArticles / $maxPage);
                for ($i = 0; $i < $sizePage; $i++) {
                    if ($i == 0) {
                        echo '<li class="page-item active"><a class="page-link" href="#">' . ($i + 1) . '</a></li> ';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="#">' . ($i + 1) . '</a></li> ';
                    }
                }
                echo '
            </ul>
        </nav>
    </div>';
            }


            ?>


        </div>
    </div>
</body>

</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
require_once "assets/js/js-pagination.php";
?>

</html>