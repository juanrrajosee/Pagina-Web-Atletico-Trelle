<?php
require __DIR__ . '/config.php';
$ok = false;
$err = '';
$usuarioLogueado = !empty($_SESSION['uid']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre    = trim($_POST['nombre'] ?? '');
  $apellidos = trim($_POST['apellidos'] ?? '');
  $email     = trim($_POST['email'] ?? '');
  $telefono  = trim($_POST['telefono'] ?? '');
  $coment    = trim($_POST['comentarios'] ?? '');

  if (!$usuarioLogueado) {
    $err = 'Debes iniciar sesión para enviar la solicitud de socio.';
  } elseif ($nombre === '' || $email === '') {
    $err = 'Nome e email son obrigatorios.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
    $err = 'O correo debe ser válido e rematar en @gmail.com.';
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

$activePage = 'haztesocio';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Hazte Socio | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="haztesocio.css">
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<main class="seccion">
  <h2>Hazte Socio</h2>

  <?php if ($ok): ?>
    <p class="alert-ok"><b>Solicitude enviada correctamente.</b> En breve contactaremos contigo. Grazas!</p>
  <?php elseif ($err): ?>
    <p class="alert-err"><b><?= htmlspecialchars($err) ?></b></p>
  <?php endif; ?>

  <div class="socio-layout">
    <div class="socio-form">
      <form class="form" method="post" action="haztesocio.php" novalidate>
        <label>Nome*</label>
        <input name="nombre" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label>Apelidos</label>
        <input name="apellidos" value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>">

        <label>Email*</label>
        <input type="email" name="email" required pattern="^[A-Za-z0-9._%+-]+@gmail\.com$" title="O correo debe rematar en @gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label>Teléfono</label>
        <input name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

        <label>Comentarios</label>
        <textarea name="comentarios"><?= htmlspecialchars($_POST['comentarios'] ?? '') ?></textarea>

        <button class="btn">Enviar Solicitud</button>
      </form>
    </div>

    <aside class="socio-visual" aria-label="Imagen promocional de la campaña de socios">
      <img src="ImagenesInicio/imagen_portada.JPG" alt="Afición del Atlético Trelle animando" loading="lazy">
    </aside>
  </div>
</main>

<footer>
  <p>&copy; 2025 Atlético Trelle. Todos los derechos reservados.</p>
</footer>

<script>
(function() {
  const puedeSolicitar = <?= $usuarioLogueado ? 'true' : 'false' ?>;
  const form = document.querySelector('.socio-form form');
  if (!puedeSolicitar && form) {
    form.addEventListener('submit', function(ev) {
      ev.preventDefault();
      alert('No puedes hacerte socio sin iniciar sesión previamente.');
    });
  }
})();
</script>

</body>
</html>
