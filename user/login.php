<?php
/**
 * >> webOTP <<
 * >> login.php <<
 * (c) Florentin Schäfer 2020
 */

require "../secret.php";



function login($username, $password) {
    $stmt = getPDO()->prepare("SELECT username, passwordhash FROM users WHERE username=?");
    $stmt->execute([$username]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($res) != 1) return ["status" => "error", "reason" => "wrongdata"];

    $user = $res[0];
    if (!password_verify($password, base64_decode($user["passwordhash"]))) return ["status" => "error", "reason" => "wrongdata"]; // Anmeldung fehlgeschlagen

    return ["status" => "success", "username" => $user["username"]];
}
