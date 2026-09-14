# 🔧 Troubleshooting - Plugin No Funciona

## 🐛 Error Reportado

```
Notice: Function WP_Styles::add was called incorrectly. 
The style with the handle "block-style-variation-styles" was enqueued 
with dependencies that are not registered: global-styles.
```

### ⚠️ IMPORTANTE: Este error NO es del plugin

Este error es de **WordPress core** (versión 6.9.1), no de TCB MegaMenu. Es un error conocido de WordPress relacionado con block styles y no afecta la funcionalidad del plugin.

**Puedes ignorar este error** o actualizar WordPress a la última versión.

---

## 🔍 Diagnóstico Paso a Paso

### Paso 1: Verificar que el Plugin está Activo

1. Ve a **Plugins** en WordPress
2. Busca **TCB MegaMenu**
3. Verifica que está **Activado**

**Si no está activo:**
- Haz clic en **Activar**
- Si da error, ve al Paso 2

---

### Paso 2: Verificar Archivos del Plugin

Usa la herramienta de diagnóstico que creé:

1. Abre en tu navegador:
   ```
   http://tu-sitio-local/wp-content/plugins/tcb-megamenu/diagnostic.php
   ```
   (Reemplaza `tu-sitio-local` con tu dominio local)

2. Esta herramienta te mostrará:
   - ✓ Estado del plugin
   - ✓ Archivos presentes
   - ✓ Configuración guardada
   - ✓ Menús configurados
   - ✓ Compatibilidad con Divi
   - ✓ Información del sistema

---

### Paso 3: Verificar Errores en la Consola

1. Abre tu sitio en el navegador
2. Presiona **F12** para abrir las herramientas de desarrollador
3. Ve a la pestaña **Console**
4. Busca errores en rojo

**Errores comunes:**

#### Error: "TCB_MegaMenu is not defined"
**Causa:** El archivo JavaScript no se carga
**Solución:**
```bash
# Verifica que el archivo existe
ls tcb-megamenu/assets/js/megamenu.js
```

#### Error: "Failed to load resource: 404"
**Causa:** Algún archivo CSS/JS no se encuentra
**Solución:**
- Verifica que todos los archivos están en su lugar
- Limpia la caché del navegador (Ctrl+F5)

#### Error: "Uncaught TypeError"
**Causa:** Conflicto con otro plugin o tema
**Solución:**
- Desactiva otros plugins temporalmente
- Cambia a un tema por defecto (Twenty Twenty-Four)
- Si funciona, el conflicto es con otro plugin/tema

---

### Paso 4: Verificar Configuración del Menú

1. Ve a **Apariencia → Menús**
2. Selecciona tu menú
3. Expande un ítem del menú
4. Verifica que **"Enable Mega Panel"** está marcado
5. Verifica que hay contenido configurado (Divi Layout o Custom Columns)
6. Guarda el menú

---

### Paso 5: Verificar que el Menú está Asignado

1. Ve a **Apariencia → Menús**
2. En la parte inferior, busca **"Ubicación del tema"**
3. Verifica que tu menú está asignado a una ubicación (ej: "Primary Menu")
4. Guarda los cambios

---

### Paso 6: Limpiar Caché

**Caché del navegador:**
- Chrome: `Ctrl + Shift + Delete` → Cached images and files
- Firefox: `Ctrl + Shift + Delete` → Cache
- Safari: `Cmd + Option + E`

**Caché de WordPress:**
Si usas un plugin de caché (WP Rocket, W3 Total Cache, etc.):
- Ve a la configuración del plugin
- Busca la opción "Limpiar caché" o "Purge cache"
- Haz clic en limpiar

---

### Paso 7: Verificar el Tema

Algunos temas tienen su propio sistema de menú que puede entrar en conflicto.

**Prueba con un tema por defecto:**
1. Ve a **Apariencia → Temas**
2. Activa **Twenty Twenty-Four** (o cualquier tema por defecto)
3. Ve al front-end
4. Si el mega menú funciona, el problema es con tu tema

**Solución para temas con conflicto:**
- Contacta al desarrollador del tema
- Usa un hook personalizado para integrar el mega menú
- Considera usar un tema compatible con mega menús

---

## 🛠️ Soluciones Específicas

### Problema: "El plugin no se activa"

**Causa:** Error de sintaxis PHP o archivo faltante

**Solución:**
1. Ve a `wp-content/plugins/tcb-megamenu/`
2. Verifica que todos los archivos están presentes
3. Verifica la sintaxis PHP:
   ```bash
   php -l tcb-megamenu.php
   php -l includes/class-plugin.php
   # Repite para todos los archivos PHP
   ```
4. Si hay errores de sintaxis, corrígelos o reinstala el plugin

---

### Problema: "El menú no aparece en el front-end"

**Causa:** El walker no se está aplicando

**Solución:**
1. Verifica que el tema usa `wp_nav_menu()`:
   ```bash
   # Busca en los archivos del tema
   grep -r "wp_nav_menu" wp-content/themes/tu-tema/
   ```
2. Verifica que el menú está asignado a una ubicación
3. Verifica que hay ítems con "Enable Mega Panel" activado
4. Revisa la consola del navegador por errores JavaScript

---

### Problema: "El menú móvil no funciona"

**Causa:** CSS o JavaScript no se carga correctamente

**Solución:**
1. Verifica que `mobile-fix.css` existe:
   ```bash
   ls tcb-megamenu/assets/css/mobile-fix.css
   ```
2. Redimensiona la ventana del navegador (< 980px)
3. Verifica que el breakpoint es correcto en Settings
4. Revisa la consola del navegador por errores

---

### Problema: "Los iconos duplicados aparecen en móvil"

**Causa:** El CSS móvil no se aplica

**Solución:**
1. Limpia la caché del navegador (Ctrl+F5)
2. Verifica que `mobile-fix.css` se carga:
   - Abre las herramientas de desarrollador (F12)
   - Ve a la pestaña **Network**
   - Recarga la página
   - Busca `mobile-fix.css` en la lista
   - Verifica que tiene status 200
3. Si no se carga, verifica que el archivo existe y tiene permisos correctos

---

### Problema: "El contenido de Divi no se renderiza"

**Causa:** Divi no está activo o el layout no existe

**Solución:**
1. Verifica que Divi theme o Divi Builder está activo
2. Verifica que el layout existe en **Divi → Divi Library**
3. Verifica que el layout está seleccionado en el metabox del menú
4. Verifica que el layout tiene contenido

---

## 📋 Checklist de Verificación

### Antes de Contactar Soporte

- [ ] El plugin está activo
- [ ] Todos los archivos del plugin están presentes
- [ ] La configuración está guardada
- [ ] Al menos un ítem del menú tiene "Enable Mega Panel" activado
- [ ] El menú está asignado a una ubicación del tema
- [ ] La caché del navegador está limpia
- [ ] La caché de WordPress está limpia (si usas plugin de caché)
- [ ] No hay errores de JavaScript en la consola
- [ ] No hay errores de PHP en los logs
- [ ] El tema usa `wp_nav_menu()`
- [ ] Divi está activo (si usas layouts de Divi)

---

## 🔧 Reinstalación Completa

Si nada funciona, prueba una reinstalación completa:

### Paso 1: Hacer Backup
```bash
# Backup de la base de datos
mysqldump -u usuario -p nombre_base_datos > backup.sql

# Backup de los archivos del plugin
cp -r wp-content/plugins/tcb-megamenu/ ~/backup-tcb-megamenu/
```

### Paso 2: Desinstalar el Plugin
1. Ve a **Plugins**
2. **Desactiva** TCB MegaMenu
3. **Borra** el plugin

### Paso 3: Limpiar la Base de Datos
```sql
-- Eliminar opciones del plugin
DELETE FROM wp_options WHERE option_name LIKE 'tcb_megamenu_%';

-- Eliminar metas de menú (OPCIONAL - esto borrará tus configuraciones)
DELETE FROM wp_postmeta WHERE meta_key LIKE '_tcb_%';
```

### Paso 4: Reinstalar el Plugin
1. Ve a **Plugins → Añadir nuevo → Subir plugin**
2. Sube `tcb-megamenu-v1.3.4.zip`
3. **Activa** el plugin
4. Ve a **TCB MegaMenu → Settings**
5. Guarda la configuración
6. Ve a **Apariencia → Menús**
7. Configura los mega menús

---

## 📞 Soporte

Si después de seguir todos estos pasos el plugin sigue sin funcionar:

### Información Necesaria

1. **Versión de WordPress:** (la encuentras en el pie de página del admin)
2. **Versión de PHP:** (la encuentras en la herramienta de diagnóstico)
3. **Tema activo:** (nombre del tema)
4. **Plugins activos:** (lista de todos los plugins activos)
5. **Errores de la consola:** (captura de pantalla de F12 → Console)
6. **Errores de PHP:** (contenido de `wp-content/debug.log` si existe)
7. **Capturas de pantalla:**
   - Herramienta de diagnóstico completa
   - Configuración del menú
   - Front-end del sitio
   - Consola del navegador

### Contacto

- **Email:** soporte@thecreator.business
- **Website:** https://thecreator.business/
- **Horario:** Lunes a Viernes, 9:00 - 18:00 (GMT+1)

---

## 🎯 Errores Conocidos de WordPress

### Error: "block-style-variation-styles"

**Este error NO es del plugin.** Es un error de WordPress 6.9.1.

**Solución:**
- Ignora el error (no afecta la funcionalidad)
- O actualiza WordPress a la última versión
- O desactiva el modo de debug en `wp-config.php`:
  ```php
  define( 'WP_DEBUG', false );
  ```

### Error: "global-styles" dependency

**Este error NO es del plugin.** Es un error de WordPress core.

**Solución:**
- Ignora el error
- O actualiza WordPress
- O desactiva el modo de debug

---

## ✅ Conclusión

El error que ves (`block-style-variation-styles`) es de WordPress core, no del plugin. Sigue los pasos de diagnóstico para identificar el problema real con el plugin.

Si el plugin no funciona, usa la herramienta de diagnóstico y contacta soporte con toda la información solicitada.

---

**Versión del documento:** 1.0  
**Fecha:** 2024  
**Plugin:** TCB MegaMenu v1.3.4
