# TBMX Mega Menu — Documento Maestro

> Fuente única de verdad para construir el plugin WordPress que convierte menús nativos en mega menús con layouts de la Biblioteca de Divi.

## ¿Qué es este proyecto?

Este repositorio contiene **dos cosas**:

1. **El documento maestro** (web React + Vite) — lo que estás viendo en el navegador. Es la especificación completa del plugin: decisiones, arquitectura, diseño, roadmap y prompts para Claude Code.

2. **Los scripts de despliegue** — herramientas para empaquetar y subir el plugin cuando exista.

## Estructura del repositorio

```
.
├── src/                    # Documento maestro (React + Vite + Tailwind)
│   ├── App.tsx
│   ├── components/         # Secciones del documento
│   └── lib/                # Datos y utilidades
├── scripts/                # Scripts de terminal para el plugin
│   ├── package-plugin.sh   # Empaqueta el plugin en .zip
│   └── deploy-plugin.sh    # Sube y activa el plugin por SSH
├── DEPLOY.md               # Guía completa de despliegue
├── tbmx-megamenu/          # [PENDIENTE] Plugin PHP de WordPress
└── package.json
```

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
- **Fase 0 · Andamiaje** — estructura de archivos, bootstrap, readme
- **Fase 1 · Admin** — metabox, ajustes globales
- **Fase 2 · Front** — Walker, render, enqueue condicional
- **Fase 3 · Interacción** — JS hover-intent, acordeón móvil
- **Fase 4 · Pulido** — presets, i18n, QA

## Documentación

- **Documento maestro:** `npm run dev` → http://localhost:5173
- **Despliegue:** [DEPLOY.md](DEPLOY.md)
- **Prompts para Claude Code:** §11 del documento maestro

## Licencia

GPL v2 o posterior — obligatorio por derivar de WordPress.

---

**Estado:** v0.1 — borrador vivo. Actualizar el documento a medida que avances.
