<?php
require __DIR__ . '/auth.php';

$loginError = '';
$loginEmailValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim(strtolower($_POST['email'] ?? ''));
  $password = $_POST['password'] ?? '';
  $loginEmailValue = $email;

  $esCorreoValido = $email === 'admin@trelle.com' || preg_match('/@gmail\.com$/', $email);
  if (!$esCorreoValido) {
    $loginError = 'El correo debe terminar en @gmail.com.';
  } elseif (login($email, $password)) {
    if (($_SESSION['rol'] ?? '') === 'admin') {
      header('Location: panel.php');
    } else {
      header('Location: inicio.php');
    }
    exit;
  } else {
    $loginError = 'Credenciales incorrectas.';
  }
}
$activePage = 'login';
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main class="auth-container">
    <section class="seccion">
      <h2>Iniciar sesión</h2>
      <p>Accede a tu cuenta para mantener tu carrito y ventajas de socio.</p>
      <?php if ($loginError): ?>
        <p class="alert-err"><b><?= htmlspecialchars($loginError) ?></b></p><?php endif; ?>
      <form class="form" method="post">
        <label>Email</label>
        <input type="email" name="email" required pattern="^(admin@trelle\.com|[A-Za-z0-9._%+-]+@gmail\.com)$"
          title="Introduce un correo que termine en @gmail.com" value="<?= htmlspecialchars($loginEmailValue) ?>">
        <label>Contraseña</label>
        <input type="password" name="password" required>
        <button class="btn">Entrar</button>
      </form>
      <div class="registro-link">
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        <p style="margin-top: 10px;"><a href="inicio.php"
            style="color: #666; font-size: 0.9em; text-decoration: none;">Entrar como invitado</a></p>
      </div>
    </section>
  </main>

</body>

</html>