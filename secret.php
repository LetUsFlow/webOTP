<?php
/**
 * >> PHP <<
 * >> secret.php <<
 * (c) Florentin Schäfer 2019
 */

function getPDOObject() {
    #$db = new PDO("sqlite:db.sqlite"); # SQLite
    $db = new PDO("mysql:host=localhost;dbname=webotp", "mysqladmin", "yitu9hYLFBlQn3tQG93c8lpkBUXOVUQaOqvRK6NnE3f1gC82IIaOfZTV30Nf2Ylq"); # MySQL
    return $db;
}

