<?php

$host     = '';
$db       = '';
$user     = '';
$password = '';

$mysqli = new mysqli($host, $user, $password, $db);

if ($mysqli->connect_error) {
    http_response_code(500);
    die("Error de conexión: " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');
