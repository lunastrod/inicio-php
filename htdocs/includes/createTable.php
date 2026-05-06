<?php
require_once 'conn.php';

if (!$mysqli->query("DROP TABLE IF EXISTS links")) {
    die("Error deleting table: " . $mysqli->error);
}

$sql = "
    CREATE TABLE links (
        id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name     VARCHAR(150)  NOT NULL,
        url      VARCHAR(2048) NOT NULL,
        category VARCHAR(100)  NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
";

if (!$mysqli->query($sql)) {
    die("Error creating table: " . $mysqli->error);
}

$inserts = [
    ['ChatGPT',         'https://chat.openai.com',          'IA'],
    ['Claude',          'https://claude.ai',                'IA'],
    ['Gemini',          'https://gemini.google.com',         'IA'],
    ['Perplexity',      'https://www.perplexity.ai',         'IA'],
    ['Gmail',           'https://mail.google.com',          'Google'],
    ['Google Drive',    'https://drive.google.com',          'Google'],
    ['Google Calendar', 'https://calendar.google.com',       'Google'],
    ['Google Maps',     'https://maps.google.com',           'Google'],
    ['GitHub',          'https://github.com',               'Programacion'],
    ['Stack Overflow',  'https://stackoverflow.com',         'Programacion'],
    ['MDN Web Docs',    'https://developer.mozilla.org',     'Programacion'],
    ['Can I Use',       'https://caniuse.com',               'Programacion'],
    ['PHP Manual',      'https://www.php.net/manual/es',     'Programacion'],
    ['Twitter',         'https://twitter.com',               'Redes Sociales'],
    ['LinkedIn',        'https://www.linkedin.com',          'Redes Sociales'],
    ['Instagram',       'https://www.instagram.com',         'Redes Sociales'],
];

$stmt = $mysqli->prepare("INSERT INTO links (name, url, category) VALUES (?, ?, ?)");

foreach ($inserts as [$name, $url, $category]) {
    $stmt->bind_param('sss', $name, $url, $category);
    $stmt->execute();
}

echo "Table 'links' created and " . count($inserts) . " sample records inserted.";