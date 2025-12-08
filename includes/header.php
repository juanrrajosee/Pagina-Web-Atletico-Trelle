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

// Ocultar burbuja en páginas de autenticación (login y registro)
$mostrarBurbuja = !in_array($activePage, ['login', 'registro']);

// Ocultar navegación en páginas de autenticación y panel
$mostrarNavegacion = !in_array($activePage, ['login', 'registro', 'panel']);
?>
<header class="site-header">
    <h1>Atlético Trelle</h1>
    <?php if ($mostrarBurbuja): ?>
        <a class="<?= $bubbleClass ?> desktop-only" href="<?= $bubbleLink ?>"><?= $bubbleText ?></a>
    <?php endif; ?>

    <?php if ($mostrarNavegacion): ?>
        <!-- Botón hamburger solo visible en móvil -->
        <button class="hamburger-menu" id="hamburger" aria-label="Menú">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav id="mainNav">
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
                <!-- Enlace de sesión para móvil -->
                <li class="nav-session-link">
                    <a href="<?= $bubbleLink ?>"><?= $bubbleText ?></a>
                </li>

            </ul>
        </nav>
    <?php endif; ?>
</header>

<script>
    // Toggle menú hamburger
    document.addEventListener('DOMContentLoaded', function () {
        const hamburger = document.getElementById('hamburger');
        const nav = document.getElementById('mainNav');

        if (hamburger && nav) {
            hamburger.addEventListener('click', function () {
                this.classList.toggle('active');
                nav.classList.toggle('active');
            });

            // Cerrar menú al hacer click en un enlace (solo en móvil)
            const navLinks = nav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768) {
                        hamburger.classList.remove('active');
                        nav.classList.remove('active');
                    }
                });
            });
        }
    });
</script>