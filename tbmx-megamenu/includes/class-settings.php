<?php
/**
 * Settings - Global plugin settings page
 *
 * Registers a settings page under Appearance menu using the Settings API.
 * Stores all global options in a single array: tbmx_megamenu_settings
 *
 * @package TBMX_MegaMenu
 */

namespace TBMX_MegaMenu;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Settings
 *
 * Handles the global settings page and options.
 * Phase 1 will implement the actual settings UI.
 */
class Settings {

    /**
     * Option name for global settings
     */
    const OPTION_NAME = 'tbmx_megamenu_settings';

    /**
     * Settings page slug
     */
    const PAGE_SLUG = 'tbmx-megamenu';

    /**
     * Default settings values
     *
     * @return array
     */
    public static function get_defaults() {
        return array(
            // Colors (tokens)
            'bg'           => '#050506',
            'fg'           => '#f5f5f5',
            'muted'        => 'rgba(245,245,245,.6)',
            'accent'       => '#e11414',
            'border'       => 'rgba(255,255,255,.08)',

            // Layout
            'radius'       => '10px',
            'shadow'       => '0 24px 60px rgba(0,0,0,.5)',
            'font'         => '"Montserrat", system-ui, sans-serif',
            'gap'          => 'clamp(16px, 2vw, 32px)',
            'anim'         => '.22s cubic-bezier(.22,.61,.36,1)',

            // Behavior
            'width'        => 'full',       // full | container | custom
            'width_px'     => 1200,
            'hover_in'     => 120,          // ms
            'hover_out'    => 200,          // ms
            'breakpoint'   => 980,          // px - mobile breakpoint
            'preset'       => 'oscuro',     // oscuro | claro | minimal
        );
    }

    /**
     * Get current settings merged with defaults
     *
     * @return array
     */
    public static function get_settings() {
        $saved = get_option( self::OPTION_NAME, array() );
        return wp_parse_args( $saved, self::get_defaults() );
    }

    /**
     * Add settings page under Appearance menu
     *
     * Hooked to: admin_menu
     */
    public function add_settings_page() {
        // Phase 1: Register the settings page
        // add_submenu_page( 'themes.php', ... )
        // TODO: Implement in Phase 1
    }

    /**
     * Register settings with the Settings API
     *
     * Hooked to: admin_init
     */
    public function register_settings() {
        // Phase 1: register_setting, add_settings_section, add_settings_field
        // TODO: Implement in Phase 1
    }

    /**
     * Render the settings page
     *
     * Phase 1 will implement the full settings UI with:
     * - Color pickers for tokens
     * - Width selector (full/container/custom)
     * - Breakpoint input
     * - Hover timing controls
     * - Preset selector
     */
    public function render_page() {
        // Phase 1: Implement settings page HTML
        // TODO: Implement in Phase 1
    }

    /**
     * Sanitize settings on save
     *
     * @param array $input Raw input.
     * @return array Sanitized settings.
     */
    public static function sanitize( $input ) {
        // Phase 1: Sanitize each field
        // TODO: Implement in Phase 1
        return $input;
    }
}
