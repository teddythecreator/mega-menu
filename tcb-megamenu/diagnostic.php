<?php
/**
 * TCB MegaMenu - Diagnostic Tool
 * 
 * Este archivo te ayudará a diagnosticar problemas con el plugin.
 * Úsalo solo si el plugin no funciona correctamente.
 * 
 * @package TCB_MegaMenu
 */

// Cargar WordPress
require_once '../../../wp-load.php';

// Verificar permisos
if ( ! current_user_can( 'manage_options' ) ) {
    die( 'No tienes permisos para acceder a esta herramienta.' );
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCB MegaMenu - Diagnóstico</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #f0f0f1;
        }
        .diagnostic-box {
            background: white;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .diagnostic-box h2 {
            margin-top: 0;
            color: #1d2327;
            border-bottom: 1px solid #dcdcde;
            padding-bottom: 10px;
        }
        .status-ok {
            color: #00a32a;
            font-weight: bold;
        }
        .status-error {
            color: #d63638;
            font-weight: bold;
        }
        .status-warning {
            color: #dba617;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dcdcde;
        }
        table th {
            background: #f6f7f7;
            font-weight: 600;
        }
        code {
            background: #f6f7f7;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: Consolas, Monaco, monospace;
            font-size: 13px;
        }
        .info-box {
            background: #f0f6fc;
            border-left: 4px solid #2271b1;
            padding: 12px;
            margin: 10px 0;
        }
        .error-box {
            background: #fcf0f1;
            border-left: 4px solid #d63638;
            padding: 12px;
            margin: 10px 0;
        }
        .warning-box {
            background: #fcf9e8;
            border-left: 4px solid #dba617;
            padding: 12px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>🔍 TCB MegaMenu - Herramienta de Diagnóstico</h1>
    
    <?php
    // 1. Verificar que el plugin está activo
    echo '<div class="diagnostic-box">';
    echo '<h2>1. Estado del Plugin</h2>';
    
    if ( is_plugin_active( 'tcb-megamenu/tcb-megamenu.php' ) ) {
        echo '<p class="status-ok">✓ El plugin está activo</p>';
    } else {
        echo '<p class="status-error">✗ El plugin NO está activo</p>';
        echo '<div class="error-box">';
        echo '<strong>Solución:</strong> Ve a Plugins y activa TCB MegaMenu';
        echo '</div>';
    }
    echo '</div>';
    
    // 2. Verificar archivos del plugin
    echo '<div class="diagnostic-box">';
    echo '<h2>2. Archivos del Plugin</h2>';
    
    $required_files = array(
        'tcb-megamenu.php' => 'Archivo principal',
        'includes/class-plugin.php' => 'Clase principal',
        'includes/class-menu-fields.php' => 'Campos del menú',
        'includes/class-menu-walker.php' => 'Walker del menú',
        'includes/class-settings.php' => 'Configuración',
        'includes/class-assets.php' => 'Assets',
        'includes/class-renderer.php' => 'Renderer',
        'assets/css/megamenu.css' => 'CSS principal',
        'assets/css/mobile-fix.css' => 'CSS móvil',
        'assets/js/megamenu.js' => 'JavaScript principal',
    );
    
    echo '<table>';
    echo '<tr><th>Archivo</th><th>Descripción</th><th>Estado</th></tr>';
    
    foreach ( $required_files as $file => $desc ) {
        $full_path = TCB_MEGAMENU_DIR . $file;
        $exists = file_exists( $full_path );
        
        echo '<tr>';
        echo '<td><code>' . esc_html( $file ) . '</code></td>';
        echo '<td>' . esc_html( $desc ) . '</td>';
        echo '<td>';
        if ( $exists ) {
            echo '<span class="status-ok">✓ Existe</span>';
        } else {
            echo '<span class="status-error">✗ Falta</span>';
        }
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
    echo '</div>';
    
    // 3. Verificar configuración
    echo '<div class="diagnostic-box">';
    echo '<h2>3. Configuración del Plugin</h2>';
    
    $settings = get_option( 'tcb_megamenu_settings' );
    
    if ( $settings ) {
        echo '<p class="status-ok">✓ La configuración existe en la base de datos</p>';
        echo '<table>';
        echo '<tr><th>Opción</th><th>Valor</th></tr>';
        
        foreach ( $settings as $key => $value ) {
            echo '<tr>';
            echo '<td><code>' . esc_html( $key ) . '</code></td>';
            echo '<td>' . esc_html( is_array( $value ) ? json_encode( $value ) : $value ) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p class="status-warning">⚠ No hay configuración guardada</p>';
        echo '<div class="warning-box">';
        echo '<strong>Solución:</strong> Ve a TCB MegaMenu → Settings y guarda la configuración';
        echo '</div>';
    }
    
    echo '</div>';
    
    // 4. Verificar menús con mega menú
    echo '<div class="diagnostic-box">';
    echo '<h2>4. Menús Configurados</h2>';
    
    global $wpdb;
    
    $mega_items = $wpdb->get_results( "
        SELECT pm.post_id, pm.meta_value, p.post_title
        FROM {$wpdb->postmeta} pm
        JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE pm.meta_key = '_tcb_enabled'
        AND pm.meta_value = '1'
    " );
    
    if ( $mega_items ) {
        echo '<p class="status-ok">✓ Se encontraron ' . count( $mega_items ) . ' mega menús configurados</p>';
        echo '<table>';
        echo '<tr><th>ID</th><th>Título del Menú</th><th>Estado</th></tr>';
        
        foreach ( $mega_items as $item ) {
            echo '<tr>';
            echo '<td>' . esc_html( $item->post_id ) . '</td>';
            echo '<td>' . esc_html( $item->post_title ) . '</td>';
            echo '<td><span class="status-ok">✓ Activo</span></td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p class="status-warning">⚠ No hay mega menús configurados</p>';
        echo '<div class="warning-box">';
        echo '<strong>Solución:</strong> Ve a Apariencia → Menús y activa "Enable Mega Panel" en algún ítem del menú';
        echo '</div>';
    }
    
    echo '</div>';
    
    // 5. Verificar compatibilidad con Divi
    echo '<div class="diagnostic-box">';
    echo '<h2>5. Compatibilidad con Divi</h2>';
    
    if ( function_exists( 'et_setup_theme' ) ) {
        echo '<p class="status-ok">✓ Divi theme está activo</p>';
    } elseif ( defined( 'ET_BUILDER_PLUGIN_VERSION' ) ) {
        echo '<p class="status-ok">✓ Divi Builder plugin está activo</p>';
    } else {
        echo '<p class="status-warning">⚠ Divi no está activo (el plugin funcionará en modo columnas)</p>';
    }
    
    echo '</div>';
    
    // 6. Información del sistema
    echo '<div class="diagnostic-box">';
    echo '<h2>6. Información del Sistema</h2>';
    
    echo '<table>';
    echo '<tr><th>Elemento</th><th>Valor</th></tr>';
    echo '<tr><td>Versión de WordPress</td><td>' . esc_html( get_bloginfo( 'version' ) ) . '</td></tr>';
    echo '<tr><td>Versión de PHP</td><td>' . esc_html( phpversion() ) . '</td></tr>';
    echo '<tr><td>Versión del Plugin</td><td>' . esc_html( TCB_MEGAMENU_VERSION ) . '</td></tr>';
    echo '<tr><td>Tema Activo</td><td>' . esc_html( wp_get_theme()->get( 'Name' ) ) . '</td></tr>';
    echo '</table>';
    
    echo '</div>';
    
    // 7. Errores comunes
    echo '<div class="diagnostic-box">';
    echo '<h2>7. Errores Comunes y Soluciones</h2>';
    
    echo '<div class="info-box">';
    echo '<strong>Error: "block-style-variation-styles"</strong><br>';
    echo 'Este es un error de WordPress core, NO del plugin. Puedes ignorarlo o actualizar WordPress a la última versión.';
    echo '</div>';
    
    echo '<div class="info-box">';
    echo '<strong>Error: El menú no aparece en el front-end</strong><br>';
    echo 'Soluciones:<br>';
    echo '1. Verifica que el menú está asignado a una ubicación del tema<br>';
    echo '2. Verifica que "Enable Mega Panel" está activado en el ítem del menú<br>';
    echo '3. Limpia la caché del navegador (Ctrl+F5)<br>';
    echo '4. Verifica que el tema usa <code>wp_nav_menu()</code>';
    echo '</div>';
    
    echo '<div class="info-box">';
    echo '<strong>Error: El menú móvil no funciona</strong><br>';
    echo 'Soluciones:<br>';
    echo '1. Verifica que el breakpoint es correcto (por defecto 980px)<br>';
    echo '2. Redimensiona la ventana del navegador<br>';
    echo '3. Verifica que el CSS móvil se carga correctamente<br>';
    echo '4. Revisa la consola del navegador por errores de JavaScript';
    echo '</div>';
    
    echo '</div>';
    
    // 8. Acciones rápidas
    echo '<div class="diagnostic-box">';
    echo '<h2>8. Acciones Rápidas</h2>';
    
    echo '<p>';
    echo '<a href="' . admin_url( 'admin.php?page=tcb-megamenu' ) . '" class="button button-primary">Ir a Configuración</a> ';
    echo '<a href="' . admin_url( 'nav-menus.php' ) . '" class="button">Ir a Menús</a> ';
    echo '<a href="' . admin_url( 'plugins.php' ) . '" class="button">Ir a Plugins</a>';
    echo '</p>';
    
    echo '</div>';
    ?>
    
    <div class="diagnostic-box">
        <h2>¿Necesitas Ayuda?</h2>
        <p>Si después de revisar este diagnóstico el plugin sigue sin funcionar:</p>
        <ul>
            <li>Toma capturas de pantalla de esta página de diagnóstico</li>
            <li>Toma capturas de pantalla de la consola del navegador (F12)</li>
            <li>Contacta soporte: soporte@thecreator.business</li>
        </ul>
    </div>
    
</body>
</html>
