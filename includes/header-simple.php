<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuarioLogueado = !empty($_SESSION['uid']);
$bubbleText = $usuarioLogueado ? 'Cerrar Sesión' : 'Inicie Sesión';
$bubbleLink = $usuarioLogueado ? 'logout.php' : 'index.php';
$bubbleClass = $usuarioLogueado ? 'session-bubble logout' : 'session-bubble login';
?>
<header class="site-header">
    <h1>Atlético Trelle</h1>
    <a class="<?= $bubbleClass ?>" href="<?= $bubbleLink ?>"><?= $bubbleText ?></a>
</header>