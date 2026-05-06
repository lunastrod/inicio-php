<?php

require_once 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqli = new mysqli($host, $user, $password, $db);

if ($mysqli->connect_error) {
    http_response_code(500);
    die("Connection error: " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');