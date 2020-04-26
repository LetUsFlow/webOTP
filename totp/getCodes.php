<?php
/**
 * >> PHP <<
 * >> getCodes.php <<
 * (c) Florentin Schäfer 2019
 */


require "user.php";
require "TOTP.php";

/*$data = checkUser(getPDOObject());
if ($data["status"]) $username = $data["username"];
else {
    header("Location: index.php?{$data["reason"]}");
}*/


$username = "florentin";

$stmt = getPDO()->prepare("SELECT secret FROM totp WHERE username=?");
$stmt->execute([$username]);
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);



foreach ($res as $i => $row) {
    $code = genCode($row["secret"]);

    if ($i == 0) echo $code;
    else echo ",$code";

}

function genCode($secret) {
    $otp = new Greymich\TOTP\TOTP($secret);
    try {
        return $otp->get();
    } catch (Exception $e) {
    }
}
