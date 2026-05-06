<?php
require_once 'includes/debug.php';
require_once 'includes/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Links</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header>
        <h1>Management Portal</h1>
        <nav class="header-actions">
            <a href="index.php" class="primary-action">&lt;- Back to Dashboard</a>
            <a href="actions/createTable.php" class="primary-action">Create Table</a>
            <a href="actions/exportLinks.php" class="primary-action">Export Links</a>
        </nav>
    </header>

    <main>
        <table class="manage-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Section</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $mysqli->query("SELECT * FROM links ORDER BY section ASC, category ASC, name ASC");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td>
                            <input type="text" name="name" class="field__input" value="<?= htmlspecialchars($row['name']) ?>" required>
                        </td>
                        <td>
                            <input type="url" name="url" class="field__input" value="<?= htmlspecialchars($row['url']) ?>" required>
                        </td>
                        <td>
                            <input type="text" name="section" class="field__input" value="<?= htmlspecialchars($row['section']) ?>" required>
                        </td>
                        <td>
                            <input type="text" name="category" class="field__input" value="<?= htmlspecialchars($row['category']) ?>" required>
                        </td>
                        <td class="actions-cell">
                            <button type="submit" formaction="actions/updateLink.php" class="primary-action">SAVE</button>
                            <button type="submit" formaction="actions/deleteLink.php" class="primary-action" 
                                    onclick="return confirm('Delete this link?')">DEL</button>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>

                <tr class="add-row-bg">
                    <form action="actions/insertLink.php" method="POST">
                        <td>
                            <input type="text" name="name" class="field__input" placeholder="New Name" required>
                        </td>
                        <td>
                            <input type="url" name="url" class="field__input" placeholder="https://..." required>
                        </td>
                        <td>
                            <input type="text" name="section" class="field__input" placeholder="Section" required>
                        </td>
                        <td>
                            <input type="text" name="category" class="field__input" placeholder="Category" required>
                        </td>
                        <td class="actions-cell">
                            <button type="submit" class="primary-action">+ ADD NEW</button>
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>
