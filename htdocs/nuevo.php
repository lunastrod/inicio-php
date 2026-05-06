<?php require 'includes/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo enlace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<header>
    <h1>Nuevo enlace</h1>
    <a href="index.php" class="header__back">volver</a>
</header>

<main>
    <section class="categoria form-wrapper">
        <form action="includes/insertarEnlace.php" method="POST">

            <div class="field">
                <label class="field__label" for="nombre">Nombre</label>
                <input class="field__input" type="text" id="nombre" name="nombre" required maxlength="150" autocomplete="off">
            </div>

            <div class="field">
                <label class="field__label" for="url">URL</label>
                <input class="field__input" type="url" id="url" name="url" required maxlength="2048" autocomplete="off" placeholder="https://">
            </div>

            <div class="field">
                <label class="field__label" for="tipo">Tipo</label>
                <input class="field__input" type="text" id="tipo" name="tipo" required maxlength="100"
                       list="tipos-existentes" autocomplete="off">
                <datalist id="tipos-existentes">
                    <?php
                    $result = $mysqli->query("SELECT DISTINCT tipo FROM enlaces ORDER BY tipo ASC");
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <option value="<?= htmlspecialchars($row['tipo']) ?>">
                    <?php endwhile; ?>
                </datalist>
            </div>

            <button type="submit" class="btn-submit">Guardar enlace</button>

        </form>
    </section>
</main>

</body>
</html>
