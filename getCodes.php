<?php
/**
 * >> PHP <<
 * >> getCodes.php <<
 * (c) Florentin Schäfer 2019
 */


require "user.php";
require "genCode.php";

$data = checkUser(getPDOObject());
if ($data["status"]) $username = $data["username"];
else {
    header("Location: index.php?{$data["reason"]}");
}
$db = getPDOObject();




$res = $db->query("SELECT * FROM totp WHERE username='$username'");

$i = 0;
foreach ($res as $row) {

    //$code = file_get_contents("https://totp.letusflow.net/genCode.php?secret={$row["secret"]}");
    $code = genCode($row["secret"]);

    if ($i == 0) {
        echo $code;
        $i++;
    }
    else {
        echo ",$code";
    }

}

