<?php
/**
 * >> PHP <<
 * >> getCodes.php <<
 * (c) Florentin Schäfer 2019
 */

require "../secret.php";
require "../totp/TOTP.php";

$username = "florentin";

$stmt = getPDO()->prepare("SELECT secret FROM totp WHERE username=?");
$stmt->execute([$username]);
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);


$codes = [];
foreach ($res as $row) {
    $codes[] = genCode($row["secret"]);
}
echo json_encode($codes);



function genCode($secret) {
    $otp = new Greymich\TOTP\TOTP($secret);
    try {
        return $otp->get();
    } catch (Exception $e) {
        echo $e;
    }
    return false;
}
