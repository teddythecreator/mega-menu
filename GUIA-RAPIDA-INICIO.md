# 🚀 Guía Rápida de Inicio — TBMX Mega Menu

> **Tiempo estimado:** 5 minutos
> **Requisito:** Plugin ya instalado y activo en tu WordPress local

---

## Paso 0: Verificar que el plugin está activo

1. Ve a **Plugins** en el menú lateral de WordPress
2. Busca **"TBMX Mega Menu"** en la lista
3. Asegúrate de que aparece como **"Activado"** (en azul)

Si no está activado, haz clic en **"Activar"**.

Al activarlo verás dos cosas nuevas:
- ✅ Una entrada **"TBMX Mega Menu"** bajo el menú **Apariencia**
- ✅ Nuevos campos en los ítems de menú (Apariencia → Menús)

---

## Paso 1: Configurar los ajustes globales (opcional pero recomendado)

1. Ve a **Apariencia → TBMX Mega Menu**
2. Verás la página de ajustes con 4 secciones

### Opción rápida: Aplicar un preset

Si no quieres personalizar colores manualmente:

1. Baja hasta la sección **"Style Presets"**
2. Selecciona uno de los 3 presets:
   - **Oscuro** — Fondo negro, texto blanco, rojo de marca
   - **Claro** — Fondo claro, texto oscuro, rojo de marca
   - **Minimal** — Fondo gris, texto negro, esquinas cuadradas
3. Haz clic en **"Guardar cambios"** (abajo del todo)

¡Listo! Los colores se aplicarán automáticamente.

### Opción personalizada: Elegir tus propios colores

1. En la sección **"Colors"**, haz clic en cada color picker
2. Elige los colores que quieras:
   - **Background Color** → Fondo del panel del mega menú
   - **Text Color** → Color del texto
   - **Accent Color** → Color de acento (enlaces al pasar el mouse, badges)
3. Haz clic en **"Guardar cambios"**

---

## Paso 2: Crear un menú (si aún no tienes uno)

1. Ve a **Apariencia → Menús**
2. Si no tienes un menú:
   - Escribe un nombre (ej: "Menú Principal")
   - Haz clic en **"Crear menú"**
3. Añade algunos ítems al menú desde la columna izquierda:
   - Páginas, categorías, enlaces personalizados, etc.
4. En **"Ubicación del tema"**, marca la ubicación donde quieres que aparezca (ej: "Primary Menu")
5. Haz clic en **"Guardar menú"**

---

## Paso 3: Activar el mega menú en un ítem

Este es el paso clave. Vamos a convertir un ítem de menú en un mega menú.

### 3.1 Abre el ítem de menú

1. En la página de Menús, busca el ítem que quieres convertir
2. Haz clic en la **flecha ▼** a la derecha del ítem para desplegarlo
3. Verás los campos habituales (URL, Título, etc.)
4. **Desplázate hacia abajo** — verás una nueva sección con fondo gris: **"TBMX Mega Menu"**

### 3.2 Activa el mega panel

1. Marca la casilla **"☑ Enable Mega Panel"**
2. Automáticamente se desplegarán más campos:
   - Content Source
   - Panel Width
   - Panel Alignment
   - Icon (opcional)
   - Badge (opcional)

### 3.3 Elige el contenido del panel

Tienes **2 opciones**:

---

#### OPCIÓN A: Usar un layout de Divi (si tienes Divi)

1. En **"Content Source"**, selecciona **"Divi Library Layout"**
2. En **"Select Divi Layout"**, elige el layout que diseñaste

**¿No tienes ningún layout?** Créalo así:

1. Ve a **Divi → Divi Library**
2. Haz clic en **"Add New Layout"**
3. Dale un nombre (ej: "Mega Menu - Servicios")
4. Diseña tu layout con el Divi Builder:
   - Añade una fila (Row) a ancho completo
   - Divide en columnas (ej: 4 columnas de 1/4)
   - Añade módulos: texto, enlaces, imágenes, botones
5. Guarda el layout
6. Vuelve a **Apariencia → Menús**
7. Selecciona tu nuevo layout en el dropdown

---

#### OPCIÓN B: Usar columnas de enlaces (sin Divi)

1. En **"Content Source"**, selecciona **"Custom Columns (no Divi)"**
2. Ahora necesitas añadir **sub-ítems** al menú:
   - En la página de Menús, añade nuevos ítems (páginas, enlaces, etc.)
   - **Arrástralos ligeramente a la derecha** debajo del ítem padre
   - O al añadir un ítem, selecciona el padre en el dropdown
3. Los sub-ítems se mostrarán automáticamente en columnas

**Ejemplo:**
```
Servicios (mega panel activado) ← padre
├── Diseño Web                  ← sub-ítem (columna 1)
├── Desarrollo                  ← sub-ítem (columna 1)
├── SEO                         ← sub-ítem (columna 2)
├── Marketing                   ← sub-ítem (columna 2)
└── Consultoría                 ← sub-ítem (columna 3)
```

### 3.4 Configura el ancho y alineación (opcional)

- **Panel Width**:
  - **Full Width** → El panel ocupa todo el ancho de la pantalla
  - **Container Width** → Limitado al ancho del contenedor del tema
  - **Custom Width** → Ancho personalizado en píxeles
- **Panel Alignment**: Left / Center / Right

### 3.5 Añade un badge (opcional)

Si quieres una etiqueta pequeña junto al ítem del menú (ej: "Nuevo", "Oferta"):

1. En el campo **"Badge"**, escribe el texto
2. Se mostrará como una etiqueta roja junto al nombre del ítem

### 3.6 Guarda el menú

Haz clic en **"Guardar menú"** (botón azul abajo a la derecha).

---

## Paso 4: Ver el resultado en el front-end

1. Abre tu sitio web en el navegador
2. Pasa el mouse sobre el ítem del menú que configuraste
3. **¡Debería aparecer el mega menú!** 🎉

### ¿Qué deberías ver?

**En desktop:**
- Un panel que se despliega al pasar el mouse
- Con el contenido del layout de Divi O las columnas de enlaces
- Con los colores que configuraste
- Con animación suave de entrada

**En móvil (< 980px):**
- Redimensiona la ventana del navegador
- El mega menú se convierte en un acordeón
- Toca el ítem para abrirlo/cerrarlo

---

## Paso 5: Probar la interacción

### En desktop:
- **Hover**: Pasa el mouse sobre el ítem → se abre el panel
- **Click**: Haz clic en el ítem → se abre/cierra el panel
- **Teclado**: Navega con Tab, abre con Enter/Space, cierra con Esc
- **Cerrar**: Haz clic fuera del panel o pulsa Esc

### En móvil:
- **Tap**: Toca el ítem → se abre el acordeón
- **Cerrar**: Toca de nuevo o toca otro ítem

---

## 🐛 Solución de problemas comunes

### "No veo los campos del mega menú en los ítems"

**Causa:** El plugin no está activo.
**Solución:** Ve a Plugins y activa "TBMX Mega Menu".

### "El mega menú no aparece en el front-end"

**Posibles causas:**

1. **No guardaste el menú** → Haz clic en "Guardar menú"
2. **El menú no está asignado a una ubicación** → En "Ubicación del tema", marca la ubicación correcta
3. **No activaste "Enable Mega Panel"** → Verifica que la casilla está marcada
4. **No seleccionaste un layout** → Si usas Divi, asegúrate de elegir un layout

### "El layout de Divi no se renderiza"

**Causa:** Divi no está activo.
**Solución:** Activa el tema Divi o el plugin Divi Builder. Si no tienes Divi, usa la opción "Custom Columns".

### "Los colores no se aplican"

**Causa:** Caché del navegador o del plugin de caché.
**Solución:** 
- Limpia la caché del navegador (Ctrl+F5 o Cmd+Shift+R)
- Si usas WP Rocket, W3 Total Cache, etc., limpia la caché del plugin

### "El mega menú se ve raro en móvil"

**Causa:** El breakpoint no coincide con tu tema.
**Solución:** Ve a Apariencia → TBMX Mega Menu → Behavior → ajusta el "Mobile Breakpoint" (por defecto 980px).

---

## 📋 Checklist rápido

Antes de dar por terminado, verifica:

- [ ] El plugin está activo
- [ ] Los ajustes globales están configurados (o usaste un preset)
- [ ] Creaste un menú con al menos un ítem padre
- [ ] Activaste "Enable Mega Panel" en el ítem padre
- [ ] Seleccionaste un layout de Divi O añadiste sub-ítems
- [ ] Guardaste el menú
- [ ] El menú está asignado a una ubicación del tema
- [ ] El mega menú aparece en el front-end al pasar el mouse
- [ ] Funciona en móvil (acordeón)

---

## 🎯 Ejemplo completo paso a paso

Vamos a crear un mega menú completo de ejemplo:

### 1. Configura los ajustes
- Ve a **Apariencia → TBMX Mega Menu**
- Selecciona el preset **"Oscuro"**
- Guarda cambios

### 2. Crea el menú
- Ve a **Apariencia → Menús**
- Crea un menú llamado "Principal"
- Añade estos ítems:
  - **Inicio** (página)
  - **Servicios** (enlace personalizado: #)
  - **Blog** (página)
  - **Contacto** (página)
- Asigna el menú a "Primary Menu"
- Guarda

### 3. Añade sub-ítems a "Servicios"
- Añade estos ítems como sub-ítems de "Servicios":
  - Diseño Web
  - Desarrollo
  - SEO
  - Marketing Digital
  - Consultoría
- Arrástralos debajo de "Servicios" y ligeramente a la derecha
- Guarda

### 4. Activa el mega panel en "Servicios"
- Despliega el ítem "Servicios"
- Marca **"Enable Mega Panel"**
- En **Content Source**, selecciona **"Custom Columns (no Divi)"**
- En **Panel Width**, selecciona **"Container Width"**
- En **Badge**, escribe **"Nuevo"**
- Guarda el menú

### 5. Verifica en el front-end
- Abre tu sitio
- Pasa el mouse sobre "Servicios"
- Deberías ver un panel con 3 columnas de enlaces y un badge "Nuevo"
- Redimensiona la ventana y verifica que funciona en móvil

---

## 📚 Más información

- **Guía completa de usuario:** `USER-GUIDE.md`
- **Checklist de pruebas:** `QA-CHECKLIST.md`
- **Changelog:** `CHANGELOG.md`
- **Documento maestro:** Web interactiva del proyecto

---

## 💡 Consejos

1. **Empieza simple:** Usa "Custom Columns" primero, luego prueba con layouts de Divi
2. **Usa un preset:** Los presets te dan un resultado profesional inmediato
3. **Prueba en móvil:** Redimensiona la ventana para ver el modo acordeón
4. **Usa el teclado:** Prueba Tab, Enter, Esc para verificar accesibilidad
5. **Guarda frecuentemente:** No olvides guardar el menú después de cada cambio

---

**¿Todo funciona? ¡Felicidades! Tu mega menú está listo.** 🎉

**¿Problemas?** Revisa la sección de solución de problemas o consulta la guía completa de usuario.
