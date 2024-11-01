<?php

function getMarkerGeneralSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;


  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );


  $template_data = [];
  $current_template = isset( $meta_data->templates ) ? $meta_data->templates : 'none';
  if ( 'none' !== $current_template && ! empty( $current_template ) ) {
    $template_data = template_meta_diff( twer_get_data( $current_template ) );
  }

  return template_apply( [
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'marker_enable_clustering',
      'label' => esc_html__( 'Enable Clustering', 'treweler' ),
      'isPro' => TWER_IS_FREE,
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'marker_enable_clustering',
            isset( $meta_data->marker_enable_clustering ) ? (array) $meta_data->marker_enable_clustering : [ 'marker_enable_clustering' ] ),
          'value'   => 'marker_enable_clustering'
        ]
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'marker_enable_center_on_click',
      'label' => esc_html__( 'Center On Click', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'marker_enable_center_on_click',
            isset( $meta_data->marker_enable_center_on_click ) ? (array) $meta_data->marker_enable_center_on_click : [ 'marker_enable_center_on_click' ] ),
          'value'   => 'marker_enable_center_on_click'
        ]
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'marker_hide_in_locator',
      'label' => esc_html__( 'Hide in Locator', 'treweler' ),
      'isPro' => TWER_IS_FREE,
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'marker_hide_in_locator',
            isset( $meta_data->marker_hide_in_locator ) ? (array) $meta_data->marker_hide_in_locator : [] ),
          'value'   => 'marker_hide_in_locator'
        ]
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'marker_ignore_filters',
      'label' => esc_html__( 'Ignore Filters', 'treweler' ),
      'isPro' => TWER_IS_FREE,
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'marker_ignore_filters',
            isset( $meta_data->marker_ignore_filters ) ? (array) $meta_data->marker_ignore_filters : [] ),
          'value'   => 'marker_ignore_filters'
        ]
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'marker_ignore_radius_filter',
      'label' => esc_html__( 'Ignore Radius Filter', 'treweler' ),
      'isPro' => TWER_IS_FREE,
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'marker_ignore_radius_filter',
            isset( $meta_data->marker_ignore_radius_filter ) ? (array) $meta_data->marker_ignore_radius_filter : [] ),
          'value'   => 'marker_ignore_radius_filter'
        ]
      ]
    ],
    [
      'type'  => 'group',
      'name'  => $prefix . 'marker_click_offset',
      'label' => esc_html__( 'Marker Offset', 'treweler' ),
      'value' => [

        [
          'type'        => 'text',
          'name'        => 'top',
          'postfix'     => 'px',
          'group_class'        => 'col-fixed col-fixed--130',
          'placeholder' => '0',
          'label'       => esc_html__( 'Top', 'treweler' ),
          'value'       => isset( $meta_data->marker_click_offset['top'] ) ? $meta_data->marker_click_offset['top'] : ''
        ],
        [
          'type'        => 'text',
          'name'        => 'bottom',
          'postfix'     => 'px',
          'group_class'        => 'col-fixed col-fixed--130',
          'placeholder' => '0',
          'label'       => esc_html__( 'Bottom', 'treweler' ),
          'value'       => isset( $meta_data->marker_click_offset['bottom'] ) ? $meta_data->marker_click_offset['bottom'] : ''
        ],
        [
          'type'        => 'text',
          'name'        => 'left',
          'postfix'     => 'px',
          'group_class'        => 'col-fixed col-fixed--130',
          'placeholder' => '0',
          'label'       => esc_html__( 'Left', 'treweler' ),
          'value'       => isset( $meta_data->marker_click_offset['left'] ) ? $meta_data->marker_click_offset['left'] : ''
        ],
        [
          'type'        => 'text',
          'name'        => 'right',
          'postfix'     => 'px',
          'group_class'        => 'col-fixed col-fixed--130',
          'placeholder' => '0',
          'label'       => esc_html__( 'Right', 'treweler' ),
          'value'       => isset( $meta_data->marker_click_offset['right'] ) ? $meta_data->marker_click_offset['right'] : ''
        ],

      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'marker_open_link_by_click',
      'label' => esc_html__( 'Open Link On Click', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'marker_open_link_by_click',
            isset( $meta_data->marker_open_link_by_click ) ? (array) $meta_data->marker_open_link_by_click : [] ),
          'value'   => 'marker_open_link_by_click'
        ]
      ]
    ],
    [
      'type'  => 'group',
      'name'  => $prefix . 'marker_link',
      'row_class' => 'row align-items-center',
      'label' => esc_html__( 'Link', 'treweler' ),
      'value' => [
        [
          'type'        => 'text',
          'name'        => 'url',
          'placeholder' => esc_html__( 'URL', 'treweler' ),
          'value'       => isset( $meta_data->marker_link['url'] ) ? $meta_data->marker_link['url'] : ''
        ],
        [
          'type'  => 'checkbox',
          'name'  => 'target',
          'label_inline' => esc_html__( 'Open in new tab', 'treweler' ),
          'value' => [
            [
              'label' => '',
              'checked' => in_array( 'target',
                isset( $meta_data->marker_link['target'] ) ? (array) $meta_data->marker_link['target'] : [] ),
              'value'   => 'target'
            ]
          ]
        ],
      ],
      'toggle-row' => [ 'related' => 'treweler-marker-open-link-by-click', 'value' => true ]
    ],
  ], $meta_data, $template_data );
}


