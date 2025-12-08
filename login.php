<?php
require __DIR__ . '/auth.php';

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
    if ($nombre === '')
      $errores[] = 'El nombre es obligatorio.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      $errores[] = 'Introduce un correo electrónico válido.';
    if (!preg_match('/@gmail\.com$/', $email))
      $errores[] = 'El correo debe terminar en @gmail.com.';
    if (strlen($password) < 6)
      $errores[] = 'La contraseña debe tener al menos 6 caracteres.';
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
      $errores[] = 'La contraseña debe contener letras y números.';
    }
    if ($email === 'admin@trelle.com')
      $errores[] = 'Las credenciales de administrador están reservadas.';

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
  <?php include __DIR__ . '/includes/header-simple.php'; ?>

  <main class="auth-grid">
    <section class="seccion accordion-section" id="login">
      <h2 class="accordion-header">
        <span>Iniciar sesión</span>
        <span class="accordion-icon">▼</span>
      </h2>
      <div class="accordion-content">
        <p>Accede a tu cuenta para mantener tu carrito y ventajas de socio.</p>
        <?php if ($loginError): ?>
          <p class="alert-err"><b><?= htmlspecialchars($loginError) ?></b></p><?php endif; ?>
        <form class="form" method="post">
          <input type="hidden" name="action" value="login">
          <label>Email</label>
          <input type="email" name="email" required pattern="^(admin@trelle\.com|[A-Za-z0-9._%+-]+@gmail\.com)$"
            title="Introduce un correo que termine en @gmail.com" value="<?= htmlspecialchars($loginEmailValue) ?>">
          <label>Contraseña</label>
          <input type="password" name="password" required>
          <button class="btn">Entrar</button>
        </form>
      </div>
    </section>

    <section class="seccion accordion-section" id="register">
      <h2 class="accordion-header">
        <span>Crear cuenta</span>
        <span class="accordion-icon">▼</span>
      </h2>
      <div class="accordion-content">
        <p>Regístrate para que tu carrito y tus pedidos queden guardados.</p>
        <?php if ($registroError): ?>
          <p class="alert-err"><b><?= htmlspecialchars($registroError) ?></b></p><?php endif; ?>
        <form class="form" method="post">
          <input type="hidden" name="action" value="register">
          <label>Nombre</label>
          <input name="nombre" required value="<?= htmlspecialchars($registroDatos['nombre']) ?>">
          <label>Apellidos</label>
          <input name="apellidos" value="<?= htmlspecialchars($registroDatos['apellidos']) ?>">
          <label>Fecha de nacimiento</label>
          <input type="date" name="fecha_nacimiento"
            value="<?= htmlspecialchars($registroDatos['fecha_nacimiento']) ?>">
          <label>Correo electrónico</label>
          <input type="email" name="email" required pattern="^[A-Za-z0-9._%+-]+@gmail\.com$"
            title="El correo debe terminar en @gmail.com" value="<?= htmlspecialchars($registroDatos['email']) ?>">
          <label>Contraseña</label>
          <input type="password" name="password" required minlength="6" pattern="(?=.*[A-Za-z])(?=.*\d).+"
            title="La contraseña debe incluir letras y números">
          <button class="btn">Registrarme</button>
        </form>
      </div>
    </section>
  </main>

  <script>
    (function () {
      // Accordion functionality for mobile/tablet
      function initAccordion() {
        const headers = document.querySelectorAll('.accordion-header');

        headers.forEach(header => {
          header.addEventListener('click', function () {
            const section = this.closest('.accordion-section');
            const allSections = document.querySelectorAll('.accordion-section');
            const icon = this.querySelector('.accordion-icon');

            // Check if this section is already active
            const isActive = section.classList.contains('active');

            // Close all sections first
            allSections.forEach(s => {
              s.classList.remove('active');
              const sIcon = s.querySelector('.accordion-icon');
              if (sIcon) sIcon.style.transform = 'rotate(0deg)';
            });

            // If it wasn't active, open it
            if (!isActive) {
              section.classList.add('active');
              if (icon) icon.style.transform = 'rotate(180deg)';
            }
          });
        });
      }

      // Auto-open section if there's an error or register param
      function autoOpenSection() {
        const params = new URLSearchParams(window.location.search);
        const hasLoginError = <?= $loginError ? 'true' : 'false' ?>;
        const hasRegisterError = <?= $registroError ? 'true' : 'false' ?>;

        // Open login if login error
        if (hasLoginError) {
          const loginSection = document.getElementById('login');
          const loginIcon = document.querySelector('#login .accordion-icon');
          if (loginSection) loginSection.classList.add('active');
          if (loginIcon) loginIcon.style.transform = 'rotate(180deg)';
        }

        // Open register if register error or tab=register
        if (hasRegisterError || params.get('tab') === 'register') {
          const registerSection = document.getElementById('register');
          const registerIcon = document.querySelector('#register .accordion-icon');
          if (registerSection) {
            registerSection.classList.add('active');
            registerSection.scrollIntoView({ behavior: 'smooth' });
          }
          if (registerIcon) registerIcon.style.transform = 'rotate(180deg)';
        }

        // Default: open login if no errors
        if (!hasLoginError && !hasRegisterError && params.get('tab') !== 'register') {
          const loginSection = document.getElementById('login');
          const loginIcon = document.querySelector('#login .accordion-icon');
          if (loginSection) loginSection.classList.add('active');
          if (loginIcon) loginIcon.style.transform = 'rotate(180deg)';
        }
      }

      // Initialize
      initAccordion();
      autoOpenSection();
    })();
  </script>

</body>

</html>