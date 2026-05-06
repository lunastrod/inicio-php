<?php
// https://lunastrod-inicio.free.nf/actions/exportLinks.php
require_once '../includes/debug.php';
require_once '../includes/conn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

// Note: Ensure your 'links' table actually has a 'section' column now
$query = "SELECT name, url, section, category FROM links ORDER BY section, category, name";
$result = $mysqli->query($query);

if (!$result) {
    die("Error fetching data: " . htmlspecialchars($mysqli->error));
}

echo '<p><a href="../manage.php">Back to Manage</a></p>';
echo '<pre>';
echo htmlspecialchars("\$inserts = [\n");

while ($row = $result->fetch_assoc()) {
    // Escaping single quotes to avoid PHP syntax errors
    $name     = addslashes($row['name']);
    $url      = addslashes($row['url']);
    $section  = addslashes($row['section']);
    $category = addslashes($row['category']);

    // Outputs: ['Name', 'URL', 'Section', 'Category'],
    echo htmlspecialchars("    ['$name', '$url', '$section', '$category'],\n");
}

echo htmlspecialchars("];\n");
echo '</pre>';
