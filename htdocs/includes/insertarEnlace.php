<?php

require __DIR__ . '/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método no permitido.");
}

$nombre = trim($_POST['nombre'] ?? '');
$url    = trim($_POST['url']    ?? '');
$tipo   = trim($_POST['tipo']   ?? '');

if ($nombre === '' || $url === '' || $tipo === '') {
    http_response_code(400);
    die("Los campos nombre, url y tipo son obligatorios.");
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    die("La URL no es válida.");
}

$stmt = $mysqli->prepare("INSERT INTO enlaces (nombre, url, tipo) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $nombre, $url, $tipo);

if ($stmt->execute()) {
    header("Location: ../index.php");
    exit;
} else {
    http_response_code(500);
    echo "Error al insertar: " . $mysqli->error;
}