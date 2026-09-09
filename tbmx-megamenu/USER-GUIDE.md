# Guía de Usuario - TBMX Mega Menu

## Índice

1. [Introducción](#introducción)
2. [Instalación](#instalación)
3. [Configuración Inicial](#configuración-inicial)
4. [Crear tu Primer Mega Menú](#crear-tu-primer-mega-menú)
5. [Usando Layouts de Divi](#usando-layouts-de-divi)
6. [Modo Columnas (sin Divi)](#modo-columnas-sin-divi)
7. [Personalización Avanzada](#personalización-avanzada)
8. [Preguntas Frecuentes](#preguntas-frecuentes)
9. [Solución de Problemas](#solución-de-problemas)

---

## Introducción

**TBMX Mega Menu** convierte los menús nativos de WordPress en mega menús profesionales con estética Divi. El contenido de cada panel puede ser un layout de la Biblioteca de Divi o columnas de enlaces personalizadas.

### Características Principales

- ✅ **Diseña con Divi**: Usa el Divi Builder para crear el contenido de tus paneles
- ✅ **Menús nativos**: Funciona con el sistema de menús de WordPress
- ✅ **Accesible**: Cumple con WCAG 2.1 Level AA
- ✅ **Responsive**: Se adapta automáticamente a móviles
- ✅ **Rápido**: Assets condicionales, solo carga cuando es necesario
- ✅ **Personalizable**: Colores, tipografía, animaciones y más

### Requisitos

- WordPress 5.8 o superior
- PHP 8.0 o superior
- **Opcional**: Divi theme o Divi Builder plugin (para layouts de Divi)

---

## Instalación

### Método 1: Desde WordPress Admin

1. Ve a **Plugins → Añadir nuevo**
2. Haz clic en **Subir plugin**
3. Selecciona el archivo `tbmx-megamenu.zip`
4. Haz clic en **Instalar ahora**
5. Activa el plugin

### Método 2: Por FTP

1. Descomprime `tbmx-megamenu.zip`
2. Sube la carpeta `tbmx-megamenu` a `/wp-content/plugins/`
3. Ve a **Plugins** en WordPress Admin
4. Activa **TBMX Mega Menu**

### Verificación

Después de activar, deberías ver:
- ✅ **TBMX Mega Menu** en el menú **Apariencia**
- ✅ Nuevos campos en los ítems de menú (Apariencia → Menús)

---

## Configuración Inicial

### 1. Acceder a los Ajustes Globales

1. Ve a **Apariencia → TBMX Mega Menu**
2. Verás las siguientes secciones:
   - **Colors**: Colores base del mega menú
   - **Layout**: Tipografía, espaciado y tratamiento visual
   - **Behavior**: Tiempos de interacción y responsive
   - **Style Presets**: Presets predefinidos

### 2. Usar un Preset (Recomendado para empezar)

Los presets aplican configuraciones profesionales instantáneamente:

- **Oscuro**: Fondo oscuro, texto claro, rojo de marca (estilo TuboMax)
- **Claro**: Fondo claro, texto oscuro, rojo de marca
- **Minimal**: Fondo gris, texto negro, acento negro, esquinas cuadradas

**Para aplicar un preset:**
1. Selecciona el preset deseado
2. Haz clic en **Guardar cambios**
3. ¡Listo! Los colores se aplicarán automáticamente

### 3. Personalizar Colores Manualmente

Si prefieres personalizar:

1. Ve a la sección **Colors**
2. Usa los color pickers para cada token:
   - **Background Color**: Fondo del panel
   - **Text Color**: Texto principal
   - **Muted Text Color**: Texto secundario
   - **Accent Color**: Color de acento (enlaces hover, badges)
   - **Border Color**: Bordes y separadores
3. Haz clic en **Guardar cambios**

### 4. Configurar Comportamiento

En la sección **Behavior**:

- **Hover In Delay (ms)**: Tiempo antes de abrir el panel (recomendado: 120ms)
- **Hover Out Delay (ms)**: Tiempo antes de cerrar el panel (recomendado: 200ms)
- **Mobile Breakpoint (px)**: Ancho donde se activa el modo móvil (recomendado: 980px)
- **Default Panel Width**: Ancho por defecto de los paneles

---

## Crear tu Primer Mega Menú

### Paso 1: Crear el Menú

1. Ve a **Apariencia → Menús**
2. Crea un nuevo menú o edita uno existente
3. Añade los ítems principales (estos serán los triggers del mega menú)

### Paso 2: Activar Mega Panel

1. Haz clic en la flecha ▼ del ítem de menú que quieres convertir en mega menú
2. Marca la casilla **Enable Mega Panel**
3. Se desplegarán los campos adicionales

### Paso 3: Configurar el Contenido

Tienes dos opciones:

#### Opción A: Usar un Layout de Divi (Recomendado)

1. En **Content Source**, selecciona **Divi Library Layout**
2. En **Select Divi Layout**, elige el layout que diseñaste
3. (Ver sección "Usando Layouts de Divi" para más detalles)

#### Opción B: Usar Columnas de Enlaces (sin Divi)

1. En **Content Source**, selecciona **Custom Columns (no Divi)**
2. Añade sub-ítems al menú (estos aparecerán en columnas)
3. (Ver sección "Modo Columnas" para más detalles)

### Paso 4: Personalizar el Panel (Opcional)

- **Panel Width**: Ancho del panel
  - **Full Width**: Ocupa todo el ancho de la pantalla
  - **Container Width**: Limitado al ancho del contenedor del tema
  - **Custom Width**: Ancho personalizado en píxeles
- **Panel Alignment**: Alineación del panel (Left, Center, Right)
- **Icon (optional)**: Clase de icono Divi o SVG personalizado
- **Badge (optional)**: Etiqueta pequeña (ej: "Nuevo", "Oferta")

### Paso 5: Guardar el Menú

1. Haz clic en **Guardar menú**
2. Visita tu sitio web
3. Pasa el mouse sobre el ítem del menú
4. ¡Tu mega menú debería aparecer!

---

## Usando Layouts de Divi

### Crear un Layout para el Mega Menú

1. Ve a **Divi → Divi Library**
2. Haz clic en **Add New Layout**
3. Dale un nombre descriptivo (ej: "Mega Menu - Servicios")
4. Diseña tu layout con el Divi Builder:
   - Usa módulos de texto, imágenes, botones, etc.
   - Organiza en filas y columnas
   - Añade iconos, badges, CTAs
5. Guarda el layout

### Recomendaciones de Diseño

**Ancho del layout:**
- Diseña pensando en el ancho del panel (full o container)
- Usa el módulo **Row** con ancho completo
- Evita anchos fijos, usa porcentajes

**Módulos recomendados:**
- **Text Module**: Para títulos y descripciones
- **Blurb Module**: Para iconos + texto
- **Button Module**: Para CTAs
- **Image Module**: Para imágenes destacadas
- **Divider Module**: Para separadores

**Estructura típica:**
```
Row (Full Width)
├── Column 1/4: Título + descripción
├── Column 1/4: Lista de enlaces
├── Column 1/4: Lista de enlaces
└── Column 1/4: CTA destacado
```

### Asignar el Layout al Menú

1. Ve a **Apariencia → Menús**
2. Activa **Enable Mega Panel** en el ítem deseado
3. Selecciona **Divi Library Layout** como Content Source
4. Elige tu layout del dropdown
5. Guarda el menú

---

## Modo Columnas (sin Divi)

Si no tienes Divi o prefieres un enfoque más simple:

### Crear el Menú con Sub-ítems

1. Ve a **Apariencia → Menús**
2. Añade el ítem principal (trigger del mega menú)
3. Añade sub-ítems debajo del principal:
   - Arrastra los sub-ítems ligeramente a la derecha
   - O usa el dropdown **Sub-item** al añadir
4. Activa **Enable Mega Panel** en el ítem principal
5. Selecciona **Custom Columns (no Divi)** como Content Source
6. Guarda el menú

### Cómo se Organiza

Los sub-ítems se organizan automáticamente en columnas:

- **1-5 sub-ítems**: 1 columna
- **6-10 sub-ítems**: 2 columnas
- **11-15 sub-ítems**: 3 columnas
- **16+ sub-ítems**: 4 columnas (máximo)

### Ejemplo

```
Menú Principal
├── Servicios (Mega Panel activado)
│   ├── Diseño Web
│   ├── Desarrollo
│   ├── SEO
│   ├── Marketing
│   └── Consultoría
```

Esto generará un panel con 2 columnas de enlaces.

---

## Personalización Avanzada

### CSS Personalizado

Puedes añadir CSS personalizado en **Apariencia → Personalizar → CSS adicional**:

```css
/* Cambiar el color del badge */
.tbmx-badge {
    background: #ff6b6b;
    color: white;
}

/* Aumentar el espaciado entre columnas */
.tbmx-columns {
    gap: 40px;
}

/* Cambiar la animación */
.tbmx-panel {
    transition-duration: 0.4s;
}
```

### JavaScript API

Puedes controlar el mega menú desde JavaScript:

```javascript
// Abrir un panel programáticamente
TBMX_MegaMenu.open('.menu-item-123 a');

// Cerrar todos los paneles
TBMX_MegaMenu.closeAll();

// Escuchar eventos
document.addEventListener('tbmx:open', function(e) {
    console.log('Panel abierto:', e.detail.panel);
});
```

### Filtros de WordPress

Desarrolladores pueden usar filtros para personalizar:

```php
// Modificar la configuración del JS
add_filter('tbmx_config', function($config) {
    $config['hoverIn'] = 150;
    return $config;
});

// Modificar las clases del panel
add_filter('tbmx_panel_classes', function($classes, $item_id) {
    $classes[] = 'mi-clase-personalizada';
    return $classes;
}, 10, 2);
```

---

## Preguntas Frecuentes

### ¿Necesito Divi para usar este plugin?

**No.** El plugin funciona sin Divi usando el modo "Custom Columns". Sin embargo, para usar layouts de Divi Library, necesitas:
- Divi theme, **O**
- Divi Builder plugin

### ¿El plugin ralentiza mi sitio?

**No.** El plugin está optimizado para el rendimiento:
- Los assets solo se cargan en páginas con mega menús
- JavaScript vanilla < 5 KB
- Sin dependencias externas
- CSS con variables (sin recompilación)

### ¿Puedo usar múltiples mega menús?

**Sí.** Puedes activar mega panels en tantos ítems de menú como quieras. Cada uno puede tener su propio layout o configuración.

### ¿El mega menú funciona en móviles?

**Sí.** En móviles (< 980px por defecto), los mega menús se convierten en acordeones verticales. Todo funciona por tap, sin hover.

### ¿Cómo cambio los colores después de aplicar un preset?

1. Ve a **Apariencia → TBMX Mega Menu**
2. Modifica los colores en la sección **Colors**
3. Haz clic en **Guardar cambios**
4. Los cambios se aplicarán inmediatamente

### ¿Puedo desactivar las animaciones?

**Sí.** Si el usuario tiene activada la opción "Reducir movimiento" en su sistema operativo, las animaciones se desactivan automáticamente. También puedes desactivarlas con CSS:

```css
.tbmx-panel {
    transition: none !important;
}
```

### ¿El plugin es accesible?

**Sí.** Cumple con WCAG 2.1 Level AA:
- Navegación completa por teclado
- Soporte para lectores de pantalla
- Focus visible en todos los elementos
- Contraste AA mínimo

---

## Solución de Problemas

### El mega menú no aparece

**Posibles causas:**

1. **Plugin no activado**
   - Ve a **Plugins** y verifica que TBMX Mega Menu está activado

2. **Mega Panel no activado**
   - Edita el menú y verifica que **Enable Mega Panel** está marcado

3. **Layout no seleccionado**
   - Si usas Divi, verifica que seleccionaste un layout

4. **Assets no se cargan**
   - Abre la consola del navegador (F12)
   - Verifica que `megamenu.css` y `megamenu.js` se cargan
   - Si no se cargan, verifica que el menú está asignado a una ubicación

### El layout de Divi no se renderiza

**Posibles causas:**

1. **Divi no está activo**
   - Verifica que Divi theme o Divi Builder están activos
   - Si no están activos, el plugin mostrará un mensaje de advertencia

2. **Layout vacío**
   - Edita el layout en Divi Library y verifica que tiene contenido

3. **Layout no publicado**
   - Verifica que el layout está publicado (no en borrador)

### Los colores no se aplican

**Posibles causas:**

1. **Caché del navegador**
   - Limpia la caché del navegador (Ctrl+F5)

2. **Caché del plugin de caché**
   - Si usas un plugin de caché (WP Rocket, W3 Total Cache, etc.), límpialo

3. **CSS personalizado sobrescribe**
   - Verifica que no hay CSS personalizado que sobrescriba los tokens

### El menú móvil no funciona

**Posibles causas:**

1. **Breakpoint incorrecto**
   - Verifica el **Mobile Breakpoint** en los ajustes
   - Ajusta según el ancho de tu tema

2. **Conflicto con el tema**
   - Algunos temas tienen su propio menú móvil
   - Verifica que el tema usa `wp_nav_menu()` correctamente

### Errores de JavaScript en la consola

**Posibles causas:**

1. **Conflicto con otro plugin**
   - Desactiva otros plugins uno por uno para identificar el conflicto

2. **Tema incompatible**
   - Verifica que el tema usa estándares de WordPress

3. **jQuery no cargado**
   - El admin requiere jQuery, verifica que WordPress lo carga

### Reportar un Bug

Si encuentras un problema que no puedes resolver:

1. **Recopila información:**
   - Versión de WordPress
   - Versión del plugin
   - Versión de PHP
   - Tema activo
   - Otros plugins activos
   - Mensajes de error de la consola

2. **Contacta soporte:**
   - Envía un email a soporte@tubomax.com
   - Incluye toda la información recopilada
   - Adjunta capturas de pantalla si es posible

---

## Soporte

### Documentación

- **Documento Maestro**: Especificación técnica completa
- **FAQ**: Esta sección
- **Changelog**: Historial de cambios

### Contacto

- **Email**: soporte@tubomax.com
- **Web**: https://tubomax.com
- **Horario**: Lunes a Viernes, 9:00 - 18:00 (GMT+1)

### Comunidad

- **Foro**: Próximamente
- **GitHub**: Próximamente

---

## Licencia

TBMX Mega Menu está licenciado bajo GPL v2 o posterior.

**Esto significa que puedes:**
- Usar el plugin en sitios personales y comerciales
- Modificar el código fuente
- Distribuir el plugin modificado

**Esto NO significa que puedes:**
- Vender el plugin sin soporte
- Eliminar la licencia GPL
- Reclamar autoría del código original

---

## Créditos

**Desarrollado por:** TuboMax  
**Versión:** 0.1.0  
**Última actualización:** 2024

---

¡Gracias por usar TBMX Mega Menu!
