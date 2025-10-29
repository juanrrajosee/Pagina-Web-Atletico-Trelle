<?php
require __DIR__.'/auth.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(login($_POST['email']??'', $_POST['password']??'')){
    header('Location: panel.php'); exit;
  }
  $msg='Credenciais incorrectas';
}
?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Acceso | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="paginas.css">
</head>
<body>
<header class="topbar">
  <a href="index.html">Inicio</a>
  <a href="haztesocio.php">Hazte socio</a>
</header>

<main class="seccion" style="max-width:520px">
  <h2>Acceso</h2>
  <?php if($msg): ?><p class="alert-err"><b><?=$msg?></b></p><?php endif; ?>
  <form class="form" method="post">
    <label>Email</label><input type="email" name="email" required>
    <label>Contrasinal</label><input type="password" name="password" required>
    <button class="btn">Entrar</button>
  </form>
</main>
</body>
</html>
