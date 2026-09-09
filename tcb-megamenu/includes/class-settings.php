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
            'bg'         => '#050506',
            'fg'         => '#f5f5f5',
            'muted'      => 'rgba(245,245,245,.6)',
            'accent'     => '#e11414',
            'border'     => 'rgba(255,255,255,.08)',
            'radius'     => '10px',
            'shadow'     => '0 24px 60px rgba(0,0,0,.5)',
            'font'       => '"Montserrat", system-ui, sans-serif',
            'gap'        => 'clamp(16px, 2vw, 32px)',
            'anim'       => '.22s cubic-bezier(.22,.61,.36,1)',
            'width'      => 'full',
            'width_px'   => 1200,
            'hover_in'   => 120,
            'hover_out'  => 200,
            'breakpoint' => 980,
            'preset'     => 'oscuro',
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
        ?>
        <div class="wrap" style="max-width:900px;">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <p style="color:#666;font-size:14px;margin-bottom:20px;">
                <?php esc_html_e( 'Configure global settings for TCB MegaMenu. These values are injected as CSS custom properties.', 'tcb-megamenu' ); ?>
            </p>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'tcb_megamenu_group' );
                do_settings_sections( self::PAGE_SLUG );
                submit_button( __( 'Save Settings', 'tcb-megamenu' ) );
                ?>
            </form>
        </div>
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
