<?php

require __DIR__ . '/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Method not allowed.");
}

$name     = trim($_POST['nombre'] ?? '');
$url      = trim($_POST['url']    ?? '');
$category = trim($_POST['tipo']   ?? '');

if ($name === '' || $url === '' || $category === '') {
    http_response_code(400);
    die("Name, URL, and category fields are required.");
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    die("The URL is invalid.");
}

$stmt = $mysqli->prepare("INSERT INTO links (name, url, category) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $name, $url, $category);

if ($stmt->execute()) {
    header("Location: ../index.php");
    exit;
} else {
    http_response_code(500);
    echo "Insert error: " . $mysqli->error;
}