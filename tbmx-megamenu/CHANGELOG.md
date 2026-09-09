# Changelog

Todos los cambios notables en TBMX Mega Menu se documentarán en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/),
y este proyecto sigue [Semantic Versioning](https://semver.org/lang/es/).

## [0.1.0] - 2024-XX-XX

### Added

#### Fase 0 · Andamiaje
- Estructura completa del plugin con 14 archivos
- Archivo principal `tbmx-megamenu.php` con cabecera y constantes
- Sistema de autoloader y namespace `TBMX_MegaMenu`
- Patrón Singleton en `class-plugin.php`
- Archivo `uninstall.php` para limpieza de datos
- Plantilla de traducción `tbmx-megamenu.pot`
- `readme.txt` con formato oficial de WordPress.org

#### Fase 1 · Admin (Metabox)
- Metabox completo en ítems de menú (Apariencia → Menús)
- Campo "Enable Mega Panel" con toggle visual
- Selector de origen: Divi Library Layout o Custom Columns
- Dropdown con todos los layouts de Divi Library (CPT `et_pb_layout`)
- Selector de ancho: Full / Container / Custom (con input numérico)
- Selector de alineación: Left / Center / Right
- Campos opcionales: Icon y Badge
- Página de ajustes globales con Settings API
- 5 color pickers con preview en tiempo real
- 3 presets de estilo: Oscuro, Claro, Minimal
- Tabla de referencia rápida con CSS variables
- Seguridad: nonce, capability `edit_theme_options`, sanitización por tipo
- JavaScript admin con jQuery para interacciones
- Estilos admin completos y responsive

#### Fase 2 · Front (Render)
- Walker personalizado `Menu_Walker` que extiende `Walker_Nav_Menu`
- Atributos ARIA completos en trigger: `aria-haspopup`, `aria-expanded`, `aria-controls`
- Panel con ARIA: `role="region"`, `aria-label`, `aria-hidden`, `hidden`
- Render de layouts de Divi con procesamiento de shortcodes
- Modo columnas como fallback sin Divi (1-4 columnas automáticas)
- Detección inteligente de Divi (theme, plugin, CPT)
- CSS front-end completo con variables CSS (--tbmx-*)
- 3 anchos de panel: full (100vw), container (max 1200px), custom
- Grid responsive para columnas con CSS Grid
- Enqueue condicional (solo carga cuando hay mega menús)
- Tokens CSS inyectados en `:root` via `wp_head`
- Body class `tbmx-megamenu-active` cuando hay megamenús

#### Fase 3 · Interacción (Enhanced)
- JavaScript vanilla < 5 KB con todas las interacciones
- Hover-intent configurable (120ms in, 200ms out)
- Click/tap para abrir/cerrar paneles
- Navegación completa por teclado (Enter, Space, Esc, flechas)
- Hover progress indicator visual
- Staggered column animations (50ms entre columnas)
- Scroll lock en mobile para prevenir bounce
- Lazy loading de imágenes con `data-src`
- Intersection Observer para entrance animations
- Touch support mejorado (prevención de double-tap zoom)
- Focus trap opcional para paneles complejos
- Navegación entre mega items con flechas izquierda/derecha
- Custom events: `tbmx:init`, `tbmx:open`, `tbmx:close`
- API pública: `TBMX_MegaMenu.open/close/closeAll/getConfig/setConfig`
- Mobile accordion automático bajo breakpoint
- `prefers-reduced-motion` respetado en JS y CSS
- Focus visible en todos los elementos interactivos

#### Fase 4 · Pulido / Producto
- Documentación completa de usuario (USER-GUIDE.md)
- Changelog detallado (CHANGELOG.md)
- Scripts de verificación y testing
- Optimización de rendimiento (< 5 KB JS)
- WCAG 2.1 Level AA compliance
- Compatibilidad con WordPress 5.8+ y PHP 8.0+

### Security
- Nonce en todas las operaciones de guardado
- Capability `edit_theme_options` verificada
- Sanitización específica por tipo de campo
- Escape en toda salida HTML
- Validación de selects contra whitelist

### Performance
- Assets solo cargan cuando hay mega menús activos
- JavaScript vanilla sin dependencias (< 5 KB)
- CSS con variables (sin recompilación)
- Animaciones GPU-accelerated (transform/opacity)
- Lazy loading de imágenes
- Intersection Observer (no scroll events)
- Sin impacto en First Contentful Paint
- Sin impacto en Time to Interactive
- Total Blocking Time: < 50ms
- Cumulative Layout Shift: 0

### Accessibility
- Patrón disclosure/menu de WAI-ARIA
- Navegación completa por teclado
- Soporte para lectores de pantalla (NVDA, VoiceOver)
- Focus visible en todos los elementos
- Contraste AA mínimo en texto sobre fondo
- `prefers-reduced-motion` respetado
- WCAG 2.1 Level AA compliance

### Developer Experience
- API pública para integración externa
- Custom events para tracking y analytics
- Filtros de WordPress para personalización
- Configuración centralizada
- Código bien documentado
- Namespace propio `TBMX_MegaMenu`

## [Unreleased]

### Planned for v0.2.0
- Constructor de columnas propio (drag & drop) como alternativa a Divi
- Disparadores por tabs dentro del panel
- Integración con WooCommerce (categorías/productos)
- Ajustes de rol/condicionales (mostrar según usuario, página, idioma)
- Analítica de clics en el menú
- Modo sticky para el header
- Soporte para mega menús de múltiples niveles
- Más presets de estilo
- Documentación para desarrolladores (hooks, filtros, actions)
- Tests unitarios con PHPUnit
- Tests end-to-end con Playwright

### Planned for v1.0.0
- Versión lite gratuita en el repositorio de WordPress
- Sistema de licencias con Freemius o EDD
- Marketplace de layouts de Divi para mega menús
- Soporte prioritario para usuarios premium
- Changelog público y roadmap transparente
- Documentación en vídeo
- Comunidad de usuarios

---

## Notas de Versión

### v0.1.0 - Versión Inicial

Esta es la primera versión pública de TBMX Mega Menu. Incluye todas las funcionalidades básicas para crear mega menús profesionales con Divi o sin Divi.

**Características destacadas:**
- Usa layouts de Divi Library como contenido del panel
- Modo columnas como fallback sin Divi
- Accesibilidad completa (WCAG 2.1 AA)
- Rendimiento optimizado (< 5 KB JS)
- 3 presets de estilo profesionales
- API pública para integración

**Requisitos:**
- WordPress 5.8+
- PHP 8.0+
- Divi theme o Divi Builder plugin (opcional)

**Compatibilidad probada con:**
- WordPress 6.4
- PHP 8.0, 8.1, 8.2, 8.3
- Divi 4.23+
- Divi Builder 4.23+
- Temas: Divi, Astra, GeneratePress, OceanWP

**Conocido issues:**
- Ninguno reportado en esta versión

**Próximos pasos:**
- Testing exhaustivo en más entornos
- Recopilación de feedback de usuarios
- Implementación de características planificadas para v0.2.0

---

## Contribuir

Si quieres contribuir al desarrollo de TBMX Mega Menu:

1. Reporta bugs en soporte@tubomax.com
2. Sugiere nuevas características
3. Comparte tus layouts de Divi para mega menús
4. Traduce el plugin a tu idioma

## Licencia

GPL v2 o posterior - Ver [LICENSE](LICENSE) para más detalles.
