<?php
/**
 * Screen Map
 * Outputs fullscreen map on the page
 *
 * @package Treweler/Classes/Maps
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fullscreen map Class.
 */
class TWER_Screen_Map {

  /**
   * Hook in methods.
   */
  public static function init() {
  }


  public static function template_merge( $marker_data, $template_data ) {

    foreach ( $marker_data as $key => $value ) {
      if ( strpos( $key, '_lock' ) !== false ) {
        if ( $value === 'close' ) {
          if ( $key === 'custom_fields_all_lock' || $key === 'custom_field_add__lock' ) {
            continue;
          }
          $key_value = substr( $key, 0, - 5 );

          switch ( $key_value ) {

            case 'marker_link_url' :
              $marker_data->marker_link['url'] = $template_data->marker_link['url'];
              break;
            case 'marker_link_target' :
              $marker_data->marker_link['target'] = $template_data->marker_link['target'];
              break;


            case 'popup_close_button_show' :
              $marker_data->popup_close_button['show'] = $template_data->popup_close_button['show'];
                break;
            case 'popup_close_button_style' :
              $marker_data->popup_close_button['style'] = $template_data->popup_close_button['style'];
              break;
            case 'label_padding_top' :
              $marker_data->label_padding['top'] = $template_data->label_padding['top'];
              break;
            case 'label_padding_bottom' :
              $marker_data->label_padding['bottom'] = $template_data->label_padding['bottom'];
              break;
            case 'label_padding_left' :
              $marker_data->label_padding['left'] = $template_data->label_padding['left'];
              break;
            case 'label_padding_right' :
              $marker_data->label_padding['right'] = $template_data->label_padding['right'];
              break;
            case 'popup_button_text' :
              $marker_data->popup_button['text'] = $template_data->popup_button['text'];
              break;
            case 'popup_button_url' :
              $marker_data->popup_button['url'] = $template_data->popup_button['url'];
              break;
            case 'popup_button_color' :
              $marker_data->popup_button['color'] = $template_data->popup_button['color'];
              break;
            case 'popup_button_target' :
              $marker_data->popup_button['target'] = $template_data->popup_button['target'];
              break;
            case 'popup_size_height' :
              $marker_data->popup_size['height'] = $template_data->popup_size['height'];
              break;
            case 'popup_size_width' :
              $marker_data->popup_size['width'] = $template_data->popup_size['width'];
              break;
            case 'popup_open_group_open_on' :
              $marker_data->popup_open_group['open_on'] = $template_data->popup_open_group['open_on'];
              break;
            case 'popup_open_group_open_default' :
              $marker_data->popup_open_group['open_default'] = $template_data->popup_open_group['open_default'];
              break;
            case 'marker_click_offset_top' :
              $marker_data->marker_click_offset['top'] = $template_data->marker_click_offset['top'];
                break;
            case 'marker_click_offset_bottom' :
              $marker_data->marker_click_offset['bottom'] = $template_data->marker_click_offset['bottom'];
              break;
            case 'marker_click_offset_left' :
              $marker_data->marker_click_offset['left'] = $template_data->marker_click_offset['left'];
              break;
            case 'marker_click_offset_right' :
              $marker_data->marker_click_offset['right'] = $template_data->marker_click_offset['right'];
              break;
            default :
              //var_dump($marker_data->$key_value, $key_value, $marker_data->marker_click_offset, $template_data->marker_click_offset);
              $marker_data->$key_value = isset( $template_data->$key_value ) ? $template_data->$key_value : '';
              break;
          }
        }
      }
    }

    if ( ! empty( $template_data ) ) {
      foreach ( $template_data as $template_data_key => $template_data_value ) {
        if ( ! isset( $marker_data->$template_data_key ) ) {
          $marker_data->$template_data_key = $template_data_value;
        }
      }
    }

    return $marker_data;
  }


  public static function get_shapes_by_map( $id ) {
    global $post;
    $screen_shapes = [];

    $shapes = get_posts( [
      // basics
      'post_type'      => 'twer-shapes',
      'post_status'    => 'publish',
      'posts_per_page' => '-1',
      // meta query
      'meta_query'     => [
        'relation' => 'OR',
        [
          'key'     => '_treweler_map_id',
          'value'   => $id,
          'compare' => '='
        ],
        [
          'key'     => '_treweler_map_id',
          'value'   => serialize( strval( $id ) ),
          'compare' => 'LIKE'
        ]
      ]
    ] );
    if ( $shapes ) {
      foreach ( $shapes as $post ) {
        setup_postdata( $post );
        $post_id = get_the_ID();
        $shapes = get_post_meta( $post_id, '_treweler_shape_styles', true );
        if ( ! empty( $shapes ) ) {
          $screen_shapes[] = $shapes;
        }
      }
    }
    wp_reset_postdata();

    return $screen_shapes;
  }

  /**
   * Generate JS code for map page
   *
   * @return string
   */
  public static function generate_map_js() {
    $post_id = get_the_ID();


    // Get map ID for single page
    $map_id = get_post_meta( $post_id, '_treweler_cpt_dd_box_fullscreen', true );

    // Get map ID for iframe element
    $iframe_params = [];
    if ( twer_is_map_iframe() ) {
      $map_id = twer_get_iframe_map_id();
      $iframe_params = twer_get_iframe_params();
    }

    $scrollzoom = isset( $iframe_params['scrollzoom'] ) ? $iframe_params['scrollzoom'] : '';
    $lat_init = isset( $iframe_params['lat'] ) ? $iframe_params['lat'] : '';
    $lon_init = isset( $iframe_params['lon'] ) ? $iframe_params['lon'] : '';
    $zoom_init = isset( $iframe_params['zoom'] ) ? $iframe_params['zoom'] : '';


    $meta = get_post_meta( $map_id );
    $markers = self::getMarkersOfMap( $map_id );


    /***
     * $str = '';
     * foreach($markers as $m) {
     * $str .= join(", ", $m['latlng']) . "<br/>";
     * }
     * return $str;
     ***/
    $routes = self::getRoutesOfMap( $map_id );

    $nonce = isset( $meta['_treweler_noncefield'][0] ) ? true : false;
    $newMapSettingsData = isset( $meta['_treweler_map_initial_point'][0] ) ? $meta['_treweler_map_initial_point'][0] : '';
    $newMapSettingsDataZoom = isset( $meta['_treweler_map_zoom_range'][0] ) ? $meta['_treweler_map_zoom_range'][0] : '';

    $newMapSettingsDataInitZoom = isset( $meta['_treweler_map_zoom'][0] ) ? $meta['_treweler_map_zoom'][0] : '';

    $_treweler_map_initial_point = unserialize( $newMapSettingsData );
    $_treweler_map_zoom = unserialize( $newMapSettingsDataZoom );
    $_treweler_map_zoom1 = maybe_unserialize( $newMapSettingsDataInitZoom );

    if ( ! $nonce ) {
      $latlng = unserialize( $meta['_treweler_map_latlng'][0] );
    } else {
      $latlng = [
        $_treweler_map_initial_point['lat'],
        $_treweler_map_initial_point['lon'],
      ];
    }

    if ( is_array( $latlng ) && ! empty( $latlng ) ) {
      foreach ( $latlng as $k => $v ) {
        ${"ll$k"} = $v;
      }
    } else {
      $ll0 = 40.730610;
      $ll1 = - 73.935242;
    }
    $style = $meta['_treweler_map_styles'][0];
    $customStyle = $meta['_treweler_map_custom_style'][0];


	  $mapLightPresetMeta = get_post_meta( $map_id, '_treweler_map_light_preset', true );

	  $map_light_preset = false;
	  if ( $style === twerGetDefaultMapStyle() && trim( $customStyle ) === '' ) {
		  $map_light_preset = empty( $mapLightPresetMeta ) ? 'day' : $mapLightPresetMeta;
	  }


    if ( ! $nonce ) {
      $maxZoom = trim( $meta['_treweler_map_max_zoom'][0] ) != "" ? $meta['_treweler_map_max_zoom'][0] : 24;
      $minZoom = trim( $meta['_treweler_map_min_zoom'][0] ) != "" ? $meta['_treweler_map_min_zoom'][0] : 0;
      $zoom = trim( $meta['_treweler_map_zoom'][0] ) != "" ? $meta['_treweler_map_zoom'][0] : 0;

      if ( is_array( maybe_unserialize( $zoom ) ) ) {
        $zoom = 0;
      }
    } else {
      $maxZoom = is_numeric( $_treweler_map_zoom['max_zoom'] ) ? $_treweler_map_zoom['max_zoom'] : 24;
      $minZoom = is_numeric( $_treweler_map_zoom['min_zoom'] ) ? $_treweler_map_zoom['min_zoom'] : 0;
      if(isset($_treweler_map_zoom1['number'])) {
        $zoom = is_numeric( $_treweler_map_zoom1['number'] ) ? $_treweler_map_zoom1['number'] : 0;
      } else {
        $zoom = $_treweler_map_zoom1 !== '' ? $_treweler_map_zoom1 : 0;
      }
    }


    $iniBearing = $meta['_treweler_camera_initial_bearing'][0] ?? false;
    $iniPitch = $meta['_treweler_camera_initial_pitch'][0] ?? false;
    //$allowPitch   = (bool) $meta['_treweler_camera_pitch'][0] ?? false;
    $allowBearing = (bool) $meta['_treweler_camera_bearing'][0] ?? false;
    $minPitch = $allowBearing ? ( $meta['_treweler_camera_min_pitch'][0] ?? 0 ) : 0;
    $maxPitch = $allowBearing ? ( $meta['_treweler_camera_max_pitch'][0] ?? 85 ) : 85;
    $languanges = $meta['_treweler_map_languanges'][0] ?? 'browser';


    $projectionMeta = isset( $meta['_treweler_map_projection'][0] ) ? $meta['_treweler_map_projection'][0] : '';
    $projection = trim( $projectionMeta ) != "" ? $projectionMeta : 'mercator';


    $meta_data = twer_get_data( $map_id );

    $clusterColor = isset($meta['_treweler_map_cluster_color'][0]) ? $meta['_treweler_map_cluster_color'][0] : '#ac2929';
    $cluster_max_zoom = isset( $meta['_treweler_map_cluster_max_zoom'][0] ) ? $meta['_treweler_map_cluster_max_zoom'][0] : '14';
    if ( ! is_numeric( $cluster_max_zoom ) && empty( $cluster_max_zoom ) ) {
      $cluster_max_zoom = '14';
    }
    $api_key = twer_get_api_key();
    $cluster_features = $route_features = $gpx_data = $init_data = [];

    $tour_offsets = [];
    $tour_offset_top = isset( $meta_data->tour_offset['top'] ) ? $meta_data->tour_offset['top'] : '0';
    if ( ! is_numeric( $tour_offset_top ) && empty( $tour_offset_top ) ) {
      $tour_offset_top = '0';
    }
    $tour_offset_bottom = isset( $meta_data->tour_offset['bottom'] ) ? $meta_data->tour_offset['bottom'] : '0';
    if ( ! is_numeric( $tour_offset_bottom ) && empty( $tour_offset_bottom ) ) {
      $tour_offset_bottom = '0';
    }
    $tour_offset_left = isset( $meta_data->tour_offset['left'] ) ? $meta_data->tour_offset['left'] : '0';
    if ( ! is_numeric( $tour_offset_left ) && empty( $tour_offset_left ) ) {
      $tour_offset_left = '0';
    }
    $tour_offset_right = isset( $meta_data->tour_offset['right'] ) ? $meta_data->tour_offset['right'] : '0';
    if ( ! is_numeric( $tour_offset_right ) && empty( $tour_offset_right ) ) {
      $tour_offset_right = '0';
    }

    $tour_offsets = [ $tour_offset_top, $tour_offset_bottom, $tour_offset_left, $tour_offset_right ];

    $tourNumberStartFrom =  explode('/', get_post_meta( $map_id, '_treweler_tour_numbered_markers_start_from', true ));

    $startFromNumber = reset($tourNumberStartFrom);
    $startFromMarker = isset($tourNumberStartFrom['1']) ? $tourNumberStartFrom['1'] : 1;

    $startFromNumber = empty($startFromNumber) && !is_numeric($startFromNumber) ? 1 : (int) $startFromNumber;
    $startFromMarker = empty($startFromMarker) && !is_numeric($startFromMarker) ? 1 : abs((int) $startFromMarker);


    $mapTourMarkers = [];

    if ( 'yes' === twerGetNormalMetaCheckboxValue( get_post_meta( $map_id, '_treweler_tour_numbered_markers', true ) ) ) {
      $data_map_raw = twer_get_meta( 'tour_marker_repeater', $map_id );
      $data_main = isset( $data_map_raw['main'] ) ? $data_map_raw['main'] : [];

      $data_map = twer_isset( $data_map_raw ) ? $data_main : false;  //$data_map_raw['main'] ?: false arra ;
      if ( ! empty( $data_map ) ) {
        foreach ( $data_map as $data_map_item ) {
            if(--$startFromMarker > 0) {
              continue;
            }

            $mapTourMarkers[ $startFromNumber ] = (int) $data_map_item['tour_marker_id'];
            $startFromNumber ++;

        }
      }
    }


    $script = "!(()=>{window.addEventListener('load',() => {";


    // Fill cluster data
    if ( is_array( $markers ) && ! empty( $markers ) ) {
      foreach ( twerYieldLoop($markers) as $marker ) {

        $marker_meta_data = twer_get_data( $marker['id'] );


        $template_data = [];
        $current_template = isset( $marker_meta_data->templates ) ? $marker_meta_data->templates : 'none';

        if ( 'none' !== $current_template && ! empty( $current_template ) && 'publish' === get_post_status( $current_template ) ) {
          $template_data = self::template_meta_diff( twer_get_data( $current_template ) );

        }

        if ( ! empty( (array) $template_data ) ) {
          $marker_meta_data = self::template_merge( $marker_meta_data, $template_data );
        }

        $marker_category = twer_build_category_classes( $marker['id'] ?? 0 );
        $popup_description = false;

        $open_default = $openby = false;


        // Check marker clustering settings
        $enable_marker_cluster = isset( $marker_meta_data->marker_enable_clustering ) ? $marker_meta_data->marker_enable_clustering : true;
        if ( is_array( $enable_marker_cluster ) ) {
          $enable_marker_cluster = true;
        }
        if ( empty( $enable_marker_cluster ) ) {
          $enable_marker_cluster = false;
        }

        // Check marker click on center settings
        $enable_center_on_click = isset( $marker_meta_data->marker_enable_center_on_click ) ? $marker_meta_data->marker_enable_center_on_click : true;
        if ( is_array( $enable_center_on_click ) ) {
          $enable_center_on_click = true;
        }
        if ( empty( $enable_center_on_click ) ) {
          $enable_center_on_click = false;
        }


        $markerOpenLinkByClick = isset( $marker_meta_data->marker_open_link_by_click ) ? twerGetNormalMetaCheckboxValue($marker_meta_data->marker_open_link_by_click) : 'no';
        $markerLinkUrl = isset( $marker_meta_data->marker_link['url'] ) ? $marker_meta_data->marker_link['url'] : '';
        $markerLinkOpenInNewWindow = isset( $marker_meta_data->marker_link['target'] ) ? twerGetNormalMetaCheckboxValue($marker_meta_data->marker_link['target']) : 'no';

        $markerLink = [
          'enable' => false
        ];
        if ( ! empty( $markerLinkUrl ) && 'yes' === $markerOpenLinkByClick ) {
          $markerLink = [
            'enable' => true,
            'url' => $markerLinkUrl,
            'openInNewWindow' => 'yes' === $markerLinkOpenInNewWindow
          ];
        }

        $marker_hide_in_locator = isset( $marker_meta_data->marker_hide_in_locator ) ? $marker_meta_data->marker_hide_in_locator : false;
        if ( is_array( $marker_hide_in_locator ) ) {
          $marker_hide_in_locator = true;
        }
        if ( empty( $marker_hide_in_locator ) ) {
          $marker_hide_in_locator = false;
        }

        $marker_ignore_filters = isset( $marker_meta_data->marker_ignore_filters ) ? $marker_meta_data->marker_ignore_filters : false;
        if ( is_array( $marker_ignore_filters ) ) {
          $marker_ignore_filters = true;
        }
        if ( empty( $marker_ignore_filters ) ) {
          $marker_ignore_filters = false;
        }


        $marker_ignore_radius_filter = isset( $marker_meta_data->marker_ignore_radius_filter ) ? $marker_meta_data->marker_ignore_radius_filter : false;
        if ( is_array( $marker_ignore_radius_filter ) ) {
          $marker_ignore_radius_filter = true;
        }
        if ( empty( $marker_ignore_radius_filter ) ) {
          $marker_ignore_radius_filter = false;
        }


        // Add offset marker after click
        if( $marker['id'] === 869) {
          //var_dump( $marker_meta_data->marker_click_offset);
        }

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


        // Check marker labels settings
        $marker_label = [];
        $marker_enable_labels = isset( $marker_meta_data->marker_enable_labels ) ? $marker_meta_data->marker_enable_labels : false;
        if ( is_array( $marker_enable_labels ) ) {
          $marker_enable_labels = true;
        }
        if ( empty( $marker_enable_labels ) ) {
          $marker_enable_labels = false;
        }
        if ( $marker_enable_labels ) {
          //ob_start();
          $marker_label['description'] = isset( $marker_meta_data->label_description ) ? nl2br( $marker_meta_data->label_description ) : '';
          $marker_label['position'] = isset( $marker_meta_data->label_position ) ? $marker_meta_data->label_position : 'left';
          $marker_label['font_color'] = isset( $marker_meta_data->label_font_color ) ? $marker_meta_data->label_font_color : '#000';
          $marker_label['font_size'] = isset( $marker_meta_data->label_font_size ) ? $marker_meta_data->label_font_size : '12';
          if ( ! is_numeric( $marker_label['font_size'] ) && empty( $marker_label['font_size'] ) ) {
            $marker_label['font_size'] = '12';
          }


          $label_has_bg = isset( $marker_meta_data->label_has_bg ) ? $marker_meta_data->label_has_bg : true;
          if ( is_array( $label_has_bg ) ) {
            $label_has_bg = true;
          }
          if ( empty( $label_has_bg ) ) {
            $label_has_bg = false;
          }
          //var_dump($marker_meta_data);
          $marker_label['label_has_bg'] = $label_has_bg;
          $label_border_radius = isset( $marker_meta_data->label_border_radius ) ? $marker_meta_data->label_border_radius : '0';

          if ( empty( $label_border_radius ) && ! is_numeric( $label_border_radius ) ) {
            $label_border_radius = 0;
          }
          $marker_label['label_border_radius'] = $label_border_radius;


          $label_padding = isset( $marker_meta_data->label_padding ) ? $marker_meta_data->label_padding : [
            'top'    => 8,
            'bottom' => 6,
            'left'   => 17,
            'right'  => 17
          ];
          if ( empty( $label_padding['top'] ) && ! is_numeric( $label_padding['top'] ) ) {
            $label_padding['top'] = 8;
          }
          if ( empty( $label_padding['bottom'] ) && ! is_numeric( $label_padding['bottom'] ) ) {
            $label_padding['bottom'] = 6;
          }

          if ( empty( $label_padding['left'] ) && ! is_numeric( $label_padding['left'] ) ) {
            $label_padding['left'] = 17;
          }
          if ( empty( $label_padding['right'] ) && ! is_numeric( $label_padding['right'] ) ) {
            $label_padding['right'] = 17;
          }
          $marker_label['label_padding'] = $label_padding;

          $marker_label['font_weight'] = isset( $marker_meta_data->label_font_weight ) ? $marker_meta_data->label_font_weight : '400';
          $marker_label['letter_spacing'] = isset( $marker_meta_data->label_letter_spacing ) ? $marker_meta_data->label_letter_spacing : '0';
          if ( ! is_numeric( $marker_label['letter_spacing'] ) && empty( $marker_label['letter_spacing'] ) ) {
            $marker_label['letter_spacing'] = '0';
          }

          $marker_label['line_height'] = isset( $marker_meta_data->label_line_height ) ? $marker_meta_data->label_line_height : '1.3';
          if ( ! is_numeric( $marker_label['line_height'] ) && empty( $marker_label['line_height'] ) ) {
            $marker_label['line_height'] = '1.3';
          }
          $marker_label['margin'] = isset( $marker_meta_data->label_margin ) ? $marker_meta_data->label_margin : '5';
          if ( ! is_numeric( $marker_label['margin'] ) && empty( $marker_label['margin'] ) ) {
            $marker_label['margin'] = '5';
          }
        }
        // Check if marker hide or not
        $marker_enable = isset( $marker_meta_data->marker_hide ) ? $marker_meta_data->marker_hide : false;
        if ( is_array( $marker_enable ) ) {
          $marker_enable = true;
        }
        if ( empty( $marker_enable ) ) {
          $marker_enable = false;
        }

        // Add popup to marker if it enable
        if ( ! empty( $marker_meta_data->popup_show ) ) {
          ob_start();


          $openby = $marker_meta_data->popup_open_group['open_on'];
          $open_default = (bool) $marker_meta_data->popup_open_group['open_default'];

          $popup_image = '';
          $popup_class = [ 'js-twer-popup twer-popup twer-popup-id-' . $marker['id'] . ' ' . $marker_category ];

          // Handling Marker SVG
          $marker_svg = [
            'pin-light',
            'pin-dark',
            'pin-transparent',
            'pin-semi-dark',
            'pin-solid',
            'ballon-light',
            'ballon-dark',
            'ballon-transparent',
            'ballon-semi-dark',
            'ballon-solid'
          ];

          if ( in_array( $marker_meta_data->marker_style, $marker_svg ) ) {
            $popup_class[] = 'popup-marker-svg';
          }
          $popup_head = isset( $marker_meta_data->popup_heading ) ? trim( $marker_meta_data->popup_heading ) : '';
          $popup_subhead = isset( $marker_meta_data->popup_subheading ) ? trim( $marker_meta_data->popup_subheading ) : '';

          if ( $marker_meta_data->popup_image ) {

            $image_width = '';
            if ( 'right' === $marker_meta_data->popup_image_position && is_numeric( $marker_meta_data->popup_image_width ) ) {
              $image_width = 'style="width:' . $marker_meta_data->popup_image_width . 'px"';
            }

            $gallery_indicate = '';
            $popup_handler_start_tag = '<div class="twer-popup__image">';
            $popup_handler_end_tag = '</div>';
            $popup_image_val = isset( $marker_meta_data->popup_image ) ? $marker_meta_data->popup_image : '';
            $gallery_images = [];


            $place_data = [];

            if ( ! empty( $popup_head ) ) {
              $place_data[] = $popup_head;
            }
            if ( ! empty( $popup_subhead ) ) {
              $place_data[] = $popup_subhead;
            }

            if ( ! filter_var( $popup_image_val, FILTER_VALIDATE_URL ) ) {
              $popup_image_val = explode( ',', $popup_image_val );

              if ( ! empty( $popup_image_val ) && is_array( $popup_image_val ) ) {


                foreach ( $popup_image_val as $popup_image_value ) {
                  $attach_url = wp_get_attachment_image_url( $popup_image_value, 'full' );
                  $attach_caption = wp_get_attachment_caption( $popup_image_value );
                  if ( ! empty( $attach_url ) ) {
                    $gallery_images[] = [
                      'url'     => $attach_url,
                      'caption' => $attach_caption
                    ];
                  }
                }

//                if ( ! empty( $marker_meta_data->popup_gallery_show ) ) {
//                  $gallery_indicate = '<div class="twer-popup__indicate">' . count( $gallery_images ) . '</div>';
//                  $popup_handler_start_tag = '<a href="' . esc_url( $gallery_images[0]['url'] ) . '" data-caption="' . esc_attr( $gallery_images[0]['caption'] ) . '" data-place="' . esc_attr( implode( ', ', $place_data ) ) . '" data-fancybox="gallery-' . $marker['id'] . '" class="twer-popup__image twer-popup__image-link" title="">';
//                  $popup_handler_end_tag = '</a>';
//                }


              }
            } else {
              $gallery_images[] = [
                'url'     => $popup_image_val,
                'caption' => ''
              ];
            }


            $gallery_images_html = '';
//            if ( count( $gallery_images ) > 1 && ! empty( $marker_meta_data->popup_gallery_show ) ) {
//              foreach ( $gallery_images as $gallery_image_key => $gallery_image ) {
//                if ( $gallery_image_key === 0 ) {
//                  continue;
//                }
//
//                $gallery_images_html .= '<a href="' . esc_url( $gallery_image['url'] ) . '" data-caption="' . esc_attr( $gallery_image['caption'] ) . '" data-fancybox="gallery-' . $marker['id'] . '" class="twer-popup__thumb-gallery" title=""><img src="' . esc_url( $gallery_image['url'] ) . '"  alt="' . esc_attr( $gallery_image['caption'] ) . '"></a>';
//              }
//            }


            $popup_image = sprintf( '<div class="twer-popup__col twer-popup__col--image" %s>' . $popup_handler_start_tag . '<img src="%s" alt="%s">%s' . $popup_handler_end_tag . '%s</div>',
              $image_width,
              esc_url( $gallery_images[0]['url'] ),
              esc_attr( $gallery_images[0]['caption'] ),
              $gallery_indicate,
              $gallery_images_html
            );
            $popup_class[] = 'twer-popup--image-yes';
            $popup_class[] = 'twer-popup--image-align-' . $marker_meta_data->popup_image_position;
          } else {
            $popup_class[] = 'twer-popup--image-no';
          }
          $popup_class[] = 'twer-popup--style-' . $marker_meta_data->popup_style;
          $popup_class[] = 'twer-popup--align-' . $marker_meta_data->popup_content_align;


          $cf_show = '';
          $cf_list = [];

          $once_publish = false;
          $once_filled = false;
          $cf_show_name_flag = false;
          if ( ! empty( $cf_list ) ) {
            foreach ( $cf_list as $cf_prepare ) {
              $cf_meta_prepare = twer_get_data( $cf_prepare );
              $cf_show_name = isset( $cf_meta_prepare->custom_field_show ) ? $cf_meta_prepare->custom_field_show : '';
              $cf_key = isset( $cf_meta_prepare->custom_field_key ) ? $cf_meta_prepare->custom_field_key : 'field-1488228';
              $cf_default = isset( $cf_meta_prepare->{$cf_key} ) ? $cf_meta_prepare->{$cf_key} : '';

              $custom_field = isset( $marker_meta_data->{$cf_key} ) ? $marker_meta_data->{$cf_key} : '';
              $custom_field_lock = isset( $marker_meta_data->{$cf_key . '_lock'} ) ? $marker_meta_data->{$cf_key . '_lock'} : 'close';

              if ( 'close' === $custom_field_lock ) {
                $custom_field = $cf_default;
              }


              if ( ! empty( $cf_show_name ) ) {
                $cf_show_name_flag = true;
              }

              if ( ! empty( (array) $cf_meta_prepare ) ) {
                $once_publish = true;
              }

              $filled = '';
              if ( ! empty( $custom_field ) ) {
                if ( is_array( $custom_field ) ) {
                  $filled .= twer_implode_r( '', $custom_field );
                } else {
                  $filled .= $custom_field;
                }

                if ( ! empty( $filled ) ) {
                  $once_filled = true;
                }
              }
            }
          }

          $popup_class[] = 'twer-popup--custom-fields-no';

          $popupHeading = !empty($marker_meta_data->popup_heading) ? $marker_meta_data->popup_heading : get_the_title( $marker['id']);

          $popup_class[] = !empty($popupHeading) ? 'twer-popup--heading-yes' : 'twer-popup--heading-no';
          $popup_class[] = !empty($marker_meta_data->popup_subheading) ? 'twer-popup--subheading-yes' : 'twer-popup--subheading-no';
          $popup_class[] = !empty($marker_meta_data->popup_description) ? 'twer-popup--description-yes' : 'twer-popup--description-no';
          $popup_class[] = !empty($marker_meta_data->popup_button) && !empty($marker_meta_data->popup_button['text']) ? 'twer-popup--button-yes' : 'twer-popup--button-no';
          $popup_class[] = 'twer-popup--openby-' . $marker_meta_data->popup_open_group['open_on'];
          if ( $open_default ) {
            $popup_class[] = 'twer-popup--open-default';
          }


          $popup_min_height = isset( $marker_meta_data->popup_size['height'] ) ? $marker_meta_data->popup_size['height'] : '';
          $popup_min_width = isset( $marker_meta_data->popup_size['width'] ) ? $marker_meta_data->popup_size['width'] : '';
          $popup_size = '';
          $popup_size_alternate = '';

          if ( ! empty( $popup_min_height ) ) {
            $popup_size .= 'min-height:' . $popup_min_height . 'px;';
          }

          if ( ! empty( $popup_min_width ) ) {
            if ( ( empty( $popup_image ) && $marker_meta_data->popup_image_position === 'right' ) || $marker_meta_data->popup_image_position === 'top' ) {
              $popup_size_alternate .= $popup_min_width;
            } else {
              $popup_size .= 'min-width:' . $popup_min_width . 'px;';
            }
          }

          if ( ! empty( $popup_size ) ) {
            $popup_size = 'style="' . $popup_size . '"';
          }


          $popup_border_radius = isset( $marker_meta_data->popup_border_radius ) ? $marker_meta_data->popup_border_radius : '6';
          if ( ! is_numeric( $popup_border_radius ) && empty( $popup_border_radius ) ) {
            $popup_border_radius = '0';
          }



          $showCloseIcon = isset( $marker_meta_data->popup_close_button['show'] ) ? twerGetNormalMetaCheckboxValue($marker_meta_data->popup_close_button['show']) : 'no';
          $closeIconStyle = isset( $marker_meta_data->popup_close_button['style'] ) ? $marker_meta_data->popup_close_button['style'] : 'dark';


          $closeIconHTML = '';

          if('yes' === $showCloseIcon && $openby !== 'always_open' ) {
            $closeIconHTML = '<button type="button" class="btn js-twer-close-popup-btn twer-close-popup-btn twer-close-popup-btn--'.$closeIconStyle.'"><svg class="twer-svg-icon" width="10" height="10"><use xlink:href="#close"></use></svg></button>';
          }


          /*  Style settings for popup heading */
          $popup_heading_size = isset( $marker_meta_data->popup_heading_size ) ? $marker_meta_data->popup_heading_size : '16';
          if ( ! is_numeric( $popup_heading_size ) && empty( $popup_heading_size ) ) {
            $popup_heading_size = '16';
          }

          $popup_heading_font_weight = isset( $marker_meta_data->popup_heading_font_weight ) ? $marker_meta_data->popup_heading_font_weight : '700';
          if ( ! is_numeric( $popup_heading_font_weight ) && empty( $popup_heading_font_weight ) ) {
            $popup_heading_font_weight = '400';
          }

          $style_heading = 'style="font-size:' . $popup_heading_size . 'px;font-weight:' . $popup_heading_font_weight . ';"';


          /*  Style settings for popup subheading */
          $popup_subheading_size = isset( $marker_meta_data->popup_subheading_size ) ? $marker_meta_data->popup_subheading_size : '13';
          if ( ! is_numeric( $popup_subheading_size ) && empty( $popup_subheading_size ) ) {
            $popup_subheading_size = '13';
          }

          $popup_subheading_font_weight = isset( $marker_meta_data->popup_subheading_font_weight ) ? $marker_meta_data->popup_subheading_font_weight : '600';
          if ( ! is_numeric( $popup_subheading_font_weight ) && empty( $popup_subheading_font_weight ) ) {
            $popup_subheading_font_weight = '400';
          }

          $style_subheading = 'style="font-size:' . $popup_subheading_size . 'px;font-weight:' . $popup_subheading_font_weight . ';"';


          /*  Style settings for popup description */
          $popup_description_size = isset( $marker_meta_data->popup_description_size ) ? $marker_meta_data->popup_description_size : '14';
          if ( ! is_numeric( $popup_description_size ) && empty( $popup_description_size ) ) {
            $popup_description_size = '13';
          }

          $popup_description_font_weight = isset( $marker_meta_data->popup_description_font_weight ) ? $marker_meta_data->popup_description_font_weight : '400';
          if ( ! is_numeric( $popup_description_font_weight ) && empty( $popup_description_font_weight ) ) {
            $popup_description_font_weight = '400';
          }

          $style_description = 'style="font-size:' . $popup_description_size . 'px;font-weight:' . $popup_description_font_weight . ';"';




          ?>
            <div class="twer-popup__wrap js-twer-popup__wrap"
                 data-idpopup="<?php echo esc_attr( $marker['id'] ); ?>"
                 data-class="<?php echo esc_attr( implode( ' ', $popup_class ) ); ?>"
                 data-borderradius="<?php echo esc_attr( $popup_border_radius ); ?>"
                 data-minwidthalternate="<?php echo esc_attr( $popup_size_alternate ); ?>"
            >
                <?php echo $closeIconHTML; ?>
                <div class="twer-popup__body">
                    <div class="twer-popup__row">
                      <?php echo $popup_image && 'top' === $marker_meta_data->popup_image_position ? $popup_image : ''; ?>
                        <div class="twer-popup__col twer-popup__col--description" <?php echo $popup_size; ?>>
                            <div class="twer-popup-inner">
                              <?php if ( $popup_head ) { ?>
                                  <div class="twer-popup__title" <?php echo $style_heading; ?>><?php echo esc_html( trim( $popup_head ) ); ?></div>
                              <?php } ?>
                              <?php if ( !empty( $marker_meta_data->popup_subheading) ) { ?>
                                  <div class="twer-popup__subtitle" <?php echo $style_subheading; ?>><?php echo esc_html( trim( $marker_meta_data->popup_subheading ) ); ?></div>
                              <?php } ?>

                              <?php if (  !empty( $marker_meta_data->popup_description ) ) { ?>
                                  <div class="twer-popup__description" <?php echo $style_description; ?>><?php echo wpautop( $marker_meta_data->popup_description ); ?></div>
                              <?php } ?>
                              <?php if ( !empty($marker_meta_data->popup_button) &&  !empty($marker_meta_data->popup_button['text']) ) {

                                $popup_btn_target = ! empty( $marker_meta_data->popup_button['target'] ) ? 'target="_blank"' : 'target="_parent"';
                                $popup_btn_style = ! empty( $marker_meta_data->popup_button['color'] ) ? 'style="background-color:' . $marker_meta_data->popup_button['color'] . ';"' : '';
                                $popup_btn_url = ! empty( $marker_meta_data->popup_button['url'] ) ? $marker_meta_data->popup_button['url'] : '#';

                                $mask_url = "'" . esc_url( $popup_btn_url ) . "'";
                                $popup_js_button = ! empty( $marker_meta_data->popup_button['target'] ) ? "onclick='console.log(" . $mask_url . ");window.open(" . $mask_url . ",'_blank')'" : "onclick='console.log(" . $mask_url . ");window.open(" . $mask_url . ",'_parent')'";

                                echo sprintf( '<div class="twer-popup__button-wrap"><a href="%1$s" class="twer-popup__button" tabindex="-1" title="%2$s" %3$s %4$s>%2$s</a></div>',
                                  esc_url( $popup_btn_url ),
                                  esc_attr( trim( $marker_meta_data->popup_button['text'] ) ),
                                  $popup_btn_target,
                                  $popup_btn_style
                                );


//											echo sprintf( '<div class="twer-popup__button-wrap"><button type="button" data-href="%1$s" class="twer-popup__button" title="%2$s" %3$s %4$s>%2$s</button></div>',
//												esc_url( $popup_btn_url ),
//												esc_attr( trim( $marker_meta_data->popup_button['text'] ) ),
//												$popup_js_button,
//												$popup_btn_style
//											);

                              } ?>
                            </div>
                        </div>
                      <?php echo $popup_image && 'right' === $marker_meta_data->popup_image_position ? $popup_image : ''; ?>
                    </div>
                </div>
            </div>
          <?php


          $popup_description = twer_fix_html_markup( twer_minify_html_markup( ob_get_clean() ) );
        }


        $intMarker = (int) $marker['id'];
        $popupCustomFields = twerGetCustomFieldsForMarker( $intMarker );
        $locatorPreviewCustomFields = twerGetCustomFieldsForMarker( $intMarker, 'locator_preview' );
        $locatorCustomFields = twerGetCustomFieldsForMarker( $intMarker, 'locator' );


        $markerIntId = (int) $marker['id'];
        $tourIndexNumber = '';
        if ( in_array( $markerIntId, $mapTourMarkers, true ) ) {
          $tourIndexNumber = array_search( $markerIntId, $mapTourMarkers, true );
        }


        if ( $marker['style'] !== 'custom' ) {

          $latlng_1 = isset( $marker['latlng'][1] ) ? $marker['latlng'][1] : '0';
          $latlng_0 = isset( $marker['latlng'][0] ) ? $marker['latlng'][0] : '0';
          $cluster_features[] = [
            'type'       => 'Feature',
            'geometry'   => [
              'type'        => 'Point',
              'coordinates' => [ esc_js( $latlng_1 ), esc_js( $latlng_0 ) ]
            ],
            'properties' => [
              'id'                  => esc_js( $marker['id'] ),
              'color'               => esc_js( $marker['color'] ),
              'type'                => esc_js( $marker['style'] ),
              'halo_color'          => esc_js( $marker['halo_color'] ),
              'halo_opacity'        => esc_js( $marker['halo_opacity'] ),
              'inner_size'          => esc_js( $marker['inner_size'] ),
              'dotcenter_color'     => esc_js( $marker['dotcenter_color'] ),
              'border_color'        => esc_js( $marker['border_color'] ),
              'border_width'        => esc_js( $marker['border_width'] ),
              'corner_radius'       => esc_js( $marker['corner_radius'] ),
              'corner_radius_units' => esc_js( $marker['corner_radius_units'] ),
              'color_balloon'        => esc_js( $marker['color_balloon'] ),
              'size_balloon'         => esc_js( $marker['size_balloon'] ),
              'border_color_balloon' => esc_js( $marker['border_color_balloon'] ),
              'border_width_balloon' => esc_js( $marker['border_width_balloon'] ),
              'dot_color'            => esc_js( $marker['dot_color'] ),
              'dot_size'             => esc_js( $marker['dot_size'] ),

              'tourIndexNumber' => $tourIndexNumber,

              'color_triangle'  => esc_js( $marker['color_triangle'] ),
              'height_triangle' => esc_js( $marker['height_triangle'] ),
              'width_triangle'  => esc_js( $marker['width_triangle'] ),


              'balloon_icon_size'  => esc_js( $marker['balloon_icon_size'] ),
              'balloon_icon_color' => esc_js( $marker['balloon_icon_color'] ),
              'balloon_icon'       => esc_js( $marker['balloon_icon'] ),
              'balloon_icon_show'  => esc_js( $marker['balloon_icon_show'] ),

              'dot_icon_size'  => esc_js( $marker['dot_icon_size'] ),
              'dot_icon_color' => esc_js( $marker['dot_icon_color'] ),
              'dot_icon'       => esc_js( $marker['dot_icon'] ),
              'dot_icon_show'  => esc_js( $marker['dot_icon_show'] ),

              'description'              => $popup_description,
              'openby'                   => $openby,
              'cursor'                   => 'pointer',
              'allowMarkerCluster'       => $enable_marker_cluster,
              'allowMarkerCenterOnClick' => $enable_center_on_click,
              'markerLink' => $markerLink,
              'hideInLocator' => $marker_hide_in_locator,
              'ignoreFilters' => $marker_ignore_filters,
              'ignoreRadiusFilter' => $marker_ignore_radius_filter,
              'markerClickOffset'        => $marker_click_offset,
              'openDefault'              => $open_default,
              'category'                 => esc_js( twer_build_category_classes( $marker['id'] ?? 0, 'id', ' ' ) ),
              'cat_ids'                  => esc_js( twer_get_categories_ids( $marker['id'] ?? 0 ) ),
              'markerLabelEnable'        => $marker_enable_labels,
              'label'                    => $marker_label,
              'markerHide'               => $marker_enable,
              'customFields'     => [
                'popup'                      => $popupCustomFields,
                'locatorPreviewCustomFields' => $locatorPreviewCustomFields,
                'locatorCustomFields'        => $locatorCustomFields
              ],
              'filteredFields' => twerGetFilteredCustomFieldsForMarker( $marker['id'])
            ]
          ];


        } else {
          $cluster_features[] = [
            'type'       => 'Feature',
            'geometry'   => [
              'type'        => 'Point',
              'coordinates' => [ esc_js( $marker['latlng'][1] ), esc_js( $marker['latlng'][0] ) ]
            ],
            'properties' => [
              'id'                       => esc_js( $marker['id'] ),
              'icon'                     => esc_js( $marker['icon'] ),
              'cursor'                   => ! empty( $marker['cursor'] ) ? esc_js( $marker['cursor'] ) : 'pointer',
              'anchor'                   => esc_js( $marker['anchor'] ),
              'size'                     => esc_js( $marker['size'] ),
              'markerSize'               => esc_js( $marker['markerSize'] ),
              'type'                     => 'custom',
              'tourIndexNumber' => $tourIndexNumber,
              'description'              => $popup_description,
              'openby'                   => $openby,
              'allowMarkerCluster'       => $enable_marker_cluster,
              'allowMarkerCenterOnClick' => $enable_center_on_click,
              'markerLink' => $markerLink,
              'hideInLocator' => $marker_hide_in_locator,
              'ignoreFilters' => $marker_ignore_filters,
              'ignoreRadiusFilter' => $marker_ignore_radius_filter,
              'markerClickOffset'        => $marker_click_offset,
              'openDefault'              => $open_default,
              'category'                 => esc_js( twer_build_category_classes( $marker['id'] ?? 0, 'id', ' ' ) ),
              'cat_ids'                  => esc_js( twer_get_categories_ids( $marker['id'] ?? 0 ) ),
              'markerLabelEnable'        => $marker_enable_labels,
              'label'                    => $marker_label,
              'markerHide'               => $marker_enable,
              'customFields'     => [
                'popup'                      => $popupCustomFields,
                'locatorPreviewCustomFields' => $locatorPreviewCustomFields,
                'locatorCustomFields'        => $locatorCustomFields
              ],
              'filteredFields' => twerGetFilteredCustomFieldsForMarker( $marker['id']),
            ]
          ];
        }
      }
    }

    // Fill route data
    if ( is_array( $routes ) && ! empty( $routes ) ) {
      foreach ( twerYieldLoop($routes) as $route ) {

        $route_id = isset( $route['id'] ) ? $route['id'] : 0;
        $route_line_dash = isset( $route['routeLineDash'] ) && is_numeric( $route['routeLineDash'] ) ? (float) $route['routeLineDash'] : 1;
        $route_line_gap = isset( $route['routeLineGap'] ) && is_numeric( $route['routeLineGap'] ) ? (float) $route['routeLineGap'] : 1;
        $dynamic_route_data = [
          'line-dasharray' => [
            $route_line_dash,
            $route_line_gap
          ]
        ];

        if ( $route['routeProfile'] != 'no' && trim( $route['routeGPX'] ) == '' && ! empty( $route['routeCoords'] && ! empty( $route['routeProfile'] ) ) ) {


          $url_route = 'https://api.mapbox.com/directions/v5/mapbox/' . $route['routeProfile'] . '/' . $route['routeCoords'] . '?geometries=geojson&overview=full&access_token=' . $api_key;

          $route_features[] = [
            'type'       => 'Feature',
            'geometry'   => [
              'type'        => 'LineString',
              'coordinates' => []
            ],
            'properties' => [
              'route_load'     => 'dynamic',
              'route_id'       => esc_js( $route['id'] ),
              'route_url'      => esc_url( $url_route ),
              'line-color'     => esc_js( $route['routeColor'] ),
              'line-width'     => esc_js( $route['routeLineWidth'] ),
              'line-opacity'   => esc_js( $route['routeLineOpacity'] ),
              'line-dasharray' => [ esc_js( $route['routeLineDash'] ), esc_js( $route['routeLineGap'] ) ],
              'category'       => esc_js( twer_build_category_classes( isset( $marker['id'] ) ?? 0, 'id',
                ' ' ) )
            ]
          ];

          $gpx_data[] = [
            'route_id'     => $route_id,
            'route_source' => $url_route,
            'route_data'   => $dynamic_route_data
          ];
        } else {
          if ( trim( $route['routeGPX'] ) == '' ) {

            $fs_coords = [];
            $coords_str = explode( ";", $route['routeCoords'] );
            foreach ( $coords_str as $lls ) {
              $ll = explode( ",", $lls );
              $llA = [];
              foreach ( $ll as $l ) {
                if ( $l ) {
                  $llA[] = floatval( $l );
                }
              }
              if ( $llA ) {
                $fs_coords[] = $llA;
              }
            }

            if ( $fs_coords ) {

              $route_features[] = [
                'type'       => 'Feature',
                'geometry'   => [
                  'type'        => 'LineString',
                  'coordinates' => $fs_coords
                ],
                'properties' => [
                  'route_load'     => 'static',
                  'route_id'       => esc_js( $route['id'] ),
                  'line-color'     => esc_js( $route['routeColor'] ),
                  'line-width'     => esc_js( $route['routeLineWidth'] ),
                  'line-opacity'   => esc_js( $route['routeLineOpacity'] ),
                  'line-dasharray' => [
                    esc_js( $route['routeLineDash'] ),
                    esc_js( $route['routeLineGap'] )
                  ],
                  'ld1'            => 1,
                  'ld2'            => 2,
                  'category'       => esc_js( twer_build_category_classes( $marker['id'] ?? 0, 'id',
                    ' ' ) )
                ]
              ];

            }

          } else {

            $route_features[] = [
              'type'       => 'Feature',
              'geometry'   => [
                'type'        => 'LineString',
                'coordinates' => []
              ],
              'properties' => [
                'route_load'     => 'dynamic',
                'route_id'       => esc_js( $route['id'] ),
                'route_url'      => esc_url( $route['routeGPX'] ),
                'line-color'     => esc_js( $route['routeColor'] ),
                'line-width'     => esc_js( $route['routeLineWidth'] ),
                'line-opacity'   => esc_js( $route['routeLineOpacity'] ),
                'line-dasharray' => [
                  esc_js( $route['routeLineDash'] ),
                  esc_js( $route['routeLineGap'] )
                ]
              ]
            ];

            $gpx_data[] = [
              'route_id'     => $route_id,
              'route_source' => $route['routeGPX'],
              'route_data'   => $dynamic_route_data
            ];

          }
        }
      }
    }

    // Declare cluster JS data
    $cluster_features = apply_filters('twer_markers_data_output', $cluster_features);
    if ( $cluster_features ) {
      $script .= 'TWER.clusterData = ' . wp_json_encode( [
          'type'     => 'FeatureCollection',
          'features' => $cluster_features
        ], JSON_NUMERIC_CHECK ) . ';';
    }

    // Declare route JS data
	  $route_features = apply_filters('twer_routes_data_output', $route_features);
    if ( $route_features ) {
      $script .= 'TWER.routeData = ' . wp_json_encode( [
          'type'     => 'FeatureCollection',
          'features' => $route_features
        ], JSON_NUMERIC_CHECK ) . ';';
    }

    $distance_scale = false;
    $distance_scale_position = 'bottom-right';
    $distance_scale_unit = 'imperial';
    if ( isset( $meta_data->map_controls['distance_scale'] ) ) {
      $distance_scale = in_array( 'distance_scale', (array) $meta_data->map_controls['distance_scale'] ) ? true : false;
    }
    if ( isset( $meta_data->map_controls['distance_position'] ) ) {
      $distance_scale_position = $meta_data->map_controls['distance_position'];
    }
    if ( isset( $meta_data->map_controls['distance_unit'] ) ) {
      $distance_scale_unit = $meta_data->map_controls['distance_unit'];
    }


    $allLayers = [ 'boundaries', 'showPlaceLabels', 'showPointOfInterestLabels', 'natural_features', 'showTransitLabels', 'transit', 'building_labels', 'buildings', 'pedestrian_labels', 'pedestrian_roads', 'showRoadLabels', 'roads', 'contour_lines', 'hillshade', 'land_structure', 'water_depth' ];
    $layers = isset( $meta_data->map_layers ) ? $meta_data->map_layers : [
      'boundaries' => 'boundaries',
      'place_labels' => 'place_labels',
      'points_of_interest' => 'points_of_interest',
      'natural_features' => 'natural_features',
      'transit_labels' => 'transit_labels',
      'transit' => 'transit',
      'building_labels' => 'building_labels',
      'buildings' => 'buildings',
      'pedestrian_labels' => 'pedestrian_labels',
      'pedestrian_roads' => 'pedestrian_roads',
      'road_labels' => 'road_labels',
      'roads' => 'roads',
      'contour_lines' => 'contour_lines',
      'hillshade' => 'hillshade',
      'land_structure' => 'land_structure',
      'water_depth' => 'water_depth'
    ];


    $filteredLayers = array_keys(array_filter($layers, static function($value) {
      return is_array($value) ? !empty($value) : !empty(trim($value));
    }));
    $mapLayers = array_map( static function($key) {
      switch ($key) {
        case 'place_labels':
          return 'showPlaceLabels';
        case 'road_labels':
          return 'showRoadLabels';
        case 'points_of_interest':
          return 'showPointOfInterestLabels';
        case 'transit_labels':
          return 'showTransitLabels';
        default:
          return $key;
      }
    }, $filteredLayers);


    $fullscreen = false;
    $fullscreen_position = 'top-right';
    if ( isset( $meta_data->map_controls['fullscreen'] ) ) {
      $fullscreen = in_array( 'fullscreen', (array) $meta_data->map_controls['fullscreen'] ) ? true : false;
    }
    if ( isset( $meta_data->map_controls['fullscreen_position'] ) ) {
      $fullscreen_position = $meta_data->map_controls['fullscreen_position'];
    }


    $search = false;
    $search_position = 'top-left';
    if ( isset( $meta_data->map_controls['search'] ) ) {
      $search = in_array( 'search', (array) $meta_data->map_controls['search'] ) ? true : false;
    }
    if ( isset( $meta_data->map_controls['search_position'] ) ) {
      $search_position = $meta_data->map_controls['search_position'];
    }


    $zoom_pan = false;
    $zoom_pan_position = 'top-left';
    if ( isset( $meta_data->map_controls['zoom_pan'] ) ) {
      $zoom_pan = in_array( 'zoom_pan', (array) $meta_data->map_controls['zoom_pan'] ) ? true : false;
    }
    if ( isset( $meta_data->map_controls['zoom_pan_position'] ) ) {
      $zoom_pan_position = $meta_data->map_controls['zoom_pan_position'];
    }


    $geolocate = false;
    $geolocate_position = 'top-right';
	  $geolocate_style = 'mapbox-style';
    if ( isset( $meta_data->map_controls['geolocate'] ) ) {
      $geolocate = in_array( 'geolocate', (array) $meta_data->map_controls['geolocate'] ) ? true : false;
    }
    if ( isset( $meta_data->map_controls['geolocate_position'] ) ) {
      $geolocate_position = $meta_data->map_controls['geolocate_position'];
    }

	  if ( isset( $meta_data->map_controls['geolocate_style'] ) ) {
		  $geolocate_style = $meta_data->map_controls['geolocate_style'];
	  }


    if ( ! $nonce ) {
      $user_geolocation = isset( $meta_data->map_geoposition ) ? (bool) $meta_data->map_geoposition : false;
    } else {
      $user_geolocation_Checkbox = isset( $_treweler_map_initial_point['geoposition'] ) ? $_treweler_map_initial_point['geoposition'] : false;
      if ( is_array( $user_geolocation_Checkbox ) ) {
        $user_geolocation_Checkbox = reset( $user_geolocation_Checkbox );
      }
      $user_geolocation = empty( $user_geolocation_Checkbox ) ? false : true;
    }

    $centeredMapOnLoadUserGeolocation = isset( $meta_data->map_center_geolocation_on_load ) ? (bool) $meta_data->map_center_geolocation_on_load : true;

    $userLocationMarkerTemplateMetaValue = isset( $meta_data->map_user_location_marker_template ) ? $meta_data->map_user_location_marker_template : 'none';
    $userLocationMarkerTemplate = 'none';

    switch ($userLocationMarkerTemplateMetaValue) {
      case 'none' :
        $userLocationMarkerTemplate = false;
          break;
      case 'default' :
        $userLocationMarkerTemplate = 'default';
          break;
      default:
        $userLocationMarkerTemplate = wp_json_encode( twer_get_marker_styles( (int) $userLocationMarkerTemplateMetaValue ), JSON_NUMERIC_CHECK );
    }

    $store_locator = isset( $meta_data->store_locator ) ? (bool) $meta_data->store_locator : false;

	  $store_locator_close = isset( $meta_data->store_locator_close ) ? (bool) $meta_data->store_locator_close : false;

    $store_locator_type = isset( $meta_data->store_locator_type ) ? $meta_data->store_locator_type : 'extended';
    $store_locator_sidebar_open_button_position = isset( $meta_data->store_locator_sidebar_open_button_position ) ? $meta_data->store_locator_sidebar_open_button_position : 'middle';

	  $store_locator_sidebar_position = isset( $meta_data->store_locator_sidebar_position ) ? $meta_data->store_locator_sidebar_position : 'left';


    $store_locator_card_fields_main_value = '';
    $store_locator_marker_fields_main_value = '';

    $store_locator_marker_click_event = isset( $meta_data->store_locator_marker_click_event ) ? $meta_data->store_locator_marker_click_event : 'marker_details';
    $store_locator_card_click_event = isset( $meta_data->store_locator_card_click_event ) ? $meta_data->store_locator_card_click_event : 'marker_details';
    $store_locator_zoom_on_click = isset( $meta_data->store_locator_zoom_on_click ) ? $meta_data->store_locator_zoom_on_click : '';


    $map_location_marker = true;
    if ( isset( $meta_data->map_location_marker['show'] ) ) {
      $map_location_marker = in_array( 'show', (array) $meta_data->map_location_marker['show'] ) ? true : false;
    }


    $map_location_marker_template = isset( $meta_data->map_location_marker['template'] ) ? $meta_data->map_location_marker['template'] : 'none';
    $map_location_marker_template = 'none' !== $map_location_marker_template ? wp_json_encode( twer_get_marker_styles( (int) $map_location_marker_template ), JSON_NUMERIC_CHECK ) : false;

    $map_center_on_click = isset( $meta_data->map_center_on_click ) ? (bool) $meta_data->map_center_on_click : true;
    $store_locator_search = isset( $meta_data->store_locator_search ) ? (bool) $meta_data->store_locator_search : true;
    $store_locator_geolocation = isset( $meta_data->store_locator_geolocation ) ? (bool) $meta_data->store_locator_geolocation : true;
    $store_locator_search_and_geolocation = isset( $meta_data->store_locator_search_and_geolocation ) ? (bool) $meta_data->store_locator_search_and_geolocation : true;

    $store_locator_filters = isset( $meta_data->store_locator_filters ) ?  $meta_data->store_locator_filters : true;

    if($store_locator_filters === 'yes') {
      $store_locator_filters = true;
    } else if($store_locator_filters === 'no') {
      $store_locator_filters = false;
    }

    $store_locator_controls_position = isset( $meta_data->store_locator_positions ) ? $meta_data->store_locator_positions : 'top_right';

    $store_locator_radius = false;
    if ( isset( $meta_data->store_locator_radius['show'] ) ) {
      $store_locator_radius = in_array( 'show', (array) $meta_data->store_locator_radius['show'] ) ? true : false;
    }

    $store_locator_radius_size = isset( $meta_data->store_locator_radius['size'] ) ? $meta_data->store_locator_radius['size'] : [];
    $store_locator_radius_distance = isset( $meta_data->store_locator_radius['distance'] ) ? $meta_data->store_locator_radius['distance'] : '';
    $store_locator_radius_default = isset( $meta_data->store_locator_radius_default ) ? $meta_data->store_locator_radius_default : '';


    $store_locator_radius_size = ! empty( $store_locator_radius_size ) ? wp_json_encode( $store_locator_radius_size ) : wp_json_encode( [ $store_locator_radius_default ] );


    $bg_overlay = isset( $meta_data->bg_overlay ) ? $meta_data->bg_overlay : 'rgba(255,255,255,0)';
    if ( ! $nonce ) {
      $world_copy = isset( $meta_data->world_copy ) ? (bool) $meta_data->world_copy : true;
    } else {
      $world_copyCheckbox = isset( $meta_data->world_copy ) ? $meta_data->world_copy : true;


      if ( is_array( $world_copyCheckbox ) ) {
        $world_copyCheckbox = reset( $world_copyCheckbox );
      }
      $world_copy = empty( $world_copyCheckbox ) ? false : true;
    }

    $boundaries = isset( $meta_data->boundaries ) ? (bool) $meta_data->boundaries : false;


    $regions_cap = isset( $meta_data->boundaries_regions ) ? $meta_data->boundaries_regions : 'world';
    if ( is_array( $regions_cap ) ) {
      $boundaries_regions = isset( $meta_data->boundaries_regions['region'] ) ? $meta_data->boundaries_regions['region'] : 'world';
    } else {
      $boundaries_regions = $regions_cap;
    }

    $boundaries_regions_selected = isset( $meta_data->boundaries_regions_selected ) ? $meta_data->boundaries_regions_selected : '';
    $boundaries_fill_main = isset( $meta_data->boundaries_fill['main'] ) ? $meta_data->boundaries_fill['main'] : 'rgba(161, 191, 227, 0.5)';
    $boundaries_fill_hover = isset( $meta_data->boundaries_fill['hover'] ) ? $meta_data->boundaries_fill['hover'] : '#6B89AD';
    $boundaries_fill_selected = isset( $meta_data->boundaries_fill['selected'] ) ? $meta_data->boundaries_fill['selected'] : '#3384E4';

    $boundaries_stroke_color = isset( $meta_data->boundaries_stroke['color'] ) ? $meta_data->boundaries_stroke['color'] : '#203146';
    $boundaries_stroke_width = isset( $meta_data->boundaries_stroke['width'] ) ? $meta_data->boundaries_stroke['width'] : '1';
    if ( ! is_numeric( $boundaries_stroke_width ) && empty( $boundaries_stroke_width ) ) {
      $boundaries_stroke_width = 1;
    }

    $boundaries_accuracy = isset( $meta_data->boundaries_regions['accuracy'] ) ? $meta_data->boundaries_regions['accuracy'] : 'medium';

    $boundaries_regions_hide = isset( $meta_data->boundaries_regions_hide ) ? $meta_data->boundaries_regions_hide : '';
    $boundaries_regions_custom_colors = isset( $meta_data->boundaries_regions_custom_colors ) ? $meta_data->boundaries_regions_custom_colors : '';


    $disable_drag_pan = isset( $meta_data->disable_drag_pan ) ? (bool) $meta_data->disable_drag_pan : false;
    $restrict_panning = isset( $meta_data->restrict_panning ) ? (bool) $meta_data->restrict_panning : false;
    $restrict_panning_southwest_lat = isset( $meta_data->restrict_panning_southwest['lat'] ) ? $meta_data->restrict_panning_southwest['lat'] : 0;
    $restrict_panning_southwest_lon = isset( $meta_data->restrict_panning_southwest['lon'] ) ? $meta_data->restrict_panning_southwest['lon'] : 0;

    $restrict_panning_northeast_lat = isset( $meta_data->restrict_panning_northeast['lat'] ) ? $meta_data->restrict_panning_northeast['lat'] : 0;
    $restrict_panning_northeast_lon = isset( $meta_data->restrict_panning_northeast['lon'] ) ? $meta_data->restrict_panning_northeast['lon'] : 0;

    if ( empty( $restrict_panning_southwest_lat ) && ! is_numeric( $restrict_panning_southwest_lat ) ) {
      $restrict_panning_southwest_lat = 0;
    }
    if ( empty( $restrict_panning_southwest_lon ) && ! is_numeric( $restrict_panning_southwest_lon ) ) {
      $restrict_panning_southwest_lon = 0;
    }

    if ( empty( $restrict_panning_northeast_lat ) && ! is_numeric( $restrict_panning_northeast_lat ) ) {
      $restrict_panning_northeast_lat = 0;
    }
    if ( empty( $restrict_panning_northeast_lon ) && ! is_numeric( $restrict_panning_northeast_lon ) ) {
      $restrict_panning_northeast_lon = 0;
    }


    $restrict_panning_data = [
      [ $restrict_panning_southwest_lon, $restrict_panning_southwest_lat ],
      [ $restrict_panning_northeast_lon, $restrict_panning_northeast_lat ],
    ];


    $action_on_click = isset( $meta_data->boundaries_onclick ) ? $meta_data->boundaries_onclick : 'none';
    $boundaries_links = isset( $meta_data->boundaries_links ) ? $meta_data->boundaries_links : '';


    $boundaries_onhover = isset( $meta_data->boundaries_onhover['type'] ) ? $meta_data->boundaries_onhover['type'] : 'none';
    $boundaries_onhover_prefix = isset( $meta_data->boundaries_onhover['prefix'] ) ? $meta_data->boundaries_onhover['prefix'] : '';
    $boundaries_values_regions = isset( $meta_data->boundaries_values_regions ) ? $meta_data->boundaries_values_regions : '';


    /**
     * $ll0 = 40.730610;
     * $ll1 = - 73.935242;
     */
    if ( twer_is_map_iframe() ) {
      if ( ! empty( $lat_init ) && is_numeric( $lat_init ) ) {
        $ll0 = $lat_init;
      }
      if ( ! empty( $lon_init ) && is_numeric( $lon_init ) ) {
        $ll1 = $lon_init;
      }
      if ( ! empty( $zoom_init ) && is_numeric( $zoom_init ) ) {
        $zoom = $zoom_init;
      }
    } else {
      $is_page_map_custom = get_post_meta( $post_id, '_treweler_page_map_custom', true );

      if ( ! empty( $is_page_map_custom ) ) {
        $page_map_initial_point = get_post_meta( $post_id, '_treweler_page_map_initial_point', true );
        $page_map_zoom = get_post_meta( $post_id, '_treweler_page_map_zoom', true );


        $page_map_initial_point_lat = isset( $page_map_initial_point['lat'] ) ? $page_map_initial_point['lat'] : '';
        $page_map_initial_point_lon = isset( $page_map_initial_point['lon'] ) ? $page_map_initial_point['lon'] : '';
        $page_map_zoom_number = isset( $page_map_zoom['number'] ) ? $page_map_zoom['number'] : '';


        if ( ! empty( $page_map_initial_point_lat ) && is_numeric( $page_map_initial_point_lat ) ) {
          $ll0 = $page_map_initial_point_lat;
        }
        if ( ! empty( $page_map_initial_point_lon ) && is_numeric( $page_map_initial_point_lon ) ) {
          $ll1 = $page_map_initial_point_lon;
        }
        if ( ! empty( $page_map_zoom_number ) && is_numeric( $page_map_zoom_number ) ) {
          $zoom = $page_map_zoom_number;
        }
      }

    }

    $tourShowMarkerNames = twer_get_meta( 'tour_show_marker_names', $map_id );
    if ( is_array( $tourShowMarkerNames ) ) {
      $tourShowMarkerNames = reset( $tourShowMarkerNames );
    }
    $tour_show_name = empty( $tourShowMarkerNames ) ? false : true;


    $tourIndexNumberStyle = get_post_meta( $map_id, '_treweler_tour_numbered_markers_style', true );

    $tourIndexNumberOffset = get_post_meta( $map_id, '_treweler_tour_numbered_markers_offset', true );
    $tourIndexNumberSettings = [
      'fontColor'  => $tourIndexNumberStyle['color'] ?? '#000000',
      'fontSize'   => ! empty( $tourIndexNumberStyle['font_size'] ) && is_numeric( $tourIndexNumberStyle['font_size'] ) ? (int) $tourIndexNumberStyle['font_size'] : 12,
      'fontWeight' => ! empty( $tourIndexNumberStyle['font_weight'] ) && is_numeric( $tourIndexNumberStyle['font_weight'] ) ? (int) $tourIndexNumberStyle['font_weight'] : 400,
      'offset'     => [
        'top'    => ! empty( $tourIndexNumberOffset['top'] ) && is_numeric( $tourIndexNumberOffset['top'] ) ? (int) $tourIndexNumberOffset['top'] : 0,
        'bottom' => ! empty( $tourIndexNumberOffset['bottom'] ) && is_numeric( $tourIndexNumberOffset['bottom'] ) ? (int) $tourIndexNumberOffset['bottom'] : 0,
        'left'   => ! empty( $tourIndexNumberOffset['left'] ) && is_numeric( $tourIndexNumberOffset['left'] ) ? (int) $tourIndexNumberOffset['left'] : 0,
        'right'  => ! empty( $tourIndexNumberOffset['right'] ) && is_numeric( $tourIndexNumberOffset['right'] ) ? (int) $tourIndexNumberOffset['right'] : 0
      ]
    ];



    $showUncategorized = twerGetNormalMetaCheckboxValue( get_post_meta( $map_id, '_treweler_show_uncategorized', true ) );
    $uncategorizedId = (int) get_option( 'default_map_category' );


    $directions = [
      'enable' => false
    ];
    if ( twerIsEnableDirections( $map_id ) ) {
      $directions = [
        'enable'            => isset( $meta_data->enable_directions ) && (bool) $meta_data->enable_directions,
        'profile'           => $meta_data->directions_routing_profile ?? 'traffic',
        'resetIconPosition' => $meta_data->directions_reset_position ?? 'top-left',
        'startDirectionsMarker' => $meta_data->directions_start_marker ?? 'user-geolocation',
      ];
    }

    $map_id = (int) $map_id;

    // Fill init map data
    $script .= 'TWER.initMap(' . wp_json_encode( apply_filters('twerResultMapSettings', [
        'mapPageId'                         => (int) $map_id,
        'accessToken'                       => esc_js( $api_key ),
        'container'                         => 'twer-map',
        'style'                             => trim( $customStyle ) != '' ? $customStyle : $style,
        'mapLightPreset' => $map_light_preset,
        'center'                            => [ esc_js( $ll1 ), esc_js( $ll0 ) ],
        'minZoom'                           => esc_js( $minZoom ),
        'projection'                        => esc_js( $projection ),
        'maxZoom'                           => esc_js( $maxZoom ),
        'zoom'                              => esc_js( $zoom ),
        'allowTour'                         => twer_isset( twer_get_meta( 'enable_tour', $map_id ) ),
        'tourData'                          => self::map_marker_data( $map_id ) ? wp_json_encode( self::map_marker_data( $map_id ),
          JSON_NUMERIC_CHECK ) : '{}',
        'tourPopUp'                         => twer_isset( twer_get_meta( 'tour_show_marker_popups', $map_id ) ),
        'tourNumberSettings' => $tourIndexNumberSettings,
        'tourLabelMarker'                   => $tour_show_name,
        'tourAutoRun'                       => twer_isset( twer_get_meta( 'tour_auto_run', $map_id ) ),
        'tourType'                          => esc_js( $meta_data->tour_type ?? 'jump' ),
        'tourFlySpeed'                      => esc_js( $meta_data->tour_fly_speed ?? '1.2' ),
        'tourOffsets'                       => $tour_offsets,
        'tourFlyCurve'                      => esc_js( $meta_data->tour_fly_curve ?? '1.42' ),
        'allowBearing'                      => esc_js( $allowBearing ),
        'iniBearing'                        => esc_js( $iniBearing ),
        //'allowPitch'               => esc_js( $allowPitch ),
        'iniPitch'                          => esc_js( $iniPitch ),
        'maxPitch'                          => esc_js( $maxPitch ),
        'minPitch'                          => esc_js( $minPitch ),
        'mapLanguange'                      => esc_js( $languanges ),
        'showUncategorized' => $showUncategorized,
        'uncategorizedId' => $uncategorizedId,
        'allowCluster'                      => (bool) twer_isset( twer_get_meta( 'map_enable_clustering', $map_id ) ),
        'shapes'                            => self::get_shapes_by_map( $map_id ),
        'allowStoreLocator'                 => false,
        'storeLocatorControlsPosition'      => $store_locator_controls_position,
        'storeLocatorMarker'                => $map_location_marker,
        'storeLocatorMarkerTemplate'        => $map_location_marker_template,
        'storeLocatorFilters'               => $store_locator_filters,
        'mapCenterOnClick'                => $map_center_on_click,
        'storeLocatorSearch'                => $store_locator_search,
        'storeLocatorGeolocation'           => $store_locator_geolocation,
        'storeLocatorType'                  => $store_locator_type,
        'storeLocatorSidebarOpenButtonPosition' => $store_locator_sidebar_open_button_position,
        'storeLocatorSidebarClose' => $store_locator_close,
        'storeLocatorSidebarPosition' => $store_locator_sidebar_position,
        'storeLocatorCardFieldsMainValue'   => $store_locator_card_fields_main_value,
        'storeLocatorMarkerFieldsMainValue' => $store_locator_marker_fields_main_value,
        'storeLocatorSearchAndGeolocation'  => $store_locator_search_and_geolocation,
        'storeLocatorRadius'                => $store_locator_radius,
        'storeLocatorRadiusSize'            => $store_locator_radius_size,
        'storeLocatorRadiusDistance'        => $store_locator_radius_distance,
        'storeLocatorRadiusDefault'         => $store_locator_radius_default,
        'storeLocatorMarkerClickEvent'      => $store_locator_marker_click_event,
        'storeLocatorCardClickEvent'        => $store_locator_card_click_event,
        'storeLocatorZoomOnClick'        => $store_locator_zoom_on_click,
        'storeLocatorStrings'               => wp_json_encode( [
          'unlim' => esc_html__( 'Unlimited', 'treweler' ),
          'km'    => esc_html__( 'km', 'treweler' ),
          'mi'    => esc_html__( 'mi', 'treweler' )
        ] ),
        'storeLocatorSearchPlaceholder'     => esc_html__( 'Enter address or ZIP code', 'treweler' ),

        'actionOnHoverBoundaries' => $boundaries_onhover,
        'boundariesValuesPrefix'  => $boundaries_onhover_prefix,
        'boundariesValues'        => $boundaries_values_regions,

        'disableDragPan'      => $disable_drag_pan,
        'restrictPanning'     => $restrict_panning,
        'restrictPanningData' => $restrict_panning_data,


        'actionOnClickBoundaries' => $action_on_click,
        'boundariesLinks'         => $boundaries_links,

        'boundaries'         => $boundaries,
        'boundariesRegions'  => $boundaries_regions,
        'boundariesAccuracy' => $boundaries_accuracy,

        'boundariesRegionsHide'         => $boundaries_regions_hide,
        'boundariesRegionsCustomColors' => $boundaries_regions_custom_colors,

        'boundariesRegionsSelected' => $boundaries_regions_selected,
        'boundariesFillMain'        => $boundaries_fill_main,
        'boundariesFillHover'       => $boundaries_fill_hover,
        'boundariesFillSelected'    => $boundaries_fill_selected,
        'boundariesStrokeColor'     => $boundaries_stroke_color,
        'boundariesStrokeWidth'     => $boundaries_stroke_width,


        'worldCopy'                 => $world_copy,
        'bgOverlay'                 => esc_js( $bg_overlay ),
        'clusterColor'              => esc_js( $clusterColor ),
        'clusterMaxZoom'            => esc_js( $cluster_max_zoom ),
        'wordmarkPosition'          => ! empty( $meta_data->wordmark_position ) ? esc_js( $meta_data->wordmark_position ) : 'bottom-left',
        'attributionPosition'       => ! empty( $meta_data->attribution_position ) ? esc_js( $meta_data->attribution_position ) : 'bottom-right',
        'compactAttribution'        => twer_isset( $meta_data->compact_attribution ),
        'scaleControl'              => $distance_scale,
        'scaleControlPosition'      => esc_js( $distance_scale_position ),
        'scaleControlUnit' => esc_js($distance_scale_unit),
        'layers' => $mapLayers,
        'fullscreenControl'         => $fullscreen,
        'fullscreenControlPosition' => esc_js( $fullscreen_position ),
        'searchControl'             => $search,
        'searchControlPlaceholder'  => esc_html__( 'Enter search...', 'treweler' ),
        'searchControlPosition'     => esc_js( $search_position ),
        'zoomControl'               => $zoom_pan,
        'zoomControlPosition'       => esc_js( $zoom_pan_position ),
        'geolocateControl'          => $geolocate,
        'geolocateControlPosition'  => esc_js( $geolocate_position ),
        'geolocateControlStyle' => esc_js($geolocate_style),
        'scrollZoom'                => ( $scrollzoom !== 'no' ) ? true : false,
        'gpxRoutes'                 => ! empty( $gpx_data ) ? $gpx_data : false,
        'fitBounds'                 => twer_isset( twer_get_meta( 'fitbounds', $map_id ) ),
        'userGeolocation'           => $user_geolocation,
        'userGeolocationCenteredMapOnLoad'           => $centeredMapOnLoadUserGeolocation,
        'userGeolocationMarkerTemplate'           => $userLocationMarkerTemplate,
        'directions' => $directions
      ], $map_id, $cluster_features, $route_features ), JSON_NUMERIC_CHECK ) . ');';

    $script .= "});})();";

    return $script;
  }

  public static function template_meta_diff( $data ) {
    $new_data = [];
    foreach ( $data as $data_key => $data_item ) {

      switch ( $data_key ) {
        case 'custom_fields_font' :
          $new_data['custom_field_size'] = $data_item['size'];
          $new_data['custom_field_weight'] = $data_item['weight'];
          break;
        case 'label_marker_hide' :
          $new_data['marker_hide'] = $data_item;
          break;
        case 'label_weight' :
          $new_data['label_font_weight'] = $data_item;
          break;
        case 'label_size' :
          $new_data['label_font_size'] = $data_item;
          break;
        case 'label_color' :
          $new_data['label_font_color'] = $data_item;
          break;
        case 'label_enable' :
          $new_data['marker_enable_labels'] = $data_item;
          break;
        case 'popup_open_on' :
          $new_data['popup_open_group']['open_on'] = $data_item['action'];
          $new_data['popup_open_group']['open_default'] = $data_item['default'];
          break;
        case 'popup_heading' :
          $new_data['popup_heading'] = $data_item['text'];
          $new_data['popup_heading_size'] = $data_item['size'];
          $new_data['popup_heading_font_weight'] = $data_item['weight'];
          break;
        case 'popup_subheading' :
          $new_data['popup_subheading'] = $data_item['text'];
          $new_data['popup_subheading_size'] = $data_item['size'];
          $new_data['popup_subheading_font_weight'] = $data_item['weight'];
          break;
        case 'popup_description' :
          $new_data['popup_description'] = $data_item['text'];
          $new_data['popup_description_size'] = $data_item['size'];
          $new_data['popup_description_font_weight'] = $data_item['weight'];
          break;
        case 'popup_gallery' :
          $new_data['popup_image'] = $data_item;
          break;
        case 'popup_gallery_position' :
          $new_data['popup_image_position'] = $data_item;
          break;
        case 'popup_gallery_width' :
          $new_data['popup_image_width'] = $data_item;
          break;
        case 'point_color' :
          $new_data['marker_color'] = $data_item;
          break;
        case 'point_halo_color' :
          $new_data['marker_halo_color'] = $data_item;
          break;
        case 'dot_icon_show' :
          $new_data['picker_dot'] = $data_item;
          break;
        case 'dot_icon' :
          $new_data['dot_icon_color'] = $data_item['color'];
          $new_data['dot_icon_size'] = $data_item['size'];
          break;
        case 'dot' :
          $new_data['marker_dotcenter_color'] = $data_item['color'];
          $new_data['marker_size'] = $data_item['size'];
          break;
        case 'dot_border' :
          $new_data['marker_border_color'] = $data_item['color'];
          $new_data['marker_border_width'] = $data_item['size'];
          break;
        case 'dot_corner_radius' :
          $new_data['marker_corner_radius'] = $data_item['size'];
          $new_data['marker_corner_radius_units'] = $data_item['units'];
          break;
        case 'balloon_icon_show' :
          $new_data['picker'] = $data_item;
          break;
        case 'balloon_icon' :
          $new_data['balloon_icon_color'] = $data_item['color'];
          $new_data['balloon_icon_size'] = $data_item['size'];
          break;
        case 'balloon' :
          $new_data['marker_color_balloon'] = $data_item['color'];
          $new_data['marker_size_balloon'] = $data_item['size'];
          break;
        case 'balloon_border' :
          $new_data['marker_border_color_balloon'] = $data_item['color'];
          $new_data['marker_border_width_balloon'] = $data_item['size'];
          break;
        case 'balloon_dot' :
          $new_data['marker_dot_color'] = $data_item['color'];
          $new_data['marker_dot_size'] = $data_item['size'];
          break;
        case 'triangle_color' :
          $new_data['marker_color_triangle'] = $data_item;
          break;
        case 'triangle_width' :
          $new_data['marker_width_triangle'] = $data_item;
          break;
        case 'triangle_height' :
          $new_data['marker_height_triangle'] = $data_item;
          break;
        case 'custom_marker_img' :
          if ( is_numeric( $data_item ) ) {
            $data_item = wp_get_attachment_image_src( $data_item, 'full' );
            $data_item = isset( $data_item[0] ) ? $data_item[0] : $data_item;
          }
          $new_data['thumbnail_id'] = $data_item;
          break;
        case 'custom_marker_position' :
          $new_data['marker_position'] = $data_item;
          break;
        case 'custom_marker_size' :
          $new_data['marker_img_size'] = $data_item;
          break;
        case 'custom_marker_cursor' :
          $new_data['marker_cursor'] = $data_item;
          break;
        case 'point_halo_opacity' :
          $new_data['marker_halo_opacity'] = $data_item;
          break;
        default :
          $new_data[ $data_key ] = $data_item;
          break;
      }
    }

    return (object) $new_data;
  }


  /**
   * Get Markers for particular map
   *
   * @param string $mapId
   *
   * @return array
   */
  public static function getMarkersOfMap( $mapId = '' ) {
    global $post, $wp_filter;
	  $prefix       = '_treweler_';
	  $lagacyFilter = 'twerGetMarkersOfMapArgs';
	  if ( isset( $wp_filter[ $lagacyFilter ] ) ) {
		  $args       = apply_filters( 'twerGetMarkersOfMapArgs', [
			  // basics
			  'post_type'      => 'marker',
			  'post_status'    => 'publish',
			  'posts_per_page' => '-1',
			  // meta query
			  'meta_query'     => [
				  'relation' => 'OR',
				  [
					  'key'     => $prefix . 'marker_map_id',
					  'value'   => $mapId,
					  'compare' => '='
				  ],
				  [
					  'key'     => $prefix . 'marker_map_id',
					  'value'   => serialize( strval( $mapId ) ),
					  'compare' => 'LIKE'
				  ]
			  ]
		  ], $mapId );
		  $getMarkers = get_posts( $args );
	  } else {
		  $mapId = intval($mapId);
		  $getMarkers = twerGetMarkersMap($mapId);
	  }

    if ( ! empty( $getMarkers ) ) {
      $c = 0;
      foreach ( twerYieldLoop( $getMarkers ) as $v ) {
        $template_data = [];
        $current_template = get_post_meta( $v->ID, $prefix . 'templates', true );

        if ( 'none' !== $current_template && ! empty( $current_template ) ) {
          $template_data = self::template_meta_diff( twer_get_data( $current_template ) );
        }

        $marker_data = twer_get_data( $v->ID );

        if ( ! empty( (array) $template_data ) ) {
          $markers[ $c ]['id'] = $v->ID;
          $markers[ $c ]['style'] = isset( $marker_data->marker_style_lock ) && $marker_data->marker_style_lock === 'close' ? $template_data->marker_style : $marker_data->marker_style;
          $markers[ $c ]['halo_color'] = isset( $marker_data->marker_halo_color_lock ) && $marker_data->marker_halo_color_lock === 'close' ? $template_data->marker_halo_color : $marker_data->marker_halo_color;
          $halo_opacity = isset( $marker_data->marker_halo_opacity_lock ) && $marker_data->marker_halo_opacity_lock === 'close' ? $template_data->marker_halo_opacity : $marker_data->marker_halo_opacity;

          if ( ! is_numeric( $halo_opacity ) && empty( $halo_opacity ) ) {
            $halo_opacity = 0.5;
          }
          $markers[ $c ]['halo_opacity'] = $halo_opacity;

          $marker_inner_size = isset( $marker_data->marker_size_lock ) && $marker_data->marker_size_lock === 'close' ? $template_data->marker_size : $marker_data->marker_size;
          if ( ! is_numeric( $marker_inner_size ) && empty( $marker_inner_size ) ) {
            $marker_inner_size = 12;
          }
          $markers[ $c ]['inner_size'] = $marker_inner_size;


          $markers[ $c ]['border_color'] = isset( $marker_data->marker_border_color_lock ) && $marker_data->marker_border_color_lock === 'close' ? $template_data->marker_border_color : $marker_data->marker_border_color;
          $markers[ $c ]['dotcenter_color'] = isset( $marker_data->marker_dotcenter_color_lock ) && $marker_data->marker_dotcenter_color_lock === 'close' ? $template_data->marker_dotcenter_color : $marker_data->marker_dotcenter_color;
          $border_width = isset( $marker_data->marker_border_width_lock ) && $marker_data->marker_border_width_lock === 'close' ? $template_data->marker_border_width : $marker_data->marker_border_width;
          if ( ! is_numeric( $border_width ) && empty( $border_width ) ) {
            $border_width = 0;
          }
          $markers[ $c ]['border_width'] = $border_width;

          $corner_radius = isset( $marker_data->marker_corner_radius_lock ) && $marker_data->marker_corner_radius_lock === 'close' ? $template_data->marker_corner_radius : $marker_data->marker_corner_radius;
          if ( ! is_numeric( $corner_radius ) && empty( $corner_radius ) ) {
            $corner_radius = 50;
          }
          $markers[ $c ]['corner_radius'] = $corner_radius;


          $corner_radius_units = isset( $marker_data->marker_corner_radius_units_lock ) && $marker_data->marker_corner_radius_units_lock === 'close' ? $template_data->marker_corner_radius_units : $marker_data->marker_corner_radius_units;
          if ( empty( $corner_radius_units ) ) {
            $corner_radius_units = '%';
          }
          $markers[ $c ]['corner_radius_units'] = $corner_radius_units;


          $dot_icon_show = isset( $marker_data->picker_dot_lock ) && $marker_data->picker_dot_lock === 'close' ? $template_data->picker_dot : $marker_data->picker_dot;
          $markers[ $c ]['dot_icon_show'] = (bool) twer_isset( $dot_icon_show );
          $dot_icon_size = isset( $marker_data->dot_icon_size_lock ) && $marker_data->dot_icon_size_lock === 'close' ? $template_data->dot_icon_size : $marker_data->dot_icon_size;
          if ( ! is_numeric( $dot_icon_size ) && empty( $dot_icon_size ) ) {
            $dot_icon_size = 15;
          }
          $markers[ $c ]['dot_icon_size'] = $dot_icon_size;
          $markers[ $c ]['dot_icon_color'] = isset( $marker_data->dot_icon_color_lock ) && $marker_data->dot_icon_color_lock === 'close' ? $template_data->dot_icon_color : $marker_data->dot_icon_color;
          $markers[ $c ]['dot_icon'] = isset( $marker_data->dot_icon_picker_lock ) && $marker_data->dot_icon_picker_lock === 'close' ? $template_data->dot_icon_picker : $marker_data->dot_icon_picker;


          $markers[ $c ]['color_balloon'] = isset( $marker_data->marker_color_balloon_lock ) && $marker_data->marker_color_balloon_lock === 'close' ? $template_data->marker_color_balloon : $marker_data->marker_color_balloon;
          $size_balloon = isset( $marker_data->marker_size_balloon_lock ) && $marker_data->marker_size_balloon_lock === 'close' ? $template_data->marker_size_balloon : $marker_data->marker_size_balloon;
          if ( ! is_numeric( $size_balloon ) && empty( $size_balloon ) ) {
            $size_balloon = 18;
          }
          $markers[ $c ]['size_balloon'] = $size_balloon;
          $markers[ $c ]['border_color_balloon'] = isset( $marker_data->marker_border_color_balloon_lock ) && $marker_data->marker_border_color_balloon_lock === 'close' ? $template_data->marker_border_color_balloon : $marker_data->marker_border_color_balloon;
          $border_width_balloon = isset( $marker_data->marker_border_width_balloon_lock ) && $marker_data->marker_border_width_balloon_lock === 'close' ? $template_data->marker_border_width_balloon : $marker_data->marker_border_width_balloon;
          if ( ! is_numeric( $border_width_balloon ) && empty( $border_width_balloon ) ) {
            $border_width_balloon = 4;
          }
          $markers[ $c ]['border_width_balloon'] = $border_width_balloon;
          $markers[ $c ]['dot_color'] = isset( $marker_data->marker_dot_color_lock ) && $marker_data->marker_dot_color_lock === 'close' ? $template_data->marker_dot_color : $marker_data->marker_dot_color;
          $marker_dot_size = isset( $marker_data->marker_dot_size_lock ) && $marker_data->marker_dot_size_lock === 'close' ? $template_data->marker_dot_size : $marker_data->marker_dot_size;
          if ( ! is_numeric( $marker_dot_size ) && empty( $marker_dot_size ) ) {
            $marker_dot_size = 8;
          }
          $markers[ $c ]['dot_size'] = $marker_dot_size;


          $markers[ $c ]['color_triangle'] = isset( $marker_data->marker_color_triangle_lock ) && $marker_data->marker_color_triangle_lock === 'close' ? $template_data->marker_color_triangle : $marker_data->marker_color_triangle;

          $width_triangle = isset( $marker_data->marker_width_triangle_lock ) && $marker_data->marker_width_triangle_lock === 'close' ? $template_data->marker_width_triangle : $marker_data->marker_width_triangle;
          if ( ! is_numeric( $width_triangle ) && empty( $width_triangle ) ) {
            $width_triangle = 12;
          }
          $markers[ $c ]['width_triangle'] = $width_triangle;

          $height_triangle = isset( $marker_data->marker_height_triangle_lock ) && $marker_data->marker_height_triangle_lock === 'close' ? $template_data->marker_height_triangle : $marker_data->marker_height_triangle;
          if ( ! is_numeric( $height_triangle ) && empty( $height_triangle ) ) {
            $height_triangle = 10;
          }
          $markers[ $c ]['height_triangle'] = $height_triangle;

          if(isset( $marker_data->picker_lock ) && $marker_data->picker_lock === 'close') {
	          $picker_show = $template_data->picker ?? false;
          } else {
	          $picker_show = $marker_data->picker ?? false;
          }

          $markers[ $c ]['balloon_icon_show'] = (bool) twer_isset( $picker_show );

          if(isset( $marker_data->balloon_icon_size_lock ) && $marker_data->balloon_icon_size_lock === 'close') {
	          $balloon_icon_size = $template_data->balloon_icon_size ?? 15;
          } else {
	          $balloon_icon_size = $marker_data->balloon_icon_size ?? 15;
          }

          if ( ! is_numeric( $balloon_icon_size ) && empty( $balloon_icon_size ) ) {
            $balloon_icon_size = 15;
          }
          $markers[ $c ]['balloon_icon_size'] = $balloon_icon_size;


          if(isset( $marker_data->balloon_icon_color_lock ) && $marker_data->balloon_icon_color_lock === 'close') {
              $balloon_icon_color = $template_data->balloon_icon_color ?? '#ffffff';
          } else {
	          $balloon_icon_color = $marker_data->balloon_icon_color ?? '#ffffff';
          }

          $markers[ $c ]['balloon_icon_color'] = $balloon_icon_color;

          if(isset( $marker_data->balloon_icon_picker_lock ) && $marker_data->balloon_icon_picker_lock === 'close' ) {
              $balloon_icon = $template_data->balloon_icon_picker ?? '';
          } else {
	          $balloon_icon = $marker_data->balloon_icon_picker ?? '';
          }

          $markers[ $c ]['balloon_icon'] = $balloon_icon;




          $markers[ $c ]['color'] = isset( $marker_data->marker_color_lock ) && $marker_data->marker_color_lock === 'close' ? $template_data->marker_color : $marker_data->marker_color;
          $markers[ $c ]['latlng'] = isset( $marker_data->marker_latlng_lock ) && $marker_data->marker_latlng_lock === 'close' ? $template_data->marker_latlng : $marker_data->marker_latlng;


          if ( isset( $marker_data->thumbnail_id_lock ) && $marker_data->thumbnail_id_lock === 'close' ) {
            $thumbnail_id = $template_data->thumbnail_id ?? '';
          } else {
            $thumbnail_id = $marker_data->thumbnail_id ?? '';
          }

          if ( is_numeric( $thumbnail_id ) ) {
            $thumbnail_id = wp_get_attachment_image_src( $thumbnail_id, 'full' );
            $thumbnail_id = isset( $thumbnail_id[0] ) ? $thumbnail_id[0] : $thumbnail_id;
          }

          $markers[ $c ]['icon'] = $thumbnail_id;

          if(isset( $marker_data->marker_cursor_lock ) && $marker_data->marker_cursor_lock === 'close') {
              $cursor = $template_data->marker_cursor ?? 'pointer';
          } else {
              $cursor = $marker_data->marker_cursor ?? 'pointer';
          }


          $markers[ $c ]['cursor'] =  $cursor;


          if(isset( $marker_data->marker_position_lock ) && $marker_data->marker_position_lock === 'close') {
              $anchor = $template_data->marker_position ?? 'center';
          } else {
	          $anchor = $marker_data->marker_position ?? 'center';
          }


          $markers[ $c ]['anchor'] = $anchor;


          if(isset( $marker_data->marker_icon_size_lock ) && $marker_data->marker_icon_size_lock === 'close') {
              $marker_icon_size =  $template_data->marker_icon_size ?? 0;
          } else {
	          $marker_icon_size = $marker_data->marker_icon_size ?? 0;
          }

          $markers[ $c ]['size'] =  $marker_icon_size;


          if(isset( $marker_data->marker_img_size_lock ) && $marker_data->marker_img_size_lock === 'close') {
              $markerSize = $template_data->marker_img_size ?? 42;
          } else {
	          $markerSize = $marker_data->marker_img_size ?? 42;
          }


          $markers[ $c ]['markerSize'] = $markerSize;
          $markers[ $c ]['category'] = twer_build_category_classes( $v->ID ?? 0 );

        } else {
          $markers[ $c ]['id'] = $v->ID;
          $markers[ $c ]['style'] = get_post_meta( $v->ID, $prefix . 'marker_style', true );
          $markers[ $c ]['halo_color'] = get_post_meta( $v->ID, $prefix . 'marker_halo_color', true );
          $halo_opacity = get_post_meta( $v->ID, $prefix . 'marker_halo_opacity', true );

          if ( ! is_numeric( $halo_opacity ) && empty( $halo_opacity ) ) {
            $halo_opacity = 0.5;
          }
          $markers[ $c ]['halo_opacity'] = $halo_opacity;

          $marker_inner_size = get_post_meta( $v->ID, $prefix . 'marker_size', true );
          if ( ! is_numeric( $marker_inner_size ) && empty( $marker_inner_size ) ) {
            $marker_inner_size = 12;
          }
          $markers[ $c ]['inner_size'] = $marker_inner_size;


          $markers[ $c ]['border_color'] = get_post_meta( $v->ID, $prefix . 'marker_border_color', true );
          $markers[ $c ]['dotcenter_color'] = get_post_meta( $v->ID, $prefix . 'marker_dotcenter_color', true );
          $border_width = get_post_meta( $v->ID, $prefix . 'marker_border_width', true );
          if ( ! is_numeric( $border_width ) && empty( $border_width ) ) {
            $border_width = 0;
          }
          $markers[ $c ]['border_width'] = $border_width;

          $corner_radius = get_post_meta( $v->ID, $prefix . 'marker_corner_radius', true );
          if ( ! is_numeric( $corner_radius ) && empty( $corner_radius ) ) {
            $corner_radius = 50;
          }
          $markers[ $c ]['corner_radius'] = $corner_radius;


          $corner_radius_units = get_post_meta( $v->ID, $prefix . 'marker_corner_radius_units', true );
          if ( empty( $corner_radius_units ) ) {
            $corner_radius_units = '%';
          }
          $markers[ $c ]['corner_radius_units'] = $corner_radius_units;


          $markers[ $c ]['dot_icon_show'] = (bool) twer_isset( get_post_meta( $v->ID, $prefix . 'picker_dot', true ) );
          $dot_icon_size = get_post_meta( $v->ID, $prefix . 'dot_icon_size', true );
          if ( ! is_numeric( $dot_icon_size ) && empty( $dot_icon_size ) ) {
            $dot_icon_size = 15;
          }
          $markers[ $c ]['dot_icon_size'] = $dot_icon_size;
          $markers[ $c ]['dot_icon_color'] = get_post_meta( $v->ID, $prefix . 'dot_icon_color', true );
          $markers[ $c ]['dot_icon'] = get_post_meta( $v->ID, $prefix . 'dot_icon_picker', true );


          $markers[ $c ]['color_balloon'] = get_post_meta( $v->ID, $prefix . 'marker_color_balloon', true );
          $size_balloon = get_post_meta( $v->ID, $prefix . 'marker_size_balloon', true );
          if ( ! is_numeric( $size_balloon ) && empty( $size_balloon ) ) {
            $size_balloon = 18;
          }
          $markers[ $c ]['size_balloon'] = $size_balloon;
          $markers[ $c ]['border_color_balloon'] = get_post_meta( $v->ID, $prefix . 'marker_border_color_balloon', true );
          $border_width_balloon = get_post_meta( $v->ID, $prefix . 'marker_border_width_balloon', true );
          if ( ! is_numeric( $border_width_balloon ) && empty( $border_width_balloon ) ) {
            $border_width_balloon = 4;
          }
          $markers[ $c ]['border_width_balloon'] = $border_width_balloon;
          $markers[ $c ]['dot_color'] = get_post_meta( $v->ID, $prefix . 'marker_dot_color', true );
          $marker_dot_size = get_post_meta( $v->ID, $prefix . 'marker_dot_size', true );
          if ( ! is_numeric( $marker_dot_size ) && empty( $marker_dot_size ) ) {
            $marker_dot_size = 8;
          }
          $markers[ $c ]['dot_size'] = $marker_dot_size;


          $markers[ $c ]['color_triangle'] = get_post_meta( $v->ID, $prefix . 'marker_color_triangle', true );

          $width_triangle = get_post_meta( $v->ID, $prefix . 'marker_width_triangle', true );
          if ( ! is_numeric( $width_triangle ) && empty( $width_triangle ) ) {
            $width_triangle = 12;
          }
          $markers[ $c ]['width_triangle'] = $width_triangle;

          $height_triangle = get_post_meta( $v->ID, $prefix . 'marker_height_triangle', true );
          if ( ! is_numeric( $height_triangle ) && empty( $height_triangle ) ) {
            $height_triangle = 10;
          }
          $markers[ $c ]['height_triangle'] = $height_triangle;


          $markers[ $c ]['balloon_icon_show'] = (bool) twer_isset( get_post_meta( $v->ID, $prefix . 'picker', true ) );
          $balloon_icon_size = get_post_meta( $v->ID, $prefix . 'balloon_icon_size', true );
          if ( ! is_numeric( $balloon_icon_size ) && empty( $balloon_icon_size ) ) {
            $balloon_icon_size = 15;
          }
          $markers[ $c ]['balloon_icon_size'] = $balloon_icon_size;
          $markers[ $c ]['balloon_icon_color'] = get_post_meta( $v->ID, $prefix . 'balloon_icon_color', true );
          $markers[ $c ]['balloon_icon'] = get_post_meta( $v->ID, $prefix . 'balloon_icon_picker', true );


          $markers[ $c ]['color'] = get_post_meta( $v->ID, $prefix . 'marker_color', true );
          $markers[ $c ]['latlng'] = get_post_meta( $v->ID, $prefix . 'marker_latlng', true );
          $thumbnail_id = get_post_meta( $v->ID, $prefix . 'thumbnail_id', true );
          if ( is_numeric( $thumbnail_id ) ) {
            $thumbnail_id = wp_get_attachment_image_src( $thumbnail_id, 'full' );
            $thumbnail_id = isset( $thumbnail_id[0] ) ? $thumbnail_id[0] : $thumbnail_id;
          }
          $markers[ $c ]['icon'] = $thumbnail_id;
          $markers[ $c ]['cursor'] = get_post_meta( $v->ID, $prefix . 'marker_cursor', true );
          $markers[ $c ]['anchor'] = get_post_meta( $v->ID, $prefix . 'marker_position', true );
          $markers[ $c ]['size'] = get_post_meta( $v->ID, $prefix . 'marker_icon_size', true );
          $markers[ $c ]['markerSize'] = get_post_meta( $v->ID, $prefix . 'marker_img_size', true ) ?? 0;
          $markers[ $c ]['category'] = twer_build_category_classes( $v->ID ?? 0 );
        }

        $c ++;
      }

      return $markers;
    }

    return [];
  }

  /**
   * Get Routes for particular map
   *
   * @param string $mapId
   *
   * @return array
   */
  public static function getRoutesOfMap( $mapId = '' ) {

    $prefix = '_treweler_';
    $args = apply_filters('twerGetRoutesOfMapArgs', [
      // basics
      'post_type'      => 'route',
      'post_status'    => 'publish',
      'posts_per_page' => '-1',
      // meta query
      'meta_query'     => [
        'relation' => 'OR',
        [
          'key'     => $prefix . 'route_map_id',
          'value'   => $mapId,
          'compare' => '='
        ],
        [
          'key'     => $prefix . 'route_map_id',
          'value'   => serialize( strval( $mapId ) ),
          'compare' => 'LIKE'
        ]
      ]
    ], $mapId );

    $getRoutes = new WP_Query( $args );
    if ( $getRoutes->post_count > 0 ) {
      $c = 0;
      foreach ( $getRoutes->posts as $k => $v ) {
        $routes[ $c ]['id'] = $v->ID;
        $routes[ $c ]['routeCoords'] = get_post_meta( $v->ID, $prefix . 'route_line_coords', true );
        $routes[ $c ]['routeGPX'] = get_post_meta( $v->ID, $prefix . 'route_gpx_file', true );
        $routes[ $c ]['routeColor'] = get_post_meta( $v->ID, $prefix . 'route_line_color', true );
        $routes[ $c ]['routeProfile'] = get_post_meta( $v->ID, $prefix . 'route_profile', true );
        $routes[ $c ]['routeLineWidth'] = get_post_meta( $v->ID, $prefix . 'route_line_width', true ) ?: 3;
        $routes[ $c ]['routeLineOpacity'] = get_post_meta( $v->ID, $prefix . 'route_line_opacity', true ) ?: 1;
        $routes[ $c ]['routeLineDash'] = get_post_meta( $v->ID, $prefix . 'route_line_dash', true ) ?: 1;
        $routes[ $c ]['routeLineGap'] = get_post_meta( $v->ID, $prefix . 'route_line_gap', true ) ?: 0;
        $routes[ $c ]['routeCategory'] = twer_get_categories( $v->ID ?? 0 );
        $c ++;
      }

      return $routes;
    }

    return [];
  }

  public static function map_marker_data( $map_id ) {

    $meta = get_post_meta( $map_id );
    $prefix = '_treweler_';
    $args = [
      // basics
      'post_type'      => 'marker',
      'post_status'    => 'publish',
      'posts_per_page' => '-1',
      // meta query
      'meta_query'     => [
        'relation' => 'OR',
        [
          'key'     => $prefix . 'marker_map_id',
          'value'   => $map_id,
          'compare' => '='
        ],
        [
          'key'     => $prefix . 'marker_map_id',
          'value'   => serialize( strval( $map_id ) ),
          'compare' => 'LIKE'
        ]
      ]
    ];

    $markers = [];
    $getMarkers = new WP_Query( $args );
    if ( $getMarkers->post_count > 0 ) {
      $c = 0;
      foreach ( $getMarkers->posts as $k => $v ) {
        $markers[] = $v->ID;
      }
    }


    $tour_metadata = [];
    $data_map_raw = twer_get_meta( 'tour_marker_repeater', $map_id );

    $data_main = isset( $data_map_raw['main'] ) ? $data_map_raw['main'] : [];

    $data_map = twer_isset( $data_map_raw ) ? $data_main : false;  //$data_map_raw['main'] ?: false arra ;
    $marker_zoom_parent = twer_get_meta( 'marker_zoom_level', $map_id );
    $marker_bearing_parent = twer_get_meta( 'camera_initial_bearing', $map_id );
    $marker_pitch_parent = twer_get_meta( 'camera_initial_pitch', $map_id );


    $nonce = isset( $meta['_treweler_noncefield'][0] ) ? true : false;

    if ( ! $nonce ) {
      $map_zoom_max_parent = twer_get_meta( 'map_max_zoom', $map_id );
      $map_zoom_min_parent = twer_get_meta( 'map_min_zoom', $map_id );
    } else {
      $newMapSettingsDataZoom = isset( $meta['_treweler_map_zoom_range'][0] ) ? $meta['_treweler_map_zoom_range'][0] : '';
      $_treweler_map_zoom = unserialize( $newMapSettingsDataZoom );
      $map_zoom_max_parent = is_numeric( $_treweler_map_zoom['max_zoom'] ) ? $_treweler_map_zoom['max_zoom'] : 24;
      $map_zoom_min_parent = is_numeric( $_treweler_map_zoom['min_zoom'] ) ? $_treweler_map_zoom['min_zoom'] : 0;
    }

    $map_fly_speed_parent = twer_get_meta( 'tour_fly_speed', $map_id ) ?? '1.2';
    $map_fly_curve_parent = twer_get_meta( 'tour_fly_curve', $map_id ) ?? '1.42';

    $tour_offset_parent = twer_get_meta( 'tour_offset', $map_id ) ?? [
      'top'    => 0,
      'bottom' => 0,
      'left'   => 0,
      'right'  => 0
    ];

    if ( empty( $tour_offset_parent ) ) {
      $tour_offset_parent = [
        'top'    => 0,
        'bottom' => 0,
        'left'   => 0,
        'right'  => 0
      ];
    }

    $idx = 0;

    if ( isset( $data_map ) && $data_map != false ) {
      foreach ( $data_map as $i => $item ) {
        if ( ! isset( $item['tour_marker_id'] ) || $item['tour_marker_id'] <= 0 || 'publish' !== get_post_status( $item['tour_marker_id'] ) || ! in_array( $item['tour_marker_id'],
            $markers ) ) {
          continue;
        }

        $adv_s = (bool) $item['tour_advanced_settings'] ?? false;

        if ( $adv_s ) {
          if ( $item['tour_marker_zoom'] > $map_zoom_max_parent ) {
            $marker_zoom = $map_zoom_max_parent;
          } elseif ( $item['tour_marker_zoom'] < $map_zoom_min_parent ) {
            $marker_zoom = $map_zoom_min_parent;
          } else {
            $marker_zoom = $item['tour_marker_zoom'];
          }
        } else {
          if ( $marker_zoom_parent > $map_zoom_max_parent ) {
            $marker_zoom = $map_zoom_max_parent;
          } elseif ( $marker_zoom_parent < $map_zoom_min_parent ) {
            $marker_zoom = $map_zoom_min_parent;
          } else {
            $marker_zoom = $marker_zoom_parent;
          }
        }


        $popupHeading = isset( twer_get_data( $item['tour_marker_id'] )->popup_heading) ?  twer_get_data( $item['tour_marker_id'] )->popup_heading : '';
        $tour_metadata[ $idx ]['id'] = (int) $item['tour_marker_id'];
        $tour_metadata[ $idx ]['title'] = $popupHeading ?: get_the_title( $item['tour_marker_id'] );
        $tour_metadata[ $idx ]['geo']['lat'] = twer_get_data( $item['tour_marker_id'] )->marker_latlng[0];
        $tour_metadata[ $idx ]['geo']['lang'] = twer_get_data( $item['tour_marker_id'] )->marker_latlng[1];
        $tour_metadata[ $idx ]['geo']['str'] = "[" . twer_get_data( $item['tour_marker_id'] )->marker_latlng[1] . "," . twer_get_data( $item['tour_marker_id'] )->marker_latlng[0] . "]";
        $tour_metadata[ $idx ]['zoom'] = $marker_zoom;
        $tour_metadata[ $idx ]['bearing'] = $adv_s ? $item['tour_marker_bearing'] : $marker_bearing_parent;
        $tour_metadata[ $idx ]['pitch'] = $adv_s ? $item['tour_marker_pitch'] : $marker_pitch_parent;
        $tour_metadata[ $idx ]['flySpeed'] = $adv_s ? ( $item['tour_fly_speed'] ?: '1.2' ) : ( $map_fly_speed_parent ?: '1.2' );
        $tour_metadata[ $idx ]['flyCurve'] = $adv_s ? ( $item['tour_fly_curve'] ?: '1.42' ) : ( $map_fly_curve_parent ?: '1.42' );

        if ( $adv_s ) {

          if ( ! empty( $item['tour_offset'] ) ) {
            foreach ( $item['tour_offset'] as $key => $offset ) {
              if ( ! is_numeric( $offset ) && empty( $offset ) ) {
                $item['tour_offset'][ $key ] = '0';
              }
            }
          }
          $tour_metadata[ $idx ]['tourOffsets'] = $item['tour_offset'];
        } else {
          foreach ( $tour_offset_parent as $key => $offset ) {
            if ( ! is_numeric( $offset ) && empty( $offset ) ) {
              $tour_offset_parent[ $key ] = '0';
            }
          }
          $tour_metadata[ $idx ]['tourOffsets'] = $tour_offset_parent;
        }

        $tour_metadata[ $idx ]['showPopUp'] = in_array( 'tour_marker_popup',
          (array) $item['tour_marker_popup'] );
        $tour_metadata[ $idx ]['popupDefault'] = in_array( 'open_default',
          (array) twer_get_data( $item['tour_marker_id'] )->popup_open_group['open_default'] );
        $tour_metadata[ $idx ]['advanced_settings'] = (bool) $adv_s;
        $idx ++;

      }
    }

    return $tour_metadata;
  }


  public static function tourWidgetElement( $arrows_position, $start_message, $tour_number ) { ?>
      <div class="tour-row tr-<?php echo esc_attr( str_ireplace( '_', '-', $arrows_position ) ); ?>">
        <?php // if(!empty(trim($start_message)) ) { ?>
          <div class="text-label <?php echo empty( trim( $start_message ) ) ? 'only-numbers' : ''; ?> <?php echo esc_attr( $tour_number ? 'twer-tour-number-container-js ' : ' ' ); ?>">
              <div class="twer-label__inner">
                <?php if ( $tour_number ): ?>
                    <div class="twer-tour-number">01/08</div>
                    <div class="twer-tour-number-label"><?php echo esc_attr( $start_message ?? esc_html__( 'USE BUTTONS TO START A TOUR',
                        'treweler' ) ); ?></div>
                <?php else: echo esc_attr( $start_message ); endif; ?>
              </div>
          </div>
        <?php // } ?>

          <div class="arrow-btn">
              <button type="button" class="btn-tour btn-tour-left" id="btn-tour-left"></button>
              <button type="button" class="btn-tour btn-tour-right" id="btn-tour-right"></button>
          </div>
      </div>
    <?php
  }
}

TWER_Screen_Map::init();
