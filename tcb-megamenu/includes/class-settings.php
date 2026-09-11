<?php
/**
 * Settings - Global plugin settings page
 *
 * @package TCB_MegaMenu
 */

namespace TCB_MegaMenu;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Settings {

    const OPTION_NAME = 'tcb_megamenu_settings';
    const PAGE_SLUG   = 'tcb-megamenu';

    /**
     * Get default settings
     */
    public static function get_defaults() {
        return array(
            // Colors
            'bg'         => '#ffffff',
            'fg'         => '#333333',
            'muted'      => '#666666',
            'accent'     => '#e11414',
            'border'     => 'rgba(0,0,0,.08)',
            
            // Layout
            'radius'     => '10px',
            'shadow'     => '0 24px 60px rgba(0,0,0,.15)',
            'font'       => 'inherit',
            'gap'        => '32px',
            'anim'       => '.22s',
            
            // Desktop
            'width'      => 'full',
            'width_px'   => 1200,
            'hover_in'   => 120,
            'hover_out'  => 200,
            
            // Mobile
            'breakpoint'         => 980,
            'mobile_style'       => 'accordion',
            'mobile_position'    => 'left',
            'mobile_width'       => 300,
            'hamburger_icon'     => 'classic',
            'hamburger_color'    => '#333333',
            'hamburger_size'     => 24,
            'hamburger_thickness'=> 2,
            
            // Advanced
            'scroll_lock'        => true,
            'close_on_outside'   => true,
            'keyboard_nav'       => true,
        );
    }

    /**
     * Get current settings
     */
    public static function get_settings() {
        $saved = get_option( self::OPTION_NAME, array() );
        return wp_parse_args( $saved, self::get_defaults() );
    }

    /**
     * Add settings page
     */
    public function add_settings_page() {
        add_menu_page(
            'TCB MegaMenu',
            'TCB MegaMenu',
            'edit_theme_options',
            self::PAGE_SLUG,
            array( $this, 'render_page' ),
            'dashicons-screenoptions',
            61
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting(
            'tcb_megamenu_group',
            self::OPTION_NAME,
            array( 'sanitize_callback' => array( __CLASS__, 'sanitize' ) )
        );

        // Handle reset actions
        $this->handle_reset_actions();
    }

    /**
     * Handle reset actions
     */
    private function handle_reset_actions() {
        if ( ! isset( $_POST['tcb_reset_action'] ) ) {
            return;
        }

        if ( ! current_user_can( 'edit_theme_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['tcb_reset_nonce'], 'tcb_reset_action' ) ) {
            return;
        }

        $action = sanitize_text_field( $_POST['tcb_reset_action'] );

        switch ( $action ) {
            case 'reset_settings':
                delete_option( self::OPTION_NAME );
                add_settings_error( 'tcb_megamenu', 'settings_reset', __( 'Settings have been reset to defaults.', 'tcb-megamenu' ), 'success' );
                break;

            case 'reset_menu_data':
                $this->reset_menu_data();
                add_settings_error( 'tcb_megamenu', 'menu_data_reset', __( 'All menu configurations have been removed.', 'tcb-megamenu' ), 'success' );
                break;

            case 'reset_all':
                delete_option( self::OPTION_NAME );
                $this->reset_menu_data();
                add_settings_error( 'tcb_megamenu', 'all_reset', __( 'All plugin data has been removed.', 'tcb-megamenu' ), 'success' );
                break;
        }
    }

    /**
     * Reset all menu item meta data
     */
    private function reset_menu_data() {
        global $wpdb;

        $meta_keys = array(
            '_tcb_enabled',
            '_tcb_source',
            '_tcb_layout_id',
            '_tcb_width',
            '_tcb_width_px',
            '_tcb_align',
            '_tcb_icon',
            '_tcb_badge',
        );

        foreach ( $meta_keys as $key ) {
            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM {$wpdb->postmeta} WHERE meta_key = %s",
                    $key
                )
            );
        }
    }

    /**
     * Get statistics
     */
    private function get_stats() {
        global $wpdb;

        $stats = array(
            'mega_items' => 0,
            'divi_layouts' => 0,
            'custom_columns' => 0,
        );

        // Count mega menu items
        $stats['mega_items'] = (int) $wpdb->get_var(
            "SELECT COUNT(DISTINCT post_id) FROM {$wpdb->postmeta} WHERE meta_key = '_tcb_enabled' AND meta_value = '1'"
        );

        // Count by source
        $stats['divi_layouts'] = (int) $wpdb->get_var(
            "SELECT COUNT(DISTINCT post_id) FROM {$wpdb->postmeta} WHERE meta_key = '_tcb_source' AND meta_value = 'divi_layout'"
        );

        $stats['custom_columns'] = (int) $wpdb->get_var(
            "SELECT COUNT(DISTINCT post_id) FROM {$wpdb->postmeta} WHERE meta_key = '_tcb_source' AND meta_value = 'columns'"
        );

        return $stats;
    }

    /**
     * Render settings page
     */
    public function render_page() {
        if ( ! current_user_can( 'edit_theme_options' ) ) return;
        
        $settings = self::get_settings();
        $stats = $this->get_stats();
        $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'colors';
        ?>
        <div class="wrap">
            <h1>
                <span class="dashicons dashicons-screenoptions" style="font-size: 30px; margin-right: 10px; color: #e11414;"></span>
                TCB MegaMenu Settings
            </h1>

            <!-- Status Bar -->
            <div style="background: #fff; padding: 15px 20px; margin: 20px 0; border: 1px solid #ccd0d4; border-left: 4px solid #46b450;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong style="color: #46b450;">✓ Plugin Active</strong>
                        <span style="margin-left: 20px; color: #666;">
                            <strong><?php echo esc_html( $stats['mega_items'] ); ?></strong> mega menus | 
                            <strong><?php echo esc_html( $stats['divi_layouts'] ); ?></strong> Divi layouts | 
                            <strong><?php echo esc_html( $stats['custom_columns'] ); ?></strong> Custom columns
                        </span>
                    </div>
                    <div>
                        <span style="color: #666; font-size: 12px;">v<?php echo esc_html( TCB_MEGAMENU_VERSION ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <h2 class="nav-tab-wrapper" style="margin-bottom: 20px;">
                <a href="?page=<?php echo self::PAGE_SLUG; ?>&tab=colors" class="nav-tab <?php echo $active_tab === 'colors' ? 'nav-tab-active' : ''; ?>">🎨 Colors</a>
                <a href="?page=<?php echo self::PAGE_SLUG; ?>&tab=layout" class="nav-tab <?php echo $active_tab === 'layout' ? 'nav-tab-active' : ''; ?>">📐 Layout</a>
                <a href="?page=<?php echo self::PAGE_SLUG; ?>&tab=desktop" class="nav-tab <?php echo $active_tab === 'desktop' ? 'nav-tab-active' : ''; ?>">🖥️ Desktop</a>
                <a href="?page=<?php echo self::PAGE_SLUG; ?>&tab=mobile" class="nav-tab <?php echo $active_tab === 'mobile' ? 'nav-tab-active' : ''; ?>">📱 Mobile</a>
                <a href="?page=<?php echo self::PAGE_SLUG; ?>&tab=advanced" class="nav-tab <?php echo $active_tab === 'advanced' ? 'nav-tab-active' : ''; ?>">⚙️ Advanced</a>
                <a href="?page=<?php echo self::PAGE_SLUG; ?>&tab=data" class="nav-tab <?php echo $active_tab === 'data' ? 'nav-tab-active' : ''; ?>">💾 Data</a>
            </h2>

            <form method="post" action="options.php">
                <?php settings_fields( 'tcb_megamenu_group' ); ?>

                <?php if ( $active_tab === 'colors' ) : ?>
                    <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;">
                        <h2 style="margin-top:0;">🎨 Colors</h2>
                        <p style="color: #666; margin-bottom: 20px;">Configure the visual appearance of your mega menus.</p>
                        
                        <table class="form-table">
                            <tr>
                                <th><label for="tcb_bg">Background Color</label></th>
                                <td>
                                    <input type="color" id="tcb_bg" name="<?php echo self::OPTION_NAME; ?>[bg]" value="<?php echo esc_attr( $settings['bg'] ); ?>" />
                                    <p class="description">Background color of the mega menu panel. Choose a color that complements your theme.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_fg">Text Color</label></th>
                                <td>
                                    <input type="color" id="tcb_fg" name="<?php echo self::OPTION_NAME; ?>[fg]" value="<?php echo esc_attr( $settings['fg'] ); ?>" />
                                    <p class="description">Main text color. Ensure good contrast with the background color.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_muted">Muted Text Color</label></th>
                                <td>
                                    <input type="text" id="tcb_muted" name="<?php echo self::OPTION_NAME; ?>[muted]" value="<?php echo esc_attr( $settings['muted'] ); ?>" class="regular-text" />
                                    <p class="description">Secondary text color (descriptions, hints). Can be hex (#666) or rgba.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_accent">Accent Color</label></th>
                                <td>
                                    <input type="color" id="tcb_accent" name="<?php echo self::OPTION_NAME; ?>[accent]" value="<?php echo esc_attr( $settings['accent'] ); ?>" />
                                    <p class="description">Accent color for hover states, badges, and highlights. Use your brand color.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_border">Border Color</label></th>
                                <td>
                                    <input type="text" id="tcb_border" name="<?php echo self::OPTION_NAME; ?>[border]" value="<?php echo esc_attr( $settings['border'] ); ?>" class="regular-text" />
                                    <p class="description">Border color for panels and separators. Can be hex or rgba for transparency.</p>
                                </td>
                            </tr>
                        </table>

                        <?php submit_button( 'Save Colors' ); ?>
                    </div>

                <?php elseif ( $active_tab === 'layout' ) : ?>
                    <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;">
                        <h2 style="margin-top:0;">📐 Layout & Typography</h2>
                        <p style="color: #666; margin-bottom: 20px;">Control spacing, borders, and typography of your mega menus.</p>
                        
                        <table class="form-table">
                            <tr>
                                <th><label for="tcb_radius">Border Radius</label></th>
                                <td>
                                    <input type="text" id="tcb_radius" name="<?php echo self::OPTION_NAME; ?>[radius]" value="<?php echo esc_attr( $settings['radius'] ); ?>" class="small-text" />
                                    <p class="description">Corner rounding for panels. Examples: 10px (rounded), 0 (square), 5px (subtle).</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_shadow">Box Shadow</label></th>
                                <td>
                                    <input type="text" id="tcb_shadow" name="<?php echo self::OPTION_NAME; ?>[shadow]" value="<?php echo esc_attr( $settings['shadow'] ); ?>" class="regular-text" />
                                    <p class="description">Shadow effect for panels. Use CSS box-shadow syntax. Leave empty for no shadow.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_font">Font Family</label></th>
                                <td>
                                    <input type="text" id="tcb_font" name="<?php echo self::OPTION_NAME; ?>[font]" value="<?php echo esc_attr( $settings['font'] ); ?>" class="regular-text" />
                                    <p class="description">Font family for mega menu text. Use "inherit" to use your theme's font.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_gap">Gap/Spacing</label></th>
                                <td>
                                    <input type="text" id="tcb_gap" name="<?php echo self::OPTION_NAME; ?>[gap]" value="<?php echo esc_attr( $settings['gap'] ); ?>" class="small-text" />
                                    <p class="description">Spacing between elements. Examples: 32px, 2rem, clamp(16px, 2vw, 32px).</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_anim">Animation Duration</label></th>
                                <td>
                                    <input type="text" id="tcb_anim" name="<?php echo self::OPTION_NAME; ?>[anim]" value="<?php echo esc_attr( $settings['anim'] ); ?>" class="small-text" />
                                    <p class="description">Duration of open/close animations. Examples: .22s, 300ms.</p>
                                </td>
                            </tr>
                        </table>

                        <?php submit_button( 'Save Layout' ); ?>
                    </div>

                <?php elseif ( $active_tab === 'desktop' ) : ?>
                    <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;">
                        <h2 style="margin-top:0;">🖥️ Desktop Behavior</h2>
                        <p style="color: #666; margin-bottom: 20px;">Configure how mega menus behave on desktop devices.</p>
                        
                        <table class="form-table">
                            <tr>
                                <th><label for="tcb_hover_in">Hover In Delay</label></th>
                                <td>
                                    <input type="number" id="tcb_hover_in" name="<?php echo self::OPTION_NAME; ?>[hover_in]" value="<?php echo esc_attr( $settings['hover_in'] ); ?>" class="small-text" min="0" max="1000" /> ms
                                    <p class="description">Delay before opening the panel when hovering. Lower = more responsive, higher = less accidental.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_hover_out">Hover Out Delay</label></th>
                                <td>
                                    <input type="number" id="tcb_hover_out" name="<?php echo self::OPTION_NAME; ?>[hover_out]" value="<?php echo esc_attr( $settings['hover_out'] ); ?>" class="small-text" min="0" max="1000" /> ms
                                    <p class="description">Delay before closing the panel when mouse leaves. Allows smooth transition between items.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_width">Default Panel Width</label></th>
                                <td>
                                    <select id="tcb_width" name="<?php echo self::OPTION_NAME; ?>[width]">
                                        <option value="full" <?php selected( $settings['width'], 'full' ); ?>>Full Width (100vw)</option>
                                        <option value="container" <?php selected( $settings['width'], 'container' ); ?>>Container Width (max 1200px)</option>
                                        <option value="custom" <?php selected( $settings['width'], 'custom' ); ?>>Custom Width</option>
                                    </select>
                                    <p class="description">Default width for mega menu panels. Can be overridden per menu item.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_width_px">Custom Width</label></th>
                                <td>
                                    <input type="number" id="tcb_width_px" name="<?php echo self::OPTION_NAME; ?>[width_px]" value="<?php echo esc_attr( $settings['width_px'] ); ?>" class="small-text" min="600" max="2000" /> px
                                    <p class="description">Width in pixels when "Custom Width" is selected above.</p>
                                </td>
                            </tr>
                        </table>

                        <?php submit_button( 'Save Desktop Settings' ); ?>
                    </div>

                <?php elseif ( $active_tab === 'mobile' ) : ?>
                    <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;">
                        <h2 style="margin-top:0;">📱 Mobile Settings</h2>
                        <p style="color: #666; margin-bottom: 20px;">Configure the mobile menu experience.</p>
                        
                        <table class="form-table">
                            <tr>
                                <th><label for="tcb_breakpoint">Mobile Breakpoint</label></th>
                                <td>
                                    <input type="number" id="tcb_breakpoint" name="<?php echo self::OPTION_NAME; ?>[breakpoint]" value="<?php echo esc_attr( $settings['breakpoint'] ); ?>" class="small-text" min="320" max="1400" /> px
                                    <p class="description">Screen width where mobile menu activates. Match your theme's breakpoint.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_mobile_style">Mobile Menu Style</label></th>
                                <td>
                                    <select id="tcb_mobile_style" name="<?php echo self::OPTION_NAME; ?>[mobile_style]; ?>">
                                        <option value="accordion" <?php selected( $settings['mobile_style'], 'accordion' ); ?>>📋 Accordion (Vertical)</option>
                                        <option value="drawer" <?php selected( $settings['mobile_style'], 'drawer' ); ?>>📥 Drawer (Lateral)</option>
                                        <option value="overlay" <?php selected( $settings['mobile_style'], 'overlay' ); ?>>🔲 Overlay (Fullscreen)</option>
                                        <option value="slide" <?php selected( $settings['mobile_style'], 'slide' ); ?>>📤 Slide Down</option>
                                    </select>
                                    <p class="description">Style of the mobile menu. Accordion is simplest, Overlay is most immersive.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_mobile_position">Drawer Position</label></th>
                                <td>
                                    <select id="tcb_mobile_position" name="<?php echo self::OPTION_NAME; ?>[mobile_position]; ?>">
                                        <option value="left" <?php selected( $settings['mobile_position'], 'left' ); ?>>← Left</option>
                                        <option value="right" <?php selected( $settings['mobile_position'], 'right' ); ?>>→ Right</option>
                                    </select>
                                    <p class="description">Position of the drawer (only for Drawer style).</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_mobile_width">Drawer Width</label></th>
                                <td>
                                    <input type="number" id="tcb_mobile_width" name="<?php echo self::OPTION_NAME; ?>[mobile_width]; ?>" value="<?php echo esc_attr( $settings['mobile_width'] ); ?>" class="small-text" min="200" max="500" /> px
                                    <p class="description">Width of the drawer (only for Drawer style).</p>
                                </td>
                            </tr>
                        </table>

                        <h3>🍔 Hamburger Icon</h3>
                        <table class="form-table">
                            <tr>
                                <th><label for="tcb_hamburger_icon">Icon Style</label></th>
                                <td>
                                    <select id="tcb_hamburger_icon" name="<?php echo self::OPTION_NAME; ?>[hamburger_icon]; ?>">
                                        <option value="classic" <?php selected( $settings['hamburger_icon'], 'classic' ); ?>>☰ Classic (3 lines)</option>
                                        <option value="arrow" <?php selected( $settings['hamburger_icon'], 'arrow' ); ?>>← Arrow</option>
                                        <option value="dots" <?php selected( $settings['hamburger_icon'], 'dots' ); ?>>⋮ Dots (Vertical)</option>
                                        <option value="plus" <?php selected( $settings['hamburger_icon'], 'plus' ); ?>>+ Plus/Minus</option>
                                        <option value="x" <?php selected( $settings['hamburger_icon'], 'x' ); ?>>✕ X Mark</option>
                                    </select>
                                    <p class="description">Style of the hamburger icon.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_hamburger_color">Icon Color</label></th>
                                <td>
                                    <input type="color" id="tcb_hamburger_color" name="<?php echo self::OPTION_NAME; ?>[hamburger_color]; ?>" value="<?php echo esc_attr( $settings['hamburger_color'] ); ?>" />
                                    <p class="description">Color of the hamburger icon. Should contrast with your header background.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_hamburger_size">Icon Size</label></th>
                                <td>
                                    <input type="number" id="tcb_hamburger_size" name="<?php echo self::OPTION_NAME; ?>[hamburger_size]; ?>" value="<?php echo esc_attr( $settings['hamburger_size'] ); ?>" class="small-text" min="16" max="48" /> px
                                    <p class="description">Size of the hamburger icon in pixels.</p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="tcb_hamburger_thickness">Line Thickness</label></th>
                                <td>
                                    <input type="number" id="tcb_hamburger_thickness" name="<?php echo self::OPTION_NAME; ?>[hamburger_thickness]; ?>" value="<?php echo esc_attr( $settings['hamburger_thickness'] ); ?>" class="small-text" min="1" max="5" /> px
                                    <p class="description">Thickness of the hamburger icon lines.</p>
                                </td>
                            </tr>
                        </table>

                        <?php submit_button( 'Save Mobile Settings' ); ?>
                    </div>

                <?php elseif ( $active_tab === 'advanced' ) : ?>
                    <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;">
                        <h2 style="margin-top:0;">⚙️ Advanced Settings</h2>
                        <p style="color: #666; margin-bottom: 20px;">Advanced behavior and accessibility options.</p>
                        
                        <table class="form-table">
                            <tr>
                                <th>Scroll Lock (Mobile)</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="<?php echo self::OPTION_NAME; ?>[scroll_lock]" value="1" <?php checked( $settings['scroll_lock'], true ); ?> />
                                        Prevent background scrolling when mobile menu is open
                                    </label>
                                    <p class="description">Recommended for better mobile UX.</p>
                                </td>
                            </tr>
                            <tr>
                                <th>Close on Outside Click</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="<?php echo self::OPTION_NAME; ?>[close_on_outside]" value="1" <?php checked( $settings['close_on_outside'], true ); ?> />
                                        Close mega menu when clicking outside
                                    </label>
                                    <p class="description">Recommended for better UX.</p>
                                </td>
                            </tr>
                            <tr>
                                <th>Keyboard Navigation</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="<?php echo self::OPTION_NAME; ?>[keyboard_nav]" value="1" <?php checked( $settings['keyboard_nav'], true ); ?> />
                                        Enable keyboard navigation (Tab, Enter, Escape, Arrow keys)
                                    </label>
                                    <p class="description">Required for WCAG 2.1 AA accessibility compliance.</p>
                                </td>
                            </tr>
                        </table>

                        <?php submit_button( 'Save Advanced Settings' ); ?>
                    </div>

                <?php elseif ( $active_tab === 'data' ) : ?>
                    <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;">
                        <h2 style="margin-top:0;">💾 Data Management</h2>
                        <p style="color: #666; margin-bottom: 20px;">Manage plugin data and configurations.</p>
                        
                        <div style="background: #f0f6fc; padding: 15px; border-left: 4px solid #2271b1; margin-bottom: 20px;">
                            <strong>ℹ️ Important:</strong> When you deactivate or delete the plugin, your menu configurations are preserved. Use the buttons below to manually remove data when needed.
                        </div>

                        <h3>Current Data</h3>
                        <table class="widefat striped" style="margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <td><strong>Mega Menu Items</strong></td>
                                    <td><?php echo esc_html( $stats['mega_items'] ); ?> items configured</td>
                                </tr>
                                <tr>
                                    <td><strong>Divi Library Layouts</strong></td>
                                    <td><?php echo esc_html( $stats['divi_layouts'] ); ?> items using Divi layouts</td>
                                </tr>
                                <tr>
                                    <td><strong>Custom Columns</strong></td>
                                    <td><?php echo esc_html( $stats['custom_columns'] ); ?> items using custom columns</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3>Reset Options</h3>
                        
                        <!-- Reset Settings Only -->
                        <div style="background: #fff; padding: 15px; border: 1px solid #ddd; margin-bottom: 15px;">
                            <h4 style="margin-top: 0;">Reset Settings Only</h4>
                            <p style="color: #666;">This will reset all plugin settings to their default values. Your menu configurations will be preserved.</p>
                            <form method="post" style="margin: 0;">
                                <?php wp_nonce_field( 'tcb_reset_action', 'tcb_reset_nonce' ); ?>
                                <input type="hidden" name="tcb_reset_action" value="reset_settings" />
                                <button type="submit" class="button button-secondary" onclick="return confirm('Are you sure you want to reset all settings to defaults?');">
                                    Reset Settings
                                </button>
                            </form>
                        </div>

                        <!-- Reset Menu Data -->
                        <div style="background: #fff; padding: 15px; border: 1px solid #ddd; margin-bottom: 15px;">
                            <h4 style="margin-top: 0;">Reset Menu Configurations</h4>
                            <p style="color: #666;">This will remove all mega menu configurations from your menu items. Plugin settings will be preserved. <strong style="color: #dc3232;">This action cannot be undone!</strong></p>
                            <form method="post" style="margin: 0;">
                                <?php wp_nonce_field( 'tcb_reset_action', 'tcb_reset_nonce' ); ?>
                                <input type="hidden" name="tcb_reset_action" value="reset_menu_data" />
                                <button type="submit" class="button" style="background: #dc3232; border-color: #dc3232; color: #fff;" onclick="return confirm('WARNING: This will remove ALL mega menu configurations from your menu items. This cannot be undone. Are you sure?');">
                                    Remove All Menu Configurations
                                </button>
                            </form>
                        </div>

                        <!-- Reset Everything -->
                        <div style="background: #fff; padding: 15px; border: 2px solid #dc3232;">
                            <h4 style="margin-top: 0; color: #dc3232;">⚠️ Reset Everything</h4>
                            <p style="color: #666;">This will remove ALL plugin data including settings and menu configurations. <strong style="color: #dc3232;">This action cannot be undone!</strong></p>
                            <form method="post" style="margin: 0;">
                                <?php wp_nonce_field( 'tcb_reset_action', 'tcb_reset_nonce' ); ?>
                                <input type="hidden" name="tcb_reset_action" value="reset_all" />
                                <button type="submit" class="button" style="background: #dc3232; border-color: #dc3232; color: #fff;" onclick="return confirm('CRITICAL WARNING: This will remove ALL plugin data including settings and menu configurations. This CANNOT be undone. Are you absolutely sure?');">
                                    Remove All Plugin Data
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </form>

            <!-- Help Box -->
            <div style="background:#f0f6fc;padding:20px;border-left:4px solid #2271b1; margin-top: 20px;">
                <h3 style="margin-top:0;">💡 Quick Tips</h3>
                <ul style="margin:0;">
                    <li><strong>Colors:</strong> Ensure good contrast between text and background for accessibility.</li>
                    <li><strong>Mobile Style:</strong> Accordion is simplest, Drawer is elegant, Overlay is immersive.</li>
                    <li><strong>Hamburger Icon:</strong> Choose the style that best matches your design.</li>
                    <li><strong>Breakpoint:</strong> Match your theme's mobile breakpoint (usually 768px or 980px).</li>
                    <li><strong>Data:</strong> Your menu configurations are preserved when you deactivate the plugin.</li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * Sanitize settings
     */
    public static function sanitize( $input ) {
        $sanitized = array();

        // Color fields
        foreach ( array( 'bg', 'fg', 'accent', 'hamburger_color' ) as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = sanitize_hex_color( $input[ $key ] );
            }
        }

        // Text fields
        foreach ( array( 'muted', 'border', 'radius', 'shadow', 'font', 'gap', 'anim' ) as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = sanitize_text_field( $input[ $key ] );
            }
        }

        // Number fields
        foreach ( array( 'hover_in', 'hover_out', 'breakpoint', 'width_px', 'mobile_width', 'hamburger_size', 'hamburger_thickness' ) as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = absint( $input[ $key ] );
            }
        }

        // Checkbox fields
        foreach ( array( 'scroll_lock', 'close_on_outside', 'keyboard_nav' ) as $key ) {
            $sanitized[ $key ] = isset( $input[ $key ] ) ? true : false;
        }

        // Select fields
        if ( isset( $input['width'] ) && in_array( $input['width'], array( 'full', 'container', 'custom' ), true ) ) {
            $sanitized['width'] = $input['width'];
        }

        if ( isset( $input['mobile_style'] ) && in_array( $input['mobile_style'], array( 'accordion', 'drawer', 'overlay', 'slide' ), true ) ) {
            $sanitized['mobile_style'] = $input['mobile_style'];
        }

        if ( isset( $input['mobile_position'] ) && in_array( $input['mobile_position'], array( 'left', 'right' ), true ) ) {
            $sanitized['mobile_position'] = $input['mobile_position'];
        }

        if ( isset( $input['hamburger_icon'] ) && in_array( $input['hamburger_icon'], array( 'classic', 'arrow', 'dots', 'plus', 'x' ), true ) ) {
            $sanitized['hamburger_icon'] = $input['hamburger_icon'];
        }

        return wp_parse_args( $sanitized, self::get_defaults() );
    }
}
