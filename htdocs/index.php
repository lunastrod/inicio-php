<?php require 'includes/conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
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
    <a href="nuevo.php" class="btn-new">+ new link</a>
</header>

<main>
<?php
$result = $mysqli->query("SELECT DISTINCT category FROM links ORDER BY category ASC");

while ($row = $result->fetch_assoc()):
    $category = $row['category'];

    $stmt = $mysqli->prepare("SELECT name, url FROM links WHERE category = ? ORDER BY name ASC");
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $links = $stmt->get_result();
?>
    <section class="category">
        <h2 class="category__title"><?= htmlspecialchars($category) ?></h2>
        <div class="category__links">
            <?php while ($link = $links->fetch_assoc()): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-link">
                    <?= htmlspecialchars($link['name']) ?>
                </a>
            <?php endwhile; ?>
        </div>
    </section>
<?php endwhile; ?>
</main>

</body>
</html>