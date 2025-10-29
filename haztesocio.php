<?php
require __DIR__.'/config.php';
$ok=false; $err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $nombre=trim($_POST['nombre']??'');
  $apellidos=trim($_POST['apellidos']??'');
  $email=trim($_POST['email']??'');
  $telefono=trim($_POST['telefono']??'');
  $coment=trim($_POST['comentarios']??'');
  if($nombre===''||$email===''){ $err='Nome e email son obrigatorios.'; }
  else{
    try{
      $st=$pdo->prepare("INSERT INTO socios(nombre,apellidos,email,telefono,comentarios) VALUES (?,?,?,?,?)");
      $st->execute([$nombre,$apellidos,$email,$telefono,$coment]);
      $ok=true;
    }catch(Throwable $e){ $err='Produciuse un erro ao gardar a solicitude.'; }
  }
}
?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Hazte Socio | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css"><!-- tu css general si lo tienes -->
  <link rel="stylesheet" href="paginas.css">
</head>
<body>
<header class="topbar">
  <a href="index.html">Inicio</a>
  <a href="jugadores.html">Plantilla</a>
  <a href="galeria.html">Galería</a>
  <a href="tienda.html">Tenda</a>
  <a href="haztesocio.php"><b>Hazte socio</b></a>
  <a href="login.php" style="float:right">Acceso</a>
</header>

<main class="seccion">
  <h2>Hazte Socio</h2>

  <?php if($ok): ?>
    <p class="alert-ok"><b>Solicitude enviada correctamente.</b> En breve contactaremos contigo. Grazas!</p>
  <?php elseif($err): ?>
    <p class="alert-err"><b><?=htmlspecialchars($err)?></b></p>
  <?php endif; ?>

  <form class="form" method="post" action="haztesocio.php" novalidate>
    <label>Nome*</label>
    <input name="nombre" required value="<?=htmlspecialchars($_POST['nombre']??'')?>">

    <label>Apelidos</label>
    <input name="apellidos" value="<?=htmlspecialchars($_POST['apellidos']??'')?>">

    <label>Email*</label>
    <input type="email" name="email" required value="<?=htmlspecialchars($_POST['email']??'')?>">

    <label>Teléfono</label>
    <input name="telefono" value="<?=htmlspecialchars($_POST['telefono']??'')?>">

    <label>Comentarios</label>
    <textarea name="comentarios" rows="4"><?=htmlspecialchars($_POST['comentarios']??'')?></textarea>

    <label><input type="checkbox" required> Acepto a política de privacidade</label>
    <button class="btn" type="submit">Enviar solicitude</button>
  </form>
</main>
</body>
</html>
