<?php
/**
 * >> Frontend <<
 * >> verify.php <<
 * (c) Florentin Schäfer 2020
 * Verifies if the user is logged in, has to be required in every other file
 * It also includes the authentication-data for the MariaDB-database
 */

session_start();

if(count(get_included_files()) == 1) {
    $verification = verify();
    if ($verification["status"] === "success") exit(json_encode($verification));
    else exit(json_encode($verification));
}

function verify() {
    if (isset($_COOKIE["sessiontoken"])) {
        $stmt = getPDO()->prepare("SELECT * FROM session WHERE sessiontoken=?");
        $stmt->execute([$_COOKIE["sessiontoken"]]);
        if ($stmt->rowCount() > 1) { // Da ist was gewaltig schief gelaufen lol
            getPDO()->prepare("DELETE FROM session WHERE sessiontoken=?")->execute([$_COOKIE["sessiontoken"]]);
            return ["status" => "error", "code" => "database_error"];
        }
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row["useragent"] === $_SERVER["HTTP_USER_AGENT"]) {
                if (strtotime($row["lastupdatetime"]) > (time() - 3600 * 24 * 30)) { // Nutzer hat sich innerhalb der letzten 30 Tage eingeloggt
                    getPDO()
                        ->prepare("UPDATE session SET lastupdatetime=current_timestamp() WHERE sessiontoken=?")
                        ->execute([$_COOKIE["sessiontoken"]]);
                    return ["status" => "success", "username" => $row["username"]];
                }
                return ["status" => "error", "code" => "session_expired"];
            }
            return ["status" => "error", "code" => "unrecognized_browser"];
        }
    }

    return ["status" => "error", "code" => "forbidden"];
}

function getPDO() {
    $host = "localhost";
    $dbname = "webotp";
    $username = "root";
    $passwd = "";
    return new PDO("mysql:host=$host;dbname=$dbname", $username, $passwd);
}
