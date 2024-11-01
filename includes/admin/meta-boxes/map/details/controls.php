<?php
function getControlsSettings() {
	global $post;
	$post_id = isset( $post->ID ) ? $post->ID : 0;

	$prefix    = '_treweler_';
	$meta_data = twer_get_data( $post_id );

	return [
		[
			'type'  => 'group',
			'name'  => $prefix . 'map_controls',
			'label' => esc_html__( 'Distance Scale', 'treweler' ),
			'value' => [
				[
					'type'  => 'checkbox',
					'name'  => 'distance_scale',
					'class' => 'col-fixed col-fixed--90',
					'value' => [
						[
							'label'   => '',
							'checked' => in_array( 'distance_scale',
								isset( $meta_data->map_controls['distance_scale'] ) ? (array) $meta_data->map_controls['distance_scale'] : [] ),
							'value'   => 'distance_scale'
						]
					]
				],
				[
					'type'  => 'select',
					'name'  => 'distance_position',
					'class' => 'col-fixed col-fixed--150',
					'value' => [
						[
							'label'    => esc_html__( 'Top Left', 'treweler' ),
							'selected' => in_array( 'top-left',
								isset( $meta_data->map_controls['distance_position'] ) ? (array) $meta_data->map_controls['distance_position'] : [] ),
							'value'    => 'top-left'
						],
						[
							'label'    => esc_html__( 'Top Right', 'treweler' ),
							'selected' => in_array( 'top-right',
								isset( $meta_data->map_controls['distance_position'] ) ? (array) $meta_data->map_controls['distance_position'] : [] ),
							'value'    => 'top-right'
						],
						[
							'label'    => esc_html__( 'Bottom Left', 'treweler' ),
							'selected' => in_array( 'bottom-left',
								isset( $meta_data->map_controls['distance_position'] ) ? (array) $meta_data->map_controls['distance_position'] : [] ),
							'value'    => 'bottom-left'
						],
						[
							'label'    => esc_html__( 'Bottom Right', 'treweler' ),
							'selected' => in_array( 'bottom-right',
								isset( $meta_data->map_controls['distance_position'] ) ? (array) $meta_data->map_controls['distance_position'] : [ 'bottom-right' ] ),
							'value'    => 'bottom-right'
						],
					]
				],
        [
          'type'  => 'select',
          'name'  => 'distance_unit',
          'class' => 'col-fixed col-fixed--150',
          'value' => [
            [
              'label'    => esc_html__( 'Imperial', 'treweler' ),
              'selected' => in_array( 'imperial',
                isset( $meta_data->map_controls['distance_unit'] ) ? (array) $meta_data->map_controls['distance_unit'] : ['imperial'] ),
              'value'    => 'imperial'
            ],
            [
              'label'    => esc_html__( 'Metric', 'treweler' ),
              'selected' => in_array( 'metric',
                isset( $meta_data->map_controls['distance_unit'] ) ? (array) $meta_data->map_controls['distance_unit'] : [ ] ),
              'value'    => 'metric'
            ],
            [
              'label'    => esc_html__( 'Nautical', 'treweler' ),
              'selected' => in_array( 'nautical',
                isset( $meta_data->map_controls['distance_unit'] ) ? (array) $meta_data->map_controls['distance_unit'] : [ ] ),
              'value'    => 'nautical'
            ],
          ]
        ],
			]
		],
		[
			'type'  => 'group',
			'name'  => $prefix . 'map_controls',
			'label' => esc_html__( 'Fullscreen', 'treweler' ),
			'value' => [
				[
					'type'  => 'checkbox',
					'name'  => 'fullscreen',
					'class' => 'col-fixed col-fixed--90',
					'value' => [
						[
							'label'   => '',
							'checked' => in_array( 'fullscreen',
								isset( $meta_data->map_controls['fullscreen'] ) ? (array) $meta_data->map_controls['fullscreen'] : [] ),
							'value'   => 'fullscreen'
						]
					]
				],
				[
					'type'  => 'select',
					'name'  => 'fullscreen_position',
					'class' => 'col-fixed col-fixed--150',
					'value' => [
						[
							'label'    => esc_html__( 'Top Left', 'treweler' ),
							'selected' => in_array( 'top-left',
								isset( $meta_data->map_controls['fullscreen_position'] ) ? (array) $meta_data->map_controls['fullscreen_position'] : [] ),
							'value'    => 'top-left'
						],
						[
							'label'    => esc_html__( 'Top Right', 'treweler' ),
							'selected' => in_array( 'top-right',
								isset( $meta_data->map_controls['fullscreen_position'] ) ? (array) $meta_data->map_controls['fullscreen_position'] : [ 'top-right' ] ),
							'value'    => 'top-right'
						],
						[
							'label'    => esc_html__( 'Bottom Left', 'treweler' ),
							'selected' => in_array( 'bottom-left',
								isset( $meta_data->map_controls['fullscreen_position'] ) ? (array) $meta_data->map_controls['fullscreen_position'] : [] ),
							'value'    => 'bottom-left'
						],
						[
							'label'    => esc_html__( 'Bottom Right', 'treweler' ),
							'selected' => in_array( 'bottom-right',
								isset( $meta_data->map_controls['fullscreen_position'] ) ? (array) $meta_data->map_controls['fullscreen_position'] : [] ),
							'value'    => 'bottom-right'
						],
					]
				],
			]
		],
		[
			'type'  => 'group',
			'name'  => $prefix . 'map_controls',
			'label' => esc_html__( 'Search', 'treweler' ),
			'value' => [
				[
					'type'  => 'checkbox',
					'name'  => 'search',
					'class' => 'col-fixed col-fixed--90',
					'value' => [
						[
							'label'   => '',
							'checked' => in_array( 'search',
								isset( $meta_data->map_controls['search'] ) ? (array) $meta_data->map_controls['search'] : [] ),
							'value'   => 'search'
						]
					]
				],
				[
					'type'  => 'select',
					'name'  => 'search_position',
					'class' => 'col-fixed col-fixed--150',
					'value' => [
						[
							'label'    => esc_html__( 'Top Left', 'treweler' ),
							'selected' => in_array( 'top-left',
								isset( $meta_data->map_controls['search_position'] ) ? (array) $meta_data->map_controls['search_position'] : [ 'top-left' ] ),
							'value'    => 'top-left'
						],
						[
							'label'    => esc_html__( 'Top Right', 'treweler' ),
							'selected' => in_array( 'top-right',
								isset( $meta_data->map_controls['search_position'] ) ? (array) $meta_data->map_controls['search_position'] : [] ),
							'value'    => 'top-right'
						],
						[
							'label'    => esc_html__( 'Bottom Left', 'treweler' ),
							'selected' => in_array( 'bottom-left',
								isset( $meta_data->map_controls['search_position'] ) ? (array) $meta_data->map_controls['search_position'] : [] ),
							'value'    => 'bottom-left'
						],
						[
							'label'    => esc_html__( 'Bottom Right', 'treweler' ),
							'selected' => in_array( 'bottom-right',
								isset( $meta_data->map_controls['search_position'] ) ? (array) $meta_data->map_controls['search_position'] : [] ),
							'value'    => 'bottom-right'
						],
					]
				],
			]
		],
		[
			'type'  => 'group',
			'name'  => $prefix . 'map_controls',
			'label' => esc_html__( 'Zoom & Pan', 'treweler' ),
			'value' => [
				[
					'type'  => 'checkbox',
					'name'  => 'zoom_pan',
					'class' => 'col-fixed col-fixed--90',
					'value' => [
						[
							'label'   => '',
							'checked' => in_array( 'zoom_pan',
								isset( $meta_data->map_controls['zoom_pan'] ) ? (array) $meta_data->map_controls['zoom_pan'] : [] ),
							'value'   => 'zoom_pan'
						]
					]
				],
				[
					'type'  => 'select',
					'name'  => 'zoom_pan_position',
					'class' => 'col-fixed col-fixed--150',
					'value' => [
						[
							'label'    => esc_html__( 'Top Left', 'treweler' ),
							'selected' => in_array( 'top-left',
								isset( $meta_data->map_controls['zoom_pan_position'] ) ? (array) $meta_data->map_controls['zoom_pan_position'] : [] ),
							'value'    => 'top-left'
						],
						[
							'label'    => esc_html__( 'Top Right', 'treweler' ),
							'selected' => in_array( 'top-right',
								isset( $meta_data->map_controls['zoom_pan_position'] ) ? (array) $meta_data->map_controls['zoom_pan_position'] : [ 'top-right' ] ),
							'value'    => 'top-right'
						],
						[
							'label'    => esc_html__( 'Bottom Left', 'treweler' ),
							'selected' => in_array( 'bottom-left',
								isset( $meta_data->map_controls['zoom_pan_position'] ) ? (array) $meta_data->map_controls['zoom_pan_position'] : [] ),
							'value'    => 'bottom-left'
						],
						[
							'label'    => esc_html__( 'Bottom Right', 'treweler' ),
							'selected' => in_array( 'bottom-right',
								isset( $meta_data->map_controls['zoom_pan_position'] ) ? (array) $meta_data->map_controls['zoom_pan_position'] : [] ),
							'value'    => 'bottom-right'
						],
					]
				],
			]
		],
		[
			'type'  => 'group',
			'name'  => $prefix . 'map_controls',
			'label' => esc_html__( 'Geolocate', 'treweler' ),
			'value' => [
				[
					'type'  => 'checkbox',
					'name'  => 'geolocate',
					'class' => 'col-fixed col-fixed--90',
					'value' => [
						[
							'label'   => '',
							'checked' => in_array( 'geolocate',
								isset( $meta_data->map_controls['geolocate'] ) ? (array) $meta_data->map_controls['geolocate'] : [] ),
							'value'   => 'geolocate'
						]
					]
				],
				[
					'type'  => 'select',
					'name'  => 'geolocate_position',
					'class' => 'col-fixed col-fixed--150',
					'value' => [
						[
							'label'    => esc_html__( 'Top Left', 'treweler' ),
							'selected' => in_array( 'top-left',
								isset( $meta_data->map_controls['geolocate_position'] ) ? (array) $meta_data->map_controls['geolocate_position'] : [] ),
							'value'    => 'top-left'
						],
						[
							'label'    => esc_html__( 'Top Right', 'treweler' ),
							'selected' => in_array( 'top-right',
								isset( $meta_data->map_controls['geolocate_position'] ) ? (array) $meta_data->map_controls['geolocate_position'] : [ 'top-right' ] ),
							'value'    => 'top-right'
						],
						[
							'label'    => esc_html__( 'Bottom Left', 'treweler' ),
							'selected' => in_array( 'bottom-left',
								isset( $meta_data->map_controls['geolocate_position'] ) ? (array) $meta_data->map_controls['geolocate_position'] : [] ),
							'value'    => 'bottom-left'
						],
						[
							'label'    => esc_html__( 'Bottom Right', 'treweler' ),
							'selected' => in_array( 'bottom-right',
								isset( $meta_data->map_controls['geolocate_position'] ) ? (array) $meta_data->map_controls['geolocate_position'] : [] ),
							'value'    => 'bottom-right'
						],
					]
				],
				[
					'type'  => 'select',
					'name'  => 'geolocate_style',
					'class' => 'col-fixed col-fixed--150',
					'value' => [
						[
							'label'    => esc_html__( 'Mapbox Style', 'treweler' ),
							'selected' => in_array( 'mapbox-style',
								isset( $meta_data->map_controls['geolocate_style'] ) ? (array) $meta_data->map_controls['geolocate_style'] : ['mapbox-style'] ),
							'value'    => 'mapbox-style'
						],
						[
							'label'    => esc_html__( 'Treweler Style', 'treweler' ),
							'selected' => in_array( 'treweler-style',
								isset( $meta_data->map_controls['geolocate_style'] ) ? (array) $meta_data->map_controls['geolocate_style'] : [ ] ),
							'value'    => 'treweler-style'
						],
					]
				],
			]
		],
	];
}
