<?php
function getCategoriesSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );

  return [
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'category_filter',
      'label' => esc_html__( 'Show Category Filter', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'category_filter',
            isset( $meta_data->category_filter ) ? (array) $meta_data->category_filter : [] ),
          'value'   => 'category_filter'
        ]
      ]
    ],
    [
      'type'  => 'select',
      'name'  => $prefix . 'category_position',
      'label' => esc_html__( 'Position', 'treweler' ),
      'id'    => 'twer-category-position',
      'value' => [
        [
          'value'    => 'top-left',
          'label'    => esc_html__( 'Top Left', 'treweler' ),
          'selected' => in_array( 'top-left',
            isset( $meta_data->category_position ) ? (array) $meta_data->category_position : [ 'top-left' ] )
        ],
        [
          'value'    => 'top-right',
          'label'    => esc_html__( 'Top Right', 'treweler' ),
          'selected' => in_array( 'top-right',
            isset( $meta_data->category_position ) ? (array) $meta_data->category_position : [] )
        ],
        [
          'value'    => 'bottom-left',
          'label'    => esc_html__( 'Bottom Left', 'treweler' ),
          'selected' => in_array( 'bottom-left',
            isset( $meta_data->category_position ) ? (array) $meta_data->category_position : [] )
        ],
        [
          'value'    => 'bottom-right',
          'label'    => esc_html__( 'Bottom Right', 'treweler' ),
          'selected' => in_array( 'bottom-right',
            isset( $meta_data->category_position ) ? (array) $meta_data->category_position : [] )
        ]
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'show_uncategorized',
      'label' => esc_html__( 'Show Uncategorized', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'show_uncategorized',
            isset( $meta_data->show_uncategorized ) ? (array) $meta_data->show_uncategorized : [ 'show_uncategorized' ] ),
          'value'   => 'show_uncategorized'
        ]
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'fitbounds',
      'label' => esc_html__( 'Fit Bounds', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'fitbounds',
            isset( $meta_data->fitbounds ) ? (array) $meta_data->fitbounds : [ 'fitbounds' ] ),
          'value'   => 'fitbounds'
        ]
      ]
    ],
  ];
}
