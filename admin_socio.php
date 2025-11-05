<?php
require __DIR__.'/auth.php';
require_role('admin');

// aprobar solicitud
if (isset($_GET['aprobar'])) {
  $id = (int)$_GET['aprobar'];
  if ($id > 0) {
    $pdo->prepare("UPDATE socios SET estado='aprobado' WHERE id=?")->execute([$id]);

    // vincular a usuarios (si existe)
    $st = $pdo->prepare("SELECT email FROM socios WHERE id=?");
    $st->execute([$id]);
    if ($row = $st->fetch()) {
      $email = $row['email'];
      $st2 = $pdo->prepare("SELECT id FROM usuarios WHERE email=? LIMIT 1");
      $st2->execute([$email]);
      if ($usr = $st2->fetch()) {
        $pdo->prepare("UPDATE usuarios SET rol='socio' WHERE email=?")->execute([$email]);
      }
    }
    header('Location: admin_socio.php?ok=1'); exit;
  }
}

// eliminar solicitud
if (isset($_GET['eliminar'])) {
  $id = (int)$_GET['eliminar'];
  if ($id > 0) {
    $pdo->prepare("DELETE FROM socios WHERE id=?")->execute([$id]);
    header('Location: admin_socio.php?del=1'); exit;
  }
}

// listado
$sol = $pdo->query("SELECT id,nombre,apellidos,email,telefono,estado,creado_en
                    FROM socios ORDER BY creado_en DESC")->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Solicitudes de socios | Panel</title>
  <link rel="stylesheet" href="admin_socio.css">
</head>
<body>
<header>
  <h1>Solicitudes de socios</h1>
  <nav><a href="panel.php" style="color:#fff;">← Volver ao panel</a></nav>
</header>
<main class="seccion">
  <h2>Solicitudes</h2>
  <?php if(isset($_GET['ok'])): ?>
    <p class="alert-ok"><b>Solicitude aprobada e usuario vinculado (se existía).</b></p>
  <?php endif; ?>
  <?php if(isset($_GET['del'])): ?>
    <p class="alert-ok"><b>Solicitude eliminada correctamente.</b></p>
  <?php endif; ?>

  <?php if(!$sol): ?>
    <p>Non hai solicitudes polo momento.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Nome</th><th>Email</th><th>Teléfono</th><th>Estado</th><th>Data</th><th>Accións</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($sol as $s): ?>
        <tr>
          <td><?=htmlspecialchars($s['nombre'].' '.$s['apellidos'])?></td>
          <td><?=htmlspecialchars($s['email'])?></td>
          <td><?=htmlspecialchars($s['telefono'])?></td>
          <td><span class="tag <?=htmlspecialchars($s['estado'])?>"><?=htmlspecialchars($s['estado'])?></span></td>
          <td><?=htmlspecialchars($s['creado_en'])?></td>
          <td>
            <?php if($s['estado']!=='aprobado'): ?>
              <a class="btn" href="admin_socio.php?aprobar=<?=$s['id']?>">Aprobar</a>
            <?php else: ?>
              —
            <?php endif; ?>
            <a class="btn" style="background:#444;margin-left:6px"
               href="admin_socio.php?eliminar=<?=$s['id']?>"
               onclick="return confirm('¿Seguro que quieres eliminar esta solicitude?');">
               Eliminar
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>
</body>
</html>
