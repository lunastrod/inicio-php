<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host     = 'sql203.infinityfree.com';
$user     = 'if0_41845437';
$password = 'aNesfIfZK170h6';
$db       = 'if0_41845437';

$mysqli = new mysqli($host, $user, $password);

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');
$mysqli->select_db($db);

if (!$mysqli->query("DROP TABLE IF EXISTS enlaces")) {
    die("Error al borrar tabla: " . $mysqli->error);
}

$sql = "
    CREATE TABLE enlaces (
        id     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(150)  NOT NULL,
        url    VARCHAR(2048) NOT NULL,
        tipo   VARCHAR(100)  NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
";

if (!$mysqli->query($sql)) {
    die("Error al crear tabla: " . $mysqli->error);
}

$inserts = [
    ['ChatGPT',         'https://chat.openai.com',          'IA'],
    ['Claude',          'https://claude.ai',                'IA'],
    ['Gemini',          'https://gemini.google.com',        'IA'],
    ['Perplexity',      'https://www.perplexity.ai',        'IA'],
    ['Gmail',           'https://mail.google.com',          'Google'],
    ['Google Drive',    'https://drive.google.com',         'Google'],
    ['Google Calendar', 'https://calendar.google.com',      'Google'],
    ['Google Maps',     'https://maps.google.com',          'Google'],
    ['GitHub',          'https://github.com',               'Programacion'],
    ['Stack Overflow',  'https://stackoverflow.com',        'Programacion'],
    ['MDN Web Docs',    'https://developer.mozilla.org',    'Programacion'],
    ['Can I Use',       'https://caniuse.com',              'Programacion'],
    ['PHP Manual',      'https://www.php.net/manual/es',    'Programacion'],
    ['Twitter',         'https://twitter.com',              'Redes Sociales'],
    ['LinkedIn',        'https://www.linkedin.com',         'Redes Sociales'],
    ['Instagram',       'https://www.instagram.com',        'Redes Sociales'],
];

$stmt = $mysqli->prepare("INSERT INTO enlaces (nombre, url, tipo) VALUES (?, ?, ?)");

foreach ($inserts as [$nombre, $url, $tipo]) {
    $stmt->bind_param('sss', $nombre, $url, $tipo);
    $stmt->execute();
}

echo "Tabla 'enlaces' creada e insertados " . count($inserts) . " registros de ejemplo.";