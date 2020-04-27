<?php
/**
 * >> PHP <<
 * >> getCodes.php <<
 * (c) Florentin Schäfer 2019
 */

require "../secret.php";
require "../totp/TOTP.php";

$username = "florentin";

$stmt = getPDO()->prepare("SELECT totpId, secret, issuer FROM totp WHERE username=? ORDER BY totpId");
$stmt->execute([$username]);
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);


$codes = [];
foreach ($res as $row) {
    $codes[] = [
        "id" => $row["totpId"],
        "code" => genCode($row["secret"]),
        "issuer" => $row["issuer"]
    ];
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
