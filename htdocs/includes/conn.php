<?php
require_once 'debug.php';
require_once 'config.php';

$mysqli = new mysqli($host, $user, $password, $db);

if ($mysqli->connect_error) {
    http_response_code(500);
    die("Connection error: " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');