<?php
/**
 * Uninstall handler for TCB-MegaMenu.
 *
 * Fired when the plugin is uninstalled.
 * 
 * IMPORTANT: This only removes the plugin's global settings and transients.
 * Menu item configurations (_tcb_* meta) are PRESERVED so users don't lose
 * their work when temporarily deactivating or updating the plugin.
 *
 * To completely remove all data including menu configurations, use the
 * "Reset All Data" option in TCB MegaMenu → Settings → Data Management.
 *
 * @package TCB_MegaMenu
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// Delete global settings option
delete_option( 'tcb_megamenu_settings' );

// Clear transients
$wpdb->query(
    "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_tcb_%' OR option_name LIKE '_transient_timeout_tcb_%'"
);

/**
 * IMPORTANT: Menu item meta (_tcb_*) is NOT deleted here.
 * 
 * This preserves user configurations when:
 * - Temporarily deactivating the plugin
 * - Updating to a new version
 * - Testing with the plugin on/off
 * 
 * Users who want to completely remove all data can use the
 * "Reset All Data" button in the plugin settings page.
 */
