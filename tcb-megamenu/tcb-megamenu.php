<?php
/**
 * Plugin Name: TCB-MegaMenu
 * Plugin URI: https://thecreator.business/tcb-megamenu
 * Description: Professional mega menus for WordPress with Divi integration. Create stunning mega menus using Divi Library layouts or custom columns.
 * Version: 1.0.0
 * Author: The Creator Business
 * Author URI: https://thecreator.business/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tcb-megamenu
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 8.0
 *
 * @package TCB_MegaMenu
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin constants
define( 'TCB_MEGAMENU_VERSION', '1.0.0' );
define( 'TCB_MEGAMENU_FILE', __FILE__ );
define( 'TCB_MEGAMENU_DIR', plugin_dir_path( __FILE__ ) );
define( 'TCB_MEGAMENU_URL', plugin_dir_url( __FILE__ ) );
define( 'TCB_MEGAMENU_BASENAME', plugin_basename( __FILE__ ) );

// Autoloader
require_once TCB_MEGAMENU_DIR . 'includes/class-plugin.php';

// Initialize plugin
function tcb_megamenu_init() {
    TCB_MegaMenu\Plugin::instance();
}
add_action( 'plugins_loaded', 'tcb_megamenu_init' );

// Activation hook
register_activation_hook( __FILE__, function() {
    // Set default options on activation
    if ( ! get_option( 'tcb_megamenu_settings' ) ) {
        update_option( 'tcb_megamenu_settings', TCB_MegaMenu\Settings::get_defaults() );
    }
} );

// Deactivation hook
register_deactivation_hook( __FILE__, function() {
    // Cleanup if needed
} );
