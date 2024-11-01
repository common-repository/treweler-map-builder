<?php
function getClusteringSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );

  return [
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'map_enable_clustering',
      'label' => esc_html__( 'Enable Clustering', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'map_enable_clustering',
            isset( $meta_data->map_enable_clustering ) ? (array) $meta_data->map_enable_clustering : [ 'map_enable_clustering' ] ),
          'value'   => 'map_enable_clustering'
        ]
      ]
    ],
    [
      'type'  => 'colorpicker',
      'name'  => $prefix . 'map_cluster_color',
      'id'    => 'twer-map-cluster-color',
      'label' => esc_html__( 'Cluster Color', 'treweler' ),
      'value' => isset( $meta_data->map_cluster_color ) ? $meta_data->map_cluster_color : '#4b7715'
    ],
    [
      'type'        => 'text',
      'name'        => $prefix . 'map_cluster_max_zoom',
      'size'        => 'small',
      'label'       => esc_html__( 'Clustering Max Zoom', 'treweler' ),
      'value'       => isset( $meta_data->map_cluster_max_zoom ) ? $meta_data->map_cluster_max_zoom : '',
      'placeholder' => '14'
    ],
  ];
}
