<?php
$activePage = 'jugadores';
require __DIR__.'/config.php';

$playersStmt = $pdo->query('SELECT nombre, apodo, slug, posicion, dorsal, descripcion_corta, imagen_principal FROM jugadores ORDER BY nombre');
$players = $playersStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugadores - Atlético Trelle</title>
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="jugadores.css">
</head>
<body>
    <?php include __DIR__.'/includes/header.php'; ?>

    <main>
        <h2 class="page-title">Atlético Trelle - Jugadores</h2>

        <section class="jugadores">
            <?php foreach ($players as $player): ?>
                <?php
                    $image = $player['imagen_principal'] ?: 'ImagenesJugadores/placeholder.svg';
                    $name = htmlspecialchars($player['nombre']);
                    $position = $player['posicion'] ? htmlspecialchars($player['posicion']) : 'Jugador del Atlético Trelle';
                    $dorsal = $player['dorsal'] ? 'Dorsal ' . htmlspecialchars($player['dorsal']) : null;
                    $description = $player['descripcion_corta'] ? htmlspecialchars($player['descripcion_corta']) : null;
                ?>
                <article class="jugador">
                    <div class="jugador-imagen">
                        <img src="<?= htmlspecialchars($image) ?>" alt="<?= $name ?>">
                    </div>
                    <div class="jugador-texto">
                        <h3>
                            <?= $name ?>
                            <?php if (!empty($player['apodo'])): ?>
                                <span class="jugador-apodo">“<?= htmlspecialchars($player['apodo']) ?>”</span>
                            <?php endif; ?>
                        </h3>
                        <p class="jugador-posicion">Posición: <?= $position ?></p>
                        <?php if ($dorsal): ?>
                            <p class="jugador-dorsal"><?= $dorsal ?></p>
                        <?php endif; ?>
                        <?php if ($description): ?>
                            <p class="jugador-desc"><?= $description ?></p>
                        <?php endif; ?>
                        <a class="btn-perfil" href="jugador.php?slug=<?= urlencode($player['slug']) ?>">Ver perfil</a>
                    </div>
                </article>
            <?php endforeach; ?>

            <?php if (!$players): ?>
                <p class="jugadores-vacio">Aún no hay jugadores registrados. ¡Pronto añadiremos a todo el plantel!</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Atlético Trelle. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
