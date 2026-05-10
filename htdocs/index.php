<?php 
require 'includes/conn.php'; 
require_once 'includes/debug.php';
?>
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
    <link rel="icon" type="image/png" href="img/icon.png">
</head>
<body>

<header>
    <h1>Dashboard</h1>
    <a href="manage.php" class="primary-action">+ edit</a>
</header>

<main class="dashboard">
<?php
$sections = $mysqli->query("SELECT DISTINCT section FROM links ORDER BY section ASC");

while ($sectionRow = $sections->fetch_assoc()):
    $section = $sectionRow['section'];

    $categoryStmt = $mysqli->prepare("SELECT DISTINCT category FROM links WHERE section = ? ORDER BY category ASC");
    $categoryStmt->bind_param('s', $section);
    $categoryStmt->execute();
    $categories = $categoryStmt->get_result();
?>
    <section class="dashboard-section">
        <h2 class="dashboard-section__title"><?= htmlspecialchars($section) ?></h2>
        <div class="dashboard-section__categories">
            <?php while ($categoryRow = $categories->fetch_assoc()):
                $category = $categoryRow['category'];

                $linkStmt = $mysqli->prepare("SELECT name, url FROM links WHERE section = ? AND category = ? ORDER BY name ASC");
                $linkStmt->bind_param('ss', $section, $category);
                $linkStmt->execute();
                $links = $linkStmt->get_result();
            ?>
                <section class="category">
                    <h3 class="category__title"><?= htmlspecialchars($category) ?></h3>
                    <div class="category__links">
                        <?php while ($link = $links->fetch_assoc()): ?>
                            <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-link">
                                <?= htmlspecialchars($link['name']) ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endwhile; ?>
        </div>
    </section>
<?php endwhile; ?>
</main>

</body>
</html>
