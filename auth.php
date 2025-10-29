<?php
// auth.php
require_once __DIR__ . '/config.php';

function login(string $email, string $password): bool {
  global $pdo;
  $email = trim(strtolower($email));

  $st = $pdo->prepare("SELECT id, nombre, email, pass_hash, rol FROM usuarios WHERE email = ? LIMIT 1");
  $st->execute([$email]);
  $u = $st->fetch();

  if ($u && password_verify($password, $u['pass_hash'])) {
    $_SESSION['uid']     = $u['id'];
    $_SESSION['rol']     = $u['rol'];
    $_SESSION['nombre']  = $u['nombre'];
    $_SESSION['email']   = $u['email'];
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
  header('Location: login.php');
  exit;
}
