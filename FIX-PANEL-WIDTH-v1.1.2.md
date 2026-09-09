# 🔧 Fix Panel Width - v1.1.2

## 🐛 Problema Reportado

Las opciones de **Panel Width** no funcionaban correctamente:
- ❌ Container width no se aplicaba
- ❌ Custom width no se aplicaba
- ❌ Full width funcionaba pero con problemas de posicionamiento

## 🔍 Causa del Problema

El CSS base del panel tenía `left: 0; right: 0;` que forzaba el ancho completo del viewport, y las clases de width no podían sobrescribirlo correctamente.

Además, para **custom width** no se estaba aplicando el ancho personalizado en ningún lado.

## ✅ Solución Implementada

### 1. CSS Corregido (`assets/css/megamenu.css`)

**Antes:**
```css
.tcb-panel {
    left: 0;
    right: 0;
    /* ... */
}
```

**Ahora:**
```css
.tcb-panel {
    /* Sin left/right fijos */
    /* ... */
}

.tcb-width-full {
    left: 50%;
    right: auto;
    width: 100vw;
    transform: translateX(-50%) translateY(10px);
}

.tcb-width-container {
    left: 50%;
    right: auto;
    width: 100%;
    max-width: 1200px;
    transform: translateX(-50%) translateY(10px);
}

.tcb-width-custom {
    left: 50%;
    right: auto;
    transform: translateX(-50%) translateY(10px);
    /* El width se aplica via inline style */
}
```

### 2. Walker Corregido (`includes/class-menu-walker.php`)

**Antes:**
```php
// No aplicaba inline style para custom width
```

**Ahora:**
```php
$width    = Menu_Fields::get_meta( $data_object->ID, Menu_Fields::META_WIDTH, 'full' );
$width_px = Menu_Fields::get_meta( $data_object->ID, Menu_Fields::META_WIDTH_PX, 1200 );

// Inline style para custom width
$inline_style = '';
if ( 'custom' === $width && $width_px > 0 ) {
    $inline_style = ' style="width: ' . intval( $width_px ) . 'px;"';
}

$output .= $inline_style;
```

## 🎯 Cómo Funciona Ahora

### Full Width
- Ocupa todo el ancho del viewport (100vw)
- Centrado con `transform: translateX(-50%)`
- Se extiende más allá del contenedor del tema

### Container Width
- Ancho máximo de 1200px
- Centrado con `transform: translateX(-50%)`
- Respeta el contenedor del tema

### Custom Width
- Ancho personalizado en píxeles (configurable en el metabox)
- Centrado con `transform: translateX(-50%)`
- Se aplica via inline style: `width: XXXpx`

## 📦 Cómo Actualizar

### Opción 1: Usando el script
```bash
./scripts/package-plugin.sh --tag 1.1.2
```

### Opción 2: Manualmente
```bash
cd tcb-megamenu
zip -r ../tcb-megamenu-v1.1.2.zip .
```

## 🔄 Cómo Reinstalar

1. Ve a **Plugins** en WordPress
2. **Desactiva** TCB MegaMenu
3. **Borra** el plugin
4. Ve a **Plugins → Añadir nuevo → Subir plugin**
5. Sube `tcb-megamenu-v1.1.2.zip`
6. **Activa** el plugin
7. **Limpia la caché** del navegador: `Ctrl + F5`

## 🧪 Cómo Probar

### 1. Full Width
1. Ve a **Apariencia → Menús**
2. Edita un ítem con mega panel activado
3. En **Panel Width**, selecciona **Full Width**
4. Guarda el menú
5. Ve al front-end y abre el mega menú
6. **Resultado esperado**: Panel ocupa todo el ancho de la pantalla

### 2. Container Width
1. En **Panel Width**, selecciona **Container Width**
2. Guarda el menú
3. Ve al front-end y abre el mega menú
4. **Resultado esperado**: Panel centrado con máximo 1200px

### 3. Custom Width
1. En **Panel Width**, selecciona **Custom Width**
2. Aparece el campo **Custom Width (px)**
3. Escribe un valor (ej: 800px)
4. Guarda el menú
5. Ve al front-end y abre el mega menú
6. **Resultado esperado**: Panel con ancho exacto de 800px

## 📋 Verificación Técnica

### HTML generado (ejemplo)

**Full Width:**
```html
<div id="tcb-panel-123" class="tcb-panel tcb-width-full tcb-align-left" role="region">
    <div class="tcb-panel-inner">...</div>
</div>
```

**Container Width:**
```html
<div id="tcb-panel-123" class="tcb-panel tcb-width-container tcb-align-left" role="region">
    <div class="tcb-panel-inner">...</div>
</div>
```

**Custom Width (800px):**
```html
<div id="tcb-panel-123" class="tcb-panel tcb-width-custom tcb-align-left" style="width: 800px;" role="region">
    <div class="tcb-panel-inner">...</div>
</div>
```

## 🎨 CSS Applied

### Full Width
```css
.tcb-width-full {
    left: 50%;
    right: auto;
    width: 100vw;
    transform: translateX(-50%) translateY(10px);
}
```

### Container Width
```css
.tcb-width-container {
    left: 50%;
    right: auto;
    width: 100%;
    max-width: 1200px;
    transform: translateX(-50%) translateY(10px);
}
```

### Custom Width
```css
.tcb-width-custom {
    left: 50%;
    right: auto;
    transform: translateX(-50%) translateY(10px);
}
/* Plus inline style: width: XXXpx */
```

## 🐛 Troubleshooting

### "El panel sigue ocupando todo el ancho"
- Limpia la caché del navegador: `Ctrl + F5`
- Verifica que la versión del plugin es 1.1.2
- Inspecciona el elemento y verifica que las clases CSS se aplican correctamente

### "Container width no se centra"
- Verifica que el CSS se carga correctamente
- Inspecciona el elemento y verifica que tiene la clase `tcb-width-container`
- Verifica que no hay CSS personalizado que sobrescriba los estilos

### "Custom width no se aplica"
- Verifica que el campo "Custom Width (px)" tiene un valor > 0
- Guarda el menú después de cambiar el valor
- Inspecciona el elemento y verifica que tiene el inline style `width: XXXpx`

## 📊 Archivos Modificados

1. `tcb-megamenu.php` - Versión actualizada a 1.1.2
2. `includes/class-menu-walker.php` - Añadido inline style para custom width
3. `assets/css/megamenu.css` - CSS de width corregido

---

**Versión:** 1.1.2  
**Fecha:** 2024  
**Cambio principal:** Corregido el funcionamiento de Panel Width (Full, Container, Custom)
