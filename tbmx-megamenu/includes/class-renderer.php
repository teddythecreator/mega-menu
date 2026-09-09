<?php
/**
 * Renderer - Panel content renderer
 *
 * Renders the mega panel content from either:
 * - Divi Library layout (et_pb_layout CPT)
 * - Custom columns (fallback without Divi)
 *
 * @package TBMX_MegaMenu
 */

namespace TBMX_MegaMenu;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Renderer
 *
 * Handles rendering of mega panel content.
 * Phase 2 will implement the actual rendering logic.
 */
class Renderer {

    /**
     * Render panel content for a menu item
     *
     * @param int $item_id Menu item ID.
     * @return string Panel HTML content.
     */
    public function render( $item_id ) {
        $source    = Menu_Fields::get_meta( $item_id, Menu_Fields::META_SOURCE, 'divi_layout' );
        $layout_id = (int) Menu_Fields::get_meta( $item_id, Menu_Fields::META_LAYOUT_ID, 0 );

        if ( 'divi_layout' === $source && $layout_id > 0 ) {
            return $this->render_divi_layout( $layout_id );
        }

        // Fallback: render custom columns
        return $this->render_columns( $item_id );
    }

    /**
     * Render content from a Divi Library layout
     *
     * @param int $layout_id Post ID of the et_pb_layout.
     * @return string Rendered HTML.
     */
    private function render_divi_layout( $layout_id ) {
        // Phase 2: Implement Divi layout rendering
        // 1. Get the layout post content
        // 2. Process with do_shortcode (Divi shortcodes)
        // 3. Ensure Divi styles are loaded
        // TODO: Implement in Phase 2
        return '';
    }

    /**
     * Render custom columns layout (fallback)
     *
     * @param int $item_id Menu item ID.
     * @return string Rendered HTML.
     */
    private function render_columns( $item_id ) {
        // Phase 2: Implement custom columns rendering
        // - Get child menu items
        // - Render in columns layout
        // - Optional featured block
        // TODO: Implement in Phase 2
        return '';
    }

    /**
     * Check if Divi is active
     *
     * @return bool
     */
    public static function is_divi_active() {
        return function_exists( 'et_setup_theme' ) || defined( 'ET_BUILDER_PLUGIN_VERSION' );
    }

    /**
     * Get available Divi Library layouts
     *
     * @return array Array of layout objects (ID, title).
     */
    public static function get_divi_layouts() {
        if ( ! self::is_divi_active() ) {
            return array();
        }

        // Phase 2: Query et_pb_layout CPT
        // TODO: Implement in Phase 2
        return array();
    }
}
