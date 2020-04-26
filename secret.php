<?php
/**
 * >> PHP <<
 * >> secret.php <<
 * (c) Florentin Schäfer 2019
 */

function getPDO() {
    return new PDO("mysql:host=localhost;dbname=webotp", "root", "");
}
