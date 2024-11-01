<?php
/**
 * Marker
 * Display the marker settings meta box.
 *
 * @author      Aisconverse
 * @category    Admin
 * @package     Treweler/Admin/Meta Boxes
 * @version     0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * TWER_Meta_Box_Marker_Settings Class.
 */
class TWER_Meta_Box_Marker_Settings {

	/**
	 * Output the metabox.
	 *
	 * @param  WP_Post  $post
	 */
	public static function output( $post ) {
		wp_nonce_field( 'treweler_save_data', 'treweler_meta_nonce' );

		include TWER()->admin_views_path() . 'html-marker-settings-panel.php';
	}


  public static function output_template( $post ) {
    //wp_nonce_field( 'treweler_save_data', 'treweler_meta_nonce' );

    include TWER()->admin_views_path() . 'html-marker-template-settings-panel.php';
  }
}
