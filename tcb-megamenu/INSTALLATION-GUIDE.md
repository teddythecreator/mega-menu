# 📖 Guía de Instalación - TCB MegaMenu

## 🚀 Instalación Rápida (2 minutos)

### Paso 1: Subir el Plugin

1. Ve a **Plugins → Añadir nuevo → Subir plugin**
2. Selecciona el archivo `tcb-megamenu.zip`
3. Haz clic en **Instalar ahora**
4. Haz clic en **Activar plugin**

**¡Listo!** El plugin funciona automáticamente sin necesidad de código adicional.

---

## ⚙️ Configuración Inicial

### 1. Configurar Ajustes Globales

1. Ve a **TCB MegaMenu → Settings** en el menú principal
2. Configura las siguientes secciones:

#### Colors
- **Background Color**: Color de fondo del panel (ej: `#ffffff`)
- **Text Color**: Color del texto (ej: `#333333`)
- **Accent Color**: Color de acento para hover y badges (ej: `#e11414`)

#### Layout
- **Border Radius**: Redondez de esquinas (ej: `10px`)
- **Gap/Spacing**: Espaciado entre elementos (ej: `32px`)

#### Desktop Behavior
- **Hover In Delay**: Tiempo antes de abrir el panel (ej: `120` ms)
- **Hover Out Delay**: Tiempo antes de cerrar el panel (ej: `200` ms)

#### Mobile Settings
- **Mobile Breakpoint**: Ancho donde se activa el modo móvil (ej: `980` px)
- **Mobile Menu Style**: Estilo del menú móvil
  - **Accordion**: Panel vertical (recomendado)
  - **Drawer**: Panel lateral deslizante
  - **Overlay**: Panel a pantalla completa
  - **Slide**: Panel que se desliza desde arriba

#### Hamburger Icon
- **Icon Style**: Estilo del icono
  - **Classic**: Tres líneas (☰)
  - **Arrow**: Flechas (←)
  - **Dots**: Tres puntos (⋮)
  - **Plus**: Más/menos (+)
  - **X**: Marca X (✕)
- **Icon Color**: Color del icono (ej: `#333333`)
- **Icon Size**: Tamaño del icono (ej: `24` px)
- **Line Thickness**: Grosor de las líneas (ej: `2` px)

3. Haz clic en **Save Changes**

---

## 🎯 Crear tu Primer Mega Menú

### Opción A: Usando Divi Library Layouts

1. **Crear un Layout en Divi**
   - Ve a **Divi → Divi Library**
   - Haz clic en **Add New Layout**
   - Diseña tu mega menú con secciones, filas y módulos
   - Guarda el layout

2. **Asignar el Layout al Menú**
   - Ve a **Apariencia → Menús**
   - Crea o edita un menú
   - Expande el ítem del menú que quieres convertir en mega menú
   - Marca **"Enable Mega Panel"**
   - En **Content Source**, selecciona **Divi Library Layout**
   - En **Select Divi Layout**, elige el layout que creaste
   - Configura **Panel Width** (Full, Container, Custom)
   - Configura **Panel Alignment** (Left, Center, Right)
   - Opcionalmente, añade un **Badge** (ej: "Nuevo", "Oferta")
   - Guarda el menú

### Opción B: Usando Columnas Personalizadas (sin Divi)

1. **Crear el Menú**
   - Ve a **Apariencia → Menús**
   - Crea o edita un menú
   - Añade el ítem principal (ej: "Servicios")
   - Añade sub-ítems debajo del ítem principal
   - Arrastra los sub-ítems ligeramente a la derecha para anidarlos

2. **Activar Mega Panel**
   - Expande el ítem principal
   - Marca **"Enable Mega Panel"**
   - En **Content Source**, selecciona **Custom Columns (no Divi)**
   - Configura **Panel Width** y **Panel Alignment**
   - Guarda el menú

Los sub-ítems se organizarán automáticamente en columnas.

---

## 📱 Probar el Menú Móvil

1. Redimensiona la ventana del navegador a menos del breakpoint configurado (por defecto 980px)
2. Deberías ver el icono de hamburguesa junto a cada mega ítem
3. Haz clic en el icono de hamburguesa
4. El menú debería desplegarse como acordeón (o el estilo que configuraste)
5. Verifica que no hay iconos duplicados
6. Verifica que los enlaces son clickeables

---

## 🖥️ Probar el Menú Desktop

1. Redimensiona la ventana del navegador a más del breakpoint configurado
2. Pasa el mouse sobre un mega ítem
3. El panel debería desplegarse automáticamente
4. Verifica que el contenido se muestra correctamente
5. Verifica que los enlaces son clickeables
6. Mueve el mouse fuera del panel - debería cerrarse automáticamente

---

## 🔧 Solución de Problemas

### El menú no aparece en el frontend

**Causa:** El menú no está asignado a una ubicación del tema

**Solución:**
1. Ve a **Apariencia → Menús**
2. En la parte inferior, busca **"Ubicación del tema"**
3. Marca la ubicación donde quieres que aparezca el menú (ej: "Primary Menu")
4. Guarda los cambios

### Los ajustes no se guardan

**Causa:** Problema con el formulario de ajustes

**Solución:**
1. Ve a **TCB MegaMenu → Settings**
2. Verifica que puedes cambiar los valores
3. Haz clic en **Save Changes**
4. Recarga la página
5. Verifica que los cambios se mantuvieron

Si el problema persiste:
1. Desactiva el plugin
2. Activa el plugin
3. Intenta guardar los ajustes nuevamente

### El menú móvil no funciona

**Causa:** El breakpoint no coincide con tu tema

**Solución:**
1. Ve a **TCB MegaMenu → Settings → Mobile Settings**
2. Ajusta el **Mobile Breakpoint** para que coincida con tu tema
3. Guarda los cambios
4. Limpia la caché del navegador (Ctrl+F5)
5. Redimensiona la ventana para probar

### El contenido de Divi no se muestra

**Causa:** Divi no está activo o el layout no existe

**Solución:**
1. Verifica que Divi theme o Divi Builder está activo
2. Verifica que el layout existe en **Divi → Divi Library**
3. Verifica que el layout está seleccionado en el metabox del menú
4. Verifica que el layout tiene contenido

### Los iconos duplicados aparecen en móvil

**Causa:** El CSS móvil no se carga correctamente

**Solución:**
1. Limpia la caché del navegador (Ctrl+F5)
2. Verifica que el archivo `mobile-fix.css` existe en `wp-content/plugins/tcb-megamenu/assets/css/`
3. Abre la consola del navegador (F12) y verifica que no hay errores 404

---

## 📋 Checklist de Verificación

Antes de considerar la instalación completa, verifica:

- [ ] El plugin está activo
- [ ] Los ajustes se guardan correctamente
- [ ] El menú está asignado a una ubicación del tema
- [ ] Al menos un ítem tiene "Enable Mega Panel" activado
- [ ] El contenido del panel se muestra en desktop
- [ ] El menú móvil funciona correctamente
- [ ] No hay iconos duplicados en móvil
- [ ] Los enlaces son clickeables
- [ ] Las animaciones funcionan suavemente

---

## 🎓 Consejos Avanzados

### Usar Múltiples Mega Menús

Puedes tener múltiples mega menús en el mismo menú:
1. Activa "Enable Mega Panel" en varios ítems padre
2. Cada ítem puede tener su propio layout o columnas
3. Solo un panel se abre a la vez

### Personalizar con CSS Adicional

Puedes añadir CSS personalizado en **Apariencia → Personalizar → CSS adicional**:

```css
/* Cambiar el color del badge */
.tcb-badge {
    background: #ff6b6b !important;
}

/* Aumentar el espaciado entre columnas */
.tcb-columns {
    gap: 40px !important;
}

/* Cambiar la animación */
.tcb-panel {
    transition-duration: 0.4s !important;
}
```

### Usar con WooCommerce

El plugin es compatible con WooCommerce:
- Puedes crear mega menús para categorías de productos
- Usa layouts de Divi para mostrar productos destacados
- Funciona con el menú de la tienda

---

## 📞 Soporte

Si necesitas ayuda:

- **Email:** soporte@thecreator.business
- **Website:** https://thecreator.business/
- **Horario:** Lunes a Viernes, 9:00 - 18:00 (GMT+1)

Incluye en tu mensaje:
- Versión de WordPress
- Versión del plugin
- Tema activo
- Descripción detallada del problema
- Capturas de pantalla si es posible

---

## 🎉 ¡Felicidades!

Ahora tienes un mega menú profesional funcionando en tu sitio WordPress. Disfruta de la experiencia de usuario mejorada y la integración perfecta con Divi.

**¡Gracias por usar TCB MegaMenu!** 🚀
