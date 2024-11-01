<?php

function getMarkerPopupStylesSettings() {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;


  $prefix = '_treweler_';
  $meta_data = twer_get_data( $post_id );


  $template_data = [];
  $current_template = isset( $meta_data->templates ) ? $meta_data->templates : 'none';
  if ( 'none' !== $current_template && ! empty( $current_template ) ) {
    $template_data = template_meta_diff( twer_get_data( $current_template ) );
  }

  $options = [
    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'popup_show',
      'label' => esc_html__( 'Show popup', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'popup_show',
            isset( $meta_data->popup_show ) ? (array) $meta_data->popup_show : [] ),
          'value'   => 'popup_show'
        ]
      ]
    ],
  ];

  if(TWER_IS_FREE || TWER_OLD_POPUP_FIELDS) {
    $options[] = [
      'type'  => 'group_simple',
      'name'  => $prefix . 'popup_heading_settings',
      'label' => esc_html__( 'Heading', 'treweler' ),
      'value' => [
        [
          'type'  => 'text',
          'name'  => $prefix . 'popup_heading',
          'value' => isset( $meta_data->popup_heading ) ? $meta_data->popup_heading : ''
        ],
        [
          'type'        => 'text',
          'postfix'     => 'px',
          'size'        => 'small',
          'name'        => $prefix . 'popup_heading_size',
          'value'       => isset( $meta_data->popup_heading_size ) ? $meta_data->popup_heading_size : '',
          'placeholder' => '16'
        ],
        [
          'type'  => 'select',
          'name'  => $prefix . 'popup_heading_font_weight',
          'value' => [
            [
              'label'    => esc_html__( 'Thin 100', 'treweler' ),
              'selected' => in_array( '100',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [] ),
              'value'    => '100'
            ],
            [
              'label'    => esc_html__( 'Extra Light 200', 'treweler' ),
              'selected' => in_array( '200',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [] ),
              'value'    => '200'
            ],
            [
              'label'    => esc_html__( 'Light 300', 'treweler' ),
              'selected' => in_array( '300',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [] ),
              'value'    => '300'
            ],
            [
              'label'    => esc_html__( 'Regular 400', 'treweler' ),
              'selected' => in_array( '400',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [ '400' ] ),
              'value'    => '400'
            ],
            [
              'label'    => esc_html__( 'Medium 500', 'treweler' ),
              'selected' => in_array( '500',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [] ),
              'value'    => '500'
            ],
            [
              'label'    => esc_html__( 'Semi Bold 600', 'treweler' ),
              'selected' => in_array( '600',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [] ),
              'value'    => '600'
            ],
            [
              'label'    => esc_html__( 'Bold 700', 'treweler' ),
              'selected' => in_array( '700',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [ ] ),
              'value'    => '700'
            ],
            [
              'label'    => esc_html__( 'Extra Bold 800', 'treweler' ),
              'selected' => in_array( '800',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [] ),
              'value'    => '800'
            ],
            [
              'label'    => esc_html__( 'Black 900', 'treweler' ),
              'selected' => in_array( '900',
                isset( $meta_data->popup_heading_font_weight ) ? (array) $meta_data->popup_heading_font_weight : [] ),
              'value'    => '900'
            ],
          ]
        ],
      ]
    ];
    $options[] = [
      'type'  => 'group_simple',
      'name'  => $prefix . 'popup_subheading_settings',
      'label' => esc_html__( 'Subheading', 'treweler' ),
      'value' => [
        [
          'type'  => 'text',
          'name'  => $prefix . 'popup_subheading',
          'value' => isset( $meta_data->popup_subheading ) ? $meta_data->popup_subheading : ''
        ],
        [
          'type'        => 'text',
          'postfix'     => 'px',
          'size'        => 'small',
          'name'        => $prefix . 'popup_subheading_size',
          'value'       => isset( $meta_data->popup_subheading_size ) ? $meta_data->popup_subheading_size : '',
          'placeholder' => '13'
        ],
        [
          'type'  => 'select',
          'name'  => $prefix . 'popup_subheading_font_weight',
          'value' => [
            [
              'label'    => esc_html__( 'Thin 100', 'treweler' ),
              'selected' => in_array( '100',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '100'
            ],
            [
              'label'    => esc_html__( 'Extra Light 200', 'treweler' ),
              'selected' => in_array( '200',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '200'
            ],
            [
              'label'    => esc_html__( 'Light 300', 'treweler' ),
              'selected' => in_array( '300',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '300'
            ],
            [
              'label'    => esc_html__( 'Regular 400', 'treweler' ),
              'selected' => in_array( '400',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [ '400' ] ),
              'value'    => '400'
            ],
            [
              'label'    => esc_html__( 'Medium 500', 'treweler' ),
              'selected' => in_array( '500',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '500'
            ],
            [
              'label'    => esc_html__( 'Semi Bold 600', 'treweler' ),
              'selected' => in_array( '600',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '600'
            ],
            [
              'label'    => esc_html__( 'Bold 700', 'treweler' ),
              'selected' => in_array( '700',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '700'
            ],
            [
              'label'    => esc_html__( 'Extra Bold 800', 'treweler' ),
              'selected' => in_array( '800',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '800'
            ],
            [
              'label'    => esc_html__( 'Black 900', 'treweler' ),
              'selected' => in_array( '900',
                isset( $meta_data->popup_subheading_font_weight ) ? (array) $meta_data->popup_subheading_font_weight : [] ),
              'value'    => '900'
            ],
          ]
        ],
      ]
    ];
    $options[] =  [
      'type'  => 'group_simple',
      'name'  => $prefix . 'popup_description_settings',
      'label' => esc_html__( 'Description', 'treweler' ),
      'value' => [
        [
          'type'  => 'textarea',
          'name'  => $prefix . 'popup_description',
          'value' => isset( $meta_data->popup_description ) ? $meta_data->popup_description : ''
        ],
        [
          'type'        => 'text',
          'postfix'     => 'px',
          'size'        => 'small',
          'name'        => $prefix . 'popup_description_size',
          'value'       => isset( $meta_data->popup_description_size ) ? $meta_data->popup_description_size : '',
          'placeholder' => '13'
        ],
        [
          'type'  => 'select',
          'name'  => $prefix . 'popup_description_font_weight',
          'value' => [
            [
              'label'    => esc_html__( 'Thin 100', 'treweler' ),
              'selected' => in_array( '100',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [] ),
              'value'    => '100'
            ],
            [
              'label'    => esc_html__( 'Extra Light 200', 'treweler' ),
              'selected' => in_array( '200',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [] ),
              'value'    => '200'
            ],
            [
              'label'    => esc_html__( 'Light 300', 'treweler' ),
              'selected' => in_array( '300',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [] ),
              'value'    => '300'
            ],
            [
              'label'    => esc_html__( 'Regular 400', 'treweler' ),
              'selected' => in_array( '400',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [ '400' ] ),
              'value'    => '400'
            ],
            [
              'label'    => esc_html__( 'Medium 500', 'treweler' ),
              'selected' => in_array( '500',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [ '400' ] ),
              'value'    => '500'
            ],
            [
              'label'    => esc_html__( 'Semi Bold 600', 'treweler' ),
              'selected' => in_array( '600',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [] ),
              'value'    => '600'
            ],
            [
              'label'    => esc_html__( 'Bold 700', 'treweler' ),
              'selected' => in_array( '700',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [] ),
              'value'    => '700'
            ],
            [
              'label'    => esc_html__( 'Extra Bold 800', 'treweler' ),
              'selected' => in_array( '800',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [] ),
              'value'    => '800'
            ],
            [
              'label'    => esc_html__( 'Black 900', 'treweler' ),
              'selected' => in_array( '900',
                isset( $meta_data->popup_description_font_weight ) ? (array) $meta_data->popup_description_font_weight : [] ),
              'value'    => '900'
            ],
          ]
        ],
      ]
    ];
  }


  $options[] = [
    'type'  => 'gallery',
    'name'  => $prefix . 'popup_image',
    'id'    => 'treweler-popup-gallery',
    'label' => esc_html__( 'Images', 'treweler' ),
    'value' => isset( $meta_data->popup_image ) ? $meta_data->popup_image : ''
  ];
  $options[] = [
      'type'  => 'checkbox',
      'name'  => $prefix . 'popup_gallery_show',
      'isPro' => TWER_IS_FREE,
      'label' => esc_html__( 'Enable Image Gallery', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( 'popup_gallery_show', isset( $meta_data->popup_gallery_show ) ? (array) $meta_data->popup_gallery_show : [] ),
          'value'   => 'popup_gallery_show'
        ]
      ]
    ];
  $options[] = [
      'type'  => 'select',
      'name'  => $prefix . 'popup_image_position',
      'label' => esc_html__( 'Image position', 'treweler' ),
      'value' => [
        [
          'label'    => esc_html__( 'Right', 'treweler' ),
          'selected' => in_array( 'right',
            isset( $meta_data->popup_image_position ) ? (array) $meta_data->popup_image_position : [ 'right' ] ),
          'value'    => 'right'
        ],
        [
          'label'    => esc_html__( 'Top', 'treweler' ),
          'selected' => in_array( 'top',
            isset( $meta_data->popup_image_position ) ? (array) $meta_data->popup_image_position : [] ),
          'value'    => 'top'
        ]
      ]
    ];
  $options[] = [
      'type'        => 'text',
      'postfix'     => 'px',
      'size'        => 'small',
      'name'        => $prefix . 'popup_image_width',
      'label'       => esc_html__( 'Image width', 'treweler' ),
      'value'       => isset( $meta_data->popup_image_width ) ? $meta_data->popup_image_width : '',
      'placeholder' => '160'
    ];

  if(TWER_IS_FREE || TWER_OLD_POPUP_FIELDS) {
    $options[] = [
      'type'  => 'group',
      'name'  => $prefix . 'popup_button',
      'label' => esc_html__( 'Button', 'treweler' ),
      'value' => [
        [
          'type'  => 'text',
          'name'  => 'text',
          'placeholder' => '',
          'label' => esc_html__( 'Text', 'treweler' ),
          'value' => isset( $meta_data->popup_button['text'] ) ? $meta_data->popup_button['text'] : ''
        ],
        [
          'type'  => 'url',
          'name'  => 'url',
          'placeholder' => '',
          'label' => esc_html__( 'URL', 'treweler' ),
          'value' => isset( $meta_data->popup_button['url'] ) ? $meta_data->popup_button['url'] : ''
        ],
        [
          'type'  => 'colorpicker',
          'name'  => 'color',
          'label' => esc_html__( 'Color', 'treweler' ),
          'value' => isset( $meta_data->popup_button['color'] ) ? $meta_data->popup_button['color'] : '#4a7805'
        ],
        [
          'type'  => 'checkbox',
          'name'  => 'target',
          'label' => esc_html__( 'Open in new tab', 'treweler' ),
          'value' => [
            [
              'label'   => '',
              'checked' => in_array( 'target',
                isset( $meta_data->popup_button['target'] ) ? (array) $meta_data->popup_button['target'] : [] ),
              'value'   => 'target'
            ]
          ]
        ],
      ]
    ];
    $options[] = [
      'type'  => 'select',
      'name'  => $prefix . 'popup_content_align',
      'label' => esc_html__( 'Content align', 'treweler' ),
      'value' => [
        [
          'label'    => esc_html__( 'Left', 'treweler' ),
          'selected' => in_array( 'left',
            isset( $meta_data->popup_content_align ) ? (array) $meta_data->popup_content_align : [ 'left' ] ),
          'value'    => 'left'
        ],
        [
          'label'    => esc_html__( 'Center', 'treweler' ),
          'selected' => in_array( 'center',
            isset( $meta_data->popup_content_align ) ? (array) $meta_data->popup_content_align : [] ),
          'value'    => 'center'
        ]
      ]
    ];
  }


  $options[] = [
    'type'  => 'group',
    'name'  => $prefix . 'popup_size',
    'label' => esc_html__( 'Min width and height', 'treweler' ),
    'value' => [
      [
        'type'    => 'text',
        'postfix' => 'px',
        'size'    => 'small',
        'name'    => 'height',
        'placeholder' => '',
        'label'   => esc_html__( 'Height', 'treweler' ),
        'value'   => isset( $meta_data->popup_size['height'] ) ? $meta_data->popup_size['height'] : ''
      ],
      [
        'type'    => 'text',
        'postfix' => 'px',
        'size'    => 'small',
        'name'    => 'width',
        'placeholder' => '',
        'label'   => esc_html__( 'Width', 'treweler' ),
        'value'   => isset( $meta_data->popup_size['width'] ) ? $meta_data->popup_size['width'] : ''
      ],
    ]
  ];
  $options[] = [
      'type'        => 'text',
      'postfix'     => 'px',
      'size'        => 'small',
      'name'        => $prefix . 'popup_border_radius',
      'label'       => esc_html__( 'Corner Radius', 'treweler' ),
      'value'       => isset( $meta_data->popup_border_radius ) ? $meta_data->popup_border_radius : '',
      'placeholder' => '0'
    ];
  $options[] = [
      'type'  => 'select',
      'name'  => $prefix . 'popup_style',
      'label' => esc_html__( 'Style', 'treweler' ),
      'value' => [
        [
          'label'    => esc_html__( 'Light', 'treweler' ),
          'selected' => in_array( 'light',
            isset( $meta_data->popup_style ) ? (array) $meta_data->popup_style : [ 'light' ] ),
          'value'    => 'light'
        ],
        [
          'label'    => esc_html__( 'Dark', 'treweler' ),
          'selected' => in_array( 'dark',
            isset( $meta_data->popup_style ) ? (array) $meta_data->popup_style : [] ),
          'value'    => 'dark'
        ]
      ]
    ];
  $options[] = [
      'type'  => 'group',
      'name'  => $prefix . 'popup_open_group',
      'label' => esc_html__( 'Open popup on', 'treweler' ),
      'value' => [
        [
          'type'  => 'select',
          'name'  => 'open_on',
          'label' => esc_html__( 'Open popup on', 'treweler' ),
          'value' => [
            [
              'label'    => esc_html__( 'Hover', 'treweler' ),
              'selected' => in_array( 'hover',
                isset( $meta_data->popup_open_group['open_on'] ) ? (array) $meta_data->popup_open_group['open_on'] : [ 'hover' ] ),
              'value'    => 'hover'
            ],
            [
              'label'    => esc_html__( 'Click', 'treweler' ),
              'selected' => in_array( 'click',
                isset( $meta_data->popup_open_group['open_on'] ) ? (array) $meta_data->popup_open_group['open_on'] : [] ),
              'value'    => 'click'
            ],
            [
              'label'    => esc_html__( 'Always open', 'treweler' ),
              'selected' => in_array( 'always_open',
                isset( $meta_data->popup_open_group['open_on'] ) ? (array) $meta_data->popup_open_group['open_on'] : [] ),
              'value'    => 'always_open'
            ]
          ]
        ],
        [
          'type'  => 'checkbox',
          'name'  => 'open_default',
          'label' => esc_html__( 'Open by default', 'treweler' ),
          'value' => [
            [
              'label'   => '',
              'checked' => in_array( 'open_default',
                isset( $meta_data->popup_open_group['open_default'] ) ? (array) $meta_data->popup_open_group['open_default'] : [] ),
              'value'   => 'open_default'
            ]
          ]
        ],
      ]
    ];
  $options[] = [
      'type'  => 'group',
      'name'  => $prefix . 'popup_close_button',
      'label' => esc_html__( 'Show Close Icon', 'treweler' ),
      'row_class' => 'row align-items-center',
      'value' => [
        [
          'type'  => 'checkbox',
          'name'  => 'show',
          'group_class' => 'col-simple',
          'value' => [
            [
              'label'   => '',
              'checked' => in_array( 'show',
                isset( $meta_data->popup_close_button['show'] ) ? (array) $meta_data->popup_close_button['show'] : [] ),
              'value'   => 'show'
            ]
          ]
        ],
        [
          'type'  => 'select',
          'name'  => 'style',
          'group_class' => 'col-fixed col-fixed--153',
          'value' => [
            [
              'label'    => esc_html__( 'Dark', 'treweler' ),
              'selected' => in_array( 'dark',
                isset( $meta_data->popup_close_button['style'] ) ? (array) $meta_data->popup_close_button['style'] : [ 'dark' ] ),
              'value'    => 'dark'
            ],
            [
              'label'    => esc_html__( 'Light', 'treweler' ),
              'selected' => in_array( 'light',
                isset( $meta_data->popup_close_button['style'] ) ? (array) $meta_data->popup_close_button['style'] : [] ),
              'value'    => 'light'
            ],
          ]
        ],

      ]
    ];

  return template_apply($options, $meta_data, $template_data );
}


