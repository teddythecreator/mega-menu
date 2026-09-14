<?php
/**
 * TCB MegaMenu - Debug Frontend
 * 
 * Este archivo te ayuda a diagnosticar por qué el mega menú no funciona en el frontend.
 * 
 * USO:
 * 1. Abre este archivo en tu navegador: http://tu-sitio.local/wp-content/plugins/tcb-megamenu/debug-frontend.php
 * 2. Revisa los resultados
 * 3. Copia la información y envíala para soporte
 */

// Cargar WordPress
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';

// Verificar permisos
if (!current_user_can('manage_options')) {
    die('Acceso denegado. Solo administradores pueden acceder a esta página.');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCB MegaMenu - Debug Frontend</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f0f0f1;
        }
        .debug-section {
            background: white;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .debug-section h2 {
            margin-top: 0;
            color: #23282d;
            border-bottom: 1px solid #ccd0d4;
            padding-bottom: 10px;
        }
        .status-ok {
            color: #46b450;
            font-weight: bold;
        }
        .status-error {
            color: #dc3232;
            font-weight: bold;
        }
        .status-warning {
            color: #ffb900;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccd0d4;
        }
        table th {
            background: #f1f1f1;
            font-weight: 600;
        }
        code {
            background: #f1f1f1;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 10px 0;
        }
        .error-box {
            background: #ffe7e7;
            border-left: 4px solid #dc3232;
            padding: 15px;
            margin: 10px 0;
        }
        .warning-box {
            background: #fff7e7;
            border-left: 4px solid #ffb900;
            padding: 15px;
            margin: 10px 0;
        }
        pre {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>🔍 TCB MegaMenu - Debug Frontend</h1>
    
    <?php
    // 1. Verificar que el plugin está activo
    echo '<div class="debug-section">';
    echo '<h2>1. Estado del Plugin</h2>';
    
    if (is_plugin_active('tcb-megamenu/tcb-megamenu.php')) {
        echo '<p class="status-ok">✓ El plugin está activo</p>';
    } else {
        echo '<p class="status-error">✗ El plugin NO está activo</p>';
    }
    
    echo '<p><strong>Versión del Plugin:</strong> ' . TCB_MEGAMENU_VERSION . '</p>';
    echo '</div>';
    
    // 2. Verificar configuración
    echo '<div class="debug-section">';
    echo '<h2>2. Configuración del Plugin</h2>';
    
    $settings = get_option('tcb_megamenu_settings');
    if ($settings) {
        echo '<p class="status-ok">✓ La configuración existe</p>';
        echo '<table>';
        echo '<tr><th>Opción</th><th>Valor</th></tr>';
        foreach ($settings as $key => $value) {
            echo '<tr><td><code>' . esc_html($key) . '</code></td><td>' . esc_html(is_array($value) ? json_encode($value) : $value) . '</td></tr>';
        }
        echo '</table>';
    } else {
        echo '<p class="status-error">✗ No hay configuración guardada</p>';
    }
    echo '</div>';
    
    // 3. Verificar menús y ubicaciones
    echo '<div class="debug-section">';
    echo '<h2>3. Menús y Ubicaciones</h2>';
    
    $locations = get_nav_menu_locations();
    if (empty($locations)) {
        echo '<p class="status-error">✗ No hay ubicaciones de menú asignadas</p>';
        echo '<div class="error-box">';
        echo '<strong>Problema:</strong> El tema no tiene ubicaciones de menú configuradas.<br>';
        echo '<strong>Solución:</strong> Ve a Apariencia → Menús y asigna un menú a una ubicación del tema.';
        echo '</div>';
    } else {
        echo '<p class="status-ok">✓ Hay ' . count($locations) . ' ubicación(es) de menú</p>';
        echo '<table>';
        echo '<tr><th>Ubicación</th><th>Menú Asignado</th><th>ID del Menú</th><th>¿Tiene Mega Items?</th></tr>';
        
        foreach ($locations as $location => $menu_id) {
            $menu = wp_get_nav_menu_object($menu_id);
            $menu_name = $menu ? $menu->name : 'No encontrado';
            $has_mega = TCB_MegaMenu\Assets::menu_has_mega_items($menu_id);
            
            echo '<tr>';
            echo '<td><code>' . esc_html($location) . '</code></td>';
            echo '<td>' . esc_html($menu_name) . '</td>';
            echo '<td>' . esc_html($menu_id) . '</td>';
            echo '<td>' . ($has_mega ? '<span class="status-ok">✓ Sí</span>' : '<span class="status-warning">✗ No</span>') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    echo '</div>';
    
    // 4. Verificar mega items
    echo '<div class="debug-section">';
    echo '<h2>4. Mega Items Configurados</h2>';
    
    global $wpdb;
    $mega_items = $wpdb->get_results("
        SELECT pm.post_id, pm.meta_value, p.post_title, p.post_type
        FROM {$wpdb->postmeta} pm
        JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE pm.meta_key = '_tcb_enabled'
        AND pm.meta_value = '1'
    ");
    
    if (empty($mega_items)) {
        echo '<p class="status-error">✗ No hay mega items configurados</p>';
        echo '<div class="error-box">';
        echo '<strong>Problema:</strong> No hay ítems de menú con mega panel activado.<br>';
        echo '<strong>Solución:</strong> Ve a Apariencia → Menús, edita un menú, y marca "Enable Mega Panel" en al menos un ítem padre.';
        echo '</div>';
    } else {
        echo '<p class="status-ok">✓ Hay ' . count($mega_items) . ' mega item(s) configurado(s)</p>';
        echo '<table>';
        echo '<tr><th>ID</th><th>Título</th><th>Tipo</th><th>Source</th><th>Layout ID</th><th>Width</th></tr>';
        
        foreach ($mega_items as $item) {
            $source = get_post_meta($item->post_id, '_tcb_source', true);
            $layout_id = get_post_meta($item->post_id, '_tcb_layout_id', true);
            $width = get_post_meta($item->post_id, '_tcb_width', true);
            
            echo '<tr>';
            echo '<td>' . esc_html($item->post_id) . '</td>';
            echo '<td>' . esc_html($item->post_title) . '</td>';
            echo '<td>' . esc_html($item->post_type) . '</td>';
            echo '<td><code>' . esc_html($source ?: 'divi_layout') . '</code></td>';
            echo '<td>' . esc_html($layout_id ?: '0') . '</td>';
            echo '<td><code>' . esc_html($width ?: 'full') . '</code></td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    echo '</div>';
    
    // 5. Verificar que los assets se cargan
    echo '<div class="debug-section">';
    echo '<h2>5. Assets del Plugin</h2>';
    
    $assets_to_check = array(
        'megamenu.css' => TCB_MEGAMENU_URL . 'assets/css/megamenu.css',
        'mobile-fix.css' => TCB_MEGAMENU_URL . 'assets/css/mobile-fix.css',
        'megamenu.js' => TCB_MEGAMENU_URL . 'assets/js/megamenu.js',
    );
    
    echo '<table>';
    echo '<tr><th>Archivo</th><th>URL</th><th>Existe</th></tr>';
    
    foreach ($assets_to_check as $name => $url) {
        $file_path = TCB_MEGAMENU_DIR . 'assets/' . (strpos($name, '.css') !== false ? 'css/' : 'js/') . $name;
        $exists = file_exists($file_path);
        
        echo '<tr>';
        echo '<td><code>' . esc_html($name) . '</code></td>';
        echo '<td><a href="' . esc_url($url) . '" target="_blank">' . esc_html($url) . '</a></td>';
        echo '<td>' . ($exists ? '<span class="status-ok">✓ Sí</span>' : '<span class="status-error">✗ No</span>') . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
    
    // 6. Verificar el Walker
    echo '<div class="debug-section">';
    echo '<h2>6. Walker del Menú</h2>';
    
    echo '<p><strong>Clase del Walker:</strong> <code>TCB_MegaMenu\\Menu_Walker</code></p>';
    
    if (class_exists('TCB_MegaMenu\\Menu_Walker')) {
        echo '<p class="status-ok">✓ La clase del Walker existe</p>';
    } else {
        echo '<p class="status-error">✗ La clase del Walker NO existe</p>';
    }
    
    echo '<h3>Probar Walker Manualmente</h3>';
    echo '<p>Para probar si el Walker funciona, añade este código temporalmente a tu tema (functions.php):</p>';
    echo '<pre>';
    echo htmlspecialchars('
add_filter("wp_nav_menu_args", function($args) {
    // Reemplaza "primary" con la ubicación de tu menú
    if (isset($args["theme_location"]) && $args["theme_location"] === "primary") {
        $args["walker"] = new TCB_MegaMenu\\Menu_Walker();
    }
    return $args;
});
    ');
    echo '</pre>';
    echo '</div>';
    
    // 7. Verificar compatibilidad con Divi
    echo '<div class="debug-section">';
    echo '<h2>7. Compatibilidad con Divi</h2>';
    
    if (function_exists('et_setup_theme')) {
        echo '<p class="status-ok">✓ Divi theme está activo</p>';
    } else {
        echo '<p class="status-warning">⚠ Divi theme NO está activo</p>';
    }
    
    if (defined('ET_BUILDER_PLUGIN_VERSION')) {
        echo '<p class="status-ok">✓ Divi Builder plugin está activo</p>';
    }
    
    if (TCB_MegaMenu\Renderer::is_divi_active()) {
        echo '<p class="status-ok">✓ Divi está disponible para renderizar layouts</p>';
    } else {
        echo '<p class="status-warning">⚠ Divi NO está disponible (usando modo columnas)</p>';
    }
    echo '</div>';
    
    // 8. Información del sistema
    echo '<div class="debug-section">';
    echo '<h2>8. Información del Sistema</h2>';
    
    echo '<table>';
    echo '<tr><th>Elemento</th><th>Valor</th></tr>';
    echo '<tr><td>Versión de WordPress</td><td>' . esc_html(get_bloginfo('version')) . '</td></tr>';
    echo '<tr><td>Versión de PHP</td><td>' . esc_html(phpversion()) . '</td></tr>';
    echo '<tr><td>Tema Activo</td><td>' . esc_html(wp_get_theme()->get('Name')) . '</td></tr>';
    echo '<tr><td>URL del Sitio</td><td>' . esc_html(home_url()) . '</td></tr>';
    echo '</table>';
    echo '</div>';
    
    // 9. Soluciones comunes
    echo '<div class="debug-section">';
    echo '<h2>9. Soluciones Comunes</h2>';
    
    echo '<div class="info-box">';
    echo '<h3>Problema: El mega menú no aparece en el frontend</h3>';
    echo '<ol>';
    echo '<li><strong>Verifica que el menú está asignado a una ubicación:</strong> Ve a Apariencia → Menús y asegúrate de que el menú está asignado a una ubicación del tema (ej: "Primary Menu").</li>';
    echo '<li><strong>Verifica que hay mega items configurados:</strong> Edita el menú y marca "Enable Mega Panel" en al menos un ítem padre.</li>';
    echo '<li><strong>Limpia la caché:</strong> Si usas un plugin de caché, límpialo. También limpia la caché del navegador (Ctrl+F5).</li>';
    echo '<li><strong>Verifica que el tema usa wp_nav_menu():</strong> El tema debe usar <code>wp_nav_menu()</code> para mostrar el menú.</li>';
    echo '</ol>';
    echo '</div>';
    
    echo '<div class="info-box">';
    echo '<h3>Problema: El Walker no se aplica</h3>';
    echo '<ol>';
    echo '<li><strong>Añade el filtro manualmente:</strong> Añade el código del Walker manualmente a tu functions.php (ver sección 6).</li>';
    echo '<li><strong>Verifica conflictos:</strong> Desactiva otros plugins temporalmente para verificar si hay un conflicto.</li>';
    echo '<li><strong>Revisa los logs:</strong> Activa WP_DEBUG y revisa wp-content/debug.log para ver si hay errores.</li>';
    echo '</ol>';
    echo '</div>';
    
    echo '<div class="info-box">';
    echo '<h3>Problema: Los assets no se cargan</h3>';
    echo '<ol>';
    echo '<li><strong>Verifica que los archivos existen:</strong> Revisa la tabla de assets arriba.</li>';
    echo '<li><strong>Verifica permisos:</strong> Asegúrate de que los archivos tienen permisos de lectura (644).</li>';
    echo '<li><strong>Revisa la consola:</strong> Abre la consola del navegador (F12) y busca errores 404.</li>';
    echo '</ol>';
    echo '</div>';
    echo '</div>';
    
    // 10. Próximos pasos
    echo '<div class="debug-section">';
    echo '<h2>10. Próximos Pasos</h2>';
    
    echo '<ol>';
    echo '<li>Copia toda esta información (puedes hacer Ctrl+A, Ctrl+C)</li>';
    echo '<li>Envíala a soporte@thecreator.business</li>';
    echo '<li>Incluye una descripción detallada del problema</li>';
    echo '<li>Adjunta capturas de pantalla si es posible</li>';
    echo '</ol>';
    
    echo '<div class="info-box">';
    echo '<strong>Nota:</strong> Esta página es solo para diagnóstico. No afecta el funcionamiento del plugin.';
    echo '</div>';
    echo '</div>';
    ?>
    
    <script>
        // Seleccionar todo el contenido para copiar fácilmente
        document.addEventListener('DOMContentLoaded', function() {
            console.log('TCB MegaMenu Debug Frontend loaded');
        });
    </script>
</body>
</html>
