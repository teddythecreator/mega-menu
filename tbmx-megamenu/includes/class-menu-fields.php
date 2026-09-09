<?php
/**
 * Menu Fields - Metabox for menu items
 *
 * Adds custom fields to each menu item in Appearance > Menus:
 * - Enable mega panel (checkbox)
 * - Select Divi Library layout (dropdown)
 *
 * @package TBMX_MegaMenu
 */

namespace TBMX_MegaMenu;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Menu_Fields
 *
 * Handles the custom fields added to nav menu items in the admin.
 * Phase 1 will implement the actual metabox UI and save logic.
 */
class Menu_Fields {

    /**
     * Meta keys used by the plugin
     */
    const META_ENABLED   = '_tbmx_enabled';
    const META_SOURCE    = '_tbmx_source';
    const META_LAYOUT_ID = '_tbmx_layout_id';
    const META_WIDTH     = '_tbmx_width';
    const META_WIDTH_PX  = '_tbmx_width_px';
    const META_ALIGN     = '_tbmx_align';
    const META_ICON      = '_tbmx_icon';
    const META_BADGE     = '_tbmx_badge';

    /**
     * Render custom fields for a menu item.
     *
     * Hooked to: wp_nav_menu_item_custom_fields
     *
     * @param int        $item_id    Menu item ID.
     * @param object     $item       Menu item object.
     * @param int        $depth      Depth of menu item.
     * @param \stdClass  $args       An object of menu item arguments.
     * @param int        $current_object_id Current object ID.
     */
    public function render_fields( $item_id, $item, $depth, $args, $current_object_id ) {
        // Phase 1: Implement metabox UI
        // - Checkbox: Enable mega panel
        // - Select: Divi Library layout (et_pb_layout CPT)
        // - Nonce field for security
        // TODO: Implement in Phase 1
    }

    /**
     * Save custom fields for a menu item.
     *
     * Hooked to: wp_update_nav_menu_item
     *
     * @param int   $menu_id         ID of the menu.
     * @param int   $menu_item_db_id ID of the menu item.
     * @param array $menu_item_args  Menu item arguments.
     */
    public function save_fields( $menu_id, $menu_item_db_id, $menu_item_args ) {
        // Phase 1: Implement save logic
        // - Verify nonce
        // - Check capability (edit_theme_options)
        // - Sanitize and save each meta key
        // TODO: Implement in Phase 1
    }

    /**
     * Get meta value for a menu item with default fallback.
     *
     * @param int    $item_id Menu item ID.
     * @param string $key     Meta key.
     * @param mixed  $default Default value.
     * @return mixed
     */
    public static function get_meta( $item_id, $key, $default = '' ) {
        $value = get_post_meta( $item_id, $key, true );
        return ( '' !== $value && false !== $value ) ? $value : $default;
    }

    /**
     * Check if a menu item has mega panel enabled.
     *
     * @param int $item_id Menu item ID.
     * @return bool
     */
    public static function is_mega_enabled( $item_id ) {
        return (bool) self::get_meta( $item_id, self::META_ENABLED, false );
    }
}
