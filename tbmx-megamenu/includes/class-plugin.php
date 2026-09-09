<?php
/**
 * Main plugin class - Singleton orchestrator
 *
 * @package TBMX_MegaMenu
 */

namespace TBMX_MegaMenu;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Plugin
 *
 * Main plugin orchestrator using Singleton pattern.
 * Registers all hooks and loads dependencies.
 */
final class Plugin {

    /**
     * Single instance of the class
     *
     * @var Plugin|null
     */
    private static $instance = null;

    /**
     * Plugin version
     *
     * @var string
     */
    private $version;

    /**
     * Menu Fields handler
     *
     * @var Menu_Fields|null
     */
    private $menu_fields;

    /**
     * Settings handler
     *
     * @var Settings|null
     */
    private $settings;

    /**
     * Assets handler
     *
     * @var Assets|null
     */
    private $assets;

    /**
     * Renderer handler
     *
     * @var Renderer|null
     */
    private $renderer;

    /**
     * Get single instance of the class
     *
     * @return Plugin
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - private to enforce Singleton
     */
    private function __construct() {
        $this->version = TBMX_MEGAMENU_VERSION;
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Prevent unserializing
     */
    public function __wakeup() {
        throw new \Exception( 'Cannot unserialize singleton' );
    }

    /**
     * Load required dependencies
     */
    private function load_dependencies() {
        require_once TBMX_MEGAMENU_DIR . 'includes/class-menu-fields.php';
        require_once TBMX_MEGAMENU_DIR . 'includes/class-menu-walker.php';
        require_once TBMX_MEGAMENU_DIR . 'includes/class-settings.php';
        require_once TBMX_MEGAMENU_DIR . 'includes/class-assets.php';
        require_once TBMX_MEGAMENU_DIR . 'includes/class-renderer.php';

        $this->menu_fields = new Menu_Fields();
        $this->settings    = new Settings();
        $this->assets      = new Assets();
        $this->renderer    = new Renderer();
    }

    /**
     * Define the locale for i18n
     */
    private function set_locale() {
        add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
    }

    /**
     * Load plugin text domain for translations
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'tbmx-megamenu',
            false,
            dirname( TBMX_MEGAMENU_BASENAME ) . '/languages/'
        );
    }

    /**
     * Register admin-specific hooks
     */
    private function define_admin_hooks() {
        // Menu fields (metabox in menu items)
        add_action( 'wp_nav_menu_item_custom_fields', array( $this->menu_fields, 'render_fields' ), 10, 5 );
        add_action( 'wp_update_nav_menu_item', array( $this->menu_fields, 'save_fields' ), 10, 3 );

        // Settings page
        add_action( 'admin_menu', array( $this->settings, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this->settings, 'register_settings' ) );

        // Admin assets
        add_action( 'admin_enqueue_scripts', array( $this->assets, 'enqueue_admin_assets' ) );
    }

    /**
     * Register public-facing hooks
     */
    private function define_public_hooks() {
        // Front-end assets (conditional)
        add_action( 'wp_enqueue_scripts', array( $this->assets, 'enqueue_public_assets' ) );

        // Apply custom walker to menus with mega items
        add_filter( 'wp_nav_menu_args', array( $this, 'apply_walker' ) );

        // Add body class when mega menu is active
        add_filter( 'body_class', array( $this, 'add_body_class' ) );
    }

    /**
     * Apply custom walker to menus that have mega items.
     *
     * Hooked to: wp_nav_menu_args
     *
     * @param array $args wp_nav_menu() arguments.
     * @return array Modified arguments.
     */
    public function apply_walker( $args ) {
        // If walker already set to ours, skip
        if ( isset( $args['walker'] ) && $args['walker'] instanceof Menu_Walker ) {
            return $args;
        }

        // Determine which menu we're dealing with
        $menu_id = 0;

        if ( ! empty( $args['menu'] ) ) {
            if ( is_numeric( $args['menu'] ) ) {
                $menu_id = (int) $args['menu'];
            } else {
                $menu = wp_get_nav_menu_object( $args['menu'] );
                if ( $menu ) {
                    $menu_id = $menu->term_id;
                }
            }
        } elseif ( ! empty( $args['theme_location'] ) ) {
            $locations = get_nav_menu_locations();
            if ( isset( $locations[ $args['theme_location'] ] ) ) {
                $menu_id = (int) $locations[ $args['theme_location'] ];
            }
        }

        // Check if this menu has mega items
        if ( $menu_id && Assets::menu_has_mega_items( $menu_id ) ) {
            $args['walker'] = new Menu_Walker();
        }

        return $args;
    }

    /**
     * Add body class when mega menu is active on the page.
     *
     * Hooked to: body_class
     *
     * @param array $classes Body classes.
     * @return array Modified classes.
     */
    public function add_body_class( $classes ) {
        if ( Assets::any_menu_has_mega_items() ) {
            $classes[] = 'tbmx-megamenu-active';
        }
        return $classes;
    }

    /**
     * Get plugin version
     *
     * @return string
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Get settings instance
     *
     * @return Settings
     */
    public function get_settings() {
        return $this->settings;
    }

    /**
     * Get renderer instance
     *
     * @return Renderer
     */
    public function get_renderer() {
        return $this->renderer;
    }
}
