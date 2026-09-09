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
            'bg'         => '#ffffff',
            'fg'         => '#333333',
            'muted'      => '#666666',
            'accent'     => '#e11414',
            'border'     => 'rgba(0,0,0,.08)',
            'radius'     => '10px',
            'shadow'     => '0 24px 60px rgba(0,0,0,.15)',
            'font'       => 'inherit',
            'gap'        => '32px',
            'anim'       => '.22s',
            'width'      => 'full',
            'width_px'   => 1200,
            'hover_in'   => 120,
            'hover_out'  => 200,
            'breakpoint' => 980,
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
                <h2 style="margin-top:0;">Colors</h2>
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

                <h2>Layout</h2>
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

                <h2>Behavior</h2>
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
                    <tr>
                        <th>Mobile Breakpoint (px)</th>
                        <td>
                            <input type="number" name="<?php echo self::OPTION_NAME; ?>[breakpoint]" value="<?php echo esc_attr( $settings['breakpoint'] ); ?>" class="small-text" min="320" max="1400" />
                            <p class="description">Ancho donde se activa el modo móvil</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </div>

            <div style="background:#f0f6fc;padding:20px;border-left:4px solid #2271b1;">
                <h3 style="margin-top:0;">💡 Quick Tips</h3>
                <ul style="margin:0;">
                    <li><strong>Background Color:</strong> Usa un color sólido para mejor visibilidad</li>
                    <li><strong>Text Color:</strong> Asegúrate de que contraste con el fondo</li>
                    <li><strong>Accent Color:</strong> Usa el color de tu marca</li>
                    <li><strong>Mobile Breakpoint:</strong> Ajusta según tu tema (por defecto 980px)</li>
                </ul>
            </div>
        </div>
        <?php
    }

    public static function sanitize( $input ) {
        $sanitized = array();

        // Color fields
        foreach ( array( 'bg', 'fg', 'accent' ) as $key ) {
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
        foreach ( array( 'hover_in', 'hover_out', 'breakpoint', 'width_px' ) as $key ) {
            if ( isset( $input[ $key ] ) ) {
                $sanitized[ $key ] = absint( $input[ $key ] );
            }
        }

        // Select
        if ( isset( $input['width'] ) && in_array( $input['width'], array( 'full', 'container', 'custom' ), true ) ) {
            $sanitized['width'] = $input['width'];
        }

        return wp_parse_args( $sanitized, self::get_defaults() );
    }
}
