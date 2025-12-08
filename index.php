<?php
session_start();

// Si está logueado como usuario real → va a la web principal
if (!empty($_SESSION['uid'])) {
  header('Location: inicio.php');
  exit;
}

// IMPORTANTE: si antes entró como invitado, lo dejamos así, sin redirigir
if (isset($_SESSION['invitado'])) {
  // No hacemos nada: se mantiene la sesión de invitado
  // unset($_SESSION['invitado']); // si quieres limpiar, descomenta
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #aa0d0d;
      font-family: 'Poppins', sans-serif;
      margin: 0;
    }

    .card {
      background: #fff;
      padding: 30px 25px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
      text-align: center;
      max-width: 380px;
      width: 90%;
    }

    h1 {
      margin-top: 0;
      color: #aa0d0d;
      font-family: 'Montserrat', sans-serif;
    }

    p {
      color: #444;
      font-size: 1.05em;
    }

    .btn {
      display: inline-block;
      /* 🔥 antes era block */
      margin: 10px 0;
      padding: 12px 18px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1em;
      cursor: pointer;
      text-decoration: none;
      transition: 0.3s;
      vertical-align: middle;
      /* opcional: mejora la alineación con el texto */
    }

    .btn-primary {
      background: #aa0d0d;
      color: #fff;
    }

    .btn-primary:hover {
      background: #8a0b0b;
    }

    .btn-secondary {
      background: #f4f4f4;
      color: #aa0d0d;
      border: 1px solid #aa0d0d;
    }

    .btn-secondary:hover {
      background: #e9e9e9;
    }

    .guest-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      /* espacio entre botón y texto */
      flex-wrap: wrap;
      /* para que en pantallas pequeñas baje automáticamente */
      margin-top: 10px;
    }

    .warning-text {
      color: #aa0d0d;
      font-size: 0.9em;
      max-width: 180px;
      text-align: left;
    }
  </style>
</head>

<body>
  <div class="card">
    <h1>Atlético Trelle</h1>
    <p>Bienvenido a la web oficial del Atlético Trelle.</p>
    <a href="login.php" class="btn btn-primary">Iniciar Sesión/Registrarse</a>
    <form method="post" action="inicio.php" class="guest-form">
      <?php
      // Al entrar como invitado, marcamos la sesión
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['invitado'] = true;
        header('Location: inicio.php');
        exit;
      }
      ?>
      <div class="guest-row">
        <button type="submit" class="btn btn-secondary">Entrar como Invitado</button>
        <p class="warning-text">⚠️ Al entrar como invitado, algunas funciones pueden estar limitadas.</p>
      </div>
    </form>

  </div>
</body>

</html>