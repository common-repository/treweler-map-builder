<?php
/**
 * Map details meta box.
 *
 * @package Treweler/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$post_id = isset( $post->ID ) ? $post->ID : '';
$prefix = '_treweler_';
$meta_data = twer_get_data( $post_id );
$post_meta_old = get_post_meta( $post_id );

$name = get_post_meta( $post_id, '_treweler_map_details_name', true );
$name_color = get_post_meta( $post_id, '_treweler_map_details_name_color', true );
$name_color = $name_color != '' ? $name_color : '#000';
$desc = get_post_meta( $post_id, '_treweler_map_details_description', true );
$desc_color = get_post_meta( $post_id, '_treweler_map_details_description_color', true );
$desc_color = $desc_color != '' ? $desc_color : '#000';
$position = get_post_meta( $post_id, '_treweler_map_details_position', true );
$projection = get_post_meta( $post_id, '_treweler_map_projection', true );
$custom_color = get_option( 'treweler_mapbox_colorpicker_custom_color' );
$defaultColors = '#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|';
$logoSize = get_post_meta( $post_id, '_treweler_map_details_logo_size', true );
$map_css_class = get_post_meta( $post_id, '_treweler_map_css_class', true );


$fields_widgets = [
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'widgets_show',
    'label' => esc_html__( 'Show Widgets', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'widgets_show',
          isset( $meta_data->widgets_show ) ? (array) $meta_data->widgets_show : [] ),
        'value'   => 'widgets_show'
      ]
    ]
  ],
  [
    'type'  => 'widgets',
    'name'  => $prefix . 'widgets',
    'label' => esc_html__( 'Widgets', 'treweler' ),
    'value' => [
      [
        [
          'type'  => 'widget',
          'name'  => 'top_left',
          'label' => esc_html__( 'Top Left', 'treweler' ),
          'value' => [
            [
              'type'  => 'text',
              'name'  => 'value',
              'label' => esc_html__( 'Value', 'treweler' ),
              'value' => ''
            ],
            [
              'type'  => 'text',
              'name'  => 'description',
              'label' => esc_html__( 'Description', 'treweler' ),
              'value' => ''
            ]
          ]
        ],
        [
          'type'  => 'widget',
          'name'  => 'middle_left',
          'label' => esc_html__( 'Middle Left', 'treweler' ),
          'value' => [
            [
              'type'  => 'text',
              'name'  => 'value',
              'label' => esc_html__( 'Value', 'treweler' ),

              'value' => ''
            ],
            [
              'type'  => 'text',
              'name'  => 'description',
              'label' => esc_html__( 'Description', 'treweler' ),
              'value' => ''
            ]
          ]
        ],
        [
          'type'  => 'widget',
          'name'  => 'bottom_left',
          'label' => esc_html__( 'Bottom Left', 'treweler' ),
          'value' => [
            [
              'type'  => 'text',
              'name'  => 'value',
              'label' => esc_html__( 'Value', 'treweler' ),
              'value' => ''
            ],
            [
              'type'  => 'text',
              'name'  => 'description',
              'label' => esc_html__( 'Description', 'treweler' ),
              'value' => ''
            ]
          ]
        ],
      ],
      [
        [
          'type'  => 'widget',
          'name'  => 'top_right',
          'label' => esc_html__( 'Top Right', 'treweler' ),
          'value' => [
            [
              'type'  => 'text',
              'name'  => 'value',
              'label' => esc_html__( 'Value', 'treweler' ),
              'value' => ''
            ],
            [
              'type'  => 'text',
              'name'  => 'description',
              'label' => esc_html__( 'Description', 'treweler' ),
              'value' => ''
            ]
          ]
        ],
        [
          'type'  => 'widget',
          'name'  => 'middle_right',
          'label' => esc_html__( 'Middle Right', 'treweler' ),
          'value' => [
            [
              'type'  => 'text',
              'name'  => 'value',
              'label' => esc_html__( 'Value', 'treweler' ),
              'value' => ''
            ],
            [
              'type'  => 'text',
              'name'  => 'description',
              'label' => esc_html__( 'Description', 'treweler' ),
              'value' => ''
            ]
          ]
        ],
        [
          'type'  => 'widget',
          'name'  => 'bottom_right',
          'label' => esc_html__( 'Bottom Right', 'treweler' ),
          'value' => [
            [
              'type'  => 'text',
              'name'  => 'value',
              'label' => esc_html__( 'Value', 'treweler' ),
              'value' => ''
            ],
            [
              'type'  => 'text',
              'name'  => 'description',
              'label' => esc_html__( 'Description', 'treweler' ),
              'value' => ''
            ]
          ]
        ]
      ]
    ]
  ],
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'widgets_bg',
    'label' => esc_html__( 'Show Background', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'widgets_bg',
          isset( $meta_data->widgets_bg ) ? (array) $meta_data->widgets_bg : ['widgets_bg'] ),
        'value'   => 'widgets_bg'
      ]
    ]
  ],
  [
    'type'  => 'colorpicker',
    'name'  => $prefix . 'widgets_color',
    'label' => esc_html__( 'Color', 'treweler' ),
    'value' => isset( $meta_data->widgets_color ) ? $meta_data->widgets_color : '#000'
  ],
  [
    'type'  => 'select',
    'name'  => $prefix . 'widgets_font_weight',
    'label' => esc_html__( 'Font Weight', 'treweler' ),
    'value' => [
      [
        'label'    => esc_html__( 'Thin 100', 'treweler' ),
        'selected' => in_array( '100',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [] ),
        'value'    => '100'
      ],
      [
        'label'    => esc_html__( 'Extra Light 200', 'treweler' ),
        'selected' => in_array( '200',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [] ),
        'value'    => '200'
      ],
      [
        'label'    => esc_html__( 'Light 300', 'treweler' ),
        'selected' => in_array( '300',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [] ),
        'value'    => '300'
      ],
      [
        'label'    => esc_html__( 'Regular 400', 'treweler' ),
        'selected' => in_array( '400',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [ '400'] ),
        'value'    => '400'
      ],
      [
        'label'    => esc_html__( 'Medium 500', 'treweler' ),
        'selected' => in_array( '500',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [] ),
        'value'    => '500'
      ],
      [
        'label'    => esc_html__( 'Semi Bold 600', 'treweler' ),
        'selected' => in_array( '600',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [] ),
        'value'    => '600'
      ],
      [
        'label'    => esc_html__( 'Bold 700', 'treweler' ),
        'selected' => in_array( '700',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [ ] ),
        'value'    => '700'
      ],
      [
        'label'    => esc_html__( 'Extra Bold 800', 'treweler' ),
        'selected' => in_array( '800',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [] ),
        'value'    => '800'
      ],
      [
        'label'    => esc_html__( 'Black 900', 'treweler' ),
        'selected' => in_array( '900',
          isset( $meta_data->widgets_font_weight ) ? (array) $meta_data->widgets_font_weight : [] ),
        'value'    => '900'
      ],
    ]
  ],
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'widgets_gradient',
    'label' => esc_html__( 'Show Gradient', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'widgets_gradient',
          isset( $meta_data->widgets_gradient ) ? (array) $meta_data->widgets_gradient : [] ),
        'value'   => 'widgets_gradient'
      ]
    ]
  ],
  [
    'type'  => 'colorpicker',
    'name'  => $prefix . 'widgets_gradient_color',
    'label' => esc_html__( 'Gradient Color', 'treweler' ),
    'value' => isset( $meta_data->widgets_gradient_color ) ? $meta_data->widgets_gradient_color : '#ffffff'
  ],
  [
    'type'  => 'range',
    'name'  => $prefix . 'widgets_gradient_opacity',
    'label' => esc_html__( 'Gradient Opacity', 'treweler' ),
    'value' => [
      'current' => isset( $meta_data->widgets_gradient_opacity ) ? $meta_data->widgets_gradient_opacity : '1',
      'min'     => '0',
      'max'     => '1',
      'step'    => '0.01'
    ],
    'help'  => esc_html__( 'The opacity property can take a value from 0.0 - 1.0. The lower value, the more transparent.',
      'treweler' )
  ],
  [
    'type'  => 'select',
    'name'  => $prefix . 'widgets_gradient_position',
    'label' => esc_html__( 'Gradient Position', 'treweler' ),
    'value' => [
      [
        'label'    => esc_html__( 'Left', 'treweler' ),
        'selected' => in_array( 'left',
          isset( $meta_data->widgets_gradient_position ) ? (array) $meta_data->widgets_gradient_position : [ 'left' ] ),
        'value'    => 'left'
      ],
      [
        'label'    => esc_html__( 'Right', 'treweler' ),
        'selected' => in_array( 'right',
          isset( $meta_data->widgets_gradient_position ) ? (array) $meta_data->widgets_gradient_position : [] ),
        'value'    => 'right'
      ],
      [
        'label'    => esc_html__( 'Left and Right', 'treweler' ),
        'selected' => in_array( 'left-right',
          isset( $meta_data->widgets_gradient_position ) ? (array) $meta_data->widgets_gradient_position : [] ),
        'value'    => 'left-right'
      ]
    ]
  ]
];

$fields_camera = [
  [
    'type'  => 'range',
    'name'  => $prefix . 'camera_initial_bearing',
    'label' => esc_html__( 'Initial Bearing', 'treweler' ),
    'value' => [
      'current' => isset( $meta_data->camera_initial_bearing ) ? $meta_data->camera_initial_bearing : '0',
      'min'     => '-360',
      'max'     => '360',
      'step'    => '0.01'
    ],
    'help'  => esc_html__( "The map's angle of rotation, measured in degrees counter-clockwise from north.",
      'treweler' )
  ],
  [
    'type'  => 'range',
    'name'  => $prefix . 'camera_initial_pitch',
    'label' => esc_html__( 'Initial Pitch', 'treweler' ),
    'value' => [
      'current' => isset( $meta_data->camera_initial_pitch ) ? $meta_data->camera_initial_pitch : '0',
      'min'     => '0',
      'max'     => '85',
      'step'    => '0.01'
    ],
    'help'  => esc_html__( "The map's angle towards the horizon measured in degrees.",
      'treweler' )
  ],
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'camera_bearing',
    'label' => esc_html__( 'Allow Pitch & Bearing', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'camera_bearing',
          isset( $meta_data->camera_bearing ) ? (array) $meta_data->camera_bearing : [] ),
        'value'   => 'camera_bearing'
      ]
    ]
  ],

  [
    'type'   => 'multirange',
    'name'   => $prefix . 'camera_pitch_mr',
    'label'  => esc_html__( 'Pitch Range', 'treweler' ),
    'fields' => [
      [
        'name'  => $prefix . 'camera_min_pitch',
        'label' => esc_html__( 'Minimum Pitch', 'treweler' ),
        'value' => [
          'current' => isset( $meta_data->camera_min_pitch ) ? $meta_data->camera_min_pitch : '0',
          'min'     => '0',
          'max'     => '85',
          'step'    => '0.01'
        ],
      ],
      [
        'name'  => $prefix . 'camera_max_pitch',
        'label' => esc_html__( 'Maximum Pitch', 'treweler' ),
        'value' => [
          'current' => isset( $meta_data->camera_max_pitch ) ? $meta_data->camera_max_pitch : '85',
          'min'     => '0',
          'max'     => '85',
          'step'    => '0.01'
        ],
      ]
    ]
  ],
];



$fields_preloader = [
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'enable_preloader',
    'label' => esc_html__( 'Enable Preloader', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'enable_preloader',
          isset( $meta_data->enable_preloader ) ? (array) $meta_data->enable_preloader : [] ),
        'value'   => 'enable_preloader'
      ]
    ]
  ],
  [
    'type'  => 'colorpicker',
    'name'  => $prefix . 'preloader_background_color',
    'label' => esc_html__( 'Background Color', 'treweler' ),
    'value' => isset( $meta_data->preloader_background_color ) ? $meta_data->preloader_background_color : '#0F0F0F'
  ],
  [
    'type'   => 'textcolorpicker',
    'name'   => $prefix . 'preloader_text_with_color',
    'label'  => esc_html__( 'Preloader Text', 'treweler' ),
    'fields' => [
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'preloader_text',
        'label' => esc_html__( 'Text', 'treweler' ),
        'value' => isset( $meta_data->preloader_text ) ? $meta_data->preloader_text : ''
      ],
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'preloader_text_color',
        'label' => esc_html__( 'Color', 'treweler' ),
        'value' => isset( $meta_data->preloader_text_color ) ? $meta_data->preloader_text_color : '#FFFFFF',
      ],
    ]
  ],
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'preloader_enable_percentage',
    'label' => esc_html__( 'Enable Percentage', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'preloader_enable_percentage',
          isset( $meta_data->preloader_enable_percentage ) ? (array) $meta_data->preloader_enable_percentage : [ 'preloader_enable_percentage' ] ),
        'value'   => 'preloader_enable_percentage'
      ]
    ]
  ],
  [
    'type'  => 'colorpicker',
    'name'  => $prefix . 'preloader_percentage_color',
    'label' => esc_html__( 'Percentage Color', 'treweler' ),
    'value' => isset( $meta_data->preloader_percentage_color ) ? $meta_data->preloader_percentage_color : '#4D4D4D'
  ],
  [
    'type'  => 'image',
    'name'  => $prefix . 'preloader_popup_image',
    'label' => esc_html__( 'Image', 'treweler' ),
    'value' => isset( $meta_data->preloader_popup_image ) ? $meta_data->preloader_popup_image : ''
  ],
];

$fields_tour = [
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'enable_tour',
    'label' => esc_html__( 'Enable Tour', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'enable_tour',
          isset( $meta_data->enable_tour ) ? (array) $meta_data->enable_tour : [] ),
        'value'   => 'enable_tour'
      ]
    ]
  ],
  [
    'type'  => 'select',
    'name'  => $prefix . 'tour_arrows_position',
    'label' => esc_html__( 'Arrows Position', 'treweler' ),
    'id'    => 'twer-tour-arrows-position',
    'value' => [
      [
        'value'    => 'top-left',
        'label'    => esc_html__( 'Top Left', 'treweler' ),
        'selected' => in_array( 'top-left',
          isset( $meta_data->tour_arrows_position ) ? (array) $meta_data->tour_arrows_position : [] )
      ],
      [
        'value'    => 'top-right',
        'label'    => esc_html__( 'Top Right', 'treweler' ),
        'selected' => in_array( 'top-right',
          isset( $meta_data->tour_arrows_position ) ? (array) $meta_data->tour_arrows_position : [] )
      ],
      [
        'value'    => 'bottom-left',
        'label'    => esc_html__( 'Bottom Left', 'treweler' ),
        'selected' => in_array( 'bottom-left',
          isset( $meta_data->tour_arrows_position ) ? (array) $meta_data->tour_arrows_position : [] )
      ],
      [
        'value'    => 'bottom-right',
        'label'    => esc_html__( 'Bottom Right', 'treweler' ),
        'selected' => in_array( 'bottom-right',
          isset( $meta_data->tour_arrows_position ) ? (array) $meta_data->tour_arrows_position : [ 'bottom-right' ] )
      ]
    ]
  ],
  [
    'type'  => 'group-tour-text',
    'name'  => $prefix . 'group_tour_text',
    'label' => esc_html__( 'Tour Information', 'treweler' ),
    'value' => [
      [
        'type'  => 'text',
        'name'  => $prefix . 'tour_start_message',
        'label' => esc_html__( 'Start Message', 'treweler' ),
        'value' => isset( $meta_data->tour_start_message ) ? $meta_data->tour_start_message : ''
      ],
      [
        'type'  => 'checkbox',
        'name'  => $prefix . 'tour_show_marker_names',
        'label' => esc_html__( 'Show Marker Names', 'treweler' ),
        'value' => [
          [
            'label'   => '',
            'checked' => in_array( 'tour_show_marker_names',
              isset( $meta_data->tour_show_marker_names ) ? (array) $meta_data->tour_show_marker_names : [ 'tour_show_marker_names' ] ),
            'value'   => 'tour_show_marker_names'
          ]
        ]
      ],
    ]
  ],
  [
    'type'  => 'select',
    'name'  => $prefix . 'tour_type',
    'label' => esc_html__( 'Tour Type', 'treweler' ),
    'id'    => 'twer-tour-type',
    'value' => [
      [
        'value'    => 'jump',
        'label'    => esc_html__( 'Jump', 'treweler' ),
        'selected' => in_array( 'jump',
          isset( $meta_data->tour_type ) ? (array) $meta_data->tour_type : [ 'jump' ] )
      ],
      [
        'value'    => 'fly',
        'label'    => esc_html__( 'Fly', 'treweler' ),
        'selected' => in_array( 'fly',
          isset( $meta_data->tour_type ) ? (array) $meta_data->tour_type : [] )
      ],
    ]
  ],
  [
    'type'  => 'range',
    'name'  => $prefix . 'marker_zoom_level',
    'label' => esc_html__( 'Marker Zoom Level', 'treweler' ),
    'value' => [
      'current' => $meta_data->marker_zoom_level ?? ( $meta_data->map_zoom ?? '15' ),
      'min'     => '0',
      'max'     => '24',
      'step'    => '0.01'
    ],
  ],
  [
    'type'  => 'number-v2',
    'name'  => $prefix . 'tour_fly_speed',
    'label' => esc_html__( 'Speed', 'treweler' ),
    'value' => [
      'placeholder' => '1,2',
      'current'     => isset( $meta_data->tour_fly_speed ) ? $meta_data->tour_fly_speed : '',
      'min'         => '0',
      'max'         => '24',
      'step'        => '0.01'
    ],
    'help'  => 'The average speed of the animation defined in relation to the Curve.'
  ],
  [
    'type'  => 'number-v2',
    'name'  => $prefix . 'tour_fly_curve',
    'label' => esc_html__( 'Curve', 'treweler' ),
    'value' => [
      'placeholder' => '1,42',
      'current'     => isset( $meta_data->tour_fly_curve ) ? $meta_data->tour_fly_curve : '',
      'min'         => '0',
      'max'         => '24',
      'step'        => '0.01'
    ],
    'help'  => 'The zooming "curve" that will occur along the flight path.'
  ],
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'tour_show_marker_popups',
    'label' => esc_html__( 'Show Marker Popups', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'tour_show_marker_popups',
          isset( $meta_data->tour_show_marker_popups ) ? (array) $meta_data->tour_show_marker_popups : [] ),
        'value'   => 'tour_show_marker_popups'
      ]
    ]
  ],

  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'tour_auto_run',
    'label' => esc_html__( 'Start Tour After Load', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'tour_auto_run',
          isset( $meta_data->tour_auto_run ) ? (array) $meta_data->tour_auto_run : [ 'tour_auto_run' ] ),
        'value'   => 'tour_auto_run'
      ]
    ]
  ],
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'tour_numbered_markers',
    'label' => esc_html__( 'Numbered Markers', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'tour_numbered_markers',
          isset( $meta_data->tour_numbered_markers ) ? (array) $meta_data->tour_numbered_markers : [  ] ),
        'value'   => 'tour_numbered_markers'
      ]
    ]
  ],
  [
    'type'  => 'group',
    'name'  => $prefix . 'tour_numbered_markers_style',
    'label' => esc_html__( 'Number Styles', 'treweler' ),
    'value' => [
      [
        'type'  => 'colorpicker',
        'name'  => 'color',
        'label' => '',
        'value' => isset( $meta_data->tour_numbered_markers_style['color'] ) ? $meta_data->tour_numbered_markers_style['color'] : '#000000'
      ],
      [
        'type'        => 'text',
        'name'        => 'font_size',
        'postfix'     => 'px',
        'size'        => 'small',
        'placeholder' => '12',
        'label'       => '',
        'value'       => isset( $meta_data->tour_numbered_markers_style['font_size'] ) ? $meta_data->tour_numbered_markers_style['font_size'] : ''
      ],
      [
        'type'  => 'select',
        'name'  =>  'font_weight',
        'label' => '',
        'class' => 'col-fixed',
        'value' => [
          [
            'label'    => esc_html__( 'Thin 100', 'treweler' ),
            'selected' => in_array( '100',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [] ),
            'value'    => '100'
          ],
          [
            'label'    => esc_html__( 'Extra Light 200', 'treweler' ),
            'selected' => in_array( '200',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [] ),
            'value'    => '200'
          ],
          [
            'label'    => esc_html__( 'Light 300', 'treweler' ),
            'selected' => in_array( '300',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [] ),
            'value'    => '300'
          ],
          [
            'label'    => esc_html__( 'Regular 400', 'treweler' ),
            'selected' => in_array( '400',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [ '400'] ),
            'value'    => '400'
          ],
          [
            'label'    => esc_html__( 'Medium 500', 'treweler' ),
            'selected' => in_array( '500',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [] ),
            'value'    => '500'
          ],
          [
            'label'    => esc_html__( 'Semi Bold 600', 'treweler' ),
            'selected' => in_array( '600',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [] ),
            'value'    => '600'
          ],
          [
            'label'    => esc_html__( 'Bold 700', 'treweler' ),
            'selected' => in_array( '700',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [ ] ),
            'value'    => '700'
          ],
          [
            'label'    => esc_html__( 'Extra Bold 800', 'treweler' ),
            'selected' => in_array( '800',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [] ),
            'value'    => '800'
          ],
          [
            'label'    => esc_html__( 'Black 900', 'treweler' ),
            'selected' => in_array( '900',
              isset( $meta_data->tour_numbered_markers_style['font_weight'] ) ? (array) $meta_data->tour_numbered_markers_style['font_weight'] : [] ),
            'value'    => '900'
          ],
        ]
      ],
    ]
  ],
  [
    'type'  => 'text-v2',
    'name'  => $prefix . 'tour_numbered_markers_start_from',
    'label' => esc_html__( 'Start Number', 'treweler' ),
    'width' => '109px',
    'value' => [
      'placeholder' => '1',
      'current'     => isset( $meta_data->tour_numbered_markers_start_from ) ? $meta_data->tour_numbered_markers_start_from : '',
      'min'         => '0',
      'step'        => '1'
    ],
  ],
  [
    'type'  => 'group',
    'name'  => $prefix . 'tour_numbered_markers_offset',
    'label' => esc_html__( 'Numbers Offset', 'treweler' ),
    'value' => [
      [
        'type'        => 'number',
        'name'        => 'top',
        'postfix'     => 'px',
        'size'        => 'small',
        'min' => 0,
        'step' => 1,
        'placeholder' => '0',
        'label'       => esc_html__( 'Top', 'treweler' ),
        'value'       => isset( $meta_data->tour_numbered_markers_offset['top'] ) ? $meta_data->tour_numbered_markers_offset['top'] : ''
      ],
      [
        'type'        => 'text',
        'name'        => 'bottom',
        'postfix'     => 'px',
        'min' => 0,
        'step' => 1,
        'size'        => 'small',
        'placeholder' => '0',
        'label'       => esc_html__( 'Bottom', 'treweler' ),
        'value'       => isset( $meta_data->tour_numbered_markers_offset['bottom'] ) ? $meta_data->tour_numbered_markers_offset['bottom'] : ''
      ],
      [
        'type'        => 'text',
        'name'        => 'left',
        'postfix'     => 'px',
        'min' => 0,
        'step' => 1,
        'size'        => 'small',
        'placeholder' => '0',
        'label'       => esc_html__( 'Left', 'treweler' ),
        'value'       => isset( $meta_data->tour_numbered_markers_offset['left'] ) ? $meta_data->tour_numbered_markers_offset['left'] : ''
      ],
      [
        'type'        => 'text',
        'name'        => 'right',
        'postfix'     => 'px',
        'min' => 0,
        'step' => 1,
        'size'        => 'small',
        'placeholder' => '0',
        'label'       => esc_html__( 'Right', 'treweler' ),
        'value'       => isset( $meta_data->tour_numbered_markers_offset['right'] ) ? $meta_data->tour_numbered_markers_offset['right'] : ''
      ],
    ]
  ],



  [
    'type'  => 'group',
    'name'  => $prefix . 'tour_offset',
    'label' => esc_html__( 'Marker Offset', 'treweler' ),
    'value' => [
      [
        'type'        => 'text',
        'name'        => 'top',
        'postfix'     => 'px',
        'size'        => 'small',
        'placeholder' => '0',
        'label'       => esc_html__( 'Top', 'treweler' ),
        'value'       => isset( $meta_data->tour_offset['top'] ) ? $meta_data->tour_offset['top'] : ''
      ],
      [
        'type'        => 'text',
        'name'        => 'bottom',
        'postfix'     => 'px',
        'size'        => 'small',
        'placeholder' => '0',
        'label'       => esc_html__( 'Bottom', 'treweler' ),
        'value'       => isset( $meta_data->tour_offset['bottom'] ) ? $meta_data->tour_offset['bottom'] : ''
      ],
      [
        'type'        => 'text',
        'name'        => 'left',
        'postfix'     => 'px',
        'size'        => 'small',
        'placeholder' => '0',
        'label'       => esc_html__( 'Left', 'treweler' ),
        'value'       => isset( $meta_data->tour_offset['left'] ) ? $meta_data->tour_offset['left'] : ''
      ],
      [
        'type'        => 'text',
        'name'        => 'right',
        'postfix'     => 'px',
        'size'        => 'small',
        'placeholder' => '0',
        'label'       => esc_html__( 'Right', 'treweler' ),
        'value'       => isset( $meta_data->tour_offset['right'] ) ? $meta_data->tour_offset['right'] : ''
      ],
    ]
  ],
  [
    'type'  => 'tour_markers',
    'name'  => $prefix . 'tour_marker_repeater',
    'label' => esc_html__( 'Tour Markers', 'treweler' ),
    'value' => [
      [
        'type'  => 'text',
        'name'  => 'tour_marker_picker',
        'label' => esc_html__( 'Marker', 'treweler' ),
        'value' => ''
      ],
      [
        'type'  => 'checkbox',
        'name'  => 'tour_advanced_settings',
        'label' => esc_html__( 'Advanced Settings', 'treweler' ),
        'value' => [
          [
            'label'   => '',
            'checked' => in_array( 'tour_advanced_settings',
              isset( $meta_data->tour_advanced_settings ) ? (array) $meta_data->tour_advanced_settings : [] ),
            'value'   => 'tour_advanced_settings'
          ]
        ]
      ],
      [
        'type'  => 'text',
        'name'  => 'tour_marker_zoom',
        'label' => esc_html__( 'Markers zoom level', 'treweler' ),
        'value' => ''
      ],
      [
        'type'  => 'text',
        'name'  => 'tour_marker_popup',
        'label' => esc_html__( 'Show markers popup', 'treweler' ),
        'value' => [
          [
            'label'   => '',
            'checked' => in_array( 'tour_marker_popup',
              isset( $meta_data->tour_marker_popup ) ? (array) $meta_data->tour_marker_popup : [] ),
            'value'   => 'tour_marker_popup'
          ]
        ]
      ],
      [
        'type'  => 'text',
        'name'  => 'tour_bearing',
        'label' => esc_html__( 'Bearing', 'treweler' ),
        'value' => ''
      ],
      [
        'type'  => 'text',
        'name'  => 'tour_pitch',
        'label' => esc_html__( 'Pitch', 'treweler' ),
        'value' => ''
      ],
      [
        'type'  => 'group',
        'name'  => 'tour_offset',
        'label' => esc_html__( 'Marker Offset', 'treweler' ),
        'value' => [
          [
            'type'        => 'text',
            'name'        => 'top',
            'postfix'     => 'px',
            'size'        => 'small',
            'placeholder' => '0',
            'label'       => esc_html__( 'Top', 'treweler' ),
            'value'       => isset( $meta_data->tour_offset['top'] ) ? $meta_data->tour_offset['top'] : ''
          ],
          [
            'type'        => 'text',
            'name'        => 'bottom',
            'postfix'     => 'px',
            'size'        => 'small',
            'placeholder' => '0',
            'label'       => esc_html__( 'Bottom', 'treweler' ),
            'value'       => isset( $meta_data->tour_offset['bottom'] ) ? $meta_data->tour_offset['bottom'] : ''
          ],
          [
            'type'        => 'text',
            'name'        => 'left',
            'postfix'     => 'px',
            'size'        => 'small',
            'placeholder' => '0',
            'label'       => esc_html__( 'Left', 'treweler' ),
            'value'       => isset( $meta_data->tour_offset['left'] ) ? $meta_data->tour_offset['left'] : ''
          ],
          [
            'type'        => 'text',
            'name'        => 'right',
            'postfix'     => 'px',
            'size'        => 'small',
            'placeholder' => '0',
            'label'       => esc_html__( 'Right', 'treweler' ),
            'value'       => isset( $meta_data->tour_offset['right'] ) ? $meta_data->tour_offset['right'] : ''
          ],
        ]
      ],
    ]
  ],

];





$regions_cap = isset( $meta_data->boundaries_regions ) ? $meta_data->boundaries_regions : 'world';


if ( is_array( $regions_cap ) ) {
  $current_region = isset( $meta_data->boundaries_regions['region'] ) ? $meta_data->boundaries_regions['region'] : 'world';
} else {
  $current_region = $regions_cap;
}


$fields_boundaries = [
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'boundaries',
    'label' => esc_html__( 'Enable Boundaries', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => in_array( 'boundaries',
          isset( $meta_data->boundaries ) ? (array) $meta_data->boundaries : [] ),
        'value'   => 'boundaries'
      ]
    ]
  ],
  [
    'type'  => 'group',
    'name'  => $prefix . 'boundaries_regions',
    'label' => esc_html__( 'Boundaries', 'treweler' ),
    'value' => [
      [
        'type'  => 'select',
        'name'  => 'accuracy',
        'id'    => 'treweler-boundaries-regions-accuracy',
        'label' => esc_html__( 'Accuracy', 'treweler' ),
        'value' => [
          [
            'value'    => 'very_high',
            'label'    => esc_html__( 'Very High', 'treweler' ),
            'selected' => in_array( 'very_high', isset( $meta_data->boundaries_regions['accuracy'] ) ? (array) $meta_data->boundaries_regions['accuracy'] : [] )
          ],
          [
            'value'    => 'high',
            'label'    => esc_html__( 'High', 'treweler' ),
            'selected' => in_array( 'high', isset( $meta_data->boundaries_regions['accuracy'] ) ? (array) $meta_data->boundaries_regions['accuracy'] : [] )
          ],
          [
            'value'    => 'medium',
            'label'    => esc_html__( 'Medium', 'treweler' ),
            'selected' => in_array( 'medium', isset( $meta_data->boundaries_regions['accuracy'] ) ? (array) $meta_data->boundaries_regions['accuracy'] : [ 'medium' ] )
          ],
          [
            'value'    => 'low',
            'label'    => esc_html__( 'Low', 'treweler' ),
            'selected' => in_array( 'low', isset( $meta_data->boundaries_regions['accuracy'] ) ? (array) $meta_data->boundaries_regions['accuracy'] : [] )
          ],
          [
            'value'    => 'very_low',
            'label'    => esc_html__( 'Very Low', 'treweler' ),
            'selected' => in_array( 'very_low', isset( $meta_data->boundaries_regions['accuracy'] ) ? (array) $meta_data->boundaries_regions['accuracy'] : [] )
          ]
        ]
      ],
      [
        'type'  => 'select',
        'name'  => 'region',
        'id'    => 'treweler-boundaries-regions',
        'label' => esc_html__( 'Region', 'treweler' ),
        'atts' => 'data-value="'.esc_attr($current_region).'"',
        'value' => []
      ],
    ]
  ],
  [
    'type'  => 'text',
    'name'  => $prefix . 'boundaries_regions_selected',
    'size'  => 'small',
    'label' => esc_html__( 'Region Selected', 'treweler' ),
    'value' => isset( $meta_data->boundaries_regions_selected ) ? $meta_data->boundaries_regions_selected : '[]',
  ],
  [
    'type'  => 'text',
    'name'  => $prefix . 'boundaries_regions_properties',
    'size'  => 'small',
    'label' => esc_html__( 'Regions Properties', 'treweler' ),
    'value' => isset( $meta_data->boundaries_regions_properties ) ? $meta_data->boundaries_regions_properties : '',
  ],
  [
    'type'  => 'text',
    'name'  => $prefix . 'boundaries_regions_custom_colors',
    'label' => esc_html__( 'Regions Custom Colors', 'treweler' ),
    'value' => isset( $meta_data->boundaries_regions_custom_colors ) ? $meta_data->boundaries_regions_custom_colors : '[]',
  ],
  [
    'type'  => 'text',
    'name'  => $prefix . 'boundaries_regions_hide',
    'label' => esc_html__( 'Regions Hide', 'treweler' ),
    'value' => isset( $meta_data->boundaries_regions_hide ) ? $meta_data->boundaries_regions_hide : '[]',
  ],
  [
    'type'  => 'text',
    'name'  => $prefix . 'boundaries_all_checkboxes',
    'label' => esc_html__( 'All Check Checkboxes States', 'treweler' ),
    'value' => isset( $meta_data->boundaries_all_checkboxes ) ? $meta_data->boundaries_all_checkboxes : '',
  ],
  [
    'type'  => 'text',
    'name'  => $prefix . 'boundaries_links',
    'label' => esc_html__( 'All links for regions', 'treweler' ),
    'value' => isset( $meta_data->boundaries_links ) ? $meta_data->boundaries_links : '',
  ],
  [
    'type'  => 'text',
    'name'  => $prefix . 'boundaries_values_regions',
    'label' => esc_html__( 'All values for regions', 'treweler' ),
    'value' => isset( $meta_data->boundaries_values_regions ) ? $meta_data->boundaries_values_regions : '',
  ],
  [
    'type'  => 'group',
    'name'  => $prefix . 'boundaries_fill',
    'label' => esc_html__( 'Fill Color', 'treweler' ),
    'value' => [
      [
        'type'  => 'colorpicker',
        'name'  => 'main',
        'label' => esc_html__( 'Main', 'treweler' ),
        'value' => isset( $meta_data->boundaries_fill['main'] ) ? $meta_data->boundaries_fill['main'] : '#5cc3ff'
      ],
      [
        'type'  => 'colorpicker',
        'name'  => 'hover',
        'label' => esc_html__( 'Hover', 'treweler' ),
        'value' => isset( $meta_data->boundaries_fill['hover'] ) ? $meta_data->boundaries_fill['hover'] : '#32b2fc'
      ],
      [
        'type'  => 'colorpicker',
        'name'  => 'selected',
        'label' => esc_html__( 'Selected', 'treweler' ),
        'value' => isset( $meta_data->boundaries_fill['selected'] ) ? $meta_data->boundaries_fill['selected'] : '#0a88d1'
      ],
    ]
  ],
  [
    'type'  => 'group',
    'name'  => $prefix . 'boundaries_stroke',
    'label' => esc_html__( 'Stroke Style', 'treweler' ),
    'value' => [
      [
        'type'  => 'colorpicker',
        'name'  => 'color',
        'label' => '',
        'value' => isset( $meta_data->boundaries_stroke['color'] ) ? $meta_data->boundaries_stroke['color'] : '#004e7b'
      ],
      [
        'type'        => 'text',
        'name'        => 'width',
        'postfix'     => 'px',
        'size'        => 'small',
        'placeholder' => '1',
        'label'       => '',
        'value'       => isset( $meta_data->boundaries_stroke['width'] ) ? $meta_data->boundaries_stroke['width'] : ''
      ],
    ]
  ],
  [
    'type'  => 'select',
    'name'  => $prefix . 'boundaries_onclick',
    'label' => esc_html__( 'Action On Click', 'treweler' ),
    'value' => [
      [
        'value'    => 'none',
        'label'    => esc_html__( 'None', 'treweler' ),
        'selected' => in_array( 'none',
          isset( $meta_data->boundaries_onclick ) ? (array) $meta_data->boundaries_onclick : [ 'none' ] )
      ],
      [
        'value'    => 'open_link',
        'label'    => esc_html__( 'Open Link', 'treweler' ),
        'selected' => in_array( 'open_link',
          isset( $meta_data->boundaries_onclick ) ? (array) $meta_data->boundaries_onclick : [] )
      ]
    ]
  ],
  [
    'type'  => 'group',
    'name'  => $prefix . 'boundaries_onhover',
    'label' => esc_html__( 'Action On Hover', 'treweler' ),
    'value' => [
      [
        'type'  => 'select',
        'name'  => 'type',
        'label' => '',
        'value' => [
          [
            'value'    => 'none',
            'label'    => esc_html__( 'None', 'treweler' ),
            'selected' => in_array( 'none',
              isset( $meta_data->boundaries_onhover['type'] ) ? (array) $meta_data->boundaries_onhover['type'] : [ 'none' ] )
          ],
          [
            'value'    => 'popup',
            'label'    => esc_html__( 'Popup', 'treweler' ),
            'selected' => in_array( 'popup',
              isset( $meta_data->boundaries_onhover['type'] ) ? (array) $meta_data->boundaries_onhover['type'] : [] )
          ],
          [
            'value'    => 'popup_value',
            'label'    => esc_html__( 'Popup with value', 'treweler' ),
            'selected' => in_array( 'popup_value',
              isset( $meta_data->boundaries_onhover['type'] ) ? (array) $meta_data->boundaries_onhover['type'] : [] )
          ]
        ]
      ],
      [
        'type'        => 'text',
        'name'        => 'prefix',
        'placeholder' => esc_html__( 'Prefix', 'treweler' ),
        'label'       => '',
        'value'       => isset( $meta_data->boundaries_onhover['prefix'] ) ? $meta_data->boundaries_onhover['prefix'] : ''
      ],
    ]
  ],
  [
    'type'  => 'table',
    'name'  => $prefix . 'boundaries_polygons',
    'label' => esc_html__( 'Polygon settings', 'treweler' ),
    'value' => [
      [
        'type'  => 'checkbox',
        'name'  => 'active',
        'label' => '',
        'value' => [
          [
            'label'   => '',
            'checked' => in_array( 'active',
              isset( $meta_data->boundaries_polygons['active'] ) ? (array) $meta_data->boundaries_polygons['active'] : [] ),
            'value'   => 'active'
          ]
        ]
      ],
      [
        'type'        => 'text',
        'name'        => 'name',
        'postfix'     => 'px',
        'size'        => 'small',
        'placeholder' => '',
        'label'       => esc_html__( 'Name', 'treweler' ),
        'value'       => isset( $meta_data->boundaries_polygons['name'] ) ? $meta_data->boundaries_polygons['name'] : ''
      ],
      [
        'type'  => 'colorpicker',
        'name'  => 'color',
        'label' => esc_html__( 'Custom Color', 'treweler' ),
        'value' => isset( $meta_data->boundaries_polygons['color'] ) ? $meta_data->boundaries_polygons['color'] : 'rgba(255, 255, 255, 0)'
      ],
      [
        'type'  => 'checkbox',
        'name'  => 'hide',
        'label' => esc_html__( 'Hide Region', 'treweler' ),
        'value' => [
          [
            'label'   => '',
            'checked' => in_array( 'hide',
              isset( $meta_data->boundaries_polygons['hide'] ) ? (array) $meta_data->boundaries_polygons['hide'] : [] ),
            'value'   => 'hide'
          ]
        ]
      ],
    ]
  ],

];


$customStyle = get_post_meta( $post_id, '_treweler_map_custom_style', true );
$hasCustomStyle =  trim($customStyle) === '' ? 'no' : 'yes';

?>

<div class="twer-root">
    <div class="twer-settings">
        <div class="twer-settings__body">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-2 pr-md-0">
                        <nav class="twer-tabs">
                            <div class="nav nav-tabs" id="twer-nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="twer-nav-general-tab" data-toggle="tab"
                                   href="#twer-nav-general" role="tab" aria-controls="twer-nav-general"
                                   aria-selected="true"><?php echo esc_html__( 'General', 'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-categories-tab" data-toggle="tab"
                                   href="#twer-nav-categories" role="tab" aria-controls="twer-nav-categories"
                                   aria-selected="true"><?php echo esc_html__( 'Categories', 'treweler' ); ?></a>
                                <a class="nav-item nav-link" id="twer-nav-controls-tab" data-toggle="tab"
                                   href="#twer-nav-controls" role="tab" aria-controls="twer-nav-controls"
                                   aria-selected="true"><?php echo esc_html__( 'Controls', 'treweler' ); ?></a>
                                <a class="nav-item nav-link <?php echo 'yes' === $hasCustomStyle ? 'd-none' : ''; ?>" id="twer-nav-layers-tab" data-toggle="tab"
                                   href="#twer-nav-layers" role="tab" aria-controls="twer-nav-layers"
                                   aria-selected="true"><?php echo esc_html__( 'Layers', 'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-geolocation-tab" data-toggle="tab"
                                   href="#twer-nav-geolocation" role="tab" aria-controls="twer-nav-geolocation"
                                   aria-selected="true"><?php echo esc_html__( 'Geolocation', 'treweler' ); ?></a>
                                <a class="nav-item nav-link" id="twer-nav-attribution-tab" data-toggle="tab"
                                   href="#twer-nav-attribution" role="tab" aria-controls="twer-nav-attribution"
                                   aria-selected="false"><?php echo esc_html__( 'Attribution', 'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-clusters-tab" data-toggle="tab"
                                   href="#twer-nav-clusters" role="tab" aria-controls="twer-nav-clusters"
                                   aria-selected="false"><?php echo esc_html__( 'Clustering', 'treweler' ); ?></a>
                                <a class="nav-item nav-link" id="twer-nav-lang-tab" data-toggle="tab"
                                   href="#twer-nav-lang" role="tab" aria-controls="twer-nav-lang"
                                   aria-selected="false"><?php echo esc_html__( 'Languages', 'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-widgets-tab" data-toggle="tab"
                                   href="#twer-nav-widgets" role="tab" aria-controls="twer-nav-widgets"
                                   aria-selected="false"><?php echo esc_html__( 'Information Widgets',
                                    'treweler' ); ?></a>
                                <a class="nav-item nav-link" id="twer-nav-camera-tab" data-toggle="tab"
                                   href="#twer-nav-camera" role="tab" aria-controls="twer-nav-camera"
                                   aria-selected="false"><?php echo esc_html__( 'Pitch & Bearing',
                                    'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-restrict-panning-tab" data-toggle="tab"
                                   href="#twer-nav-restrict-panning" role="tab" aria-controls="twer-nav-restrict-panning"
                                   aria-selected="false"><?php echo esc_html__( 'Restrict Panning', 'treweler' ); ?></a>
                                <a class="nav-item nav-link" id="twer-nav-preloader-tab" data-toggle="tab"
                                   href="#twer-nav-preloader" role="tab" aria-controls="twer-nav-preloader"
                                   aria-selected="false"><?php echo esc_html__( 'Preloader',
                                    'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-tour-tab" data-toggle="tab"
                                   href="#twer-nav-tour" role="tab" aria-controls="twer-nav-tour"
                                   aria-selected="false"><?php echo esc_html__( 'Tour',
                                    'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-store-locator-tab" data-toggle="tab"
                                   href="#twer-nav-store-locator" role="tab" aria-controls="twer-nav-store-locator"
                                   aria-selected="false"><?php echo esc_html__( 'Store Locator', 'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-boundaries-tab" data-toggle="tab"
                                   href="#twer-nav-boundaries" role="tab" aria-controls="twer-nav-boundaries"
                                   aria-selected="false"><?php echo esc_html__( 'Boundaries', 'treweler' ); ?></a>
                                <?php if(twerIsHasDirectionsFeature()) { ?>
                                <a class="nav-item nav-link" id="twer-nav-directions-tab" data-toggle="tab"
                                   href="#twer-nav-directions" role="tab" aria-controls="twer-nav-directions"
                                   aria-selected="false"><?php echo esc_html__( 'Directions', 'treweler' ); ?></a>
                                <?php } ?>
                            </div>
                        </nav>
                    </div>
                    <div class="col-md-9 col-lg-9 col-xl-10 pl-md-0">
                        <div class="tab-content" id="twer-Nav-tabContent">
                            <div class="tab-pane fade show active" id="twer-nav-general" role="tabpanel"
                                 aria-labelledby="twer-nav-general-tab">
                                <div class="table-responsive">
                                    <table class="table twer-table twer-table--cells-2">
                                        <tbody>


                                        <tr class="section-map-info">
                                            <th>
                                                <label for="treweler_map_projection">
                                                  <?php echo esc_html__( 'Map Projection', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <div class="twer-form-group twer-form-group--select">
                                                    <select class="large-select"
                                                            name="_treweler_map_projection"
                                                            id="treweler_map_projection">
<option value="mercator" <?php echo ( $projection === 'mercator' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Mercator', 'treweler' ); ?></option>
<option value="globe" <?php echo ( $projection === 'globe' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Globe', 'treweler' ); ?></option>
<option value="equirectangular" <?php echo ( $projection === 'equirectangular' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Equirectangular', 'treweler' ); ?></option>
<option value="lambertConformalConic" <?php echo ( $projection === 'lambertConformalConic' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Lambert Conformal Conic', 'treweler' ); ?></option>
<option value="albers" <?php echo ( $projection === 'albers' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Albers', 'treweler' ); ?></option>
<option value="winkelTripel" <?php echo ( $projection === 'winkelTripel' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Winkel Tripel', 'treweler' ); ?></option>
<option value="naturalEarth" <?php echo ( $projection === 'naturalEarth' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Natural Earth', 'treweler' ); ?></option>
<option value="equalEarth" <?php echo ( $projection === 'equalEarth' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Equal Earth', 'treweler' ); ?></option>

                                                    </select>
                                                </div>
                                            </td>
                                        </tr>






                                        <tr>
                                            <th>
                                                <label for="center-on-click">
                                                  <?php echo esc_html__( 'Center Map On Click', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                              <?php



                                              $click_checked = in_array( 'map_center_on_click',
                                                isset( $meta_data->map_center_on_click ) ? (array) $meta_data->map_center_on_click : ['map_center_on_click'] );
                                              ?>
                                                <div class="twer-form-group twer-form-group--checkbox">
                                                    <input type="hidden" name="<?php echo $prefix . 'map_center_on_click'; ?>"
                                                           value="">
                                                    <label for="center-on-click" class="twer-switcher">
                                                        <input id="center-on-click" type="checkbox"
                                                               name="<?php echo $prefix . 'map_center_on_click'; ?>[]"
                                                               value="map_center_on_click" <?php checked( $click_checked ); ?>>
                                                        <div class="twer-switcher__slider"></div>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                        $map_location_marker_templates = [
                                          [
                                            'label'    => esc_html__( 'Select a Template', 'treweler' ),
                                            'selected' => in_array( 'none',
                                              isset( $meta_data->map_location_marker['template'] ) ? (array) $meta_data->map_location_marker['template'] : [ 'none' ] ),
                                            'value'    => 'none'
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
                                            $template_selected = in_array( $template_id, isset( $meta_data->map_location_marker['template'] ) ? (array) $meta_data->map_location_marker['template'] : [] );

                                            $map_location_marker_templates[] = [
                                              'label'    => $template_label,
                                              'selected' => $template_selected,
                                              'value'    => $template_id
                                            ];
                                          }
                                        }




                                        ?>

                                        <tr class="section-treweler-store-locator-marker ">
                                            <th class="th-treweler-store-locator-marker">
                                                <label for="treweler-store-locator-marker"><?php echo esc_html__( 'Show Location Marker', 'treweler' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="twer-group-elements">
                                                    <div class="row">
                                                        <div class="col-fixed col-fixed--70 d-flex align-items-center">


                                                          <?php



                                                          $show_marker_checked = in_array( 'show',
                                                            isset( $meta_data->map_location_marker['show'] ) ? (array) $meta_data->map_location_marker['show'] : [] );
                                                          ?>
                                                            <div class="twer-form-group twer-form-group--checkbox">
                                                                <input type="hidden" name="<?php echo $prefix . 'map_location_marker[show]'; ?>"
                                                                       value="">
                                                                <label for="location-marker" class="twer-switcher">
                                                                    <input id="location-marker" type="checkbox"
                                                                           name="<?php echo $prefix . 'map_location_marker'; ?>[show][]"
                                                                           value="show" <?php checked( $show_marker_checked ); ?>>
                                                                    <div class="twer-switcher__slider"></div>
                                                                </label>
                                                            </div>


                                                        </div>
                                                        <div class="col-fixed">
                                                            <div class="twer-form-group twer-form-group--select">
                                                                <select name="_treweler_map_location_marker[template]" class="large-select" id="treweler-store-locator-marker-template">
                                                                    <?php
                                                                    foreach ($map_location_marker_templates as $localTemplate) { ?>
                                                                        <option <?php echo $localTemplate['selected'] ? 'selected="selected"' : '';  ?> value="<?php echo $localTemplate['value']; ?>"><?php echo $localTemplate['label']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                                <label for="show-map-desc">
                                                  <?php echo esc_html__( 'Show Map Description', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                              <?php
                                              $desc_checked = in_array( 'show_map_desc',
                                                isset( $meta_data->show_map_desc ) ? (array) $meta_data->show_map_desc : [] );
                                              ?>
                                                <div class="twer-form-group twer-form-group--checkbox">
                                                    <input type="hidden" name="<?php echo $prefix . 'show_map_desc'; ?>"
                                                           value="">
                                                    <label for="show-map-desc" class="twer-switcher">
                                                        <input id="show-map-desc" type="checkbox"
                                                               name="<?php echo $prefix . 'show_map_desc'; ?>[]"
                                                               value="show_map_desc" <?php checked( $desc_checked ); ?>>
                                                        <div class="twer-switcher__slider"></div>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="section-map-info row-block">
                                          <?php
                                          $map_name_font_size = $meta_data->map_name_font_size ?? '';
                                          $map_name_font_weight = $meta_data->map_name_font_weight ?? '400';
                                          $map_desc_font_size = $meta_data->map_desc_font_size ?? '';
                                          $map_desc_font_weight = $meta_data->map_desc_font_weight ?? '400';
                                          //
                                          //											$font_weight_mapping = [
                                          //												'100' => 'Thin',
                                          //												'200' => 'Extra Light',
                                          //												'300' => 'Light',
                                          //												'400' => 'Regular',
                                          //												'600' => 'Semi Bold',
                                          //												'700' => 'Bold',
                                          //												'800' => 'Extra Bold',
                                          //												'900' => 'Black',
                                          //											];

                                          ?>
                                            <th>
                                                <label for="treweler_mapbox_access_token">
                                                  <?php echo esc_html__( 'Map Name', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <div class="row">
                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <input type="text" name="_treweler_map_details_name"
                                                                   id="map_name"
                                                                   class="large-text"
                                                                   value="<?php echo esc_attr( htmlspecialchars( $name ) ) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <div class="map-text-color" id="map-text-color-name">
                                                    <span class="color-holder"
                                                          style="background-color:<?php echo esc_attr( $name_color ); ?>;"></span>
                                                                <input type="button" id="text-name-color-picker-btn"
                                                                       class="text-color-picker-btn"
                                                                       value="<?php echo esc_attr__( 'Select Color',
                                                                         'treweler' ); ?>">
                                                            </div>
                                                            <div class="color-picker-text-name"
                                                                 acp-color="<?php echo esc_attr( $name_color ); ?>"
                                                                 acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                                 default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                                 acp-show-rgb="no"
                                                                 acp-show-hsl="no"
                                                                 acp-palette-editable>
                                                            </div>
                                                            <input type="hidden" name="_treweler_map_details_name_color"
                                                                   class="input-color" id="map_name_color"
                                                                   value="<?php echo esc_attr( $name_color ); ?>">
                                                            <input type="hidden" name="addCustomColor" id="addCustomColor" value="<?php echo esc_attr( $custom_color ); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <!-- Font Size -->
                                                            <div class="twer-form-group twer-form-group--text twer-form-group--small twer-form-group--append">
                                                                <input type="number"
                                                                       min="2"
                                                                       max="100"
                                                                       id="map-name-font-size"
                                                                       name="_treweler_map_name_font_size"
                                                                       class="large-text"
                                                                       value="<?php echo esc_attr( $map_name_font_size ) ?>"
                                                                       placeholder="15">
                                                                <div class="twer-form-group-append">
                                                                    <span class="twer-form-group-append__text">px</span>
                                                                </div>
                                                            </div>
                                                            <!-- End Font Size -->
                                                        </div>
                                                    </div>

                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <!-- Font Weight -->
                                                            <div class="twer-form-group twer-form-group--select">
                                                                <select class="large-select"
                                                                        name="_treweler_map_name_font_weight"
                                                                        id="map_name_font_weight">

                                                                    <option value="100" <?php echo ( $map_name_font_weight === '100' ) ? 'selected' : '' ?>>
                                                                        Thin 100
                                                                    </option>
                                                                    <option value="200" <?php echo ( $map_name_font_weight === '200' ) ? 'selected' : '' ?>>
                                                                        Extra Light 200
                                                                    </option>
                                                                    <option value="300" <?php echo ( $map_name_font_weight === '300' ) ? 'selected' : '' ?>>
                                                                        Light 300
                                                                    </option>
                                                                    <option value="400" <?php echo ( $map_name_font_weight === '400' ) ? 'selected' : '' ?>>
                                                                        Regular 400
                                                                    </option>
                                                                    <option value="500" <?php echo ( $map_name_font_weight === '500' ) ? 'selected' : '' ?>>
                                                                        Medium 500
                                                                    </option>
                                                                    <option value="600" <?php echo ( $map_name_font_weight === '600' ) ? 'selected' : '' ?>>
                                                                        Semi Bold 600
                                                                    </option>
                                                                    <option value="700" <?php echo ( $map_name_font_weight === '700' ) ? 'selected' : '' ?>>
                                                                        Bold 700
                                                                    </option>
                                                                    <option value="800" <?php echo ( $map_name_font_weight === '800' ) ? 'selected' : '' ?>>
                                                                        Extra Bold 800
                                                                    </option>
                                                                    <option value="900" <?php echo ( $map_name_font_weight === '900' ) ? 'selected' : '' ?>>
                                                                        Black 900
                                                                    </option>

                                                                </select>
                                                            </div>
                                                            <!-- End Font Weight -->
                                                        </div>
                                                    </div>
                                                </div>


                                            </td>
                                        </tr>


                                        <tr class="section-map-info row-block">

                                            <th>
                                                <label for="treweler_mapbox_access_token">
                                                  <?php echo esc_html__( 'Map Description', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <div class="row">
                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <input type="text" name="_treweler_map_details_description"
                                                                   id="map_description" class="large-text"
                                                                   value="<?php echo esc_attr( htmlspecialchars( $desc ) ) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <div class="map-text-color" id="map-text-color-descr">
                                                    <span class="color-holder"
                                                          style="background-color:<?php echo esc_attr( $desc_color ); ?>;"></span>
                                                                <input type="button" id="text-descr-color-picker-btn"
                                                                       class="text-color-picker-btn"
                                                                       value="<?php echo esc_attr__( 'Select Color',
                                                                         'treweler' ); ?>">
                                                            </div>
                                                            <div class="color-picker-text-descr"
                                                                 acp-color="<?php echo esc_attr( $desc_color ); ?>"
                                                                 acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                                 default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                                 acp-show-rgb="no"
                                                                 acp-show-hsl="no"
                                                                 acp-palette-editable>
                                                            </div>
                                                            <input type="hidden"
                                                                   name="_treweler_map_details_description_color"
                                                                   class="input-color" id="map_description_color"
                                                                   value="<?php echo esc_attr( $desc_color ); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <!-- Font Size -->
                                                            <div class="twer-form-group twer-form-group--text twer-form-group--small twer-form-group--append">
                                                                <input type="number"
                                                                       min="2"
                                                                       max="100"
                                                                       id="map-name-font-size"
                                                                       name="_treweler_map_desc_font_size"
                                                                       class="large-text"
                                                                       value="<?php echo esc_attr( $map_desc_font_size ) ?>"
                                                                       placeholder="12">
                                                                <div class="twer-form-group-append">
                                                                    <span class="twer-form-group-append__text">px</span>
                                                                </div>
                                                            </div>
                                                            <!-- End Font Size -->
                                                        </div>
                                                    </div>

                                                    <div class="t-col">
                                                        <div class="field-wrapper">
                                                            <!-- Font Weight -->
                                                            <div class="twer-form-group twer-form-group--select">
                                                                <select class="large-select"
                                                                        name="_treweler_map_desc_font_weight"
                                                                        id="map_desc_font_weight">

                                                                    <option value="100" <?php echo ( $map_desc_font_weight === '100' ) ? 'selected' : '' ?>>
                                                                        Thin 100
                                                                    </option>
                                                                    <option value="200" <?php echo ( $map_desc_font_weight === '200' ) ? 'selected' : '' ?>>
                                                                        Extra Light 200
                                                                    </option>
                                                                    <option value="300" <?php echo ( $map_desc_font_weight === '300' ) ? 'selected' : '' ?>>
                                                                        Light 300
                                                                    </option>
                                                                    <option value="400" <?php echo ( $map_desc_font_weight === '400' ) ? 'selected' : '' ?>>
                                                                        Regular 400
                                                                    </option>
                                                                    <option value="500" <?php echo ( $map_desc_font_weight === '500' ) ? 'selected' : '' ?>>
                                                                        Medium 500
                                                                    </option>
                                                                    <option value="600" <?php echo ( $map_desc_font_weight === '600' ) ? 'selected' : '' ?>>
                                                                        Semi Bold 600
                                                                    </option>
                                                                    <option value="700" <?php echo ( $map_desc_font_weight === '700' ) ? 'selected' : '' ?>>
                                                                        Bold 700
                                                                    </option>
                                                                    <option value="800" <?php echo ( $map_desc_font_weight === '800' ) ? 'selected' : '' ?>>
                                                                        Extra Bold 800
                                                                    </option>
                                                                    <option value="900" <?php echo ( $map_desc_font_weight === '900' ) ? 'selected' : '' ?>>
                                                                        Black 900
                                                                    </option>

                                                                </select>
                                                            </div>
                                                            <!-- End Font Weight -->
                                                        </div>
                                                    </div>
                                                </div>


                                            </td>
                                        </tr>

                                        <tr class="section-map-info">
                                            <th>
                                                <label for="treweler_mapbox_access_token">
                                                  <?php echo esc_html__( 'Position', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <div class="twer-form-group twer-form-group--select">
                                                    <select class="large-select"
                                                            name="_treweler_map_details_position"
                                                            id="descr_position">
                                                        <option value="top_left" <?php echo ( $position == 'top_left' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Top Left',
                                                            'treweler' ); ?></option>
                                                        <option value="top_right" <?php echo ( $position == 'top_right' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Top Right',
                                                            'treweler' ); ?></option>
                                                        <option value="bottom_left" <?php echo ( $position == 'bottom_left' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Bottom Left',
                                                            'treweler' ); ?></option>
                                                        <option value="bottom_right" <?php echo ( $position == 'bottom_right' ) ? 'selected' : '' ?>><?php echo esc_html__( 'Bottom Right',
                                                            'treweler' ); ?></option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="section-map-info">
                                            <th>
                                                <label for="map-main-logo">
                                                  <?php echo esc_html__( 'Map Logo', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>


                                                <div class="twer-attach js-twer-attach-wrap">

                                                    <div class="twer-attach__thumb js-twer-attach-thumb">
                                                      <?php

                                                      $map_logo = isset( $meta_data->map_main_logo ) ? $meta_data->map_main_logo : '';
                                                      if ( is_numeric( $map_logo ) ) {
                                                        $attachment = wp_get_attachment_image_src( $map_logo, 'full' );
                                                        $attachment = isset( $attachment[0] ) ? $attachment[0] : $map_logo;
                                                      } else {
                                                        $attachment = $map_logo;
                                                      }

                                                      if ( ! empty( $map_logo ) ) { ?>
                                                          <img src="<?php echo esc_url( $attachment ); ?>" alt="">
                                                      <?php } ?>
                                                        <button type="button"
                                                                id="<?php echo esc_attr( 'map-main-logo' ); ?>"
                                                                style="<?php echo ! empty( $map_logo ) ? 'display:none;' : 'display:block'; ?>"
                                                                class="twer-attach__add-media js-twer-attach-add">
                                                          <?php echo esc_html__( 'Select Image',
                                                            'treweler' ); ?>
                                                        </button>

                                                        <input type="hidden"
                                                               name="<?php echo esc_attr( $prefix . 'map_main_logo' ); ?>"
                                                               value="<?php echo esc_attr( $map_logo ); ?>">
                                                    </div>

                                                    <div class="twer-attach__actions js-twer-attach-actions"
                                                         style="<?php echo ! empty( $map_logo ) ? 'display:block;' : 'display:none'; ?>">
                                                        <button type="button"
                                                                class="button js-twer-attach-remove"><?php echo esc_html__( 'Remove',
                                                            'treweler' ); ?></button>
                                                        <button type="button"
                                                                class="button js-twer-attach-add"><?php echo esc_html__( 'Change image',
                                                            'treweler' ); ?></button>
                                                    </div>
                                                </div>


                                            </td>
                                        </tr>


                                        <tr class="section-map-info">
                                            <th>
                                                <label for="treweler_mapbox_logo-size">
                                                  <?php echo esc_html__( 'Logo Size', 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <div class="twer-form-group twer-form-group--text twer-form-group--small twer-form-group--append">
                                                    <input type="text" id="treweler_mapbox_logo-size" name="_treweler_map_details_logo_size" class="large-text" value="<?php echo esc_attr( $logoSize ); ?>" placeholder="40">
                                                    <div class="twer-form-group-append">
                                                        <span class="twer-form-group-append__text">px</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                        <?php

                                        $logo_url = get_post_meta( $post_id, '_treweler_map_logo_url', true );
                                        $logo_target = get_post_meta( $post_id, '_treweler_map_logo_target', true );
                                        if ( is_array( $logo_target ) ) {
                                          $logo_target = $logo_target[0];
                                        }


                                        ?>
                                        <tr class="twer-tr-toggle">
                                            <th class="th-treweler-popup-button">
                                                <label for="treweler-popup-button"><?php echo esc_html__( 'Link', 'treweler' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="twer-group-elements">
                                                    <div class="row">

                                                        <div class="col-fixed col-fixed--260">
                                                            <label for="treweler-map-logo-url"><?php echo esc_html__( 'URL', 'treweler' ); ?></label>
                                                            <div class="twer-form-group twer-form-group--text ">
                                                                <input type="url" id="treweler-map-logo-url" name="_treweler_map_logo_url" class="large-text" value="<?php echo esc_url( $logo_url ); ?>">
                                                            </div>


                                                        </div>

                                                        <div class="col-fixed">
                                                            <label for="treweler-map-logo-target"><?php echo esc_html__( 'Open in new tab', 'treweler' ); ?></label>
                                                            <input type="hidden" name="_treweler_map_logo_target" value="">
                                                            <label for="treweler-map-logo-target" class="twer-switcher">
                                                                <input type="checkbox" <?php checked( $logo_target, 'target' ); ?> name="_treweler_map_logo_target[]" id="treweler-map-logo-target" value="target">
                                                                <div class="twer-switcher__slider"></div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>



                                        <tr class="twer-tr-toggle">
                                            <th class="th-treweler-popup-button">
                                                <label for="treweler-popup-button"><?php echo esc_html__( 'CSS Classes', 'treweler' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="twer-group-elements">
                                                    <div class="row">
                                                        <div class="col-fixed col-fixed--260">
                                                            <div class="twer-form-group twer-form-group--text ">
                                                                <input type="text" id="treweler-map-logo-url" name="_treweler_map_css_class" class="large-text" value="<?php echo esc_attr( $map_css_class ); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="twer-nav-categories" role="tabpanel" aria-labelledby="twer-nav-categories-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>
                            <div class="tab-pane fade" id="twer-nav-controls" role="tabpanel" aria-labelledby="twer-nav-controls-tab">
                                <?php

                                $fields_controls = getControlsSettings();
                                theStoreLocatorFields($fields_controls);
                                ?>
                            </div>
                            <div class="tab-pane fade" id="twer-nav-layers" role="tabpanel" aria-labelledby="twer-nav-layers-tab">
                              <?php

                              $fields_layers = getLayerSettings();
                              theStoreLocatorFields($fields_layers);
                              ?>
                            </div>
                            <div class="tab-pane fade" id="twer-nav-geolocation" role="tabpanel" aria-labelledby="twer-nav-geolocation-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>
                            <div class="tab-pane fade" id="twer-nav-attribution" role="tabpanel" aria-labelledby="twer-nav-attribution-tab">
                                <?php $fields_attribution = getAttributionSettings();
                                theStoreLocatorFields($fields_attribution);
                                ?>
                            </div>
                            <div class="tab-pane fade" id="twer-nav-clusters" role="tabpanel" aria-labelledby="twer-nav-clusters-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>
                            <div class="tab-pane fade" id="twer-nav-lang" role="tabpanel" aria-labelledby="twer-nav-lang-tab">
                              <?php
                              $fields_languanges = getLanguageSettings();
                              theStoreLocatorFields($fields_languanges);
                              ?>
                            </div>

                            <div class="tab-pane fade" id="twer-nav-widgets" role="tabpanel" aria-labelledby="twer-nav-widgets-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>

                            <!-- Pitch & Bearing Widget -->
                            <div class="tab-pane fade" id="twer-nav-camera" role="tabpanel"
                                 aria-labelledby="twer-nav-camera-tab">
                                <div class="table-responsive">
                                    <table class="table twer-table twer-table--cells-2">
                                        <tbody>
                                        <?php foreach ( $fields_camera as $field ) {
                                          $element_id = trim( str_replace( '_', '-', $field['name'] ), '-' );
                                          ?>
                                            <tr class="section-<?php echo esc_attr( $element_id ); ?>">
                                                <th class="th-<?php echo esc_attr( $element_id ); ?>">
                                                    <label for="<?php echo esc_attr( $element_id ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
                                                </th>
                                                <td>
                                                  <?php if ( 'select' === $field['type'] ) { ?>
                                                      <div class="twer-form-group twer-form-group--select">
                                                          <select name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                  class="large-select"
                                                                  id="<?php echo esc_attr( $element_id ); ?>">
                                                            <?php foreach ( $field['value'] as $data ) { ?>
                                                                <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                            <?php } ?>
                                                          </select>
                                                      </div>
                                                  <?php } elseif ( 'number-v2' === $field['type'] ) {
                                                    $num_value = $field['value']['current'] ?? '';
                                                    $num_min = $field['value']['min'] ?? '';
                                                    $num_max = $field['value']['max'] ?? '';
                                                    $num_step = $field['value']['step'] ?? '';
                                                    ?>
                                                      <div class="twer-form-group twer-form-group--text">
                                                          <input type="number"
                                                                 name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                 id="<?php echo esc_attr( $element_id ); ?>"
                                                                 value="<?php echo esc_attr( $num_value ) ?>"
                                                                 step="<?php echo esc_attr( $num_step ); ?>"
                                                                 min="<?php echo esc_attr( $num_min ); ?>"
                                                                 max="<?php echo esc_attr( $num_max ); ?>"
                                                                 class="large-text" style="width: 90px">
                                                      </div>
                                                  <?php } elseif ( 'multirange' === $field['type'] ) { ?>
                                                      <div class="multirange-wrapper">
                                                        <?php
                                                        $name = $field['fields'][0]['name'] ?? '';
                                                        $num_value = $field['fields'][0]['value']['current'] ?? '';
                                                        $num_min = $field['fields'][0]['value']['min'] ?? '';
                                                        $num_max = $field['fields'][0]['value']['max'] ?? '';
                                                        $num_step = $field['fields'][0]['value']['step'] ?? '';

                                                        $name_right = $field['fields'][1]['name'] ?? '';
                                                        $num_right_value = $field['fields'][1]['value']['current'] ?? '';
                                                        $num_right_min = $field['fields'][1]['value']['min'] ?? '';
                                                        $num_right_max = $field['fields'][1]['value']['max'] ?? '';
                                                        $num_right_step = $field['fields'][1]['value']['step'] ?? '';
                                                        ?>
                                                          <p class="multirange">
                                                              <input type="range"
                                                                     step="<?php echo esc_attr( $num_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_max ); ?>"
                                                                     name="<?php echo esc_attr( $name ); ?>"
                                                                     id="range-<?php echo esc_attr( $element_id ); ?>"
                                                                     value="<?php echo esc_attr( $num_value ); ?>"
                                                                     class="large-text lower-slider"/>
                                                              <input type="range"
                                                                     step="<?php echo esc_attr( $num_right_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_right_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_right_max ); ?>"
                                                                     name="<?php echo esc_attr( $name_right ); ?>"
                                                                     id="range-<?php echo esc_attr( $element_id ); ?>-right"
                                                                     value="<?php echo esc_attr( $num_right_value ); ?>"
                                                                     class="large-text upper-slider"/>
                                                          </p>
                                                          <p class="range-ctrl-label">
                                                              <input type="number"
                                                                     step="<?php echo esc_attr( $num_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_max ); ?>"
                                                                     id="num-<?php echo esc_attr( $element_id ); ?>"
                                                                     value="<?php echo esc_attr( $num_value ); ?>"
                                                                     class="alighleft"/>
                                                              <input type="number"
                                                                     step="<?php echo esc_attr( $num_right_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_right_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_right_max ); ?>"
                                                                     id="num-<?php echo esc_attr( $element_id ); ?>-right"
                                                                     value="<?php echo esc_attr( $num_right_value ); ?>"
                                                                     class="alignright"/>
                                                          </p>
                                                      </div>
                                                  <?php } elseif ( 'range' === $field['type'] ) {

                                                    $range_value = isset( $field['value']['current'] ) ? $field['value']['current'] : '';
                                                    $range_min = isset( $field['value']['min'] ) ? $field['value']['min'] : '';
                                                    $range_max = isset( $field['value']['max'] ) ? $field['value']['max'] : '';
                                                    $range_step = isset( $field['value']['step'] ) ? $field['value']['step'] : '';
                                                    ?>
                                                      <div class="twer-range js-twer-range">
                                                          <input type="range"
                                                                 step="<?php echo esc_attr( $range_step ); ?>"
                                                                 min="<?php echo esc_attr( $range_min ); ?>"
                                                                 max="<?php echo esc_attr( $range_max ); ?>"
                                                                 id="<?php echo esc_attr( $element_id ); ?>-range"
                                                                 class="large-text js-zoom-range" data-id="range"
                                                                 value="<?php echo esc_attr( $range_value ); ?>"/>
                                                          <input type="number"
                                                                 step="<?php echo esc_attr( $range_step ); ?>"
                                                                 min="<?php echo esc_attr( $range_min ); ?>"
                                                                 max="<?php echo esc_attr( $range_max ); ?>"
                                                                 name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                 id="<?php echo esc_attr( $element_id ); ?>"
                                                                 data-id="range-input"
                                                                 class="large-text js-zoom-range-input"
                                                                 value="<?php echo esc_attr( $range_value ); ?>"/>
                                                        <?php if ( ! empty( $field['help'] ) ) { ?>
                                                            <a href="#" class="twer-help-tooltip"
                                                               data-toggle="tooltip"
                                                               title="<?php echo esc_attr( $field['help'] ); ?>"><span
                                                                        class="dashicons dashicons-editor-help"></span></a>
                                                        <?php } ?>
                                                      </div>
                                                  <?php } elseif ( 'checkbox' === $field['type'] ) { ?>
                                                      <input type="hidden"
                                                             name="<?php echo esc_attr( $field['name'] ); ?>"
                                                             value="">
                                                    <?php foreach ( $field['value'] as $data ) { ?>
                                                          <label for="<?php echo esc_attr( $element_id ) ?>"
                                                                 class="twer-switcher">
                                                              <input type="checkbox"
                                                                     name="<?php echo esc_attr( $field['name'] ); ?>[]"
                                                                     id="<?php echo esc_attr( $element_id ); ?>"
                                                                     value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                              <div class="twer-switcher__slider"></div>
                                                          </label>
                                                    <?php } ?>
                                                  <?php } elseif ( 'colorpicker' === $field['type'] ) { ?>
                                                      <div class="js-twer-color-picker-wrap twer-color-picker-wrap">
                                                          <div class="map-text-color js-twer-color-picker">
                                                                <span class="color-holder"
                                                                      style="background-color:<?php echo esc_attr( $field['value'] ) ?>;"></span>
                                                              <input type="button" class="text-color-picker-btn"
                                                                     value="<?php echo esc_attr__( 'Select Color',
                                                                       'treweler' ); ?>">
                                                          </div>
                                                          <!-- .color-picker-text-descr -->
                                                          <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                               acp-color="<?php echo esc_attr( $field['value'] ) ?>"
                                                               acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                               default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                               acp-show-rgb="no"
                                                               acp-show-hsl="no"
                                                               acp-palette-editable>
                                                          </div>
                                                          <input type="hidden"
                                                                 name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                 class="input-color"
                                                                 value="<?php echo esc_attr( $field['value'] ) ?>">
                                                      </div>


                                                  <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <!-- End twer-nav-camera -->

                            <div class="tab-pane fade" id="twer-nav-restrict-panning" role="tabpanel" aria-labelledby="twer-nav-restrict-panning-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>


                            <!-- Preloader -->
                            <div class="tab-pane fade" id="twer-nav-preloader" role="tabpanel"
                                 aria-labelledby="twer-nav-preloader-tab">
                                <div class="table-responsive">
                                    <table class="table twer-table twer-table--cells-2">
                                        <tbody>
                                        <?php foreach ( $fields_preloader as $field ) {
                                          $element_id = trim( str_replace( '_', '-', $field['name'] ), '-' );
                                          ?>
                                            <tr class="section-<?php echo esc_attr( $element_id ); ?>">
                                                <th class="th-<?php echo esc_attr( $element_id ); ?>">
                                                    <label for="<?php echo esc_attr( $element_id ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
                                                </th>
                                                <td>
                                                  <?php if ( 'select' === $field['type'] ) { ?>
                                                      <div class="twer-form-group twer-form-group--select">
                                                          <select name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                  class="large-select"
                                                                  id="<?php echo esc_attr( $element_id ); ?>">
                                                            <?php foreach ( $field['value'] as $data ) { ?>
                                                                <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                            <?php } ?>
                                                          </select>
                                                      </div>
                                                  <?php } elseif ( 'number-v2' === $field['type'] ) {
                                                    $num_value = $field['value']['current'] ?? '';
                                                    $num_min = $field['value']['min'] ?? '';
                                                    $num_max = $field['value']['max'] ?? '';
                                                    $num_step = $field['value']['step'] ?? '';
                                                    ?>
                                                      <div class="twer-form-group twer-form-group--text">
                                                          <input type="number"
                                                                 name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                 id="<?php echo esc_attr( $element_id ); ?>"
                                                                 value="<?php echo esc_attr( $num_value ) ?>"
                                                                 step="<?php echo esc_attr( $num_step ); ?>"
                                                                 min="<?php echo esc_attr( $num_min ); ?>"
                                                                 max="<?php echo esc_attr( $num_max ); ?>"
                                                                 class="large-text" style="width: 90px">
                                                      </div>
                                                  <?php } elseif ( 'multirange' === $field['type'] ) { ?>
                                                      <div class="multirange-wrapper">
                                                        <?php
                                                        $name = $field['fields'][0]['name'] ?? '';
                                                        $num_value = $field['fields'][0]['value']['current'] ?? '';
                                                        $num_min = $field['fields'][0]['value']['min'] ?? '';
                                                        $num_max = $field['fields'][0]['value']['max'] ?? '';
                                                        $num_step = $field['fields'][0]['value']['step'] ?? '';

                                                        $name_right = $field['fields'][1]['name'] ?? '';
                                                        $num_right_value = $field['fields'][1]['value']['current'] ?? '';
                                                        $num_right_min = $field['fields'][1]['value']['min'] ?? '';
                                                        $num_right_max = $field['fields'][1]['value']['max'] ?? '';
                                                        $num_right_step = $field['fields'][1]['value']['step'] ?? '';
                                                        ?>
                                                          <p class="multirange">
                                                              <input type="range"
                                                                     step="<?php echo esc_attr( $num_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_max ); ?>"
                                                                     name="<?php echo esc_attr( $name ); ?>"
                                                                     id="range-<?php echo esc_attr( $element_id ); ?>"
                                                                     value="<?php echo esc_attr( $num_value ); ?>"
                                                                     class="large-text lower-slider"/>
                                                              <input type="range"
                                                                     step="<?php echo esc_attr( $num_right_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_right_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_right_max ); ?>"
                                                                     name="<?php echo esc_attr( $name_right ); ?>"
                                                                     id="range-<?php echo esc_attr( $element_id ); ?>-right"
                                                                     value="<?php echo esc_attr( $num_right_value ); ?>"
                                                                     class="large-text upper-slider"/>
                                                          </p>
                                                          <p class="range-ctrl-label">
                                                              <input type="number"
                                                                     step="<?php echo esc_attr( $num_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_max ); ?>"
                                                                     id="num-<?php echo esc_attr( $element_id ); ?>"
                                                                     value="<?php echo esc_attr( $num_value ); ?>"
                                                                     class="alighleft"/>
                                                              <input type="number"
                                                                     step="<?php echo esc_attr( $num_right_step ); ?>"
                                                                     min="<?php echo esc_attr( $num_right_min ); ?>"
                                                                     max="<?php echo esc_attr( $num_right_max ); ?>"
                                                                     id="num-<?php echo esc_attr( $element_id ); ?>-right"
                                                                     value="<?php echo esc_attr( $num_right_value ); ?>"
                                                                     class="alignright"/>
                                                          </p>
                                                      </div>
                                                  <?php } elseif ( 'range' === $field['type'] ) {

                                                    $range_value = isset( $field['value']['current'] ) ? $field['value']['current'] : '';
                                                    $range_min = isset( $field['value']['min'] ) ? $field['value']['min'] : '';
                                                    $range_max = isset( $field['value']['max'] ) ? $field['value']['max'] : '';
                                                    $range_step = isset( $field['value']['step'] ) ? $field['value']['step'] : '';
                                                    ?>
                                                      <div class="twer-range js-twer-range">
                                                          <input type="range"
                                                                 step="<?php echo esc_attr( $range_step ); ?>"
                                                                 min="<?php echo esc_attr( $range_min ); ?>"
                                                                 max="<?php echo esc_attr( $range_max ); ?>"
                                                                 id="<?php echo esc_attr( $element_id ); ?>-range"
                                                                 class="large-text js-zoom-range" data-id="range"
                                                                 value="<?php echo esc_attr( $range_value ); ?>"/>
                                                          <input type="number"
                                                                 step="<?php echo esc_attr( $range_step ); ?>"
                                                                 min="<?php echo esc_attr( $range_min ); ?>"
                                                                 max="<?php echo esc_attr( $range_max ); ?>"
                                                                 name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                 id="<?php echo esc_attr( $element_id ); ?>"
                                                                 data-id="range-input"
                                                                 class="large-text js-zoom-range-input"
                                                                 value="<?php echo esc_attr( $range_value ); ?>"/>
                                                        <?php if ( ! empty( $field['help'] ) ) { ?>
                                                            <a href="#" class="twer-help-tooltip"
                                                               data-toggle="tooltip"
                                                               title="<?php echo esc_attr( $field['help'] ); ?>"><span
                                                                        class="dashicons dashicons-editor-help"></span></a>
                                                        <?php } ?>
                                                      </div>
                                                  <?php } elseif ( 'checkbox' === $field['type'] ) { ?>
                                                      <input type="hidden"
                                                             name="<?php echo esc_attr( $field['name'] ); ?>"
                                                             value="">
                                                    <?php foreach ( $field['value'] as $data ) { ?>
                                                          <label for="<?php echo esc_attr( $element_id ) ?>"
                                                                 class="twer-switcher">
                                                              <input type="checkbox"
                                                                     name="<?php echo esc_attr( $field['name'] ); ?>[]"
                                                                     id="<?php echo esc_attr( $element_id ); ?>"
                                                                     value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                              <div class="twer-switcher__slider"></div>
                                                          </label>
                                                    <?php } ?>
                                                  <?php } elseif ( 'colorpicker' === $field['type'] ) { ?>
                                                      <div class="js-twer-color-picker-wrap twer-color-picker-wrap">
                                                          <div class="map-text-color js-twer-color-picker">
                                                                <span class="color-holder"
                                                                      style="background-color:<?php echo esc_attr( $field['value'] ) ?>;"></span>
                                                              <input type="button" class="text-color-picker-btn"
                                                                     value="<?php echo esc_attr__( 'Select Color',
                                                                       'treweler' ); ?>">
                                                          </div>
                                                          <!-- .color-picker-text-descr -->
                                                          <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                               acp-color="<?php echo esc_attr( $field['value'] ) ?>"
                                                               acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                               default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                               acp-show-rgb="no"
                                                               acp-show-hsl="no"
                                                               acp-palette-editable>
                                                          </div>
                                                          <input type="hidden"
                                                                 name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                 class="input-color"
                                                                 value="<?php echo esc_attr( $field['value'] ) ?>">
                                                      </div>


                                                  <?php } elseif ( 'textcolorpicker' === $field['type'] ) { ?>
                                                      <div class="textcolorpicker text-color-picker-left">
                                                          <input type="text"
                                                                 name="<?php echo esc_attr( $field['fields'][0]['name'] ) ?>"
                                                                 id="map_description" class="large-text"
                                                                 value="<?php echo esc_attr( htmlspecialchars( $field['fields'][0]['value'] ) ) ?>">
                                                      </div>
                                                      <div class="textcolorpicker text-color-picker-right">

                                                          <div class="js-twer-color-picker-wrap twer-color-picker-wrap">
                                                              <div class="map-text-color js-twer-color-picker">
                                                                <span class="color-holder"
                                                                      style="background-color:<?php echo esc_attr( $field['fields'][1]['value'] ) ?>;"></span>
                                                                  <input type="button" class="text-color-picker-btn"
                                                                         value="<?php echo esc_attr__( 'Select Color',
                                                                           'treweler' ); ?>">
                                                              </div>
                                                              <!-- .color-picker-text-descr -->
                                                              <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                                   acp-color="<?php echo esc_attr( $field['fields'][1]['value'] ) ?>"
                                                                   acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                                   default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                                   acp-show-rgb="no"
                                                                   acp-show-hsl="no"
                                                                   acp-palette-editable>
                                                              </div>
                                                              <input type="hidden"
                                                                     name="<?php echo esc_attr( $field['fields'][1]['name'] ); ?>"
                                                                     class="input-color"
                                                                     value="<?php echo esc_attr( $field['fields'][1]['value'] ) ?>">
                                                          </div>

                                                      </div>
                                                  <?php } elseif ( 'image' === $field['type'] ) { ?>
                                                      <div class="twer-attach js-twer-attach-wrap">


                                                        <?php


                                                        if ( is_numeric( $field['value'] ) ) {
                                                          $attachment = wp_get_attachment_image_src( $field['value'], 'full' );
                                                          $attachment = isset( $attachment[0] ) ? $attachment[0] : $field['value'];
                                                        } else {
                                                          $attachment = $field['value'];
                                                        }

                                                        ?>

                                                          <div class="twer-attach__thumb js-twer-attach-thumb">
                                                            <?php if ( ! empty( $attachment ) ) { ?>
                                                                <img src="<?php echo esc_url( $attachment ); ?>" alt="">
                                                            <?php } ?>
                                                              <button type="button"
                                                                      id="<?php echo esc_attr( $element_id ); ?>"
                                                                      style="<?php echo ! empty( $attachment ) ? 'display:none;' : 'display:block'; ?>"
                                                                      class="twer-attach__add-media js-twer-attach-add">
                                                                <?php echo esc_html__( 'Select Image',
                                                                  'treweler' ); ?>
                                                              </button>

                                                              <input type="hidden"
                                                                     name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                     value="<?php echo esc_attr( $field['value'] ) ?>">
                                                          </div>

                                                          <div class="twer-attach__actions js-twer-attach-actions"
                                                               style="<?php echo ! empty( $attachment ) ? 'display:block;' : 'display:none'; ?>">
                                                              <button type="button"
                                                                      class="button js-twer-attach-remove"><?php echo esc_html__( 'Remove',
                                                                  'treweler' ); ?></button>
                                                              <button type="button"
                                                                      class="button js-twer-attach-add"><?php echo esc_html__( 'Change image',
                                                                  'treweler' ); ?></button>
                                                          </div>
                                                      </div>
                                                  <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End of Preloader -->


                            <!-- Tour -->
                            <div class="tab-pane fade" id="twer-nav-tour" role="tabpanel" aria-labelledby="twer-nav-tour-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>
                            <!-- End of Tour -->


                            <!-- Store-locator -->
                            <div class="tab-pane fade" id="twer-nav-store-locator" role="tabpanel" aria-labelledby="twer-nav-store-locator-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>
                            <!-- End of Store-locator -->


                            <!-- Boundaries -->
                            <div class="tab-pane fade" id="twer-nav-boundaries" role="tabpanel" aria-labelledby="twer-nav-boundaries-tab">
                              <?php twerGoToProNotice(); ?>
                            </div>
                            <!-- End of Boundaries -->

                            <?php if(twerIsHasDirectionsFeature()) {  ?>
                            <div class="tab-pane fade" id="twer-nav-directions" role="tabpanel" aria-labelledby="twer-nav-directions-tab">
                              <?php
                              $fieldsDirections = getDirectionsSettings();
                              theStoreLocatorFields($fieldsDirections);
                              ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
