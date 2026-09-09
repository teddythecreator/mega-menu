<?php
/**
 * Menu Fields - Metabox for menu items
 *
 * @package TCB_MegaMenu
 */

namespace TCB_MegaMenu;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Menu_Fields {

    const META_ENABLED   = '_tcb_enabled';
    const META_SOURCE    = '_tcb_source';
    const META_LAYOUT_ID = '_tcb_layout_id';
    const META_WIDTH     = '_tcb_width';
    const META_WIDTH_PX  = '_tcb_width_px';
    const META_ALIGN     = '_tcb_align';
    const META_ICON      = '_tcb_icon';
    const META_BADGE     = '_tcb_badge';

    const NONCE_ACTION = 'tcb_megamenu_nonce';
    const NONCE_NAME   = 'tcb_megamenu_nonce_field';

    public function render_fields( $item_id, $item, $depth, $args, $current_object_id ) {
        if ( $depth > 0 ) return;

        $enabled   = self::get_meta( $item_id, self::META_ENABLED, false );
        $source    = self::get_meta( $item_id, self::META_SOURCE, 'divi_layout' );
        $layout_id = self::get_meta( $item_id, self::META_LAYOUT_ID, 0 );
        $width     = self::get_meta( $item_id, self::META_WIDTH, 'full' );
        $width_px  = self::get_meta( $item_id, self::META_WIDTH_PX, 1200 );
        $align     = self::get_meta( $item_id, self::META_ALIGN, 'left' );
        $icon      = self::get_meta( $item_id, self::META_ICON, '' );
        $badge     = self::get_meta( $item_id, self::META_BADGE, '' );

        $layouts = Renderer::get_divi_layouts();
        ?>
        <div class="tcb-menu-fields" data-item-id="<?php echo esc_attr( $item_id ); ?>">
            <?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?>

            <p class="field-tcb-enabled description description-wide">
                <label for="edit-menu-item-tcb-enabled-<?php echo esc_attr( $item_id ); ?>">
                    <input type="checkbox"
                           id="edit-menu-item-tcb-enabled-<?php echo esc_attr( $item_id ); ?>"
                           class="edit-menu-item-tcb-enabled widefat"
                           name="tcb_enabled[<?php echo esc_attr( $item_id ); ?>]"
                           value="1"
                           <?php checked( $enabled, true ); ?> />
                    <strong><?php esc_html_e( 'Enable Mega Panel', 'tcb-megamenu' ); ?></strong>
                </label>
            </p>

            <div class="tcb-fields-container" <?php echo $enabled ? '' : 'style="display:none;"'; ?>>

                <p class="field-tcb-source description description-wide">
                    <label for="edit-menu-item-tcb-source-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Content Source', 'tcb-megamenu' ); ?>
                    </label>
                    <select id="edit-menu-item-tcb-source-<?php echo esc_attr( $item_id ); ?>"
                            class="widefat edit-menu-item-tcb-source"
                            name="tcb_source[<?php echo esc_attr( $item_id ); ?>]">
                        <option value="divi_layout" <?php selected( $source, 'divi_layout' ); ?>>
                            <?php esc_html_e( 'Divi Library Layout', 'tcb-megamenu' ); ?>
                        </option>
                        <option value="columns" <?php selected( $source, 'columns' ); ?>>
                            <?php esc_html_e( 'Custom Columns (no Divi needed)', 'tcb-megamenu' ); ?>
                        </option>
                    </select>
                </p>

                <div class="tcb-divi-fields" <?php echo $source === 'divi_layout' ? '' : 'style="display:none;"'; ?>>
                    <p class="field-tcb-layout-id description description-wide">
                        <label for="edit-menu-item-tcb-layout-id-<?php echo esc_attr( $item_id ); ?>">
                            <?php esc_html_e( 'Select Divi Layout', 'tcb-megamenu' ); ?>
                        </label>
                        <select id="edit-menu-item-tcb-layout-id-<?php echo esc_attr( $item_id ); ?>"
                                class="widefat edit-menu-item-tcb-layout-id"
                                name="tcb_layout_id[<?php echo esc_attr( $item_id ); ?>]">
                            <option value="0"><?php esc_html_e( '— Select a layout —', 'tcb-megamenu' ); ?></option>
                            <?php if ( ! empty( $layouts ) ) : ?>
                                <?php foreach ( $layouts as $layout ) : ?>
                                    <option value="<?php echo esc_attr( $layout->ID ); ?>" <?php selected( $layout_id, $layout->ID ); ?>>
                                        <?php echo esc_html( $layout->post_title ); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="" disabled><?php esc_html_e( 'No Divi layouts found', 'tcb-megamenu' ); ?></option>
                            <?php endif; ?>
                        </select>
                        <span class="description"><?php esc_html_e( 'Design your panel with Divi Builder and save as a Library layout', 'tcb-megamenu' ); ?></span>
                    </p>
                </div>

                <p class="field-tcb-width description description-wide">
                    <label for="edit-menu-item-tcb-width-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Panel Width', 'tcb-megamenu' ); ?>
                    </label>
                    <select id="edit-menu-item-tcb-width-<?php echo esc_attr( $item_id ); ?>"
                            class="widefat edit-menu-item-tcb-width"
                            name="tcb_width[<?php echo esc_attr( $item_id ); ?>]">
                        <option value="full" <?php selected( $width, 'full' ); ?>><?php esc_html_e( 'Full Width', 'tcb-megamenu' ); ?></option>
                        <option value="container" <?php selected( $width, 'container' ); ?>><?php esc_html_e( 'Container Width', 'tcb-megamenu' ); ?></option>
                        <option value="custom" <?php selected( $width, 'custom' ); ?>><?php esc_html_e( 'Custom Width', 'tcb-megamenu' ); ?></option>
                    </select>
                </p>

                <p class="field-tcb-width-px description description-wide" <?php echo $width === 'custom' ? '' : 'style="display:none;"'; ?>>
                    <label for="edit-menu-item-tcb-width-px-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Custom Width (px)', 'tcb-megamenu' ); ?>
                    </label>
                    <input type="number"
                           id="edit-menu-item-tcb-width-px-<?php echo esc_attr( $item_id ); ?>"
                           class="widefat code"
                           name="tcb_width_px[<?php echo esc_attr( $item_id ); ?>]"
                           value="<?php echo esc_attr( $width_px ); ?>"
                           min="600" max="2000" step="10" />
                </p>

                <p class="field-tcb-align description description-wide">
                    <label for="edit-menu-item-tcb-align-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Panel Alignment', 'tcb-megamenu' ); ?>
                    </label>
                    <select id="edit-menu-item-tcb-align-<?php echo esc_attr( $item_id ); ?>"
                            class="widefat"
                            name="tcb_align[<?php echo esc_attr( $item_id ); ?>]">
                        <option value="left" <?php selected( $align, 'left' ); ?>><?php esc_html_e( 'Left', 'tcb-megamenu' ); ?></option>
                        <option value="center" <?php selected( $align, 'center' ); ?>><?php esc_html_e( 'Center', 'tcb-megamenu' ); ?></option>
                        <option value="right" <?php selected( $align, 'right' ); ?>><?php esc_html_e( 'Right', 'tcb-megamenu' ); ?></option>
                    </select>
                </p>

                <p class="field-tcb-icon description description-wide">
                    <label for="edit-menu-item-tcb-icon-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Icon (optional)', 'tcb-megamenu' ); ?>
                    </label>
                    <input type="text"
                           id="edit-menu-item-tcb-icon-<?php echo esc_attr( $item_id ); ?>"
                           class="widefat code"
                           name="tcb_icon[<?php echo esc_attr( $item_id ); ?>]"
                           value="<?php echo esc_attr( $icon ); ?>" />
                    <span class="description"><?php esc_html_e( 'Divi icon class or custom SVG', 'tcb-megamenu' ); ?></span>
                </p>

                <p class="field-tcb-badge description description-wide">
                    <label for="edit-menu-item-tcb-badge-<?php echo esc_attr( $item_id ); ?>">
                        <?php esc_html_e( 'Badge (optional)', 'tcb-megamenu' ); ?>
                    </label>
                    <input type="text"
                           id="edit-menu-item-tcb-badge-<?php echo esc_attr( $item_id ); ?>"
                           class="widefat code"
                           name="tcb_badge[<?php echo esc_attr( $item_id ); ?>]"
                           value="<?php echo esc_attr( $badge ); ?>"
                           placeholder="<?php esc_attr_e( 'New, Sale, etc.', 'tcb-megamenu' ); ?>" />
                    <span class="description"><?php esc_html_e( 'Small label next to the menu item', 'tcb-megamenu' ); ?></span>
                </p>
            </div>
        </div>
        <?php
    }

    public function save_fields( $menu_id, $menu_item_db_id, $menu_item_args ) {
        if ( ! isset( $_POST[ self::NONCE_NAME ] ) || ! wp_verify_nonce( $_POST[ self::NONCE_NAME ], self::NONCE_ACTION ) ) {
            return;
        }

        if ( ! current_user_can( 'edit_theme_options' ) ) {
            return;
        }

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
            $post_key = str_replace( '_tcb_', 'tcb_', $meta_key );

            if ( isset( $_POST[ $post_key ][ $menu_item_db_id ] ) ) {
                $value = $_POST[ $post_key ][ $menu_item_db_id ];

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
                if ( $config['type'] === 'bool' ) {
                    update_post_meta( $menu_item_db_id, $meta_key, false );
                }
            }
        }
    }

    public static function get_meta( $item_id, $key, $default = '' ) {
        $value = get_post_meta( $item_id, $key, true );
        return ( '' !== $value && false !== $value ) ? $value : $default;
    }

    public static function is_mega_enabled( $item_id ) {
        return (bool) self::get_meta( $item_id, self::META_ENABLED, false );
    }
}
