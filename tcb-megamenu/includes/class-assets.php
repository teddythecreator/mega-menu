<?php
/**
 * Assets - CSS/JS enqueue handler
 *
 * @package TCB_MegaMenu
 */

namespace TCB_MegaMenu;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Assets {

    /**
     * Check if we're in Divi Builder context
     */
    public static function is_divi_builder() {
        // Check if we're in admin
        if ( ! is_admin() ) {
            return false;
        }

        // Check for Divi Builder page
        global $post;
        
        if ( ! $post ) {
            return false;
        }

        // Check if current page is using Divi Builder
        if ( function_exists( 'et_pb_is_pagebuilder_used' ) ) {
            return et_pb_is_pagebuilder_used( $post->ID );
        }

        // Check for Divi Builder AJAX requests
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return true;
        }

        // Check for specific Divi Builder admin pages
        $current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
        
        if ( $current_screen && isset( $current_screen->id ) ) {
            $divi_screens = array(
                'toplevel_page_et_divi',
                'divi_page_et_divi',
                'post',
                'page'
            );
            
            if ( in_array( $current_screen->id, $divi_screens ) ) {
                // Check if we're editing with Divi Builder
                if ( isset( $_GET['et_fb'] ) || isset( $_GET['et_pb_preview'] ) ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if we're in any page builder context (Divi, Elementor, etc.)
     */
    public static function is_page_builder() {
        // Divi Builder
        if ( self::is_divi_builder() ) {
            return true;
        }

        // Elementor
        if ( class_exists( '\\Elementor\\Plugin' ) ) {
            if ( isset( $_GET['elementor-preview'] ) || isset( $_GET['action'] ) && $_GET['action'] === 'elementor' ) {
                return true;
            }
        }

        // WPBakery (Visual Composer)
        if ( class_exists( 'Vc_Manager' ) ) {
            if ( isset( $_GET['vc_action'] ) && $_GET['vc_action'] === 'vc_inline' ) {
                return true;
            }
        }

        return false;
    }

    public function enqueue_public_assets() {
        // Don't load in admin or page builders
        if ( is_admin() || self::is_page_builder() ) {
            return;
        }

        if ( ! self::any_menu_has_mega_items() ) {
            return;
        }

        $version = TCB_MEGAMENU_VERSION;

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
            array( 'tcb-megamenu' ),
            $version
        );

        wp_enqueue_script(
            'tcb-megamenu',
            TCB_MEGAMENU_URL . 'assets/js/megamenu.js',
            array(),
            $version,
            true
        );

        $settings = Settings::get_settings();
        wp_localize_script( 'tcb-megamenu', 'tcbConfig', array(
            'hoverIn'            => intval( $settings['hover_in'] ),
            'hoverOut'           => intval( $settings['hover_out'] ),
            'breakpoint'         => intval( $settings['breakpoint'] ),
            'mobileStyle'        => $settings['mobile_style'],
            'mobilePosition'     => $settings['mobile_position'],
            'mobileWidth'        => intval( $settings['mobile_width'] ),
            'hamburgerIcon'      => $settings['hamburger_icon'],
            'hamburgerColor'     => $settings['hamburger_color'],
            'hamburgerSize'      => intval( $settings['hamburger_size'] ),
            'hamburgerThickness' => intval( $settings['hamburger_thickness'] ),
            'scrollLock'         => true,
            'staggerDelay'       => 50,
            'lazyLoadImages'     => true,
        ) );

        add_action( 'wp_head', array( __CLASS__, 'print_tokens' ), 1 );

        if ( self::has_divi_layout_panels() && Renderer::is_divi_active() ) {
            if ( function_exists( 'et_builder_load_styles' ) ) {
                et_builder_load_styles();
            }
        }
    }

    public function enqueue_admin_assets( $hook_suffix ) {
        // Don't load in Divi Builder or other page builders
        if ( self::is_page_builder() ) {
            return;
        }

        $allowed_screens = array( 'nav-menus.php', 'toplevel_page_' . Settings::PAGE_SLUG );

        if ( ! in_array( $hook_suffix, $allowed_screens, true ) ) {
            return;
        }

        $version = TCB_MEGAMENU_VERSION;

        wp_enqueue_style(
            'tcb-megamenu-admin',
            TCB_MEGAMENU_URL . 'assets/css/admin.css',
            array(),
            $version
        );

        wp_enqueue_script(
            'tcb-megamenu-admin',
            TCB_MEGAMENU_URL . 'assets/js/admin.js',
            array( 'jquery' ),
            $version,
            true
        );

        if ( 'toplevel_page_' . Settings::PAGE_SLUG === $hook_suffix ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
        }
    }

    public static function any_menu_has_mega_items() {
        $locations = get_nav_menu_locations();

        if ( empty( $locations ) ) {
            return false;
        }

        foreach ( $locations as $location => $menu_id ) {
            if ( self::menu_has_mega_items( $menu_id ) ) {
                return true;
            }
        }

        return false;
    }

    public static function menu_has_mega_items( $menu_id ) {
        $items = wp_get_nav_menu_items( $menu_id );

        if ( empty( $items ) ) {
            return false;
        }

        foreach ( $items as $item ) {
            if ( Menu_Fields::is_mega_enabled( $item->ID ) ) {
                return true;
            }
        }

        return false;
    }

    public static function has_divi_layout_panels() {
        $locations = get_nav_menu_locations();

        if ( empty( $locations ) ) {
            return false;
        }

        foreach ( $locations as $location => $menu_id ) {
            $items = wp_get_nav_menu_items( $menu_id );
            if ( empty( $items ) ) {
                continue;
            }

            foreach ( $items as $item ) {
                if ( Menu_Fields::is_mega_enabled( $item->ID ) ) {
                    $source = Menu_Fields::get_meta( $item->ID, Menu_Fields::META_SOURCE, 'divi_layout' );
                    if ( 'divi_layout' === $source ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function get_tokens_css() {
        $settings = Settings::get_settings();
        
        $css  = ':root {';
        $css .= '--tcb-bg:' . esc_attr( $settings['bg'] ) . ';';
        $css .= '--tcb-fg:' . esc_attr( $settings['fg'] ) . ';';
        $css .= '--tcb-muted:' . esc_attr( $settings['muted'] ) . ';';
        $css .= '--tcb-accent:' . esc_attr( $settings['accent'] ) . ';';
        $css .= '--tcb-border:' . esc_attr( $settings['border'] ) . ';';
        $css .= '--tcb-radius:' . esc_attr( $settings['radius'] ) . ';';
        $css .= '--tcb-shadow:' . esc_attr( $settings['shadow'] ) . ';';
        $css .= '--tcb-font:' . esc_attr( $settings['font'] ) . ';';
        $css .= '--tcb-gap:' . esc_attr( $settings['gap'] ) . ';';
        $css .= '--tcb-anim:' . esc_attr( $settings['anim'] ) . ';';
        // Mobile settings
        $css .= '--tcb-mobile-width:' . intval( $settings['mobile_width'] ) . 'px;';
        // Hamburger icon settings
        $css .= '--tcb-hamburger-color:' . esc_attr( $settings['hamburger_color'] ) . ';';
        $css .= '--tcb-hamburger-size:' . intval( $settings['hamburger_size'] ) . 'px;';
        $css .= '--tcb-hamburger-thickness:' . intval( $settings['hamburger_thickness'] ) . 'px;';
        $css .= '}';

        return $css;
    }

    public static function print_tokens() {
        // Don't print in page builders
        if ( self::is_page_builder() ) {
            return;
        }

        echo '<style id="tcb-megamenu-tokens">' . self::get_tokens_css() . '</style>' . "\n";
    }
}
