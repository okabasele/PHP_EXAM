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
// var_dump($_SESSION);
if (isset($_SESSION["token"]) && !empty($_SESSION["token"]) && isset($_SESSION["logged-in"]) && $_SESSION["logged-in"]) {
    $user = user::getUserByToken($connect, $_SESSION["token"]);
    if (!$user) {
        echo "user not found";
        Util::redirect("login.php");
    } else {
        //NAVBAR
        require_once 'inc/navbar.php';
        //CSS
        require_once 'assets/css/style-navbar.php';
        require_once 'assets/css/style-home.php';
        //BOOTSTRAP
        require_once 'inc/bootstrap.php';
    }
} else {
    echo "pas connecte";
    Util::redirect("login.php");
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
                $articles = Article::getAllArticles($connect);
                foreach ($articles as $art) {
                    $user = User::getUserByID($connect, $art["idUsers"]);
                    $cat = Article::getCategorieByArticleID($connect, $art["idArticles"]);
                    echo ' <div class="article-block card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                <div class="row align-items-center">
                                    <div class=" mb-3 mb-sm-0">
                                        <h5>
                                        <a href="details.php?art=' . $art["token"] . '" class="text-primary">' . $art["title"] . '</a>
                                        </h5>
                                        <p class="text-sm">
                                        <span class="op-6">Posted the ' . $art["publicationDate"] . ' by</span>
                                        <a class="text-black" href="account.php?u=' . $user["token"] . '">' . $user["username"] . '</a></p>
                                        <div class="text-muted">
                                        <p class="paragraph">' . $art["description"] . '</p>
                                        </div>
                                        <div class="text-sm op-5">';
                    if ($cat) {
                        echo '<a class="text-black mr-2" href=categorie.php?cat="' . $cat["id"] . '">#' . $cat["name"] . '</a>';
                    }
                    echo '</div>
                                </div>
                            </div>
                            </div>';
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

</html>