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
        );
    }

    public static function get_settings() {
        $saved = get_option( self::OPTION_NAME, array() );
        return wp_parse_args( $saved, self::get_defaults() );
    }

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

    public function register_settings() {
        register_setting(
            'tcb_megamenu_group',
            self::OPTION_NAME,
            array( 'sanitize_callback' => array( __CLASS__, 'sanitize' ) )
        );
    }

    public function render_page() {
        if ( ! current_user_can( 'edit_theme_options' ) ) return;
        
        $settings = self::get_settings();
        ?>
        <div class="wrap">
            <h1>TCB MegaMenu Settings</h1>
            
            <div style="background:#fff;padding:20px;margin:20px 0;border:1px solid #ccd0d4;">
                <h2 style="margin-top:0;">🎨 Colors</h2>
                <table class="form-table">
                    <tr>
                        <th>Background Color</th>
                        <td>
                            <input type="color" name="<?php echo self::OPTION_NAME; ?>[bg]" value="<?php echo esc_attr( $settings['bg'] ); ?>" />
                            <p class="description">Color de fondo del panel</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Text Color</th>
                        <td>
                            <input type="color" name="<?php echo self::OPTION_NAME; ?>[fg]" value="<?php echo esc_attr( $settings['fg'] ); ?>" />
                            <p class="description">Color del texto</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Accent Color</th>
                        <td>
                            <input type="color" name="<?php echo self::OPTION_NAME; ?>[accent]" value="<?php echo esc_attr( $settings['accent'] ); ?>" />
                            <p class="description">Color de acento (links hover, badges)</p>
                        </td>
                    </tr>
                </table>

                <h2>📐 Layout</h2>
                <table class="form-table">
                    <tr>
                        <th>Border Radius</th>
                        <td>
                            <input type="text" name="<?php echo self::OPTION_NAME; ?>[radius]" value="<?php echo esc_attr( $settings['radius'] ); ?>" class="small-text" />
                            <p class="description">Ej: 10px, 0, 5px</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Gap/Spacing</th>
                        <td>
                            <input type="text" name="<?php echo self::OPTION_NAME; ?>[gap]" value="<?php echo esc_attr( $settings['gap'] ); ?>" class="small-text" />
                            <p class="description">Ej: 32px, 2rem</p>
                        </td>
                    </tr>
                </table>

                <h2>⚡ Desktop Behavior</h2>
                <table class="form-table">
                    <tr>
                        <th>Hover In Delay (ms)</th>
                        <td>
                            <input type="number" name="<?php echo self::OPTION_NAME; ?>[hover_in]" value="<?php echo esc_attr( $settings['hover_in'] ); ?>" class="small-text" min="0" max="1000" />
                        </td>
                    </tr>
                    <tr>
                        <th>Hover Out Delay (ms)</th>
                        <td>
                            <input type="number" name="<?php echo self::OPTION_NAME; ?>[hover_out]" value="<?php echo esc_attr( $settings['hover_out'] ); ?>" class="small-text" min="0" max="1000" />
                        </td>
                    </tr>
                </table>

                <h2>📱 Mobile Settings</h2>
                <table class="form-table">
                    <tr>
                        <th>Mobile Breakpoint (px)</th>
                        <td>
                            <input type="number" name="<?php echo self::OPTION_NAME; ?>[breakpoint]" value="<?php echo esc_attr( $settings['breakpoint'] ); ?>" class="small-text" min="320" max="1400" />
                            <p class="description">Ancho donde se activa el modo móvil</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Mobile Menu Style</th>
                        <td>
                            <select name="<?php echo self::OPTION_NAME; ?>[mobile_style]">
                                <option value="accordion" <?php selected( $settings['mobile_style'], 'accordion' ); ?>>📋 Accordion (Vertical)</option>
                                <option value="drawer" <?php selected( $settings['mobile_style'], 'drawer' ); ?>>📥 Drawer (Lateral)</option>
                                <option value="overlay" <?php selected( $settings['mobile_style'], 'overlay' ); ?>>🔲 Overlay (Fullscreen)</option>
                                <option value="slide" <?php selected( $settings['mobile_style'], 'slide' ); ?>>📤 Slide Down</option>
                            </select>
                            <p class="description">Estilo del menú móvil</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Drawer Position</th>
                        <td>
                            <select name="<?php echo self::OPTION_NAME; ?>[mobile_position]">
                                <option value="left" <?php selected( $settings['mobile_position'], 'left' ); ?>>← Left</option>
                                <option value="right" <?php selected( $settings['mobile_position'], 'right' ); ?>>→ Right</option>
                            </select>
                            <p class="description">Posición del drawer (solo para estilo Drawer)</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Drawer Width (px)</th>
                        <td>
                            <input type="number" name="<?php echo self::OPTION_NAME; ?>[mobile_width]" value="<?php echo esc_attr( $settings['mobile_width'] ); ?>" class="small-text" min="200" max="500" />
                            <p class="description">Ancho del drawer (solo para estilo Drawer)</p>
                        </td>
                    </tr>
                </table>

                <h2>🍔 Hamburger Icon</h2>
                <table class="form-table">
                    <tr>
                        <th>Icon Style</th>
                        <td>
                            <select name="<?php echo self::OPTION_NAME; ?>[hamburger_icon]">
                                <option value="classic" <?php selected( $settings['hamburger_icon'], 'classic' ); ?>>☰ Classic (3 lines)</option>
                                <option value="arrow" <?php selected( $settings['hamburger_icon'], 'arrow' ); ?>>← Arrow</option>
                                <option value="dots" <?php selected( $settings['hamburger_icon'], 'dots' ); ?>>⋮ Dots (Vertical)</option>
                                <option value="plus" <?php selected( $settings['hamburger_icon'], 'plus' ); ?>>+ Plus/Minus</option>
                                <option value="x" <?php selected( $settings['hamburger_icon'], 'x' ); ?>>✕ X Mark</option>
                            </select>
                            <p class="description">Estilo del icono hamburguesa</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Icon Color</th>
                        <td>
                            <input type="color" name="<?php echo self::OPTION_NAME; ?>[hamburger_color]" value="<?php echo esc_attr( $settings['hamburger_color'] ); ?>" />
                            <p class="description">Color del icono</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Icon Size (px)</th>
                        <td>
                            <input type="number" name="<?php echo self::OPTION_NAME; ?>[hamburger_size]" value="<?php echo esc_attr( $settings['hamburger_size'] ); ?>" class="small-text" min="16" max="48" />
                            <p class="description">Tamaño del icono en píxeles</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Line Thickness (px)</th>
                        <td>
                            <input type="number" name="<?php echo self::OPTION_NAME; ?>[hamburger_thickness]" value="<?php echo esc_attr( $settings['hamburger_thickness'] ); ?>" class="small-text" min="1" max="5" />
                            <p class="description">Grosor de las líneas del icono</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </div>

            <div style="background:#f0f6fc;padding:20px;border-left:4px solid #2271b1;">
                <h3 style="margin-top:0;">💡 Quick Tips</h3>
                <ul style="margin:0;">
                    <li><strong>Mobile Style:</strong> Accordion es el más simple, Drawer es elegante, Overlay es inmersivo</li>
                    <li><strong>Hamburger Icon:</strong> Elige el que mejor combine con tu diseño</li>
                    <li><strong>Colors:</strong> Asegúrate de que haya buen contraste entre texto y fondo</li>
                    <li><strong>Breakpoint:</strong> Ajusta según tu tema (por defecto 980px)</li>
                </ul>
            </div>
        </div>
        <?php
    }

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
