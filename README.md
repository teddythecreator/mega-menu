# TCB MegaMenu — By The Creator Business

> Professional mega menus for WordPress with seamless Divi integration.
> Website: [thecreator.business](https://thecreator.business/)

## ¿Qué es este proyecto?

Este repositorio contiene:

1. **El documento maestro** (web React + Vite) — Especificación completa del plugin: decisiones, arquitectura, diseño, roadmap y prompts.

2. **El plugin TCB MegaMenu** — Plugin WordPress funcional listo para instalar.

3. **Los scripts de despliegue** — Herramientas para empaquetar y subir el plugin.

## Estructura del repositorio

```
.
├── src/                    # Documento maestro (React + Vite + Tailwind)
│   ├── App.tsx
│   ├── components/         # Secciones del documento
│   └── lib/                # Datos y utilidades
├── tcb-megamenu/           # Plugin WordPress (listo para instalar)
│   ├── tcb-megamenu.php    # Archivo principal
│   ├── includes/           # Clases PHP
│   ├── assets/             # CSS y JS
│   ├── INSTALLATION-GUIDE.md
│   ├── readme.txt          # WordPress.org format
│   └── LICENSE
├── scripts/                # Scripts de terminal
│   ├── package-plugin.sh   # Empaqueta el plugin en .zip
│   └── deploy-plugin.sh    # Sube y activa el plugin por SSH
├── DEPLOY.md               # Guía de despliegue
└── package.json
```

## Uso del plugin

### Instalación rápida

1. Empaquetar el plugin:
```bash
chmod +x scripts/package-plugin.sh
./scripts/package-plugin.sh --tag 1.0.0
```

2. Instalar en WordPress:
   - Ve a **Plugins → Añadir nuevo → Subir plugin**
   - Selecciona `tcb-megamenu-1.0.0.zip`
   - Activa el plugin

3. Configurar:
   - Ve a **TCB MegaMenu → Settings**
   - Elige un preset o personaliza colores
   - Guarda cambios

4. Crear mega menús:
   - Ve a **Apariencia → Menús**
   - Activa "Enable Mega Panel" en ítems padre
   - Elige Divi Layout o Custom Columns
   - Guarda el menú

### Documentación del plugin

- **Guía de instalación:** `tcb-megamenu/INSTALLATION-GUIDE.md`
- **WordPress.org readme:** `tcb-megamenu/readme.txt`
- **Licencia:** `tcb-megamenu/LICENSE` (GPL v2)

## Uso del documento maestro

```bash
# Desarrollo
npm install
npm run dev

# Build de producción
npm run build
```

El build genera `dist/index.html` — la web estática del documento.

## Uso de los scripts de despliegue

**Importante:** Los scripts requieren que el plugin PHP exista en `./tbmx-megamenu/`. Actualmente está pendiente de construir (ver §10 del documento maestro).

Cuando el plugin exista:

```bash
# Dar permisos de ejecución (solo la primera vez)
chmod +x scripts/package-plugin.sh scripts/deploy-plugin.sh

# Empaquetar el plugin
./scripts/package-plugin.sh --tag 0.1.0

# Desplegar al servidor
./scripts/deploy-plugin.sh user@host /var/www/misitio activate
```

Ver [DEPLOY.md](DEPLOY.md) para la guía completa.

## Roadmap

Ver §10 del documento maestro (web) o el checklist interactivo en la sección "Roadmap".

**Fases:**
- ✅ **Fase 0 · Andamiaje** — estructura de archivos, bootstrap, readme [COMPLETADA]
- ✅ **Fase 1 · Admin** — metabox, ajustes globales [COMPLETADA]
- ✅ **Fase 2 · Front** — Walker, render, enqueue condicional [COMPLETADA]
- ✅ **Fase 3 · Interacción** — JS avanzado, animaciones, accesibilidad [COMPLETADA]
- ✅ **Fase 4 · Pulido** — QA final, documentación, distribución [COMPLETADA]

**Estado:** ✅ Plugin 100% funcional y listo para distribución

Ver [FASE-0-COMPLETADA.md](FASE-0-COMPLETADA.md) para detalles de la Fase 0.
Ver [FASE-1-COMPLETADA.md](FASE-1-COMPLETADA.md) para detalles de la Fase 1.
Ver [FASE-2-COMPLETADA.md](FASE-2-COMPLETADA.md) para detalles de la Fase 2.
Ver [FASE-3-COMPLETADA.md](FASE-3-COMPLETADA.md) para detalles de la Fase 3.
Ver [FASE-4-COMPLETADA.md](FASE-4-COMPLETADA.md) para detalles de la Fase 4.

## Documentación

- **Documento maestro:** `npm run dev` → http://localhost:5173
- **Despliegue:** [DEPLOY.md](DEPLOY.md)
- **Prompts para Claude Code:** §11 del documento maestro

## Licencia

GPL v2 o posterior — obligatorio por derivar de WordPress.

---

**Estado:** v0.1 — borrador vivo. Actualizar el documento a medida que avances.
