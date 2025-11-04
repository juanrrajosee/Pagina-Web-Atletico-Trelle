<?php
session_start();

// si está logueado como usuario real → va á web
if (!empty($_SESSION['uid'])) {
  header('Location: inicio.html');
  exit;
}

// IMPORTANTE: se antes entrou como invitado, non o forzamos
if (isset($_SESSION['invitado'])) {
  // o deixamos así, pero NON rediriximos
  // unset($_SESSION['invitado']); // se queres, podes limpar
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <style>
    body{display:flex;align-items:center;justify-content:center;min-height:100vh;background:#aa0d0d;font-family:sans-serif;margin:0}
    .card{background:#fff;padding:30px 25px;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,.15);text-align:center;max-width:380px;width:90%}
    h1{margin-top:0;color:#aa0d0d}
    p{color:#444}
    .btn{display:block;margin:10px 0;padding:12px 18px;border:none;border-radius:8px;font-weight:600;cursor:pointer;text-decoration:none}
    .btn-primary{background:#aa0d0d;color:#fff}
    .btn-secondary{background:#f4f4f4;color:#aa0d0d;border:1px solid #aa0d0d}
  </style>
</head>
<body>
  <div class="card">
    <h1>Atlético Trelle</h1>
    <p>Como queres entrar?</p>
    <a class="btn btn-primary" href="login.php">Iniciar sesión</a>
    <a class="btn btn-secondary" href="invitado.php">Entrar como invitado</a>
    <p style="font-size:.75rem;margin-top:12px;color:#777">Se es socio verás os prezos co 15% de desconto.</p>
  </div>
</body>
</html>
