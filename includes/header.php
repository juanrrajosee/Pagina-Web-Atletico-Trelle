<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$activePage = $activePage ?? '';
$usuarioLogueado = !empty($_SESSION['uid']);
$rol = $_SESSION['rol'] ?? null;
$isAdmin = $usuarioLogueado && $rol === 'admin';

// Texto e icono de burbuja de sesión 
$bubbleText = $usuarioLogueado ? 'Cerrar Sesión' : 'Inicie Sesión';
$bubbleLink = $usuarioLogueado ? 'logout.php' : 'index.php';
$bubbleClass = $usuarioLogueado ? 'session-bubble logout' : 'session-bubble login';
?>
<header class="site-header">
    <h1>Atlético Trelle</h1>
    <a class="<?= $bubbleClass ?>" href="<?= $bubbleLink ?>"><?= $bubbleText ?></a>

    <nav>
        <ul>
            <?php if ($isAdmin): ?>
                <li><a class="<?= $activePage === 'panel' ? 'activo' : '' ?>" href="panel.php">Panel</a></li>
            <?php else: ?>
                <li><a class="<?= $activePage === 'inicio' ? 'activo' : '' ?>" href="inicio.php">Inicio</a></li>
                <li><a class="<?= $activePage === 'jugadores' ? 'activo' : '' ?>" href="jugadores.php">Jugadores</a></li>
                <li><a class="<?= $activePage === 'galeria' ? 'activo' : '' ?>" href="galeria.php">Galería</a></li>
                <li><a class="<?= $activePage === 'historia' ? 'activo' : '' ?>" href="historia.php">Historia y
                        Directiva</a></li>
                <li><a class="<?= $activePage === 'haztesocio' ? 'activo' : '' ?>" href="haztesocio.php">Hazte Socio</a>
                </li>
                <li><a class="<?= $activePage === 'tienda' ? 'activo' : '' ?>" href="tienda.php">Tienda</a></li>
            <?php endif; ?>


        </ul>
    </nav>
</header>