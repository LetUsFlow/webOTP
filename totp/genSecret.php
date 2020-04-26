<?php
require "TOTP.php";
echo Greymich\TOTP\TOTP::genSecret(128);
