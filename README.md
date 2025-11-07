# Atlético Trelle — Web Oficial  
TFG — CFGS Desenvolvemento de Aplicacións Web.  
Sitio web do club **Atlético Trelle (Toén, Ourense)** desenvolvido como proxecto final.

---

## Índice
- [Descrición](#descrición)
- [Funcionalidades](#funcionalidades)
- [Tecnoloxías](#tecnoloxías)
- [Estrutura](#estrutura)
- [Posta en marcha local](#posta-en-marcha-local)
- [Usuarios e roles](#usuarios-e-roles)
- [Orzamento estimado profesional](#orzamento-estimado-profesional)
- [Licenza](#licenza)

---

## Descrición
Web responsive con integración de **Instagram** e **Google Maps**.  
O formulario **Hazte Socio** garda datos en **MariaDB** e o **panel** mostra vistas diferenciadas para `admin` e `socio`.

---

## Funcionalidades
- Páxinas públicas: **Inicio**, **Historia e Directiva**, **Plantilla**, **Galería**, **Tenda**, **Hazte Socio**.  
- Alta de socios: formulario → BD (estado: pendente / aprobado / rexeitado).  
- Autenticación con sesións PHP e control de roles.  
- Panel:
  - **Admin**: ver, aprobar ou eliminar solicitudes de socios.  
  - **Socio**: área informativa básica.  
- Tenda con **carrito persistente** (gardado na BD por usuario).  
- Desconto automático do **15 %** para socios.  
- Navegación dinámica segundo o rol ou estado de sesión.

---

## Tecnoloxías
**Frontend:** HTML5, CSS3, JS (ES6)  
**Backend:** PHP 8.x (Apache)  
**BD:** MariaDB (phpMyAdmin)  
**Outros:** integración de Instagram, Google Maps, Bootstrap 4 (parcial)

---

## Estrutura
trelle/
├─ inicio.php
├─ historia.php
├─ jugadores.php
├─ galeria.php
├─ tienda.php
├─ haztesocio.php
├─ inicio.css, historia.css, jugadores.css...
├─ config.php, auth.php, login.php, panel.php, logout.php
├─ admin_socio.php
├─ Imagenes/ ...
└─ sql/
└─ trelle_schema.sql


---

## Posta en marcha local
1. Abrir **XAMPP** → iniciar os servizos **Apache** e **MySQL**.  
2. En `http://localhost/phpmyadmin` crear a base de datos **trelle** (codificación `utf8mb4`).  
3. Executar o script `sql/trelle_schema.sql` (ou deixar que `config.php` cree as táboas automaticamente).  
4. Verificar as credenciais en `config.php`:
   ```php
   $pdo = new PDO('mysql:host=localhost;dbname=trelle;charset=utf8mb4','root','');
