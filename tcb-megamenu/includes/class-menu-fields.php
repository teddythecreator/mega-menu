<?php
/**
 * Menu Fields - Metabox for menu items
 * Professional UX/UI Design
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
            
            <!-- Header del Metabox -->
            <div class="tcb-metabox-header">
                <div class="tcb-metabox-icon">⚡</div>
                <h3 class="tcb-metabox-title"><?php esc_html_e( 'TCB Mega Menu', 'tcb-megamenu' ); ?></h3>
                <span class="tcb-metabox-badge"><?php esc_html_e( 'Pro', 'tcb-megamenu' ); ?></span>
            </div>
            
            <div class="tcb-metabox-content">
                <!-- Toggle Principal -->
                <div class="tcb-toggle-wrapper <?php echo $enabled ? 'active' : ''; ?>">
                    <label class="tcb-toggle-switch">
                        <input type="checkbox"
                               id="edit-menu-item-tcb-enabled-<?php echo esc_attr( $item_id ); ?>"
                               class="edit-menu-item-tcb-enabled"
                               name="tcb_enabled[<?php echo esc_attr( $item_id ); ?>]"
                               value="1"
                               <?php checked( $enabled, true ); ?> />
                        <span class="tcb-toggle-slider"></span>
                    </label>
                    <div style="flex: 1;">
                        <div class="tcb-toggle-label"><?php esc_html_e( 'Enable Mega Panel', 'tcb-megamenu' ); ?></div>
                        <div class="tcb-toggle-description"><?php esc_html_e( 'Transform this menu item into a mega menu', 'tcb-megamenu' ); ?></div>
                    </div>
                </div>

                <!-- Campos Condicionales -->
                <div class="tcb-fields-container" <?php echo $enabled ? '' : 'style="display:none;"'; ?>>
                    
                    <!-- Content Source -->
                    <div class="tcb-field-group">
                        <label class="tcb-field-label" for="edit-menu-item-tcb-source-<?php echo esc_attr( $item_id ); ?>">
                            <?php esc_html_e( 'Content Source', 'tcb-megamenu' ); ?>
                            <span class="tcb-required">*</span>
                        </label>
                        <select id="edit-menu-item-tcb-source-<?php echo esc_attr( $item_id ); ?>"
                                class="tcb-field-input tcb-field-select edit-menu-item-tcb-source"
                                name="tcb_source[<?php echo esc_attr( $item_id ); ?>]">
                            <option value="divi_layout" <?php selected( $source, 'divi_layout' ); ?>>
                                🎨 <?php esc_html_e( 'Divi Library Layout', 'tcb-megamenu' ); ?>
                            </option>
                            <option value="columns" <?php selected( $source, 'columns' ); ?>>
                                📋 <?php esc_html_e( 'Custom Columns (no Divi)', 'tcb-megamenu' ); ?>
                            </option>
                        </select>
                        <div class="tcb-field-description">
                            <?php esc_html_e( 'Choose how to populate your mega menu content', 'tcb-megamenu' ); ?>
                        </div>
                    </div>

                    <!-- Divi Layout Selector -->
                    <div class="tcb-divi-fields" <?php echo $source === 'divi_layout' ? '' : 'style="display:none;"'; ?>>
                        <div class="tcb-field-group">
                            <label class="tcb-field-label" for="edit-menu-item-tcb-layout-id-<?php echo esc_attr( $item_id ); ?>">
                                <?php esc_html_e( 'Select Divi Layout', 'tcb-megamenu' ); ?>
                            </label>
                            <select id="edit-menu-item-tcb-layout-id-<?php echo esc_attr( $item_id ); ?>"
                                    class="tcb-field-input tcb-field-select edit-menu-item-tcb-layout-id"
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
                            <div class="tcb-field-description">
                                <?php esc_html_e( 'Design your panel with Divi Builder and save as a Library layout', 'tcb-megamenu' ); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Layout Options -->
                    <div class="tcb-field-row">
                        <!-- Panel Width -->
                        <div class="tcb-field-group">
                            <label class="tcb-field-label" for="edit-menu-item-tcb-width-<?php echo esc_attr( $item_id ); ?>">
                                <?php esc_html_e( 'Panel Width', 'tcb-megamenu' ); ?>
                            </label>
                            <select id="edit-menu-item-tcb-width-<?php echo esc_attr( $item_id ); ?>"
                                    class="tcb-field-input tcb-field-select edit-menu-item-tcb-width"
                                    name="tcb_width[<?php echo esc_attr( $item_id ); ?>]">
                                <option value="full" <?php selected( $width, 'full' ); ?>>↔️ <?php esc_html_e( 'Full Width', 'tcb-megamenu' ); ?></option>
                                <option value="container" <?php selected( $width, 'container' ); ?>>📦 <?php esc_html_e( 'Container Width', 'tcb-megamenu' ); ?></option>
                                <option value="custom" <?php selected( $width, 'custom' ); ?>>⚙️ <?php esc_html_e( 'Custom Width', 'tcb-megamenu' ); ?></option>
                            </select>
                        </div>

                        <!-- Panel Alignment -->
                        <div class="tcb-field-group">
                            <label class="tcb-field-label" for="edit-menu-item-tcb-align-<?php echo esc_attr( $item_id ); ?>">
                                <?php esc_html_e( 'Panel Alignment', 'tcb-megamenu' ); ?>
                            </label>
                            <select id="edit-menu-item-tcb-align-<?php echo esc_attr( $item_id ); ?>"
                                    class="tcb-field-input tcb-field-select"
                                    name="tcb_align[<?php echo esc_attr( $item_id ); ?>]">
                                <option value="left" <?php selected( $align, 'left' ); ?>>⬅️ <?php esc_html_e( 'Left', 'tcb-megamenu' ); ?></option>
                                <option value="center" <?php selected( $align, 'center' ); ?>>⬛ <?php esc_html_e( 'Center', 'tcb-megamenu' ); ?></option>
                                <option value="right" <?php selected( $align, 'right' ); ?>>➡️ <?php esc_html_e( 'Right', 'tcb-megamenu' ); ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- Custom Width (conditional) -->
                    <div class="tcb-field-group field-tcb-width-px" <?php echo $width === 'custom' ? '' : 'style="display:none;"'; ?>>
                        <label class="tcb-field-label" for="edit-menu-item-tcb-width-px-<?php echo esc_attr( $item_id ); ?>">
                            <?php esc_html_e( 'Custom Width (px)', 'tcb-megamenu' ); ?>
                        </label>
                        <input type="number"
                               id="edit-menu-item-tcb-width-px-<?php echo esc_attr( $item_id ); ?>"
                               class="tcb-field-input"
                               name="tcb_width_px[<?php echo esc_attr( $item_id ); ?>]"
                               value="<?php echo esc_attr( $width_px ); ?>"
                               min="600" max="2000" step="10" />
                        <div class="tcb-field-description">
                            <?php esc_html_e( 'Width in pixels (600-2000px)', 'tcb-megamenu' ); ?>
                        </div>
                    </div>

                    <!-- Icon & Badge -->
                    <div class="tcb-field-row">
                        <div class="tcb-field-group">
                            <label class="tcb-field-label" for="edit-menu-item-tcb-icon-<?php echo esc_attr( $item_id ); ?>">
                                <?php esc_html_e( 'Icon (optional)', 'tcb-megamenu' ); ?>
                            </label>
                            <input type="text"
                                   id="edit-menu-item-tcb-icon-<?php echo esc_attr( $item_id ); ?>"
                                   class="tcb-field-input"
                                   name="tcb_icon[<?php echo esc_attr( $item_id ); ?>]"
                                   value="<?php echo esc_attr( $icon ); ?>"
                                   placeholder="🎯 dashicons-class or SVG" />
                        </div>

                        <div class="tcb-field-group">
                            <label class="tcb-field-label" for="edit-menu-item-tcb-badge-<?php echo esc_attr( $item_id ); ?>">
                                <?php esc_html_e( 'Badge (optional)', 'tcb-megamenu' ); ?>
                            </label>
                            <input type="text"
                                   id="edit-menu-item-tcb-badge-<?php echo esc_attr( $item_id ); ?>"
                                   class="tcb-field-input"
                                   name="tcb_badge[<?php echo esc_attr( $item_id ); ?>]"
                                   value="<?php echo esc_attr( $badge ); ?>"
                                   placeholder="<?php esc_attr_e( 'New, Sale, Hot...', 'tcb-megamenu' ); ?>" />
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="tcb-info-box">
                        <div class="tcb-info-box-icon">💡</div>
                        <div class="tcb-info-box-content">
                            <strong><?php esc_html_e( 'Pro Tip:', 'tcb-megamenu' ); ?></strong>
                            <?php esc_html_e( 'Use Divi Library layouts for complex designs, or Custom Columns for simple link lists. Both options are fully responsive and accessible.', 'tcb-megamenu' ); ?>
                        </div>
                    </div>
                </div>
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
