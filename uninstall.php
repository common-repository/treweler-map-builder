<?php
/**
 * Treweler Uninstall
 * Uninstalling Treweler deletes user roles and options.
 *
 * @package Treweler\Uninstaller
 * @version 1.08
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

global $wpdb, $wp_version;

/*
 * Only remove ALL product and page data if TWER_REMOVE_ALL_DATA constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'TWER_REMOVE_ALL_DATA' ) && true === TWER_REMOVE_ALL_DATA ) {

  include_once dirname( __FILE__ ) . '/includes/class-twer-install.php';

  // Roles + caps.
  TWER_Install::remove_roles();

  // Clear any cached data that has been removed.
  wp_cache_flush();
}
