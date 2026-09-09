# TCB MegaMenu by The Creator Business

> **Plugin profesional de WordPress para mega menús con integración nativa de Divi**
> 
> Versión 1.3.0 · GPL v2 · https://thecreator.business/

---

## 🎯 Descripción

**TCB MegaMenu** convierte los menús nativos de WordPress en mega menús profesionales con estética Divi. El contenido de cada panel puede ser un **layout de la Biblioteca de Divi** o **columnas personalizadas** sin necesidad de Divi.

### Características Principales

- ✅ **Integración con Divi Library** — Usa cualquier layout como contenido del panel
- ✅ **Modo columnas sin Divi** — Funciona sin Divi usando sub-ítems del menú
- ✅ **4 estilos de menú móvil** — Accordion, Drawer, Overlay, Slide
- ✅ **5 iconos hamburguesa personalizables** — Classic, Arrow, Dots, Plus, X
- ✅ **Panel Width configurable** — Full, Container, Custom (px)
- ✅ **Colores personalizables** — Background, Text, Accent configurables
- ✅ **Accesibilidad WCAG 2.1 AA** — Navegación por teclado, ARIA completo
- ✅ **Rendimiento optimizado** — Assets condicionales, JS vanilla < 5 KB
- ✅ **Responsive completo** — Breakpoint configurable
- ✅ **Animaciones suaves** — Hover-intent, staggered columns

---

## 📋 Requisitos

- **WordPress** 5.8 o superior
- **PHP** 8.0 o superior
- **Divi theme** o **Divi Builder plugin** (opcional, para layouts de Divi)

---

## 🚀 Instalación

### Método 1: WordPress Admin (Recomendado)

1. Ve a **Plugins → Añadir nuevo → Subir plugin**
2. Selecciona el archivo `tcb-megamenu.zip`
3. Haz clic en **Instalar ahora**
4. Haz clic en **Activar plugin**

### Método 2: Por FTP

1. Descomprime `tcb-megamenu.zip`
2. Sube la carpeta `tcb-megamenu` a `/wp-content/plugins/`
3. Ve a **Plugins** en WordPress admin
4. Activa **TCB MegaMenu**

### Verificación

Después de activar, verás:
- ✅ Menú **TCB MegaMenu** en la barra lateral del admin
- ✅ Icono de grid amarillo
- ✅ Submenús: Settings

---

## 🎨 Configuración Rápida

### 1. Configurar Colores

Ve a **TCB MegaMenu → Settings**:

| Opción | Descripción | Ejemplo |
|--------|-------------|---------|
| **Background Color** | Color de fondo del panel | `#ffffff` |
| **Text Color** | Color del texto | `#333333` |
| **Accent Color** | Color de acento (links hover, badges) | `#e11414` |

### 2. Configurar Layout

| Opción | Descripción | Ejemplo |
|--------|-------------|---------|
| **Border Radius** | Redondez de esquinas | `10px` |
| **Gap/Spacing** | Espaciado interno | `32px` |

### 3. Configurar Comportamiento Desktop

| Opción | Descripción | Ejemplo |
|--------|-------------|---------|
| **Hover In Delay** | Tiempo antes de abrir (ms) | `120` |
| **Hover Out Delay** | Tiempo antes de cerrar (ms) | `200` |

### 4. Configurar Menú Móvil

| Opción | Descripción | Ejemplo |
|--------|-------------|---------|
| **Mobile Breakpoint** | Ancho donde se activa móvil (px) | `980` |
| **Mobile Style** | Estilo del menú móvil | `accordion` |
| **Drawer Position** | Posición del drawer | `left` |
| **Drawer Width** | Ancho del drawer (px) | `300` |

### 5. Configurar Icono Hamburguesa

| Opción | Descripción | Ejemplo |
|--------|-------------|---------|
| **Icon Style** | Estilo del icono | `classic` |
| **Icon Color** | Color del icono | `#333333` |
| **Icon Size** | Tamaño del icono (px) | `24` |
| **Line Thickness** | Grosor de línea (px) | `2` |

---

## 📱 Estilos de Menú Móvil

### 1. 📋 Accordion (Vertical)
Panel se despliega verticalmente debajo del trigger.
- **Ideal para:** Menús simples
- **Ventaja:** Simple y directo

### 2. 📥 Drawer (Lateral)
Panel se desliza desde izquierda o derecha.
- **Ideal para:** Menús complejos
- **Ventaja:** Elegante, mucho espacio
- **Configurable:** Posición (left/right) y ancho (200-500px)

### 3. 🔲 Overlay (Fullscreen)
Panel ocupa toda la pantalla.
- **Ideal para:** Experiencias inmersivas
- **Ventaja:** Impactante

### 4. 📤 Slide Down
Panel se desliza desde arriba.
- **Ideal para:** Acceso rápido
- **Ventaja:** Rápido y accesible

---

## 🍔 Iconos Hamburguesa

| Icono | Estilo | Uso Recomendado |
|-------|--------|-----------------|
| ☰ **Classic** | Tres líneas | Cualquier sitio |
| ← **Arrow** | Flechas | Sitios con dirección |
| ⋮ **Dots** | Tres puntos | Diseños minimalistas |
| + **Plus** | Línea que rota | Estilo flat |
| ✕ **X** | X mark | Estilo bold |

---

## 🎯 Crear tu Primer Mega Menú

### Paso 1: Crear el Menú

1. Ve a **Apariencia → Menús**
2. Crea un nuevo menú o edita uno existente
3. Añade ítems principales
4. Asigna el menú a una ubicación del tema
5. Guarda

### Paso 2: Activar Mega Panel

1. Haz clic en la flecha ▼ del ítem que quieres convertir
2. Marca **"Enable Mega Panel"**
3. Se desplegarán los campos adicionales

### Paso 3: Configurar el Contenido

**Opción A: Usar Divi Library Layout**
1. En **Content Source**, selecciona **Divi Library Layout**
2. En **Select Divi Layout**, elige tu layout
3. (Crea layouts en Divi → Divi Library)

**Opción B: Usar Columnas sin Divi**
1. En **Content Source**, selecciona **Custom Columns**
3. Añade sub-ítems al menú (se organizarán en columnas automáticamente)

### Paso 4: Configurar el Panel

- **Panel Width**: Full / Container / Custom
- **Panel Alignment**: Left / Center / Right
- **Icon** (opcional): Clase de icono o SVG
- **Badge** (opcional): Etiqueta (ej: "New", "Sale")

### Paso 5: Guardar y Probar

1. Guarda el menú
3. Visita tu sitio web
4. Pasa el mouse sobre el ítem
5. ¡El mega menú aparece! 🎉

---

## 🎯 Panel Width

| Opción | Comportamiento |
|--------|----------------|
| **Full Width** | Panel ocupa todo el viewport (100vw) |
| **Container Width** | Panel centrado con máximo 1200px |
| **Custom Width** | Panel con ancho exacto en píxeles |

---

## 📊 Estructura del Plugin

```
tcb-megamenu/
├── tcb-megamenu.php              # Archivo principal
├── uninstall.php                  # Limpieza al desinstalar
├── readme.txt                     # WordPress.org format
├── LICENSE                        # GPL v2
├── INSTALLATION-GUIDE.md          # Guía completa
├── GUIA-VISUAL-MOVIL.md           # Guía visual móvil
├── includes/
│   ├── class-plugin.php          # Singleton principal
│   ├── class-menu-fields.php     # Metabox
│   ├── class-menu-walker.php     # Walker con ARIA
│   ├── class-settings.php        # Ajustes globales
│   ├── class-assets.php          # Assets condicionales
│   └── class-renderer.php        # Render de paneles
├── assets/
│   ├── css/
│   │   ├── megamenu.css          # Estilos front
│   │   └── admin.css             # Estilos admin
│   └── js/
│       ├── megamenu.js           # JS front (< 5 KB)
│       └── admin.js              # JS admin
└── languages/
    └── (preparado para traducciones)
```

---

## 🔧 Para Desarrolladores

### Hooks y Filtros

```php
// Modificar configuración del JS
add_filter('tcb_megamenu_config', function($config) {
    $config['hoverIn'] = 150;
    return $config;
});
```

### API Pública JavaScript

```javascript
// Abrir un panel
TCB_MegaMenu.open('.menu-item-123 a');

// Cerrar un panel
TCB_MegaMenu.close('.menu-item-123 a');

// Cerrar todos los paneles
TCB_MegaMenu.closeAll();
```

### Variables CSS

```css
:root {
    --tcb-bg: #ffffff;
    --tcb-fg: #333333;
    --tcb-accent: #e11414;
    --tcb-border: rgba(0,0,0,.08);
    --tcb-radius: 10px;
    --tcb-shadow: 0 24px 60px rgba(0,0,0,.15);
    --tcb-font: inherit;
    --tcb-gap: 32px;
    --tcb-anim: .22s;
    --tcb-mobile-width: 300px;
    --tcb-hamburger-color: #333333;
    --tcb-hamburger-size: 24px;
    --tcb-hamburger-thickness: 2px;
}
```

---

## 🐛 Troubleshooting

### "El mega menú no aparece"
- Verifica que el plugin está activado
- Verifica que "Enable Mega Panel" está marcado
- Verifica que el menú está asignado a una ubicación
- Limpia la caché del navegador (Ctrl+F5)

### "El layout de Divi no se renderiza"
- Verifica que Divi theme o Divi Builder están activos
- Verifica que el layout está publicado
- Verifica que el layout tiene contenido

### "Los colores no se aplican"
- Ve a TCB MegaMenu → Settings
- Configura los colores
- Guarda los cambios
- Limpia la caché del navegador

### "El menú móvil no funciona"
- Verifica el Mobile Breakpoint en Settings
- Redimensiona la ventana del navegador
- Verifica que el JavaScript se carga

---

## 📚 Documentación

- **Guía de Instalación:** `INSTALLATION-GUIDE.md`
- **Guía Visual Móvil:** `GUIA-VISUAL-MOVIL.md`
- **WordPress.org Readme:** `readme.txt`
- **Licencia:** `LICENSE` (GPL v2)

---

## 🎓 Historial de Versiones

### v1.3.0 (Actual)
- ✅ 4 estilos de menú móvil (Accordion, Drawer, Overlay, Slide)
- ✅ 5 iconos hamburguesa personalizables
- ✅ Color, tamaño y grosor del icono configurables
- ✅ Drawer con posición y ancho configurables
- ✅ Overlay automático para drawer/overlay
- ✅ Animaciones suaves para todos los estilos

### v1.2.0
- ✅ Background configurable (sin transparencia forzada)
- ✅ Settings simplificado y funcional
- ✅ Móvil completamente funcional
- ✅ Panel Width funcionando correctamente

### v1.1.0
- ✅ Integración corregida con Divi
- ✅ Menú principal (no bajo Apariencia)
- ✅ Documentación completa

### v1.0.0
- ✅ Metabox completo con 8 campos
- ✅ Página de ajustes globales
- ✅ Walker personalizado con ARIA
- ✅ Render de layouts de Divi
- ✅ Modo columnas sin Divi
- ✅ Accesibilidad WCAG 2.1 AA
- ✅ Rendimiento optimizado (< 5 KB JS)

---

## 📞 Soporte

- **Website:** https://thecreator.business/
- **Email:** soporte@thecreator.business

---

## 📄 Licencia

GPL v2 or later - Ver [LICENSE](tcb-megamenu/LICENSE) para más detalles.

---

## 🎉 Créditos

**Desarrollado por:** The Creator Business  
**Versión:** 1.3.0  
**Última actualización:** 2024  
**Website:** https://thecreator.business/

---

**¡Gracias por usar TCB MegaMenu!** 🚀
