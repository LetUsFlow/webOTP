<?php
/**
 * >> webOTP <<
 * >> login.php <<
 * (c) Florentin Schäfer 2020
 */

require "../verify.php";


if (verify()["status"] === "success") header("Location: ../dash.php");
elseif (isset($_POST["username"]) && isset($_POST["password"]) && trim($_POST["username"]) !== "" && trim($_POST["password"]) !== "") {

    if (!checkCredentials($_POST["username"], $_POST["password"])) errorexit("credentials");

    $sessiontoken = hash("sha3-512", openssl_random_pseudo_bytes(2056));

    $stmt = getPDO()->prepare("INSERT INTO session (sessiontoken, username, useragent, lastupdatetime) VALUES (?, ?, ?, current_timestamp())");
    $stmt->execute([$sessiontoken, checkCredentials($_POST["username"], $_POST["password"]), $_SERVER["HTTP_USER_AGENT"]]);


    setcookie("sessiontoken", $sessiontoken, time() + 3600 * 24 * 90, "/"); // ALle 90 Tage soll sich der Nutzer anmelden müssen

    header("Location: ../dash.php");
}
else errorexit("invalid_input");


function errorexit($errorcode) {
    sleep(4); // limit requests / brute-force protection
    header("Location: ../index.php?code=$errorcode");
}


function checkCredentials($username, $password) {
    $stmt = getPDO()->prepare("SELECT username, passwordhash FROM `users` WHERE username=?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() != 1) return false;

    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!password_verify($password, $res["passwordhash"])) return false;

    return $res["username"];
}
