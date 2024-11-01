<?php

function getLanguageSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );

  return [
    [
      'type'  => 'select',
      'name'  => $prefix . 'map_languanges',
      'label' => esc_html__( 'Languanges', 'treweler' ),
      'id'    => 'twer-map-languanges',
      'value' => [
        [
          'value'    => 'browser',
          'label'    => esc_html__( 'Browser Language', 'treweler' ),
          'selected' => in_array( 'browser',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [ 'browser' ] )
        ],
        [
          'value'    => 'mul',
          'label'    => esc_html__( 'Multilingual', 'treweler' ),
          'selected' => in_array( 'mul',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'ar',
          'label'    => esc_html__( 'Arabic', 'treweler' ),
          'selected' => in_array( 'ar',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'zh-Hans',
          'label'    => esc_html__( 'Chinese Simplified', 'treweler' ),
          'selected' => in_array( 'zh-Hans',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'zh-Hant',
          'label'    => esc_html__( 'Chinese Traditional', 'treweler' ),
          'selected' => in_array( 'zh-Hant',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'en',
          'label'    => esc_html__( 'English', 'treweler' ),
          'selected' => in_array( 'en',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'fr',
          'label'    => esc_html__( 'French', 'treweler' ),
          'selected' => in_array( 'fr',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'de',
          'label'    => esc_html__( 'German', 'treweler' ),
          'selected' => in_array( 'de',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'it',
          'label'    => esc_html__( 'Italian', 'treweler' ),
          'selected' => in_array( 'it',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'ja',
          'label'    => esc_html__( 'Japanese', 'treweler' ),
          'selected' => in_array( 'ja',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'ko',
          'label'    => esc_html__( 'Korean', 'treweler' ),
          'selected' => in_array( 'ko',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'pt',
          'label'    => esc_html__( 'Portuguese', 'treweler' ),
          'selected' => in_array( 'pt',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'ru',
          'label'    => esc_html__( 'Russian', 'treweler' ),
          'selected' => in_array( 'ru',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ],
        [
          'value'    => 'es',
          'label'    => esc_html__( 'Spanish', 'treweler' ),
          'selected' => in_array( 'es',
            isset( $meta_data->map_languanges ) ? (array) $meta_data->map_languanges : [] )
        ]
      ],
      'help'  => esc_html__( 'Language settings are not fully supported for Standard, Streets, Outdoors, Satellite and custom styles.',
        'treweler' )
    ],
  ];
}
