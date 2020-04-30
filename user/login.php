<?php
/**
 * >> webOTP <<
 * >> login.php <<
 * (c) Florentin Schäfer 2020
 */

require "../verify.php";


if (verify()["status"] === "success") {
    header("Location: ../dash.php");
}
elseif (isset($_POST["username"]) && isset($_POST["password"])) {
    $res = login($_POST["username"], $_POST["password"]);

    if ($res["status"] === "error") header("Location: ../index.php?{$res["reason"]}");

    // Setze Session
    $_SESSION["username"] = $res["username"];
    $_SESSION["auth"] = true;
    $_SESSION["lastlogin"] = time();

    header("Location: ../dash.php");
}
else {
    header("Location: ../index.php");
}


function login($username, $password) {
    $stmt = getPDO()->prepare("SELECT username, passwordhash FROM users WHERE username=?");
    $stmt->execute([$username]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($res) != 1) return ["status" => "error", "reason" => "wrongdata"];

    $user = $res[0];
    if (!password_verify($password, base64_decode($user["passwordhash"]))) return ["status" => "error", "reason" => "wrongdata"]; // Anmeldung fehlgeschlagen

    return ["status" => "success", "username" => $user["username"]];
}
