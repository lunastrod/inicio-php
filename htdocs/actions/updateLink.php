<?php
require_once '../includes/debug.php';
require_once '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Method not allowed.");
}

$id       = intval($_POST['id'] ?? 0);
$name     = trim($_POST['name'] ?? '');
$url      = trim($_POST['url'] ?? '');
$section  = trim($_POST['section'] ?? '');
$category = trim($_POST['category'] ?? '');

if ($id <= 0 || $name === '' || $url === '' || $section === '' || $category === '') {
    http_response_code(400);
    die("All fields are required for update.");
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    die("The URL is invalid.");
}

$stmt = $mysqli->prepare("UPDATE links SET name = ?, url = ?, section = ?, category = ? WHERE id = ?");
$stmt->bind_param('ssssi', $name, $url, $section, $category, $id);

if ($stmt->execute()) {
    header("Location: ../manage.php?status=updated");
    exit;
} else {
    http_response_code(500);
    die("Update error: " . $mysqli->error);
}
