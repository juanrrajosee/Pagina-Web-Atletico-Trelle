# Configuración del Widget de Instagram - Atlético Trelle

## ✅ Widget Instalado

Se ha integrado exitosamente el widget de **Elfsight Instagram Feed** en la página de inicio (`inicio.php`).

### Ubicación del Código

El widget se encuentra en la sección de Instagram de la página de inicio, mostrando automáticamente las últimas publicaciones de la cuenta `@atleticotrelle`.

## 🔧 Cómo Actualizar o Cambiar el Widget

Si necesitas actualizar la configuración del widget (por ejemplo, cambiar el número de posts, diseño, etc.):

1. Ingresa a tu cuenta de Elfsight: https://elfsight.com/
2. Ve a "My Widgets" o "Mis Widgets"
3. Selecciona el widget de Instagram Feed
4. Realiza los cambios deseados en el panel de configuración
5. **No necesitas hacer nada más** - los cambios se reflejarán automáticamente en tu web

## 🔄 Cómo Reemplazar con un Nuevo Widget

Si necesitas generar un nuevo widget desde cero:

1. Crea un nuevo widget en Elfsight
2. Copia el código generado (similar a este):
   ```html
   <script src="https://elfsightcdn.com/platform.js" async></script>
   <div class="elfsight-app-XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX" data-elfsight-app-lazy></div>
   ```
3. Abre el archivo `inicio.php`
4. Busca la línea que contiene `elfsight-app-9a2c3aeb-27de-4bef-864f-5699b7026703`
5. Reemplázala con tu nuevo código del widget
6. Guarda el archivo

## 📱 Características del Widget

- ✅ Actualización automática de posts
- ✅ Diseño responsive (se adapta a móviles y tablets)
- ✅ No requiere credenciales de Instagram
- ✅ Lazy loading (carga cuando el usuario hace scroll)

## 🛠️ Troubleshooting

### El widget no se muestra

1. Verifica que el script de Elfsight esté cargando:
   - Abre la consola del navegador (F12)
   - Busca errores relacionados con `elfsightcdn.com`

2. Verifica tu plan de Elfsight:
   - Los planes gratuitos tienen límites de visualizaciones
   - Si excediste el límite, considera actualizar o esperar al siguiente período

### El widget muestra contenido antiguo

- El widget se actualiza automáticamente, pero puede haber un delay de caché
- Espera unos minutos y recarga la página con Ctrl+F5

### El widget se ve descuadrado

- Los estilos están configurados en `inicio.css`
- El contenedor `.instagram-feed` controla el diseño
- Si necesitas ajustes, modifica la clase `.instagram-feed` en `inicio.css`

## 📄 Archivos Modificados

- **inicio.php**: Contiene el código del widget de Elfsight
- **inicio.css**: Estilos para la sección de Instagram (sin cambios necesarios)

## 🔗 Enlaces Útiles

- Panel de Elfsight: https://elfsight.com/
- Documentación: https://help.elfsight.com/
- Soporte: https://elfsight.com/support/

---

**Última actualización**: 26/11/2024
