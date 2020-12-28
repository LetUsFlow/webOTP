<?php

$password = "password";

echo "Hash: " . password_hash($password, PASSWORD_ARGON2ID) . "\n";
# https://wiki.php.net/rfc/argon2_password_hash_enhancements
