<?php
require_once '../includes/debug.php';
require_once '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Method not allowed.");
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    die("Valid ID required for deletion.");
}

$stmt = $mysqli->prepare("DELETE FROM links WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header("Location: ../manage.php?status=deleted");
    exit;
} else {
    http_response_code(500);
    die("Delete error: " . $mysqli->error);
}
