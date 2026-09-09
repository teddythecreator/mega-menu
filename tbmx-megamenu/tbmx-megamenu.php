<?php
/**
 * Plugin Name: TBMX Mega Menu
 * Plugin URI: https://tubomax.com/tbmx-megamenu
 * Description: Converts native WordPress menus into mega menus with Divi aesthetic. Panel content uses Divi Library layouts.
 * Version: 0.1.0
 * Author: TuboMax
 * Author URI: https://tubomax.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tbmx-megamenu
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 8.0
 *
 * @package TBMX_MegaMenu
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin constants
define( 'TBMX_MEGAMENU_VERSION', '0.1.0' );
define( 'TBMX_MEGAMENU_FILE', __FILE__ );
define( 'TBMX_MEGAMENU_DIR', plugin_dir_path( __FILE__ ) );
define( 'TBMX_MEGAMENU_URL', plugin_dir_url( __FILE__ ) );
define( 'TBMX_MEGAMENU_BASENAME', plugin_basename( __FILE__ ) );

// Autoloader
require_once TBMX_MEGAMENU_DIR . 'includes/class-plugin.php';

// Initialize plugin
function tbmx_megamenu_init() {
    TBMX_MegaMenu\Plugin::instance();
}
add_action( 'plugins_loaded', 'tbmx_megamenu_init' );

// Activation hook
register_activation_hook( __FILE__, function() {
    // Future: default settings, flush rewrite rules if needed
} );

// Deactivation hook
register_deactivation_hook( __FILE__, function() {
    // Future: cleanup transient data if needed
} );
