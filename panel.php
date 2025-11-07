<?php
require __DIR__.'/auth.php';
require_role('admin'); // Solo admins
$activePage = 'panel';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="panel.css">
</head>
<body>
<?php include __DIR__.'/includes/header.php'; ?>

<main class="seccion">
  <h2>Panel de administración</h2>
  <p>Área de administración:</p>
  <a class="btn" href="admin_socio.php">Xestionar solicitudes de socios</a>
</main>

</body>
</html>
