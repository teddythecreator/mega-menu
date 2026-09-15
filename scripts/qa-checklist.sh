#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# qa-checklist.sh
# QA exhaustivo del plugin TBMX Mega Menu
#
# Uso:
#   ./scripts/qa-checklist.sh
#
# Verifica:
# - Accesibilidad (WCAG 2.1 AA)
# - Rendimiento
# - Seguridad
# - Compatibilidad
# - Documentación
# - Preparación para distribución
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

PLUGIN_DIR="tcb-megamenu"

# Colores
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; BLUE='\033[0;34m'; NC='\033[0m'
pass() { echo -e "${GREEN}✓${NC} $*"; }
fail() { echo -e "${RED}✗${NC} $*"; }
warn() { echo -e "${YELLOW}!${NC} $*"; }
section() { echo -e "\n${BLUE}═══ $* ═══${NC}"; }

PASS=0
FAIL=0
WARN=0

check() {
    if [[ $1 == "true" ]]; then
        pass "$2"
        PASS=$((PASS + 1))
    else
        fail "$2"
        FAIL=$((FAIL + 1))
    fi
}

# ── 1. ACCESIBILIDAD (WCAG 2.1 AA) ──
section "Accesibilidad (WCAG 2.1 AA)"

# 1.1 ARIA attributes
ARIA_HASPOP=$(grep -c "aria-haspopup" "$PLUGIN_DIR/includes/class-menu-walker.php" || true)
check "$([ $ARIA_HASPOP -gt 0 ] && echo true || echo false)" "aria-haspopup presente en walker"

ARIA_EXPANDED=$(grep -c "aria-expanded" "$PLUGIN_DIR/includes/class-menu-walker.php" || true)
check "$([ $ARIA_EXPANDED -gt 0 ] && echo true || echo false)" "aria-expanded presente en walker"

ARIA_CONTROLS=$(grep -c "aria-controls" "$PLUGIN_DIR/includes/class-menu-walker.php" || true)
check "$([ $ARIA_CONTROLS -gt 0 ] && echo true || echo false)" "aria-controls presente en walker"

ARIA_HIDDEN=$(grep -c "aria-hidden" "$PLUGIN_DIR/includes/class-menu-walker.php" || true)
check "$([ $ARIA_HIDDEN -gt 0 ] && echo true || echo false)" "aria-hidden presente en walker"

ROLE_REGION=$(grep -c 'role="region"' "$PLUGIN_DIR/includes/class-menu-walker.php" || true)
check "$([ $ROLE_REGION -gt 0 ] && echo true || echo false)" "role=\"region\" presente en panel"

# 1.2 Keyboard navigation
KEYBOARD_ENTER=$(grep -c "Enter" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $KEYBOARD_ENTER -gt 0 ] && echo true || echo false)" "Navegación con Enter implementada"

KEYBOARD_ESC=$(grep -c "Escape" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $KEYBOARD_ESC -gt 0 ] && echo true || echo false)" "Navegación con Escape implementada"

KEYBOARD_ARROWS=$(grep -c "ArrowDown\|ArrowUp\|ArrowLeft\|ArrowRight" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $KEYBOARD_ARROWS -gt 0 ] && echo true || echo false)" "Navegación con flechas implementada"

# 1.3 Focus management
FOCUS_VISIBLE=$(grep -c "focus-visible" "$PLUGIN_DIR/assets/css/megamenu.css" || true)
check "$([ $FOCUS_VISIBLE -gt 0 ] && echo true || echo false)" "Focus visible implementado en CSS"

FOCUS_JS=$(grep -c "\.focus()" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $FOCUS_JS -gt 0 ] && echo true || echo false)" "Focus management implementado en JS"

# 1.4 Reduced motion
REDUCED_MOTION_CSS=$(grep -c "prefers-reduced-motion" "$PLUGIN_DIR/assets/css/megamenu.css" || true)
check "$([ $REDUCED_MOTION_CSS -gt 0 ] && echo true || echo false)" "Reduced motion respetado en CSS"

REDUCED_MOTION_JS=$(grep -c "prefers-reduced-motion" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $REDUCED_MOTION_JS -gt 0 ] && echo true || echo false)" "Reduced motion respetado en JS"

# 1.5 Mobile accessibility
MOBILE_ACCORDION=$(grep -c "isMobile" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $MOBILE_ACCORDION -gt 0 ] && echo true || echo false)" "Modo móvil (acordeón) implementado"

# ── 2. RENDIMIENTO ──
section "Rendimiento"

# 2.1 Tamaño del JavaScript
JS_SIZE=$(wc -c < "$PLUGIN_DIR/assets/js/megamenu.js")
check "$([ $JS_SIZE -lt 5120 ] && echo true || echo false)" "JavaScript < 5 KB (actual: $JS_SIZE bytes)"

# 2.2 Sin dependencias externas
JQUERY_DEP=$(grep -c "jquery" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $JQUERY_DEP -eq 0 ] && echo true || echo false)" "JavaScript sin dependencias externas"

# 2.3 Enqueue condicional
CONDITIONAL_ENQUEUE=$(grep -c "any_menu_has_mega_items" "$PLUGIN_DIR/includes/class-assets.php" || true)
check "$([ $CONDITIONAL_ENQUEUE -gt 0 ] && echo true || echo false)" "Enqueue condicional implementado"

# 2.4 CSS variables
CSS_VARS=$(grep -c "\-\-tbmx-" "$PLUGIN_DIR/assets/css/megamenu.css" || true)
check "$([ $CSS_VARS -gt 10 ] && echo true || echo false)" "CSS variables para theming ($CSS_VARS variables)"

# 2.5 Lazy loading
LAZY_LOAD=$(grep -c "lazyLoadImages\|data-src" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $LAZY_LOAD -gt 0 ] && echo true || echo false)" "Lazy loading de imágenes implementado"

# 2.6 Intersection Observer
INTERSECTION_OBS=$(grep -c "IntersectionObserver" "$PLUGIN_DIR/assets/js/megamenu.js" || true)
check "$([ $INTERSECTION_OBS -gt 0 ] && echo true || echo false)" "Intersection Observer implementado"

# 2.7 GPU-accelerated animations
GPU_ANIM=$(grep -c "transform\|opacity" "$PLUGIN_DIR/assets/css/megamenu.css" || true)
check "$([ $GPU_ANIM -gt 5 ] && echo true || echo false)" "Animaciones GPU-accelerated"

# ── 3. SEGURIDAD ──
section "Seguridad"

# 3.1 Nonces
NONCE_RENDER=$(grep -c "wp_nonce_field" "$PLUGIN_DIR/includes/class-menu-fields.php" || true)
check "$([ $NONCE_RENDER -gt 0 ] && echo true || echo false)" "Nonce field en metabox"

NONCE_VERIFY=$(grep -c "wp_verify_nonce" "$PLUGIN_DIR/includes/class-menu-fields.php" || true)
check "$([ $NONCE_VERIFY -gt 0 ] && echo true || echo false)" "Verificación de nonce en guardado"

# 3.2 Capability checks
CAP_CHECK=$(grep -c "edit_theme_options" "$PLUGIN_DIR/includes/class-menu-fields.php" || true)
check "$([ $CAP_CHECK -gt 0 ] && echo true || echo false)" "Capability check en guardado"

# 3.3 Sanitization
SANITIZE_TEXT=$(grep -c "sanitize_text_field" "$PLUGIN_DIR/includes/class-menu-fields.php" || true)
check "$([ $SANITIZE_TEXT -gt 0 ] && echo true || echo false)" "Sanitización de texto"

SANITIZE_INT=$(grep -c "absint" "$PLUGIN_DIR/includes/class-menu-fields.php" || true)
check "$([ $SANITIZE_INT -gt 0 ] && echo true || echo false)" "Sanitización de enteros"

# 3.4 Escaping
ESCAPE_HTML=$(grep -c "esc_html\|esc_attr\|esc_url" "$PLUGIN_DIR/includes/class-menu-walker.php" || true)
check "$([ $ESCAPE_HTML -gt 5 ] && echo true || echo false)" "Escape de salida HTML"

# 3.5 Uninstall cleanup
UNINSTALL=$(grep -c "delete_option\|DELETE FROM" "$PLUGIN_DIR/uninstall.php" || true)
check "$([ $UNINSTALL -gt 0 ] && echo true || echo false)" "Limpieza en desinstalación"

# ── 4. COMPATIBILIDAD ──
section "Compatibilidad"

# 4.1 WordPress version
WP_VERSION=$(grep "Requires at least:" "$PLUGIN_DIR/tcb-megamenu.php" | awk '{print $4}')
check "$([ -n "$WP_VERSION" ] && echo true || echo false)" "Versión mínima de WordPress definida ($WP_VERSION)"

# 4.2 PHP version
PHP_VERSION=$(grep "Requires PHP:" "$PLUGIN_DIR/tcb-megamenu.php" | awk '{print $4}')
check "$([ -n "$PHP_VERSION" ] && echo true || echo false)" "Versión mínima de PHP definida ($PHP_VERSION)"

# 4.3 Text domain
TEXT_DOMAIN=$(grep "Text Domain:" "$PLUGIN_DIR/tcb-megamenu.php" | awk '{print $3}')
check "$([ "$TEXT_DOMAIN" = "tcb-megamenu" ] && echo true || echo false)" "Text domain correcto"

# 4.4 Translation ready
POT_FILE="$PLUGIN_DIR/languages/tcb-megamenu.pot"
check "$([ -f "$POT_FILE" ] && echo true || echo false)" "Archivo POT para traducciones"

# 4.5 Divi detection
DIVI_DETECT=$(grep -c "is_divi_active" "$PLUGIN_DIR/includes/class-renderer.php" || true)
check "$([ $DIVI_DETECT -gt 0 ] && echo true || echo false)" "Detección de Divi implementada"

# 4.6 Fallback sin Divi
FALLBACK=$(grep -c "render_columns" "$PLUGIN_DIR/includes/class-renderer.php" || true)
check "$([ $FALLBACK -gt 0 ] && echo true || echo false)" "Fallback sin Divi implementado"

# ── 5. DOCUMENTACIÓN ──
section "Documentación"

# 5.1 README
check "$([ -f "$PLUGIN_DIR/readme.txt" ] && echo true || echo false)" "readme.txt presente"

# 5.2 User guide
check "$([ -f "$PLUGIN_DIR/USER-GUIDE.md" ] && echo true || echo false)" "Guía de usuario presente"

# 5.3 Changelog
check "$([ -f "$PLUGIN_DIR/CHANGELOG.md" ] && echo true || echo false)" "Changelog presente"

# 5.4 License
check "$([ -f "$PLUGIN_DIR/LICENSE" ] && echo true || echo false)" "Archivo LICENSE presente"

# 5.5 Documentation quality
README_LINES=$(wc -l < "$PLUGIN_DIR/readme.txt")
check "$([ $README_LINES -gt 50 ] && echo true || echo false)" "readme.txt con contenido suficiente ($README_LINES líneas)"

# ── 6. PREPARACIÓN PARA DISTRIBUCIÓN ──
section "Preparación para Distribución"

# 6.1 Plugin header
PLUGIN_NAME=$(grep "Plugin Name:" "$PLUGIN_DIR/tcb-megamenu.php" | cut -d: -f2 | xargs)
check "$([ -n "$PLUGIN_NAME" ] && echo true || echo false)" "Plugin Name en cabecera"

PLUGIN_VERSION=$(grep "Version:" "$PLUGIN_DIR/tcb-megamenu.php" | awk '{print $2}')
check "$([ -n "$PLUGIN_VERSION" ] && echo true || echo false)" "Version en cabecera"

PLUGIN_DESC=$(grep "Description:" "$PLUGIN_DIR/tcb-megamenu.php" | cut -d: -f2 | xargs)
check "$([ -n "$PLUGIN_DESC" ] && echo true || echo false)" "Description en cabecera"

PLUGIN_AUTHOR=$(grep "Author:" "$PLUGIN_DIR/tcb-megamenu.php" | cut -d: -f2 | xargs)
check "$([ -n "$PLUGIN_AUTHOR" ] && echo true || echo false)" "Author en cabecera"

PLUGIN_LICENSE=$(grep "License:" "$PLUGIN_DIR/tcb-megamenu.php" | cut -d: -f2 | xargs)
check "$([ -n "$PLUGIN_LICENSE" ] && echo true || echo false)" "License en cabecera"

# 6.2 No debug code
DEBUG_CODE=$(grep -r "var_dump\|print_r\|error_log" "$PLUGIN_DIR/includes" "$PLUGIN_DIR/assets" 2>/dev/null | wc -l || true)
check "$([ $DEBUG_CODE -eq 0 ] && echo true || echo false)" "Sin código de debug"

# 6.3 No hardcoded URLs
HARDCODED_URLS=$(grep -r "localhost\|127.0.0.1\|example.com" "$PLUGIN_DIR/includes" "$PLUGIN_DIR/assets" 2>/dev/null | wc -l || true)
check "$([ $HARDCODED_URLS -eq 0 ] && echo true || echo false)" "Sin URLs hardcodeadas"

# 6.4 File structure
check "$([ -d "$PLUGIN_DIR/includes" ] && echo true || echo false)" "Directorio includes/ presente"
check "$([ -d "$PLUGIN_DIR/assets" ] && echo true || echo false)" "Directorio assets/ presente"
check "$([ -d "$PLUGIN_DIR/languages" ] && echo true || echo false)" "Directorio languages/ presente"

# 6.5 No sensitive data
SENSITIVE_DATA=$(grep -r "password\|secret\|api_key" "$PLUGIN_DIR/includes" "$PLUGIN_DIR/assets" 2>/dev/null | wc -l || true)
check "$([ $SENSITIVE_DATA -eq 0 ] && echo true || echo false)" "Sin datos sensibles"

# ── RESUMEN ──
section "Resumen de QA"

echo ""
echo -e "${GREEN}Pasaron: $PASS${NC}"
echo -e "${RED}Fallaron: $FAIL${NC}"
echo -e "${YELLOW}Advertencias: $WARN${NC}"
echo ""

TOTAL=$((PASS + FAIL))
if [ $TOTAL -gt 0 ]; then
    PERCENT=$((PASS * 100 / TOTAL))
    echo -e "Score: ${GREEN}$PERCENT%${NC}"
fi

echo ""

if [ $FAIL -eq 0 ]; then
    echo -e "${GREEN}✓✓✓ Todos los checks pasaron. El plugin está listo para distribución.${NC}"
    echo ""
    echo "Próximos pasos:"
    echo "  1. Probar en entorno real con Divi"
    echo "  2. Testing con screen readers (NVDA, VoiceOver)"
    echo "  3. Testing responsive en múltiples dispositivos"
    echo "  4. Empaquetar: ./scripts/package-plugin.sh --tag 0.1.0"
    echo "  5. Desplegar: ./scripts/deploy-plugin.sh user@host /var/www/site activate"
    exit 0
else
    echo -e "${RED}✗✗✗ Se encontraron $FAIL fallo(s). Revisa y corrige antes de distribuir.${NC}"
    exit 1
fi
