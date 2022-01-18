
<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$TitleErr = "";
$Title =  "";
$Description = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //ajout article
  if (empty($_POST["Title"])) {
    $TitleErr = "Name is required";
  } else {
    $Title = test_input($_POST["Title"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$Title)) {
      $TitleErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["Description"])) {
    $Description = "";
  } else {
    $comment = test_input($_POST["Description"]);
  }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

//  self::insertData($connect, "users", "username=?,password=?,email=?,token=?", [$username, $password, $email, $token]);
?>
<h2>Add new artical</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Title: <input type="text" Title="Title" value="<?php echo $Title;?>" required>
  <span class="error">* <?php echo $TitleErr;?></span>
  <br><br>
  Description: <textarea name="Description" rows="20" cols="70"><?php echo $Description;?></textarea>
  <br><br>
  <input type="submit" name="submit" value="Submit"> 
</form>
  </body>
</html>