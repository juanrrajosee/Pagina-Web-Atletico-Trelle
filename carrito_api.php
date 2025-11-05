<?php
require __DIR__.'/auth.php';
require_login();

global $pdo;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $st = $pdo->prepare('SELECT items FROM carritos WHERE user_id = ? LIMIT 1');
  $st->execute([$_SESSION['uid']]);
  $items = $st->fetchColumn();
  $decoded = $items ? json_decode($items, true) : [];
  if (!is_array($decoded)) {
    $decoded = [];
  }
  echo json_encode(['items' => $decoded], JSON_UNESCAPED_UNICODE);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $payload = json_decode(file_get_contents('php://input'), true);
  if (!is_array($payload) || !array_key_exists('items', $payload)) {
    http_response_code(400);
    echo json_encode(['error' => 'Formato incorrecto']);
    exit;
  }

  $items = $payload['items'];
  if (!is_array($items)) {
    $items = [];
  }

  $limpios = [];
  foreach ($items as $item) {
    if (!is_array($item)) {
      continue;
    }
    $id = isset($item['id']) ? preg_replace('/[^A-Za-z0-9_-]/', '', (string)$item['id']) : null;
    $nombre = isset($item['nombre']) ? trim((string)$item['nombre']) : '';
    $precio = isset($item['precio']) ? (float)$item['precio'] : 0.0;
    $imagen = isset($item['imagen']) ? trim((string)$item['imagen']) : '';
    $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 0;

    if ($id === null || $nombre === '' || $cantidad <= 0) {
      continue;
    }

    $limpios[] = [
      'id' => $id,
      'nombre' => $nombre,
      'precio' => round($precio, 2),
      'imagen' => $imagen,
      'cantidad' => $cantidad,
    ];
  }

  $_SESSION['carrito'] = $limpios;

  $json = json_encode($limpios, JSON_UNESCAPED_UNICODE);
  $pdo->prepare('INSERT INTO carritos (user_id, items) VALUES (?, ?) 
                 ON DUPLICATE KEY UPDATE items = VALUES(items), actualizado_en = CURRENT_TIMESTAMP')
      ->execute([$_SESSION['uid'], $json]);

  echo json_encode(['ok' => true]);
  exit;
}

http_response_code(405);
echo json_encode(['error' => 'Método non permitido']);
