<?php

$password = "password";

$passwordsalt = hash("sha3-512", get_random_bytes(2048));
$passwordhash = hash("sha3-512", $password . $passwordsalt);
echo "Salt: " . $passwordsalt;
echo "\n<br>Hash: " . $passwordhash;


function get_random_bytes($length) {
    try {
        return random_bytes($length);
    } catch (Exception $e) {
        return openssl_random_pseudo_bytes($length);
    }
}
