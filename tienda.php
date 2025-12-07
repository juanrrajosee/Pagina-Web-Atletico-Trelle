<?php
session_start();
$es_socio = !empty($_SESSION['descuento']); // 15%
$descuento = $es_socio ? 0.15 : 0;
$usuarioLogueado = !empty($_SESSION['uid']);
$carritoGuardado = $_SESSION['carrito'] ?? [];
if (!is_array($carritoGuardado)) {
  $carritoGuardado = [];
}
function precio_desc($p, $d)
{
  return number_format($p * (1 - $d), 2, ',', '');
}
$activePage = 'tienda';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tienda - Atlético Trelle</title>
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="tienda.css">
  <style>
    .precio-tachado {
      text-decoration: line-through;
      color: #999;
      margin-right: 6px;
    }

    .precio-socio {
      color: #0a7a2a;
      font-weight: 700;
    }

    .badge-socio {
      display: inline-block;
      background: #0a7a2a;
      color: #fff;
      padding: 2px 8px;
      border-radius: 4px;
      font-size: .7rem;
      margin-left: 6px;
    }
  </style>
</head>

<body>
  <!-- Botón Carrito -->
  <button class="carrito-btn" id="carritoBtn">
    🛒 Carrito <span class="carrito-contador" id="carritoContador">0</span>
  </button>

  <!-- Overlay y panel -->
  <div class="carrito-overlay" id="carritoOverlay"></div>
  <div class="carrito-panel" id="carritoPanel">
    <div class="carrito-header">
      <h2>Mi carrito</h2>
      <button class="cerrar-carrito" id="cerrarCarrito">&times;</button>
    </div>
    <div class="carrito-contenido" id="carritoContenido">
      <div class="carrito-vacio" id="carritoVacio">Tu carrito está vacío</div>
    </div>
    <div class="carrito-total" id="carritoTotal" style="display:none;">
      <div class="total-precio" id="totalPrecio">Total: 0€</div>
      <button class="btn-comprar" onclick="finalizarCompra()">Finalizar compra</button>
    </div>
  </div>

  <!-- Header unificado -->
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main>
    <h1>Tenda oficial do Atlético Trelle
      <?php if ($es_socio): ?>
        <span class="badge-socio">15% socio</span>
      <?php endif; ?>
    </h1>

    <section class="productos">
      <!-- Producto 1 -->
      <article class="producto" data-id="1" data-nombre="Equipación Oficial" data-precio="40"
        data-precio-desc="<?php echo $es_socio ? precio_desc(40, $descuento) : 40; ?>"
        data-imagen="ImagenesTienda/1eraequipacion.png">
        <img src="ImagenesTienda/1eraequipacion.png" alt="Equipación Oficial" />
        <h3>Equipación Oficial</h3>
        <p>
          <?php if ($es_socio): ?>
            <span class="precio-tachado">40€</span>
            <span class="precio-socio"><?php echo precio_desc(40, $descuento); ?>€</span>
          <?php else: ?>
            Precio: 40€
          <?php endif; ?>
        </p>
        <button onclick="agregarAlCarrito(this)">Añadir al carrito</button>
      </article>

      <!-- Producto 2 -->
      <article class="producto" data-id="2" data-nombre="2ª Equipación Oficial" data-precio="40"
        data-precio-desc="<?php echo $es_socio ? precio_desc(40, $descuento) : 40; ?>"
        data-imagen="ImagenesTienda/2daequipacion.png">
        <img src="ImagenesTienda/2daequipacion.png" alt="2ª Equipación Oficial" />
        <h3>2ª Equipación Oficial</h3>
        <p>
          <?php if ($es_socio): ?>
            <span class="precio-tachado">40€</span>
            <span class="precio-socio"><?php echo precio_desc(40, $descuento); ?>€</span>
          <?php else: ?>
            Precio: 40€
          <?php endif; ?>
        </p>
        <button onclick="agregarAlCarrito(this)">Añadir al carrito</button>
      </article>

      <!-- Producto 3 -->
      <article class="producto" data-id="3" data-nombre="Sudadera Atlético Trelle" data-precio="30"
        data-precio-desc="<?php echo $es_socio ? precio_desc(30, $descuento) : 30; ?>"
        data-imagen="ImagenesTienda/sudadera.png">
        <img src="ImagenesTienda/sudadera.png" alt="Sudadera Atlético Trelle" />
        <h3>Sudadera Atlético Trelle</h3>
        <p>
          <?php if ($es_socio): ?>
            <span class="precio-tachado">30€</span>
            <span class="precio-socio"><?php echo precio_desc(30, $descuento); ?>€</span>
          <?php else: ?>
            Precio: 30€
          <?php endif; ?>
        </p>
        <button onclick="agregarAlCarrito(this)">Añadir al carrito</button>
      </article>

      <!-- Producto 4 -->
      <article class="producto" data-id="4" data-nombre="Bufanda Oficial" data-precio="10"
        data-precio-desc="<?php echo $es_socio ? precio_desc(10, $descuento) : 10; ?>"
        data-imagen="ImagenesTienda/bufandas.png">
        <img src="ImagenesTienda/bufandas.png" alt="Bufanda Oficial" />
        <h3>Bufanda Oficial</h3>
        <p>
          <?php if ($es_socio): ?>
            <span class="precio-tachado">10€</span>
            <span class="precio-socio"><?php echo precio_desc(10, $descuento); ?>€</span>
          <?php else: ?>
            Precio: 10€
          <?php endif; ?>
        </p>
        <button onclick="agregarAlCarrito(this)">Añadir al carrito</button>
      </article>

      <!-- Producto 5 -->
      <article class="producto" data-id="5" data-nombre="Balón Firmado" data-precio="50"
        data-precio-desc="<?php echo $es_socio ? precio_desc(50, $descuento) : 50; ?>"
        data-imagen="ImagenesTienda/balonFirmado.png">
        <img src="ImagenesTienda/balonFirmado.png" alt="Balón Firmado" />
        <h3>Balón Firmado</h3>
        <p>
          <?php if ($es_socio): ?>
            <span class="precio-tachado">50€</span>
            <span class="precio-socio"><?php echo precio_desc(50, $descuento); ?>€</span>
          <?php else: ?>
            Precio: 50€
          <?php endif; ?>
        </p>
        <button onclick="agregarAlCarrito(this)">Añadir al carrito</button>
      </article>

      <!-- Producto 6 -->
      <article class="producto" data-id="6" data-nombre="Postal del equipo" data-precio="5"
        data-precio-desc="<?php echo $es_socio ? precio_desc(5, $descuento) : 5; ?>"
        data-imagen="ImagenesTienda/postal.png">
        <img src="ImagenesTienda/postal.png" alt="Postal del equipo" />
        <h3>Postal del equipo</h3>
        <p>
          <?php if ($es_socio): ?>
            <span class="precio-tachado">5€</span>
            <span class="precio-socio"><?php echo precio_desc(5, $descuento); ?>€</span>
          <?php else: ?>
            Precio: 5€
          <?php endif; ?>
        </p>
        <button onclick="agregarAlCarrito(this)">Añadir al carrito</button>
      </article>

      <!-- Producto 7 -->
      <article class="producto" data-id="7" data-nombre="Cromos oficiales" data-precio="3"
        data-precio-desc="<?php echo $es_socio ? precio_desc(3, $descuento) : 3; ?>"
        data-imagen="ImagenesTienda/cromos.png">
        <img src="ImagenesTienda/cromos.png" alt="Cromos oficiales" />
        <h3>Cromos oficiales</h3>
        <p>
          <?php if ($es_socio): ?>
            <span class="precio-tachado">3€</span>
            <span class="precio-socio"><?php echo precio_desc(3, $descuento); ?>€</span>
          <?php else: ?>
            Precio: 3€
          <?php endif; ?>
        </p>
        <button onclick="agregarAlCarrito(this)">Añadir al carrito</button>
      </article>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Atlético Trelle. Todos los derechos reservados.</p>
  </footer>

  <script>
    // Datos iniciales provenientes del servidor
    const DESCUENTO_ACTIVO = <?php echo $es_socio ? 'true' : 'false'; ?>;
    const USUARIO_LOGUEADO = <?php echo $usuarioLogueado ? 'true' : 'false'; ?>;
    const CARRITO_GUARDADO = <?php echo json_encode($carritoGuardado, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

    function normalizarItem(item) {
      const precioNum = Number(item?.precio ?? 0);
      const cantidadNum = Number(item?.cantidad ?? 0);
      return {
        id: String(item?.id ?? ''),
        nombre: String(item?.nombre ?? ''),
        precio: Number.isFinite(precioNum) ? precioNum : 0,
        imagen: String(item?.imagen ?? ''),
        cantidad: Number.isFinite(cantidadNum) ? cantidadNum : 0
      };
    }

    let carrito = [];
    if (Array.isArray(CARRITO_GUARDADO)) {
      carrito = CARRITO_GUARDADO.map(normalizarItem).filter(i => i.id && i.cantidad > 0);
    }

    const carritoBtn = document.getElementById('carritoBtn');
    const carritoPanel = document.getElementById('carritoPanel');
    const carritoOverlay = document.getElementById('carritoOverlay');
    const cerrarCarrito = document.getElementById('cerrarCarrito');
    const carritoContador = document.getElementById('carritoContador');
    const carritoContenido = document.getElementById('carritoContenido');
    const carritoTotal = document.getElementById('carritoTotal');
    const carritoVacio = document.getElementById('carritoVacio');
    const totalPrecio = document.getElementById('totalPrecio');

    function agregarAlCarrito(btn) {
      const prod = btn.closest('.producto');
      const id = prod.dataset.id;
      const nombre = prod.dataset.nombre;
      const precioBase = parseFloat(prod.dataset.precio);
      const precioDesc = parseFloat(prod.dataset.precioDesc);
      const imagen = prod.dataset.imagen;
      const precioFinal = DESCUENTO_ACTIVO ? precioDesc : precioBase;

      const ya = carrito.find(i => i.id === id);
      if (ya) {
        ya.cantidad++;
      } else {
        carrito.push({ id, nombre, precio: Number(precioFinal), imagen, cantidad: 1 });
      }
      actualizarCarrito();
      mostrarCarrito();
    }

    function mostrarCarrito() {
      carritoPanel.classList.add('activo');
      carritoOverlay.classList.add('activo');
      document.body.style.overflow = 'hidden';
    }
    function ocultarCarrito() {
      carritoPanel.classList.remove('activo');
      carritoOverlay.classList.remove('activo');
      document.body.style.overflow = 'auto';
    }

    // Guardado diferido del carrito (solo usuarios logueados)
    let guardadoTimeout = null;
    function programarGuardado() {
      if (!USUARIO_LOGUEADO) return;
      if (guardadoTimeout) clearTimeout(guardadoTimeout);
      guardadoTimeout = setTimeout(() => {
        fetch('carrito_api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ items: carrito })
        }).catch(() => { });
      }, 400);
    }

    function actualizarCarrito() {
      const totalItems = carrito.reduce((s, i) => s + i.cantidad, 0);
      const total = carrito.reduce((s, i) => s + i.cantidad * i.precio, 0);
      carritoContador.textContent = totalItems;

      if (carrito.length === 0) {
        carritoContenido.innerHTML = '<div class="carrito-vacio">Tu carrito está vacío</div>';
        carritoTotal.style.display = 'none';
        programarGuardado();
        return;
      }

      carritoTotal.style.display = 'block';
      totalPrecio.textContent = 'Total: ' + total.toFixed(2) + '€';

      let html = '';
      carrito.forEach(item => {
        html += `
          <div class="item-carrito" data-id="${item.id}">
            <img src="${item.imagen}" alt="${item.nombre}">
            <div class="item-info">
              <h4>${item.nombre}</h4>
              <p>${item.precio}€ c/u</p>
            </div>
            <div class="item-cantidad">
              <button class="btn-cantidad" onclick="cambiarCantidad('${item.id}', -1)">-</button>
              <span>${item.cantidad}</span>
              <button class="btn-cantidad" onclick="cambiarCantidad('${item.id}', 1)">+</button>
            </div>
            <button class="eliminar-item" onclick="eliminarDelCarrito('${item.id}')">Eliminar</button>
          </div>
        `;
      });
      carritoContenido.innerHTML = html;
      programarGuardado();
    }

    function cambiarCantidad(id, delta) {
      const item = carrito.find(i => i.id === id);
      if (!item) return;
      item.cantidad += delta;
      if (item.cantidad <= 0) eliminarDelCarrito(id);
      else actualizarCarrito();
    }

    function eliminarDelCarrito(id) {
      carrito = carrito.filter(i => i.id !== id);
      actualizarCarrito();
    }

    function finalizarCompra() {
      if (carrito.length === 0) { alert('Tu carrito está vacío'); return; }
      alert('Grazas pola túa compra!');
      carrito = [];
      actualizarCarrito();
      ocultarCarrito();
    }

    carritoBtn.addEventListener('click', mostrarCarrito);
    carritoOverlay.addEventListener('click', ocultarCarrito);
    cerrarCarrito.addEventListener('click', ocultarCarrito);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') ocultarCarrito(); });

    // Iniciar con el carrito (si había guardado)
    actualizarCarrito();
  </script>
</body>

</html>