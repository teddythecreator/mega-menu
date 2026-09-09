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
     * Presets definition
     */
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
            'width'        => 'full',
            'width_px'     => 1200,
            'hover_in'     => 120,
            'hover_out'    => 200,
            'breakpoint'   => 980,
            'preset'       => 'oscuro',
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
        add_theme_page(
            __( 'TBMX Mega Menu', 'tbmx-megamenu' ),
            __( 'TBMX Mega Menu', 'tbmx-megamenu' ),
            'edit_theme_options',
            self::PAGE_SLUG,
            array( $this, 'render_page' )
        );
    }

    /**
     * Register settings with the Settings API
     *
     * Hooked to: admin_init
     */
    public function register_settings() {
        register_setting(
            'tbmx_megamenu_group',
            self::OPTION_NAME,
            array(
                'type'              => 'array',
                'sanitize_callback' => array( __CLASS__, 'sanitize' ),
                'default'           => self::get_defaults(),
            )
        );

        // ── Section: Colors ──
        add_settings_section(
            'tbmx_section_colors',
            __( 'Colors', 'tbmx-megamenu' ),
            array( $this, 'render_section_colors_desc' ),
            self::PAGE_SLUG
        );

        $color_fields = array(
            'bg'      => __( 'Background Color', 'tbmx-megamenu' ),
            'fg'      => __( 'Text Color', 'tbmx-megamenu' ),
            'muted'   => __( 'Muted Text Color', 'tbmx-megamenu' ),
            'accent'  => __( 'Accent Color', 'tbmx-megamenu' ),
            'border'  => __( 'Border Color', 'tbmx-megamenu' ),
        );

        foreach ( $color_fields as $key => $label ) {
            add_settings_field(
                "tbmx_field_{$key}",
                $label,
                array( $this, 'render_color_field' ),
                self::PAGE_SLUG,
                'tbmx_section_colors',
                array( 'key' => $key, 'label' => $label )
            );
        }

        // ── Section: Layout ──
        add_settings_section(
            'tbmx_section_layout',
            __( 'Layout', 'tbmx-megamenu' ),
            array( $this, 'render_section_layout_desc' ),
            self::PAGE_SLUG
        );

        add_settings_field(
            'tbmx_field_font',
            __( 'Font Family', 'tbmx-megamenu' ),
            array( $this, 'render_text_field' ),
            self::PAGE_SLUG,
            'tbmx_section_layout',
            array( 'key' => 'font', 'placeholder' => '"Montserrat", system-ui, sans-serif' )
        );

        add_settings_field(
            'tbmx_field_radius',
            __( 'Border Radius', 'tbmx-megamenu' ),
            array( $this, 'render_text_field' ),
            self::PAGE_SLUG,
            'tbmx_section_layout',
            array( 'key' => 'radius', 'placeholder' => '10px' )
        );

        add_settings_field(
            'tbmx_field_shadow',
            __( 'Box Shadow', 'tbmx-megamenu' ),
            array( $this, 'render_text_field' ),
            self::PAGE_SLUG,
            'tbmx_section_layout',
            array( 'key' => 'shadow', 'placeholder' => '0 24px 60px rgba(0,0,0,.5)' )
        );

        add_settings_field(
            'tbmx_field_gap',
            __( 'Gap', 'tbmx-megamenu' ),
            array( $this, 'render_text_field' ),
            self::PAGE_SLUG,
            'tbmx_section_layout',
            array( 'key' => 'gap', 'placeholder' => 'clamp(16px, 2vw, 32px)' )
        );

        // ── Section: Behavior ──
        add_settings_section(
            'tbmx_section_behavior',
            __( 'Behavior', 'tbmx-megamenu' ),
            array( $this, 'render_section_behavior_desc' ),
            self::PAGE_SLUG
        );

        add_settings_field(
            'tbmx_field_hover_in',
            __( 'Hover In Delay (ms)', 'tbmx-megamenu' ),
            array( $this, 'render_number_field' ),
            self::PAGE_SLUG,
            'tbmx_section_behavior',
            array( 'key' => 'hover_in', 'min' => 0, 'max' => 1000, 'step' => 10 )
        );

        add_settings_field(
            'tbmx_field_hover_out',
            __( 'Hover Out Delay (ms)', 'tbmx-megamenu' ),
            array( $this, 'render_number_field' ),
            self::PAGE_SLUG,
            'tbmx_section_behavior',
            array( 'key' => 'hover_out', 'min' => 0, 'max' => 1000, 'step' => 10 )
        );

        add_settings_field(
            'tbmx_field_breakpoint',
            __( 'Mobile Breakpoint (px)', 'tbmx-megamenu' ),
            array( $this, 'render_number_field' ),
            self::PAGE_SLUG,
            'tbmx_section_behavior',
            array( 'key' => 'breakpoint', 'min' => 320, 'max' => 1400, 'step' => 10 )
        );

        add_settings_field(
            'tbmx_field_default_width',
            __( 'Default Panel Width', 'tbmx-megamenu' ),
            array( $this, 'render_select_field' ),
            self::PAGE_SLUG,
            'tbmx_section_behavior',
            array(
                'key'     => 'width',
                'options' => array(
                    'full'      => __( 'Full Width', 'tbmx-megamenu' ),
                    'container' => __( 'Container Width', 'tbmx-megamenu' ),
                ),
            )
        );

        // ── Section: Presets ──
        add_settings_section(
            'tbmx_section_presets',
            __( 'Style Presets', 'tbmx-megamenu' ),
            array( $this, 'render_section_presets_desc' ),
            self::PAGE_SLUG
        );

        add_settings_field(
            'tbmx_field_preset',
            __( 'Load Preset', 'tbmx-megamenu' ),
            array( $this, 'render_preset_field' ),
            self::PAGE_SLUG,
            'tbmx_section_presets',
            array()
        );
    }

    /**
     * Section descriptions
     */
    public function render_section_colors_desc() {
        echo '<p>' . esc_html__( 'Base color tokens for the mega menu panels. These values are injected as CSS custom properties.', 'tbmx-megamenu' ) . '</p>';
    }

    public function render_section_layout_desc() {
        echo '<p>' . esc_html__( 'Typography, spacing, and visual treatment of the panels.', 'tbmx-megamenu' ) . '</p>';
    }

    public function render_section_behavior_desc() {
        echo '<p>' . esc_html__( 'Interaction timing and responsive behavior.', 'tbmx-megamenu' ) . '</p>';
    }

    public function render_section_presets_desc() {
        echo '<p>' . esc_html__( 'Apply a preset to reset all color and layout values. This will overwrite your current customizations.', 'tbmx-megamenu' ) . '</p>';
    }

    /**
     * Render color field
     *
     * @param array $args Field arguments.
     */
    public function render_color_field( $args ) {
        $settings = self::get_settings();
        $value    = isset( $settings[ $args['key'] ] ) ? $settings[ $args['key'] ] : '';
        $name     = self::OPTION_NAME . '[' . $args['key'] . ']';
        ?>
        <div class="tbmx-color-field-wrap">
            <input type="text"
                   name="<?php echo esc_attr( $name ); ?>"
                   value="<?php echo esc_attr( $value ); ?>"
                   class="tbmx-color-field"
                   data-tbmx-color="true" />
            <span class="tbmx-color-preview" style="background:<?php echo esc_attr( $value ); ?>"></span>
        </div>
        <?php
    }

    /**
     * Render text field
     *
     * @param array $args Field arguments.
     */
    public function render_text_field( $args ) {
        $settings    = self::get_settings();
        $value       = isset( $settings[ $args['key'] ] ) ? $settings[ $args['key'] ] : '';
        $name        = self::OPTION_NAME . '[' . $args['key'] . ']';
        $placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
        ?>
        <input type="text"
               name="<?php echo esc_attr( $name ); ?>"
               value="<?php echo esc_attr( $value ); ?>"
               class="regular-text code"
               placeholder="<?php echo esc_attr( $placeholder ); ?>" />
        <?php
    }

    /**
     * Render number field
     *
     * @param array $args Field arguments.
     */
    public function render_number_field( $args ) {
        $settings = self::get_settings();
        $value    = isset( $settings[ $args['key'] ] ) ? intval( $settings[ $args['key'] ] ) : 0;
        $name     = self::OPTION_NAME . '[' . $args['key'] . ']';
        $min      = isset( $args['min'] ) ? intval( $args['min'] ) : 0;
        $max      = isset( $args['max'] ) ? intval( $args['max'] ) : 9999;
        $step     = isset( $args['step'] ) ? intval( $args['step'] ) : 1;
        ?>
        <input type="number"
               name="<?php echo esc_attr( $name ); ?>"
               value="<?php echo esc_attr( $value ); ?>"
               class="small-text"
               min="<?php echo esc_attr( $min ); ?>"
               max="<?php echo esc_attr( $max ); ?>"
               step="<?php echo esc_attr( $step ); ?>" />
        <?php
    }

    /**
     * Render select field
     *
     * @param array $args Field arguments.
     */
    public function render_select_field( $args ) {
        $settings = self::get_settings();
        $value    = isset( $settings[ $args['key'] ] ) ? $settings[ $args['key'] ] : '';
        $name     = self::OPTION_NAME . '[' . $args['key'] . ']';
        ?>
        <select name="<?php echo esc_attr( $name ); ?>">
            <?php foreach ( $args['options'] as $opt_value => $opt_label ) : ?>
                <option value="<?php echo esc_attr( $opt_value ); ?>" <?php selected( $value, $opt_value ); ?>>
                    <?php echo esc_html( $opt_label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    /**
     * Render preset selector
     */
    public function render_preset_field() {
        ?>
        <div class="tbmx-presets-wrap">
            <?php foreach ( self::PRESETS as $preset_id => $preset_values ) : ?>
                <label class="tbmx-preset-option">
                    <input type="radio"
                           name="tbmx_apply_preset"
                           value="<?php echo esc_attr( $preset_id ); ?>" />
                    <span class="tbmx-preset-card">
                        <span class="tbmx-preset-name"><?php echo esc_html( ucfirst( $preset_id ) ); ?></span>
                        <span class="tbmx-preset-swatches">
                            <?php foreach ( array( $preset_values['bg'], $preset_values['fg'], $preset_values['accent'] ) as $swatch ) : ?>
                                <span class="tbmx-preset-swatch" style="background:<?php echo esc_attr( $swatch ); ?>"></span>
                            <?php endforeach; ?>
                        </span>
                    </span>
                </label>
            <?php endforeach; ?>
            <p class="description">
                <?php esc_html_e( 'Select a preset and click "Save Changes" to apply. This overwrites current color values.', 'tbmx-megamenu' ); ?>
            </p>
        </div>
        <?php
    }

    /**
     * Render the settings page
     */
    public function render_page() {
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            return;
        }
        ?>
        <div class="wrap tbmx-settings-wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <p class="description">
                <?php esc_html_e( 'Configure global settings for the TBMX Mega Menu plugin. These values are injected as CSS custom properties (--tbmx-*) in the front-end.', 'tbmx-megamenu' ); ?>
            </p>

            <form method="post" action="options.php" class="tbmx-settings-form">
                <?php
                settings_fields( 'tbmx_megamenu_group' );
                do_settings_sections( self::PAGE_SLUG );
                submit_button( __( 'Save Settings', 'tbmx-megamenu' ) );
                ?>
            </form>

            <hr />

            <h2><?php esc_html_e( 'Quick Reference', 'tbmx-megamenu' ); ?></h2>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'CSS Variable', 'tbmx-megamenu' ); ?></th>
                        <th><?php esc_html_e( 'Current Value', 'tbmx-megamenu' ); ?></th>
                        <th><?php esc_html_e( 'Description', 'tbmx-megamenu' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $settings = self::get_settings();
                    $vars     = array(
                        '--tbmx-bg'     => array( 'bg', __( 'Panel background', 'tbmx-megamenu' ) ),
                        '--tbmx-fg'     => array( 'fg', __( 'Panel text color', 'tbmx-megamenu' ) ),
                        '--tbmx-muted'  => array( 'muted', __( 'Muted text', 'tbmx-megamenu' ) ),
                        '--tbmx-accent' => array( 'accent', __( 'Brand accent', 'tbmx-megamenu' ) ),
                        '--tbmx-border' => array( 'border', __( 'Borders', 'tbmx-megamenu' ) ),
                    );
                    foreach ( $vars as $css_var => $info ) :
                        $key = $info[0];
                        $desc = $info[1];
                        $val = isset( $settings[ $key ] ) ? $settings[ $key ] : '';
                        ?>
                        <tr>
                            <td><code><?php echo esc_html( $css_var ); ?></code></td>
                            <td>
                                <code><?php echo esc_html( $val ); ?></code>
                                <?php if ( strpos( $val, '#' ) === 0 ) : ?>
                                    <span class="tbmx-color-preview" style="background:<?php echo esc_attr( $val ); ?>"></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html( $desc ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Sanitize settings on save
     *
     * @param array $input Raw input.
     * @return array Sanitized settings.
     */
    public static function sanitize( $input ) {
        $sanitized = array();

        // Handle preset application
        if ( isset( $_POST['tbmx_apply_preset'] ) && array_key_exists( $_POST['tbmx_apply_preset'], self::PRESETS ) ) {
            $preset_id = sanitize_key( $_POST['tbmx_apply_preset'] );
            $preset    = self::PRESETS[ $preset_id ];

            // Apply preset values
            $sanitized['bg']      = $preset['bg'];
            $sanitized['fg']      = $preset['fg'];
            $sanitized['muted']   = $preset['muted'];
            $sanitized['accent']  = $preset['accent'];
            $sanitized['border']  = $preset['border'];
            $sanitized['radius']  = $preset['radius'];
            $sanitized['shadow']  = $preset['shadow'];
            $sanitized['preset']  = $preset_id;
        }

        // Color fields - sanitize as text (allows rgba, hex, etc.)
        $color_keys = array( 'bg', 'fg', 'muted', 'accent', 'border' );
        foreach ( $color_keys as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = sanitize_text_field( $input[ $key ] );
            }
        }

        // Text fields
        $text_keys = array( 'font', 'radius', 'shadow', 'gap', 'anim' );
        foreach ( $text_keys as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = sanitize_text_field( $input[ $key ] );
            }
        }

        // Number fields
        $number_keys = array( 'hover_in', 'hover_out', 'breakpoint', 'width_px' );
        foreach ( $number_keys as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = absint( $input[ $key ] );
            }
        }

        // Select fields
        if ( isset( $input['width'] ) && in_array( $input['width'], array( 'full', 'container' ), true ) ) {
            $sanitized['width'] = $input['width'];
        }

        // Merge with defaults to ensure all keys exist
        return wp_parse_args( $sanitized, self::get_defaults() );
    }
}
