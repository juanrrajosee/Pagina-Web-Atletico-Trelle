<?php
require __DIR__.'/auth.php';

$tab = $_GET['tab'] ?? 'login';
$loginError = '';
$registroError = '';
$registroDatos = [
  'nombre' => '',
  'apellidos' => '',
  'fecha_nacimiento' => '',
  'email' => ''
];
$loginEmailValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $accion = $_POST['action'] ?? 'login';

  if ($accion === 'login') {
    $tab = 'login';
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
  } elseif ($accion === 'register') {
    global $pdo;
    $tab = 'register';

    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $fechaNacimiento = trim($_POST['fecha_nacimiento'] ?? '');
    $email = trim(strtolower($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $registroDatos = [
      'nombre' => $nombre,
      'apellidos' => $apellidos,
      'fecha_nacimiento' => $fechaNacimiento,
      'email' => $email,
    ];

    $errores = [];
    if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Introduce un correo electrónico válido.';
    if (!preg_match('/@gmail\.com$/', $email)) $errores[] = 'El correo debe terminar en @gmail.com.';
    if (strlen($password) < 6) $errores[] = 'La contraseña debe tener al menos 6 caracteres.';
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
      $errores[] = 'La contraseña debe contener letras y números.';
    }
    if ($email === 'admin@trelle.com') $errores[] = 'Las credenciales de administrador están reservadas.';

    $fechaSql = null;
    if ($fechaNacimiento !== '') {
      $fechaObj = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
      if ($fechaObj && $fechaObj->format('Y-m-d') === $fechaNacimiento) {
        $fechaSql = $fechaNacimiento;
      } else {
        $errores[] = 'La fecha de nacimiento no es válida.';
      }
    }

    if (!$errores) {
      try {
        $pdo->prepare('INSERT INTO usuarios (nombre, apellidos, fecha_nacimiento, email, pass_hash) VALUES (?,?,?,?,?)')
            ->execute([
              $nombre,
              $apellidos !== '' ? $apellidos : null,
              $fechaSql,
              $email,
              password_hash($password, PASSWORD_DEFAULT)
            ]);

        // NO auto-login: alert + redirección a la pestaña de login
        echo "<script>alert('Usuario registrado correctamente. Ahora inicia sesión para acceder a tus ventajas.'); window.location.href='login.php?tab=login';</script>";
        exit;
      } catch (Throwable $e) {
        $registroError = 'No se pudo registrar el usuario. ¿Ya existe ese correo?';
      }
    } else {
      $registroError = implode(' ', $errores);
      $loginEmailValue = '';
    }
  }
}
$activePage = 'login';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Acceso | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="login.css">
</head>
<body>
<?php include __DIR__.'/includes/header.php'; ?>

<main class="auth-grid">
  <section class="seccion" id="login">
    <h2>Iniciar sesión</h2>
    <p>Accede a tu cuenta para mantener tu carrito y ventajas de socio.</p>
    <?php if($loginError): ?><p class="alert-err"><b><?=htmlspecialchars($loginError)?></b></p><?php endif; ?>
    <form class="form" method="post">
      <input type="hidden" name="action" value="login">
      <label>Email</label>
      <input type="email" name="email" required
             pattern="^(admin@trelle\.com|[A-Za-z0-9._%+-]+@gmail\.com)$"
             title="Introduce un correo que termine en @gmail.com"
             value="<?=htmlspecialchars($loginEmailValue)?>">
      <label>Contraseña</label>
      <input type="password" name="password" required>
      <button class="btn">Entrar</button>
    </form>
  </section>

  <section class="seccion" id="register">
    <h2>Crear cuenta</h2>
    <p>Regístrate para que tu carrito y tus pedidos queden guardados.</p>
    <?php if($registroError): ?><p class="alert-err"><b><?=htmlspecialchars($registroError)?></b></p><?php endif; ?>
    <form class="form" method="post">
      <input type="hidden" name="action" value="register">
      <label>Nombre</label>
      <input name="nombre" required value="<?=htmlspecialchars($registroDatos['nombre'])?>">
      <label>Apellidos</label>
      <input name="apellidos" value="<?=htmlspecialchars($registroDatos['apellidos'])?>">
      <label>Fecha de nacimiento</label>
      <input type="date" name="fecha_nacimiento" value="<?=htmlspecialchars($registroDatos['fecha_nacimiento'])?>">
      <label>Correo electrónico</label>
      <input type="email" name="email" required
             pattern="^[A-Za-z0-9._%+-]+@gmail\.com$"
             title="El correo debe terminar en @gmail.com"
             value="<?=htmlspecialchars($registroDatos['email'])?>">
      <label>Contraseña</label>
      <input type="password" name="password" required minlength="6"
             pattern="(?=.*[A-Za-z])(?=.*\d).+"
             title="La contraseña debe incluir letras y números">
      <button class="btn">Registrarme</button>
    </form>
  </section>
</main>

<script>
// Si vienes con ?tab=register, desplaza el foco visual ahí
(function() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('tab') === 'register') {
    const el = document.getElementById('register');
    if (el) el.scrollIntoView({behavior: 'smooth'});
  }
})();
</script>

</body>
</html>
