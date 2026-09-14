<?php
/**
 * TCB MegaMenu - Solución Definitiva para Divi
 * 
 * Este archivo contiene el código completo para forzar el mega menú en Divi.
 * Los paneles se renderizan DENTRO de cada ítem del menú (no al final).
 * 
 * INSTRUCCIONES:
 * 1. Copia TODO este código
 * 2. Pégalo al final de tu functions.php (tema hijo de Divi)
 * 3. Guarda los cambios
 * 4. Limpia la caché del navegador (Ctrl+F5)
 */

// ═══════════════════════════════════════════════════════════════
// PASO 1: FORZAR EL WALKER DEL MEGA MENÚ
// ═══════════════════════════════════════════════════════════════

add_filter('wp_nav_menu_args', 'tcb_force_mega_menu_walker', 999);
function tcb_force_mega_menu_walker($args) {
    // Solo en el frontend
    if (is_admin()) {
        return $args;
    }
    
    // Verificar que la clase del walker existe
    if (!class_exists('TCB_MegaMenu\\Menu_Walker')) {
        return $args;
    }
    
    // Aplicar el walker a TODAS las ubicaciones de menú
    // (puedes cambiar esto para aplicar solo a ubicaciones específicas)
    $args['walker'] = new TCB_MegaMenu\Menu_Walker();
    
    return $args;
}

// ═══════════════════════════════════════════════════════════════
// PASO 2: WALKER PERSONALIZADO QUE RENDERIZA PANELES DENTRO DE CADA ÍTEM
// ═══════════════════════════════════════════════════════════════

class TCB_Divi_Mega_Walker extends Walker_Nav_Menu {
    
    private $renderer;
    
    public function __construct() {
        $this->renderer = new TCB_MegaMenu\Renderer();
    }
    
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($data_object->classes) ? array() : (array) $data_object->classes;
        $classes[] = 'menu-item-' . $data_object->ID;
        
        $is_mega = TCB_MegaMenu\Menu_Fields::is_mega_enabled($data_object->ID);
        
        if ($is_mega && 0 === $depth) {
            $classes[] = 'tcb-mega-item';
        }
        
        $args = apply_filters('nav_menu_item_args', $args, $data_object, $depth);
        
        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $data_object, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $data_object->ID, $data_object, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $atts = array();
        $atts['title'] = !empty($data_object->attr_title) ? $data_object->attr_title : '';
        $atts['target'] = !empty($data_object->target) ? $data_object->target : '';
        if ('_blank' === $data_object->target && empty($data_object->xfn)) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $data_object->xfn;
        }
        $atts['href'] = !empty($data_object->url) ? $data_object->url : '';
        $atts['aria-current'] = $data_object->current ? 'page' : '';
        
        // Add mega menu attributes
        if ($is_mega && 0 === $depth) {
            $panel_id = 'tcb-panel-' . $data_object->ID;
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
            $atts['aria-controls'] = $panel_id;
            $atts['data-tcb-toggle'] = 'mega';
        }
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $data_object, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (is_scalar($value) && '' !== $value && false !== $value) {
                $attributes .= sprintf(' %s="%s"', $attr, esc_attr($value));
            }
        }
        
        $title = apply_filters('the_title', $data_object->title, $data_object->ID);
        $title = apply_filters('nav_menu_item_title', $title, $data_object, $args, $depth);
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . $title . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        // Add badge if configured
        if ($is_mega && 0 === $depth) {
            $badge = TCB_MegaMenu\Menu_Fields::get_meta($data_object->ID, TCB_MegaMenu\Menu_Fields::META_BADGE, '');
            if (!empty($badge)) {
                $item_output .= '<span class="tcb-badge">' . esc_html($badge) . '</span>';
            }
        }
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $data_object, $depth, $args);
        
        // ═══════════════════════════════════════════════════════════════
        // RENDERIZAR EL PANEL DENTRO DEL ÍTEM (NO AL FINAL)
        // ═══════════════════════════════════════════════════════════════
        
        if ($is_mega && 0 === $depth) {
            $panel_id = 'tcb-panel-' . $data_object->ID;
            $panel_content = $this->renderer->render($data_object->ID);
            
            $width = TCB_MegaMenu\Menu_Fields::get_meta($data_object->ID, TCB_MegaMenu\Menu_Fields::META_WIDTH, 'full');
            $width_px = TCB_MegaMenu\Menu_Fields::get_meta($data_object->ID, TCB_MegaMenu\Menu_Fields::META_WIDTH_PX, 1200);
            $align = TCB_MegaMenu\Menu_Fields::get_meta($data_object->ID, TCB_MegaMenu\Menu_Fields::META_ALIGN, 'left');
            
            $panel_classes = array('tcb-panel');
            $panel_classes[] = 'tcb-width-' . $width;
            $panel_classes[] = 'tcb-align-' . $align;
            
            // Inline style para custom width
            $inline_style = '';
            if ('custom' === $width && $width_px > 0) {
                $inline_style = ' style="width: ' . intval($width_px) . 'px;"';
            }
            
            $output .= "\n<div";
            $output .= ' id="' . esc_attr($panel_id) . '"';
            $output .= ' class="' . esc_attr(implode(' ', $panel_classes)) . '"';
            $output .= $inline_style;
            $output .= ' role="region"';
            $output .= ' aria-label="' . esc_attr(sprintf(__('Mega menu panel for %s', 'tcb-megamenu'), $data_object->title)) . '"';
            $output .= ' aria-hidden="true"';
            $output .= ' hidden';
            $output .= ">\n";
            $output .= '<div class="tcb-panel-inner">' . $panel_content . "</div>\n";
            $output .= "</div>\n";
        }
    }
    
    public function end_el(&$output, $data_object, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

// ═══════════════════════════════════════════════════════════════
// PASO 3: USAR EL WALKER PERSONALIZADO EN LUGAR DEL DEL PLUGIN
// ═══════════════════════════════════════════════════════════════

add_filter('wp_nav_menu_args', 'tcb_use_custom_walker', 1000);
function tcb_use_custom_walker($args) {
    // Solo en el frontend
    if (is_admin()) {
        return $args;
    }
    
    // Usar nuestro walker personalizado
    $args['walker'] = new TCB_Divi_Mega_Walker();
    
    return $args;
}

// ═══════════════════════════════════════════════════════════════
// PASO 4: ASEGURAR QUE LOS ASSETS SE CARGUEN
// ═══════════════════════════════════════════════════════════════

add_action('wp_enqueue_scripts', 'tcb_ensure_assets_loaded', 999);
function tcb_ensure_assets_loaded() {
    // Solo en el frontend
    if (is_admin()) {
        return;
    }
    
    // Verificar que hay mega items
    if (!TCB_MegaMenu\Assets::any_menu_has_mega_items()) {
        return;
    }
    
    $version = TCB_MEGAMENU_VERSION;
    
    // Cargar CSS principal
    wp_enqueue_style(
        'tcb-megamenu',
        TCB_MEGAMENU_URL . 'assets/css/megamenu.css',
        array(),
        $version
    );
    
    // Cargar mobile fixes
    wp_enqueue_style(
        'tcb-megamenu-mobile',
        TCB_MEGAMENU_URL . 'assets/css/mobile-fix.css',
        array('tcb-megamenu'),
        $version
    );
    
    // Cargar JavaScript
    wp_enqueue_script(
        'tcb-megamenu',
        TCB_MEGAMENU_URL . 'assets/js/megamenu.js',
        array(),
        $version,
        true
    );
    
    // Pasar configuración al JavaScript
    $settings = TCB_MegaMenu\Settings::get_settings();
    wp_localize_script('tcb-megamenu', 'tcbConfig', array(
        'hoverIn' => intval($settings['hover_in']),
        'hoverOut' => intval($settings['hover_out']),
        'breakpoint' => intval($settings['breakpoint']),
        'mobileStyle' => $settings['mobile_style'],
        'mobilePosition' => $settings['mobile_position'],
        'mobileWidth' => intval($settings['mobile_width']),
        'hamburgerIcon' => $settings['hamburger_icon'],
        'hamburgerColor' => $settings['hamburger_color'],
        'hamburgerSize' => intval($settings['hamburger_size']),
        'hamburgerThickness' => intval($settings['hamburger_thickness']),
        'scrollLock' => true,
        'staggerDelay' => 50,
        'lazyLoadImages' => true,
    ));
    
    // Inyectar tokens CSS
    add_action('wp_head', array('TCB_MegaMenu\\Assets', 'print_tokens'), 1);
    
    // Cargar estilos de Divi si es necesario
    if (TCB_MegaMenu\Assets::has_divi_layout_panels() && TCB_MegaMenu\Renderer::is_divi_active()) {
        if (function_exists('et_builder_load_styles')) {
            et_builder_load_styles();
        }
    }
}

// ═══════════════════════════════════════════════════════════════
// PASO 5: DEBUG (OPCIONAL - PARA DIAGNÓSTICO)
// ═══════════════════════════════════════════════════════════════

// Descomenta estas líneas para ver información de debug en el frontend
/*
add_action('wp_footer', 'tcb_debug_mega_menu');
function tcb_debug_mega_menu() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    echo '<!-- TCB MegaMenu Debug -->';
    echo '<!-- Plugin Version: ' . TCB_MEGAMENU_VERSION . ' -->';
    echo '<!-- Walker Applied: Yes -->';
    echo '<!-- Assets Loaded: Yes -->';
    
    $locations = get_nav_menu_locations();
    foreach ($locations as $location => $menu_id) {
        $has_mega = TCB_MegaMenu\Assets::menu_has_mega_items($menu_id);
        echo '<!-- Location: ' . $location . ' | Menu ID: ' . $menu_id . ' | Has Mega: ' . ($has_mega ? 'Yes' : 'No') . ' -->';
    }
}
*/

// ═══════════════════════════════════════════════════════════════
// FIN DEL CÓDIGO
// ═══════════════════════════════════════════════════════════════
