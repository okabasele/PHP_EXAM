<?php
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
//Récuperer la connection à la bdd
$dbconnect = Util::getDatabaseConnection();
$connect = $dbconnect->conn;

session_start();
$username = Controller::fetchData($connect, "username", "users", "WHERE token=?", [$_SESSION['token']]);
$articles = Controller::fetchData($connect, "*", "articles", "");

// Comparison function
function date_compare($element1, $element2)
{
    $datetime1 = strtotime($element1['datetime']);
    $datetime2 = strtotime($element2['datetime']);
    return $datetime1 - $datetime2;
}

// Sort the array 
usort($array, 'date_compare');

// var_dump($_SESSION);
var_dump($articles);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
</head>

<body>
    <nav style="display: flex; justify-content:end">
        <p><?php echo $username["username"] ?></p>
        <button>LOG OUT</button>
    </nav>

    <div class="container">
        <?php
        foreach ($articles as $art) {
            // var_dump($art);

            echo '<div class="media forum-item">
                <img src="https://www.e-xpertsolutions.com/wp-content/plugins/all-in-one-seo-pack/images/default-user-image.png" class="mr-3 rounded-circle" width="50" alt="User" />
                <div class="media-body">
                    <h6>
                        <a>' . $art["title"] . '</a>
                    </h6>
                    <p>' . $art["description"] . '</p>
                    <p>
                        post by <a class="post-author" style="text-decoration: none" href="/profil?v=' . $art["idUsers"] . '">' . $art["idUsers"] . ' </a>
                        <span>' . $art["publicationDate"] . '</span>
                    </p>
                </div>
            </div>';
        }
        ?>
    </div>
</body>

</html>