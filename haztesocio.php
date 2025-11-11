<?php
require __DIR__ . '/config.php';

$ok = false;
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre   = trim($_POST['nombre'] ?? '');
  $apellidos = trim($_POST['apellidos'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $telefono = trim($_POST['telefono'] ?? '');
  $coment   = trim($_POST['comentarios'] ?? '');

  if ($nombre === '' || $email === '') {
    $err = 'Nome e email son obrigatorios.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err = 'O email non é válido.';
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

<main class="seccion socio-page">
  <header class="socio-intro">
    <h2>Hazte Socio</h2>
    <p>Completa el formulario para solicitar tu carnet y disfruta de todas las ventajas reservadas para nuestra afición.</p>
  </header>

  <?php if ($ok): ?>
    <p class="alert-ok"><b>Solicitude enviada correctamente.</b> En breve contactaremos contigo. Grazas!</p>
  <?php elseif ($err): ?>
    <p class="alert-err"><b><?= htmlspecialchars($err) ?></b></p>
  <?php endif; ?>

  <div class="socio-grid">
    <section class="socio-form">
      <h3>Datos de contacto</h3>
      <form class="form" method="post" action="haztesocio.php" novalidate>
        <div class="form-field">
          <label for="nombre">Nome*</label>
          <input id="nombre" name="nombre" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
        </div>

        <div class="form-field">
          <label for="apellidos">Apelidos</label>
          <input id="apellidos" name="apellidos" value="<?= htmlspecialchars($_POST['apellidos'] ?? '') ?>">
        </div>

        <div class="form-field">
          <label for="email">Email*</label>
          <input id="email" type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="form-field">
          <label for="telefono">Teléfono</label>
          <input id="telefono" name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
        </div>

        <div class="form-field">
          <label for="comentarios">Comentarios</label>
          <textarea id="comentarios" name="comentarios" rows="4"><?= htmlspecialchars($_POST['comentarios'] ?? '') ?></textarea>
        </div>

        <button class="btn" type="submit">Enviar solicitud</button>
      </form>
    </section>

    <aside class="socio-visual" aria-label="Carnets de socio del Atlético Trelle">
      <figure>
        <img src="ImagenesInicio/imagen_portada.JPG" alt="Carnets de socio del Atlético Trelle" loading="lazy">
        <figcaption>Reemplaza esta imagen por la de tus nuevos carnets. Mantén un formato horizontal para un resultado óptimo.</figcaption>
      </figure>
      <ul class="socio-benefits">
        <li>Descuentos exclusivos en la tienda oficial.</li>
        <li>Preferencia en eventos y partidos especiales.</li>
        <li>Comunicación directa con el club para actividades.</li>
      </ul>
    </aside>
  </div>
</main>

<footer class="site-footer">
  <p>&copy; <?= date('Y') ?> Atlético Trelle. Todos los derechos reservados.</p>
</footer>

</body>
</html>
