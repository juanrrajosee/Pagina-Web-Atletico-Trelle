<?php
require __DIR__.'/config.php';
$ok = false;
$err = '';
$usuarioLogueado = !empty($_SESSION['uid']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre    = trim($_POST['nombre'] ?? '');
  $apellidos = trim($_POST['apellidos'] ?? '');
  $email     = trim($_POST['email'] ?? '');
  $telefono  = trim($_POST['telefono'] ?? '');
  $coment    = trim($_POST['comentarios'] ?? '');

  if ($nombre === '' || $email === '') {
    $err = 'Nome e email son obrigatorios.';
  } else {
    try {
      $st = $pdo->prepare("INSERT INTO socios(nombre, apellidos, email, telefono, comentarios) VALUES (?,?,?,?,?)");
      $st->execute([$nombre, $apellidos, $email, $telefono, $coment]);
      $ok = true;
    } catch (Throwable $e) {
      $err = 'Produciuse un erro ao gardar a solicitude.';
    }
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Hazte Socio | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css"><!-- tu css general si lo tienes -->
  <link rel="stylesheet" href="haztesocio.css">
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
      <li><a class="activo" href="haztesocio.php">Hazte socio</a></li>
      <?php if ($usuarioLogueado): ?>
        <li><a href="panel.php">Panel</a></li>
        <li><a href="logout.php">Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="login.php">Acceso</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main class="seccion">
  <h2>Hazte Socio</h2>

  <?php if ($ok): ?>
    <p class="alert-ok"><b>Solicitude enviada correctamente.</b> En breve contactaremos contigo. Grazas!</p>
  <?php elseif ($err): ?>
    <p class="alert-err"><b><?= htmlspecialchars($err) ?></b></p>
  <?php endif; ?>

  <form class="form" method="post" action="haztesocio.php" novalidate>
    <label>Nome*</label>
    <input name="nombre" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

    <label>Apelidos</label>
    <input name="apellidos" value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>">

    <label>Email*</label>
    <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label>Teléfono</label>
    <input name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

    <label>Comentarios</label>
    <textarea name="comentarios"><?= htmlspecialchars($_POST['comentarios'] ?? '') ?></textarea>

    <button class="btn">Enviar Solicitud</button>
  </form>
</main>

<footer>
  <p>&copy; 2025 Atlético Trelle. Todos los derechos reservados.</p>
</footer>
</body>
</html>
