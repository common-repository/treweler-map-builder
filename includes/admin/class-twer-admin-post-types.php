<?php
/**
 * Post Types Admin
 *
 * @package  Treweler/admin
 * @version  0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'TWER_Admin_Post_Types', false ) ) {
	new TWER_Admin_Post_Types();

	return;
}

/**
 * TWER_Admin_Post_Types Class.
 * Handles the edit posts views and some functionality on the edit post screen for TWER post types.
 */
class TWER_Admin_Post_Types {

	/**
	 * Constructor.
	 */
	public function __construct() {
		include_once dirname( __FILE__ ) . '/class-twer-admin-meta-boxes.php';

		// Load correct list table classes for current screen.
		add_action( 'current_screen', [ $this, 'setup_screen' ] );
		add_action( 'check_ajax_referer', [ $this, 'setup_screen' ] );

		// Extra post data and screen elements.
		add_action( 'edit_form_top', [ $this, 'edit_form_top' ] );
		add_action( 'edit_form_after_title', [ $this, 'edit_form_after_title' ] );
		add_filter( 'enter_title_here', [ $this, 'enter_title_here' ], 1, 2 );
		add_filter( 'default_hidden_meta_boxes', [ $this, 'hidden_meta_boxes' ], 10, 2 );

		// Admin notices.
		add_filter( 'post_updated_messages', [ $this, 'post_updated_messages' ] );
		add_filter( 'bulk_post_updated_messages', [ $this, 'bulk_post_updated_messages' ], 10, 2 );
	}


	/**
	 * Looks at the current screen and loads the correct list table handler.
	 *
	 * @since 3.3.0
	 */
	public function setup_screen() {
		global $twer_list_table;

		$screen_id = false;

		if ( function_exists( 'get_current_screen' ) ) {
			$screen    = get_current_screen();
			$screen_id = isset( $screen, $screen->id ) ? $screen->id : '';
		}

		if ( ! empty( $_REQUEST['screen'] ) ) { // WPCS: input var ok.
			$screen_id = twer_clean( wp_unslash( $_REQUEST['screen'] ) ); // WPCS: input var ok, sanitization ok.
		}

		switch ( $screen_id ) {
			case 'edit-map':
				include_once 'list-tables/class-twer-admin-list-table-map.php';
				$twer_list_table = new TWER_Admin_List_Table_Map();
				break;
			case 'edit-marker':
				include_once 'list-tables/class-twer-admin-list-table-marker.php';
				$twer_list_table = new TWER_Admin_List_Table_Marker();
				break;
			case 'edit-route':
				include_once 'list-tables/class-twer-admin-list-table-route.php';
				$twer_list_table = new TWER_Admin_List_Table_Route();
				break;
		}

		// Ensure the table handler is only loaded once. Prevents multiple loads if a plugin calls check_ajax_referer many times.
		remove_action( 'current_screen', [ $this, 'setup_screen' ] );
		remove_action( 'check_ajax_referer', [ $this, 'setup_screen' ] );
	}

	/**
	 * Change messages when a post type is updated.
	 *
	 * @param array $messages Array of messages.
	 *
	 * @return array
	 */
	public function post_updated_messages( $messages ) {
		global $post;

		$messages['map'] = [
			0  => '', // Unused. Messages start at index 1.
			1  => esc_html__( 'Map updated.', 'treweler' ),
			2  => esc_html__( 'Custom field updated.', 'treweler' ),
			3  => esc_html__( 'Custom field deleted.', 'treweler' ),
			4  => esc_html__( 'Map updated.', 'treweler' ),
			5  => esc_html__( 'Revision restored.', 'treweler' ),
			6  => esc_html__( 'Map published.', 'treweler' ),
			7  => esc_html__( 'Map saved.', 'treweler' ),
			8  => esc_html__( 'Map submitted.', 'treweler' ),
			9  => sprintf(
			/* translators: %s: date */
				'%s %s.',
				esc_html__( 'Map scheduled for:', 'treweler' ),
				'<strong>' . date_i18n( esc_html__( 'M j, Y @ G:i', 'treweler' ), strtotime( $post->post_date ) ) . '</strong>'
			),
			/* translators: %s: map url */
			10 => esc_html__( 'Map draft updated.', 'treweler' )
		];

		$messages['route'] = [
			0  => '', // Unused. Messages start at index 1.
			1  => esc_html__( 'Route updated.', 'treweler' ),
			2  => esc_html__( 'Custom field updated.', 'treweler' ),
			3  => esc_html__( 'Custom field deleted.', 'treweler' ),
			4  => esc_html__( 'Route updated.', 'treweler' ),
			5  => esc_html__( 'Revision restored.', 'treweler' ),
			6  => esc_html__( 'Route updated.', 'treweler' ),
			7  => esc_html__( 'Route saved.', 'treweler' ),
			8  => esc_html__( 'Route submitted.', 'treweler' ),
			9  => sprintf(
			/* translators: %s: date */
				'%s %s.',
				esc_html__( 'Route scheduled for:', 'treweler' ),
				'<strong>' . date_i18n( esc_html__( 'M j, Y @ G:i', 'treweler' ), strtotime( $post->post_date ) ) . '</strong>'
			),
			10 => esc_html__( 'Route draft updated.', 'treweler' )
		];

		$messages['marker'] = [
			0  => '', // Unused. Messages start at index 1.
			1  => esc_html__( 'Marker updated.', 'treweler' ),
			2  => esc_html__( 'Custom field updated.', 'treweler' ),
			3  => esc_html__( 'Custom field deleted.', 'treweler' ),
			4  => esc_html__( 'Marker updated.', 'treweler' ),
			5  => esc_html__( 'Revision restored.', 'treweler' ),
			6  => esc_html__( 'Marker updated.', 'treweler' ),
			7  => esc_html__( 'Marker saved.', 'treweler' ),
			8  => esc_html__( 'Marker submitted.', 'treweler' ),
			9  => sprintf(
			/* translators: %s: date */
				'%s %s.',
				esc_html__( 'Marker scheduled for:', 'treweler' ),
				'<strong>' . date_i18n( esc_html__( 'M j, Y @ G:i', 'treweler' ), strtotime( $post->post_date ) ) . '</strong>'
			),
			10 => esc_html__( 'Marker draft updated.', 'treweler' ),
		];

		return $messages;
	}

	/**
	 * Specify custom bulk actions messages for different post types.
	 *
	 * @param array $bulk_messages Array of messages.
	 * @param array $bulk_counts Array of how many objects were updated.
	 *
	 * @return array
	 */
	public function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {
		$bulk_messages['map'] = [
			/* translators: %s: map count */
			'updated'   => _n( '%s map updated.', '%s maps updated.', $bulk_counts['updated'], 'treweler' ),
			/* translators: %s: map count */
			'locked'    => _n( '%s map not updated, somebody is editing it.',
				'%s maps not updated, somebody is editing them.', $bulk_counts['locked'], 'treweler' ),
			/* translators: %s: map count */
			'deleted'   => _n( '%s map permanently deleted.', '%s maps permanently deleted.', $bulk_counts['deleted'],
				'treweler' ),
			/* translators: %s: map count */
			'trashed'   => _n( '%s map moved to the Trash.', '%s maps moved to the Trash.', $bulk_counts['trashed'],
				'treweler' ),
			/* translators: %s: map count */
			'untrashed' => _n( '%s map restored from the Trash.', '%s maps restored from the Trash.',
				$bulk_counts['untrashed'], 'treweler' ),
		];

		$bulk_messages['route'] = [
			/* translators: %s: route count */
			'updated'   => _n( '%s route updated.', '%s routes updated.', $bulk_counts['updated'], 'treweler' ),
			/* translators: %s: route count */
			'locked'    => _n( '%s route not updated, somebody is editing it.',
				'%s routes not updated, somebody is editing them.', $bulk_counts['locked'], 'treweler' ),
			/* translators: %s: route count */
			'deleted'   => _n( '%s route permanently deleted.', '%s routes permanently deleted.',
				$bulk_counts['deleted'], 'treweler' ),
			/* translators: %s: route count */
			'trashed'   => _n( '%s route moved to the Trash.', '%s routes moved to the Trash.', $bulk_counts['trashed'],
				'treweler' ),
			/* translators: %s: route count */
			'untrashed' => _n( '%s route restored from the Trash.', '%s routes restored from the Trash.',
				$bulk_counts['untrashed'], 'treweler' ),
		];

		$bulk_messages['marker'] = [
			/* translators: %s: marker count */
			'updated'   => _n( '%s marker updated.', '%s markers updated.', $bulk_counts['updated'], 'treweler' ),
			/* translators: %s: marker count */
			'locked'    => _n( '%s marker not updated, somebody is editing it.',
				'%s markers not updated, somebody is editing them.', $bulk_counts['locked'], 'treweler' ),
			/* translators: %s: marker count */
			'deleted'   => _n( '%s marker permanently deleted.', '%s markers permanently deleted.',
				$bulk_counts['deleted'], 'treweler' ),
			/* translators: %s: marker count */
			'trashed'   => _n( '%s marker moved to the Trash.', '%s markers moved to the Trash.',
				$bulk_counts['trashed'], 'treweler' ),
			/* translators: %s: marker count */
			'untrashed' => _n( '%s marker restored from the Trash.', '%s markers restored from the Trash.',
				$bulk_counts['untrashed'], 'treweler' ),
		];

		return $bulk_messages;
	}


	/**
	 * Output extra data on post forms.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function edit_form_top( $post ) {
		echo '<input type="hidden" id="original_post_title" name="_treweler_original_post_title" value="' . esc_attr( $post->post_title ) . '" />';
	}

	/**
	 * Change title boxes in admin.
	 *
	 * @param string $text Text to shown.
	 * @param WP_Post $post Current post object.
	 *
	 * @return string
	 */
	public function enter_title_here( $text, $post ) {
		switch ( $post->post_type ) {
			case 'map':
				$text = esc_html__( 'Map name', 'treweler' );
				break;
			case 'marker':
				$text = esc_html__( 'Marker name', 'treweler' );
				break;
			case 'route':
				$text = esc_html__( 'Route name', 'treweler' );
				break;
		}

		return $text;
	}

	/**
	 * Print map/marker/route init fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function edit_form_after_title( $post ) {
		$post_type = isset( $post->post_type ) ? $post->post_type : '';
		if ( twer_is_valid_apikey() ) {
			echo '<div id="js-twer-body" class="twer-body">';
			if ( 'map' === $post_type ) {
				echo '<div id="map" class="treweler-mapbox"></div>';
			} elseif ( 'marker' === $post_type || 'twer-templates' === $post_type ) {
				echo '<div id="marker_map" class="treweler-mapbox"></div>';
			} elseif ( 'route' === $post_type ) {
				$routeProfile = get_post_meta( $post->ID, '_treweler_route_profile', true );
				$routeProfile = ( $routeProfile != '' ? $routeProfile : 'no' );
				?>
                <div class="mapbox-directions-profile" id="js-twer-directions">
                    <input id="mapbox-directions-profile-no" type="radio" name="_treweler_route_profile"
                           value="no" <?php echo ( $routeProfile == 'no' ) ? 'checked' : ''; ?>>
                    <label for="mapbox-directions-profile-no"><?php echo esc_html__( 'No Match',
							'treweler' ); ?></label>
                    <input id="mapbox-directions-profile-driving" type="radio" name="_treweler_route_profile"
                           value="driving" <?php echo ( $routeProfile == 'driving' ) ? 'checked' : ''; ?>>
                    <label for="mapbox-directions-profile-driving"><?php echo esc_html__( 'Driving',
							'treweler' ); ?></label>
                    <input id="mapbox-directions-profile-walking" type="radio" name="_treweler_route_profile"
                           value="walking" <?php echo ( $routeProfile == 'walking' ) ? 'checked' : ''; ?>>
                    <label for="mapbox-directions-profile-walking"><?php echo esc_html__( 'Walking',
							'treweler' ); ?></label>
                    <input id="mapbox-directions-profile-cycling" type="radio" name="_treweler_route_profile"
                           value="cycling" <?php echo ( $routeProfile == 'cycling' ) ? 'checked' : ''; ?>>
                    <label for="mapbox-directions-profile-cycling"><?php echo esc_html__( 'Cycling',
							'treweler' ); ?></label>
                </div>
                <div id="js-twer-route-map" class="treweler-mapbox"></div>
                <div class="info-box">
                    <div id="info">
                        <p><?php echo esc_html__( 'Draw your route using the draw tools in the upper right corner of the map. To get the most accurate route match, draw points at regular intervals.',
								'treweler' ); ?></p>
                    </div>
                    <div id="directions"></div>
                </div>
				<?php
			}

			echo '</div>';
		}
	}

	/**
	 * Hidden default Meta-Boxes.
	 *
	 * @param array $hidden Hidden boxes.
	 * @param object $screen Current screen.
	 *
	 * @return array
	 */
	public function hidden_meta_boxes( $hidden, $screen ) {
		if ( 'map' === $screen->post_type && 'post' === $screen->base ) {
			$hidden = array_merge( $hidden, [ 'postcustom' ] );
		}

		return $hidden;
	}

}

new TWER_Admin_Post_Types();
