<?php
require __DIR__.'/config.php';

// 1) lee el hash del admin en la BD
$st = $pdo->prepare("SELECT pass_hash FROM usuarios WHERE email=? LIMIT 1");
$st->execute(['admin@trelle.com']);
$hash = $st->fetchColumn();

// 2) muestra resultados
var_dump([
  'hash_encontrado' => $hash !== false,
  'hash' => $hash,
  'password_verify_admin123' => $hash ? password_verify('admin123', $hash) : null,
]);
