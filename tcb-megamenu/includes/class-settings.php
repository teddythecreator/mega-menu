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

    const PRESETS = array(
        'oscuro'  => array(
            'bg'      => '#050506',
            'fg'      => '#f5f5f5',
            'muted'   => 'rgba(245,245,245,.6)',
            'accent'  => '#e11414',
            'border'  => 'rgba(255,255,255,.08)',
            'radius'  => '10px',
            'shadow'  => '0 24px 60px rgba(0,0,0,.5)',
        ),
        'claro'   => array(
            'bg'      => '#f2f3f5',
            'fg'      => '#101014',
            'muted'   => 'rgba(16,16,20,.64)',
            'accent'  => '#d40f0f',
            'border'  => 'rgba(16,16,20,.12)',
            'radius'  => '10px',
            'shadow'  => '0 24px 60px rgba(16,16,20,.14)',
        ),
        'minimal' => array(
            'bg'      => '#e8e8e6',
            'fg'      => '#161616',
            'muted'   => 'rgba(22,22,22,.62)',
            'accent'  => '#161616',
            'border'  => 'rgba(22,22,22,.16)',
            'radius'  => '2px',
            'shadow'  => '0 16px 40px rgba(22,22,22,.1)',
        ),
    );

    public static function get_defaults() {
        return array(
            // Background mode: 'transparent', 'dark', 'light', 'custom'
            'bg_mode'    => 'transparent',
            'bg'         => '#ffffff',
            'fg'         => '#333333',
            'muted'      => 'rgba(51,51,51,.6)',
            'accent'     => '#e11414',
            'border'     => 'rgba(0,0,0,.08)',
            'radius'     => '10px',
            'shadow'     => '0 24px 60px rgba(0,0,0,.15)',
            'font'       => 'inherit',
            'gap'        => 'clamp(16px, 2vw, 32px)',
            'anim'       => '.22s cubic-bezier(.22,.61,.36,1)',
            'width'      => 'full',
            'width_px'   => 1200,
            'hover_in'   => 120,
            'hover_out'  => 200,
            'breakpoint' => 980,
            'preset'     => 'claro',
        );
    }

    public static function get_settings() {
        $saved = get_option( self::OPTION_NAME, array() );
        return wp_parse_args( $saved, self::get_defaults() );
    }

    /**
     * Add settings page as TOP LEVEL menu (not under Appearance)
     */
    public function add_settings_page() {
        add_menu_page(
            __( 'TCB MegaMenu', 'tcb-megamenu' ),
            __( 'TCB MegaMenu', 'tcb-megamenu' ),
            'edit_theme_options',
            self::PAGE_SLUG,
            array( $this, 'render_page' ),
            'dashicons-screenoptions', // Grid-like icon
            61 // Position (after Comments)
        );

        // Submenu pages
        add_submenu_page(
            self::PAGE_SLUG,
            __( 'Settings', 'tcb-megamenu' ),
            __( 'Settings', 'tcb-megamenu' ),
            'edit_theme_options',
            self::PAGE_SLUG,
            array( $this, 'render_page' )
        );

        add_submenu_page(
            self::PAGE_SLUG,
            __( 'Installation Guide', 'tcb-megamenu' ),
            __( 'Installation Guide', 'tcb-megamenu' ),
            'edit_theme_options',
            self::PAGE_SLUG . '-guide',
            array( $this, 'render_guide_page' )
        );

        add_submenu_page(
            self::PAGE_SLUG,
            __( 'About', 'tcb-megamenu' ),
            __( 'About', 'tcb-megamenu' ),
            'edit_theme_options',
            self::PAGE_SLUG . '-about',
            array( $this, 'render_about_page' )
        );
    }

    public function register_settings() {
        register_setting(
            'tcb_megamenu_group',
            self::OPTION_NAME,
            array(
                'type'              => 'array',
                'sanitize_callback' => array( __CLASS__, 'sanitize' ),
                'default'           => self::get_defaults(),
            )
        );

        // Colors section
        add_settings_section(
            'tcb_section_colors',
            __( 'Colors', 'tcb-megamenu' ),
            function() {
                echo '<p>' . esc_html__( 'Color tokens for the mega menu panels.', 'tcb-megamenu' ) . '</p>';
            },
            self::PAGE_SLUG
        );

        $color_fields = array(
            'bg'     => __( 'Background Color', 'tcb-megamenu' ),
            'fg'     => __( 'Text Color', 'tcb-megamenu' ),
            'muted'  => __( 'Muted Text Color', 'tcb-megamenu' ),
            'accent' => __( 'Accent Color', 'tcb-megamenu' ),
            'border' => __( 'Border Color', 'tcb-megamenu' ),
        );

        foreach ( $color_fields as $key => $label ) {
            add_settings_field(
                "tcb_field_{$key}",
                $label,
                array( $this, 'render_color_field' ),
                self::PAGE_SLUG,
                'tcb_section_colors',
                array( 'key' => $key, 'label' => $label )
            );
        }

        // Layout section
        add_settings_section(
            'tcb_section_layout',
            __( 'Layout', 'tcb-megamenu' ),
            function() {
                echo '<p>' . esc_html__( 'Typography, spacing, and visual treatment.', 'tcb-megamenu' ) . '</p>';
            },
            self::PAGE_SLUG
        );

        add_settings_field( 'tcb_field_font', __( 'Font Family', 'tcb-megamenu' ), array( $this, 'render_text_field' ), self::PAGE_SLUG, 'tcb_section_layout', array( 'key' => 'font', 'placeholder' => '"Montserrat", system-ui, sans-serif' ) );
        add_settings_field( 'tcb_field_radius', __( 'Border Radius', 'tcb-megamenu' ), array( $this, 'render_text_field' ), self::PAGE_SLUG, 'tcb_section_layout', array( 'key' => 'radius', 'placeholder' => '10px' ) );
        add_settings_field( 'tcb_field_shadow', __( 'Box Shadow', 'tcb-megamenu' ), array( $this, 'render_text_field' ), self::PAGE_SLUG, 'tcb_section_layout', array( 'key' => 'shadow' ) );
        add_settings_field( 'tcb_field_gap', __( 'Gap', 'tcb-megamenu' ), array( $this, 'render_text_field' ), self::PAGE_SLUG, 'tcb_section_layout', array( 'key' => 'gap' ) );

        // Behavior section
        add_settings_section(
            'tcb_section_behavior',
            __( 'Behavior', 'tcb-megamenu' ),
            function() {
                echo '<p>' . esc_html__( 'Interaction timing and responsive behavior.', 'tcb-megamenu' ) . '</p>';
            },
            self::PAGE_SLUG
        );

        add_settings_field( 'tcb_field_hover_in', __( 'Hover In Delay (ms)', 'tcb-megamenu' ), array( $this, 'render_number_field' ), self::PAGE_SLUG, 'tcb_section_behavior', array( 'key' => 'hover_in', 'min' => 0, 'max' => 1000, 'step' => 10 ) );
        add_settings_field( 'tcb_field_hover_out', __( 'Hover Out Delay (ms)', 'tcb-megamenu' ), array( $this, 'render_number_field' ), self::PAGE_SLUG, 'tcb_section_behavior', array( 'key' => 'hover_out', 'min' => 0, 'max' => 1000, 'step' => 10 ) );
        add_settings_field( 'tcb_field_breakpoint', __( 'Mobile Breakpoint (px)', 'tcb-megamenu' ), array( $this, 'render_number_field' ), self::PAGE_SLUG, 'tcb_section_behavior', array( 'key' => 'breakpoint', 'min' => 320, 'max' => 1400, 'step' => 10 ) );
        add_settings_field( 'tcb_field_default_width', __( 'Default Panel Width', 'tcb-megamenu' ), array( $this, 'render_select_field' ), self::PAGE_SLUG, 'tcb_section_behavior', array( 'key' => 'width', 'options' => array( 'full' => __( 'Full Width', 'tcb-megamenu' ), 'container' => __( 'Container Width', 'tcb-megamenu' ) ) ) );

        // Presets section
        add_settings_section(
            'tcb_section_presets',
            __( 'Style Presets', 'tcb-megamenu' ),
            function() {
                echo '<p>' . esc_html__( 'Apply a preset to reset colors and layout values.', 'tcb-megamenu' ) . '</p>';
            },
            self::PAGE_SLUG
        );

        add_settings_field( 'tcb_field_preset', __( 'Load Preset', 'tcb-megamenu' ), array( $this, 'render_preset_field' ), self::PAGE_SLUG, 'tcb_section_presets' );
    }

    public function render_color_field( $args ) {
        $settings = self::get_settings();
        $value = isset( $settings[ $args['key'] ] ) ? $settings[ $args['key'] ] : '';
        $name = self::OPTION_NAME . '[' . $args['key'] . ']';
        ?>
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" class="tcb-color-field" data-tcb-color="true" />
            <span class="tcb-color-preview" style="display:inline-block;width:30px;height:30px;border:1px solid #ddd;border-radius:3px;background:<?php echo esc_attr( $value ); ?>"></span>
        </div>
        <?php
    }

    public function render_text_field( $args ) {
        $settings = self::get_settings();
        $value = isset( $settings[ $args['key'] ] ) ? $settings[ $args['key'] ] : '';
        $name = self::OPTION_NAME . '[' . $args['key'] . ']';
        $placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
        ?>
        <input type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" class="regular-text code" placeholder="<?php echo esc_attr( $placeholder ); ?>" />
        <?php
    }

    public function render_number_field( $args ) {
        $settings = self::get_settings();
        $value = isset( $settings[ $args['key'] ] ) ? intval( $settings[ $args['key'] ] ) : 0;
        $name = self::OPTION_NAME . '[' . $args['key'] . ']';
        ?>
        <input type="number" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" class="small-text" min="<?php echo esc_attr( $args['min'] ); ?>" max="<?php echo esc_attr( $args['max'] ); ?>" step="<?php echo esc_attr( $args['step'] ); ?>" />
        <?php
    }

    public function render_select_field( $args ) {
        $settings = self::get_settings();
        $value = isset( $settings[ $args['key'] ] ) ? $settings[ $args['key'] ] : '';
        $name = self::OPTION_NAME . '[' . $args['key'] . ']';
        ?>
        <select name="<?php echo esc_attr( $name ); ?>">
            <?php foreach ( $args['options'] as $opt_value => $opt_label ) : ?>
                <option value="<?php echo esc_attr( $opt_value ); ?>" <?php selected( $value, $opt_value ); ?>><?php echo esc_html( $opt_label ); ?></option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function render_preset_field() {
        ?>
        <div style="display:flex;gap:15px;flex-wrap:wrap;">
            <?php foreach ( self::PRESETS as $preset_id => $preset_values ) : ?>
                <label style="cursor:pointer;">
                    <input type="radio" name="tcb_apply_preset" value="<?php echo esc_attr( $preset_id ); ?>" style="display:none;" />
                    <span style="display:flex;flex-direction:column;align-items:center;padding:15px 20px;border:2px solid #ddd;border-radius:4px;background:#fff;">
                        <span style="font-weight:600;margin-bottom:8px;"><?php echo esc_html( ucfirst( $preset_id ) ); ?></span>
                        <span style="display:flex;gap:4px;">
                            <?php foreach ( array( $preset_values['bg'], $preset_values['fg'], $preset_values['accent'] ) as $swatch ) : ?>
                                <span style="display:inline-block;width:20px;height:20px;border:1px solid #ddd;border-radius:2px;background:<?php echo esc_attr( $swatch ); ?>"></span>
                            <?php endforeach; ?>
                        </span>
                    </span>
                </label>
            <?php endforeach; ?>
        </div>
        <p class="description"><?php esc_html_e( 'Select a preset and click "Save Changes" to apply.', 'tcb-megamenu' ); ?></p>
        <?php
    }

    public function render_page() {
        if ( ! current_user_can( 'edit_theme_options' ) ) return;
        
        $settings = self::get_settings();
        ?>
        <div class="wrap tcb-settings-wrap">
            <!-- Page Header -->
            <div class="tcb-page-header">
                <div class="tcb-page-header-content">
                    <div class="tcb-page-header-icon">⚡</div>
                    <div>
                        <h1 class="tcb-page-header-title"><?php esc_html_e( 'TCB MegaMenu Settings', 'tcb-megamenu' ); ?></h1>
                        <p class="tcb-page-header-subtitle">
                            <?php esc_html_e( 'Configure your mega menu appearance and behavior', 'tcb-megamenu' ); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="tcb-tabs">
                <a href="#settings" class="tcb-tab active">
                    <span class="tcb-tab-icon">⚙️</span>
                    <?php esc_html_e( 'Settings', 'tcb-megamenu' ); ?>
                </a>
                <a href="#preview" class="tcb-tab">
                    <span class="tcb-tab-icon">👁️</span>
                    <?php esc_html_e( 'Preview', 'tcb-megamenu' ); ?>
                </a>
                <a href="#presets" class="tcb-tab">
                    <span class="tcb-tab-icon">🎨</span>
                    <?php esc_html_e( 'Presets', 'tcb-megamenu' ); ?>
                </a>
            </div>

            <!-- Main Content -->
            <form method="post" action="options.php">
                <?php settings_fields( 'tcb_megamenu_group' ); ?>

                <!-- Background Mode Card -->
                <div class="tcb-card">
                    <div class="tcb-card-header">
                        <div class="tcb-card-icon">🎨</div>
                        <div>
                            <h2 class="tcb-card-title"><?php esc_html_e( 'Background Mode', 'tcb-megamenu' ); ?></h2>
                            <p class="tcb-card-description"><?php esc_html_e( 'Choose how your mega menu background integrates with your theme', 'tcb-megamenu' ); ?></p>
                        </div>
                    </div>

                    <div class="tcb-settings-grid">
                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Background Mode', 'tcb-megamenu' ); ?></div>
                            <select name="<?php echo esc_attr( self::OPTION_NAME ); ?>[bg_mode]" class="tcb-setting-input tcb-field-select">
                                <option value="transparent" <?php selected( $settings['bg_mode'], 'transparent' ); ?>>
                                    🔲 <?php esc_html_e( 'Transparent (Inherit from theme)', 'tcb-megamenu' ); ?>
                                </option>
                                <option value="light" <?php selected( $settings['bg_mode'], 'light' ); ?>>
                                    ☀️ <?php esc_html_e( 'Light Background', 'tcb-megamenu' ); ?>
                                </option>
                                <option value="dark" <?php selected( $settings['bg_mode'], 'dark' ); ?>>
                                    🌙 <?php esc_html_e( 'Dark Background', 'tcb-megamenu' ); ?>
                                </option>
                                <option value="custom" <?php selected( $settings['bg_mode'], 'custom' ); ?>>
                                    🎨 <?php esc_html_e( 'Custom Color', 'tcb-megamenu' ); ?>
                                </option>
                            </select>
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Background Color', 'tcb-megamenu' ); ?></div>
                            <div class="tcb-color-picker-wrapper">
                                <input type="text" 
                                       name="<?php echo esc_attr( self::OPTION_NAME ); ?>[bg]" 
                                       value="<?php echo esc_attr( $settings['bg'] ); ?>" 
                                       class="tcb-setting-input tcb-color-field" 
                                       data-tcb-color="true" />
                                <span class="tcb-color-preview" style="background:<?php echo esc_attr( $settings['bg'] ); ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colors Card -->
                <div class="tcb-card">
                    <div class="tcb-card-header">
                        <div class="tcb-card-icon">🎨</div>
                        <div>
                            <h2 class="tcb-card-title"><?php esc_html_e( 'Colors', 'tcb-megamenu' ); ?></h2>
                            <p class="tcb-card-description"><?php esc_html_e( 'Customize the color palette of your mega menu', 'tcb-megamenu' ); ?></p>
                        </div>
                    </div>

                    <div class="tcb-settings-grid">
                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Text Color', 'tcb-megamenu' ); ?></div>
                            <div class="tcb-color-picker-wrapper">
                                <input type="text" 
                                       name="<?php echo esc_attr( self::OPTION_NAME ); ?>[fg]" 
                                       value="<?php echo esc_attr( $settings['fg'] ); ?>" 
                                       class="tcb-setting-input tcb-color-field" />
                                <span class="tcb-color-preview" style="background:<?php echo esc_attr( $settings['fg'] ); ?>"></span>
                            </div>
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Accent Color', 'tcb-megamenu' ); ?></div>
                            <div class="tcb-color-picker-wrapper">
                                <input type="text" 
                                       name="<?php echo esc_attr( self::OPTION_NAME ); ?>[accent]" 
                                       value="<?php echo esc_attr( $settings['accent'] ); ?>" 
                                       class="tcb-setting-input tcb-color-field" />
                                <span class="tcb-color-preview" style="background:<?php echo esc_attr( $settings['accent'] ); ?>"></span>
                            </div>
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Border Color', 'tcb-megamenu' ); ?></div>
                            <div class="tcb-color-picker-wrapper">
                                <input type="text" 
                                       name="<?php echo esc_attr( self::OPTION_NAME ); ?>[border]" 
                                       value="<?php echo esc_attr( $settings['border'] ); ?>" 
                                       class="tcb-setting-input tcb-color-field" />
                                <span class="tcb-color-preview" style="background:<?php echo esc_attr( $settings['border'] ); ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Layout Card -->
                <div class="tcb-card">
                    <div class="tcb-card-header">
                        <div class="tcb-card-icon">📐</div>
                        <div>
                            <h2 class="tcb-card-title"><?php esc_html_e( 'Layout & Typography', 'tcb-megamenu' ); ?></h2>
                            <p class="tcb-card-description"><?php esc_html_e( 'Control spacing, borders, and typography', 'tcb-megamenu' ); ?></p>
                        </div>
                    </div>

                    <div class="tcb-settings-grid">
                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Font Family', 'tcb-megamenu' ); ?></div>
                            <input type="text" 
                                   name="<?php echo esc_attr( self::OPTION_NAME ); ?>[font]" 
                                   value="<?php echo esc_attr( $settings['font'] ); ?>" 
                                   class="tcb-setting-input" 
                                   placeholder="inherit" />
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Border Radius', 'tcb-megamenu' ); ?></div>
                            <input type="text" 
                                   name="<?php echo esc_attr( self::OPTION_NAME ); ?>[radius]" 
                                   value="<?php echo esc_attr( $settings['radius'] ); ?>" 
                                   class="tcb-setting-input" 
                                   placeholder="10px" />
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Gap/Spacing', 'tcb-megamenu' ); ?></div>
                            <input type="text" 
                                   name="<?php echo esc_attr( self::OPTION_NAME ); ?>[gap]" 
                                   value="<?php echo esc_attr( $settings['gap'] ); ?>" 
                                   class="tcb-setting-input" 
                                   placeholder="clamp(16px, 2vw, 32px)" />
                        </div>
                    </div>
                </div>

                <!-- Behavior Card -->
                <div class="tcb-card">
                    <div class="tcb-card-header">
                        <div class="tcb-card-icon">⚡</div>
                        <div>
                            <h2 class="tcb-card-title"><?php esc_html_e( 'Behavior & Interaction', 'tcb-megamenu' ); ?></h2>
                            <p class="tcb-card-description"><?php esc_html_e( 'Configure timing and responsive behavior', 'tcb-megamenu' ); ?></p>
                        </div>
                    </div>

                    <div class="tcb-settings-grid">
                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Hover In Delay (ms)', 'tcb-megamenu' ); ?></div>
                            <input type="number" 
                                   name="<?php echo esc_attr( self::OPTION_NAME ); ?>[hover_in]" 
                                   value="<?php echo esc_attr( $settings['hover_in'] ); ?>" 
                                   class="tcb-setting-input" 
                                   min="0" max="1000" step="10" />
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Hover Out Delay (ms)', 'tcb-megamenu' ); ?></div>
                            <input type="number" 
                                   name="<?php echo esc_attr( self::OPTION_NAME ); ?>[hover_out]" 
                                   value="<?php echo esc_attr( $settings['hover_out'] ); ?>" 
                                   class="tcb-setting-input" 
                                   min="0" max="1000" step="10" />
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Mobile Breakpoint (px)', 'tcb-megamenu' ); ?></div>
                            <input type="number" 
                                   name="<?php echo esc_attr( self::OPTION_NAME ); ?>[breakpoint]" 
                                   value="<?php echo esc_attr( $settings['breakpoint'] ); ?>" 
                                   class="tcb-setting-input" 
                                   min="320" max="1400" step="10" />
                        </div>

                        <div class="tcb-setting-item">
                            <div class="tcb-setting-label"><?php esc_html_e( 'Default Panel Width', 'tcb-megamenu' ); ?></div>
                            <select name="<?php echo esc_attr( self::OPTION_NAME ); ?>[width]" class="tcb-setting-input tcb-field-select">
                                <option value="full" <?php selected( $settings['width'], 'full' ); ?>>
                                    ↔️ <?php esc_html_e( 'Full Width', 'tcb-megamenu' ); ?>
                                </option>
                                <option value="container" <?php selected( $settings['width'], 'container' ); ?>>
                                    📦 <?php esc_html_e( 'Container Width', 'tcb-megamenu' ); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div style="margin-top: 24px; text-align: center;">
                    <button type="submit" class="tcb-btn tcb-btn-primary">
                        💾 <?php esc_html_e( 'Save Settings', 'tcb-megamenu' ); ?>
                    </button>
                </div>
            </form>

            <!-- Live Preview -->
            <div class="tcb-live-preview">
                <div class="tcb-preview-header">
                    <div class="tcb-preview-title">👁️ <?php esc_html_e( 'Live Preview', 'tcb-megamenu' ); ?></div>
                    <div class="tcb-preview-actions">
                        <button class="tcb-preview-btn" data-mode="desktop">🖥️ Desktop</button>
                        <button class="tcb-preview-btn" data-mode="mobile">📱 Mobile</button>
                    </div>
                </div>
                <div class="tcb-preview-mockup" id="tcb-preview-mockup">
                    <div style="background: <?php echo esc_attr( $settings['bg'] ); ?>; color: <?php echo esc_attr( $settings['fg'] ); ?>; padding: 20px; border-radius: <?php echo esc_attr( $settings['radius'] ); ?>;">
                        <div style="display: flex; gap: 20px; margin-bottom: 16px;">
                            <div style="flex: 1;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: <?php echo esc_attr( $settings['accent'] ); ?>; margin-bottom: 8px;">Column 1</div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; margin-bottom: 8px;"></div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; margin-bottom: 8px; width: 80%;"></div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; width: 60%;"></div>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: <?php echo esc_attr( $settings['accent'] ); ?>; margin-bottom: 8px;">Column 2</div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; margin-bottom: 8px;"></div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; margin-bottom: 8px; width: 80%;"></div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; width: 60%;"></div>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: <?php echo esc_attr( $settings['accent'] ); ?>; margin-bottom: 8px;">Column 3</div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; margin-bottom: 8px;"></div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; margin-bottom: 8px; width: 80%;"></div>
                                <div style="height: 8px; background: <?php echo esc_attr( $settings['border'] ); ?>; border-radius: 4px; width: 60%;"></div>
                            </div>
                        </div>
                        <div style="background: <?php echo esc_attr( $settings['accent'] ); ?>; color: white; padding: 10px 20px; border-radius: <?php echo esc_attr( $settings['radius'] ); ?>; text-align: center; font-weight: 600;">
                            Call to Action
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // Initialize color pickers
            if ($.fn.wpColorPicker) {
                $('.tcb-color-field').wpColorPicker({
                    change: function(event, ui) {
                        $(this).closest('.tcb-color-picker-wrapper').find('.tcb-color-preview').css('background', ui.color.toString());
                        updatePreview();
                    }
                });
            }

            // Update preview on input change
            $('input, select').on('change', function() {
                updatePreview();
            });

            function updatePreview() {
                var bg = $('input[name$="[bg]"]').val() || '#ffffff';
                var fg = $('input[name$="[fg]"]').val() || '#333333';
                var accent = $('input[name$="[accent]"]').val() || '#e11414';
                var border = $('input[name$="[border]"]').val() || 'rgba(0,0,0,.08)';
                var radius = $('input[name$="[radius]"]').val() || '10px';

                $('#tcb-preview-mockup > div').css({
                    'background': bg,
                    'color': fg,
                    'border-radius': radius
                });

                $('#tcb-preview-mockup .tcb-accent').css('color', accent);
            }

            // Preview mode toggle
            $('.tcb-preview-btn').on('click', function() {
                var mode = $(this).data('mode');
                $('.tcb-preview-btn').removeClass('active');
                $(this).addClass('active');
                
                if (mode === 'mobile') {
                    $('#tcb-preview-mockup').css('max-width', '375px');
                } else {
                    $('#tcb-preview-mockup').css('max-width', '100%');
                }
            });
        });
        </script>
        <?php
    }

    /**
     * Installation guide page
     */
    public function render_guide_page() {
        ?>
        <div class="wrap" style="max-width:900px;">
            <h1><?php esc_html_e( 'TCB MegaMenu — Installation & Setup Guide', 'tcb-megamenu' ); ?></h1>

            <div style="background:#fff;border:1px solid #ccd0d4;border-radius:4px;padding:20px;margin:20px 0;">
                <h2 style="margin-top:0;"><?php esc_html_e( 'Quick Start (5 minutes)', 'tcb-megamenu' ); ?></h2>

                <h3><?php esc_html_e( 'Step 1: Configure Global Settings', 'tcb-megamenu' ); ?></h3>
                <ol>
                    <li><?php esc_html_e( 'Go to TCB MegaMenu → Settings', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Select a preset (Dark, Light, or Minimal) or customize colors', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Click "Save Changes"', 'tcb-megamenu' ); ?></li>
                </ol>

                <h3><?php esc_html_e( 'Step 2: Create Your Menu', 'tcb-megamenu' ); ?></h3>
                <ol>
                    <li><?php esc_html_e( 'Go to Appearance → Menus', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Create a new menu or edit an existing one', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Add menu items (pages, categories, custom links)', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Assign the menu to a theme location', 'tcb-megamenu' ); ?></li>
                </ol>

                <h3><?php esc_html_e( 'Step 3: Enable Mega Menu', 'tcb-megamenu' ); ?></h3>
                <ol>
                    <li><?php esc_html_e( 'Click the arrow on a parent menu item to expand it', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Check "Enable Mega Panel"', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Choose Content Source: Divi Library Layout or Custom Columns', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Configure width, alignment, and optional badge', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Click "Save Menu"', 'tcb-megamenu' ); ?></li>
                </ol>

                <h3><?php esc_html_e( 'Step 4: View on Front-End', 'tcb-megamenu' ); ?></h3>
                <p><?php esc_html_e( 'Visit your website and hover over the menu item. The mega menu should appear!', 'tcb-megamenu' ); ?></p>
            </div>

            <div style="background:#fff;border:1px solid #ccd0d4;border-radius:4px;padding:20px;margin:20px 0;">
                <h2 style="margin-top:0;"><?php esc_html_e( 'Using with Divi', 'tcb-megamenu' ); ?></h2>
                <ol>
                    <li><?php esc_html_e( 'Go to Divi → Divi Library', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Click "Add New Layout" and design your mega menu panel', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Save the layout with a descriptive name', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'In Appearance → Menus, enable Mega Panel on a parent item', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Select "Divi Library Layout" as Content Source', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Choose your layout from the dropdown', 'tcb-megamenu' ); ?></li>
                </ol>
            </div>

            <div style="background:#fff;border:1px solid #ccd0d4;border-radius:4px;padding:20px;margin:20px 0;">
                <h2 style="margin-top:0;"><?php esc_html_e( 'Using Without Divi (Custom Columns)', 'tcb-megamenu' ); ?></h2>
                <ol>
                    <li><?php esc_html_e( 'In Appearance → Menus, add sub-items under a parent item', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Drag sub-items slightly to the right to nest them', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Enable Mega Panel on the parent item', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Select "Custom Columns (no Divi)" as Content Source', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Sub-items will automatically appear in columns', 'tcb-megamenu' ); ?></li>
                </ol>
            </div>

            <div style="background:#f8f8f8;border-left:4px solid #f0b429;padding:15px 20px;margin:20px 0;">
                <h3 style="margin-top:0;"><?php esc_html_e( 'Troubleshooting', 'tcb-megamenu' ); ?></h3>
                <ul>
                    <li><strong><?php esc_html_e( 'Mega menu not showing:', 'tcb-megamenu' ); ?></strong> <?php esc_html_e( 'Make sure the menu is assigned to a theme location and "Enable Mega Panel" is checked.', 'tcb-megamenu' ); ?></li>
                    <li><strong><?php esc_html_e( 'Divi layout not rendering:', 'tcb-megamenu' ); ?></strong> <?php esc_html_e( 'Ensure Divi theme or Divi Builder plugin is active.', 'tcb-megamenu' ); ?></li>
                    <li><strong><?php esc_html_e( 'Colors not applying:', 'tcb-megamenu' ); ?></strong> <?php esc_html_e( 'Clear browser cache (Ctrl+F5) and any caching plugin.', 'tcb-megamenu' ); ?></li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * About page
     */
    public function render_about_page() {
        ?>
        <div class="wrap" style="max-width:900px;">
            <h1><?php esc_html_e( 'About TCB MegaMenu', 'tcb-megamenu' ); ?></h1>

            <div style="background:#fff;border:1px solid #ccd0d4;border-radius:4px;padding:30px;margin:20px 0;text-align:center;">
                <h2 style="color:#e11414;margin-bottom:10px;">TCB MegaMenu</h2>
                <p style="font-size:18px;color:#666;margin-bottom:20px;"><?php esc_html_e( 'by', 'tcb-megamenu' ); ?> <a href="https://thecreator.business/" target="_blank" style="color:#e11414;text-decoration:none;font-weight:bold;">www.thecreator.business</a></p>
                <p style="font-size:14px;color:#888;"><?php esc_html_e( 'Version', 'tcb-megamenu' ); ?> <?php echo esc_html( TCB_MEGAMENU_VERSION ); ?></p>
            </div>

            <div style="background:#fff;border:1px solid #ccd0d4;border-radius:4px;padding:20px;margin:20px 0;">
                <h2 style="margin-top:0;"><?php esc_html_e( 'Features', 'tcb-megamenu' ); ?></h2>
                <ul style="columns:2;column-gap:40px;">
                    <li><?php esc_html_e( 'Divi Library integration', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Custom columns mode', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'WCAG 2.1 AA accessible', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Responsive mobile accordion', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Keyboard navigation', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Customizable colors & styles', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( '3 style presets', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Conditional asset loading', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Lightweight (< 5 KB JS)', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'No jQuery dependency', 'tcb-megamenu' ); ?></li>
                </ul>
            </div>

            <div style="background:#fff;border:1px solid #ccd0d4;border-radius:4px;padding:20px;margin:20px 0;">
                <h2 style="margin-top:0;"><?php esc_html_e( 'Requirements', 'tcb-megamenu' ); ?></h2>
                <ul>
                    <li><?php esc_html_e( 'WordPress 5.8 or higher', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'PHP 8.0 or higher', 'tcb-megamenu' ); ?></li>
                    <li><?php esc_html_e( 'Divi theme or Divi Builder plugin (optional, for Divi layouts)', 'tcb-megamenu' ); ?></li>
                </ul>
            </div>

            <div style="background:#f8f8f8;border-left:4px solid #e11414;padding:15px 20px;margin:20px 0;">
                <p style="margin:0;"><strong><?php esc_html_e( 'License:', 'tcb-megamenu' ); ?></strong> GPL v2 or later</p>
                <p style="margin:5px 0 0;"><strong><?php esc_html_e( 'Support:', 'tcb-megamenu' ); ?></strong> <a href="https://thecreator.business/" target="_blank">thecreator.business</a></p>
            </div>
        </div>
        <?php
    }

    public static function sanitize( $input ) {
        $sanitized = array();

        // Handle preset
        if ( isset( $_POST['tcb_apply_preset'] ) && array_key_exists( $_POST['tcb_apply_preset'], self::PRESETS ) ) {
            $preset_id = sanitize_key( $_POST['tcb_apply_preset'] );
            $preset = self::PRESETS[ $preset_id ];
            $sanitized['bg'] = $preset['bg'];
            $sanitized['fg'] = $preset['fg'];
            $sanitized['muted'] = $preset['muted'];
            $sanitized['accent'] = $preset['accent'];
            $sanitized['border'] = $preset['border'];
            $sanitized['radius'] = $preset['radius'];
            $sanitized['shadow'] = $preset['shadow'];
            $sanitized['preset'] = $preset_id;
        }

        // Color fields
        foreach ( array( 'bg', 'fg', 'muted', 'accent', 'border' ) as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = sanitize_text_field( $input[ $key ] );
            }
        }

        // Text fields
        foreach ( array( 'font', 'radius', 'shadow', 'gap', 'anim' ) as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = sanitize_text_field( $input[ $key ] );
            }
        }

        // Number fields
        foreach ( array( 'hover_in', 'hover_out', 'breakpoint', 'width_px' ) as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = absint( $input[ $key ] );
            }
        }

        // Select
        if ( isset( $input['width'] ) && in_array( $input['width'], array( 'full', 'container' ), true ) ) {
            $sanitized['width'] = $input['width'];
        }

        return wp_parse_args( $sanitized, self::get_defaults() );
    }
}
