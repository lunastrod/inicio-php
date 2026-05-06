<?php require 'includes/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<header>
    <h1>Dashboard</h1>
    <a href="nuevo.php" class="btn-nuevo">+ nuevo enlace</a>
</header>

<main>
<?php

$result = $mysqli->query("SELECT DISTINCT tipo FROM enlaces ORDER BY tipo ASC");

while ($row = $result->fetch_assoc()):
    $tipo = $row['tipo'];

    $stmt = $mysqli->prepare("SELECT nombre, url FROM enlaces WHERE tipo = ? ORDER BY nombre ASC");
    $stmt->bind_param('s', $tipo);
    $stmt->execute();
    $enlaces = $stmt->get_result();
?>
    <section class="categoria">
        <h2 class="categoria__titulo"><?= htmlspecialchars($tipo) ?></h2>
        <div class="categoria__enlaces">
            <?php while ($enlace = $enlaces->fetch_assoc()): ?>
                <a href="<?= htmlspecialchars($enlace['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-enlace">
                    <?= htmlspecialchars($enlace['nombre']) ?>
                </a>
            <?php endwhile; ?>
        </div>
    </section>
<?php endwhile; ?>
</main>

</body>
</html>