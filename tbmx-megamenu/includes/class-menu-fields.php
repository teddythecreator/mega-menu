<?php
/**
 * Menu Fields - Metabox for menu items
 *
 * Adds custom fields to each menu item in Appearance > Menus:
 * - Enable mega panel (checkbox)
 * - Select Divi Library layout (dropdown)
 * - Panel width, alignment, icon, badge
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
     * Nonce action
     */
    const NONCE_ACTION = 'tbmx_megamenu_nonce';

    /**
     * Nonce name
     */
    const NONCE_NAME = 'tbmx_megamenu_nonce_field';

    /**
     * Render custom fields for a menu item.
     *
     * Hooked to: wp_nav_menu_item_custom_fields
     *
     * @param int        $item_id    Menu item ID.
     * @param object     $item       Menu item object.
     * @param int        $depth      Depth of menu item.
     * @param \stdClass  $args       An object of wp_nav_menu() arguments.
     * @param int        $current_object_id Current object ID.
     */
    public function render_fields( $item_id, $item, $depth, $args, $current_object_id ) {
        // Only show for top-level items (depth 0)
        if ( $depth > 0 ) {
            return;
        }

        // Get current values
        $enabled   = self::get_meta( $item_id, self::META_ENABLED, false );
        $source    = self::get_meta( $item_id, self::META_SOURCE, 'divi_layout' );
        $layout_id = self::get_meta( $item_id, self::META_LAYOUT_ID, 0 );
        $width     = self::get_meta( $item_id, self::META_WIDTH, 'full' );
        $width_px  = self::get_meta( $item_id, self::META_WIDTH_PX, 1200 );
        $align     = self::get_meta( $item_id, self::META_ALIGN, 'left' );
        $icon      = self::get_meta( $item_id, self::META_ICON, '' );
        $badge     = self::get_meta( $item_id, self::META_BADGE, '' );

        // Get available Divi layouts
        $layouts = Renderer::get_divi_layouts();
        ?>
        <div class="tbmx-menu-fields" data-item-id="<?php echo esc_attr( $item_id ); ?>">
            <?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?>

            <p class="field-tbmx-enabled description description-wide">
                <label for="edit-menu-item-tbmx-enabled-<?php echo esc_attr( $item_id ); ?>">
                    <input type="checkbox"
                           id="edit-menu-item-tbmx-enabled-<?php echo esc_attr( $item_id ); ?>"
                           class="edit-menu-item-tbmx-enabled"
                           name="tbmx_enabled[<?php echo esc_attr( $item_id ); ?>]"
                           value="1"
                           <?php checked( $enabled, true ); ?> />
                    <?php esc_html_e( 'Enable Mega Panel', 'tbmx-megamenu' ); ?>
                </label>
                <span class="description"><?php esc_html_e( 'Convert this menu item into a mega menu trigger', 'tbmx-megamenu' ); ?></span>
            </p>

            <div class="tbmx-fields-container" <?php echo $enabled ? '' : 'style="display:none;"'; ?>>
                <p class="field-tbmx-source description description-wide">
                    <label for="edit-menu-item-tbmx-source-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Content Source', 'tbmx-megamenu' ); ?>
                    </label>
                    <select id="edit-menu-item-tbmx-source-<?php echo esc_attr( $item_id ); ?>"
                            class="widefat edit-menu-item-tbmx-source"
                            name="tbmx_source[<?php echo esc_attr( $item_id ); ?>]">
                        <option value="divi_layout" <?php selected( $source, 'divi_layout' ); ?>>
                            <?php esc_html_e( 'Divi Library Layout', 'tbmx-megamenu' ); ?>
                        </option>
                        <option value="columns" <?php selected( $source, 'columns' ); ?>>
                            <?php esc_html_e( 'Custom Columns (no Divi)', 'tbmx-megamenu' ); ?>
                        </option>
                    </select>
                </p>

                <div class="tbmx-divi-fields" <?php echo $source === 'divi_layout' ? '' : 'style="display:none;"'; ?>>
                    <p class="field-tbmx-layout-id description description-wide">
                        <label for="edit-menu-item-tbmx-layout-id-<?php echo esc_attr( $item_id ); ?>">
                            <?php esc_html_e( 'Select Divi Layout', 'tbmx-megamenu' ); ?>
                        </label>
                        <select id="edit-menu-item-tbmx-layout-id-<?php echo esc_attr( $item_id ); ?>"
                                class="widefat edit-menu-item-tbmx-layout-id"
                                name="tbmx_layout_id[<?php echo esc_attr( $item_id ); ?>]">
                            <option value="0"><?php esc_html_e( '— Select a layout —', 'tbmx-megamenu' ); ?></option>
                            <?php if ( ! empty( $layouts ) ) : ?>
                                <?php foreach ( $layouts as $layout ) : ?>
                                    <option value="<?php echo esc_attr( $layout->ID ); ?>" <?php selected( $layout_id, $layout->ID ); ?>>
                                        <?php echo esc_html( $layout->post_title ); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="" disabled><?php esc_html_e( 'No Divi layouts found', 'tbmx-megamenu' ); ?></option>
                            <?php endif; ?>
                        </select>
                        <span class="description">
                            <?php esc_html_e( 'Design your panel with Divi Builder and save as a Library layout', 'tbmx-megamenu' ); ?>
                        </span>
                    </p>
                </div>

                <p class="field-tbmx-width description description-wide">
                    <label for="edit-menu-item-tbmx-width-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Panel Width', 'tbmx-megamenu' ); ?>
                    </label>
                    <select id="edit-menu-item-tbmx-width-<?php echo esc_attr( $item_id ); ?>"
                            class="widefat edit-menu-item-tbmx-width"
                            name="tbmx_width[<?php echo esc_attr( $item_id ); ?>]">
                        <option value="full" <?php selected( $width, 'full' ); ?>>
                            <?php esc_html_e( 'Full Width', 'tbmx-megamenu' ); ?>
                        </option>
                        <option value="container" <?php selected( $width, 'container' ); ?>>
                            <?php esc_html_e( 'Container Width', 'tbmx-megamenu' ); ?>
                        </option>
                        <option value="custom" <?php selected( $width, 'custom' ); ?>>
                            <?php esc_html_e( 'Custom Width', 'tbmx-megamenu' ); ?>
                        </option>
                    </select>
                </p>

                <p class="field-tbmx-width-px description description-wide" <?php echo $width === 'custom' ? '' : 'style="display:none;"'; ?>>
                    <label for="edit-menu-item-tbmx-width-px-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Custom Width (px)', 'tbmx-megamenu' ); ?>
                    </label>
                    <input type="number"
                           id="edit-menu-item-tbmx-width-px-<?php echo esc_attr( $item_id ); ?>"
                           class="widefat code edit-menu-item-tbmx-width-px"
                           name="tbmx_width_px[<?php echo esc_attr( $item_id ); ?>]"
                           value="<?php echo esc_attr( $width_px ); ?>"
                           min="600"
                           max="2000"
                           step="10" />
                </p>

                <p class="field-tbmx-align description description-wide">
                    <label for="edit-menu-item-tbmx-align-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Panel Alignment', 'tbmx-megamenu' ); ?>
                    </label>
                    <select id="edit-menu-item-tbmx-align-<?php echo esc_attr( $item_id ); ?>"
                            class="widefat edit-menu-item-tbmx-align"
                            name="tbmx_align[<?php echo esc_attr( $item_id ); ?>]">
                        <option value="left" <?php selected( $align, 'left' ); ?>>
                            <?php esc_html_e( 'Left', 'tbmx-megamenu' ); ?>
                        </option>
                        <option value="center" <?php selected( $align, 'center' ); ?>>
                            <?php esc_html_e( 'Center', 'tbmx-megamenu' ); ?>
                        </option>
                        <option value="right" <?php selected( $align, 'right' ); ?>>
                            <?php esc_html_e( 'Right', 'tbmx-megamenu' ); ?>
                        </option>
                    </select>
                </p>

                <p class="field-tbmx-icon description description-wide">
                    <label for="edit-menu-item-tbmx-icon-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Icon (optional)', 'tbmx-megamenu' ); ?>
                    </label>
                    <input type="text"
                           id="edit-menu-item-tbmx-icon-<?php echo esc_attr( $item_id ); ?>"
                           class="widefat code edit-menu-item-tbmx-icon"
                           name="tbmx_icon[<?php echo esc_attr( $item_id ); ?>]"
                           value="<?php echo esc_attr( $icon ); ?>"
                           placeholder="et-pb-icon-..." />
                    <span class="description"><?php esc_html_e( 'Divi icon class or custom SVG', 'tbmx-megamenu' ); ?></span>
                </p>

                <p class="field-tbmx-badge description description-wide">
                    <label for="edit-menu-item-tbmx-badge-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Badge (optional)', 'tbmx-megamenu' ); ?>
                    </label>
                    <input type="text"
                           id="edit-menu-item-tbmx-badge-<?php echo esc_attr( $item_id ); ?>"
                           class="widefat code edit-menu-item-tbmx-badge"
                           name="tbmx_badge[<?php echo esc_attr( $item_id ); ?>]"
                           value="<?php echo esc_attr( $badge ); ?>"
                           placeholder="<?php esc_attr_e( 'New, Sale, etc.', 'tbmx-megamenu' ); ?>" />
                    <span class="description"><?php esc_html_e( 'Small label next to the menu item', 'tbmx-megamenu' ); ?></span>
                </p>
            </div>
        </div>
        <?php
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
        // Check nonce
        if ( ! isset( $_POST[ self::NONCE_NAME ] ) || ! wp_verify_nonce( $_POST[ self::NONCE_NAME ], self::NONCE_ACTION ) ) {
            return;
        }

        // Check capability
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            return;
        }

        // Save each meta field with sanitization
        $fields = array(
            self::META_ENABLED   => array( 'type' => 'bool', 'default' => false ),
            self::META_SOURCE    => array( 'type' => 'select', 'options' => array( 'divi_layout', 'columns' ), 'default' => 'divi_layout' ),
            self::META_LAYOUT_ID => array( 'type' => 'int', 'default' => 0 ),
            self::META_WIDTH     => array( 'type' => 'select', 'options' => array( 'full', 'container', 'custom' ), 'default' => 'full' ),
            self::META_WIDTH_PX  => array( 'type' => 'int', 'default' => 1200 ),
            self::META_ALIGN     => array( 'type' => 'select', 'options' => array( 'left', 'center', 'right' ), 'default' => 'left' ),
            self::META_ICON      => array( 'type' => 'text', 'default' => '' ),
            self::META_BADGE     => array( 'type' => 'text', 'default' => '' ),
        );

        foreach ( $fields as $meta_key => $config ) {
            $post_key = str_replace( '_tbmx_', 'tbmx_', $meta_key );

            if ( isset( $_POST[ $post_key ][ $menu_item_db_id ] ) ) {
                $value = $_POST[ $post_key ][ $menu_item_db_id ];

                // Sanitize based on type
                switch ( $config['type'] ) {
                    case 'bool':
                        $value = $value ? true : false;
                        break;

                    case 'int':
                        $value = absint( $value );
                        break;

                    case 'select':
                        if ( ! in_array( $value, $config['options'], true ) ) {
                            $value = $config['default'];
                        }
                        break;

                    case 'text':
                    default:
                        $value = sanitize_text_field( $value );
                        break;
                }

                update_post_meta( $menu_item_db_id, $meta_key, $value );
            } else {
                // Field not submitted (checkbox unchecked)
                if ( $config['type'] === 'bool' ) {
                    update_post_meta( $menu_item_db_id, $meta_key, false );
                }
            }
        }
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
