<?php
/* idee 
https://bbbootstrap.com/snippets/latest-updates-list-68233138
https://www.bootdey.com/snippets/view/Support-center
https://www.bootdey.com/snippets/view/Forum-post-list
https://codepen.io/melnik909/pen/VQOodQ effet menu
*/
session_start();
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'inc/navbar.php';
require_once 'assets/css/style-navbar.php';
require_once 'assets/css/style-home.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

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

<body style="background-color:bisque;">

    <div class="container d-flex">
        <div class="left-side">
            <div class="posts">
                <?php

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

                ?>
            </div>
            <div class="pagination">

            </div>
        </div>
        <div class="right-side">
            <div class="side-block">
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
                    <div class="sidebarblock">
                        <h3>Categories</h3>
                        <div class="divline"></div>
                        <div class="blocktxt">
                            <ul class="cats">

                                <?php
                                
                                for ($i = 0; $i < 2; $i++) {
                                    echo '<li>
                                    <a href="categorie.php?cat=TOKEN">CATEGORIE
                                    <span class="badge rounded-pill bg-secondary">10</span>
                                    </a>
                                    </li>';
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>