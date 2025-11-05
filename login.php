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
    if (login($email, $password)) {
      header('Location: panel.php');
      exit;
    }
    $loginError = 'Credenciales incorrectas.';
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
    if (strlen($password) < 6) $errores[] = 'La contraseña debe tener al menos 6 caracteres.';
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

        // NO auto-login: alert + redirección a index.php
        echo "<script>alert('Usuario registrado correctamente. Ahora inicia sesión para acceder a tus ventajas.'); window.location.href='index.php';</script>";
        exit;

      } catch (PDOException $e) {
        if ((int)$e->getCode() === 23000) {
          $registroError = 'Ya existe una cuenta con ese correo electrónico.';
        } else {
          $registroError = 'No se pudo completar el registro. Inténtalo de nuevo.';
        }
      }
    } else {
      $registroError = implode(' ', $errores);
      $loginEmailValue = '';
    }
  }
}
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
      <li><a class="activo" href="login.php">Acceso</a></li>
    </ul>
  </nav>
</header>

<main class="auth-grid">
  <section class="seccion" id="login">
    <h2>Iniciar sesión</h2>
    <p>Accede a tu cuenta para mantener tu carrito y ventajas de socio.</p>
    <?php if($loginError): ?><p class="alert-err"><b><?=htmlspecialchars($loginError)?></b></p><?php endif; ?>
    <form class="form" method="post">
      <input type="hidden" name="action" value="login">
      <label>Email</label>
      <input type="email" name="email" required value="<?=htmlspecialchars($loginEmailValue)?>">
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
      <input type="email" name="email" required value="<?=htmlspecialchars($registroDatos['email'])?>">
      <label>Contraseña</label>
      <input type="password" name="password" required minlength="6">
      <button class="btn">Registrarme</button>
    </form>
  </section>
</main>
</body>
</html>
