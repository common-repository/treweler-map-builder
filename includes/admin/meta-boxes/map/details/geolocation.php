<?php
function getGeolocationSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );

  $geoPositionValue = isset( $meta_data->map_initial_point['geoposition'] ) ? $meta_data->map_initial_point['geoposition'] : '';

  if ( is_array( $geoPositionValue ) ) {
    $geoPositionValue = reset( $geoPositionValue );
  }


  $map_user_location_marker_templates = [
    [
      'label'    => esc_html__( 'Select a Template', 'treweler' ),
      'selected' => in_array( 'none',
        isset( $meta_data->map_user_location_marker_template ) ? (array) $meta_data->map_user_location_marker_template : [ 'none' ] ),
      'value'    => 'none'
    ],
    [
      'label'    => esc_html__( 'Mapbox Location Dot', 'treweler' ),
      'selected' => in_array( 'default',
        isset( $meta_data->map_user_location_marker_template ) ? (array) $meta_data->map_user_location_marker_template : [ ] ),
      'value'    => 'default'
    ],
  ];

  $cpt_templates = get_posts( [
    'post_status'    => 'publish',
    'post_type'      => 'twer-templates',
    'numberposts'    => - 1,
    'posts_per_page' => - 1,
    'order'          => 'ASC',
  ] );

  if ( ! empty( $cpt_templates ) ) {
    foreach ( $cpt_templates as $template ) {
      $template_id = isset( $template->ID ) ? $template->ID : 0;
      $template_label = isset( $template->post_title ) ? $template->post_title : esc_html__( 'Template', 'treweler' );
      $template_selected = in_array( $template_id, isset( $meta_data->map_user_location_marker_template ) ? (array) $meta_data->map_user_location_marker_template : [] );



      $map_user_location_marker_templates[] = [
        'label'    => $template_label,
        'selected' => $template_selected,
        'value'    => $template_id
      ];
    }
  }

  return [
    [
      'type'  => 'group',
      'name'  => $prefix . 'map_initial_point',
      'label' => esc_html__( 'Show User Location', 'treweler' ),
      'value' => [
        [
          'type'  => 'checkbox',
          'name'  => 'geoposition',
          'value' => [
            [
              'label'   => '',
              'checked' => ! empty( $geoPositionValue ) ? true : false,
              'value'   => 'geoposition'
            ]
          ]
        ],
      ]
    ],
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'map_center_geolocation_on_load',
      'label' => esc_html__( 'Center Map On Load', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'map_center_geolocation_on_load',
            isset( $meta_data->map_center_geolocation_on_load ) ? (array) $meta_data->map_center_geolocation_on_load : [ 'map_center_geolocation_on_load' ] ),
          'value'   => 'map_center_geolocation_on_load'
        ]
      ]
    ],
    [
      'type'  => 'select',
      'name'  => $prefix . 'map_user_location_marker_template',
      'label' => esc_html__( 'Geolocation Marker Template', 'treweler' ),
      'value' => $map_user_location_marker_templates
    ],
  ];
}
