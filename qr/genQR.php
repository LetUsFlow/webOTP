<?php
/**
 * >> PHP <<
 * >> genQR.php <<
 * (c) Florentin Schäfer 2019
 */

require "../totp/TOTP.php";
require "phpqrcode.php";

$secret = $_GET["secret"];
$issuer = $_GET["issuer"];
$user = $_GET["user"];

$otp = new Greymich\TOTP\TOTP($secret);
$uri = $otp->uri($user, null, null, $issuer);


QRcode::png($uri);
