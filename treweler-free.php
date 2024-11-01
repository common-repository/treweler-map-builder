<?php
/**
 * Plugin Name: Treweler Map Builder
 * Description: Create customized maps and describe the surroundings with a multi-featured, WordPress and Mapbox based, Treweler plugin.
 * Version: 1.02
 * Author: Aisconverse
 * Plugin URI: https://treweler.com/
 * Author URI: https://aisconverse.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: treweler
 * Domain Path: /languages/
 * Requires at least: 5.7
 * Requires PHP: 7.2
 *
 * @package Treweler
 */

defined( 'ABSPATH' ) || exit;


@ini_set('memory_limit', '4000M');

if ( ! defined( 'TWER_VERSION' ) ) {
  define( 'TWER_VERSION', '1.02' );
}

if ( ! defined( 'TWER_PLUGIN_FILE' ) ) {
  define( 'TWER_PLUGIN_FILE', __FILE__ );
}

// Load core packages and the autoloader.
require __DIR__ . '/libs/autoload.php';


// Include the main Treweler class.
if ( ! class_exists( 'Treweler', false ) ) {
  include_once dirname( TWER_PLUGIN_FILE ) . '/includes/class-treweler.php';
}

/**
 * Returns the main instance of TW.
 *
 * @since  0.23
 * @return Treweler
 */
function TWER() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
  return Treweler::instance();
}

// Global for backwards compatibility.
$GLOBALS['treweler'] = TWER();
