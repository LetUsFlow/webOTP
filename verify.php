<?php
/**
 * >> webOTP <<
 * >> verify.php <<
 * (c) Florentin Schäfer 2020
 */


session_start();

function verify() {
    if ($_SESSION["auth"]) { // Basically ist der Nutzer eingeloggt
        if (isset($_SESSION["username"]) && isset($_SESSION["lastlogin"])) { // Prüfe, ob alle Elemete existent
            if ($_SESSION["lastlogin"]+(3600*24*30) > time()) { // Letzer Login war innerhalb des letzen Monats
                $_SESSION["lastlogin"] = time();
                return ["status" => "success", "username" => $_SESSION["username"]];
            }
        }
    }
    session_destroy(); // Sicherheitshalber
    return ["status" => "error"];
}

function getPDO() {
    return new PDO("mysql:host=localhost;dbname=webotp", "root", "");
}
