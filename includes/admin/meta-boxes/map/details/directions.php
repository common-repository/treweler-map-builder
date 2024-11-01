<?php
function getDirectionsSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );

  return [
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'enable_directions',
      'label' => esc_html__( 'Enable Directions', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'enable_directions',
            isset( $meta_data->enable_directions ) ? (array) $meta_data->enable_directions : [] ),
          'value'   => 'enable_directions'
        ]
      ]
    ],
    [
      'type'  => 'select',
      'name'  => $prefix . 'directions_routing_profile',
      'label' => esc_html__( 'Routing Profile', 'treweler' ),
      'value' => [
        [
          'value'    => 'driving-traffic',
          'label'    => esc_html__( 'Traffic', 'treweler' ),
          'selected' => in_array( 'driving-traffic',
            isset( $meta_data->directions_routing_profile ) ? (array) $meta_data->directions_routing_profile : [ 'driving-traffic' ] )
        ],
        [
          'value'    => 'driving',
          'label'    => esc_html__( 'Driving', 'treweler' ),
          'selected' => in_array( 'driving',
            isset( $meta_data->directions_routing_profile ) ? (array) $meta_data->directions_routing_profile : [] )
        ],
        [
          'value'    => 'walking',
          'label'    => esc_html__( 'Walking', 'treweler' ),
          'selected' => in_array( 'walking',
            isset( $meta_data->directions_routing_profile ) ? (array) $meta_data->directions_routing_profile : [] )
        ],
        [
          'value'    => 'cycling',
          'label'    => esc_html__( 'Cycling', 'treweler' ),
          'selected' => in_array( 'cycling',
            isset( $meta_data->directions_routing_profile ) ? (array) $meta_data->directions_routing_profile : [] )
        ]
      ]
    ],
    [
      'type'  => 'select',
      'name'  => $prefix . 'directions_reset_position',
      'label' => esc_html__( 'Reset Icon Position', 'treweler' ),
      'value' => [
        [
          'value'    => 'top-left',
          'label'    => esc_html__( 'Top Left', 'treweler' ),
          'selected' => in_array( 'top-left',
            isset( $meta_data->directions_reset_position ) ? (array) $meta_data->directions_reset_position : [ 'top-left' ] )
        ],
        [
          'value'    => 'top-right',
          'label'    => esc_html__( 'Top Right', 'treweler' ),
          'selected' => in_array( 'top-right',
            isset( $meta_data->directions_reset_position ) ? (array) $meta_data->directions_reset_position : [] )
        ],
        [
          'value'    => 'bottom-left',
          'label'    => esc_html__( 'Bottom Left', 'treweler' ),
          'selected' => in_array( 'bottom-left',
            isset( $meta_data->directions_reset_position ) ? (array) $meta_data->directions_reset_position : [] )
        ],
        [
          'value'    => 'bottom-right',
          'label'    => esc_html__( 'Bottom Right', 'treweler' ),
          'selected' => in_array( 'bottom-right',
            isset( $meta_data->directions_reset_position ) ? (array) $meta_data->directions_reset_position : [] )
        ]
      ]
    ],
    [
      'type'  => 'select',
      'name'  => $prefix . 'directions_start_marker',
      'label' => esc_html__( 'Start Direction Marker', 'treweler' ),
      'value' => [
        [
          'value'    => 'user-geolocation',
          'label'    => esc_html__( 'User Geolocation', 'treweler' ),
          'selected' => in_array( 'user-geolocation',
            isset( $meta_data->directions_start_marker ) ? (array) $meta_data->directions_start_marker : [ 'user-geolocation' ] )
        ],
        [
          'value'    => 'manual-location',
          'label'    => esc_html__( 'Manual Location', 'treweler' ),
          'selected' => in_array( 'manual-location',
            isset( $meta_data->directions_start_marker ) ? (array) $meta_data->directions_start_marker : [] )
        ],
      ]
    ],
  ];
}
