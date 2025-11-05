<?php
require __DIR__.'/auth.php';
require_role('admin'); // <-- solo admins
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel | Atlético Trelle</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="panel.css">
</head>
<body>
<header>
  <h1>Atlético Trelle</h1>
  <nav>
    <ul>
      <li><a href="index.html">Inicio</a></li>
      <li><a href="jugadores.html">Jugadores</a></li>
      <li><a href="galeria.html">Galería</a></li>
      <li><a href="historia.html">Historia y Directiva</a></li>
      <li><a href="tienda.php">Tienda</a></li>
      <li><a href="haztesocio.php">Hazte socio</a></li>
      <li><a class="activo" href="panel.php">Panel</a></li>
      <li><a href="logout.php">Cerrar sesión</a></li>
    </ul>
  </nav>
</header>

<main class="seccion">
  <h2>Panel de administración</h2>
  <p>Área de administración:</p>
  <a class="btn" href="admin_socio.php">Xestionar solicitudes de socios</a>
</main>
</body>
</html>
