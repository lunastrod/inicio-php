<?php
// https://lunastrod-inicio.free.nf/actions/createTable.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/debug.php';
require_once '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Links Table</title>
        <link rel="stylesheet" href="../css/dashboard.css">
    </head>
    <body>
        <header>
            <h1>Create Links Table</h1>
            <a href="../manage.php" class="primary-action">&lt;- Back to Manage</a>
        </header>

        <main>
            <section class="category">
                <h2 class="category__title">Confirm reset</h2>
                <p class="warning-text">
                    This will delete the current links table and recreate it with the default links.
                </p>
                <form method="POST">
                    <button type="submit" name="confirm" value="yes" class="primary-action">
                        DELETE AND RECREATE
                    </button>
                </form>
            </section>
        </main>
    </body>
    </html>
    <?php
    exit;
}

if (($_POST['confirm'] ?? '') !== 'yes') {
    http_response_code(400);
    die("Confirmation required.");
}

echo '<p><a href="../manage.php">Back to Manage</a></p>';
echo "<pre>";
echo "Connected to database.\n";

if (!$mysqli->query("DROP TABLE IF EXISTS links")) {
    die("Error deleting table: " . $mysqli->error);
}

echo "Old 'links' table dropped if it existed.\n";

$sql = "
    CREATE TABLE links (
        id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name     VARCHAR(150)  NOT NULL,
        url      VARCHAR(2048) NOT NULL,
        section  VARCHAR(100)  NOT NULL,
        category VARCHAR(100)  NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
";

if (!$mysqli->query($sql)) {
    die("Error creating table: " . $mysqli->error);
}

echo "New 'links' table created.\n";

$inserts = [
    ['Bases de Datos', 'https://campus.europaeducationgroup.es/courses/116295/modules', 'Clase', 'Bases de Datos'],
    ['Teams 1', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_MTY4NTJjYWQtYTQwZS00NmVmLWE0MzQtMjQ2ZDVhN2Y4MWIw%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%2241dd77d0-bb1a-4580-9e0e-10046d348140%22%7d', 'Clase', 'Bases de Datos'],
    ['Teams 2', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_OWUyNTA0MzEtNGYxZS00NzM5LThlZmUtNTk2ZGFmYTA3OTU4%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%2241dd77d0-bb1a-4580-9e0e-10046d348140%22%7d', 'Clase', 'Bases de Datos'],
    ['Entornos de Desarrollo', 'https://campus.europaeducationgroup.es/courses/116675/modules', 'Clase', 'Entornos de Desarrollo'],
    ['Teams', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_OTlhMWMzYTYtNDQzZC00NWQxLTlhYTItNTkzODdhODI2NTlj%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%225e7e0fcc-01f3-4250-83e5-c11873c6ca89%22%7d', 'Clase', 'Entornos de Desarrollo'],
    ['Itinerario Empleabilidad', 'https://campus.europaeducationgroup.es/courses/106795/modules', 'Clase', 'Itinerario Empleabilidad'],
    ['Teams', 'https://teams.microsoft.com/l/meetup-join/19%3aoT4A0fFYSM2YDq1yxaF0jJ__sB9nl31xKrVcBwuetnk1%40thread.tacv2/1759480418753?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%2245a6ec04-a8ba-4a53-8542-3b5c86a1f6ca%22%7d', 'Clase', 'Itinerario Empleabilidad'],
    ['Lenguajes de Marcas', 'https://campus.europaeducationgroup.es/courses/114391/modules', 'Clase', 'Lenguajes de Marcas'],
    ['Teams', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_MDU2MTE1MDYtMzQxYi00ZGZhLWJlZDItODAzYzY2NzdmY2Q2%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%225e7e0fcc-01f3-4250-83e5-c11873c6ca89%22%7d', 'Clase', 'Lenguajes de Marcas'],
    ['Programación', 'https://campus.europaeducationgroup.es/courses/104848/modules', 'Clase', 'Programación'],
    ['Teams (Jueves)', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_NTk2ZmUxNWUtNDMzNC00N2MwLThkMWYtOTJmY2JlNzMxMTQy%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%22275b1295-4877-4add-aed9-4db0ba9c8425%22%7d', 'Clase', 'Programación'],
    ['Teams (Martes)', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_MjVmYTc1ZDctOGZkNi00Y2Y1LThmZGEtODgyNjk0YmU0ODJk%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%22275b1295-4877-4add-aed9-4db0ba9c8425%22%7d', 'Clase', 'Programación'],
    ['Robótica', 'https://campus.europaeducationgroup.es/courses/103874/modules', 'Clase', 'Robótica'],
    ['Teams', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_Y2U4YTU5OTYtYWJlNS00NTZmLWE5N2MtODIwYWFmMjRkNjVk%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%2241dd77d0-bb1a-4580-9e0e-10046d348140%22%7d', 'Clase', 'Robótica'],
    ['Sistemas Informáticos', 'https://campus.europaeducationgroup.es/courses/113313/modules', 'Clase', 'Sistemas Informáticos'],
    ['Teams (Jueves)', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_MDQwYjgzNTQtNWQwZS00MzJiLWI0YWYtNWQzYTRkMzZlNGVl%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%225e7e0fcc-01f3-4250-83e5-c11873c6ca89%22%7d', 'Clase', 'Sistemas Informáticos'],
    ['Teams (Lunes)', 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_OTlhMWMzYTYtNDQzZC00NWQxLTlhYTItNTkzODdhODI2NTlj%40thread.v2/0?context=%7b%22Tid%22%3a%22cfab0009-84b7-4397-a0f8-f77cdf1579c1%22%2c%22Oid%22%3a%225e7e0fcc-01f3-4250-83e5-c11873c6ca89%22%7d', 'Clase', 'Sistemas Informáticos'],
    ['Google Docs', 'https://docs.google.com/document/u/0/', 'Productivity', 'Google'],
    ['Google Drive', 'https://drive.google.com/drive/u/0/home', 'Productivity', 'Google'],
    ['TickTick', 'https://ticktick.com/webapp/#q/all/tasks', 'Productivity', 'Tareas'],
    ['GitHub', 'https://github.com/lunastrod', 'Programación', 'Git'],
    ['repo DAM', 'https://github.com/lunastrod/DAM-general', 'Programación', 'Git'],
    ['Claude', 'https://claude.ai/new', 'Programación', 'IA'],
    ['Gemini', 'https://gemini.google.com/app', 'Programación', 'IA'],
    ['Z', 'https://chat.z.ai/', 'Programación', 'IA'],
    ['Gmail', 'https://mail.google.com/mail/u/0/?hl=es#inbox', 'Social', 'Comunicación'],
    ['Telegram', 'https://web.telegram.org/k/', 'Social', 'Comunicación'],
    ['WhatsApp', 'https://web.whatsapp.com/', 'Social', 'Comunicación'],
    ['Reddit', 'https://www.reddit.com/', 'Social', 'RRSS'],
    ['YouTube', 'https://www.youtube.com/', 'Social', 'RRSS'],
];

$stmt = $mysqli->prepare("INSERT INTO links (name, url, section, category) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    die("Error preparing insert: " . $mysqli->error);
}

foreach ($inserts as [$name, $url, $section, $category]) {
    $stmt->bind_param('ssss', $name, $url, $section, $category);

    if (!$stmt->execute()) {
        die("Error inserting '{$name}': " . $stmt->error);
    }
}

echo "Table 'links' created and " . count($inserts) . " sample records inserted.";
echo "</pre>";
