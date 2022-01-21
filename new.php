
<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
require_once 'class/controller.php';
require_once 'class/util.php';
// define variables and set to empty values
$titleErr = "";
$title =  "";
$description = "";
$publish = "" ;
$dateToAdd =  date("D, d M Y H:i:s") ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //ajout article
  if (empty($_POST["title"])) {
    $titleErr = "Name is required";
  } else {
    $title = Util::testInput($_POST["title"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$title)) {
      $titleErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["description"])) {
    $description = "";
  } else {
    $comment = Util::testInput($_POST["description"]);
  }
  if ($_POST['publish'] === "send") {

    $publish =self::insertData($connect, "articles", "title=?,description=?,publicationDate=?", [$title, $description,$dateToAdd]) ;
  }

}


?>
<h2>Add new artical</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Title: <input type="text" Title="Title" value="<?php echo $title;?>" required>
  <span class="error">* <?php echo $titleErr;?></span>
  <br><br>
  Description: <textarea name="description" rows="20" cols="70"><?php echo $description;?></textarea>
  <br><br>
  <button name="publish" type="submit" value="send">Publish</button>
  <br><br>
  Categories:
  <input type="radio" name="categories" <?php if (isset($categories) && $categories=="health") echo "checked";?> value="health">Health
  <input type="radio" name="categories" <?php if (isset($categories) && $categories=="politics") echo "checked";?> value="politics">Politics
  <input type="radio" name="categories" <?php if (isset($categories) && $categories=="environment") echo "checked";?> value="environment">Environment
  <input type="radio" name="categories" <?php if (isset($categories) && $categories=="environment") echo "checked";?> value="beauty">Beauty
  <input type="radio" name="categories" <?php if (isset($categories) && $categories=="fashion") echo "checked";?> value="fashion">Fashion
  <input type="radio" name="categories" <?php if (isset($categories) && $categories=="food") echo "checked";?> value="food">Food
</form>
  </body>
</html>