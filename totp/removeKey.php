<?php
/**
 * >> PHP <<
 * >> removeKey.php <<
 * (c) Florentin Schäfer 2019
 */

require "../verify.php";

if (verify()["status"] === "success") $username = verify()["username"];
else header("Location: ../index.php");


if (!(isset($_GET["totpId"]))) {
    die("Error!");
}
$totpId = $_GET["totpId"];


$stmt = getPDO()->prepare("DELETE FROM totp WHERE totpId=?");
$stmt->execute([$totpId]);


echo ($stmt->rowCount() == 1) ? "success" : "error";
echo "<br><br><a href='../dash.php'>Done</a>";
