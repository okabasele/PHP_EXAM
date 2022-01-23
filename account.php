<?php
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/article.php';
require_once 'class/categorie.php';
require_once 'class/user.php';
require_once 'assets/css/style.php';
require_once 'inc/bootstrap.php';
require_once 'assets/css/style-account.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
session_start();
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
            //si utilisateur change username on le change
            #code

            //si utilisateur change email on le change
            #code

            //si utilisateur change le mdp on le change
            //on verifie que current password est bien dans la bdd
            //on verifie que le new password et confirmation sont bien pareilles
            //on modifie le mdp
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
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="left">

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    Name: <input type="text" name="name" value="<?php echo $name; ?>">
                    <br><br>
                    E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
                    <br><br>
                    <div>

                        <label for="pass">Current Password:</label>
                        <input type="password" id="pass" name="password" minlength="8">
                    </div>
                    <br><br>
                    <div>

                        <label for="pass">New Password:</label>
                        <input type="password" id="pass" name="password" minlength="8">
                    </div>
                    <br><br>
                    <div>

                        <label for="pass">New Password confirmation:</label>
                        <input type="password" id="pass" name="password" minlength="8">
                    </div>
                    <br><br>
                    <button name="modifie" type="submit" value="send">MODIFIER</button>
                </form>
            </div>
            <div class="right">

                <div class="articles" style="height: 90%;">

                    <h1>Your Articles</h1>
                    <?php
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
                                echo '<a class="text-black mr-2" href="' . $cat["id"] . '">#' . $cat["name"] . '</a>';
                            }
                            echo '</div>
                        </div>
                    </div>
                    </div>';
                        }
                    }

                    ?>

                </div>
                <div class="pagination">
                    <nav aria-label="...">
                        <ul id="pagin" class="pagination">
                            <?php
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

                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
<<<<<<< HEAD
            <br><br>
            <div>

                <label for="pass">New Password confirmation:</label>
                <input type="password" id="pass" name="password" minlength="8" required>
            </div>
            <br><br>
            <button name="modifie" type="submit" value="send">MODIFIER</button>
        </form>

        <div class="articles">

            <h1>Your Articles</h1>
            <?php
            $articles = Article::getAllArticlesByUserID($connect, $userData["idUsers"]);

            //parcourt du tableau "$articles"
            if($articles){
            foreach ($articles as $art) {
                $cat = Article::getCategorieByArticleID($connect, $art["idArticles"]);
                echo ' <div class="row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                <div class="row align-items-center">
                                    <div class=" mb-3 mb-sm-0">
                                        <h5>
                                        <a href="details.php?art=' . $art["token"] . '" class="text-primary">' . $art["title"] . '</a>
                                        </h5>

                                        <div class="text-sm op-5">';
                if ($cat) {
                    echo '<a class="text-black mr-2" href="' . $cat["id"] . '">#' . $cat["name"] . '</a>';
                }
                echo '</div>
                                </div>
                            </div>
                            </div>';
            }
        }

            ?>

=======
>>>>>>> ee868492355860bbd7bbc57247d332075477db2c
        </div>
    </div>
</body>

</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
require_once "assets/js/js-pagination.php";
?>

</html>