<?php
/**
 * >> PHP <<
 * >> addKey.php <<
 * (c) Florentin Schäfer 2019
 */

require "../verify.php";
require "TOTP.php";

if (verify()["status"] === "success") $username = verify()["username"];
else header("Location: ../index.php");

if (!isset($_GET["secret"]) || !isset($_GET["issuer"])) {
    die("Error!");
}

$issuer = $_GET["issuer"];
$secret = $_GET["secret"];


while ( strlen($secret) < 16 || strlen($secret) % 8 != 0 ) {
    $secret .= "=";
}

$otp = new Greymich\TOTP\TOTP($secret);

try {
    $otp->get();
} catch (Exception $e) {
    echo $e;
    die();
}


$stmt = getPDO()->prepare("INSERT INTO keys (username, secret, issuer) VALUES (?, ?, ?);");
$stmt->execute([$username, $secret, $issuer]);


echo ($stmt->rowCount() == 1) ? "success" : "error";
echo "<br><br><a href='../dash.php'>Done</a>";
