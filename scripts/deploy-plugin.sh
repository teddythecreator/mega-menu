#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# deploy-plugin.sh
# Sube y activa el plugin en un servidor remoto por SSH + WP-CLI.
#
# Uso:
#   ./scripts/deploy-plugin.sh user@host /var/www/site          # sube el zip y lo instala
#   ./scripts/deploy-plugin.sh user@host /var/www/site activate # además lo activa
#
# Requisitos: ssh, scp, wp-cli instalado en el servidor remoto.
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

PLUGIN_SLUG="tbmx-megamenu"
ZIP_NAME="${PLUGIN_SLUG}.zip"
REMOTE_USER_HOST="${1:-}"
REMOTE_PATH="${2:-}"
DO_ACTIVATE="${3:-}"

RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; NC='\033[0m'
info()  { echo -e "${GREEN}[✓]${NC} $*"; }
warn()  { echo -e "${YELLOW}[!]${NC} $*"; }
err()   { echo -e "${RED}[✗]${NC} $*" >&2; exit 1; }

[ -n "$REMOTE_USER_HOST" ] || err "Falta el host: ./deploy-plugin.sh user@host /ruta/wp"
[ -n "$REMOTE_PATH" ]      || err "Falta la ruta remota del WordPress"
[ -f "$ZIP_NAME" ]         || err "No existe $ZIP_NAME. Ejecuta primero package-plugin.sh"

info "Subiendo $ZIP_NAME → $REMOTE_USER_HOST:$REMOTE_PATH"
scp "$ZIP_NAME" "$REMOTE_USER_HOST:$REMOTE_PATH/$ZIP_NAME"

info "Instalando plugin en el servidor..."
ssh "$REMOTE_USER_HOST" "cd '$REMOTE_PATH' && wp plugin install $ZIP_NAME --force --allow-root 2>/dev/null || wp plugin install $ZIP_NAME --force"
rm -f "$ZIP_NAME"  # opcional: borrar el zip del servidor

if [[ "$DO_ACTIVATE" == "activate" ]]; then
  info "Activando plugin..."
  ssh "$REMOTE_USER_HOST" "cd '$REMOTE_PATH' && wp plugin activate $PLUGIN_SLUG --allow-root 2>/dev/null || wp plugin activate $PLUGIN_SLUG"
fi

info "Desplegado. Verifica en WP Admin → Plugins."
