<?php
/**
 * Main plugin class - Singleton orchestrator
 *
 * @package TCB_MegaMenu
 */

namespace TCB_MegaMenu;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Plugin {

    private static $instance = null;
    private $version;
    private $menu_fields;
    private $settings;
    private $assets;
    private $renderer;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->version = TCB_MEGAMENU_VERSION;
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function __clone() {}

    public function __wakeup() {
        throw new \Exception( 'Cannot unserialize singleton' );
    }

    private function load_dependencies() {
        require_once TCB_MEGAMENU_DIR . 'includes/class-menu-fields.php';
        require_once TCB_MEGAMENU_DIR . 'includes/class-menu-walker.php';
        require_once TCB_MEGAMENU_DIR . 'includes/class-settings.php';
        require_once TCB_MEGAMENU_DIR . 'includes/class-assets.php';
        require_once TCB_MEGAMENU_DIR . 'includes/class-renderer.php';

        $this->menu_fields = new Menu_Fields();
        $this->settings    = new Settings();
        $this->assets      = new Assets();
        $this->renderer    = new Renderer();
    }

    private function set_locale() {
        add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
    }

    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'tcb-megamenu',
            false,
            dirname( TCB_MEGAMENU_BASENAME ) . '/languages/'
        );
    }

    private function define_admin_hooks() {
        // Menu fields (metabox in menu items)
        add_action( 'wp_nav_menu_item_custom_fields', array( $this->menu_fields, 'render_fields' ), 10, 5 );
        add_action( 'wp_update_nav_menu_item', array( $this->menu_fields, 'save_fields' ), 10, 3 );

        // Settings page - MENÚ PRINCIPAL (no bajo Apariencia)
        add_action( 'admin_menu', array( $this->settings, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this->settings, 'register_settings' ) );

        // Admin assets
        add_action( 'admin_enqueue_scripts', array( $this->assets, 'enqueue_admin_assets' ) );

        // Add custom menu icon
        add_action( 'admin_head', array( $this, 'add_menu_icon_styles' ) );
    }

    /**
     * Add custom icon styles for the menu
     */
    public function add_menu_icon_styles() {
        ?>
        <style>
            #adminmenu .toplevel_page_tcb-megamenu .dashicons-before::before {
                content: "\f333"; /* Grid icon */
                color: #f0b429;
            }
            #adminmenu .toplevel_page_tcb-megamenu.wp-menu-open .dashicons-before::before,
            #adminmenu .toplevel_page_tcb-megamenu:hover .dashicons-before::before {
                color: #e11414;
            }
        </style>
        <?php
    }

    private function define_public_hooks() {
        // Front-end assets (conditional)
        add_action( 'wp_enqueue_scripts', array( $this->assets, 'enqueue_public_assets' ) );

        // Apply custom walker to ALL menus (force for Divi compatibility)
        // Priority 999 ensures it runs after theme's walker
        add_filter( 'wp_nav_menu_args', array( $this, 'apply_walker' ), 999 );

        // Add body class when mega menu is active
        add_filter( 'body_class', array( $this, 'add_body_class' ) );
    }

    /**
     * Apply custom walker to ALL menus on frontend.
     * Forces walker for Divi compatibility - no external code needed.
     */
    public function apply_walker( $args ) {
        // Don't apply in admin
        if ( is_admin() ) {
            return $args;
        }

        // Don't apply in page builders (Divi Builder, Elementor, etc.)
        if ( Assets::is_page_builder() ) {
            return $args;
        }

        // Don't override if already using our walker
        if ( isset( $args['walker'] ) && $args['walker'] instanceof Menu_Walker ) {
            return $args;
        }

        // FORCE our walker on ALL frontend menus
        // This ensures compatibility with Divi and other themes
        $args['walker'] = new Menu_Walker();

        return $args;
    }

    /**
     * Add body class when mega menu is active on the page.
     */
    public function add_body_class( $classes ) {
        // Don't add in admin or page builders
        if ( is_admin() || Assets::is_page_builder() ) {
            return $classes;
        }

        if ( Assets::any_menu_has_mega_items() ) {
            $classes[] = 'tcb-megamenu-active';
        }
        return $classes;
    }

    public function get_version() {
        return $this->version;
    }

    public function get_settings() {
        return $this->settings;
    }

    public function get_renderer() {
        return $this->renderer;
    }
}
