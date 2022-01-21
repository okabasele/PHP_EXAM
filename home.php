<?php
/* idee 
https://bbbootstrap.com/snippets/latest-updates-list-68233138
https://www.bootdey.com/snippets/view/Support-center
https://www.bootdey.com/snippets/view/Forum-post-list
https://codepen.io/melnik909/pen/VQOodQ effet menu
*/
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'assets/css/menu-effect.php';
require_once 'assets/css/navbar.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

session_start();
$username = Controller::fetchData($connect, "username", "users", "WHERE token=?", [$_SESSION['token']]);

// var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- BOOTSTRAP JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<style>
    body,
    html {
        margin: 0;
        padding: 0;
    }

    .nav {
        position: sticky;
        display: flex;
        justify-content: space-between;
        align-items: center;
        top: 0;
        background: pink;
    }

    .pink {
        background: pink;

    }

    .nav.title,
    .nav.item {
        margin: 0px 30px;
    }

    .personal {
        width: 50px;
        height: 50px;
    }

    .icon {
        width: 50px;
        height: 50px;
        background-color: red;
    }


    .status {
        position: absolute;
        right: 0;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: solid 2px #ffffff;
    }

    .status.user {
        background-color: #80d3ab;
    }

    .personal a {
        color: black;
        text-decoration: none;
    }
</style>

<body>
    <nav class="nav">
        <div class="icon">
        </div>
        <div class="pages">
            <div class="page__menu menu">
                <ul class="menu__list r-list">
                    <li class="menu__group">
                        <a href="#0" class="menu__link r-link text-underlined">Home</a>
                    </li>
                    <li class="menu__group">
                        <a href="#0" class="menu__link r-link text-underlined">Help</a>
                    </li>
                    <li class="menu__group">
                        <a href="#0" class="menu__link r-link text-underlined">About</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="search-bar">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-3"> <input type="text" class="form-control input-text" placeholder="Search....">
                            <div class="input-group-append"> <button class="btn btn-outline-warning btn-lg" type="button"><i class="bi bi-search"></i></button> </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="new-topic">
            <button class="btn btn-dark">Create a new article</button>
        </div>
        <div class="personal">
            <div class="position-relative dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://www.e-xpertsolutions.com/wp-content/plugins/all-in-one-seo-pack/images/default-user-image.png" class="mr-3 rounded-circle" width="50" alt="User" />
                    <div class="status user">&nbsp;</div>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">My Account</a></li>
                    <li><a class="dropdown-item" href="#">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div>
                    ANNONCE
                </div>
            </div>
            <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
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
    </div> -->
    <!--     
    <nav class="nav">
        <ul class="nav list">
            <li class="nav item">FORUM</li>
            <a href="">
                <li class="nav item">Home</li>
            </a>
            <a href="">
                <li class="nav item">Support Center</li>
            </a>
            <a href="">
                <li class="nav item">About</li>
            </a>
        </ul>

        <div class="col-md-8">
            <form action="" method="post">
                <input class="form-control" type="text" placeholder="Search...">
                <button type="submit">
                    <i class="bx bx-search"></i>
                </button>
            </form>

        </div>
        <ul class="nav list">
            <li class="nav item"><?php echo $username["username"] ?></li>
        </ul>
    </nav>
    <div class="general">
        <div class="news">
            <h4>NEWS UPDATES</h4>
            <li class="d-flex no-block card-body">
                <i class="fa fa-check-circle w-30px m-t-5"></i>
                <div>
                    <a href="#" class="m-b-0 font-medium p-0" data-abc="true">Version 2.5 released</a>
                    <span class="text-muted">A new version 2.5 has been released. </span>
                </div>
                <div class="ml-auto">
                    <div class="tetx-right">
                        <h5 class="text-muted m-b-0">26</h5>
                        <span class="text-muted font-16">FEB</span>
                    </div>
                </div>
            </li>
        </div>
        <div class="private-admin">
            <h4>STAFF DISCUSSION</h4>
            <li class="d-flex no-block card-body">
                <i class="bi bi-star-fill w-30px m-t-5"></i>
                <div>
                    <a href="#" class="m-b-0 font-medium p-0" data-abc="true">Hidden</a>
                    <span class="text-muted">This forum is for private, staff member only discussions, usually pertaining to the community itself. </span>
                </div>
                <div class="ml-auto">
                    <div class="tetx-right">
                        <h5 class="text-muted m-b-0">26</h5>
                        <span class="text-muted font-16">FEB</span>
                    </div>
                </div>
            </li>
        </div>
    </div> -->


    <div class="container">

        <?php
        /*
        


        for ($i = 0; $i < 2; $i++) {

            echo '<div class="media forum-item">
                <img src="https://www.e-xpertsolutions.com/wp-content/plugins/all-in-one-seo-pack/images/default-user-image.png" class="mr-3 rounded-circle" width="50" alt="User" />
                <div class="media-body">
                    <h6>
                        <a>' . "Title" . '</a>
                    </h6>
                    <p>' . "Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio fuga magni cupiditate laudantium quasi tenetur necessitatibus accusantium libero at aperiam sunt asperiores voluptate sed, doloribus, obcaecati minima illo ea fugiat." . '</p>
                    <p>
                        post by
                        <a class="post-author" style="text-decoration: none" href="/profil?v=' . "tokenAuthor" . '">' . "Username-Author" . ' </a>
                        <span>' . "10/10/10" . '</span>
                    </p>
                </div>
            </div>';
        }
        */
        ?>
    </div>
</body>

</html>