<?php
/**
 * Uninstall handler for TBMX Mega Menu.
 *
 * Fired when the plugin is uninstalled.
 * Cleans up all plugin data: options and menu item meta.
 *
 * @package TBMX_MegaMenu
 */

// Exit if not called by WordPress
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// 1. Delete global settings option
delete_option( 'tbmx_megamenu_settings' );

// 2. Delete all menu item meta with _tbmx_ prefix
$meta_keys = array(
    '_tbmx_enabled',
    '_tbmx_source',
    '_tbmx_layout_id',
    '_tbmx_width',
    '_tbmx_width_px',
    '_tbmx_align',
    '_tbmx_icon',
    '_tbmx_badge',
);

foreach ( $meta_keys as $key ) {
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->postmeta} WHERE meta_key = %s",
            $key
        )
    );
}

// 3. Clear any transients
$wpdb->query(
    "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_tbmx_%' OR option_name LIKE '_transient_timeout_tbmx_%'"
);
