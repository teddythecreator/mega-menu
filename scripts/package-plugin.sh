#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# package-plugin.sh
# Empaqueta el plugin WordPress en un .zip listo para subir (WP Admin o WP-CLI).
#
# Uso:
#   ./scripts/package-plugin.sh              # genera tcb-megamenu.zip en la raíz
#   ./scripts/package-plugin.sh --tag 1.0.0  # genera tcb-megamenu-1.0.0.zip
#
# Requisitos: bash, zip, git (opcional, para limpiar archivos ignorados).
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

PLUGIN_SLUG="tcb-megamenu"

# Manejar argumentos opcionales
if [ $# -eq 0 ]; then
    VERSION="dev"
else
    VERSION="${1#--tag}"
    VERSION="${VERSION:-dev}"
fi

ZIP_NAME="${PLUGIN_SLUG}${VERSION:+-$VERSION}.zip"
BUILD_DIR=".build-package"

# Colores
RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; NC='\033[0m'
info()  { echo -e "${GREEN}[✓]${NC} $*"; }
warn()  { echo -e "${YELLOW}[!]${NC} $*"; }
err()   { echo -e "${RED}[✗]${NC} $*" >&2; exit 1; }

# Comprobaciones
command -v zip >/dev/null 2>&1 || err "Falta 'zip'. Instálalo: apt install zip / brew install zip"
[ -d "$PLUGIN_SLUG" ] || err "No existe la carpeta './$PLUGIN_SLUG/'. Crea primero el plugin PHP."

info "Empaquetando $PLUGIN_SLUG → $ZIP_NAME"

# Limpieza previa
rm -rf "$BUILD_DIR" "$ZIP_NAME"
mkdir -p "$BUILD_DIR"

# Copia los archivos del plugin excluyendo basura
# Ajusta los patrones si añades tests, docs, etc.
rsync -a \
  --exclude='.DS_Store' \
  --exclude='Thumbs.db' \
  --exclude='*.log' \
  --exclude='.git*' \
  --exclude='node_modules' \
  --exclude='.env*' \
  --exclude='tests' \
  --exclude='.phpunit*' \
  --exclude='phpcs.xml*' \
  "$PLUGIN_SLUG/" "$BUILD_DIR/$PLUGIN_SLUG/"

# Inyecta la versión en la cabecera del plugin (solo si es un tag real)
if [[ "$VERSION" != "dev" ]]; then
  if [[ -f "$BUILD_DIR/$PLUGIN_SLUG/$PLUGIN_SLUG.php" ]]; then
    sed -i.bak "s/^ \* Version:.*$/ * Version: $VERSION/" \
      "$BUILD_DIR/$PLUGIN_SLUG/$PLUGIN_SLUG.php"
    rm -f "$BUILD_DIR/$PLUGIN_SLUG/$PLUGIN_SLUG.php.bak"
    info "Versión inyectada: $VERSION"
  fi
fi

# Genera el .zip
(cd "$BUILD_DIR" && zip -rq "../$ZIP_NAME" "$PLUGIN_SLUG")
rm -rf "$BUILD_DIR"

SIZE=$(du -h "$ZIP_NAME" | cut -f1)
info "Listo: $ZIP_NAME ($SIZE)"
echo ""
echo "  Sube este zip desde:"
echo "    • WP Admin → Plugins → Añadir nuevo → Subir plugin"
echo "    • wp plugin install $ZIP_NAME --force"
echo ""
