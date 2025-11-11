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

// Tabla usuarios
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

// Tabla socios (solicitudes)
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

// Tabla carritos (carrito persistente por usuario)
$pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS carritos (
  user_id INT PRIMARY KEY,
  items LONGTEXT NOT NULL,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_carritos_usuario FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
);

// Tabla jugadores (para futuras fichas dinámicas)
$pdo->exec(<<<SQL
CREATE TABLE IF NOT EXISTS jugadores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  apodo VARCHAR(120) DEFAULT NULL,
  slug VARCHAR(160) NOT NULL UNIQUE,
  dorsal VARCHAR(10) DEFAULT NULL,
  posicion VARCHAR(120) DEFAULT NULL,
  fecha_nacimiento DATE DEFAULT NULL,
  lugar_nacimiento VARCHAR(160) DEFAULT NULL,
  nacionalidad VARCHAR(120) DEFAULT NULL,
  altura_cm INT DEFAULT NULL,
  peso_kg INT DEFAULT NULL,
  debut_club DATE DEFAULT NULL,
  pierna_habil VARCHAR(50) DEFAULT NULL,
  descripcion_corta VARCHAR(255) DEFAULT NULL,
  biografia TEXT,
  trayectoria TEXT,
  estadisticas TEXT,
  palmares TEXT,
  video_url VARCHAR(255) DEFAULT NULL,
  imagen_principal VARCHAR(255) DEFAULT NULL,
  imagen_portada VARCHAR(255) DEFAULT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
);

// Seed inicial de jugadores si la tabla está vacía
$countJugadores = $pdo->query('SELECT COUNT(*) FROM jugadores')->fetchColumn();
if ((int)$countJugadores === 0) {
    $seedJugadores = [
        [
            'nombre'            => 'Adrián Rodríguez',
            'apodo'             => 'Adri',
            'slug'              => 'adrian-rodriguez',
            'dorsal'            => '3',
            'posicion'          => 'Lateral izquierdo',
            'fecha_nacimiento'  => '2005-04-18',
            'lugar_nacimiento'  => 'Ourense, España',
            'nacionalidad'      => 'España',
            'altura_cm'         => 178,
            'peso_kg'           => 72,
            'debut_club'        => '2021-09-12',
            'pierna_habil'      => 'Izquierda',
            'descripcion_corta' => 'Carrilero de ida y vuelta, inagotable en defensa y valiente en ataque.',
            'biografia'         => "Formado en las categorías inferiores del Atlético Trelle, Adrián es un lateral que combina potencia, velocidad y buena lectura táctica. Su evolución ha sido meteórica desde su debut con el primer equipo.",
            'trayectoria'       => "2018-2021 · Academia Atlético Trelle\n2021-Actualidad · Primer equipo Atlético Trelle",
            'estadisticas'      => "Temporada 2023/24 · 28 partidos · 2 goles · 7 asistencias\nTemporada 2022/23 · 25 partidos · 5 asistencias",
            'palmares'          => "2022 · Campeón Liga Provincial Juvenil",
            'video_url'         => 'https://www.youtube.com/embed/HN2lQGN1v2A',
            'imagen_principal'  => 'ImagenesJugadores/adrian.png',
            'imagen_portada'    => 'ImagenesJugadores/adrian.png',
        ],
        [
            'nombre'            => 'Adrián Altamira',
            'apodo'             => 'Altamira',
            'slug'              => 'adrian-altamira',
            'dorsal'            => '5',
            'posicion'          => 'Central / Lateral derecho',
            'fecha_nacimiento'  => '2004-11-02',
            'lugar_nacimiento'  => 'Verín, España',
            'nacionalidad'      => 'España',
            'altura_cm'         => 183,
            'peso_kg'           => 78,
            'debut_club'        => '2020-10-04',
            'pierna_habil'      => 'Derecha',
            'descripcion_corta' => 'Defensa polivalente que domina el juego aéreo y la salida de balón.',
            'biografia'         => "Altamira se ha consolidado como un pilar defensivo del Atlético Trelle gracias a su serenidad, fuerza aérea y capacidad para adaptarse a varias posiciones en la zaga.",
            'trayectoria'       => "2016-2019 · UD Verín juvenil\n2019-2020 · Atlético Trelle juvenil\n2020-Actualidad · Primer equipo Atlético Trelle",
            'estadisticas'      => "Temporada 2023/24 · 30 partidos · 3 goles\nTemporada 2022/23 · 27 partidos · 1 gol",
            'palmares'          => "2021 · Ascenso a Preferente con Atlético Trelle",
            'video_url'         => null,
            'imagen_principal'  => 'ImagenesJugadores/altamira.png',
            'imagen_portada'    => 'ImagenesJugadores/altamira.png',
        ],
        [
            'nombre'            => 'Anxo Rodríguez',
            'apodo'             => 'Anxo',
            'slug'              => 'anxo-rodriguez',
            'dorsal'            => '8',
            'posicion'          => 'Mediocentro organizador',
            'fecha_nacimiento'  => '2003-06-25',
            'lugar_nacimiento'  => 'Xinzo de Limia, España',
            'nacionalidad'      => 'España',
            'altura_cm'         => 176,
            'peso_kg'           => 70,
            'debut_club'        => '2019-08-31',
            'pierna_habil'      => 'Derecha',
            'descripcion_corta' => 'Cerebro del equipo, creativo en espacios reducidos y preciso a balón parado.',
            'biografia'         => "Anxo es el motor del centro del campo del Atlético Trelle, con gran visión de juego y personalidad para asumir la responsabilidad en los partidos importantes.",
            'trayectoria'       => "2015-2019 · Atlético Trelle juvenil\n2019-Actualidad · Primer equipo Atlético Trelle",
            'estadisticas'      => "Temporada 2023/24 · 32 partidos · 5 goles · 10 asistencias\nTemporada 2022/23 · 29 partidos · 4 goles",
            'palmares'          => "2023 · Mejor centrocampista Liga Provincial",
            'video_url'         => 'https://www.youtube.com/embed/NL6CDFn2iEw',
            'imagen_principal'  => 'ImagenesJugadores/anxo.png',
            'imagen_portada'    => 'ImagenesJugadores/anxo.png',
        ],
    ];

    $insertJugador = $pdo->prepare(
        'INSERT INTO jugadores 
        (nombre, apodo, slug, dorsal, posicion, fecha_nacimiento, lugar_nacimiento, nacionalidad, altura_cm, peso_kg, debut_club, pierna_habil, descripcion_corta, biografia, trayectoria, estadisticas, palmares, video_url, imagen_principal, imagen_portada)
        VALUES 
        (:nombre, :apodo, :slug, :dorsal, :posicion, :fecha_nacimiento, :lugar_nacimiento, :nacionalidad, :altura_cm, :peso_kg, :debut_club, :pierna_habil, :descripcion_corta, :biografia, :trayectoria, :estadisticas, :palmares, :video_url, :imagen_principal, :imagen_portada)'
    );

    foreach ($seedJugadores as $jugador) {
        $insertJugador->execute($jugador);
    }
}

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
