<?php
/**
 * >> PHP <<
 * >> removeKey.php <<
 * (c) Florentin Schäfer 2019
 */

require "user.php";

$data = checkUser(getPDOObject());
if ($data["status"]) $username = $data["username"];
else {
    header("Location: index.php?{$data["reason"]}");
}




$db = getPDOObject();

if (!(isset($_GET["totpId"]))) {
    die("Error!");
}

$totpId = $_GET["totpId"];


$res = $db->query("DELETE FROM totp WHERE totpId = " . $totpId);


echo ($res->rowCount() == 1) ? "success" : "error";

echo "<br><br><a href='../dash.php'>Done</a>";
