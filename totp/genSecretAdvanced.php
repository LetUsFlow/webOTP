<?php
require "TOTP.php";

$issuer = $_GET["issuer"];
$user = $_GET["user"];

$secretURL = "http://" . $_SERVER["HTTP_HOST"] . explode('?', $_SERVER['REQUEST_URI'], 2)[0] . "/../genSecret.php";
$secret = file_get_contents($secretURL);
$imageURL = "http://" . $_SERVER["HTTP_HOST"] . explode('?', $_SERVER['REQUEST_URI'], 2)[0] . "/../genQR.php?secret=$secret&issuer=$issuer&user=$user";
echo "<img src='$imageURL'>";
echo "<p>$secret</p>";

