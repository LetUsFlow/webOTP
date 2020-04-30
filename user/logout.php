<?php
/**
 * >> webOTP <<
 * >> logout.php <<
 * (c) Florentin Schäfer 2020
 */

require "../verify.php";

if (verify()["status"] === "success") {
    logout();
}

header("Location: ../index.php");


function logout() {
    session_destroy();
}
