/* Contenido del Documento Maestro — Mega Menú para Divi (v0.1) */

export type PresetId = "oscuro" | "claro" | "minimal";

export const PRESET_META: Record<PresetId, { label: string; desc: string; swatches: string[] }> = {
  oscuro: {
    label: "Oscuro",
    desc: "El preset de TuboMax: fondo profundo, rojo de marca y borde sutil.",
    swatches: ["#050506", "#131318", "#f5f5f5", "#e11414", "rgba(255,255,255,.08)"],
  },
  claro: {
    label: "Claro",
    desc: "Papel frío con tinta densa; el rojo mantiene el peso de marca.",
    swatches: ["#f2f3f5", "#ffffff", "#101014", "#d40f0f", "rgba(16,16,20,.12)"],
  },
  minimal: {
    label: "Minimal",
    desc: "Gris plano, esquinas a 2px y acento en negro. Cero ruido.",
    swatches: ["#e8e8e6", "#f4f4f2", "#161616", "#161616", "rgba(22,22,22,.16)"],
  },
};

/* §1 — Decisión de arquitectura */
export const DECISION_ROWS = [
  {
    option: "Snippet CSS/JS en módulo Código",
    re: "No",
    ve: "No",
    ef: "Bajo",
    verdict: "Solo para un arreglo puntual",
    chosen: false,
  },
  {
    option: "Módulo/extensión nativa de Divi (Module API + React)",
    re: "Sí",
    ve: "Sí · marketplace Divi",
    ef: "Alto",
    verdict: "Potente, pero curva alta",
    chosen: false,
  },
  {
    option: "Plugin WP + layout de Divi como panel",
    re: "Sí",
    ve: "Sí",
    ef: "Medio",
    verdict: "Recomendado",
    chosen: true,
  },
];

/* §0 — Por qué esta vía */
export const REASONS = [
  { t: "Reutilizable (interno)", d: "Se instala en cualquier proyecto Divi de la agencia sin reescribir nada." },
  { t: "Vendible (producto)", d: "Un plugin es un activo con licencia; encaja en el mercado de add-ons de Divi." },
  { t: "Esfuerzo controlado", d: "No programas un editor: el panel se diseña con el propio Divi Builder y se asigna a un ítem de menú." },
  { t: "Diferenciador claro", d: "«Usa cualquier diseño de Divi como panel de tu menú». Nadie lo ofrece así." },
];

/* §3 — Alcance por fases */
export const PHASES = [
  {
    tag: "MVP · v0.1",
    name: "Lo mínimo que ya aporta valor",
    badge: "AHORA",
    items: [
      "Metabox en cada ítem de menú: activar mega panel + elegir layout de la Biblioteca de Divi.",
      "Render en front: hover / focus / click despliega el panel a ancho completo bajo la barra.",
      "Estilo base con tokens CSS editables (colores, tipografía, sombras).",
      "Responsive: en móvil el panel colapsa en acordeón.",
      "Accesibilidad base: teclado + ARIA.",
    ],
  },
  {
    tag: "v1.0",
    name: "Producto vendible",
    badge: null,
    items: [
      "Panel de ajustes global: colores, ancho full/contenido, animación, hover-intent, breakpoint.",
      "Ajustes por ítem: ancho, alineación, icono, badge («Nuevo», «Oferta»).",
      "Modo columnas sin Divi: sublinks + bloque destacado para sitios sin Biblioteca.",
      "Presets de estilo: Oscuro, Claro, Minimal.",
      "Internacionalización (i18n) y textos traducibles.",
    ],
  },
  {
    tag: "v2.0",
    name: "Diferenciación",
    badge: null,
    items: [
      "Constructor de columnas propio (drag & drop) como alternativa a Divi.",
      "Disparadores por tabs dentro del panel.",
      "Integración con WooCommerce: categorías y productos en el panel.",
      "Condicionales por rol, página o idioma.",
      "Analítica de clics en el menú.",
    ],
  },
];

/* §4.1 — Stack */
export const STACK = [
  { t: "PHP 8.x", d: "APIs nativas de WP, sin framework" },
  { t: "JS vanilla", d: "Cero dependencias · objetivo < 5 KB" },
  { t: "CSS custom properties", d: "Theming por tokens sin recompilar" },
  { t: "Build opcional", d: "esbuild/rollup solo si crece; MVP en archivos planos" },
];

/* §4.2 — Estructura de archivos */
export const FILE_TREE: { name: string; depth: number; kind: "dir" | "php" | "css" | "js" | "txt"; desc: string }[] = [
  { name: "tbmx-megamenu/", depth: 0, kind: "dir", desc: "Raíz del plugin — el nombre de carpeta define el slug." },
  { name: "tbmx-megamenu.php", depth: 1, kind: "php", desc: "Cabecera del plugin + bootstrap. Punto de activación en WP." },
  { name: "uninstall.php", depth: 1, kind: "php", desc: "Limpieza de opciones y metas al desinstalar." },
  { name: "includes/", depth: 1, kind: "dir", desc: "Clases PHP del plugin (autoload simple)." },
  { name: "class-plugin.php", depth: 2, kind: "php", desc: "Singleton / orquestador: registra todos los hooks." },
  { name: "class-menu-fields.php", depth: 2, kind: "php", desc: "Metabox en ítems de menú (admin): activar panel + selector de layout." },
  { name: "class-menu-walker.php", depth: 2, kind: "php", desc: "Custom Nav_Menu Walker: inyecta el panel y los atributos ARIA." },
  { name: "class-settings.php", depth: 2, kind: "php", desc: "Página de ajustes globales vía Settings API." },
  { name: "class-assets.php", depth: 2, kind: "php", desc: "Enqueue condicional de CSS/JS + tokens inline en :root." },
  { name: "class-renderer.php", depth: 2, kind: "php", desc: "Render del panel: layout de Divi o modo columnas." },
  { name: "assets/", depth: 1, kind: "dir", desc: "Recursos estáticos del front y del admin." },
  { name: "css/megamenu.css", depth: 2, kind: "css", desc: "Estilos front — consume var(--tbmx-*) en todo." },
  { name: "css/admin.css", depth: 2, kind: "css", desc: "Estilos del metabox y la página de ajustes." },
  { name: "js/megamenu.js", depth: 2, kind: "js", desc: "Hover-intent, teclado, ARIA y acordeón móvil. Vanilla, < 5 KB." },
  { name: "js/admin.js", depth: 2, kind: "js", desc: "UX del metabox (mostrar/ocultar campos según origen)." },
  { name: "languages/", depth: 1, kind: "dir", desc: ".pot y traducciones (i18n desde v1.0)." },
  { name: "readme.txt", depth: 1, kind: "txt", desc: "Formato oficial del repositorio de plugins de WordPress." },
];

/* §4.3 — Modelo de datos */
export const META_KEYS = [
  { key: "_tbmx_enabled", type: "bool", desc: "Activar mega panel en este ítem" },
  { key: "_tbmx_source", type: "divi_layout | columns", desc: "Origen del contenido del panel" },
  { key: "_tbmx_layout_id", type: "int", desc: "ID del layout de la Biblioteca Divi (CPT et_pb_layout)" },
  { key: "_tbmx_width", type: "full | container | custom", desc: "Ancho del panel · combina con _tbmx_width_px" },
  { key: "_tbmx_align", type: "left | center | right", desc: "Alineación del panel respecto al ítem" },
  { key: "_tbmx_icon", type: "string", desc: "Clase de icono o SVG para el ítem" },
  { key: "_tbmx_badge", type: "string", desc: "Etiqueta opcional: «Nuevo», «Oferta»…" },
];

/* §4.4 — Integración */
export const INTEGRATION = [
  { t: "WP Menús", d: "wp_nav_menu + Walker personalizado que inyecta panel y ARIA en ítems con _tbmx_enabled." },
  { t: "Contenido Divi", d: "Layouts del CPT et_pb_layout renderizados con do_shortcode; Divi carga sus propios estilos." },
  { t: "Fallback sin Divi", d: "Si source = columns (o Divi no está activo), render propio de columnas + bloque destacado." },
];

/* §4.5 — Pipeline de render */
export const PIPELINE = [
  { t: "Enqueue condicional", d: "class-assets carga megamenu.css + megamenu.js solo si el menú activo tiene ítems con megamenú." },
  { t: "Tokens inline", d: "Los ajustes globales se inyectan como :root { --tbmx-* } para theming sin recompilar." },
  { t: "Walker + markup", d: "El <li> se marca con data-tbmx=\"mega\" y se renderiza <div class=\"tbmx-panel\" role=\"region\" hidden>." },
  { t: "JS de estado", d: "Apertura/cierre por hover-intent, click y teclado; sincroniza aria-expanded y el foco." },
];

/* §5.2 — Tokens visuales (defaults de la agencia) */
export const TOKENS_COLOR = [
  { v: "--tbmx-bg", val: "#050506", desc: "Fondo del panel", swatch: "#050506" },
  { v: "--tbmx-fg", val: "#f5f5f5", desc: "Texto principal", swatch: "#f5f5f5" },
  { v: "--tbmx-muted", val: "rgba(245,245,245,.6)", desc: "Texto secundario", swatch: "#9c9c9c" },
  { v: "--tbmx-accent", val: "#e11414", desc: "Rojo de marca", swatch: "#e11414" },
  { v: "--tbmx-border", val: "rgba(255,255,255,.08)", desc: "Bordes y separadores", swatch: "#2a2a2e" },
];
export const TOKENS_MISC = [
  { v: "--tbmx-radius", val: "10px", desc: "Radio base" },
  { v: "--tbmx-shadow", val: "0 24px 60px rgba(0,0,0,.5)", desc: "Sombra del panel" },
  { v: "--tbmx-font", val: "\"Montserrat\", system-ui", desc: "Tipografía del panel" },
  { v: "--tbmx-gap", val: "clamp(16px, 2vw, 32px)", desc: "Ritmo espacial fluido" },
  { v: "--tbmx-anim", val: ".22s cubic-bezier(.22,.61,.36,1)", desc: "Curva de animación" },
];

/* §5.3 — Interacción */
export const INTERACTION = [
  { k: "Entrada", v: "120 ms", d: "Retardo al entrar antes de abrir: el roce no dispara el panel." },
  { k: "Salida", v: "200 ms", d: "Margen para cruzar al panel sin que se cierre de golpe." },
  { k: "Animación", v: "fade + 6–10 px", d: "translateY sutil con la curva cubic-bezier(.22,.61,.36,1)." },
  { k: "Regla de oro", v: "1 panel", d: "Un solo panel abierto a la vez; reduced-motion anula el movimiento." },
];

/* §6 — Teclado */
export const KEYBOARD = [
  { k: "Enter / Espacio", d: "Abre o cierra el panel del ítem con foco" },
  { k: "Esc", d: "Cierra el panel y devuelve el foco al ítem padre" },
  { k: "Tab", d: "Recorre los enlaces del panel; nunca atrapa el foco" },
  { k: "← ↑ → ↓", d: "Navegación opcional entre ítems del menú" },
];

export const A11Y_POINTS = [
  "Patrón disclosure/menu de WAI-ARIA: aria-haspopup, aria-expanded y aria-controls en el padre.",
  "Panel con role=\"region\" + aria-label y atributo hidden cuando está cerrado.",
  "Foco visible (:focus-visible) en todos los enlaces; contraste AA mínimo.",
  "Enlaces con texto descriptivo — nunca solo iconos.",
];

/* §7 / §8 */
export const PERF_POINTS = [
  "Assets solo cuando hay megamenú en uso — cero peso global.",
  "Sin librerías externas; JS vanilla < 5 KB en el MVP.",
  "Imágenes del destacado con loading=\"lazy\" y tamaños correctos.",
  "La cabecera nunca se bloquea: JS con defer al final.",
];
export const SECURITY_POINTS = [
  "sanitize_text_field, absint y wp_kses en toda entrada del metabox.",
  "Nonces en el guardado del metabox y de los ajustes globales.",
  "Solo el capability edit_theme_options puede configurar.",
  "Degradación elegante si Divi no está activo: modo columnas.",
];

/* §9 — QA */
export const QA_ITEMS = [
  "Escritorio: hover, clic, teclado, cierre por Esc y por clic fuera.",
  "Móvil/táctil: acordeón, sin paneles «pegados».",
  "Varios ítems con megamenú en el mismo menú.",
  "Ítem con y sin layout asignado (fallback).",
  "prefers-reduced-motion activo.",
  "Lectores de pantalla (NVDA / VoiceOver): anuncia expandido/colapsado.",
  "Sin Divi activo (modo columnas).",
  "Rendimiento: los assets no cargan en páginas sin megamenú.",
  "i18n: todas las cadenas traducibles.",
];

/* §10 — Roadmap */
export const ROADMAP = [
  {
    fase: "Fase 0 · Andamiaje",
    items: [
      "Estructura de archivos + cabecera del plugin",
      "Bootstrap de clases (autoload simple) y hooks base",
      "readme.txt y versión",
    ],
  },
  {
    fase: "Fase 1 · Admin (metabox)",
    items: [
      "Metabox en ítems de menú: activar + selector de layout Divi",
      "Guardado seguro (nonce + sanitizado)",
      "Ajustes globales (tokens/colores, ancho, breakpoint)",
    ],
  },
  {
    fase: "Fase 2 · Front (render)",
    items: [
      "Walker personalizado + markup del panel + ARIA",
      "Render de layout Divi dentro del panel",
      "Enqueue condicional + tokens inline",
    ],
  },
  {
    fase: "Fase 3 · Interacción ✓",
    items: [
      "JS: hover-intent, clic, teclado, cierre",
      "Animaciones + prefers-reduced-motion",
      "Acordeón móvil",
      "Hover progress indicator",
      "Staggered column animations",
      "Scroll lock (mobile)",
      "Lazy loading de imágenes",
      "Intersection Observer",
      "Touch support mejorado",
      "Focus trap (opcional)",
      "Navegación entre siblings",
      "Custom events & API pública",
    ],
  },
  {
    fase: "Fase 4 · Pulido / producto",
    items: [
      "QA exhaustivo con Divi activo",
      "Testing de accesibilidad (NVDA, VoiceOver)",
      "Testing responsive en múltiples dispositivos",
      "Documentación de usuario final",
      "Optimización de rendimiento",
      "Preparación para distribución",
    ],
  },
];

/* §11 — Prompts */
export const CLAUDE_MD = `# Proyecto: Mega Menú para Divi (plugin WordPress)

## Objetivo
Plugin WP que convierte menús nativos de WP en mega menús con estética Divi.
El contenido de cada panel es un layout de la Biblioteca de Divi (CPT et_pb_layout).
Reutilizable y vendible. Sin dependencias JS externas. Accesible (WAI-ARIA).

## Reglas
- PHP 8, APIs nativas de WP. Prefijo tbmx_ / _tbmx_ y namespace propio.
- JS vanilla, < 5 KB en MVP. CSS con variables (custom properties).
- Sanitizar/escapar todo. Nonces. Capability edit_theme_options.
- Enqueue condicional (solo si el menú usa megamenú).
- Accesibilidad obligatoria: aria-haspopup/expanded/controls, Esc, foco visible.
- Respetar prefers-reduced-motion.
- Código en inglés; comentarios y textos de usuario traducibles (i18n).

## Estructura
(ver "Estructura de archivos" del documento maestro)

## Estilo de trabajo
- Entregables completos por archivo, listos para probar.
- Cambios mínimos y acotados a la tarea pedida.
- Al terminar cada fase, dejar checklist de QA de esa fase.`;

export const PHASE_PROMPTS: { title: string; prompt: string }[] = [
  {
    title: "Andamiaje",
    prompt:
      "Crea el andamiaje del plugin según CLAUDE.md: cabecera del plugin, uninstall.php, class-plugin.php (singleton que registra hooks), y stubs vacíos de las clases de includes/. Sin lógica todavía; solo estructura compilable y activable en WP.",
  },
  {
    title: "Metabox",
    prompt:
      "Implementa class-menu-fields: añade a cada ítem de menú (nav_menu_item) los campos _tbmx_enabled y _tbmx_layout_id (selector de layouts et_pb_layout). Guardado con nonce y sanitizado. Añade assets/admin.css/js si hacen falta.",
  },
  {
    title: "Ajustes globales",
    prompt:
      "Implementa class-settings con la Settings API: opción tbmx_megamenu_settings con tokens de color, tipografía, ancho (full/container) y breakpoint. Página bajo Apariencia.",
  },
  {
    title: "Walker + render",
    prompt:
      "Implementa class-menu-walker y class-renderer: para ítems con _tbmx_enabled, renderiza el panel con role=region, hidden, aria-*, e inserta el contenido del layout Divi. Documenta cómo procesas el layout.",
  },
  {
    title: "Assets condicionales",
    prompt:
      "Implementa class-assets: enqueue de megamenu.css/js solo si el menú activo tiene ítems con megamenú, e inyecta los tokens como CSS inline en :root.",
  },
  {
    title: "JS de interacción",
    prompt:
      "Escribe assets/js/megamenu.js (vanilla): hover-intent (120/200ms), apertura por clic y teclado, cierre con Esc y clic fuera, gestión de aria-expanded, y acordeón bajo el breakpoint. Respeta prefers-reduced-motion.",
  },
  {
    title: "CSS front",
    prompt:
      "Escribe assets/css/megamenu.css usando las variables --tbmx-* (preset oscuro). Panel a sangre o contenedor, columnas responsivas, foco visible, animación sutil.",
  },
  {
    title: "QA",
    prompt: "Revisa contra el checklist de QA del documento maestro y lista problemas + arreglos.",
  },
];

/* §12 — Distribución */
export const TIERS = [
  { name: "1 sitio", ideal: "Freelancers y proyectos personales", note: "Licencia anual · updates + soporte" },
  { name: "5 sitios", ideal: "Estudios pequeños", note: "Licencia anual · updates + soporte" },
  { name: "Agencia", ideal: "Equipos con proyectos ilimitados", note: "Sitios ilimitados · soporte prioritario", recommended: true },
];

export const CHANNELS = [
  { t: "Venta propia", d: "Freemius o EDD gestionan licencias, actualizaciones y renovaciones." },
  { t: "Lite en el repositorio WP", d: "Versión gratuita como captación; el Pro desbloquea presets y ajustes por ítem." },
  { t: "Marca de la agencia", d: "Documentación propia + demo en vídeo; changelog y términos públicos." },
];

/* §13 — Nombres */
export const NAME_IDEAS = [
  { name: "MegaDivi", kind: "Genérico" },
  { name: "Divi Mega Panels", kind: "Genérico" },
  { name: "MenuForge", kind: "Genérico" },
  { name: "PanelDivi", kind: "Genérico" },
  { name: "NB Mega Menu", kind: "Con marca" },
  { name: "[Agencia] MegaMenu", kind: "Con marca" },
];

export const PENDING = [
  "Nombre definitivo del plugin.",
  "¿Versión lite gratuita, sí o no?",
  "Sistema de licencias: ¿Freemius o EDD?",
  "Breakpoint móvil por defecto (¿980px?).",
  "¿Modo columnas ya en el MVP o se deja para v1?",
];

export const TICKER_ITEMS = [
  "_tbmx_enabled",
  "et_pb_layout",
  "aria-expanded",
  "hover-intent 120/200ms",
  "JS < 5 KB",
  "edit_theme_options",
  "prefers-reduced-motion",
  "Walker personalizado",
  "do_shortcode",
  "Settings API",
  "acordeón < 980px",
  "role=\"region\"",
  "tbmx_megamenu_settings",
  "un solo panel a la vez",
];
