<?php
/**
 * Treweler Meta Boxes
 * Sets up the write panels used by maps, routes and markers (custom post types).
 *
 * @package Treweler/Admin/Meta Boxes
 */


defined( 'ABSPATH' ) || exit;

/**
 * TWER_Admin_Meta_Boxes.
 */
class TWER_Admin_Meta_Boxes {

  /**
   * Is meta boxes saved once?
   *
   * @var boolean
   */
  private static bool $saved_meta_boxes = false;


  /**
   * Constructor.
   */
  public function __construct() {

    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/categories.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/controls.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/layers.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/geolocation.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/attribution.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/clustering.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/language.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/restrict-panning.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/map/details/store-locator.php';
    if(twerIsHasDirectionsFeature()) {
      include_once dirname( __FILE__ ) . '/meta-boxes/map/details/directions.php';
    }

    include_once dirname( __FILE__ ) . '/meta-boxes/marker/details/popup-styles.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/marker/details/general.php';

    include_once dirname( __FILE__ ) . '/meta-boxes/map/fields.php';
    include_once dirname( __FILE__ ) . '/meta-boxes/marker/fields.php';



    add_action( 'add_meta_boxes', [ $this, 'remove_meta_boxes' ], 10 );
    add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ], 30 );
    add_action( 'save_post', [ $this, 'save_meta_boxes' ], 1, 2 );
  }

  /**
   * Add TWER Meta boxes.
   */
  public function add_meta_boxes() {
    $screen = get_current_screen();
    $screen_id = $screen ? $screen->id : '';

    if ( twer_is_valid_apikey() ) {

      if($screen_id === 'map') {
        // Map CPT metaboxes
        $mapSettings = new TWER_Meta_Box_Map_Settings();
        $mapSettings->meta_box_id = 'treweler-map-settings';
        $mapSettings->add_meta_box( $mapSettings->meta_box_id, esc_html__( 'Map Settings', 'treweler' ), 'output', 'map', 'side', 'core' );
        add_meta_box( 'treweler_map_description_settings_controls-meta', esc_html__( 'Map Details', 'treweler' ),
          'TWER_Meta_Box_Map_Details::output', 'map', 'normal', 'default' );

        $shortcode_settings = new TWER_Meta_Box_Map_Shortcode();
        $shortcode_settings->meta_box_id = 'treweler-map-shortcode';
        $shortcode_settings->add_meta_box( $shortcode_settings->meta_box_id, esc_html__( 'Map Shortcode', 'treweler' ), 'output', 'map', 'side', 'core' );
      }

	  if('page' === $screen_id) {
		  // Page map metaboxes
		  $page_map_settings              = new TWER_Meta_Box_Page_Map();
		  $page_map_settings->meta_box_id = 'treweler-page-map';
		  $page_map_settings->add_meta_box( $page_map_settings->meta_box_id, esc_html__( 'Treweler Fullscreen Map', 'treweler' ), 'output', 'page', 'side', 'core' );
	  }

      if($screen_id === 'marker') {
        // Marker CPT metaboxes
        add_meta_box( 'treweler_map_marker_settings_controls-meta', esc_html__( 'Marker Settings', 'treweler' ),
          'TWER_Meta_Box_Marker_Settings::output', 'marker', 'side', 'core' );
        add_meta_box( 'treweler_marker_details', esc_html__( 'Marker Details', 'treweler' ),
          'TWER_Meta_Box_Marker_Details::output', 'marker', 'normal', 'default' );
      }

      if($screen_id === 'route') {
        // Route CPT metaboxes
        add_meta_box( 'treweler-route-settings', esc_html__( 'Route Settings', 'treweler' ),
          'TWER_Meta_Box_Route_Settings::output', 'route', 'side', 'low' );

        add_meta_box( 'treweler-route-details', esc_html__( 'Route Details', 'treweler' ),
          'TWER_Meta_Box_Route_Details::output', 'route', 'normal', 'default' );
      }
    }
  }

  /**
   * Remove bloat.
   */
  public function remove_meta_boxes() {
    $screens = twer_get_screen_ids();

    if ( $screens ) {
      foreach ( $screens as $screen ) {
        remove_meta_box( 'postexcerpt', $screen, 'normal' );
        remove_meta_box( 'commentsdiv', $screen, 'normal' );
        remove_meta_box( 'commentstatusdiv', $screen, 'side' );
        remove_meta_box( 'commentstatusdiv', $screen, 'normal' );
        remove_meta_box( 'commentstatusdiv', $screen, 'normal' );
        remove_meta_box( 'slugdiv', $screen, 'normal' );

        // Remove Metabox In Category
        if ( 'map' === $screen ) {
          remove_meta_box( 'map-categorydiv', $screen, 'side' );
        }
      }
    }


  }

  /**
   * Check if we're saving, the trigger an action based on the post type.
   *
   * @param int $post_id Post ID.
   * @param object $post Post object.
   */
  public function save_meta_boxes( $post_id, $post ) {
    $post_id = absint( $post_id );

    // $post_id and $post are required
    if ( empty( $post_id ) || empty( $post ) || self::$saved_meta_boxes ) {
      return;
    }

    // Dont' save meta boxes for revisions or autosaves.
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
      return;
    }

    // Check the nonce.
    if ( empty( $_POST['treweler_meta_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['treweler_meta_nonce'] ),
        'treweler_save_data' ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
      return;
    }

    // Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
    if ( empty( $_POST['post_ID'] ) || absint( $_POST['post_ID'] ) !== $post_id ) {
      return;
    }

    // Check user has permission to edit.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }

    // We need this save event to run once to avoid potential endless loops. This would have been perfect:
    // remove_action( current_filter(), __METHOD__ );
    self::$saved_meta_boxes = true;

    foreach ( $_POST as $key => $value ) {
      if ( strpos( $key, '_treweler' ) !== false ) {
        update_post_meta( $post_id, $key, $value );
      }
    }
  }
}

new TWER_Admin_Meta_Boxes();
