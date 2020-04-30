<?php
require "TOTP.php";
require "../verify.php";

if (verify()["status"] === "success") $username = verify()["username"];
else header("Location: ../index.php");


if (!isset($_GET["issuer"])) {
    die("Error!");
}
$issuer = $_GET["issuer"];

$secret = Greymich\TOTP\TOTP::genSecret(128);
$imageURL = "http://" . $_SERVER["HTTP_HOST"] . explode('?', $_SERVER['REQUEST_URI'], 2)[0] . "/../../qr/genQR.php?secret=$secret&issuer=$issuer&user=$username";
echo "<img src='$imageURL' alt='qrcode'>";
echo "<p>$secret</p>";
