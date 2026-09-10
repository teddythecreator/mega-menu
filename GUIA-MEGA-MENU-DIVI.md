# 🎯 Guía: Replicar el Mega Menú del Documento Maestro en Divi

## 🐛 Problema Identificado

El código del roadmap que pegaste en la plantilla de Divi está causando conflictos con el plugin TCB MegaMenu. Las causas probables son:

1. **jQuery conflict** - El script del roadmap usa jQuery que puede interferir con el vanilla JS del plugin
2. **CSS conflicts** - Los estilos globales del roadmap pueden estar afectando al mega menú
3. **Z-index conflicts** - Los elementos del roadmap pueden estar superponiéndose al mega menú
4. **Event conflicts** - El script puede estar capturando eventos que debería manejar el plugin

---

## ✅ Solución: Separar Roadmap del Header

### Paso 1: Eliminar el Código Problemático

**Elimina TODO el código del roadmap** de la plantilla del header. El roadmap debe ir en una sección separada del contenido, NO en el header donde está el menú.

### Paso 2: Estructura Correcta

```
HEADER (Template Divi)
├── Logo
├── Menú Principal (con TCB MegaMenu activado)
└── NO incluir roadmap aquí

CONTENIDO (Página normal)
├── Sección Hero
├── Sección Roadmap (aquí sí va el código)
├── Sección Servicios
└── Footer
```

---

## 🎨 Crear el Mega Menú del Documento Maestro en Divi

### Opción A: Usando Divi Library Layouts (Recomendado)

#### 1. Crear el Layout del Panel "Producto"

Ve a **Divi → Divi Library → Add New Layout**

**Nombre:** `Mega Menu - Producto`

**Estructura:**

```
Section (Full Width, Padding: 40px 0)
└── Row (4 columns: 1/4, 1/4, 1/4, 1/4)
    ├── Column 1 (Links)
    │   └── Text Module
    │       ├── Heading: "La recomendación"
    │       ├── Link: "Por qué un plugin y no un snippet"
    │       ├── Link: "Decisión de arquitectura"
    │       └── Link: "Definición de producto"
    │
    ├── Column 2 (Links)
    │   └── Text Module
    │       ├── Heading: "Distribución"
    │       ├── Link: "Licencia GPL"
    │       ├── Link: "Modelo de venta"
    │       └── Link: "Canales"
    │
    ├── Column 3 (Links)
    │   └── Text Module
    │       ├── Heading: "Recursos"
    │       ├── Link: "Documentación"
    │       ├── Link: "Soporte"
    │       └── Link: "Changelog"
    │
    └── Column 4 (Featured Box)
        └── Text Module
            ├── Background: #f8f9fa
            ├── Padding: 20px
            ├── Border-left: 3px solid #e11414
            ├── Heading: "¿Por qué esta vía?"
            ├── Text: "Un plugin, tres victorias..."
            └── Button: "Leer más →"
```

**CSS Personalizado del Section:**
```css
/* Fondo del panel */
.et_pb_section {
    background: #ffffff !important;
    border-top: 1px solid rgba(0,0,0,.08);
    border-radius: 0 0 10px 10px;
    box-shadow: 0 24px 60px rgba(0,0,0,.15);
}

/* Estilo de los headings */
.et_pb_text h4 {
    font-size: 14px;
    font-weight: 700;
    color: #e11414;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

/* Estilo de los links */
.et_pb_text a {
    display: block;
    padding: 8px 0;
    color: #333333;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.2s ease;
}

.et_pb_text a:hover {
    color: #e11414;
    padding-left: 8px;
}

/* Featured box */
.et_pb_text.featured-box {
    background: #f8f9fa;
    padding: 24px;
    border-left: 3px solid #e11414;
    border-radius: 0 10px 10px 0;
}

/* Button */
.et_pb_button {
    background: #e11414 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 10px 20px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 1px !important;
    transition: all 0.3s ease !important;
}

.et_pb_button:hover {
    background: #c01010 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(225, 20, 20, 0.3);
}
```

#### 2. Crear el Layout del Panel "Arquitectura"

**Nombre:** `Mega Menu - Arquitectura`

**Estructura similar pero con contenido técnico:**

```
Section (Full Width)
└── Row (2 columns: 1/2, 1/2)
    ├── Column 1 (Stack List)
    │   └── Text Module
    │       ├── "PHP 8.x · APIs nativas"
    │       ├── "JS vanilla < 5 KB"
    │       ├── "CSS custom properties"
    │       └── "Build opcional"
    │
    └── Column 2 (Code Block)
        └── Code Module
            └── Mostrar estructura de archivos
```

#### 3. Crear el Layout del Panel "Fases"

**Nombre:** `Mega Menu - Fases`

**Estructura:**

```
Section (Full Width)
└── Row (3 columns: 1/3, 1/3, 1/3)
    ├── Column 1
    │   └── Text Module
    │       ├── Badge: "AHORA" (background: #e11414, color: white)
    │       ├── Heading: "MVP · v0.1"
    │       └── List: "Metabox, render, tokens..."
    │
    ├── Column 2
    │   └── Text Module
    │       ├── Heading: "v1.0"
    │       └── List: "Ajustes globales, presets..."
    │
    └── Column 3
        └── Text Module
            ├── Heading: "v2.0"
            └── List: "Builder propio, tabs..."
```

---

### Opción B: Usando Custom Columns (sin Divi)

Si no quieres usar Divi Library, puedes usar el modo "Custom Columns" del plugin:

1. Ve a **Apariencia → Menús**
2. Activa **"Enable Mega Panel"** en el ítem "Producto"
3. Selecciona **"Custom Columns (no Divi)"**
4. Añade sub-ítems:
   - La recomendación
   - Decisión de arquitectura
   - Definición de producto
   - Distribución
5. Los sub-ítems se organizarán automáticamente en columnas

---

## 🔧 CSS Personalizado para el Header

Añade este CSS en **Divi → Theme Options → Custom CSS** o en **Apariencia → Personalizar → CSS adicional**:

```css
/* ═══════════════════════════════════════════════════════════════
   TCB MEGA MENU - ESTILOS DEL HEADER
   ═══════════════════════════════════════════════════════════════ */

/* Header sticky con blur */
#main-header {
    position: sticky !important;
    top: 0;
    z-index: 9999;
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

/* Logo */
#logo {
    max-height: 50px;
}

/* Menú principal */
#top-menu {
    display: flex;
    align-items: center;
    gap: 8px;
}

#top-menu li {
    position: relative;
}

#top-menu > li > a {
    padding: 20px 16px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    color: #333333 !important;
    transition: color 0.2s ease !important;
}

#top-menu > li > a:hover {
    color: #e11414 !important;
}

/* Indicador de hover (línea roja) */
#top-menu > li > a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 16px;
    right: 16px;
    height: 2px;
    background: #e11414;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

#top-menu > li > a:hover::after,
#top-menu > li.current-menu-item > a::after {
    transform: scaleX(1);
}

/* Badge en el menú */
.tcb-badge {
    display: inline-block;
    margin-left: 8px;
    padding: 2px 8px;
    background: #e11414;
    color: #ffffff;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 3px;
    vertical-align: middle;
}

/* ═══════════════════════════════════════════════════════════════
   MEGA MENU PANEL
   ═══════════════════════════════════════════════════════════════ */

/* Panel base */
.tcb-panel {
    background: #ffffff !important;
    border-top: 1px solid rgba(0, 0, 0, 0.08) !important;
    border-radius: 0 0 10px 10px !important;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.15) !important;
}

/* Panel inner */
.tcb-panel-inner {
    padding: 40px !important;
    max-width: 1200px;
    margin: 0 auto;
}

/* Columnas */
.tcb-columns {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 32px;
}

/* Links en el panel */
.tcb-panel a {
    color: #333333;
    text-decoration: none;
    transition: all 0.2s ease;
}

.tcb-panel a:hover {
    color: #e11414;
}

/* ═══════════════════════════════════════════════════════════════
   MOBILE MENU
   ═══════════════════════════════════════════════════════════════ */

@media (max-width: 980px) {
    /* Hamburger icon */
    .tcb-hamburger {
        display: block !important;
    }
    
    /* Panel móvil */
    .tcb-panel {
        position: static !important;
        width: 100% !important;
        border-radius: 0 !important;
        border-left: 3px solid #e11414 !important;
        box-shadow: none !important;
    }
    
    /* Columnas en móvil */
    .tcb-columns {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}

/* ═══════════════════════════════════════════════════════════════
   ROADMAP SECTION (fuera del header)
   ═══════════════════════════════════════════════════════════════ */

.roadmap-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.roadmap-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}

.roadmap-item {
    position: relative;
    padding-top: 32px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.roadmap-item:hover {
    transform: translateY(-4px);
}

.roadmap-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #e5e7eb;
    transition: background 0.3s ease;
}

.roadmap-item.active::before,
.roadmap-item:hover::before {
    background: #dc2626;
}

.roadmap-title {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 16px 0;
    letter-spacing: -0.5px;
}

.roadmap-desc {
    font-size: 15px;
    color: #6b7280;
    line-height: 1.6;
    margin: 0 0 24px 0;
}

.roadmap-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #dc2626;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: gap 0.3s ease;
}

.roadmap-link:hover {
    gap: 12px;
}

.roadmap-link-arrow {
    font-size: 16px;
    transition: transform 0.3s ease;
}

.roadmap-item:hover .roadmap-link-arrow {
    transform: translateX(4px);
}

/* Roadmap responsive */
@media (max-width: 768px) {
    .roadmap-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    
    .roadmap-item {
        padding-top: 24px;
    }
}
```

---

## 📝 HTML del Roadmap (PARA LA SECCIÓN DE CONTENIDO, NO EL HEADER)

Este código va en una sección normal de la página, **NO en el header**:

```html
<div class="roadmap-container">
    <div class="roadmap-grid">
        <!-- MVP V0.1 -->
        <div class="roadmap-item active">
            <h3 class="roadmap-title">MVP · V0.1</h3>
            <p class="roadmap-desc">Metabox, render, tokens, acordeón y ARIA</p>
            <a href="#mvp" class="roadmap-link">
                Ver alcance
                <span class="roadmap-link-arrow">→</span>
            </a>
        </div>
        
        <!-- V1.0 PRODUCTO -->
        <div class="roadmap-item">
            <h3 class="roadmap-title">V1.0 · PRODUCTO</h3>
            <p class="roadmap-desc">Ajustes globales, presets, i18n</p>
            <a href="#v1" class="roadmap-link">
                Ver alcance
                <span class="roadmap-link-arrow">→</span>
            </a>
        </div>
        
        <!-- V2.0 DIFERENCIACIÓN -->
        <div class="roadmap-item">
            <h3 class="roadmap-title">V2.0 · DIFERENCIACIÓN</h3>
            <p class="roadmap-desc">Builder propio, tabs, WooCommerce</p>
            <a href="#v2" class="roadmap-link">
                Ver alcance
                <span class="roadmap-link-arrow">→</span>
            </a>
        </div>
    </div>
</div>
```

**NOTA:** No incluyas el `<script>` de jQuery. El CSS ya maneja los efectos hover.

---

## 🔧 Configuración del Plugin

### 1. Configurar Colores

Ve a **TCB MegaMenu → Settings**:

- **Background Color**: `#ffffff`
- **Text Color**: `#333333`
- **Accent Color**: `#e11414`
- **Border Radius**: `10px`
- **Gap**: `32px`

### 2. Configurar Menú Móvil

- **Mobile Style**: `Drawer` o `Accordion`
- **Hamburger Icon**: `Classic`
- **Icon Color**: `#333333`
- **Icon Size**: `24px`

### 3. Crear el Menú

1. Ve a **Apariencia → Menús**
2. Crea un menú con los ítems principales:
   - **Producto** (activar mega panel)
   - **Arquitectura** (activar mega panel)
   - **Fases** (activar mega panel)
   - **Roadmap** (link normal)
   - **Prompts** (link normal)

### 4. Configurar cada Mega Menú

Para cada ítem con mega panel:

1. Activa **"Enable Mega Panel"**
2. Selecciona **"Divi Library Layout"**
3. Elige el layout correspondiente:
   - Producto → `Mega Menu - Producto`
   - Arquitectura → `Mega Menu - Arquitectura`
   - Fases → `Mega Menu - Fases`
4. **Panel Width**: `Container Width`
5. **Panel Alignment**: `Left`

---

## 🐛 Solución de Problemas

### "El mega menú no aparece"

**Causa:** El código del roadmap está en el header.
**Solución:** Mueve el roadmap a una sección de contenido, no al header.

### "Los estilos no se aplican"

**Causa:** Caché del navegador o de Divi.
**Solución:**
1. Limpia la caché del navegador (Ctrl+F5)
2. Ve a **Divi → Theme Options → Builder → Advanced**
3. Haz clic en **"Clear Static CSS File Generation"**
4. Si usas plugin de caché, límpialo también

### "El jQuery del roadmap interfiere"

**Causa:** El script del roadmap usa jQuery que puede interferir.
**Solución:** Elimina el `<script>` del roadmap. El CSS ya maneja los efectos hover.

### "El z-index no funciona"

**Causa:** Otros elementos tienen z-index más alto.
**Solución:** Añade esto al CSS personalizado:

```css
#main-header {
    z-index: 99999 !important;
}

.tcb-panel {
    z-index: 9998 !important;
}
```

---

## 📋 Checklist Final

- [ ] Eliminado el código del roadmap del header
- [ ] Roadmap movido a sección de contenido
- [ ] CSS personalizado añadido a Divi Theme Options
- [ ] Layouts de Divi creados para cada mega menú
- [ ] Plugin configurado con colores correctos
- [ ] Menú creado con mega panels activados
- [ ] Layouts asignados a cada mega panel
- [ ] Caché limpiada
- [ ] Probado en desktop
- [ ] Probado en móvil

---

## 🎯 Resultado Esperado

Con esta configuración tendrás:

✅ **Header sticky** con blur y border inferior
✅ **Mega menús** que se abren con hover (120ms delay)
✅ **Paneles con contenido** de Divi (layouts personalizados)
✅ **Animaciones suaves** de entrada/salida
✅ **Responsive** con drawer o accordion en móvil
✅ **Accesibilidad** completa (ARIA, teclado)
✅ **Roadmap** en sección de contenido sin conflictos

---

## 📞 Soporte

Si sigues teniendo problemas:

1. **Verifica** que el código del roadmap NO está en el header
2. **Limpia** toda la caché (navegador, Divi, plugins)
3. **Desactiva** otros plugins temporalmente para descartar conflictos
4. **Contacta** soporte: soporte@thecreator.business

---

**¡Con esta guía tendrás el mega menú del documento maestro funcionando en WordPress con Divi!** 🚀
