/* Datos del checklist de QA - TBMX Mega Menu */

export type QACategory = {
  id: string;
  title: string;
  icon: string;
  color: string;
  groups: {
    title: string;
    items: string[];
  }[];
};

export const QA_CATEGORIES: QACategory[] = [
  {
    id: "install",
    title: "Instalación y Activación",
    icon: "📦",
    color: "#3ecf8e",
    groups: [
      {
        title: "Instalación desde ZIP",
        items: [
          "El archivo tbmx-megamenu.zip se descomprime correctamente",
          "La carpeta tbmx-megamenu se crea en wp-content/plugins/",
          "No hay errores PHP durante la activación",
          "El plugin aparece en la lista de plugins activos",
          "Se muestra la entrada 'TBMX Mega Menu' en el menú Apariencia",
        ],
      },
      {
        title: "Activación / Desactivación",
        items: [
          "El plugin se activa sin errores",
          "El plugin se desactiva sin errores",
          "Al reactivar, las configuraciones previas se mantienen",
          "No hay conflictos con otros plugins al activar",
        ],
      },
      {
        title: "Desinstalación",
        items: [
          "Se elimina la opción tbmx_megamenu_settings",
          "Se eliminan todas las metas _tbmx_* de los ítems de menú",
          "Se eliminan los transients del plugin",
          "No quedan archivos residuales",
        ],
      },
    ],
  },
  {
    id: "settings",
    title: "Ajustes Globales",
    icon: "⚙️",
    color: "#f0b429",
    groups: [
      {
        title: "Acceso",
        items: [
          "La página es accesible desde Apariencia → TBMX Mega Menu",
          "Solo usuarios con edit_theme_options pueden acceder",
          "Usuarios sin permisos reciben mensaje de acceso denegado",
        ],
      },
      {
        title: "Colores",
        items: [
          "Los 5 color pickers se renderizan correctamente",
          "Los color pickers muestran preview en tiempo real",
          "Se pueden ingresar valores HEX (#RRGGBB)",
          "Se pueden ingresar valores RGBA",
          "Los cambios se guardan y persisten tras recargar",
        ],
      },
      {
        title: "Layout",
        items: [
          "Font Family se guarda correctamente",
          "Border Radius se guarda correctamente",
          "Box Shadow se guarda correctamente",
          "Gap se guarda correctamente",
        ],
      },
      {
        title: "Behavior",
        items: [
          "Hover In Delay acepta valores numéricos (0-1000ms)",
          "Hover Out Delay acepta valores numéricos (0-1000ms)",
          "Mobile Breakpoint acepta valores numéricos (320-1400px)",
          "Default Panel Width (Full/Container) se guarda correctamente",
          "Los valores inválidos se rechazan",
        ],
      },
      {
        title: "Presets",
        items: [
          "Preset 'Oscuro' aplica los valores correctos",
          "Preset 'Claro' aplica los valores correctos",
          "Preset 'Minimal' aplica los valores correctos",
          "Los presets sobrescriben los valores actuales",
        ],
      },
    ],
  },
  {
    id: "metabox",
    title: "Metabox en Ítems de Menú",
    icon: "🎛️",
    color: "#e11414",
    groups: [
      {
        title: "Visibilidad",
        items: [
          "El metabox aparece en ítems de menú de nivel 0 (padres)",
          "El metabox NO aparece en ítems de nivel > 0 (hijos)",
          "El metabox aparece en todos los menús registrados",
        ],
      },
      {
        title: "Enable Mega Panel",
        items: [
          "El checkbox se renderiza correctamente",
          "Al marcar, se muestran los campos adicionales",
          "Al desmarcar, se ocultan los campos adicionales",
          "La animación de mostrar/ocultar es suave",
          "El estado se guarda y persiste",
        ],
      },
      {
        title: "Content Source",
        items: [
          "El selector muestra 2 opciones: Divi Library / Custom Columns",
          "Al seleccionar 'Divi Library', se muestra el selector de layout",
          "Al seleccionar 'Custom Columns', se oculta el selector de layout",
          "El valor se guarda correctamente",
        ],
      },
      {
        title: "Select Divi Layout",
        items: [
          "El selector muestra todos los layouts de Divi Library",
          "Los layouts se ordenan alfabéticamente",
          "La opción '— Select a layout —' está presente",
          "Si no hay layouts, se muestra 'No Divi layouts found'",
          "El layout seleccionado persiste tras recargar",
        ],
      },
      {
        title: "Panel Width / Alignment",
        items: [
          "Panel Width muestra 3 opciones: Full / Container / Custom",
          "Al seleccionar 'Custom', aparece el campo de ancho personalizado",
          "Custom Width acepta 600-2000px con step de 10",
          "Panel Alignment muestra 3 opciones: Left / Center / Right",
        ],
      },
      {
        title: "Icon y Badge",
        items: [
          "El campo Icon acepta texto y se sanitiza",
          "El campo Badge acepta texto y se sanitiza",
          "Los placeholders son visibles",
        ],
      },
      {
        title: "Seguridad",
        items: [
          "Nonce se genera y verifica correctamente",
          "Guardado falla si el nonce es inválido",
          "Solo usuarios con edit_theme_options pueden guardar",
          "Los datos se sanitizan según su tipo",
          "Los selects validan contra whitelist",
        ],
      },
    ],
  },
  {
    id: "render",
    title: "Render en Front-End",
    icon: "🎨",
    color: "#9b59b6",
    groups: [
      {
        title: "Estructura HTML",
        items: [
          "Los ítems mega tienen la clase tbmx-mega-item",
          "Los triggers tienen data-tbmx-toggle=\"mega\"",
          "Los triggers tienen aria-haspopup=\"true\"",
          "Los triggers tienen aria-expanded=\"false\" inicialmente",
          "Los triggers tienen aria-controls apuntando al panel",
          "Los paneles tienen role=\"region\"",
          "Los paneles tienen aria-label descriptivo",
          "Los paneles tienen aria-hidden=\"true\" inicialmente",
          "Los paneles tienen atributo hidden inicialmente",
        ],
      },
      {
        title: "Clases del Panel",
        items: [
          "Panel tiene clase tbmx-panel",
          "Panel tiene clase tbmx-width-{full|container|custom}",
          "Panel tiene clase tbmx-align-{left|center|right}",
          "Las clases se aplican según la configuración",
        ],
      },
      {
        title: "Badge",
        items: [
          "El badge se muestra si está configurado",
          "El badge tiene la clase tbmx-badge",
          "El texto del badge se escapa correctamente",
          "No se muestra badge si no está configurado",
        ],
      },
      {
        title: "Render de Layout Divi",
        items: [
          "El contenido del layout se renderiza correctamente",
          "Los shortcodes de Divi se procesan",
          "Los estilos de Divi se cargan",
          "Si el layout no existe, se muestra mensaje de error",
          "Si Divi no está activo, se muestra advertencia",
        ],
      },
      {
        title: "Render de Columnas (sin Divi)",
        items: [
          "1-5 sub-ítems → 1 columna",
          "6-10 sub-ítems → 2 columnas",
          "11-15 sub-ítems → 3 columnas",
          "16+ sub-ítems → 4 columnas",
          "Los enlaces se renderizan correctamente",
          "Si no hay sub-ítems, se muestra mensaje",
        ],
      },
      {
        title: "Tokens CSS",
        items: [
          "Los tokens se inyectan en <head> con id tbmx-megamenu-tokens",
          "Los tokens reflejan los valores de los ajustes globales",
          "Los tokens se aplican correctamente a los paneles",
        ],
      },
    ],
  },
  {
    id: "desktop",
    title: "Interacción Desktop",
    icon: "🖥️",
    color: "#3498db",
    groups: [
      {
        title: "Hover-Intent",
        items: [
          "Al pasar el mouse, el panel se abre después de 120ms",
          "El hover indicator se muestra durante el hover",
          "Al salir, el panel se cierra después de 200ms",
          "Los tiempos son configurables desde los ajustes",
          "El hover-intent NO se dispara por roce accidental",
        ],
      },
      {
        title: "Click / Tap",
        items: [
          "Al hacer clic en el trigger, el panel se abre",
          "Al hacer clic nuevamente, el panel se cierra",
          "El click funciona en desktop y móvil",
          "El click previene el comportamiento por defecto",
        ],
      },
      {
        title: "Panel Único",
        items: [
          "Solo un panel puede estar abierto a la vez",
          "Al abrir un panel, se cierra cualquier otro abierto",
          "No hay conflictos al cambiar entre paneles",
        ],
      },
      {
        title: "Click Outside",
        items: [
          "Al hacer clic fuera del panel, se cierra",
          "El click en otros elementos no interfiere",
          "El click en el trigger actual no cierra el panel",
        ],
      },
      {
        title: "Animaciones",
        items: [
          "El panel aparece con fade + translateY",
          "La animación dura 220ms",
          "Las columnas aparecen con stagger (50ms entre cada una)",
          "Las animaciones son suaves y profesionales",
        ],
      },
    ],
  },
  {
    id: "keyboard",
    title: "Interacción Teclado",
    icon: "⌨️",
    color: "#1abc9c",
    groups: [
      {
        title: "Navegación Básica",
        items: [
          "Tab navega entre los triggers del menú",
          "Enter abre/cierra el panel del trigger con foco",
          "Space abre/cierra el panel del trigger con foco",
          "Escape cierra el panel y devuelve el foco al trigger",
        ],
      },
      {
        title: "Dentro del Panel",
        items: [
          "Tab navega entre los enlaces del panel",
          "Shift+Tab navega hacia atrás",
          "ArrowDown mueve el foco al primer elemento del panel",
          "ArrowUp devuelve el foco al trigger",
          "El foco nunca queda atrapado en el panel",
        ],
      },
      {
        title: "Entre Siblings",
        items: [
          "ArrowRight mueve el foco al siguiente mega item",
          "ArrowLeft mueve el foco al anterior mega item",
          "La navegación cicla al final/inicio de la lista",
          "El foco es visible en todos los elementos",
        ],
      },
      {
        title: "Focus Visible",
        items: [
          "El foco es visible en los triggers",
          "El foco es visible en los enlaces del panel",
          "El outline usa el color de accent",
          "El outline tiene offset de 2px",
        ],
      },
    ],
  },
  {
    id: "mobile",
    title: "Interacción Móvil",
    icon: "📱",
    color: "#e67e22",
    groups: [
      {
        title: "Breakpoint",
        items: [
          "El modo móvil se activa bajo 980px (por defecto)",
          "El breakpoint es configurable desde los ajustes",
          "Al cambiar de desktop a móvil, los paneles se cierran",
          "Al cambiar de móvil a desktop, los paneles se cierran",
        ],
      },
      {
        title: "Acordeón",
        items: [
          "Los paneles se convierten en acordeones verticales",
          "El acordeón se abre/cierra con tap",
          "No hay hover en móvil",
          "El acordeón tiene border-left de accent (3px)",
          "El acordeón ocupa todo el ancho",
        ],
      },
      {
        title: "Touch Support",
        items: [
          "El double-tap zoom está prevenido",
          "El feedback visual al tap funciona (scale 0.98)",
          "Los taps son precisos y responsivos",
          "No hay delays innecesarios en la respuesta táctil",
        ],
      },
      {
        title: "Scroll Lock",
        items: [
          "El scroll del body se bloquea al abrir un panel",
          "La posición de scroll se restaura al cerrar",
          "No hay 'scroll bounce' en iOS",
          "El scroll lock funciona correctamente en Android",
        ],
      },
      {
        title: "Layout Móvil",
        items: [
          "Las columnas se muestran en 1 columna",
          "El padding se reduce",
          "Los enlaces son más grandes (15px)",
          "El badge se muestra más pequeño",
        ],
      },
    ],
  },
  {
    id: "a11y",
    title: "Accesibilidad (WCAG 2.1 AA)",
    icon: "♿",
    color: "#27ae60",
    groups: [
      {
        title: "ARIA",
        items: [
          "aria-haspopup=\"true\" está presente en triggers",
          "aria-expanded cambia entre 'true' y 'false'",
          "aria-controls apunta al ID correcto del panel",
          "role=\"region\" está en los paneles",
          "aria-label describe el panel",
          "aria-hidden cambia entre 'true' y 'false'",
          "El atributo hidden se añade/quita correctamente",
        ],
      },
      {
        title: "Screen Readers",
        items: [
          "NVDA anuncia el estado expandido/colapsado",
          "VoiceOver anuncia el estado expandido/colapsado",
          "JAWS anuncia el estado expandido/colapsado",
          "El contenido del panel es anunciado correctamente",
        ],
      },
      {
        title: "Contraste",
        items: [
          "El texto sobre el fondo tiene contraste AA (4.5:1)",
          "Los enlaces tienen contraste AA",
          "El badge tiene contraste AA",
        ],
      },
      {
        title: "Reduced Motion",
        items: [
          "Las animaciones se desactivan con prefers-reduced-motion",
          "Los transitions se desactivan",
          "El stagger de columnas se desactiva",
          "La funcionalidad básica sigue funcionando",
        ],
      },
      {
        title: "Tamaño de Objetivo",
        items: [
          "Los triggers tienen al menos 44x44px de área táctil",
          "Los enlaces del panel tienen al menos 44px de altura",
        ],
      },
    ],
  },
  {
    id: "perf",
    title: "Rendimiento",
    icon: "⚡",
    color: "#f39c12",
    groups: [
      {
        title: "Carga de Assets",
        items: [
          "megamenu.css solo se carga en páginas con mega menús",
          "megamenu.js solo se carga en páginas con mega menús",
          "Los tokens CSS se inyectan en <head>",
          "No hay requests innecesarios",
        ],
      },
      {
        title: "Tamaño",
        items: [
          "megamenu.js < 5 KB (comprimido con gzip)",
          "megamenu.css < 15 KB (comprimido con gzip)",
          "No hay dependencias externas",
        ],
      },
      {
        title: "Métricas Web",
        items: [
          "First Contentful Paint sin impacto",
          "Time to Interactive sin impacto",
          "Total Blocking Time < 50ms",
          "Cumulative Layout Shift = 0",
        ],
      },
      {
        title: "Optimizaciones",
        items: [
          "Las imágenes usan lazy loading",
          "Las animaciones usan transform/opacity (GPU)",
          "Intersection Observer se usa correctamente",
          "Los timers se limpian correctamente",
        ],
      },
    ],
  },
  {
    id: "security",
    title: "Seguridad",
    icon: "🔒",
    color: "#c0392b",
    groups: [
      {
        title: "Nonces",
        items: [
          "Nonce se genera en el metabox",
          "Nonce se verifica al guardar",
          "Nonce expira correctamente",
          "Guardado falla sin nonce válido",
        ],
      },
      {
        title: "Capability",
        items: [
          "Solo edit_theme_options puede configurar",
          "Solo edit_theme_options puede guardar ajustes",
          "Otros roles no pueden acceder a la configuración",
        ],
      },
      {
        title: "Sanitización y Escape",
        items: [
          "Texto se sanitiza con sanitize_text_field",
          "Números se sanitizan con absint",
          "Selects validan contra whitelist",
          "Toda salida HTML se escapa (esc_attr, esc_url, esc_html)",
        ],
      },
      {
        title: "SQL",
        items: [
          "No hay queries SQL sin preparar",
          "Se usa $wpdb->prepare cuando es necesario",
          "No hay inyección SQL posible",
        ],
      },
    ],
  },
  {
    id: "compat",
    title: "Compatibilidad",
    icon: "🔗",
    color: "#8e44ad",
    groups: [
      {
        title: "Con Divi",
        items: [
          "Funciona con Divi theme activo",
          "Funciona con Divi Builder plugin activo",
          "Los layouts se renderizan correctamente",
          "No hay conflictos con otros plugins",
        ],
      },
      {
        title: "Sin Divi",
        items: [
          "Funciona sin Divi instalado",
          "El modo columnas funciona correctamente",
          "Se muestra advertencia si se intenta usar layout Divi",
        ],
      },
      {
        title: "Navegadores",
        items: [
          "Chrome 80+ funciona correctamente",
          "Firefox 75+ funciona correctamente",
          "Safari 13+ funciona correctamente",
          "Edge 80+ funciona correctamente",
          "iOS Safari 13+ funciona correctamente",
          "Android Chrome 80+ funciona correctamente",
        ],
      },
      {
        title: "Temas Populares",
        items: [
          "Funciona con tema Divi",
          "Funciona con tema Astra",
          "Funciona con tema GeneratePress",
          "Funciona con tema OceanWP",
          "Funciona con tema Twenty Twenty-Four",
        ],
      },
      {
        title: "Versiones de WordPress",
        items: [
          "Funciona con WordPress 5.8",
          "Funciona con WordPress 6.0",
          "Funciona con WordPress 6.2",
          "Funciona con WordPress 6.4",
          "Funciona con WordPress 6.5+",
        ],
      },
    ],
  },
  {
    id: "edge",
    title: "Edge Cases",
    icon: "🧪",
    color: "#16a085",
    groups: [
      {
        title: "Casos Especiales",
        items: [
          "Múltiples mega menús en el mismo menú funcionan",
          "Cada mega menú funciona independientemente",
          "Un mega menú sin layout muestra mensaje",
          "Un mega menú sin sub-ítems muestra mensaje",
          "Layouts con mucho contenido se renderizan correctamente",
          "Las imágenes se cargan con lazy loading",
          "Los enlaces externos abren en nueva pestaña si target='_blank'",
        ],
      },
      {
        title: "Degradación Graceful",
        items: [
          "JavaScript deshabilitado: el menú sigue siendo navegable",
          "CSS deshabilitado: el menú sigue siendo funcional",
          "Zoom 125%: funciona correctamente",
          "Zoom 150%: funciona correctamente",
          "Zoom 200%: funciona correctamente",
          "Modo oscuro del sistema: funciona correctamente",
          "Modo de alto contraste: funciona correctamente",
          "Impresión: los paneles no se muestran",
        ],
      },
      {
        title: "API y Extensibilidad",
        items: [
          "TBMX_MegaMenu.open() funciona",
          "TBMX_MegaMenu.close() funciona",
          "TBMX_MegaMenu.closeAll() funciona",
          "TBMX_MegaMenu.getConfig() devuelve la configuración",
          "TBMX_MegaMenu.setConfig() actualiza la configuración",
          "Evento tbmx:init se dispara al inicializar",
          "Evento tbmx:open se dispara al abrir un panel",
          "Evento tbmx:close se dispara al cerrar un panel",
        ],
      },
    ],
  },
];

export const QA_TOTAL = QA_CATEGORIES.reduce(
  (acc, cat) => acc + cat.groups.reduce((a, g) => a + g.items.length, 0),
  0
);

export const QA_ACCEPTANCE = {
  pass: 95,
  conditional: 85,
};
