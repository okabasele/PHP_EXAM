<?php
/* idee 
https://bbbootstrap.com/snippets/latest-updates-list-68233138
https://www.bootdey.com/snippets/view/Support-center
https://www.bootdey.com/snippets/view/Forum-post-list
*/
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

session_start();
$username = Controller::fetchData($connect, "username", "users", "WHERE token=?", [$_SESSION['token']]);

var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
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
        height: 60px;
        top: 0;
        background: pink;
    }

    .nav.title,
    .nav.item {
        margin: 0px 30px;
    }
</style>

<body>
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


    <div class="container">
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
        </div>
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