<?php
require __DIR__.'/auth.php';
require_role('admin');

if(isset($_GET['aprobar'])){
  $id=(int)$_GET['aprobar'];
  if($id>0){
    $pdo->prepare("UPDATE socios SET estado='aprobado' WHERE id=?")->execute([$id]);
    header('Location: admin_socio.php?ok=1'); exit;
  }
}
$sol = $pdo->query("SELECT id,nombre,apellidos,email,telefono,estado,creado_en
                    FROM socios ORDER BY creado_en DESC")->fetchAll();
?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Solicitudes de socios | Panel</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="admin_socio.css">
</head>
<body>
<header class="topbar">
  <a href="panel.php">← Volver ao panel</a>
  <span>Solicitudes de socios</span>
</header>

<main class="seccion">
  <h2>Solicitudes de socios</h2>
  <?php if(isset($_GET['ok'])): ?><p class="alert-ok"><b>Estado actualizado.</b></p><?php endif; ?>

  <?php if(!$sol): ?>
    <p>Non hai solicitudes polo momento.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Nome</th><th>Email</th><th>Teléfono</th>
          <th>Estado</th><th>Data</th><th>Accións</th>
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
