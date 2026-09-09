# Despliegue del plugin TBMX Mega Menu

Este documento explica cómo empaquetar y desplegar el plugin `tbmx-megamenu` desde la terminal.

## 1. Requisitos previos

- El plugin PHP ya construido en la carpeta `./tbmx-megamenu/` (ver documento maestro §4.2).
- En tu máquina local: `bash`, `zip`, `rsync`, `ssh`, `scp`.
- En el servidor remoto: [WP-CLI](https://wp-cli.org/) instalado y accesible.

Instalación rápida (Ubuntu/Debian):
```bash
sudo apt install zip rsync openssh-client
```

## 2. Empaquetar el plugin

El script `scripts/package-plugin.sh` genera un `.zip` limpio con solo los archivos necesarios, listo para subir a WordPress.

```bash
# Da permisos de ejecución (solo la primera vez)
chmod +x scripts/package-plugin.sh

# Empaquetar como dev
./scripts/package-plugin.sh

# Empaquetar con etiqueta de versión (inyecta la versión en la cabecera del plugin)
./scripts/package-plugin.sh --tag 0.1.0
```

**Resultado:** `tbmx-megamenu.zip` (o `tbmx-megamenu-0.1.0.zip`) en la raíz del proyecto.

### ¿Qué incluye el zip?
Todo el contenido de `./tbmx-megamenu/` **excepto**:
- `.git*`, `node_modules`, `.env*`, `tests`, `.phpunit*`, `phpcs.xml*`
- Archivos de sistema (`.DS_Store`, `Thumbs.db`) y logs

### Estructura del zip
```
tbmx-megamenu.zip
└── tbmx-megamenu/
    ├── tbmx-megamenu.php
    ├── uninstall.php
    ├── includes/
    │   ├── class-plugin.php
    │   ├── class-menu-fields.php
    │   ├── class-menu-walker.php
    │   ├── class-settings.php
    │   ├── class-assets.php
    │   └── class-renderer.php
    ├── assets/
    │   ├── css/megamenu.css
    │   ├── css/admin.css
    │   ├── js/megamenu.js
    │   └── js/admin.js
    ├── languages/
    └── readme.txt
```

## 3. Desplegar el plugin

### Opción A: Subida manual por WP Admin
1. Ve a **WP Admin → Plugins → Añadir nuevo → Subir plugin**.
2. Selecciona `tbmx-megamenu.zip`.
3. Pulsa **Instalar ahora** y luego **Activar plugin**.

### Opción B: Despliegue por terminal (recomendado)

El script `scripts/deploy-plugin.sh` sube el zip por SSH y lo instala con WP-CLI.

```bash
# Da permisos de ejecución (solo la primera vez)
chmod +x scripts/deploy-plugin.sh

# Solo instalar (no activa)
./scripts/deploy-plugin.sh user@host /var/www/misitio

# Instalar y activar
./scripts/deploy-plugin.sh user@host /var/www/misitio activate
```

**Parámetros:**
- `user@host`: usuario y host SSH (ej. `deploy@tubomax.com`)
- `/var/www/misitio`: ruta absoluta al WordPress en el servidor
- `activate` (opcional): activa el plugin tras instalarlo

### Opción C: WP-CLI directo (si ya tienes el zip en el servidor)

```bash
# Subir el zip manualmente
scp tbmx-megamenu.zip user@host:/var/www/misitio/

# SSH al servidor
ssh user@host

# Instalar y activar
cd /var/www/misitio
wp plugin install tbmx-megamenu.zip --force
wp plugin activate tbmx-megamenu
```

## 4. Verificar la instalación

```bash
# En el servidor, por SSH
cd /var/www/misitio
wp plugin list | grep tbmx-megamenu
wp plugin status tbmx-megamenu
```

O visita **WP Admin → Plugins** y busca "TBMX Mega Menu".

## 5. Actualizar el plugin

Para actualizar a una nueva versión:

```bash
# 1. Empaquetar la nueva versión
./scripts/package-plugin.sh --tag 0.2.0

# 2. Desplegar (sobrescribe la versión anterior)
./scripts/deploy-plugin.sh user@host /var/www/misitio activate
```

WP-CLI con `--force` sobrescribe los archivos existentes. Las opciones guardadas en la base de datos (`tbmx_megamenu_settings` y metas `_tbmx_*`) **no se tocan**.

## 6. Desinstalar el plugin

```bash
# En el servidor
cd /var/www/misitio
wp plugin deactivate tbmx-megamenu
wp plugin delete tbmx-megamenu
```

El archivo `uninstall.php` se ejecuta automáticamente al borrar el plugin y limpia:
- La opción `tbmx_megamenu_settings`
- Todas las metas `_tbmx_*` de los ítems de menú

## 7. Flujo completo recomendado

```bash
# Desarrollo local
# 1. Editas los archivos PHP/CSS/JS en ./tbmx-megamenu/
# 2. Pruebas en tu entorno local (Local by Flywheel, DDEV, etc.)

# Preparar release
./scripts/package-plugin.sh --tag 0.1.0

# Desplegar a staging
./scripts/deploy-plugin.sh deploy@staging.tubomax.com /var/www/staging activate

# QA (ver §9 del documento maestro)
# ...

# Desplegar a producción
./scripts/deploy-plugin.sh deploy@tubomax.com /var/www/produccion activate
```

## 8. Troubleshooting

**Error: "The package could not be installed. No valid plugins were found."**
- El zip debe contener una carpeta con el mismo nombre que el archivo principal: `tbmx-megamenu/tbmx-megamenu.php`.
- Verifica que el script `package-plugin.sh` se ejecutó desde la raíz del proyecto.

**Error: "wp: command not found" en el servidor**
- Instala WP-CLI: https://wp-cli.org/#installing
- O usa la Opción A (subida manual por WP Admin).

**Error: "Permission denied" al activar**
- El usuario SSH debe tener permisos de escritura en la carpeta del WordPress.
- O usa `--allow-root` si ejecutas como root (no recomendado en producción).

**El plugin se activa pero no aparece el mega menú**
- Ve a **Apariencia → Menús** y configura los ítems con `_tbmx_enabled`.
- Verifica que el menú asignado a la ubicación correcta tiene ítems con megamenú.
- Revisa la consola del navegador por errores JS.

## 9. Notas de seguridad

- **Nunca subas el zip por FTP sin SSL.** Usa siempre SSH/SCP.
- **No commitees el zip al repositorio.** Añade `*.zip` a `.gitignore`.
- **Usa claves SSH**, no contraseñas. Configura `~/.ssh/config` para simplificar:
  ```
  Host staging
    HostName staging.tubomax.com
    User deploy
    IdentityFile ~/.ssh/id_ed25519
  ```
  Luego: `./scripts/deploy-plugin.sh staging /var/www/staging activate`

---

**Referencia:** Documento maestro §4 (Arquitectura técnica), §8 (Seguridad), §10 (Roadmap).
