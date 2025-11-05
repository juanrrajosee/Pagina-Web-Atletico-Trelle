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

// Crear tablas base si no existen (instalación simplificada)
$pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  apellidos VARCHAR(160) DEFAULT NULL,
  fecha_nacimiento DATE DEFAULT NULL,
  email VARCHAR(180) NOT NULL UNIQUE,
  pass_hash VARCHAR(255) NOT NULL,
  rol ENUM('aficionado','socio','admin') NOT NULL DEFAULT 'aficionado',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
);

$pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS socios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  apellidos VARCHAR(160) DEFAULT NULL,
  email VARCHAR(180) NOT NULL,
  telefono VARCHAR(40) DEFAULT NULL,
  comentarios TEXT,
  estado ENUM('pendiente','aprobado','rechazado') NOT NULL DEFAULT 'pendiente',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
);

$pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS carritos (
  user_id INT PRIMARY KEY,
  items LONGTEXT NOT NULL,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_carritos_usuario FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
);

// Sesiones siempre activas
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Crear administrador por defecto (admin@trelle.com / admin123)
$adminEmail = 'admin@trelle.com';
$adminPass  = 'admin123';

$stAdmin = $pdo->prepare('SELECT id, pass_hash, rol FROM usuarios WHERE email = ? LIMIT 1');
$stAdmin->execute([$adminEmail]);
$adminRow = $stAdmin->fetch();

if (!$adminRow) {
  $pdo->prepare('INSERT INTO usuarios (nombre, apellidos, email, pass_hash, rol) VALUES (?,?,?,?,?)')
      ->execute([
        'Administrador',
        'Atlético Trelle',
        $adminEmail,
        password_hash($adminPass, PASSWORD_DEFAULT),
        'admin'
      ]);
} else {
  $updates = [];
  if ($adminRow['rol'] !== 'admin') {
    $updates['rol'] = 'admin';
  }
  if (!password_verify($adminPass, $adminRow['pass_hash'])) {
    $updates['pass_hash'] = password_hash($adminPass, PASSWORD_DEFAULT);
  }
  if ($updates) {
    $sets = [];
    $values = [];
    foreach ($updates as $column => $value) {
      $sets[] = "$column = ?";
      $values[] = $value;
    }
    $values[] = $adminEmail;
    $pdo->prepare('UPDATE usuarios SET ' . implode(',', $sets) . ' WHERE email = ?')->execute($values);
  }
}
