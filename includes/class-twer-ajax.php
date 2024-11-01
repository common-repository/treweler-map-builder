<?php
/**
 * Treweler TWER_AJAX. AJAX Event Handlers.
 *
 * @class   TWER_AJAX
 * @package Treweler\Classes
 */

defined( 'ABSPATH' ) || exit;

/**
 * TWER_Ajax class.
 */
class TWER_AJAX {

  /**
   * Hook in ajax handlers.
   */
  public static function init() {
    add_action( 'init', array( __CLASS__, 'define_ajax' ), 0 );
    add_action( 'template_redirect', array( __CLASS__, 'do_twer_ajax' ), 0 );
    self::add_ajax_events();
  }

  /**
   * Get TWER Ajax Endpoint.
   *
   * @param string $request Optional.
   *
   * @return string
   */
  public static function get_endpoint( $request = '' ) {
    return esc_url_raw( apply_filters( 'twer_ajax_get_endpoint', add_query_arg( 'twer-ajax', $request, remove_query_arg( array( 'remove_item', 'add-to-cart', 'added-to-cart', 'order_again', '_wpnonce' ), home_url( '/', 'relative' ) ) ), $request ) );
  }

  /**
   * Set TWER AJAX constant and headers.
   */
  public static function define_ajax() {
    // phpcs:disable
    if ( ! empty( $_GET['twer-ajax'] ) ) {
      twer_maybe_define_constant( 'DOING_AJAX', true );
      twer_maybe_define_constant( 'TWER_DOING_AJAX', true );
      if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
        @ini_set( 'display_errors', 0 ); // Turn off display_errors during AJAX events to prevent malformed JSON.
      }
      $GLOBALS['wpdb']->hide_errors();
    }
    // phpcs:enable
  }

  /**
   * Send headers for TWER Ajax Requests.
   *
   * @since 1.14
   */
  private static function twer_ajax_headers() {
    if ( ! headers_sent() ) {
      send_origin_headers();
      send_nosniff_header();
      twer_nocache_headers();
      header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
      header( 'X-Robots-Tag: noindex' );
      status_header( 200 );
    } elseif ( defined( WP_DEBUG ) && true === WP_DEBUG ) {
      headers_sent( $file, $line );
      trigger_error( "twer_ajax_headers cannot set headers - headers already sent by {$file} on line {$line}", E_USER_NOTICE ); // @codingStandardsIgnoreLine
    }
  }

  /**
   * Check for TWER Ajax request and fire action.
   */
  public static function do_twer_ajax() {
    global $wp_query;

    // phpcs:disable WordPress.Security.NonceVerification.Recommended
    if ( ! empty( $_GET['twer-ajax'] ) ) {
      $wp_query->set( 'twer-ajax', sanitize_text_field( wp_unslash( $_GET['twer-ajax'] ) ) );
    }

    $action = $wp_query->get( 'twer-ajax' );

    if ( $action ) {
      self::twer_ajax_headers();
      $action = sanitize_text_field( $action );
      do_action( 'twer_ajax_' . $action );
      wp_die();
    }
    // phpcs:enable
  }

  /**
   * Hook in methods - uses WordPress ajax handlers (admin-ajax).
   */
  public static function add_ajax_events() {
    $ajax_events_nopriv = array(
      'loadMapMarkers',
      'getDataForMapMarkers',
      'getStoreLocatorMapFilters'
    );

    foreach ( $ajax_events_nopriv as $ajax_event ) {
      add_action( 'wp_ajax_twer_' . $ajax_event, array( __CLASS__, $ajax_event ) );
      add_action( 'wp_ajax_nopriv_twer_' . $ajax_event, array( __CLASS__, $ajax_event ) );

      // TWER AJAX can be used for frontend ajax requests.
      add_action( 'twer_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
    }

//		$ajax_events = array(
//			'feature_product',
//		);
//
//		foreach ( $ajax_events as $ajax_event ) {
//			add_action( 'wp_ajax_twer_' . $ajax_event, array( __CLASS__, $ajax_event ) );
//		}
//
//		$ajax_private_events = array(
//			'order_add_meta',
//			'order_delete_meta',
//		);
//
//		foreach ( $ajax_private_events as $ajax_event ) {
//			add_action(
//				'wp_ajax_twer_' . $ajax_event,
//				function() use ( $ajax_event ) {
//					call_user_func( array( __CLASS__, $ajax_event ) );
//				}
//			);
//		}
  }

  /**
   * AJAX load markers for specified map
   */
  public static function loadMapMarkers() {
    $mapId = isset( $_POST['mapId'] ) ? (int) twer_clean( wp_unslash( $_POST['mapId'] ) ) : 0;
    $markers = twerGetMarkersForMap( $mapId );

    wp_send_json( [ 'test' => $markers ] );
    wp_die();
  }

  public static function getDataForMapMarkers() {
    $mapId = $_POST['mapId'] ?? 0;
    $mapMarkers = twerGetMarkersForMap( $mapId, [ 'fields' => 'ids' ] );
    $markersData = [];
    if ( ! empty( $mapMarkers ) ) {
      foreach ( $mapMarkers as $mapMarkerId ) {
        $marker_meta_data = twer_get_data( $mapMarkerId );

        $template_data = [];
        $current_template = isset( $marker_meta_data->templates ) ? $marker_meta_data->templates : 'none';

        if ( 'none' !== $current_template && ! empty( $current_template ) && 'publish' === get_post_status( $current_template ) ) {
          $template_data = twerTemplateMetaDiff( twer_get_data( $current_template ) );
        }

        if ( ! empty( (array) $template_data ) ) {
          $marker_meta_data = twerTemplateMerge( $marker_meta_data, $template_data );

        }




        $popupCustomFields = twerGetCustomFieldsForMarker( $mapMarkerId );
        $locatorPreviewCustomFields = twerGetCustomFieldsForMarker( $mapMarkerId, 'locator_preview' );
        $locatorCustomFields = twerGetCustomFieldsForMarker( $mapMarkerId, 'locator' );

        $markerDetails = [];

        if ( isset( $marker_meta_data->popup_image ) ) {
          $popupImage = $marker_meta_data->popup_image;
          $popupImages = [];
          if ( ! filter_var( $popupImage, FILTER_VALIDATE_URL ) ) {
            $popup_image_val = explode( ',', $popupImage );
            if ( ! empty( $popup_image_val ) && is_array( $popup_image_val ) ) {
              foreach ( $popup_image_val as $popup_image_value ) {
                $attach_url = wp_get_attachment_image_url( $popup_image_value, 'full' );
                $attach_caption = wp_get_attachment_caption( $popup_image_value );
                if ( ! empty( $attach_url ) ) {
                  $popupImages[] = [
                    'url'     => $attach_url,
                    'caption' => $attach_caption
                  ];
                }
              }
            }
          } else {
            $popupImages[] = [
              'url'     => $popupImage,
              'caption' => ''
            ];
          }

          if ( ! empty( $popupImages ) ) {

            $placeData1 = [ 'test1', 'test1' ];

            $markerDetails['imageTotalNumber'] = count( $popupImages );
            $markerDetails['imageUrl'] = $popupImages['0']['url'];
            $markerDetails['imageCaption'] = $popupImages['0']['caption'];
            $markerDetails['imagePlace'] = get_the_title($mapMarkerId);
            $markerDetails['hasImage'] = true;
          }


          $galleryIsShow = isset( $marker_meta_data->popup_gallery_show ) ? (bool) $marker_meta_data->popup_gallery_show : false;

          if ( $galleryIsShow ) {
            $placeData = [ '', '' ];


            foreach ( $popupImages as $gallery_image_key => $gallery_image ) {
              if ( $gallery_image_key === 0 ) {
                continue;
              }

              $markerDetails['gallery'][] = [
                'url'     => esc_url( $gallery_image['url'] ),
                'caption' => esc_attr( $gallery_image['caption'] ),
                'place'   => esc_attr( implode( ', ', $placeData ) )
              ];
            }


          }
        }

        if ( isset( $marker_meta_data->popup_gallery_show ) ) {
          $markerDetails['hasGallery'] = (bool) $marker_meta_data->popup_gallery_show;
        }


        // Add offset marker after click
        $marker_click_offset = isset( $marker_meta_data->marker_click_offset ) ? $marker_meta_data->marker_click_offset : [
          'top'    => 0,
          'bottom' => 0,
          'left'   => 0,
          'right'  => 0
        ];


        if ( empty( $marker_click_offset['top'] ) && ! is_numeric( $marker_click_offset['top'] ) ) {
          $marker_click_offset['top'] = 0;
        }
        if ( empty( $marker_click_offset['bottom'] ) && ! is_numeric( $marker_click_offset['bottom'] ) ) {
          $marker_click_offset['bottom'] = 0;
        }

        if ( empty( $marker_click_offset['left'] ) && ! is_numeric( $marker_click_offset['left'] ) ) {
          $marker_click_offset['left'] = 0;
        }
        if ( empty( $marker_click_offset['right'] ) && ! is_numeric( $marker_click_offset['right'] ) ) {
          $marker_click_offset['right'] = 0;
        }

        $latlng_1 = isset( $marker_meta_data->marker_latlng[1] ) ? $marker_meta_data->marker_latlng[1] : '0';
        $latlng_0 = isset( $marker_meta_data->marker_latlng[0] ) ? $marker_meta_data->marker_latlng[0] : '0';

        $hideInLocator = isset( $marker_meta_data->marker_hide_in_locator ) ? twerGetNormalMetaCheckboxValue( $marker_meta_data->marker_hide_in_locator ) : 'no';
        $ignoreFilters = isset( $marker_meta_data->marker_ignore_filters ) ? twerGetNormalMetaCheckboxValue( $marker_meta_data->marker_ignore_filters) : 'no';
        $ignoreRadiusFilter = isset( $marker_meta_data->marker_ignore_radius_filter ) ? twerGetNormalMetaCheckboxValue( $marker_meta_data->marker_ignore_radius_filter) : 'no';

        $markersData[] = [
          'type'       => 'Feature',
          'geometry'   => [
            'coordinates' => [ esc_js( $latlng_1 ), esc_js( $latlng_0 ) ]
          ],
          'properties' => wp_parse_args( $markerDetails, [
            'markerId'         => $mapMarkerId,
            'imageUrl'         => '',
            'gallery'          => [],
            'hasImage'         => false,
            'imagePlace'       => '',
            'imageTotalNumber' => 0,
            'hideInLocator' => $hideInLocator,
            'ignoreFilters' => $ignoreFilters,
            'ignoreRadiusFilter' => $ignoreRadiusFilter,
            'hasGallery'       => false,
            'markerClickOffset'        => $marker_click_offset,
            'customFields'     => [
              'popup'                      => $popupCustomFields,
              'locatorPreviewCustomFields' => $locatorPreviewCustomFields,
              'locatorCustomFields'        => $locatorCustomFields
            ],
            'filteredFields' => twerGetFilteredCustomFieldsForMarker($mapMarkerId)
          ] )
        ];

      }
    }


    wp_send_json( $markersData );
  }

  public static function getStoreLocatorMapFilters() {
    $mapId = $_POST['mapId'] ?? 0;
    $filters = [];
    if ( twerStoreLocatorFiltersIsAvailable( $mapId ) ) {
      $filtersIds = explode( ',', twerGetStoreLocatorFiltersForMap( $mapId ) );
      if ( is_array( $filtersIds ) && ! empty( $filtersIds ) ) {
        foreach ( $filtersIds as $filterId ) {
          $filterId = (int) $filterId;


          if($filterId === -1) {
            $filters[] = [
              'name' => esc_html__('Radius', 'treweler'),
              'type' => 'select',
              'key' => 'field-radius',
              'value' => twerGetStoreLocatorRadiusForSelect($mapId),
              'selected' => twerGetDefaultRadiusSize($mapId)
            ];
          } elseif ($filterId === -2) {
            $categoriesRaw = twerGetCategories( $mapId );

            if ( ! empty( $categoriesRaw ) ) {
              $categoriesList = [];
              $selectedCategories = [];
              foreach ( $categoriesRaw as $category ) {
                $categoriesList[] = [
                  'value' => $category->term_id,
                  'label' => $category->name,
                  'slug' => $category->slug,
                  'route' => twerGetRouteInfo( $mapId, $category->term_id )
                ];
                $selectedCategories[] = $category->term_id;
              }

              $filters[] = [
                'name'  => esc_html__( 'Categories', 'treweler' ),
                'type'  => 'categories',
                'key'   => 'field-categories',
                'value' => $categoriesList,
                'selected' => $selectedCategories,
                'ttt' => $categoriesRaw
              ];
            }
          } else {
            $filters[] = twerGetFilterBasedFromCustomField($filterId, $mapId);
          }

        }
      }
    }

    wp_send_json( $filters );
  }

}

TWER_AJAX::init();
