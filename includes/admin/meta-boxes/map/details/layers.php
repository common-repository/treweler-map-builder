<?php
function getLayerSettings() {
	global $post;
	$post_id = isset( $post->ID ) ? $post->ID : 0;

	$prefix    = '_treweler_';
	$meta_data = twer_get_data( $post_id );

  $layersData = [
    [ 'label' => esc_html__( 'Boundaries', 'treweler' ), 'name' => 'boundaries' ],
    [ 'label' => esc_html__( 'Place Labels', 'treweler' ), 'name' => 'place_labels' ],
    [ 'label' => esc_html__( 'Points Of Interest', 'treweler' ), 'name' => 'points_of_interest' ],
    [ 'label' => esc_html__( 'Natural Features', 'treweler' ), 'name' => 'natural_features' ],
    [ 'label' => esc_html__( 'Transit Labels', 'treweler' ), 'name' => 'transit_labels' ],
    [ 'label' => esc_html__( 'Transit', 'treweler' ), 'name' => 'transit' ],
    [ 'label' => esc_html__( 'Building Labels', 'treweler' ), 'name' => 'building_labels' ],
    [ 'label' => esc_html__( 'Buildings', 'treweler' ), 'name' => 'buildings' ],
    [ 'label' => esc_html__( 'Pedestrian Labels', 'treweler' ), 'name' => 'pedestrian_labels' ],
    [ 'label' => esc_html__( 'Pedestrian Roads', 'treweler' ), 'name' => 'pedestrian_roads' ],
    [ 'label' => esc_html__( 'Road Labels', 'treweler' ), 'name' => 'road_labels' ],
    [ 'label' => esc_html__( 'Roads', 'treweler' ), 'name' => 'roads' ],
    [ 'label' => esc_html__( 'Contour Lines', 'treweler' ), 'name' => 'contour_lines' ],
    [ 'label' => esc_html__( 'Hillshade', 'treweler' ), 'name' => 'hillshade' ],
    [ 'label' => esc_html__( 'Land Structure', 'treweler' ), 'name' => 'land_structure' ],
    [ 'label' => esc_html__( 'Water Depth', 'treweler' ), 'name' => 'water_depth' ],
  ];

  $layerOptions = [];
  foreach ($layersData as $layerOption) {
    $layerOptions[] = [
      'type'  => 'group',
      'name'  => $prefix . 'map_layers',
      'label' => $layerOption['label'],
      'value' => [
        [
          'type'  => 'checkbox',
          'name'  => $layerOption['name'],
          'class' => 'col-fixed col-fixed--90',
          'value' => [
            [
              'label'   => '',
              'checked' => in_array( $layerOption['name'],
                isset( $meta_data->map_layers[$layerOption['name']] ) ? (array) $meta_data->map_layers[$layerOption['name']] : [$layerOption['name']] ),
              'value'   => $layerOption['name']
            ]
          ]
        ],
      ]
    ];
  }

	return $layerOptions;
}
