# 📱 Guía Visual - Menú Móvil TCB MegaMenu

## 🎯 Estilos de Menú Móvil Disponibles

El plugin ofrece 4 estilos diferentes de menú móvil, cada uno con sus propias características y casos de uso ideales.

---

## 📋 1. Accordion (Vertical)

**Recomendado para:** Menús simples y directos

### Características
- ✅ Panel se despliega verticalmente debajo del ítem
- ✅ Sin iconos duplicados
- ✅ Estructura limpia y organizada
- ✅ Separadores entre ítems
- ✅ Padding consistente (15px 20px)

### Apariencia
```
┌─────────────────────────┐
│  ☰ Servicios            │
├─────────────────────────┤
│  Diseño Web             │
│  Desarrollo             │
│  SEO                    │
│  Marketing              │
│  Consultoría            │
└─────────────────────────┘
```

### Cuándo Usarlo
- Menús con pocos ítems
- Sitios corporativos
- Blogs y sitios de contenido
- Cuando prefieres simplicidad

---

## 📥 2. Drawer (Lateral)

**Recomendado para:** Menús complejos con muchos ítems

### Características
- ✅ Panel se desliza desde la izquierda o derecha
- ✅ Overlay oscuro detrás del panel
- ✅ Ancho configurable (200-500px)
- ✅ Posición configurable (left/right)
- ✅ Scroll interno si el contenido es largo

### Apariencia
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
```

### Configuración
- **Drawer Position:** Left o Right
- **Drawer Width:** 200-500px (recomendado: 300px)

### Cuándo Usarlo
- E-commerce con muchas categorías
- Sitios con menús complejos
- Cuando necesitas mucho espacio
- Apps móviles nativas

---

## 🔲 3. Overlay (Fullscreen)

**Recomendado para:** Experiencias inmersivas

### Características
- ✅ Panel ocupa toda la pantalla
- ✅ Efecto de zoom al abrir
- ✅ Overlay oscuro detrás
- ✅ Contenido centrado
- ✅ Ideal para menús principales

### Apariencia
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
```

### Cuándo Usarlo
- Landing pages
- Portfolios creativos
- Sitios con diseño minimalista
- Cuando quieres impacto visual

---

## 📤 4. Slide Down

**Recomendado para:** Acceso rápido

### Características
- ✅ Panel se desliza desde arriba
- ✅ Ocupa todo el ancho
- ✅ Max-height con scroll
- ✅ Rápido y accesible
- ✅ No bloquea el contenido

### Apariencia
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
```

### Cuándo Usarlo
- Blogs y sitios de noticias
- Sitios con contenido largo
- Cuando necesitas acceso rápido
- Menús secundarios

---

## 🍔 Iconos de Hamburguesa Disponibles

### 1. Classic (☰)
**El más reconocido y usado**

```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│ ━━━  │          │  ╲   │
│ ━━━  │    →     │   ╳  │
│ ━━━  │          │  ╱   │
└──────┘          └──────┘
```

**Recomendado para:** Cualquier sitio

---

### 2. Arrow (←)
**Flechas direccionales**

```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│  ╱   │          │      │
│ ━━━  │    →     │ ━━━  │
│  ╲   │          │      │
└──────┘          └──────┘
```

**Recomendado para:** Sitios con dirección clara

---

### 3. Dots (⋮)
**Tres puntos verticales**

```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│  ●   │          │  ●   │
│  ●   │    →     │  ●   │
│  ●   │          │  ●   │
└──────┘          └──────┘
```

**Recomendado para:** Diseños minimalistas

---

### 4. Plus (+)
**Línea que rota**

```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│      │          │      │
│ ━━━  │    →     │ ━━━  │
│      │          │      │
└──────┘          └──────┘
  ( + )             ( - )
```

**Recomendado para:** Estilo flat

---

### 5. X (✕)
**X mark directo**

```
Cerrado:          Abierto:
┌──────┐          ┌──────┐
│  ╲   │          │  ╲   │
│   ╳  │    →     │   ╳  │
│  ╱   │          │  ╱   │
└──────┘          └──────┘
```

**Recomendado para:** Estilo bold

---

## 🎨 Personalización del Icono

### Color del Icono
- Debe contrastar con el fondo del header
- Ejemplos:
  - Header claro: `#333333`
  - Header oscuro: `#ffffff`
  - Color de marca: tu color corporativo

### Tamaño del Icono
- Rango: 16px - 48px
- Por defecto: 24px
- Recomendaciones:
  - **16-20px:** Diseños minimalistas
  - **24-28px:** Estándar (recomendado)
  - **32-48px:** Diseños bold

### Grosor de Línea
- Rango: 1px - 5px
- Por defecto: 2px
- Recomendaciones:
  - **1-2px:** Diseños delicados
  - **2-3px:** Estándar (recomendado)
  - **4-5px:** Diseños bold

---

## 📊 Comparación de Estilos

| Estilo | Ventaja | Desventaja | Uso Recomendado |
|--------|---------|------------|-----------------|
| **Accordion** | Simple, rápido | Limita el contenido | Menús simples, pocos items |
| **Drawer** | Elegante, mucho espacio | Requiere más interacción | Menús complejos, muchos items |
| **Overlay** | Inmersivo, impactante | Puede ser intrusivo | Landing pages, experiencias únicas |
| **Slide** | Rápido, accesible | Limita el alto | Blogs, sitios de contenido |

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

## 📱 Configuraciones Recomendadas

### Sitio Corporativo
```yaml
Mobile Style: Drawer (Right)
Drawer Width: 320px
Hamburger Icon: Classic
Icon Color: #333333
Icon Size: 24px
```

### E-commerce
```yaml
Mobile Style: Drawer (Left)
Drawer Width: 320px
Hamburger Icon: Classic
Icon Size: 28px
```

### Portfolio
```yaml
Mobile Style: Overlay
Hamburger Icon: Dots
Icon Size: 32px
```

### Blog
```yaml
Mobile Style: Slide
Hamburger Icon: Plus
Icon Size: 24px
```

### Landing Page
```yaml
Mobile Style: Overlay
Hamburger Icon: X
Icon Size: 36px
```

---

## 🧪 Testing de Estilos Móviles

### Checklist de Pruebas

- [ ] El icono de hamburguesa aparece correctamente
- [ ] Al hacer clic, el panel se abre
- [ ] El contenido es visible y legible
- [ ] Los enlaces son clickeables
- [ ] El panel se cierra al hacer clic fuera
- [ ] El panel se cierra al hacer clic en el icono
- [ ] No hay iconos duplicados
- [ ] Las animaciones son suaves
- [ ] El scroll funciona correctamente (si aplica)
- [ ] El overlay aparece (para Drawer y Overlay)

### Dispositivos a Probar

- iPhone (375px)
- iPad (768px)
- Android móvil (360px)
- Android tablet (1024px)

---

## 🐛 Troubleshooting de Estilos Móviles

### "El icono no aparece"
**Solución:**
1. Verifica que el breakpoint es correcto
2. Redimensiona la ventana del navegador
3. Limpia la caché del navegador (Ctrl+F5)

### "El panel no se abre"
**Solución:**
1. Verifica que el JavaScript se carga correctamente
2. Abre la consola del navegador (F12) y busca errores
3. Verifica que el CSS móvil se carga

### "Hay iconos duplicados"
**Solución:**
1. Verifica que el archivo `mobile-fix.css` se carga
2. Limpia la caché del navegador
3. Verifica que no hay CSS personalizado que interfiera

### "El contenido no se ve bien"
**Solución:**
1. Verifica que el estilo móvil es correcto
2. Ajusta el padding y spacing en los ajustes
3. Verifica que el contenido de Divi se renderiza correctamente

---

## 🎉 Conclusión

El plugin TCB MegaMenu ofrece 4 estilos de menú móvil y 5 iconos de hamburguesa personalizables. Cada estilo tiene sus propias ventajas y casos de uso ideales.

**Recomendación general:**
- Para la mayoría de sitios: **Accordion** con icono **Classic**
- Para e-commerce: **Drawer** con icono **Classic**
- Para portfolios creativos: **Overlay** con icono **Dots**

**¡Experimenta con todas las combinaciones y encuentra la perfecta para tu sitio!** 🎨

---

**Versión del documento:** 1.0  
**Fecha:** 2024  
**Plugin:** TCB MegaMenu v1.3.5
