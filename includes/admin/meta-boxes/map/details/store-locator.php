<?php

function getStoreLocatorGeneralSettings() {
	global $post;
	$post_id = isset( $post->ID ) ? $post->ID : 0;


	$prefix    = '_treweler_';
	$meta_data = twer_get_data( $post_id );

	$storeLocatorType = get_post_meta( $post_id, '_treweler_store_locator_type', true );

	$store_locator_radius_size = [
		[
			'label'    => esc_html__( 'Unlimited', 'treweler' ),
			'selected' => in_array( 'unlim',
				isset( $meta_data->store_locator_radius['size'] ) ? (array) $meta_data->store_locator_radius['size'] : [ 'unlim' ] ),
			'value'    => 'unlim'
		],
	];
	$ir                        = 1;
	while ( $ir <= 1000 ) {

		switch ( $ir ) {
			case 1 :
			case 5 :
			case 10 :
			case 25 :
			case 50 :
			case 100 :
			case 500 :
				$selected_ir = [ $ir ];
				break;
			default :
				$selected_ir = [];
				break;
		}

		$ir_selected                 = in_array( $ir, isset( $meta_data->store_locator_radius['size'] ) ? (array) $meta_data->store_locator_radius['size'] : $selected_ir );
		$store_locator_radius_size[] = [
			'label'    => $ir,
			'selected' => $ir_selected,
			'value'    => $ir
		];

		if ( $ir <= 9 ) {
			$ir ++;
		} elseif ( $ir >= 10 && $ir <= 95 ) {
			$ir += 5;
		} elseif ( $ir >= 100 ) {
			$ir += 50;
		}
	}


	$store_locator_radius_default_value = isset( $meta_data->store_locator_radius['size'] ) ? (array) $meta_data->store_locator_radius['size'] : [];
	$check_value                        = isset( $store_locator_radius_default_value[0] ) ? $store_locator_radius_default_value[0] : $store_locator_radius_default_value;


	if ( is_array( $check_value ) && empty( $check_value ) ) {
		$store_locator_radius_default = [
			[
				'label'    => esc_html__( 'Unlimited', 'treweler' ),
				'selected' => in_array( 'unlim',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [ 'unlim' ] ),
				'value'    => 'unlim'
			],
			[
				'label'    => esc_html__( '1', 'treweler' ),
				'selected' => in_array( '1',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [] ),
				'value'    => '1'
			],
			[
				'label'    => esc_html__( '5', 'treweler' ),
				'selected' => in_array( '5',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [] ),
				'value'    => '5'
			],
			[
				'label'    => esc_html__( '10', 'treweler' ),
				'selected' => in_array( '10',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [ '10' ] ),
				'value'    => '10'
			],
			[
				'label'    => esc_html__( '25', 'treweler' ),
				'selected' => in_array( '25',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [] ),
				'value'    => '25'
			],
			[
				'label'    => esc_html__( '50', 'treweler' ),
				'selected' => in_array( '50',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [] ),
				'value'    => '50'
			],
			[
				'label'    => esc_html__( '100', 'treweler' ),
				'selected' => in_array( '100',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [] ),
				'value'    => '100'
			],
			[
				'label'    => esc_html__( '500', 'treweler' ),
				'selected' => in_array( '500',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [] ),
				'value'    => '500'
			],
		];
	}

	if ( is_string( $check_value ) && empty( $check_value ) ) {
		$store_locator_radius_default = [
			[
				'label'    => esc_html__( '10', 'treweler' ),
				'selected' => in_array( '10',
					isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [ '10' ] ),
				'value'    => '10'
			],
		];
	}

	if ( ! empty( $check_value ) ) {

		$store_locator_radius_default = [];
		foreach ( $store_locator_radius_default_value as $store_locator_radius_default_value_item ) {
			$store_locator_radius_default_value_label = $store_locator_radius_default_value_item;
			if ( $store_locator_radius_default_value_label === 'unlim' ) {
				$store_locator_radius_default_value_label = esc_html__( 'Unlimited', 'treweler' );
			}
			$store_locator_radius_default[] = [
				'label'    => $store_locator_radius_default_value_label,
				'selected' => in_array( $store_locator_radius_default_value_item, isset( $meta_data->store_locator_radius_default ) ? (array) $meta_data->store_locator_radius_default : [] ),
				'value'    => $store_locator_radius_default_value_item
			];
		}
	}

	return [
		[
			'type'  => 'checkbox',
			'name'  => $prefix . 'store_locator',
			'label' => esc_html__( 'Enable Store Locator', 'treweler' ),
			'value' => [
				[
					'label'   => '',
					'checked' => in_array( 'store_locator',
						isset( $meta_data->store_locator ) ? (array) $meta_data->store_locator : [] ),
					'value'   => 'store_locator'
				]
			]
		],
		[
			'type'  => 'select',
			'name'  => $prefix . 'store_locator_type',
			'label' => esc_html__( 'Locator Type', 'treweler' ),
			'value' => [
				[
					'value'    => 'extended',
					'label'    => esc_html__( 'Extended', 'treweler' ),
					'selected' => in_array( 'extended', isset( $meta_data->store_locator_type ) ? (array) $meta_data->store_locator_type : [ 'extended' ] )
				],
				[
					'value'    => 'simple',
					'label'    => esc_html__( 'Simple', 'treweler' ),
					'selected' => in_array( 'simple', isset( $meta_data->store_locator_type ) ? (array) $meta_data->store_locator_type : [] )
				],

			]
		],

		[
			'type'      => 'checkbox',
			'name'      => $prefix . 'store_locator_close',
			'row_class' => $storeLocatorType === 'extended' ? '' : 'd-none',
			'label'     => esc_html__( 'Close Sidebar by Default', 'treweler' ),
			'value'     => [
				[
					'label'   => '',
					'checked' => in_array( 'store_locator_close',
						isset( $meta_data->store_locator_close ) ? (array) $meta_data->store_locator_close : [] ),
					'value'   => 'store_locator_close'
				]
			]
		],


		[
			'type'      => 'select',
			'row_class' => $storeLocatorType === 'extended' ? '' : 'd-none',
			'name'      => $prefix . 'store_locator_sidebar_position',
			'label'     => esc_html__( 'Sidebar Position', 'treweler' ),
			'value'     => [
				[
					'value'    => 'left',
					'label'    => esc_html__( 'Left', 'treweler' ),
					'selected' => in_array( 'left', isset( $meta_data->store_locator_sidebar_position ) ? (array) $meta_data->store_locator_sidebar_position : [ 'left' ] )
				],
				[
					'value'    => 'right',
					'label'    => esc_html__( 'Right', 'treweler' ),
					'selected' => in_array( 'right', isset( $meta_data->store_locator_sidebar_position ) ? (array) $meta_data->store_locator_sidebar_position : [] )
				],
			]
		],



		[
			'type'      => 'select',
			'row_class' => $storeLocatorType === 'extended' ? '' : 'd-none',
			'name'      => $prefix . 'store_locator_sidebar_open_button_position',
			'label'     => esc_html__( 'Sidebar Open Button', 'treweler' ),
			'value'     => [
				[
					'value'    => 'middle',
					'label'    => esc_html__( 'Middle', 'treweler' ),
					'selected' => in_array( 'middle', isset( $meta_data->store_locator_sidebar_open_button_position ) ? (array) $meta_data->store_locator_sidebar_open_button_position : [ 'middle' ] )
				],
				[
					'value'    => 'top',
					'label'    => esc_html__( 'Top', 'treweler' ),
					'selected' => in_array( 'top', isset( $meta_data->store_locator_sidebar_open_button_position ) ? (array) $meta_data->store_locator_sidebar_open_button_position : [] )
				],
			]
		],


		[
			'type'      => 'select',
			'row_class' => $storeLocatorType === 'extended' ? '' : 'd-none',
			'name'      => $prefix . 'store_locator_marker_click_event',
			'label'     => esc_html__( 'Marker Click Event', 'treweler' ),
			'value'     => [
				[
					'value'    => 'marker_details',
					'label'    => esc_html__( 'Marker Details', 'treweler' ),
					'selected' => in_array( 'marker_details', isset( $meta_data->store_locator_marker_click_event ) ? (array) $meta_data->store_locator_marker_click_event : [ 'marker_details' ] )
				],
				[
					'value'    => 'focus_on_card',
					'label'    => esc_html__( 'Focus on Card', 'treweler' ),
					'selected' => in_array( 'focus_on_card', isset( $meta_data->store_locator_marker_click_event ) ? (array) $meta_data->store_locator_marker_click_event : [] )
				],
			]
		],
		[
			'type'      => 'select',
			'row_class' => $storeLocatorType === 'extended' ? '' : 'd-none',
			'name'      => $prefix . 'store_locator_card_click_event',
			'label'     => esc_html__( 'Card Click Event', 'treweler' ),
			'value'     => [
				[
					'value'    => 'marker_details',
					'label'    => esc_html__( 'Marker Details', 'treweler' ),
					'selected' => in_array( 'marker_details', isset( $meta_data->store_locator_card_click_event ) ? (array) $meta_data->store_locator_card_click_event : [ 'marker_details' ] )
				],
				[
					'value'    => 'focus_on_card',
					'label'    => esc_html__( 'Focus on Card', 'treweler' ),
					'selected' => in_array( 'focus_on_card', isset( $meta_data->store_locator_card_click_event ) ? (array) $meta_data->store_locator_card_click_event : [] )
				],
			]
		],

		[
			'type'  => 'number-v2',
			'name'  => $prefix . 'store_locator_zoom_on_click',
			'label' => esc_html__( 'Zoom Level On Card Click', 'treweler' ),
			'value' => [
				'placeholder' => '',
				'current'     => isset( $meta_data->store_locator_zoom_on_click ) ? $meta_data->store_locator_zoom_on_click : '',
				'min'         => '0',
				'max'         => '24',
				'step'        => '0.1'
			],
		],

		[
			'type'      => 'select',
			'row_class' => $storeLocatorType === 'extended' ? 'd-none' : '',
			'name'      => $prefix . 'store_locator_positions',
			'label'     => esc_html__( 'Controls Position', 'treweler' ),
			'value'     => [
				[
					'value'    => 'top_left',
					'label'    => esc_html__( 'Top Left', 'treweler' ),
					'selected' => in_array( 'top_left',
						isset( $meta_data->store_locator_positions ) ? (array) $meta_data->store_locator_positions : [] )
				],
				[
					'value'    => 'top_right',
					'label'    => esc_html__( 'Top Right', 'treweler' ),
					'selected' => in_array( 'top_right',
						isset( $meta_data->store_locator_positions ) ? (array) $meta_data->store_locator_positions : [ 'top_right' ] )
				],
				[
					'value'    => 'bottom_left',
					'label'    => esc_html__( 'Bottom Left', 'treweler' ),
					'selected' => in_array( 'bottom_left',
						isset( $meta_data->store_locator_positions ) ? (array) $meta_data->store_locator_positions : [] )
				],
				[
					'value'    => 'bottom_right',
					'label'    => esc_html__( 'Bottom Right', 'treweler' ),
					'selected' => in_array( 'bottom_right',
						isset( $meta_data->store_locator_positions ) ? (array) $meta_data->store_locator_positions : [] )
				]
			]
		],


		[
			'type'      => 'checkbox',
			'row_class' => $storeLocatorType === 'extended' ? 'd-none' : '',
			'name'      => $prefix . 'store_locator_search',
			'label'     => esc_html__( 'Search Control', 'treweler' ),
			'value'     => [
				[
					'label'   => '',
					'checked' => in_array( 'store_locator_search',
						isset( $meta_data->store_locator_search ) ? (array) $meta_data->store_locator_search : [ 'store_locator_search' ] ),
					'value'   => 'store_locator_search'
				]
			]
		],
		[
			'type'      => 'checkbox',
			'row_class' => $storeLocatorType === 'extended' ? 'd-none' : '',
			'name'      => $prefix . 'store_locator_geolocation',
			'label'     => esc_html__( 'Geolocation Control', 'treweler' ),
			'value'     => [
				[
					'label'   => '',
					'checked' => in_array( 'store_locator_geolocation',
						isset( $meta_data->store_locator_geolocation ) ? (array) $meta_data->store_locator_geolocation : [ 'store_locator_geolocation' ] ),
					'value'   => 'store_locator_geolocation'
				]
			]
		],
		[
			'type'      => 'checkbox',
			'row_class' => $storeLocatorType === 'extended' ? '' : 'd-none',
			'name'      => $prefix . 'store_locator_search_and_geolocation',
			'label'     => esc_html__( 'Search & Geolocation Control', 'treweler' ),
			'value'     => [
				[
					'label'   => '',
					'checked' => in_array( 'store_locator_search_and_geolocation',
						isset( $meta_data->store_locator_search_and_geolocation ) ? (array) $meta_data->store_locator_search_and_geolocation : [ 'store_locator_search_and_geolocation' ] ),
					'value'   => 'store_locator_search_and_geolocation'
				]
			]
		],
		[
			'type'  => 'group',
			'name'  => $prefix . 'store_locator_radius',
			'label' => esc_html__( 'Radius Control', 'treweler' ),
			'value' => [
				[
					'type'  => 'checkbox',
					'name'  => 'show',
					'class' => 'col-fixed col-fixed--70',
					'value' => [
						[
							'label'   => '',
							'checked' => in_array( 'show',
								isset( $meta_data->store_locator_radius['show'] ) ? (array) $meta_data->store_locator_radius['show'] : [ 'show' ] ),
							'value'   => 'show'
						]
					]
				],
				[
					'class' => 'col-fixed col-fixed--550',
					'type'  => 'multiple-select',
					'name'  => 'size',
					'value' => $store_locator_radius_size
				],
				[
					'type'  => 'select',
					'name'  => 'distance',
					'class' => 'col-fixed col-fixed--90',
					'value' => [
						[
							'value'    => 'kilometers',
							'label'    => esc_html__( 'km', 'treweler' ),
							'selected' => in_array( 'kilometers',
								isset( $meta_data->store_locator_radius['distance'] ) ? (array) $meta_data->store_locator_radius['distance'] : [ 'kilometers' ] )
						],
						[
							'value'    => 'miles',
							'label'    => esc_html__( 'mi', 'treweler' ),
							'selected' => in_array( 'miles',
								isset( $meta_data->store_locator_radius['distance'] ) ? (array) $meta_data->store_locator_radius['distance'] : [] )
						],
					]
				],
			]
		],
		[
			'type'  => 'select',
			'name'  => $prefix . 'store_locator_radius_default',
			'label' => esc_html__( 'Default Radius', 'treweler' ),
			'value' => $store_locator_radius_default
		],
	];
}


