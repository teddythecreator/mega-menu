<?php
/**
 * Uninstall handler for TCB-MegaMenu.
 *
 * Fired when the plugin is uninstalled.
 *
 * @package TCB_MegaMenu
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// Delete global settings
delete_option( 'tcb_megamenu_settings' );

// Delete all menu item meta
$meta_keys = array(
    '_tcb_enabled',
    '_tcb_source',
    '_tcb_layout_id',
    '_tcb_width',
    '_tcb_width_px',
    '_tcb_align',
    '_tcb_icon',
    '_tcb_badge',
);

foreach ( $meta_keys as $key ) {
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->postmeta} WHERE meta_key = %s",
            $key
        )
    );
}

// Clear transients
$wpdb->query(
    "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_tcb_%' OR option_name LIKE '_transient_timeout_tcb_%'"
);
