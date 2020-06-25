<?php
/**
 * >> webOTP <<
 * >> logout.php <<
 * (c) Florentin Schäfer 2020
 */

require "../verify.php";

if (verify()["status"] === "success") {
    getPDO()
        ->prepare("DELETE FROM session WHERE sessiontoken=?")
        ->execute([$_COOKIE["sessiontoken"]]);

    setcookie("sessiontoken", "", time() - 3600, "/");
}
header("Location: ../index.php");
