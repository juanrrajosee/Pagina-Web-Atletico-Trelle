# Páxina web oficial do Atlético Trelle

TFG — CFGS Desenvolvemento de Aplicacións Web. Sitio web do club Atlético Trelle cunha parte pública (Inicio, Historia e Directiva, Plantilla, Galería, Tenda, Hazte Socio) e funcionalidade mínima: **usuarios** (admin/socio) e **alta de socios**.

## 🧭 Índice
- [Descrición](#descrición)
- [Funcionalidades](#funcionalidades)
- [Tecnoloxías](#tecnoloxías)
- [Estrutura](#estrutura)
- [Posta en marcha local](#posta-en-marcha-local)
- [Usuarios e roles](#usuarios-e-roles)
- [Orzamento estimado profesional](#orzamento-estimado-profesional)
- [Licenza](#licenza)

## Descrición
Web responsive con integración de Instagram e Google Maps. O formulario **Hazte Socio** garda datos en MariaDB e o **panel** mostra vistas diferenciadas para `admin` e `socio`.

## Funcionalidades
- Páxinas públicas: Inicio, Historia e Directiva, Plantilla, Galería, Tenda, Hazte Socio.
- Alta de socios: formulario → BD (estado: pendente/aprobado).
- Autenticación con sesións PHP.
- Panel:
  - **Admin**: ver/aprobar solicitudes de socios (base para CRUDs).
  - **Socio**: área básica informativa.

## Tecnoloxías
**Frontend:** HTML5, CSS3, JS (ES6)  
**Backend:** PHP 8.x (Apache)  
**BD:** MariaDB (phpMyAdmin)  
**Outros:** Instagram embeds, Google Maps

## Estrutura
trelle/
├─ index.html
├─ historia.html
├─ jugadores.html
├─ galeria.html
├─ tienda.html
├─ hazte-socio.php
├─ paginas.css (estilos comúns)
├─ .css
├─ config.php, auth.php, login.php, panel.php, logout.php
├─ admin_socios.php
├─ Imagenes/ ...
└─ sql/
└─ trelle_schema.sql


## Posta en marcha local
1. XAMPP → iniciar **Apache** e **MySQL**.
2. `http://localhost/phpmyadmin` → crear BD **trelle** (utf8mb4) e executar `sql/trelle_schema.sql`.
3. Configurar `config.php`:
   ```php
   $pdo = new PDO('mysql:host=localhost;dbname=trelle;charset=utf8mb4','root','');


