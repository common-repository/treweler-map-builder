<?php
/**
 * Map Settings
 * Display the Map Settings meta box.
 *
 * @author      Aisconverse
 * @category    Admin
 * @package     Treweler/Admin/Meta Boxes
 * @version     1.13
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( class_exists( 'TWER_Meta_Box_Map_Settings', false ) ) {
  return;
}

if ( ! class_exists( 'TWER_Meta_Boxes', false ) ) {
  include_once 'abstract-class-twer-meta-boxes.php';
}

/**
 * TWER_Meta_Box_Map_Settings Class.
 */
class TWER_Meta_Box_Map_Settings extends TWER_Meta_Boxes {

  protected $metabox = 'twer-map-settings';

  protected function setNestedFields() {

  }
  protected function setNestedTabs() {
  }

  protected function set_tabs() {
  }

  protected function set_fields() {
	 $defaultMapBoxStyle = twerGetDefaultMapStyle();

    $this->fields = [
      [
        'type'        => 'select',
        'name'        => 'map_styles',
        'id'          => 'map_styles',
        'group_class' => 'form-group col-12',
        'label'       => esc_html__( 'Styles', 'treweler' ),
        'options'     => [
          "mapbox://styles/mapbox/streets-v12"                  => esc_html__( 'Streets', 'treweler' ),
	        "mapbox://styles/mapbox/outdoors-v12"                 => esc_html__( 'Outdoors', 'treweler' ),
	        "mapbox://styles/mapbox/light-v11"                    => esc_html__( 'Streets Light', 'treweler' ),
	        "mapbox://styles/mapbox/dark-v11"                     => esc_html__( 'Streets Dark', 'treweler' ),
          $defaultMapBoxStyle => esc_html__( 'Standard', 'treweler' ),
	        "mapbox://styles/mapbox/satellite-v9"                 => esc_html__( 'Satellite', 'treweler' ),
	        "mapbox://styles/mapbox/satellite-streets-v12"        => esc_html__( 'Satellite Streets', 'treweler' ),
	        "mapbox://styles/mapbox/navigation-day-v1"            => esc_html__( 'Navigation Day', 'treweler' ),
	        "mapbox://styles/mapbox/navigation-night-v1"          => esc_html__( 'Navigation Night', 'treweler' ),
	        "mapbox://styles/mapbox/navigation-guidance-day-v4"   => esc_html__( 'Navigations Guidance Day', 'treweler' ),
	        "mapbox://styles/mapbox/navigation-guidance-night-v4" => esc_html__( 'Navigations Guidance Night', 'treweler' ),
        ],
        'selected'    => 'mapbox://styles/mapbox/streets-v12'
      ],
	    [
		    'type'        => 'select',
		    'name'        => 'map_light_preset',
		    'group_class' => 'form-group col-12',
		    'options'     => [
			    'day'   => esc_html__( 'Day', 'treweler' ),
			    'night' => esc_html__( 'Night', 'treweler' ),
			    'dusk'   => esc_html__( 'Dusk', 'treweler' ),
			    'dawn'  => esc_html__( 'Dawn', 'treweler' ),
		    ],
		    'selected'    => 'day'
	    ],
      [
        'type'        => 'text',
        'name'        => 'map_custom_style',
        'id'          => 'custom_style',
        'group_class' => 'form-group col-12',
        'label'       => esc_html__( 'Custom Style', 'treweler' ),
        'placeholder' => 'E.g. mapbox://styles/username/*',
        'value'       => ''
      ],
      [
        'type'  => 'group',
        'name'  => 'map_initial_point',
        'label' => esc_html__( 'Initial Point', 'treweler' ),
        'group' => [
          [
            'type'        => 'number',
            'name'        => 'lat',
            'id'          => 'latitude',
            'atts'        => [ 'min="-85"', 'max="85"', 'step=".00000000000000001"' ],
            'group_class' => 'form-group col-12',
            'value'       => '0',
            'placeholder' => esc_html__( 'Latitude', 'treweler' )
          ],
          [
            'type'        => 'number',
            'name'        => 'lon',
            'id'          => 'longitude',
            'group_class' => 'form-group col-12',
            'atts'        => [ 'min="-180"', 'max="180"', 'step=".00000000000000001"' ],
            'value'       => '0',
            'placeholder' => esc_html__( 'Longitude', 'treweler' )
          ],
          [
            'type'         => 'checkbox',
            'name'         => 'latlng_prev',
            'id'           => 'latlng_map_prev',
            'group_class'  => 'form-group col-12',
            'style'        => 'default',
            'label_inline' => esc_html__( 'Use the map preview', 'treweler' ),
            'checked'      => true
          ],
        ]
      ],
      [
        'type'  => 'group',
        'name'  => 'map_zoom',
        'label' => esc_html__( 'Initial Zoom Level', 'treweler' ),
        'group' => [
          [
            'type'        => 'range',
            'name'        => 'level',
            'class'       => '',
            'id'          => 'setZoom_range',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"' ],
            'group_class' => 'form-group col d-flex flex-wrap align-items-center',
            'label'       => esc_html__( 'Initial Zoom Level', 'treweler' ),
            'value'       => '0'
          ],
          [
            'type'        => 'number',
            'name'        => 'number',
            'id'          => 'setZoom',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"' ],
            'group_class' => 'form-group col-80',
            'value'       => '0'
          ],
          [
            'type'         => 'checkbox',
            'name'         => 'zoom_prev',
            'id'           => 'zoom_map_prev',
            'group_class'  => 'form-group col-12',
            'style'        => 'default',
            'label_inline' => esc_html__( 'Use the map preview', 'treweler' ),
            'checked'      => true
          ],
        ]
      ],
      [
        'type'  => 'group',
        'name'  => 'map_zoom_range',
        'row_class' => 'twer-row js-twer-row twer-is-pro-field',
        'label' => esc_html__( 'Zoom Range', 'treweler' ),
        'group' => [
          [
            'type'        => 'range',
            'name'        => 'min_zoom',
            'id'          => 'setZoom_min_range',
            'class'       => 'lower-slider',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"' ],
            'group_class' => 'form-group col-12 d-flex flex-wrap align-items-center',
            'label'       => esc_html__( 'Min Zoom Level', 'treweler' ),
            'value'       => '0'
          ],
          [
            'type'        => 'range',
            'name'        => 'max_zoom',
            'id'          => 'setZoom_max_range',
            'class'       => 'upper-slider',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"' ],
            'group_class' => 'form-group col-12 d-flex flex-wrap align-items-center last-zoom-range',
            'label'       => esc_html__( 'Max Zoom Level', 'treweler' ),
            'value'       => '24'
          ],
          [
            'type'        => 'number',
            'name'        => 'number_min',
            'id'          => 'default_min_zoom',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"' ],
            'group_class' => 'form-group col-80',
            'value'       => '0'
          ],
          [
            'type'        => 'number',
            'name'        => 'number_max',
            'id'          => 'default_max_zoom',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"' ],
            'group_class' => 'form-group col-80',
            'value'       => '24'
          ],
        ]
      ],
      [
        'type'        => 'colorpicker',
        'name'        => 'bg_overlay',
        'row_class' => 'twer-row js-twer-row twer-is-pro-field',
        'group_class' => 'form-group col-auto',
        'label'       => esc_html__( 'Overlay Color', 'treweler' ),
        'id'          => 'overlay-style-map',
        'value'       => 'rgba(255,255,255,0)',
        'note'        => esc_html__( 'To load the map smoothly, use the preloader settings', 'treweler' )
      ],
      [
        'type'         => 'checkbox',
        'name'         => 'world_copy',
        'id'           => 'world_copy',
        'group_class'  => 'form-group col-auto twer-is-pro-field',
        'style'        => 'default',
        'label_inline' => esc_html__( 'Render world copies', 'treweler' ),
        'checked'      => true
      ],
      [
        'type'        => 'hidden',
        'row_class'  => 'form-group col-auto d-none',
        'name'        => 'noncefield',
        'value'       => '1'
      ],
    ];
  }

  /**
   * Constructor.
   */
  public function __construct() {
    parent::__construct();


    add_filter( $this->metabox . '_assign_fields', [ $this, 'add_old_capability' ], 10, 2 );
  }

  public function add_old_capability( $fields, $metabox ) {
    $post_id = get_the_ID();
    $post_meta_old = get_post_meta( $post_id );
	  $meta = twer_get_data();
	  $defaultMapStyle = twerGetDefaultMapStyle();
	  $mapStyle = $meta->map_styles ?? 'mapbox://styles/mapbox/streets-v12';
    $nonce = isset($post_meta_old['_treweler_noncefield'][0]) ? true : false;

    if(!$nonce) {
      $meta_data = twer_get_data( $post_id );
      $map_ll = isset( $post_meta_old["_treweler_map_latlng"] ) ? unserialize( $post_meta_old["_treweler_map_latlng"][0] ) : [];
      if ( ! empty( $map_ll ) ) {
        foreach ( $map_ll as $k => $v ) {
          ${"ll$k"} = $v;
        }
      }

      $ll0 = isset( $ll0 ) ? $ll0 : 0;
      $ll1 = isset( $ll1 ) ? $ll1 : 0;

      $prevVal = isset( $meta_data->map_latlng_prev ) ? $meta_data->map_latlng_prev : is_int( $post_id );
      if(is_array($prevVal)) {
        $prevVal = reset($prevVal);
      }


      $map_latlng_prev = checked( $prevVal, true, false );


      $map_zoom = isset( $post_meta_old["_treweler_map_zoom"] ) ? $post_meta_old["_treweler_map_zoom"][0] : 0;
      $map_min_zoom = isset( $post_meta_old["_treweler_map_min_zoom"] ) ? $post_meta_old["_treweler_map_min_zoom"][0] : 0;
      $map_max_zoom = isset( $post_meta_old["_treweler_map_max_zoom"] ) ? $post_meta_old["_treweler_map_max_zoom"][0] : 24;

      if(is_array(maybe_unserialize($map_zoom))) {
        $map_zoom = 0;
      }

      $map_zoom_prev = checked( isset( $meta_data->map_zoom_prev ) ? $meta_data->map_zoom_prev : is_int( $post_id ), true, false );

      $wcArr = isset( $meta_data->world_copy ) ? $meta_data->world_copy : is_int( $post_id );

      if(is_array($wcArr)) {
        $wcArr = reset($wcArr);
      }


      $world_copy = checked( $wcArr, true, false );

      foreach ( $fields as &$field ) {
        switch ( $field['name'] ) {
          case '_treweler_map_initial_point' :
            foreach ( $field['group'] as &$group ) {
              switch ( $group['name'] ) {
                case '_treweler_map_initial_point[lat]':
                  $group['value'] = $ll0;
                  break;
                case '_treweler_map_initial_point[lon]':
                  $group['value'] = $ll1;
                  break;
                case '_treweler_map_initial_point[latlng_prev]':
                  $group['checked'] = empty( $map_latlng_prev ) ? false : true;
                  break;
              }
            }
            unset( $group );
            break;

          case '_treweler_map_zoom' :
            foreach ( $field['group'] as &$group ) {
              switch ( $group['name'] ) {
                case '_treweler_map_zoom[level]':
                case '_treweler_map_zoom[number]':
                  $group['value'] = $map_zoom;
                  break;
                case '_treweler_map_zoom[zoom_prev]':
                  $group['checked'] = empty( $map_zoom_prev ) ? false : true;
                  break;
              }
            }
            unset( $group );
            break;
          case '_treweler_map_zoom_range' :
            foreach ( $field['group'] as &$group ) {
              switch ( $group['name'] ) {
                case '_treweler_map_zoom_range[min_zoom]':
                case '_treweler_map_zoom_range[number_min]' :
                  $group['value'] = $map_min_zoom;
                  break;
                case '_treweler_map_zoom_range[max_zoom]':
                case '_treweler_map_zoom_range[number_max]':
                  $group['value'] = $map_max_zoom;
                  break;
              }
            }
            unset( $group );
            break;
          case '_treweler_world_copy' :
            $group['checked'] = empty( $world_copy ) ? false : true;
            break;
        }
      }
      unset( $field );
    }


	  foreach ( $fields as &$field ) {
		  if ( $field['id'] === 'map_light_preset' ) {
			  if($mapStyle !== $defaultMapStyle) {
				  $field['row_class'] = implode( ' ', array_merge( [ $field['row_class'] ], [ 'd-none' ] ) );
			  }
		  }
	  }
		  unset( $field );
    return $fields;
  }

}
