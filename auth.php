<?php
require_once __DIR__ . '/config.php';

function login(string $email, string $password): bool {
  global $pdo;
  $email = trim(strtolower($email));

  $st = $pdo->prepare("SELECT id, nombre, email, pass_hash, rol FROM usuarios WHERE email = ? LIMIT 1");
  $st->execute([$email]);
  $u = $st->fetch();

  if ($u && password_verify($password, $u['pass_hash'])) {
    // sesión base
    $_SESSION['uid']     = $u['id'];
    $_SESSION['rol']     = $u['rol'];
    $_SESSION['nombre']  = $u['nombre'];
    $_SESSION['email']   = $u['email'];

    // si estaba como invitado, lo quitamos
    unset($_SESSION['invitado']);

    // cargar carrito guardado
    $stc = $pdo->prepare('SELECT items FROM carritos WHERE user_id = ? LIMIT 1');
    $stc->execute([$u['id']]);
    $itemsGuardados = $stc->fetchColumn();
    if ($itemsGuardados) {
      $items = json_decode($itemsGuardados, true);
      $_SESSION['carrito'] = is_array($items) ? $items : [];
    } else {
      unset($_SESSION['carrito']);
    }

    // DESCUENTO: si es socio → 15%
    if ($u['rol'] === 'socio') {
      $_SESSION['descuento'] = 0.15;
    } else {
      unset($_SESSION['descuento']);
    }

    return true;
  }
  return false;
}

function require_login(): void {
  if (empty($_SESSION['uid'])) {
    header('Location: login.php');
    exit;
  }
}

function require_role(string $rol): void {
  require_login();
  if ($_SESSION['rol'] !== $rol) {
    http_response_code(403);
    exit('Acceso denegado');
  }
}

function logout(): void {
  session_unset();
  session_destroy();
  header('Location: index.php');
  exit;
}
