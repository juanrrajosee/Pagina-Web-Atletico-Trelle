<?php require __DIR__.'/auth.php'; require_login(); ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="paginas.css">
</head>
<body>
<header class="topbar">
  <a href="index.html">Inicio</a>
  <span>Panel</span>
  <a href="logout.php" style="float:right">Saír</a>
</header>

<main class="seccion">
  <h2>Benvido, <?=htmlspecialchars($_SESSION['nombre'])?> (<?=htmlspecialchars($_SESSION['rol'])?>)</h2>

  <?php if($_SESSION['rol']==='admin'): ?>
    <p>Área de administración:</p>
    <a class="btn" href="admin_socio.php">Xestionar solicitudes de socios</a>
  <?php else: ?>
    <p>Área de socio: vantaxes, datos de membro e novidades do club.</p>
  <?php endif; ?>
</main>
</body>
</html>
