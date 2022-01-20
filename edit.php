<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FFFFFF;}
</style>
</head>
<body>  

<?php
require_once 'class/database-connection.php';
require_once 'class/util.php';
require_once 'class/controller.php';
require_once 'class/user.php';
require_once 'assets/css/style.php';

$idArticles = "";
$TitleErr = "";
$Title =  "";
$Description = "";
$Publier = "";