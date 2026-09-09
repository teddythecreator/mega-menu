#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# verify-plugin.sh
# Verifica que el plugin tiene la estructura correcta y puede activarse.
#
# Uso:
#   ./scripts/verify-plugin.sh
#
# Comprueba:
# - Archivos principales existen
# - PHP syntax es válido
# - Constantes definidas
# - Clases tienen namespace correcto
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

PLUGIN_DIR="tbmx-megamenu"

# Colores
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; BLUE='\033[0;34m'; NC='\033[0m'
info()  { echo -e "${GREEN}[✓]${NC} $*"; }
warn()  { echo -e "${YELLOW}[!]${NC} $*"; }
err()   { echo -e "${RED}[✗]${NC} $*" >&2; exit 1; }
section() { echo -e "\n${BLUE}═══ $* ═══${NC}"; }

ERRORS=0

# ── 1. Verificar estructura de archivos ──
section "Estructura de archivos"

REQUIRED_FILES=(
    "tbmx-megamenu.php"
    "uninstall.php"
    "readme.txt"
    "includes/class-plugin.php"
    "includes/class-menu-fields.php"
    "includes/class-menu-walker.php"
    "includes/class-settings.php"
    "includes/class-assets.php"
    "includes/class-renderer.php"
    "assets/css/megamenu.css"
    "assets/css/admin.css"
    "assets/js/megamenu.js"
    "assets/js/admin.js"
    "languages/tbmx-megamenu.pot"
)

for file in "${REQUIRED_FILES[@]}"; do
    if [[ -f "$PLUGIN_DIR/$file" ]]; then
        info "$file"
    else
        err "Falta: $file"
        ERRORS=$((ERRORS + 1))
    fi
done

# ── 2. Verificar sintaxis PHP ──
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
fi

# ── 3. Verificar cabecera del plugin ──
section "Cabecera del plugin"

if grep -q "Plugin Name: TBMX Mega Menu" "$PLUGIN_DIR/tbmx-megamenu.php"; then
    info "Plugin Name encontrado"
else
    err "Plugin Name no encontrado en tbmx-megamenu.php"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "Version:" "$PLUGIN_DIR/tbmx-megamenu.php"; then
    VERSION=$(grep "Version:" "$PLUGIN_DIR/tbmx-megamenu.php" | head -1 | awk '{print $3}')
    info "Versión: $VERSION"
else
    err "Version no encontrada"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "Text Domain: tbmx-megamenu" "$PLUGIN_DIR/tbmx-megamenu.php"; then
    info "Text Domain correcto"
else
    err "Text Domain no encontrado o incorrecto"
    ERRORS=$((ERRORS + 1))
fi

# ── 4. Verificar constantes ──
section "Constantes definidas"

CONSTANTS=(
    "TBMX_MEGAMENU_VERSION"
    "TBMX_MEGAMENU_FILE"
    "TBMX_MEGAMENU_DIR"
    "TBMX_MEGAMENU_URL"
    "TBMX_MEGAMENU_BASENAME"
)

for const in "${CONSTANTS[@]}"; do
    if grep -q "define( '$const'" "$PLUGIN_DIR/tbmx-megamenu.php"; then
        info "$const"
    else
        err "Constante no definida: $const"
        ERRORS=$((ERRORS + 1))
    fi
done

# ── 5. Verificar namespaces ──
section "Namespaces"

PHP_CLASSES=$(find "$PLUGIN_DIR/includes" -name "class-*.php" -type f)
for file in $PHP_CLASSES; do
    if grep -q "namespace TBMX_MegaMenu;" "$file"; then
        info "$(basename $file) - namespace correcto"
    else
        warn "$(basename $file) - namespace no encontrado o incorrecto"
    fi
done

# ── 6. Verificar hooks ──
section "Hooks registrados"

if grep -q "add_action( 'plugins_loaded'" "$PLUGIN_DIR/tbmx-megamenu.php"; then
    info "Hook plugins_loaded registrado"
else
    err "Hook plugins_loaded no encontrado"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "register_activation_hook" "$PLUGIN_DIR/tbmx-megamenu.php"; then
    info "Activation hook registrado"
else
    warn "Activation hook no encontrado (opcional)"
fi

if grep -q "register_deactivation_hook" "$PLUGIN_DIR/tbmx-megamenu.php"; then
    info "Deactivation hook registrado"
else
    warn "Deactivation hook no encontrado (opcional)"
fi

# ── 7. Verificar uninstall ──
section "Uninstall handler"

if grep -q "WP_UNINSTALL_PLUGIN" "$PLUGIN_DIR/uninstall.php"; then
    info "Verificación WP_UNINSTALL_PLUGIN presente"
else
    err "Verificación WP_UNINSTALL_PLUGIN no encontrada"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "delete_option( 'tbmx_megamenu_settings'" "$PLUGIN_DIR/uninstall.php"; then
    info "Limpieza de opciones configurada"
else
    err "Limpieza de opciones no encontrada"
    ERRORS=$((ERRORS + 1))
fi

# ── Resumen ──
section "Resumen"

if [[ $ERRORS -eq 0 ]]; then
    echo -e "${GREEN}✓ Todos los checks pasaron. El plugin está listo para activarse.${NC}"
    echo ""
    echo "Próximos pasos:"
    echo "  1. Empaquetar: ./scripts/package-plugin.sh --tag 0.1.0"
    echo "  2. Desplegar:  ./scripts/deploy-plugin.sh user@host /var/www/site activate"
    echo "  3. O copiar manualmente a wp-content/plugins/"
    exit 0
else
    echo -e "${RED}✗ Se encontraron $ERRORS error(es). Revisa los mensajes arriba.${NC}"
    exit 1
fi
