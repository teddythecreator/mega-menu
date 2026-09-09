#!/usr/bin/env php
<?php
/**
 * Script de diagnóstico para TCB MegaMenu
 * 
 * Uso: php diagnostic.php
 */

echo "=== TCB MegaMenu - Diagnóstico ===\n\n";

// Verificar que estamos en el directorio correcto
if (!file_exists('tcb-megamenu.php')) {
    echo "❌ ERROR: No se encuentra tcb-megamenu.php\n";
    echo "   Asegúrate de ejecutar este script desde la carpeta del plugin\n";
    exit(1);
}

echo "✓ Archivo principal encontrado\n";

// Verificar sintaxis PHP de todos los archivos
$php_files = array(
    'tcb-megamenu.php',
    'includes/class-plugin.php',
    'includes/class-menu-fields.php',
    'includes/class-menu-walker.php',
    'includes/class-settings.php',
    'includes/class-assets.php',
    'includes/class-renderer.php',
    'uninstall.php'
);

echo "\nVerificando sintaxis PHP...\n";
$errors = 0;

foreach ($php_files as $file) {
    if (!file_exists($file)) {
        echo "❌ ERROR: No se encuentra $file\n";
        $errors++;
        continue;
    }
    
    $output = array();
    $return_var = 0;
    exec("php -l " . escapeshellarg($file) . " 2>&1", $output, $return_var);
    
    if ($return_var === 0) {
        echo "✓ $file - Sintaxis OK\n";
    } else {
        echo "❌ ERROR en $file:\n";
        echo "   " . implode("\n   ", $output) . "\n";
        $errors++;
    }
}

// Verificar que los archivos CSS y JS existen
echo "\nVerificando assets...\n";
$asset_files = array(
    'assets/css/megamenu.css',
    'assets/css/admin.css',
    'assets/js/megamenu.js',
    'assets/js/admin.js'
);

foreach ($asset_files as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "✓ $file (" . number_format($size) . " bytes)\n";
    } else {
        echo "❌ ERROR: No se encuentra $file\n";
        $errors++;
    }
}

// Verificar documentación
echo "\nVerificando documentación...\n";
$doc_files = array(
    'readme.txt',
    'INSTALLATION-GUIDE.md',
    'LICENSE'
);

foreach ($doc_files as $file) {
    if (file_exists($file)) {
        echo "✓ $file\n";
    } else {
        echo "⚠ ADVERTENCIA: No se encuentra $file\n";
    }
}

// Verificar permisos
echo "\nVerificando permisos...\n";
if (is_readable('tcb-megamenu.php')) {
    echo "✓ tcb-megamenu.php es legible\n";
} else {
    echo "❌ ERROR: tcb-megamenu.php no es legible\n";
    $errors++;
}

// Resumen
echo "\n=== Resumen ===\n";
if ($errors === 0) {
    echo "✅ Todos los checks pasaron. El plugin debería activarse correctamente.\n\n";
    echo "Próximos pasos:\n";
    echo "1. Empaqueta el plugin: zip -r ../tcb-megamenu.zip .\n";
    echo "2. Sube el ZIP a WordPress: Plugins → Añadir nuevo → Subir plugin\n";
    echo "3. Activa el plugin\n";
    echo "4. Ve a TCB MegaMenu en el menú principal\n";
    exit(0);
} else {
    echo "❌ Se encontraron $errors error(es). Corrige los problemas antes de activar.\n";
    exit(1);
}
