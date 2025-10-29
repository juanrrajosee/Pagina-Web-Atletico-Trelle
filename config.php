<?php
// config.php
$dsn  = 'mysql:host=localhost;dbname=trelle;charset=utf8mb4';
$user = 'root';
$pass = '';

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO($dsn, $user, $pass, $options);

// Sesiones siempre activas
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
