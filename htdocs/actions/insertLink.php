<?php
require_once '../includes/debug.php';
require_once '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Method not allowed.");
}

$name     = trim($_POST['name'] ?? '');
$url      = trim($_POST['url'] ?? '');
$section  = trim($_POST['section'] ?? '');
$category = trim($_POST['category'] ?? '');

if ($name === '' || $url === '' || $section === '' || $category === '') {
    http_response_code(400);
    die("Name, URL, section, and category fields are required.");
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    die("The URL is invalid.");
}

$stmt = $mysqli->prepare("INSERT INTO links (name, url, section, category) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $name, $url, $section, $category);

if ($stmt->execute()) {
    header("Location: ../manage.php?status=inserted");
    exit;
} else {
    http_response_code(500);
    die("Insert error: " . $mysqli->error);
}
