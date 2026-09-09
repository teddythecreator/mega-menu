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
 * Phase 2 will implement conditional loading logic.
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
        // Phase 2: Implement conditional enqueue
        // 1. Check if current menu has mega items
        // 2. If yes, enqueue megamenu.css and megamenu.js
        // 3. Inject tokens as inline CSS in :root
        // TODO: Implement in Phase 2
    }

    /**
     * Enqueue admin assets
     *
     * Hooked to: admin_enqueue_scripts
     *
     * Only loads on nav-menus.php and the settings page.
     */
    public function enqueue_admin_assets( $hook_suffix ) {
        // Phase 1: Enqueue admin.css and admin.js on:
        // - nav-menus.php (for the metabox)
        // - Appearance > TBMX Mega Menu (for settings page)
        // TODO: Implement in Phase 1
    }

    /**
     * Check if the current menu has any mega menu items
     *
     * @param string $menu_location Theme location slug.
     * @return bool
     */
    public static function menu_has_mega_items( $menu_location ) {
        // Phase 2: Query menu items and check _tbmx_enabled meta
        // TODO: Implement in Phase 2
        return false;
    }

    /**
     * Generate inline CSS with tokens from settings
     *
     * @return string CSS with :root variables
     */
    public static function get_tokens_css() {
        $settings = Settings::get_settings();

        $css = ':root {';
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
     *
     * Phase 2: Hook this to wp_head when mega menu is active
     */
    public static function print_tokens() {
        echo '<style id="tbmx-megamenu-tokens">' . self::get_tokens_css() . '</style>';
    }
}
