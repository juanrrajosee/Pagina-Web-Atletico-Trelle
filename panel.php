<?php
require __DIR__ . '/auth.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_role('admin'); // Solo admins

$activePage = 'panel';

function redirect_with_msg(string $msg): void
{
  header('Location: panel.php?msg=' . urlencode($msg));
  exit;
}

// Aprobar solicitud
if (isset($_GET['aprobar'])) {
  $id = (int) $_GET['aprobar'];
  if ($id <= 0) {
    redirect_with_msg('error');
  }

  try {
    $pdo->beginTransaction();

    $st = $pdo->prepare('SELECT email FROM socios WHERE id = ? LIMIT 1');
    $st->execute([$id]);
    $row = $st->fetch();

    if (!$row) {
      $pdo->rollBack();
      redirect_with_msg('no_encontrado');
    }

    $email = $row['email'];

    $pdo->prepare("UPDATE socios SET estado = 'aprobado' WHERE id = ?")
      ->execute([$id]);

    if ($email) {
      $st2 = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
      $st2->execute([$email]);
      if ($st2->fetch()) {
        $pdo->prepare("UPDATE usuarios SET rol = 'socio' WHERE email = ?")
          ->execute([$email]);
      }
    }

    $pdo->commit();
    redirect_with_msg('aprobado');
  } catch (Throwable $e) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    redirect_with_msg('error');
  }
}

// Eliminar solicitud
if (isset($_GET['eliminar'])) {
  $id = (int) $_GET['eliminar'];
  if ($id <= 0) {
    redirect_with_msg('error');
  }

  try {
    $pdo->beginTransaction();

    $st = $pdo->prepare('SELECT email FROM socios WHERE id = ? LIMIT 1');
    $st->execute([$id]);
    $row = $st->fetch();
    $email = $row['email'] ?? null;

    $pdo->prepare('DELETE FROM socios WHERE id = ?')->execute([$id]);

    if ($email) {
      $pdo->prepare("UPDATE usuarios SET rol = 'aficionado' WHERE email = ? AND rol = 'socio'")
        ->execute([$email]);
    }

    $pdo->commit();
    redirect_with_msg('eliminado');
  } catch (Throwable $e) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    redirect_with_msg('error');
  }
}

$solicitudes = $pdo->query("SELECT id, nombre, apellidos, email, telefono, estado, creado_en FROM socios ORDER BY creado_en DESC")
  ->fetchAll();

$status = $_GET['msg'] ?? null;
$alert = null;

if ($status === 'aprobado') {
  $alert = ['type' => 'ok', 'text' => 'Solicitud aprobada correctamente.'];
} elseif ($status === 'eliminado') {
  $alert = ['type' => 'ok', 'text' => 'Solicitud eliminada y beneficios de socio revocados.'];
} elseif ($status === 'no_encontrado') {
  $alert = ['type' => 'err', 'text' => 'La solicitud indicada no existe.'];
} elseif ($status === 'error') {
  $alert = ['type' => 'err', 'text' => 'Ha ocurrido un error al procesar la petición.'];
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel | Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="panel.css">
</head>

<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main class="seccion panel-admin">
    <div class="panel-header">
      <div>
        <h2>Panel de administración</h2>
        <p>Gestiona las solicitudes de socios pendientes, aprueba nuevas altas o revoca beneficios.</p>
      </div>
      <div class="panel-meta">
        <span class="meta-item"><strong><?= count($solicitudes) ?></strong> solicitudes registradas</span>
      </div>
    </div>

    <?php if ($alert): ?>
      <p class="alert-<?= $alert['type'] ?>"><?= htmlspecialchars($alert['text']) ?></p>
    <?php endif; ?>

    <?php if (!$solicitudes): ?>
      <p class="panel-empty">No hay solicitudes registradas por el momento.</p>
    <?php else: ?>
      <div class="table-responsive" role="region" aria-live="polite">
        <table>
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th class="acciones">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($solicitudes as $s): ?>
              <tr>
                <td><?= htmlspecialchars($s['nombre'] . ' ' . $s['apellidos']) ?></td>
                <td><?= htmlspecialchars($s['email']) ?></td>
                <td><?= htmlspecialchars($s['telefono']) ?></td>
                <td><span class="tag <?= htmlspecialchars($s['estado']) ?>"><?= htmlspecialchars($s['estado']) ?></span>
                </td>
                <td><?= htmlspecialchars($s['creado_en']) ?></td>
                <td class="acciones">
                  <?php if ($s['estado'] !== 'aprobado'): ?>
                    <a class="btn btn-approve" href="panel.php?aprobar=<?= $s['id'] ?>">Aprobar</a>
                  <?php endif; ?>
                  <a class="btn btn-delete" href="panel.php?eliminar=<?= $s['id'] ?>"
                    onclick="return confirm('¿Seguro que quieres eliminar esta solicitud? Se revocarán los beneficios otorgados.');">
                    Eliminar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>

  <footer class="site-footer">
    <p>&copy; <?= date('Y') ?> Atlético Trelle. Todos los derechos reservados.</p>
  </footer>
</body>

</html>