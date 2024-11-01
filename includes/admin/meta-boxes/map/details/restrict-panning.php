<?php

function getRestrictPanningSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );

  return [
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'disable_drag_pan',
      'label' => esc_html__( 'Disable Drag Pan', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'disable_drag_pan',
            isset( $meta_data->disable_drag_pan ) ? (array) $meta_data->disable_drag_pan : [] ),
          'value'   => 'disable_drag_pan'
        ]
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'restrict_panning',
      'label' => esc_html__( 'Enable Restrict Panning', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'restrict_panning',
            isset( $meta_data->restrict_panning ) ? (array) $meta_data->restrict_panning : [] ),
          'value'   => 'restrict_panning'
        ]
      ]
    ],
    [
      'type'  => 'group',
      'name'  => $prefix . 'restrict_panning_southwest',
      'label' => esc_html__( 'Southwest', 'treweler' ),
      'value' => [
        [
          'type'        => 'text',
          'name'        => 'lat',
          'size'        => 'small',
          'placeholder' => esc_html__( 'Latitude', 'treweler' ),
          'label'       => '',
          'value'       => isset( $meta_data->restrict_panning_southwest['lat'] ) ? $meta_data->restrict_panning_southwest['lat'] : ''
        ],
        [
          'type'        => 'text',
          'name'        => 'lon',
          'size'        => 'small',
          'placeholder' => esc_html__( 'Longitude', 'treweler' ),
          'label'       => '',
          'value'       => isset( $meta_data->restrict_panning_southwest['lon'] ) ? $meta_data->restrict_panning_southwest['lon'] : ''
        ],
      ]
    ],
    [
      'type'  => 'group',
      'name'  => $prefix . 'restrict_panning_northeast',
      'label' => esc_html__( 'Northeast', 'treweler' ),
      'value' => [
        [
          'type'        => 'text',
          'name'        => 'lat',
          'size'        => 'small',
          'placeholder' => esc_html__( 'Latitude', 'treweler' ),
          'label'       => '',
          'value'       => isset( $meta_data->restrict_panning_northeast['lat'] ) ? $meta_data->restrict_panning_northeast['lat'] : ''
        ],
        [
          'type'        => 'text',
          'name'        => 'lon',
          'size'        => 'small',
          'placeholder' => esc_html__( 'Longitude', 'treweler' ),
          'label'       => '',
          'value'       => isset( $meta_data->restrict_panning_northeast['lon'] ) ? $meta_data->restrict_panning_northeast['lon'] : ''
        ],
      ]
    ],
  ];
}
