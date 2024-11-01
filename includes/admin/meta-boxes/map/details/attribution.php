<?php
function getAttributionSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );

  return [
    [
      'type'  => 'select',
      'name'  => $prefix . 'wordmark_position',
      'label' => esc_html__( 'Wordmark position', 'treweler' ),
      'id'    => 'twer-wordmark-position',
      'value' => [
        [
          'value'    => 'top-left',
          'label'    => esc_html__( 'Top Left', 'treweler' ),
          'selected' => in_array( 'top-left',
            isset( $meta_data->wordmark_position ) ? (array) $meta_data->wordmark_position : [] )
        ],
        [
          'value'    => 'top-right',
          'label'    => esc_html__( 'Top Right', 'treweler' ),
          'selected' => in_array( 'top-right',
            isset( $meta_data->wordmark_position ) ? (array) $meta_data->wordmark_position : [] )
        ],
        [
          'value'    => 'bottom-left',
          'label'    => esc_html__( 'Bottom Left', 'treweler' ),
          'selected' => in_array( 'bottom-left',
            isset( $meta_data->wordmark_position ) ? (array) $meta_data->wordmark_position : [ 'bottom-left' ] )
        ],
        [
          'value'    => 'bottom-right',
          'label'    => esc_html__( 'Bottom Right', 'treweler' ),
          'selected' => in_array( 'bottom-right',
            isset( $meta_data->wordmark_position ) ? (array) $meta_data->wordmark_position : [] )
        ],
      ]
    ],
    [
      'type'  => 'select',
      'name'  => $prefix . 'attribution_position',
      'label' => esc_html__( 'Attribution position', 'treweler' ),
      'id'    => 'twer-attribution-position',
      'value' => [
        [
          'value'    => 'top-left',
          'label'    => esc_html__( 'Top Left', 'treweler' ),
          'selected' => in_array( 'top-left',
            isset( $meta_data->attribution_position ) ? (array) $meta_data->attribution_position : [] )
        ],
        [
          'value'    => 'top-right',
          'label'    => esc_html__( 'Top Right', 'treweler' ),
          'selected' => in_array( 'top-right',
            isset( $meta_data->attribution_position ) ? (array) $meta_data->attribution_position : [] )
        ],
        [
          'value'    => 'bottom-left',
          'label'    => esc_html__( 'Bottom Left', 'treweler' ),
          'selected' => in_array( 'bottom-left',
            isset( $meta_data->attribution_position ) ? (array) $meta_data->attribution_position : [] )
        ],
        [
          'value'    => 'bottom-right',
          'label'    => esc_html__( 'Bottom Right', 'treweler' ),
          'selected' => in_array( 'bottom-right',
            isset( $meta_data->attribution_position ) ? (array) $meta_data->attribution_position : [ 'bottom-right' ] )
        ],
      ]
    ],


    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'compact_attribution',
      'id'    => 'twer-compact-attribution',
      'label' => esc_html__( 'Compact attribution', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'compact_attribution',
            isset( $meta_data->compact_attribution ) ? (array) $meta_data->compact_attribution : [ 'compact_attribution' ] ),
          'value'   => 'compact_attribution'
        ]
      ]
    ],
  ];
}
