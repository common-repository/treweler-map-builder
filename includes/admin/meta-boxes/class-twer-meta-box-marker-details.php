<?php
/**
 * Map
 * Display the marker details meta box.
 *
 * @author      Aisconverse
 * @category    Admin
 * @package     Treweler/Admin/Meta Boxes
 * @version     0.38
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * TWER_Meta_Box_Marker_Details Class.
 */
class TWER_Meta_Box_Marker_Details {

	/**
	 * Output the metabox.
	 *
	 * @param  WP_Post  $post
	 */
	public static function output( $post ) {
		wp_nonce_field( 'treweler_save_data', 'treweler_meta_nonce' );

		include TWER()->admin_views_path() . 'html-marker-details-panel'.TWER_FREE_FILE_SUFFIX.'.php';
	}

}
