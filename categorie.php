<?php
if(isset($_GET['cat']) AND $_GET['cat'] > 0 ){
    //table categories
    $requete = ' WHERE id='.$_GET['cat']; 
}

$nombreDArticlesParPage = 5;
if (isset($_GET['page'])){ 
    $page = $_GET['page'];
}
else{
    $page = 1;         
}