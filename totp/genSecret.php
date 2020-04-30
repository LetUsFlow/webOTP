<?php
require "TOTP.php";

if (!isset($_GET["secret"]) || !isset($_GET["issuer"])) {
    die("Error!");
}
$issuer = $_GET["issuer"];
$user = $_GET["user"];

$secret = Greymich\TOTP\TOTP::genSecret(128);
$imageURL = "http://" . $_SERVER["HTTP_HOST"] . explode('?', $_SERVER['REQUEST_URI'], 2)[0] . "/../genQR.php?secret=$secret&issuer=$issuer&user=$user";
echo "<img src='$imageURL' alt='qrcode'>";
echo "<p>$secret</p>";

