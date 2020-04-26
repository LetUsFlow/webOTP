<?php
/**
 * >> PHP <<
 * >> user.php <<
 * (c) Florentin Schäfer 2019
 */

require "secret.php";


#  time()+3600*24*60

if (isset($_GET["logout"])) {
    deleteCookies(getPDOObject());
    header("Location: index.php");
}


function checkUser($db) {


    if (!(isset($_COOKIE["clientkey"]))) { // Es sind keine Cookies gesetzt
        if (isset($_POST["username"]) && isset($_POST["password"])) { // Der Benutzer will sich anmelden

            $user = $db->quote($_POST["username"]);

            
            $stmt = $db->prepare("SELECT * FROM users WHERE username=?");
            $stmt->execute([$user]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row === false) return ["status" => false, "reason" => "wrongdata"]; // Anmeldung fehlgeschlagen
            if (!password_verify($_POST["password"], base64_decode($row["passwordhash"]))) return ["status" => false, "reason" => "wrongdata"]; // Anmeldung fehlgeschlagen


            $clientkey = hash("sha256", bin2hex(openssl_random_pseudo_bytes(255)));

            setcookie("clientkey", $clientkey, time() + 3600 * 24 * 60, "/", $_SERVER["HTTP_HOST"]);
            $db = getPDOObject();
            $stmt = $db->prepare("INSERT INTO sessions (username, clientkey, lastupdatetime) VALUES (?, '$clientkey', current_timestamp())");
            $stmt->execute([$user]);


            return ["status" => true, "username" => $row["username"]];

        }
        return ["status" => false, "reason" => "nosession"];
    }

    $clientkey = $_COOKIE["clientkey"];




    $stmt = $db->prepare("SELECT * FROM sessions WHERE clientkey=?");
    $stmt->execute([$clientkey]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        deleteCookies($db);
        return ["status" => false, "reason" => "unknownsession"];
    }


    if (strtotime($row["lastupdatetime"]) + 3600 * 24 * 60 < time()) {
        deleteCookies($db);
        return ["status" => false, "reason" => "sessionexpired"]; // Zeit abgelaufen
    }

    return ["status" => true, "username" => $row["username"]];
}

function deleteCookies($db) {
    setcookie("clientkey", "", time() - 3600, "/", $_SERVER["HTTP_HOST"]);
    $stmt = $db->prepare("DELETE FROM sessions WHERE sessions.clientkey = '?'");
    $stmt->execute([$_COOKIE["clientkey"]]);
}
