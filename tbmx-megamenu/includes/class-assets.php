<?php
/**
 * Assets - CSS/JS enqueue handler
 *
 * Handles conditional loading of front-end and admin assets.
 * Only loads assets when mega menu is actually in use.
 *
 * @package TBMX_MegaMenu
 */

namespace TBMX_MegaMenu;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Assets
 *
 * Manages enqueuing of CSS and JS files.
 */
class Assets {

    /**
     * Enqueue public-facing assets (conditional)
     *
     * Hooked to: wp_enqueue_scripts
     *
     * Only loads when the current menu has items with _tbmx_enabled.
     */
    public function enqueue_public_assets() {
        // Check if any registered menu has mega items
        if ( ! self::any_menu_has_mega_items() ) {
            return;
        }

        $version = TBMX_MEGAMENU_VERSION;

        // Main stylesheet
        wp_enqueue_style(
            'tbmx-megamenu',
            TBMX_MEGAMENU_URL . 'assets/css/megamenu.css',
            array(),
            $version
        );

        // Main script (vanilla JS, no dependencies)
        wp_enqueue_script(
            'tbmx-megamenu',
            TBMX_MEGAMENU_URL . 'assets/js/megamenu.js',
            array(),
            $version,
            true // Load in footer
        );

        // Pass config to JS
        $settings = Settings::get_settings();
        wp_localize_script( 'tbmx-megamenu', 'tbmxConfig', array(
            'hoverIn'        => intval( $settings['hover_in'] ),
            'hoverOut'       => intval( $settings['hover_out'] ),
            'breakpoint'     => intval( $settings['breakpoint'] ),
            'scrollLock'     => true,
            'focusTrap'      => false,
            'staggerDelay'   => 50,
            'lazyLoadImages' => true,
        ) );

        // Inject tokens as inline CSS
        add_action( 'wp_head', array( __CLASS__, 'print_tokens' ), 1 );

        // If Divi layouts are used, ensure Divi styles are loaded
        if ( self::has_divi_layout_panels() && Renderer::is_divi_active() ) {
            // Divi should already load its styles, but we can force it if needed
            if ( function_exists( 'et_builder_load_styles' ) ) {
                et_builder_load_styles();
            }
        }
    }

    /**
     * Enqueue admin assets
     *
     * Hooked to: admin_enqueue_scripts
     *
     * Only loads on nav-menus.php and the settings page.
     */
    public function enqueue_admin_assets( $hook_suffix ) {
        // Only on menu editor and our settings page
        $allowed_screens = array( 'nav-menus.php', 'appearance_page_' . Settings::PAGE_SLUG );

        if ( ! in_array( $hook_suffix, $allowed_screens, true ) ) {
            return;
        }

        $version = TBMX_MEGAMENU_VERSION;

        // Admin styles
        wp_enqueue_style(
            'tbmx-megamenu-admin',
            TBMX_MEGAMENU_URL . 'assets/css/admin.css',
            array(),
            $version
        );

        // Admin scripts
        wp_enqueue_script(
            'tbmx-megamenu-admin',
            TBMX_MEGAMENU_URL . 'assets/js/admin.js',
            array( 'jquery' ),
            $version,
            true
        );

        // WordPress color picker on settings page
        if ( 'appearance_page_' . Settings::PAGE_SLUG === $hook_suffix ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
        }
    }

    /**
     * Check if any registered menu has mega items
     *
     * @return bool
     */
    public static function any_menu_has_mega_items() {
        // Get all registered menu locations
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

    /**
     * Check if a specific menu has any mega menu items
     *
     * @param int $menu_id Menu term ID.
     * @return bool
     */
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

    /**
     * Check if any menu has mega items using Divi layouts
     *
     * @return bool
     */
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

    /**
     * Generate inline CSS with tokens from settings
     *
     * @return string CSS with :root variables
     */
    public static function get_tokens_css() {
        $settings = Settings::get_settings();

        $css  = ':root {';
        $css .= '--tbmx-bg:' . esc_attr( $settings['bg'] ) . ';';
        $css .= '--tbmx-fg:' . esc_attr( $settings['fg'] ) . ';';
        $css .= '--tbmx-muted:' . esc_attr( $settings['muted'] ) . ';';
        $css .= '--tbmx-accent:' . esc_attr( $settings['accent'] ) . ';';
        $css .= '--tbmx-border:' . esc_attr( $settings['border'] ) . ';';
        $css .= '--tbmx-radius:' . esc_attr( $settings['radius'] ) . ';';
        $css .= '--tbmx-shadow:' . esc_attr( $settings['shadow'] ) . ';';
        $css .= '--tbmx-font:' . esc_attr( $settings['font'] ) . ';';
        $css .= '--tbmx-gap:' . esc_attr( $settings['gap'] ) . ';';
        $css .= '--tbmx-anim:' . esc_attr( $settings['anim'] ) . ';';
        $css .= '}';

        return $css;
    }

    /**
     * Print inline tokens CSS in the head
     */
    public static function print_tokens() {
        echo '<style id="tbmx-megamenu-tokens">' . self::get_tokens_css() . '</style>' . "\n";
    }
}
