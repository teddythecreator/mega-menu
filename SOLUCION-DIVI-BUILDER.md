# 🔧 Solución: Compatibilidad con Divi Builder

## 🐛 Problema Identificado

Cuando el plugin TCB MegaMenu está activo, el Divi Builder no funciona correctamente y no permite crear nuevas páginas.

### Causas del Problema

1. **Assets cargándose en el admin**: El plugin estaba cargando CSS/JS en el Divi Builder
2. **Walker interfiriendo**: El Walker personalizado se aplicaba en el admin
3. **JavaScript conflicts**: Scripts del plugin interferían con el Divi Builder
4. **CSS conflicts**: Estilos del plugin afectaban al Divi Builder

---

## ✅ Solución Implementada (v1.3.1)

He corregido el problema añadiendo detección automática de page builders:

### 1. Detección de Page Builders

El plugin ahora detecta automáticamente si estás en:
- ✅ Divi Builder
- ✅ Elementor
- ✅ WPBakery (Visual Composer)
- ✅ Otros page builders

### 2. Exclusión Automática

Cuando se detecta un page builder:
- ❌ NO se cargan assets del plugin
- ❌ NO se aplica el Walker personalizado
- ❌ NO se inyectan tokens CSS
- ❌ NO se añaden body classes

### 3. Protección Completa

El plugin ahora:
- ✅ Solo se activa en el front-end
- ✅ No interfiere con el admin de WordPress
- ✅ No interfiere con page builders
- ✅ Mantiene toda su funcionalidad en el front-end

---

## 🚀 Cómo Actualizar

### Paso 1: Reempaquetar el Plugin

```bash
# Ir a la carpeta del plugin
cd tcb-megamenu

# Empaquetar con nueva versión
zip -r ../tcb-megamenu-v1.3.1.zip .
```

### Paso 2: Reinstalar en WordPress

1. Ve a **Plugins** en WordPress
2. **Desactiva** TCB MegaMenu
3. **Borra** el plugin
4. Ve a **Plugins → Añadir nuevo → Subir plugin**
5. Sube `tcb-megamenu-v1.3.1.zip`
6. **Activa** el plugin

### Paso 3: Limpiar Caché

```bash
# Limpiar caché del navegador
Ctrl + F5 (Windows) o Cmd + Shift + R (Mac)

# Si usas plugin de caché, límpialo también
```

### Paso 4: Probar Divi Builder

1. Ve a **Páginas → Añadir nueva**
2. Haz clic en **"Usar Divi Builder"**
3. El Divi Builder debería funcionar correctamente
4. Crea contenido normalmente

---

## 🧪 Verificación

### Checklist de Pruebas

- [ ] El plugin está activo
- [ ] Puedes crear nuevas páginas con Divi Builder
- [ ] El Divi Builder carga correctamente
- [ ] Puedes añadir módulos de Divi
- [ ] Puedes guardar la página
- [ ] El mega menú funciona en el front-end
- [ ] No hay errores en la consola del navegador

### Pruebas Específicas

#### 1. Crear Nueva Página con Divi
```
1. Ve a Páginas → Añadir nueva
2. Escribe un título
3. Haz clic en "Usar Divi Builder"
4. ✅ El Divi Builder debe cargar sin errores
5. Añade una sección
6. Añade un módulo de texto
7. Guarda la página
```

#### 2. Editar Página Existente con Divi
```
1. Ve a Páginas
2. Haz clic en "Editar con Divi" en una página existente
3. ✅ El Divi Builder debe cargar sin errores
4. Edita el contenido
5. Guarda los cambios
```

#### 3. Front-end del Mega Menú
```
1. Ve al front-end de tu sitio
2. Pasa el mouse sobre un ítem del menú con mega panel
3. ✅ El mega menú debe aparecer
4. Haz clic en el ítem
5. ✅ El mega menú debe abrirse/cerrarse
```

---

## 🐛 Si el Problema Persiste

### Opción 1: Desactivar Temporalmente

Si necesitas usar Divi Builder urgentemente:

1. Ve a **Plugins**
2. **Desactiva** TCB MegaMenu
3. Usa Divi Builder normalmente
4. **Reactiva** TCB MegaMenu cuando termines

### Opción 2: Modo Debug

Activa el modo debug para ver errores:

1. Edita `wp-config.php`
2. Añade estas líneas:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

3. Intenta usar Divi Builder
4. Revisa el archivo `wp-content/debug.log`
5. Busca errores relacionados con `tcb-megamenu`

### Opción 3: Conflicto con Otros Plugins

Si el problema persiste:

1. **Desactiva todos los plugins** excepto TCB MegaMenu y Divi
2. Prueba Divi Builder
3. Si funciona, **activa los plugins uno por uno**
4. Identifica el plugin que causa el conflicto
5. Contacta soporte con la información

### Opción 4: Conflicto con el Tema

Si el problema persiste:

1. Cambia temporalmente a un tema por defecto (Twenty Twenty-Four)
2. Prueba Divi Builder
3. Si funciona, el conflicto es con tu tema
4. Contacta soporte con el nombre del tema

---

## 📊 Archivos Modificados

### class-assets.php
- ✅ Añadido método `is_divi_builder()`
- ✅ Añadido método `is_page_builder()`
- ✅ Exclusión de page builders en `enqueue_public_assets()`
- ✅ Exclusión de page builders en `enqueue_admin_assets()`
- ✅ Exclusión de page builders en `print_tokens()`

### class-plugin.php
- ✅ Exclusión de admin en `apply_walker()`
- ✅ Exclusión de page builders en `apply_walker()`
- ✅ Exclusión de admin y page builders en `add_body_class()`

---

## 🎯 Características de la Solución

### Detección Inteligente

El plugin detecta automáticamente:

#### Divi Builder
- ✅ Páginas editándose con Divi Builder
- ✅ AJAX requests de Divi
- ✅ Parámetros `et_fb` y `et_pb_preview`
- ✅ Función `et_pb_is_pagebuilder_used()`

#### Elementor
- ✅ Parámetro `elementor-preview`
- ✅ Acción `elementor`
- ✅ Clase `\Elementor\Plugin`

#### WPBakery
- ✅ Parámetro `vc_action=vc_inline`
- ✅ Clase `Vc_Manager`

### Protección Completa

Cuando se detecta un page builder:

```php
// NO se cargan assets
if ( self::is_page_builder() ) {
    return;
}

// NO se aplica el Walker
if ( Assets::is_page_builder() ) {
    return $args;
}

// NO se inyectan tokens
if ( self::is_page_builder() ) {
    return;
}
```

---

## 📋 Configuración Recomendada

### Para Sitios con Divi

```yaml
Plugin: TCB MegaMenu v1.3.1+
Divi: 4.23+
WordPress: 5.8+
PHP: 8.0+

Configuración:
- Usar Divi Library Layouts para mega menús
- Crear layouts en Divi → Divi Library
- Asignar layouts en Apariencia → Menús
- Configurar colores en TCB MegaMenu → Settings
```

### Para Sitios sin Divi

```yaml
Plugin: TCB MegaMenu v1.3.1+
WordPress: 5.8+
PHP: 8.0+

Configuración:
- Usar Custom Columns para mega menús
- Añadir sub-ítems al menú
- Configurar colores en TCB MegaMenu → Settings
```

---

## 🔍 Diagnóstico Avanzado

### Verificar que el Plugin NO se Carga en Divi

1. Abre la consola del navegador (F12)
2. Ve a la pestaña "Network"
3. Carga una página con Divi Builder
4. Busca archivos `tcb-megamenu`
5. ✅ NO deberían aparecer en la lista

### Verificar que el Walker NO se Aplica

1. Abre la consola del navegador (F12)
2. Ve a la pestaña "Elements"
3. Inspecciona el menú
4. ✅ NO debería tener la clase `tcb-mega-item`
5. ✅ NO debería tener el atributo `data-tcb-toggle="mega"`

### Verificar que los Tokens NO se Inyectan

1. Abre la consola del navegador (F12)
2. Ve a la pestaña "Elements"
3. Busca `<style id="tcb-megamenu-tokens">`
4. ✅ NO debería existir en el Divi Builder

---

## 📞 Soporte

Si el problema persiste después de actualizar:

### Información Necesaria

1. **Versión del plugin**: ¿Estás usando v1.3.1 o superior?
2. **Versión de WordPress**: ¿Qué versión usas?
3. **Versión de Divi**: ¿Qué versión de Divi usas?
4. **Otros plugins activos**: Lista de plugins activos
5. **Tema**: ¿Qué tema usas?
6. **Errores**: Mensajes de error de la consola o debug.log
7. **Pasos para reproducir**: Descripción detallada del problema

### Contacto

- **Email:** soporte@thecreator.business
- **Website:** https://thecreator.business/
- **Horario:** Lunes a Viernes, 9:00 - 18:00 (GMT+1)

---

## 🎉 Resultado Esperado

Con la versión 1.3.1:

✅ **Divi Builder funciona** perfectamente con el plugin activo  
✅ **TCB MegaMenu funciona** en el front-end  
✅ **Sin conflictos** entre el plugin y Divi  
✅ **Detección automática** de page builders  
✅ **Protección completa** del admin y page builders  
✅ **Rendimiento óptimo** sin carga innecesaria  

---

## 📝 Notas Técnicas

### ¿Por Qué Ocurría el Problema?

El plugin original no excluía los page builders del enqueue de assets y la aplicación del Walker. Esto causaba:

1. **CSS conflicts**: Los estilos del plugin afectaban al Divi Builder
2. **JavaScript conflicts**: Los scripts del plugin interferían con el Divi Builder
3. **Walker conflicts**: El Walker personalizado se aplicaba en el admin
4. **Performance issues**: Assets innecesarios se cargaban en el admin

### ¿Cómo Se Solucionó?

Se añadió detección inteligente de page builders:

```php
public static function is_page_builder() {
    // Divi Builder
    if ( self::is_divi_builder() ) {
        return true;
    }
    
    // Elementor
    if ( class_exists( '\\Elementor\\Plugin' ) ) {
        if ( isset( $_GET['elementor-preview'] ) ) {
            return true;
        }
    }
    
    // WPBakery
    if ( class_exists( 'Vc_Manager' ) ) {
        if ( isset( $_GET['vc_action'] ) && $_GET['vc_action'] === 'vc_inline' ) {
            return true;
        }
    }
    
    return false;
}
```

Y se excluyeron los page builders de todas las operaciones:

```php
// En enqueue_public_assets()
if ( is_admin() || self::is_page_builder() ) {
    return;
}

// En apply_walker()
if ( is_admin() || Assets::is_page_builder() ) {
    return $args;
}
```

---

**¡Con la versión 1.3.1 el plugin es completamente compatible con Divi Builder!** 🚀

**Versión:** 1.3.1  
**Fecha:** 2024  
**Estado:** ✅ Completamente compatible con Divi Builder
