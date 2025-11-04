<?php
require __DIR__.'/auth.php';
require_role('admin');

// aprobar
if (isset($_GET['aprobar'])) {
  $id = (int)$_GET['aprobar'];
  if ($id > 0) {
    // 1. ponemos la solicitud en aprobado
    $pdo->prepare("UPDATE socios SET estado='aprobado' WHERE id=?")->execute([$id]);

    // 2. buscamos el email de esa solicitud
    $st = $pdo->prepare("SELECT email, nombre FROM socios WHERE id=?");
    $st->execute([$id]);
    $sol = $st->fetch();

    if ($sol) {
      $email = $sol['email'];

      // 3. comprobamos si existe un usuario con ese email
      $st2 = $pdo->prepare("SELECT id FROM usuarios WHERE email=? LIMIT 1");
      $st2->execute([$email]);
      $usr = $st2->fetch();

      if ($usr) {
        // 3.a si existe → actualizar a socio
        $pdo->prepare("UPDATE usuarios SET rol='socio' WHERE email=?")->execute([$email]);
      }
      // si NO existe podríamos crearlo aquí con pass aleatoria,
      // pero por ahora lo dejamos así para no romper tu flujo.
    }

    header('Location: admin_socio.php?ok=1');
    exit;
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
    <p class="alert-ok"><b>Estado actualizado e usuario vinculado (se existía).</b></p>
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
            <?php else: ?>—<?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>
</body>
</html>
