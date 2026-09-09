#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# test-plugin.sh
# Verifica que el plugin está listo para producción.
#
# Uso:
#   ./scripts/test-plugin.sh
#
# Comprueba:
# - Sintaxis PHP válida
# - Archivos CSS/JS existen y no están vacíos
# - Walker está correctamente implementado
# - Assets se cargan condicionalmente
# - ARIA attributes están presentes
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

PLUGIN_DIR="tcb-megamenu"

# Colores
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; BLUE='\033[0;34m'; NC='\033[0m'
info()  { echo -e "${GREEN}[✓]${NC} $*"; }
warn()  { echo -e "${YELLOW}[!]${NC} $*"; }
err()   { echo -e "${RED}[✗]${NC} $*" >&2; }
section() { echo -e "\n${BLUE}═══ $* ═══${NC}"; }

ERRORS=0
WARNINGS=0

# ── 1. Verificar sintaxis PHP ──
section "Sintaxis PHP"

if command -v php >/dev/null 2>&1; then
    PHP_FILES=$(find "$PLUGIN_DIR" -name "*.php" -type f)
    for file in $PHP_FILES; do
        if php -l "$file" > /dev/null 2>&1; then
            info "$(basename $file)"
        else
            err "Error de sintaxis en: $file"
            php -l "$file"
            ERRORS=$((ERRORS + 1))
        fi
    done
else
    warn "PHP no está instalado. Omitiendo verificación de sintaxis."
    WARNINGS=$((WARNINGS + 1))
fi

# ── 2. Verificar Walker implementado ──
section "Walker personalizado"

if grep -q "class Menu_Walker extends \\\\Walker_Nav_Menu" "$PLUGIN_DIR/includes/class-menu-walker.php"; then
    info "Walker extiende Walker_Nav_Menu"
else
    err "Walker no extiende Walker_Nav_Menu"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "aria-haspopup" "$PLUGIN_DIR/includes/class-menu-walker.php"; then
    info "ARIA: aria-haspopup presente"
else
    err "ARIA: aria-haspopup no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "aria-expanded" "$PLUGIN_DIR/includes/class-menu-walker.php"; then
    info "ARIA: aria-expanded presente"
else
    err "ARIA: aria-expanded no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "aria-controls" "$PLUGIN_DIR/includes/class-menu-walker.php"; then
    info "ARIA: aria-controls presente"
else
    err "ARIA: aria-controls no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q 'role="region"' "$PLUGIN_DIR/includes/class-menu-walker.php"; then
    info "ARIA: role=\"region\" presente"
else
    err "ARIA: role=\"region\" no encontrado"
    ERRORS=$((ERRORS + 1))
fi

# ── 3. Verificar assets front ──
section "Assets front-end"

if [[ -s "$PLUGIN_DIR/assets/css/megamenu.css" ]]; then
    CSS_LINES=$(wc -l < "$PLUGIN_DIR/assets/css/megamenu.css")
    info "megamenu.css: $CSS_LINES líneas"
else
    err "megamenu.css no existe o está vacío"
    ERRORS=$((ERRORS + 1))
fi

if [[ -s "$PLUGIN_DIR/assets/js/megamenu.js" ]]; then
    JS_LINES=$(wc -l < "$PLUGIN_DIR/assets/js/megamenu.js")
    JS_SIZE=$(du -h "$PLUGIN_DIR/assets/js/megamenu.js" | cut -f1)
    info "megamenu.js: $JS_LINES líneas ($JS_SIZE)"
    
    # Verificar que está bajo 5 KB
    JS_BYTES=$(wc -c < "$PLUGIN_DIR/assets/js/megamenu.js")
    if [[ $JS_BYTES -lt 5120 ]]; then
        info "JS bajo 5 KB ✓"
    else
        warn "JS excede 5 KB: $JS_BYTES bytes"
        WARNINGS=$((WARNINGS + 1))
    fi
else
    err "megamenu.js no existe o está vacío"
    ERRORS=$((ERRORS + 1))
fi

# ── 4. Verificar interacciones JS ──
section "Interacciones JavaScript"

if grep -q "hoverIn" "$PLUGIN_DIR/assets/js/megamenu.js"; then
    info "Hover-intent implementado"
else
    err "Hover-intent no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "addEventListener.*click" "$PLUGIN_DIR/assets/js/megamenu.js"; then
    info "Click handler implementado"
else
    err "Click handler no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "addEventListener.*keydown" "$PLUGIN_DIR/assets/js/megamenu.js"; then
    info "Keyboard navigation implementada"
else
    err "Keyboard navigation no encontrada"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "aria-expanded" "$PLUGIN_DIR/assets/js/megamenu.js"; then
    info "ARIA state management presente"
else
    err "ARIA state management no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "prefers-reduced-motion" "$PLUGIN_DIR/assets/js/megamenu.js"; then
    info "Reduced motion respetado"
else
    err "Reduced motion no respetado"
    ERRORS=$((ERRORS + 1))
fi

# ── 5. Verificar CSS responsive ──
section "CSS responsive"

if grep -q "@media.*max-width.*980px" "$PLUGIN_DIR/assets/css/megamenu.css"; then
    info "Media query mobile (< 980px) presente"
else
    err "Media query mobile no encontrada"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "@media.*prefers-reduced-motion" "$PLUGIN_DIR/assets/css/megamenu.css"; then
    info "Reduced motion en CSS"
else
    err "Reduced motion no encontrado en CSS"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "focus-visible" "$PLUGIN_DIR/assets/css/megamenu.css"; then
    info "Focus visible implementado"
else
    err "Focus visible no encontrado"
    ERRORS=$((ERRORS + 1))
fi

# ── 6. Verificar enqueue condicional ──
section "Enqueue condicional"

if grep -q "any_menu_has_mega_items" "$PLUGIN_DIR/includes/class-assets.php"; then
    info "Verificación de mega items presente"
else
    err "Verificación de mega items no encontrada"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "wp_enqueue_style.*tcb-megamenu" "$PLUGIN_DIR/includes/class-assets.php"; then
    info "CSS se enqueue condicionalmente"
else
    err "CSS enqueue no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "wp_enqueue_script.*tcb-megamenu" "$PLUGIN_DIR/includes/class-assets.php"; then
    info "JS se enqueue condicionalmente"
else
    err "JS enqueue no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "wp_localize_script" "$PLUGIN_DIR/includes/class-assets.php"; then
    info "Config pasada a JS via localize_script"
else
    err "Config no se pasa a JS"
    ERRORS=$((ERRORS + 1))
fi

# ── 7. Verificar Renderer ──
section "Renderer"

if grep -q "render_divi_layout" "$PLUGIN_DIR/includes/class-renderer.php"; then
    info "Render de layouts Divi implementado"
else
    err "Render de layouts Divi no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "render_columns" "$PLUGIN_DIR/includes/class-renderer.php"; then
    info "Render de columnas implementado"
else
    err "Render de columnas no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "is_divi_active" "$PLUGIN_DIR/includes/class-renderer.php"; then
    info "Detección de Divi implementada"
else
    err "Detección de Divi no encontrada"
    ERRORS=$((ERRORS + 1))
fi

# ── 8. Verificar integración ──
section "Integración con WordPress"

if grep -q "wp_nav_menu_args" "$PLUGIN_DIR/includes/class-plugin.php"; then
    info "Filtro wp_nav_menu_args registrado"
else
    err "Filtro wp_nav_menu_args no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "body_class" "$PLUGIN_DIR/includes/class-plugin.php"; then
    info "Filtro body_class registrado"
else
    err "Filtro body_class no encontrado"
    ERRORS=$((ERRORS + 1))
fi

# ── Resumen ──
section "Resumen"

if [[ $ERRORS -eq 0 ]]; then
    echo -e "${GREEN}✓ Todos los checks pasaron. El plugin está listo para producción.${NC}"
    echo ""
    echo "Estadísticas:"
    echo "  - Archivos PHP: $(find $PLUGIN_DIR -name '*.php' -type f | wc -l)"
    echo "  - Archivos CSS: $(find $PLUGIN_DIR -name '*.css' -type f | wc -l)"
    echo "  - Archivos JS: $(find $PLUGIN_DIR -name '*.js' -type f | wc -l)"
    echo "  - Total líneas de código: $(find $PLUGIN_DIR -type f \( -name '*.php' -o -name '*.css' -o -name '*.js' \) -exec cat {} \; | wc -l)"
    echo ""
    echo "Próximos pasos:"
    echo "  1. Probar en entorno de desarrollo"
    echo "  2. Verificar con Divi activo y sin Divi"
    echo "  3. Probar accesibilidad con screen reader"
    echo "  4. Empaquetar: ./scripts/package-plugin.sh --tag 0.1.0"
    echo "  5. Desplegar: ./scripts/deploy-plugin.sh user@host /var/www/site activate"
    exit 0
else
    echo -e "${RED}✗ Se encontraron $ERRORS error(es) y $WARNINGS warning(s).${NC}"
    echo "Revisa los mensajes arriba y corrige los errores antes de desplegar."
    exit 1
fi
