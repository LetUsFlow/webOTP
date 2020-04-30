<?php
/**
 * >> PHP <<
 * >> getCodes.php <<
 * (c) Florentin Schäfer 2019
 */

require "../verify.php";
require "TOTP.php";

if (verify()["status"] === "success") $username = verify()["username"];
else header("Location: ../index.php");


$stmt = getPDO()->prepare("SELECT totpId, secret, issuer FROM webotp.keys WHERE username=? ORDER BY totpId");
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
