<?php
/* idee 
https://bbbootstrap.com/snippets/latest-updates-list-68233138
https://www.bootdey.com/snippets/view/Support-center
https://www.bootdey.com/snippets/view/Forum-post-list
https://codepen.io/melnik909/pen/VQOodQ effet menu
*/
session_start();
//CLASSES
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/user.php';
require_once 'class/article.php';
require_once 'class/categorie.php';

//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;
$mode = 0;
if (isset($_SESSION["token"]) && !empty($_SESSION["token"]) && isset($_SESSION["logged-in"]) && $_SESSION["logged-in"] && isset($_SESSION["admin"]) && $_SESSION["admin"]) {
    // var_dump($_SESSION);
    $user = User::getUserByToken($connect, $_SESSION["token"]);
    if (!$user) {
        echo "user not found";
        Util::redirect("loginAdmin.php");
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["del"]) && $_POST["del"] === "delete") {
                $article = Article::getArticleByToken($connect, $_POST["articleToken"]);
                //si c'est dans une categorie > supprime id article dans categorie
                $catArticle = Article::getCategorieByArticleID($connect, $article["idArticles"]);
                if ($catArticle) {
                    Categorie::deleteArticleIdFromCategorie($connect, $catArticle["id"], $article["idArticles"]);
                }
                //supprimer article
                Article::deleteArticleByToken($connect, $_POST["articleToken"]);
                Util::redirect("panelAdmin.php");
            } elseif (isset($_POST["delUser"]) && $_POST["delUser"] === "delete") {
                //supprimer utilisateur et ses articles
                User::deleteUserByToken($connect, $_POST["userToken"]);
                Util::redirect("panelAdmin.php");
            }
        } elseif (isset($_GET["v"]) && !empty($_GET["v"])) {
            if ($_GET["v"] === "articles") {
                $mode = 1;
            } elseif ($_GET["v"] === "users") {
                $mode = 2;
            }
        }
        //NAVBAR
        require_once 'inc/navbarAdmin.php';
        //CSS
        require_once 'assets/css/style-navbar.php';
        require_once 'assets/css/style-home.php';
        //BOOTSTRAP
        require_once 'inc/bootstrap.php';
    }
} else {
    echo "pas connecte";
    Util::redirect("loginAdmin.php");
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

    <div class="container d-flex justify-content-center">
        <div class="left-side">
            <div class="posts">
                <?php
                if ($mode == 1) {
                    $articles = Article::getAllArticles($connect);

                    if ($articles) {
                        if (count($articles) == count($articles, COUNT_RECURSIVE)) {
                            $art = $articles;
                            $auteur = User::getUserByID($connect, $art["idUsers"]);
                            $cat = Article::getCategorieByArticleID($connect, $art["idArticles"]);
                            echo ' <div class="article-block card row-hover pos-relative py-3 px-3 mb-3 border-light border-top-0 border-right-0 border-bottom-0 rounded-0">
                                        <div class="row align-items-center">
                                        ';
                            echo '              <div class=" mb-3 mb-sm-0">
                              <div style="display: flex; justify-content: space-between; flex-direction: row-reverse;">
                              <div style="display: flex; justify-content: center; ">
                            <a style="margin-right:10px;" href="edit.php?edit=' . $art["token"] . '"><button class="btn btn-light"><i class="bi bi-arrow-clockwise"></i></button></a>';
                            echo '<form class="form1" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                                           <input type="hidden" name="articleToken" value="' . $art["token"] . '">
                                           <input type="hidden" name="del" value="delete">
                                           <button name="delete" class="buttondelete btn btn-warning" type="submit" value="delete"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                        </div>
                                        <h5>
                                                <a href="details.php?art=' . $art["token"] . '" class="text-primary">' . $art["title"] . '</a>
                                                </h5>
                                        </div>';


                            echo '
                                                
                                                <p class="text-sm">
                                                <span class="op-6">Posted the ' . $art["publicationDate"] . ' by</span>
                                                <a class="text-black" href="account.php?u=' . $auteur["token"] . '">' . $auteur["username"] . '</a></p>
                                                <div class="text-muted">
                                                <p class="paragraph">' . $art["description"] . '</p>
                                                </div>
                                                <div class="text-sm op-5">';
                            if ($cat) {
                                echo '<a class="text-black mr-2" href=categorie.php?cat=' . $cat["id"] . '>#' . $cat["name"] . '</a>';
                            }
                            echo '</div>
                                        </div>
                                    </div>
                                    </div>';
                        } else {
                            foreach ($articles as $art) {
                                $auteur = User::getUserByID($connect, $art["idUsers"]);
                                $cat = Article::getCategorieByArticleID($connect, $art["idArticles"]);
                                echo ' <div class="article-block card row-hover pos-relative py-3 px-3 mb-3 border-light border-top-0 border-right-0 border-bottom-0 rounded-0">
                                            <div class="row align-items-center">
                                            ';
                                echo '              <div class=" mb-3 mb-sm-0">
                                  <div style="display: flex; justify-content: space-between; flex-direction: row-reverse;">
                                  <div style="display: flex; justify-content: center; ">
                                <a style="margin-right:10px;" href="edit.php?edit=' . $art["token"] . '"><button class="btn btn-light"><i class="bi bi-arrow-clockwise"></i></button></a>';
                                echo '<form class="form1" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                                               <input type="hidden" name="articleToken" value="' . $art["token"] . '">
                                               <input type="hidden" name="del" value="delete">
                                               <button name="delete" class="buttondelete btn btn-warning" type="submit" value="delete"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                            </div>
                                            <h5>
                                                    <a href="details.php?art=' . $art["token"] . '" class="text-primary">' . $art["title"] . '</a>
                                                    </h5>
                                            </div>';


                                echo '
                                                    
                                                    <p class="text-sm">
                                                    <span class="op-6">Posted the ' . $art["publicationDate"] . ' by</span>
                                                    <a class="text-black" href="account.php?u=' . $auteur["token"] . '">' . $auteur["username"] . '</a></p>
                                                    <div class="text-muted">
                                                    <p class="paragraph">' . $art["description"] . '</p>
                                                    </div>
                                                    <div class="text-sm op-5">';
                                if ($cat) {
                                    echo '<a class="text-black mr-2" href=categorie.php?cat=' . $cat["id"] . '>#' . $cat["name"] . '</a>';
                                }
                                echo '</div>
                                            </div>
                                        </div>
                                        </div>';
                            }
                        }
                    }
                } elseif ($mode == 2) {
                    $users = User::getAllUsers($connect);

                    if ($users) {
                        if (count($users) == count($users, COUNT_RECURSIVE)) {
                            $user = $users;
                            echo ' <div class="article-block card row-hover pos-relative py-3 px-3 mb-3 border-light border-top-0 border-right-0 border-bottom-0 rounded-0">
                                        <div class="row align-items-center">
                                        ';
                            echo '              <div class=" mb-3 mb-sm-0">
                              <div style="display: flex; justify-content: space-between; flex-direction: row-reverse;">
                              <div style="display: flex; justify-content: center; ">
                            <a style="margin-right:10px;" href="account.php?u=' . $user["token"] . '"><button class="btn btn-light"><i class="bi bi-arrow-clockwise"></i></button></a>';
                            echo '<form class="form1" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                                           <input type="hidden" name="userToken" value="' . $user["token"] . '">
                                           <input type="hidden" name="delUser" value="delete">
                                           <button name="delete" class="buttondelete btn btn-warning" type="submit" value="delete"><i class="bi bi-trash-fill"></i></button>
                                        </form>
                                        </div>
                                        <h5>
                                                <a href="account.php?u=' . $user["token"] . '" class="text-primary">' . $user["username"] . '</a>
                                                </h5>
                                        </div>';

                            echo '
                                    </div>
                                    </div>
                                    </div>';
                        } else {
                            foreach ($users as $user) {
                                echo ' <div class="article-block card row-hover pos-relative py-3 px-3 mb-3 border-light border-top-0 border-right-0 border-bottom-0 rounded-0">
                                <div class="row align-items-center">
                                ';
                                echo '              <div class=" mb-3 mb-sm-0">
                      <div style="display: flex; justify-content: space-between; flex-direction: row-reverse;">
                      <div style="display: flex; justify-content: center; ">
                    <a style="margin-right:10px;" href="account.php?u=' . $user["token"] . '"><button class="btn btn-light"><i class="bi bi-arrow-clockwise"></i></button></a>';
                                echo '<form class="form1" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                                   <input type="hidden" name="userToken" value="' . $user["token"] . '">
                                   <input type="hidden" name="delUser" value="delete">
                                   <button name="delete" class="buttondelete btn btn-warning" type="submit" value="delete"><i class="bi bi-trash-fill"></i></button>
                                </form>
                                </div>
                                <h5>
                                        <a href="account.php?u=' . $user["token"] . '" class="text-primary">' . $user["username"] . '</a>
                                        </h5>
                                </div>';

                                echo '
                            </div>
                            </div>
                            </div>';
                            }
                        }
                    }
                } else {
                    $mode = 1;
                }
                ?>
            </div>
            <div class="pagination">
                <nav aria-label="...">
                    <ul id="pagin" class="pagination">
                        <?php
                        if (isset($articles)) {
                            if ($articles) {
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
                            }
                        }
                        if (isset($users)) {
                            if ($users) {
                                $sizeUsers = sizeof($users);
                                $maxPage = 4;
                                $sizePage = ceil($sizeUsers / $maxPage);
                                for ($i = 0; $i < $sizePage; $i++) {
                                    if ($i == 0) {
                                        echo '<li class="page-item active"><a class="page-link" href="#">' . ($i + 1) . '</a></li> ';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="#">' . ($i + 1) . '</a></li> ';
                                    }
                                }
                            }
                        }
                        ?>
                    </ul>
                </nav>
            </div>

        </div>
        <div class="right-side">

            <div class="side-block">
                <h3>Announcements</h3>
                <div class="divline"></div>
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="carousel-wrap">

                                <li class="d-flex no-block card-body">
                                    <div class="wrap-icon d-grid">
                                        <i class="bi bi-check-circle-fill"></i>

                                    </div>
                                    <div class="d-grid ">
                                        <a href="#" class="m-b-0 font-medium p-0" data-abc="true">Version 2.5 released</a>
                                        <span class="text-muted">A new version 2.5 has been released. </span>
                                    </div>
                                    <div class="date-news ml-auto">
                                        <div class="tetx-right">
                                            <h5 class="text-muted m-b-0">15</h5>
                                            <span class="text-muted font-16">JAN</span>
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-wrap">

                                <li class="d-flex no-block card-body">
                                    <div class="wrap-icon d-grid ">
                                        <i class="bi bi-question-circle-fill"></i>

                                    </div>
                                    <div class="d-grid align-items-center">
                                        <a href="#" class="m-b-0 font-medium p-0" data-abc="true">New Guidelines to Employees</a>
                                        <span class="text-muted">We have realeased new guidelines to all employees</span>
                                    </div>
                                    <div class="date-news ml-auto">
                                        <div class="tetx-right">
                                            <h5 class="text-muted m-b-0">10</h5>
                                            <span class="text-muted font-16">JAN</span>
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-wrap">

                                <li class="d-flex no-block card-body">
                                    <div class="wrap-icon d-grid ">
                                        <i class="bi bi-plus-lg"></i>
                                    </div>
                                    <div class="d-grid align-items-center">
                                        <a href="#" class="m-b-0 font-medium p-0" data-abc="true">Hiring Android Developers</a>
                                        <span class="text-muted">We are hiring android developers to expend our mobile development team.</span>
                                    </div>
                                    <div class="date-news ml-auto">
                                        <div class="tetx-right">
                                            <h5 class="text-muted m-b-0">6</h5>
                                            <span class="text-muted font-16">JAN</span>
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="side-block">
                <div class="categories">

                    <h3>Categories</h3>
                    <div class="divline"></div>
                    <div class="blocktxt">
                        <ul class="cats">

                            <?php
                            $categories = Categorie::getAllCategories($connect);
                            if ($categories) {
                                foreach ($categories as $cat) {
                                    echo '<li>
                                        <a href="categorie.php?cat=' . $cat["id"] . '">' . ucfirst($cat["name"]) . '
                                        <span class="badge rounded-pill bg-secondary">' . sizeof($cat["articles"]) . '</span>
                                        </a>
                                        </li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>


</body>
<?php
require_once "assets/js/js-home.php";
require_once "assets/js/js-pagination.php";
?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script>
    document.querySelector('#form1').addEventListener('submit', function(e) {
        var form = this;

        e.preventDefault(); // <--- prevent form from submitting

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover!",
            icon: "warning",
            buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: 'Deleted!',
                    text: 'The article is successfully deleted!',
                    icon: 'success'
                }).then(function() {
                    form.submit(); // <--- submit form programmatically
                });
            } else {
                swal("Cancelled", "The article is safe :)", "info");
            }
        })
    });
</script>

</html>