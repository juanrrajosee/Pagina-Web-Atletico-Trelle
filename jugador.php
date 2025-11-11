<?php
$activePage = 'jugadores';
require __DIR__.'/config.php';

$slug = $_GET['slug'] ?? '';
$slug = is_string($slug) ? trim($slug) : '';
$errorMessage = null;

if ($slug === '') {
    http_response_code(404);
    $errorMessage = 'Jugador no encontrado.';
} else {
    $stmt = $pdo->prepare('SELECT * FROM jugadores WHERE slug = ? LIMIT 1');
    $stmt->execute([$slug]);
    $jugador = $stmt->fetch();

    if (!$jugador) {
        http_response_code(404);
        $errorMessage = 'Jugador no encontrado.';
    }
}

if (!empty($errorMessage)) {
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Jugador no encontrado - Atlético Trelle</title>
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="jugador_perfil.css">
</head>
<body class="perfil-error">
<?php include __DIR__.'/includes/header.php'; ?>
<main class="perfil-jugador">
    <section class="perfil-error-box">
        <h2><?= htmlspecialchars($errorMessage) ?></h2>
        <p>El jugador que buscas no está disponible en este momento.</p>
        <a class="btn-perfil" href="jugadores.php">Volver al listado de jugadores</a>
    </section>
</main>
</body>
</html>
<?php
    exit;
}

$fechaNacimiento = $jugador['fecha_nacimiento'] ?? null;
$edad = null;
$fechaNacimientoTexto = null;
if ($fechaNacimiento) {
    try {
        $nacimiento = new DateTime($fechaNacimiento);
        $fechaNacimientoTexto = $nacimiento->format('d/m/Y');
        $edad = (new DateTime())->diff($nacimiento)->y;
    } catch (Exception $e) {
        $fechaNacimientoTexto = $fechaNacimiento;
    }
}

$debutClub = $jugador['debut_club'] ?? null;
$debutTexto = null;
if ($debutClub) {
    try {
        $debut = new DateTime($debutClub);
        $debutTexto = $debut->format('d/m/Y');
    } catch (Exception $e) {
        $debutTexto = $debutClub;
    }
}

$altura = $jugador['altura_cm'] ? $jugador['altura_cm'].' cm' : null;
$peso = $jugador['peso_kg'] ? $jugador['peso_kg'].' kg' : null;
$pierna = $jugador['pierna_habil'] ?: null;
$nacionalidad = $jugador['nacionalidad'] ?: null;
$lugarNacimiento = $jugador['lugar_nacimiento'] ?: null;

$trayectoria = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string)($jugador['trayectoria'] ?? ''))));
$estadisticas = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string)($jugador['estadisticas'] ?? ''))));
$palmares = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string)($jugador['palmares'] ?? ''))));
$hayBloques = $trayectoria || $estadisticas || $palmares;

$heroImage = $jugador['imagen_portada'] ?: 'ImagenesJugadores/placeholder.svg';
$playerImage = $jugador['imagen_principal'] ?: 'ImagenesJugadores/placeholder.svg';
$descripcion = $jugador['descripcion_corta'] ?: null;
$biografia = $jugador['biografia'] ?: null;
$videoUrl = $jugador['video_url'] ?: null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($jugador['nombre']) ?> - Atlético Trelle</title>
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="jugador_perfil.css">
</head>
<body>
<?php include __DIR__.'/includes/header.php'; ?>

<main class="perfil-jugador">
    <section class="perfil-hero" style="background-image: url('<?= htmlspecialchars($heroImage, ENT_QUOTES) ?>');">
        <div class="perfil-hero-overlay"></div>
        <div class="perfil-hero-content">
            <figure class="perfil-hero-photo">
                <img src="<?= htmlspecialchars($playerImage, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($jugador['nombre']) ?>">
            </figure>
            <div class="perfil-hero-texto">
                <?php if (!empty($jugador['dorsal'])): ?>
                    <span class="perfil-hero-dorsal">#<?= htmlspecialchars($jugador['dorsal']) ?></span>
                <?php endif; ?>
                <h2>
                    <?= htmlspecialchars($jugador['nombre']) ?>
                    <?php if (!empty($jugador['apodo'])): ?>
                        <span class="perfil-hero-apodo">“<?= htmlspecialchars($jugador['apodo']) ?>”</span>
                    <?php endif; ?>
                </h2>
                <?php if (!empty($jugador['posicion'])): ?>
                    <p class="perfil-hero-posicion">Posición: <?= htmlspecialchars($jugador['posicion']) ?></p>
                <?php endif; ?>
                <?php if ($descripcion): ?>
                    <p class="perfil-hero-resumen"><?= htmlspecialchars($descripcion) ?></p>
                <?php endif; ?>
                <div class="perfil-hero-tags">
                    <?php if ($edad !== null): ?>
                        <span>Edad: <?= $edad ?> años</span>
                    <?php endif; ?>
                    <?php if ($altura): ?>
                        <span>Altura: <?= htmlspecialchars($altura) ?></span>
                    <?php endif; ?>
                    <?php if ($peso): ?>
                        <span>Peso: <?= htmlspecialchars($peso) ?></span>
                    <?php endif; ?>
                    <?php if ($pierna): ?>
                        <span>Pierna hábil: <?= htmlspecialchars($pierna) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="perfil-detalles">
        <div class="detalles-grid">
            <?php if ($fechaNacimientoTexto): ?>
                <article class="detalle-card">
                    <h3>Fecha de nacimiento</h3>
                    <p><?= htmlspecialchars($fechaNacimientoTexto) ?><?= $edad !== null ? ' · '.$edad.' años' : '' ?></p>
                </article>
            <?php endif; ?>
            <?php if ($lugarNacimiento): ?>
                <article class="detalle-card">
                    <h3>Lugar</h3>
                    <p><?= htmlspecialchars($lugarNacimiento) ?></p>
                </article>
            <?php endif; ?>
            <?php if ($nacionalidad): ?>
                <article class="detalle-card">
                    <h3>Nacionalidad</h3>
                    <p><?= htmlspecialchars($nacionalidad) ?></p>
                </article>
            <?php endif; ?>
            <?php if ($debutTexto): ?>
                <article class="detalle-card">
                    <h3>Debut con el club</h3>
                    <p><?= htmlspecialchars($debutTexto) ?></p>
                </article>
            <?php endif; ?>
            <?php if ($altura): ?>
                <article class="detalle-card">
                    <h3>Altura</h3>
                    <p><?= htmlspecialchars($altura) ?></p>
                </article>
            <?php endif; ?>
            <?php if ($peso): ?>
                <article class="detalle-card">
                    <h3>Peso</h3>
                    <p><?= htmlspecialchars($peso) ?></p>
                </article>
            <?php endif; ?>
            <?php if ($pierna): ?>
                <article class="detalle-card">
                    <h3>Pierna hábil</h3>
                    <p><?= htmlspecialchars($pierna) ?></p>
                </article>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($biografia): ?>
        <section class="perfil-bio">
            <h3>Biografía</h3>
            <p><?= nl2br(htmlspecialchars($biografia)) ?></p>
        </section>
    <?php endif; ?>

    <?php if ($hayBloques): ?>
        <section class="perfil-bloques">
            <?php if ($trayectoria): ?>
                <article class="perfil-card">
                    <h3>Trayectoria</h3>
                    <ul>
                        <?php foreach ($trayectoria as $linea): ?>
                            <li><?= htmlspecialchars($linea) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endif; ?>

            <?php if ($estadisticas): ?>
                <article class="perfil-card">
                    <h3>Estadísticas recientes</h3>
                    <ul>
                        <?php foreach ($estadisticas as $linea): ?>
                            <li><?= htmlspecialchars($linea) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endif; ?>

            <?php if ($palmares): ?>
                <article class="perfil-card">
                    <h3>Palmarés y reconocimientos</h3>
                    <ul>
                        <?php foreach ($palmares as $linea): ?>
                            <li><?= htmlspecialchars($linea) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <?php if ($videoUrl): ?>
        <section class="perfil-video">
            <h3>Highlights</h3>
            <div class="video-wrapper">
                <iframe src="<?= htmlspecialchars($videoUrl) ?>" title="Vídeo de <?= htmlspecialchars($jugador['nombre']) ?>" allowfullscreen loading="lazy"></iframe>
            </div>
        </section>
    <?php endif; ?>

    <div class="perfil-volver">
        <a href="jugadores.php" class="link-volver">&larr; Volver al listado de jugadores</a>
    </div>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Atlético Trelle. Todos los derechos reservados.</p>
</footer>
</body>
</html>
