<?php
require __DIR__ . '/auth.php';

$registroError = '';
$registroDatos = [
    'nombre' => '',
    'apellidos' => '',
    'fecha_nacimiento' => '',
    'email' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;

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

            // Iniciar sesión automáticamente después del registro
            if (login($email, $password)) {
                // Registro exitoso: redirigir al inicio
                echo "<script>alert('¡Registro exitoso! Bienvenido a Atlético Trelle.'); window.location.href='inicio.php';</script>";
                exit;
            } else {
                $registroError = 'Usuario registrado pero no se pudo iniciar sesión. Por favor, inicia sesión manualmente.';
            }
        } catch (Throwable $e) {
            $registroError = 'No se pudo registrar el usuario. ¿Ya existe ese correo?';
        }
    } else {
        $registroError = implode(' ', $errores);
    }
}
$activePage = 'registro';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta | Atlético Trelle</title>
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="auth-container">
        <section class="seccion">
            <h2>Crear cuenta</h2>
            <p>Regístrate para que tu carrito y tus pedidos queden guardados.</p>
            <?php if ($registroError): ?>
                <p class="alert-err"><b><?= htmlspecialchars($registroError) ?></b></p><?php endif; ?>
            <form class="form" method="post">
                <label>Nombre</label>
                <input name="nombre" required value="<?= htmlspecialchars($registroDatos['nombre']) ?>">
                <label>Apellidos</label>
                <input name="apellidos" value="<?= htmlspecialchars($registroDatos['apellidos']) ?>">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento"
                    value="<?= htmlspecialchars($registroDatos['fecha_nacimiento']) ?>">
                <label>Correo electrónico</label>
                <input type="email" name="email" required pattern="^[A-Za-z0-9._%+-]+@gmail\.com$"
                    title="El correo debe terminar en @gmail.com"
                    value="<?= htmlspecialchars($registroDatos['email']) ?>">
                <label>Contraseña</label>
                <input type="password" name="password" required minlength="6" pattern="(?=.*[A-Za-z])(?=.*\d).+"
                    title="La contraseña debe incluir letras y números">
                <button class="btn">Registrarme</button>
            </form>
            <div class="registro-link">
                <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                <p style="margin-top: 10px;"><a href="inicio.php"
                        style="color: #666; font-size: 0.9em; text-decoration: none;">Entrar como invitado</a></p>
            </div>
        </section>
    </main>

</body>

</html>