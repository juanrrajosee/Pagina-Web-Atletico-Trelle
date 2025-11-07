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
  global $pdo;
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

  // Guardar carrito antes de cerrar sesión
  if (!empty($_SESSION['uid']) && isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
    $json = json_encode($_SESSION['carrito'], JSON_UNESCAPED_UNICODE);
    try {
      $pdo->prepare('INSERT INTO carritos (user_id, items) VALUES (?, ?)
                      ON DUPLICATE KEY UPDATE items = VALUES(items), actualizado_en = CURRENT_TIMESTAMP')
          ->execute([$_SESSION['uid'], $json]);
    } catch (Throwable $e) {
      // Si no se puede guardar el carrito, se continúa igualmente.
    }
  }

  // Limpiar sesión y cookies
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }

  session_destroy();
  header('Location: index.php');
  exit;
}
