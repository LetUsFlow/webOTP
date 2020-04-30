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
$db = getPDO();

if (!(isset($_GET["secret"]) && isset($_GET["issuer"]))) {
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
    echo "<h2>ERROR!</h2><br><br>";
    echo $e;
    die();
}


$res = $db->query("INSERT INTO totp (username, secret, issuer) VALUES ('$username', '$secret', '$issuer');");

echo ($res->rowCount() == 1) ? "success" : "error";

echo "<br><br><a href='../dash.php.old'>Done</a>";
