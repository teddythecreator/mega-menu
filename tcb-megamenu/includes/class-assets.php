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

    public function enqueue_public_assets() {
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

        wp_enqueue_script(
            'tcb-megamenu',
            TCB_MEGAMENU_URL . 'assets/js/megamenu.js',
            array(),
            $version,
            true
        );

        $settings = Settings::get_settings();
        wp_localize_script( 'tcb-megamenu', 'tcbConfig', array(
            'hoverIn'        => intval( $settings['hover_in'] ),
            'hoverOut'       => intval( $settings['hover_out'] ),
            'breakpoint'     => intval( $settings['breakpoint'] ),
            'scrollLock'     => true,
            'staggerDelay'   => 50,
            'lazyLoadImages' => true,
        ) );

        add_action( 'wp_head', array( __CLASS__, 'print_tokens' ), 1 );

        if ( self::has_divi_layout_panels() && Renderer::is_divi_active() ) {
            if ( function_exists( 'et_builder_load_styles' ) ) {
                et_builder_load_styles();
            }
        }
    }

    public function enqueue_admin_assets( $hook_suffix ) {
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
        $css .= '}';

        return $css;
    }

    public static function print_tokens() {
        echo '<style id="tcb-megamenu-tokens">' . self::get_tokens_css() . '</style>' . "\n";
    }
}
