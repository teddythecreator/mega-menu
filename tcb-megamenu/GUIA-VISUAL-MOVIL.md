# 📱 Guía Visual - Opciones de Menú Móvil TCB MegaMenu

## 🎨 Estilos de Menú Móvil

### 1. 📋 Accordion (Vertical)
```
┌─────────────────────────┐
│  Menú Principal         │
├─────────────────────────┤
│  ▼ Item 1               │
├─────────────────────────┤ ← Border-left accent
│    ├─ Subitem 1.1       │
│    ├─ Subitem 1.2       │
│    └─ Subitem 1.3       │
├─────────────────────────┤
│  ▶ Item 2               │
├─────────────────────────┤
│  ▶ Item 3               │
└─────────────────────────┘

✅ Simple y directo
✅ Ocupa todo el ancho
✅ Ideal para menús simples
```

### 2. 📥 Drawer (Lateral)
```
┌─────────────────────────────────────┐
│  Header              [☰]            │
├─────────────────────────────────────┤
│                                     │
│  ┌──────────┐░░░░░░░░░░░░░░░░░░░░░│
│  │          │░░░░░░░░░░░░░░░░░░░░░│
│  │  Menú    │░░░░░░░░░░░░░░░░░░░░░│
│  │          │░░░ Overlay ░░░░░░░░░│
│  │  Item 1  │░░░░░░░░░░░░░░░░░░░░░│
│  │  ├─ 1.1  │░░░░░░░░░░░░░░░░░░░░░│
│  │  ├─ 1.2  │░░░░░░░░░░░░░░░░░░░░░│
│  │  └─ 1.3  │░░░░░░░░░░░░░░░░░░░░░│
│  │          │░░░░░░░░░░░░░░░░░░░░░│
│  │  Item 2  │░░░░░░░░░░░░░░░░░░░░░│
│  │  Item 3  │░░░░░░░░░░░░░░░░░░░░░│
│  └──────────┘░░░░░░░░░░░░░░░░░░░░░│
│                                     │
└─────────────────────────────────────┘

✅ Elegante y profesional
✅ Mucho espacio para contenido
✅ Posición: Izquierda o Derecha
✅ Ancho configurable (200-500px)
```

### 3. 🔲 Overlay (Fullscreen)
```
┌─────────────────────────────────────┐
│  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│  ░░░┌─────────────────────┐░░░░░░░│
│  ░░░│                     │░░░░░░░│
│  ░░░│     Menú            │░░░░░░░│
│  ░░░│                     │░░░░░░░│
│  ░░░│     Item 1          │░░░░░░░│
│  ░░░│     ├─ 1.1          │░░░░░░░│
│  ░░░│     ├─ 1.2          │░░░░░░░│
│  ░░░│     └─ 1.3          │░░░░░░░│
│  ░░░│                     │░░░░░░░│
│  ░░░│     Item 2          │░░░░░░░│
│  ░░░│     Item 3          │░░░░░░░│
│  ░░░│                     │░░░░░░░│
│  ░░░└─────────────────────┘░░░░░░░│
│  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
└─────────────────────────────────────┘

✅ Inmersivo y impactante
✅ Ocupa toda la pantalla
✅ Efecto de zoom al abrir
✅ Ideal para experiencias únicas
```

### 4. 📤 Slide Down
```
┌─────────────────────────────────────┐
│  ┌───────────────────────────────┐  │
│  │  Menú                         │  │
│  │                               │  │
│  │  Item 1                       │  │
│  │  ├─ 1.1                       │  │
│  │  ├─ 1.2                       │  │
│  │  └─ 1.3                       │  │
│  │                               │  │
│  │  Item 2                       │  │
│  │  Item 3                       │  │
│  │                               │  │
│  │  (scroll si es necesario)     │  │
│  └───────────────────────────────┘  │
├─────────────────────────────────────┤
│  Header              [☰]            │
├─────────────────────────────────────┤
│                                     │
│  Contenido de la página...          │
│                                     │
└─────────────────────────────────────┘

✅ Rápido y accesible
✅ Se desliza desde arriba
✅ Max-height con scroll
✅ Ideal para acceso rápido
```

---

## 🍔 Estilos de Icono Hamburguesa

### 1. ☰ Classic (3 líneas)
```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│ ━━━  │          │  ╲   │
│ ━━━  │    →     │   ╳  │
│ ━━━  │          │  ╱   │
└──────┘          └──────┘

⭐ El más reconocido
⭐ Se transforma en X
⭐ Recomendado para cualquier sitio
```

### 2. ← Arrow (Flecha)
```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│  ╱   │          │      │
│ ━━━  │    →     │ ━━━  │
│  ╲   │          │      │
└──────┘          └──────┘

⭐ Efecto direccional
⭐ Moderno y dinámico
⭐ Ideal para sitios con dirección clara
```

### 3. ⋮ Dots (3 puntos)
```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│  ●   │          │  ●   │
│  ●   │    →     │  ●   │
│  ●   │          │  ●   │
└──────┘          └──────┘

⭐ Minimalista
⭐ Limpio y elegante
⭐ Ideal para diseños modernos
```

### 4. + Plus/Minus
```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│      │          │      │
│ ━━━  │    →     │ ━━━  │
│      │          │      │
└──────┘          └──────┘
  ( + )             ( - )

⭐ Simple y directo
⭐ Rotación de 90°
⭐ Ideal para estilo flat
```

### 5. ✕ X Mark
```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│  ╲   │          │  ╲   │
│   ╳  │    →     │   ╳  │
│  ╱   │          │  ╱   │
└──────┘          └──────┘

⭐ Siempre visible como X
⭐ Directo y claro
⭐ Ideal para estilo bold
```

---

## 🎨 Personalización del Icono

### Color del Icono
```
Header Claro:              Header Oscuro:
┌──────────────────┐       ┌──────────────────┐
│                  │       │                  │
│  ☰ (negro)       │       │  ☰ (blanco)      │
│                  │       │                  │
└──────────────────┘       └──────────────────┘
Color: #333333             Color: #ffffff

Color de Marca:
┌──────────────────┐
│                  │
│  ☰ (rojo)        │
│                  │
└──────────────────┘
Color: #e11414
```

### Tamaño del Icono
```
Pequeño (16px):      Mediano (24px):      Grande (32px):
┌────────┐           ┌────────────┐       ┌────────────────┐
│  ☰     │           │    ☰       │       │      ☰         │
└────────┘           └────────────┘       └────────────────┘
```

### Grosor de Línea
```
Fino (1px):          Normal (2px):        Grueso (3px):
┌────────────┐       ┌────────────┐       ┌────────────┐
│  ─ ─ ─     │       │  ━ ━ ━     │       │  █ █ █     │
└────────────┘       └────────────┘       └────────────┘
```

---

## 📊 Tabla de Recomendaciones

### Por Tipo de Sitio

| Tipo de Sitio | Mobile Style | Hamburger Icon | Icon Size | Notas |
|---------------|--------------|----------------|-----------|-------|
| **Corporativo** | Drawer (Right) | Classic | 24px | Elegante y profesional |
| **E-commerce** | Drawer (Left) | Classic | 28px | Fácil acceso al menú |
| **Portfolio** | Overlay | Dots | 32px | Experiencia inmersiva |
| **Blog** | Slide | Plus | 24px | Acceso rápido |
| **Landing** | Overlay | Arrow | 36px | Impactante |
| **Minimalista** | Accordion | Dots | 20px | Limpio y simple |
| **Bold** | Drawer (Right) | X | 28px | Directo y claro |

### Por Cantidad de Items

| Items | Mobile Style | Notas |
|-------|--------------|-------|
| **1-5** | Accordion | Simple y directo |
| **6-10** | Slide | Rápido y accesible |
| **11-20** | Drawer | Espacio suficiente |
| **20+** | Overlay o Drawer | Mucho contenido |

### Por Diseño del Header

| Header | Mobile Style | Icon Color | Notas |
|--------|--------------|------------|-------|
| **Claro** | Cualquiera | Oscuro (#333) | Buen contraste |
| **Oscuro** | Cualquiera | Claro (#fff) | Buen contraste |
| **Color** | Cualquiera | Blanco o color marca | Destacar |
| **Transparente** | Overlay | Según fondo | Adaptar |

---

## 🚀 Configuraciones Rápidas

### ⚡ Configuración Minimalista
```yaml
Mobile Style: Accordion
Hamburger Icon: Dots
Icon Color: #666666
Icon Size: 20px
Line Thickness: 2px
```
**Ideal para:** Sitios limpios y modernos

### 💼 Configuración Profesional
```yaml
Mobile Style: Drawer (Right)
Drawer Width: 320px
Hamburger Icon: Classic
Icon Color: #333333
Icon Size: 24px
Line Thickness: 2px
```
**Ideal para:** Sitios corporativos y e-commerce

### 🎨 Configuración Creativa
```yaml
Mobile Style: Overlay
Hamburger Icon: Plus
Icon Color: #e11414
Icon Size: 32px
Line Thickness: 3px
```
**Ideal para:** Portfolios y landing pages

### ⚡ Configuración Rápida
```yaml
Mobile Style: Slide
Hamburger Icon: Arrow
Icon Color: #333333
Icon Size: 24px
Line Thickness: 2px
```
**Ideal para:** Blogs y sitios de contenido

### 🎯 Configuración Impactante
```yaml
Mobile Style: Overlay
Hamburger Icon: X
Icon Color: #ffffff
Icon Size: 36px
Line Thickness: 3px
```
**Ideal para:** Landing pages y experiencias únicas

---

## 📱 Preview de Combinaciones

### Accordion + Classic
```
┌─────────────────────────┐
│  Header      [☰]        │
├─────────────────────────┤
│  ▼ Item 1               │
│    ├─ Subitem 1.1       │
│    └─ Subitem 1.2       │
├─────────────────────────┤
│  ▶ Item 2               │
└─────────────────────────┘
✅ Simple y reconocido
```

### Drawer + Dots
```
┌─────────────────────────────────┐
│  Header          [⋮]            │
├─────────────────────────────────┤
│  ┌────────┐░░░░░░░░░░░░░░░░░░░│
│  │        │░░░░░░░░░░░░░░░░░░░│
│  │  Menú  │░░░░░░░░░░░░░░░░░░░│
│  │        │░░░░░░░░░░░░░░░░░░░│
│  │  Item  │░░░░░░░░░░░░░░░░░░░│
│  └────────┘░░░░░░░░░░░░░░░░░░░│
└─────────────────────────────────┘
✅ Minimalista y elegante
```

### Overlay + Plus
```
┌─────────────────────────────────┐
│  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│  ░░░┌───────────────┐░░░░░░░░░│
│  ░░░│               │░░░░░░░░░│
│  ░░░│   [+] Menú    │░░░░░░░░░│
│  ░░░│               │░░░░░░░░░│
│  ░░░│   Item 1      │░░░░░░░░░│
│  ░░░│   Item 2      │░░░░░░░░░│
│  ░░░│               │░░░░░░░░░│
│  ░░░└───────────────┘░░░░░░░░░│
│  ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
└─────────────────────────────────┘
✅ Simple e inmersivo
```

### Slide + Arrow
```
┌─────────────────────────────────┐
│  ┌───────────────────────────┐  │
│  │  [←] Menú                 │  │
│  │                           │  │
│  │  Item 1                   │  │
│  │  Item 2                   │  │
│  │  Item 3                   │  │
│  └───────────────────────────┘  │
├─────────────────────────────────┤
│  Header                         │
├─────────────────────────────────┤
│  Contenido...                   │
└─────────────────────────────────┘
✅ Rápido y direccional
```

---

## 🎯 Decision Tree

```
¿Cuántos items tienes?
│
├─ 1-5 items → Accordion
│
├─ 6-10 items → Slide
│
├─ 11-20 items → Drawer
│
└─ 20+ items → Overlay

¿Qué estilo tiene tu sitio?
│
├─ Minimalista → Dots
│
├─ Corporativo → Classic
│
├─ Creativo → Plus
│
├─ Bold → X
│
└─ Moderno → Arrow

¿Cuál es el color de tu header?
│
├─ Claro → Icon Color: #333333
│
├─ Oscuro → Icon Color: #ffffff
│
└─ Color → Icon Color: Color de marca o blanco
```

---

## 📞 Soporte

Si necesitas ayuda para elegir la configuración perfecta:

1. **Prueba diferentes combinaciones** en Settings
2. **Redimensiona la ventana** para ver el resultado
3. **Limpia la caché** si no ves los cambios
4. **Contacta soporte**: soporte@thecreator.business

---

**¡Experimenta con todas las combinaciones y encuentra la perfecta para tu sitio!** 🎨
