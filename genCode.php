<?php
/**
 * >> PHP <<
 * >> genCode.php <<
 * (c) Florentin Schäfer 2019
 */


require "TOTP.php";

/*$secret = $_GET["secret"];
$otp = new Greymich\TOTP\TOTP($secret);
echo $otp->get();*/


function genCode($secret) {
    //$secret = $_GET["secret"];
    $otp = new Greymich\TOTP\TOTP($secret);
    return $otp->get();
}
