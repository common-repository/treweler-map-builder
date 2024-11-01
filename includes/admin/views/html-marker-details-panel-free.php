<?php
/**
 * Marker details meta box.
 *
 * @package Treweler/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$post_id = isset( $post->ID ) ? $post->ID : '';
$prefix = '_treweler_';
$meta_data = twer_get_data( $post_id );


$custom_color = get_option( 'treweler_mapbox_colorpicker_custom_color' );
$defaultColors = '#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|';


$template_data = [];
$current_template = isset( $meta_data->templates ) ? $meta_data->templates : 'none';
if ( 'none' !== $current_template && ! empty( $current_template ) ) {
  $template_data = template_meta_diff( twer_get_data( $current_template ) );
}


$fields_marker_styles = template_apply( [
  [
    'type'  => 'select',
    'name'  => $prefix . 'marker_style',
    'id'    => 'marker_style',
    'label' => esc_html__( 'Style', 'treweler' ),
    'value' => [
      [
        'label'    => esc_html__( 'Point', 'treweler' ),
        'selected' => in_array( 'default', isset( $meta_data->marker_style ) ? (array) $meta_data->marker_style : [ 'default' ] ),
        'value'    => 'default'
      ],
      [
        'label'    => esc_html__( 'Dot', 'treweler' ),
        'selected' => in_array( 'dot-default', isset( $meta_data->marker_style ) ? (array) $meta_data->marker_style : [] ),
        'value'    => 'dot-default'
      ],
      [
        'label'    => esc_html__( 'Balloon', 'treweler' ),
        'selected' => in_array( 'balloon-default', isset( $meta_data->marker_style ) ? (array) $meta_data->marker_style : [] ),
        'value'    => 'balloon-default'
      ],
      [
        'label'    => esc_html__( 'Triangle', 'treweler' ),
        'selected' => in_array( 'triangle-default', isset( $meta_data->marker_style ) ? (array) $meta_data->marker_style : [] ),
        'value'    => 'triangle-default'
      ],
      [
        'label'    => esc_html__( 'Custom Marker', 'treweler' ),
        'selected' => in_array( 'custom', isset( $meta_data->marker_style ) ? (array) $meta_data->marker_style : [] ),
        'value'    => 'custom'
      ],
    ]
  ],
  [
    'type'       => 'checkbox',
    'name'       => $prefix . 'picker',
    'label'      => esc_html__( 'Show Icon', 'treweler' ),
    'value'      => [
      [
        'label'   => '',
        'checked' => in_array( 'picker',
          isset( $meta_data->picker ) ? (array) $meta_data->picker : [] ),
        'value'   => 'picker'
      ]
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'balloon-default' ] ]
  ],
  [
    'type'       => 'picker',
    'name'       => $prefix . 'balloon_icon_picker',
    'label'      => esc_html__( 'Select Icon', 'treweler' ),
    'value'      => isset( $meta_data->balloon_icon_picker ) ? $meta_data->balloon_icon_picker : '',
    'toggle-row' => [ 'related' => 'treweler-picker', 'value' => true ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'balloon_icon_settings',
    'label'      => esc_html__( 'Icon', 'treweler' ),
    'value'      => [
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'balloon_icon_color',
        'id'    => 'balloon_icon_color',
        'label' => esc_html__( 'Icon', 'treweler' ),
        'value' => isset( $meta_data->balloon_icon_color ) ? $meta_data->balloon_icon_color : '#ffffff',
      ],
      [
        'type'        => 'text',
        'name'        => $prefix . 'balloon_icon_size',
        'placeholder' => '15',
        'postfix'     => 'px',
        'size'        => 'small',
        'id'          => 'treweler-balloon-icon-size',
        'label'       => esc_html__( 'Icon Size', 'treweler' ),
        'value'       => isset( $meta_data->balloon_icon_size ) ? $meta_data->balloon_icon_size : ''
      ],
    ],
    'toggle-row' => [ 'related' => 'treweler-picker', 'value' => true ]
  ],
  [
    'type'       => 'checkbox',
    'name'       => $prefix . 'picker_dot',
    'label'      => esc_html__( 'Show Icon', 'treweler' ),
    'value'      => [
      [
        'label'   => '',
        'checked' => in_array( 'picker_dot',
          isset( $meta_data->picker_dot ) ? (array) $meta_data->picker_dot : [] ),
        'value'   => 'picker_dot'
      ]
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'dot-default' ] ]
  ],
  [
    'type'       => 'picker',
    'name'       => $prefix . 'dot_icon_picker',
    'label'      => esc_html__( 'Select Icon', 'treweler' ),
    'value'      => isset( $meta_data->dot_icon_picker ) ? $meta_data->dot_icon_picker : '',
    'toggle-row' => [ 'related' => 'treweler-picker-dot', 'value' => true ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'dot_icon_settings',
    'label'      => esc_html__( 'Icon', 'treweler' ),
    'value'      => [
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'dot_icon_color',
        'id'    => 'dot_icon_color',
        'label' => esc_html__( 'Icon', 'treweler' ),
        'value' => isset( $meta_data->dot_icon_color ) ? $meta_data->dot_icon_color : '#ffffff',
      ],
      [
        'type'        => 'text',
        'name'        => $prefix . 'dot_icon_size',
        'placeholder' => '15',
        'postfix'     => 'px',
        'size'        => 'small',
        'id'          => 'treweler-dot-icon-size',
        'label'       => esc_html__( 'Icon Size', 'treweler' ),
        'value'       => isset( $meta_data->dot_icon_size ) ? $meta_data->dot_icon_size : ''
      ],
    ],
    'toggle-row' => [ 'related' => 'treweler-picker-dot', 'value' => true ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'balloon_marker_colors',
    'label'      => esc_html__( 'Marker', 'treweler' ),
    'value'      => [
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'marker_color_balloon',
        'id'    => 'marker_color_balloon',
        'label' => esc_html__( 'Marker Color', 'treweler' ),
        'value' => isset( $meta_data->marker_color_balloon ) ? $meta_data->marker_color_balloon : '#4b7715',
      ],
      [
        'type'        => 'text',
        'name'        => $prefix . 'marker_size_balloon',
        'placeholder' => '18',
        'postfix'     => 'px',
        'size'        => 'small',
        'id'          => 'treweler-marker-size-balloon',
        'label'       => esc_html__( 'Marker Size', 'treweler' ),
        'value'       => isset( $meta_data->marker_size_balloon ) ? $meta_data->marker_size_balloon : '',
      ],
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'balloon-default' ] ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'balloon_marker_border_colors',
    'label'      => esc_html__( 'Border', 'treweler' ),
    'value'      => [
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'marker_border_color_balloon',
        'id'    => 'marker_border_color_balloon',
        'label' => esc_html__( 'Border Color', 'treweler' ),
        'value' => isset( $meta_data->marker_border_color_balloon ) ? $meta_data->marker_border_color_balloon : '#4b7715',
      ],
      [
        'type'        => 'text',
        'name'        => $prefix . 'marker_border_width_balloon',
        'placeholder' => '4',
        'postfix'     => 'px',
        'size'        => 'small',
        'id'          => 'treweler-marker-border-width-balloon',
        'label'       => esc_html__( 'Border Width', 'treweler' ),
        'value'       => isset( $meta_data->marker_border_width_balloon ) ? $meta_data->marker_border_width_balloon : '',
      ],
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'balloon-default' ] ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'balloon_marker_dot_colors',
    'label'      => esc_html__( 'Dot', 'treweler' ),
    'value'      => [
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'marker_dot_color',
        'id'    => 'marker_dot_color',
        'label' => esc_html__( 'Dot Color', 'treweler' ),
        'value' => isset( $meta_data->marker_dot_color ) ? $meta_data->marker_dot_color : '#ffffff',
      ],
      [
        'type'        => 'text',
        'name'        => $prefix . 'marker_dot_size',
        'placeholder' => '8',
        'postfix'     => 'px',
        'id'          => 'treweler-marker-dot-size',
        'size'        => 'small',
        'label'       => esc_html__( 'Dot size', 'treweler' ),
        'value'       => isset( $meta_data->marker_dot_size ) ? $meta_data->marker_dot_size : ''
      ],
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'balloon-default' ] ]
  ],
  [
    'type'       => 'colorpicker_default',
    'name'       => $prefix . 'marker_color',
    'id'         => 'markerColor',
    'label'      => esc_html__( 'Marker Color', 'treweler' ),
    'value'      => isset( $meta_data->marker_color ) ? $meta_data->marker_color : '#4b7715',
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'default' ], 'show' => true ]
  ],
  [
    'type'       => 'colorpicker',
    'name'       => $prefix . 'marker_halo_color',
    'id'         => 'marker_halo_color',
    'label'      => esc_html__( 'Halo Color', 'treweler' ),
    'value'      => isset( $meta_data->marker_halo_color ) ? $meta_data->marker_halo_color : '#ffffff',
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'default' ], 'show' => true ]
  ],
  [
    'type'        => 'text',
    'name'        => $prefix . 'marker_halo_opacity',
    'placeholder' => '0.5',
    'size'        => 'small',
    'label'       => esc_html__( 'Halo Opacity', 'treweler' ),
    'value'       => isset( $meta_data->marker_halo_opacity ) ? $meta_data->marker_halo_opacity : '',
    'help'        => esc_html__( 'The opacity property can take a value from 0.0 - 1.0. The lower value, the more transparent.',
      'treweler' ),
    'toggle-row'  => [ 'related' => 'marker_style', 'value' => [ 'default' ], 'show' => true ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'dot_marker_settings',
    'label'      => esc_html__( 'Marker', 'treweler' ),
    'value'      => [

      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'marker_dotcenter_color',
        'id'    => 'marker_dotcenter_color',
        'label' => esc_html__( 'Marker', 'treweler' ),
        'value' => isset( $meta_data->marker_dotcenter_color ) ? $meta_data->marker_dotcenter_color : '#4b7715',

      ],
      [
        'type'        => 'text',
        'name'        => $prefix . 'marker_size',
        'placeholder' => '12',
        'postfix'     => 'px',
        'size'        => 'small',
        'id'          => 'treweler-marker-size',
        'label'       => esc_html__( 'Marker Size', 'treweler' ),
        'value'       => isset( $meta_data->marker_size ) ? $meta_data->marker_size : '',

      ],
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'dot-default' ] ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'dot_border_settings',
    'label'      => esc_html__( 'Border', 'treweler' ),
    'value'      => [
      [
        'type'  => 'colorpicker',
        'name'  => $prefix . 'marker_border_color',
        'id'    => 'marker_border_color',
        'label' => esc_html__( 'Border Color', 'treweler' ),
        'value' => isset( $meta_data->marker_border_color ) ? $meta_data->marker_border_color : '#ffffff',
      ],
      [
        'type'        => 'text',
        'name'        => $prefix . 'marker_border_width',
        'placeholder' => '0',
        'postfix'     => 'px',
        'size'        => 'small',
        'id'          => 'treweler-marker-border-width',
        'label'       => esc_html__( 'Border Width', 'treweler' ),
        'value'       => isset( $meta_data->marker_border_width ) ? $meta_data->marker_border_width : '',
      ],
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'dot-default' ] ]
  ],
  [
    'type'       => 'group_simple',
    'name'       => $prefix . 'marker_corner_radius_group',
    'label'      => esc_html__( 'Corner Radius', 'treweler' ),
    'value'      => [
      [
        'type'        => 'text',
        'name'        => $prefix . 'marker_corner_radius',
        'placeholder' => '50',
        'size'        => 'small',

        'label' => esc_html__( 'Corner Radius', 'treweler' ),
        'value' => isset( $meta_data->marker_corner_radius ) ? $meta_data->marker_corner_radius : '',
      ],
      [
        'type' => 'select',
        'name' => $prefix . 'marker_corner_radius_units',

        'label' => esc_html__( 'Style', 'treweler' ),
        'value' => [
          [
            'label'    => esc_html__( '%', 'treweler' ),
            'selected' => in_array( '%', isset( $meta_data->marker_corner_radius_units ) ? (array) $meta_data->marker_corner_radius_units : [ '%' ] ),
            'value'    => '%'
          ],
          [
            'label'    => esc_html__( 'px', 'treweler' ),
            'selected' => in_array( 'px', isset( $meta_data->marker_corner_radius_units ) ? (array) $meta_data->marker_corner_radius_units : [] ),
            'value'    => 'px'
          ],
        ]
      ],
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'dot-default' ] ]
  ],
  [
    'type'       => 'colorpicker',
    'name'       => $prefix . 'marker_color_triangle',
    'id'         => 'marker_color_triangle',
    'label'      => esc_html__( 'Marker Color', 'treweler' ),
    'value'      => isset( $meta_data->marker_color_triangle ) ? $meta_data->marker_color_triangle : '#4b7715',
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'triangle-default' ] ]
  ],
  [
    'type'        => 'text',
    'name'        => $prefix . 'marker_width_triangle',
    'placeholder' => '12',
    'postfix'     => 'px',
    'size'        => 'small',
    'label'       => esc_html__( 'Marker Width', 'treweler' ),
    'value'       => isset( $meta_data->marker_width_triangle ) ? $meta_data->marker_width_triangle : '',
    'toggle-row'  => [ 'related' => 'marker_style', 'value' => [ 'triangle-default' ] ]
  ],
  [
    'type'        => 'text',
    'name'        => $prefix . 'marker_height_triangle',
    'placeholder' => '10',
    'postfix'     => 'px',
    'size'        => 'small',
    'label'       => esc_html__( 'Marker Height', 'treweler' ),
    'value'       => isset( $meta_data->marker_height_triangle ) ? $meta_data->marker_height_triangle : '',
    'toggle-row'  => [ 'related' => 'marker_style', 'value' => [ 'triangle-default' ] ]
  ],
  [
    'type'       => 'image_custom',
    'isPro' => true,
    'name'       => $prefix . 'thumbnail_id',
    'id'         => 'thumbnail_id',
    'label'      => esc_html__( 'Custom Marker', 'treweler' ),
    'value'      => isset( $meta_data->thumbnail_id ) ? $meta_data->thumbnail_id : '',
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'custom' ] ]
  ],
  [
    'type'       => 'select',
    'name'       => $prefix . 'marker_position',
    'id'         => 'marker_position',
    'label'      => esc_html__( 'Position', 'treweler' ),
    'value'      => [
      [
        'label'    => esc_html__( 'Center', 'treweler' ),
        'selected' => in_array( 'center', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [ 'center' ] ),
        'value'    => 'center'
      ],
      [
        'label'    => esc_html__( 'Top', 'treweler' ),
        'selected' => in_array( 'top', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'top'
      ],
      [
        'label'    => esc_html__( 'Bottom', 'treweler' ),
        'selected' => in_array( 'bottom', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'bottom'
      ],
      [
        'label'    => esc_html__( 'Left', 'treweler' ),
        'selected' => in_array( 'left', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'left'
      ],
      [
        'label'    => esc_html__( 'Right', 'treweler' ),
        'selected' => in_array( 'right', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'right'
      ],
      [
        'label'    => esc_html__( 'Top-left', 'treweler' ),
        'selected' => in_array( 'top-left', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'top-left'
      ],
      [
        'label'    => esc_html__( 'Top-right', 'treweler' ),
        'selected' => in_array( 'top-right', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'top-right'
      ],
      [
        'label'    => esc_html__( 'Bottom-left', 'treweler' ),
        'selected' => in_array( 'bottom-left', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'bottom-left'
      ],
      [
        'label'    => esc_html__( 'Bottom-right', 'treweler' ),
        'selected' => in_array( 'bottom-left', isset( $meta_data->marker_position ) ? (array) $meta_data->marker_position : [] ),
        'value'    => 'bottom-right'
      ],
    ],
    'isPro' => true,
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'custom' ] ]
  ],
  [
    'type'        => 'text',
    'name'        => $prefix . 'marker_img_size',
    'placeholder' => '42',
    'postfix'     => 'px',
    'isPro' => true,
    'size'        => 'small',
    'label'       => esc_html__( 'Marker Size', 'treweler' ),
    'value'       => isset( $meta_data->marker_img_size ) ? $meta_data->marker_img_size : '',
    'toggle-row'  => [ 'related' => 'marker_style', 'value' => [ 'custom' ] ]
  ],
  [
    'type'       => 'select',
    'name'       => $prefix . 'marker_cursor',
    'id'         => 'marker_cursor',
    'isPro' => true,
    'label'      => esc_html__( 'Cursor on Hover', 'treweler' ),
    'value'      => [
      [
        'label'    => esc_html__( 'Pointer', 'treweler' ),
        'selected' => in_array( 'pointer', isset( $meta_data->marker_cursor ) ? (array) $meta_data->marker_cursor : [ 'pointer' ] ),
        'value'    => 'pointer'
      ],
      [
        'label'    => esc_html__( 'Grab', 'treweler' ),
        'selected' => in_array( 'grab', isset( $meta_data->marker_cursor ) ? (array) $meta_data->marker_cursor : [] ),
        'value'    => 'grab'
      ],
    ],
    'toggle-row' => [ 'related' => 'marker_style', 'value' => [ 'custom' ] ]
  ],
], $meta_data, $template_data );


$fields_clusters = [
  [
    'type'  => 'checkbox',
    'name'  => $prefix . 'marker_enable_clustering',
    'label' => esc_html__( 'Enable Clustering', 'treweler' ),
    'value' => [
      [
        'label'   => '',
        'checked' => false,
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
  ]
];


?>

<div class="twer-root">
    <div class="twer-settings">
        <div class="twer-settings__body">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-2 pr-md-0">
                        <nav class="twer-tabs">
                            <div class="nav nav-tabs" id="twer-nav-tab" role="tablist">
                                <a class="nav-item nav-link active twer-is-pro-field" id="twer-nav-template-tab" data-toggle="tab"
                                   href="#twer-nav-template" role="tab" aria-controls="twer-nav-template"
                                   aria-selected="true"><?php echo esc_html__( 'Template', 'treweler' ); ?>
                                </a>
                                <a class="nav-item nav-link" id="twer-nav-general-tab" data-toggle="tab"
                                   href="#twer-nav-general" role="tab" aria-controls="twer-nav-general"
                                   aria-selected="false"><?php echo esc_html__( 'General', 'treweler' ); ?></a>
                                <a class="nav-item nav-link" id="twer-nav-marker-styles-tab" data-toggle="tab"
                                   href="#twer-nav-marker-styles" role="tab" aria-controls="twer-nav-marker-styles"
                                   aria-selected="false"><?php echo esc_html__( 'Marker Styles', 'treweler' ); ?></a>
                                <a class="nav-item nav-link" id="twer-nav-popup-tab" data-toggle="tab"
                                   href="#twer-nav-popup" role="tab" aria-controls="twer-nav-popup"
                                   aria-selected="true"><?php echo esc_html__( 'Popup Styles', 'treweler' ); ?></a>

                                  <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-custom-fields-tab" data-toggle="tab"
                                     href="#twer-nav-custom-fields" role="tab" aria-controls="twer-nav-custom-fields"
                                     aria-selected="false"><?php echo esc_html__( 'Custom Fields', 'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-labels-tab" data-toggle="tab"
                                   href="#twer-nav-labels" role="tab" aria-controls="twer-nav-labels"
                                   aria-selected="false"><?php echo esc_html__( 'Text Label', 'treweler' ); ?></a>


                            </div>
                        </nav>
                    </div>
                    <div class="col-md-9 col-lg-9 col-xl-10 pl-md-0">
                        <div class="tab-content" id="twer-Nav-tabContent1">

                            <div class="tab-pane fade " id="twer-nav-marker-styles" role="tabpanel" aria-labelledby="twer-nav-popup-tab">
                                <div class="table-responsive">
                                    <table class="table twer-table twer-table--cells-2">
                                      <?php foreach (
                                        $fields_marker_styles

                                        as $field
                                      ) {
                                        if ( isset( $field['id'] ) ) {
                                          $element_id = $field['id'];
                                        } else {
                                          $element_id = trim( str_replace( '_', '-', $field['name'] ), '-' );
                                        }


                                        $tr_class = [ 'twer-tr-toggle' ];
                                        $tr_atts = [];

                                        if ( isset( $field['toggle_row'] ) ) {
                                          $tr_class[] = 'js-twer-tr-toggle';


                                          if ( isset( $field['toggle_row']['related_id'] ) ) {
                                            $tr_atts[] = 'id="' . $field['toggle_row']['related_id'] . '-toggle"';
                                          }

                                          if ( isset( $field['toggle_row']['trigger'] ) ) {
                                            $tr_atts[] = 'data-trigger="' . $field['toggle_row']['trigger'] . '"';
                                          }


                                        }

                                        if ( ! empty( $field['toggle-row'] ) ) {
                                          if ( ! empty( $field['toggle-row']['show'] ) ) {
                                            $tr_class[] = 'js-toggle-row';
                                          } else {
                                            $tr_class[] = 'js-toggle-row  d-none';
                                          }
                                          $tr_atts[] = 'data-related-id="' . esc_attr( $field['toggle-row']['related'] ) . '"';
                                          $att_value = $field['toggle-row']['value'];
                                          if ( is_array( $att_value ) ) {
                                            $att_value = implode( ',', $att_value );
                                          } else {
                                            $att_value = (string) $att_value;
                                          }
                                          $tr_atts[] = 'data-related-val="' . esc_attr( $att_value ) . '"';
                                        }

                                        $isPro = isset($field['isPro']) ? $field['isPro'] : false;

                                        if($isPro) {
                                          $tr_class[] = 'twer-default-row twer-is-pro-field';
                                        }
                                        ?>
                                          <tr class="<?php echo esc_attr( implode( ' ',
                                            $tr_class ) ); ?>" <?php echo implode( ' ', $tr_atts ); ?>>
                                              <th class="th-<?php echo esc_attr( $element_id ); ?>">
                                                  <label for="<?php echo esc_attr( $element_id ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
                                              </th>
                                              <td>
                                                <?php
                                                $data_template = isset( $field['data_template'] ) ? implode( ' ', $field['data_template'] ) : '';
                                                ?>
                                                  <div class="twer-wrap-fields">

                                                    <?php if ( 'select' === $field['type'] ) { ?>
                                                        <div class="twer-form-group twer-form-group--select">
                                                            <select name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                    class="large-select"
                                                              <?php echo $data_template; ?>
                                                                    id="<?php echo esc_attr( $element_id ); ?>">
                                                              <?php foreach ( $field['value'] as $data ) { ?>
                                                                  <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                              <?php } ?>
                                                            </select>
                                                        </div>
                                                    <?php } else if ( 'picker' === $field['type'] ) { ?>
                                                        <input type="text" <?php echo $data_template; ?> name="<?php echo esc_attr( $field['name'] ); ?>" id="<?php echo esc_attr( $element_id ); ?>" value="<?php echo esc_attr( $field['value'] ) ?>">
                                                    <?php } elseif ( 'checkbox' === $field['type'] ) { ?>
                                                        <input type="hidden"
                                                               name="<?php echo esc_attr( $field['name'] ); ?>"
                                                               value="">
                                                      <?php foreach ( $field['value'] as $data ) { ?>
                                                            <label for="<?php echo esc_attr( $element_id ) ?>"
                                                                   class="twer-switcher"
                                                              <?php echo $data_template; ?>
                                                            >
                                                                <input type="checkbox"

                                                                       name="<?php echo esc_attr( $field['name'] ); ?>[]"
                                                                       id="<?php echo esc_attr( $element_id ); ?>"
                                                                       value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                                <div class="twer-switcher__slider"></div>
                                                            </label>
                                                      <?php } ?>
                                                    <?php } elseif ( 'colorpicker' === $field['type'] ) { ?>
                                                        <div class="js-twer-color-picker-wrap twer-color-picker-wrap" <?php echo $data_template; ?>>
                                                            <div class="map-text-color js-twer-color-picker">
                                                                                    <span class="color-holder"
                                                                                          style="background-color:<?php echo esc_attr( $field['value'] ) ?>;"></span>
                                                                <input type="button"
                                                                       class="text-color-picker-btn"
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
                                                                   class="input-color input-color-field"

                                                                   id="<?php echo esc_attr( $field['id'] ); ?>"
                                                                   value="<?php echo esc_attr( $field['value'] ) ?>">
                                                        </div>
                                                    <?php } elseif ( 'colorpicker_default' === $field['type'] ) { ?>
                                                        <div class="twer-color-picker-wrap" <?php echo $data_template; ?>>

                                                            <div class="clr-picker" style="margin: 0">
                                                                <span class="color-holder" style="background-color:<?php echo esc_attr( $field['value'] ) ?>;"></span>
                                                                <input type="button" id="color-picker-btn" value="<?php echo esc_attr__( 'Select Color', 'treweler' ); ?>">
                                                            </div>
                                                            <div class="twer-color-picker-palette color-picker"
                                                                 acp-color="<?php echo esc_attr( $field['value'] ) ?>"
                                                                 acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                                 default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                                 acp-show-rgb="no"
                                                                 acp-show-hsl="no"
                                                                 acp-palette-editable>
                                                            </div>

                                                            <input type="hidden" name="addCustomColor" id="addCustomColor" value="<?php echo esc_attr( $custom_color ); ?>">
                                                            <input class="input-color-field" type="hidden" name="<?php echo esc_attr( $field['name'] ); ?>" id="markerColor" value="<?php echo esc_attr( $field['value'] ) ?>">


                                                        </div>

                                                    <?php } elseif ( 'text' === $field['type'] || 'url' === $field['type'] ) {

                                                      $field_class = [ 'twer-form-group twer-form-group--text' ];
                                                      $field_placeholder = '';
                                                      if ( isset( $field['size'] ) ) {
                                                        $field_class[] = 'twer-form-group--' . $field['size'];
                                                      }

                                                      if ( isset( $field['placeholder'] ) ) {
                                                        $field_placeholder = $field['placeholder'];
                                                      }
                                                      if ( isset( $field['postfix'] ) ) {
                                                        $field_class[] = 'twer-form-group--append';
                                                      }

                                                      if ( ! empty( $field['help'] ) ) {
                                                        $field_class[] = 'twer-help-input';
                                                      }
                                                      ?>

                                                        <div class="<?php echo esc_attr( implode( ' ', $field_class ) ); ?>">
                                                            <input type="<?php echo esc_attr( $field['type'] ); ?>"
                                                                   id="<?php echo esc_attr( $element_id ); ?>"
                                                                   name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                   class="large-text"
                                                              <?php echo $data_template; ?>
                                                                   value="<?php echo esc_attr( $field['value'] ) ?>"
                                                                   placeholder="<?php echo esc_attr( $field_placeholder ); ?>">
                                                          <?php if ( isset( $field['postfix'] ) ) { ?>
                                                              <div class="twer-form-group-append">
                                                                  <span class="twer-form-group-append__text"><?php echo esc_html( $field['postfix'] ); ?></span>
                                                              </div>
                                                          <?php } ?>


                                                          <?php if ( ! empty( $field['help'] ) ) { ?>
                                                              <a href="#" class="twer-help-tooltip"
                                                                 data-toggle="tooltip"
                                                                 title="<?php echo esc_attr( $field['help'] ); ?>"><span
                                                                          class="dashicons dashicons-editor-help"></span></a>
                                                          <?php } ?>
                                                        </div>
                                                    <?php } elseif ( 'textarea' === $field['type'] ) { ?>
                                                        <div class="twer-form-group twer-form-group--text">
                                                            <textarea class="large-text"
                                                                      name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                      id="<?php echo esc_attr( $element_id ); ?>"
                                                                      cols="30"
                                                                      <?php echo $data_template; ?>
                                                                      rows="6"><?php echo esc_attr( $field['value'] ) ?></textarea>
                                                        </div>
                                                    <?php } elseif ( 'image_custom' === $field['type'] ) { ?>
                                                        <div class="twer-attach js-twer-attach-wrap-custom" <?php echo $data_template; ?>>

                                                            <div class="twer-attach__thumb js-twer-attach-thumb-custom">
                                                              <?php if ( $field['value'] ) { ?>
                                                                  <img src="<?php echo esc_url( $field['value'] ); ?>"
                                                                       alt="">
                                                              <?php } ?>
                                                                <button type="button"

                                                                        style="<?php echo ! empty( $field['value'] ) ? 'display:none;' : 'display:block'; ?>"
                                                                        class="twer-attach__add-media js-twer-attach-add-custom"><?php echo esc_html__( 'Select File',
                                                                    'treweler' ); ?></button>

                                                                <input type="hidden"

                                                                       id="<?php echo esc_attr( $field['id'] ); ?>"
                                                                       name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                       value="<?php echo esc_attr( $field['value'] ) ?>">
                                                            </div>

                                                            <div class="twer-attach__actions js-twer-attach-actions-custom"
                                                                 style="<?php echo ! empty( $field['value'] ) ? 'display:block;' : 'display:none'; ?>">
                                                                <button type="button"
                                                                        class="button js-twer-attach-remove-custom"><?php echo esc_html__( 'Remove',
                                                                    'treweler' ); ?></button>
                                                                <button type="button"
                                                                        class="button js-twer-attach-add-custom"><?php echo esc_html__( 'Change file',
                                                                    'treweler' ); ?></button>
                                                            </div>
                                                        </div>
                                                    <?php } elseif ( 'image' === $field['type'] ) { ?>
                                                        <div class="twer-attach js-twer-attach-wrap">

                                                            <div class="twer-attach__thumb js-twer-attach-thumb">
                                                              <?php if ( $field['value'] ) { ?>
                                                                  <img src="<?php echo esc_url( $field['value'] ); ?>"
                                                                       alt="">
                                                              <?php } ?>
                                                                <button type="button"
                                                                        id="<?php echo esc_attr( $element_id ); ?>"
                                                                        style="<?php echo ! empty( $field['value'] ) ? 'display:none;' : 'display:block'; ?>"
                                                                        class="twer-attach__add-media js-twer-attach-add"><?php echo esc_html__( 'Select Image',
                                                                    'treweler' ); ?></button>

                                                                <input type="hidden"
                                                                  <?php echo $data_template; ?>
                                                                       name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                       value="<?php echo esc_attr( $field['value'] ) ?>">
                                                            </div>

                                                            <div class="twer-attach__actions js-twer-attach-actions"
                                                                 style="<?php echo ! empty( $field['value'] ) ? 'display:block;' : 'display:none'; ?>">
                                                                <button type="button"
                                                                        class="button js-twer-attach-remove"><?php echo esc_html__( 'Remove',
                                                                    'treweler' ); ?></button>
                                                                <button type="button"
                                                                        class="button js-twer-attach-add"><?php echo esc_html__( 'Change image',
                                                                    'treweler' ); ?></button>
                                                            </div>
                                                        </div>
                                                    <?php } elseif ( 'group' === $field['type'] ) { ?>
                                                        <div class="twer-group-elements">
                                                            <div class="row">
                                                              <?php foreach ( $field['value'] as $field_group ) {

                                                                $element_id_group = trim( str_replace( '_', '-',
                                                                  $field['name'] . '_' . $field_group['name'] ),
                                                                  '-' );
                                                                $field_group['name'] = $field['name'] . '[' . $field_group['name'] . ']';

                                                                $field_class = [];
                                                                if ( isset( $field_group['postfix'] ) ) {
                                                                  $field_class[] = 'twer-form-group--append';
                                                                }

                                                                $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';

                                                                ?>
                                                                  <div class="<?php echo 'colorpicker' === $field_group['type'] ? 'col-simple' : 'col-fixed' ?>">
                                                                      <label for="<?php echo esc_attr( $element_id_group ); ?>"><?php echo esc_attr( $field_group['label'] ); ?></label>
                                                                    <?php if ( 'text' === $field_group['type'] || 'url' === $field_group['type'] ) { ?>
                                                                        <div class="twer-form-group twer-form-group--text <?php echo esc_attr( implode( ' ', $field_class ) ); ?>">
                                                                            <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                                                   id="<?php echo esc_attr( $element_id_group ); ?>"
                                                                                   name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                                   class="large-text"
                                                                              <?php echo $data_template; ?>
                                                                                   value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                                                          <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                                              <div class="twer-form-group-append">
                                                                                  <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                                              </div>
                                                                          <?php } ?>
                                                                        </div>


                                                                    <?php } elseif ( 'select' === $field_group['type'] ) { ?>
                                                                        <div class="twer-form-group twer-form-group--select">
                                                                            <select name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                                    class="large-select"
                                                                              <?php echo $data_template; ?>
                                                                                    id="<?php echo esc_attr( $element_id_group ); ?>">
                                                                              <?php foreach ( $field_group['value'] as $data ) { ?>
                                                                                  <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                                              <?php } ?>
                                                                            </select>
                                                                        </div>


                                                                    <?php } elseif ( 'colorpicker' === $field_group['type'] ) { ?>
                                                                        <div class="js-twer-color-picker-wrap twer-color-picker-wrap" <?php echo $data_template; ?>>
                                                                            <div class="map-text-color js-twer-color-picker">
                                                                                    <span class="color-holder"
                                                                                          style="background-color:<?php echo esc_attr( $field_group['value'] ) ?>;"></span>
                                                                                <input type="button"
                                                                                       class="text-color-picker-btn"
                                                                                       value="<?php echo esc_attr__( 'Select Color',
                                                                                         'treweler' ); ?>">
                                                                            </div>
                                                                            <!-- .color-picker-text-descr -->
                                                                            <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                                                 acp-color="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                                                 acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                                                 default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                                                 acp-show-rgb="no"
                                                                                 acp-show-hsl="no"
                                                                                 acp-palette-editable>
                                                                            </div>
                                                                            <input type="hidden"

                                                                                   name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                                   class="input-color input-color-field"
                                                                                   value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                                                        </div>
                                                                    <?php } elseif ( 'checkbox' === $field_group['type'] ) { ?>
                                                                        <input type="hidden"
                                                                               name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                               value="">
                                                                      <?php foreach ( $field_group['value'] as $data ) { ?>
                                                                            <label for="<?php echo esc_attr( $element_id_group ) ?>"
                                                                                   class="twer-switcher"
                                                                              <?php echo $data_template; ?>
                                                                            >
                                                                                <input type="checkbox"

                                                                                       name="<?php echo esc_attr( $field_group['name'] ); ?>[]"
                                                                                       id="<?php echo esc_attr( $element_id_group ); ?>"
                                                                                       value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                                                <div class="twer-switcher__slider"></div>
                                                                            </label>
                                                                      <?php } ?>
                                                                    <?php } ?>
                                                                  </div>
                                                              <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } elseif ( 'group_simple' === $field['type'] ) { ?>
                                                        <div class="twer-group-elements">
                                                            <div class="row">
                                                              <?php
                                                              $simple_counter = 0;
                                                              foreach ( $field['value'] as $field_group ) {
                                                                $simple_counter ++;
                                                                $class_simple = '';
                                                                switch ( $simple_counter ) {
                                                                  case '1' :
                                                                    // $class_simple = 'col-fixed--260';
                                                                    break;
                                                                  case '2' :
                                                                    $class_simple = 'col-fixed--130';
                                                                    break;
                                                                  case '3' :
                                                                    $class_simple = 'col-fixed--200';
                                                                    break;
                                                                }

                                                                $fgi = isset( $field_group['id'] ) ? $field_group['id'] : '';
                                                                if ( 'marker_corner_radius' === $fgi ) {
                                                                  $class_simple = 'col-fixed--150';
                                                                }

                                                                $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';
                                                                ?>
                                                                  <div style="margin-bottom: 0" class="<?php echo 'colorpicker' === $field_group['type'] ? 'col-simple' : 'col-fixed ' . $class_simple ?>">
                                                                    <?php if ( 'text' === $field_group['type'] || 'url' === $field_group['type'] ) {

                                                                      $field_group_class = [ 'twer-form-group twer-form-group--text' ];
                                                                      $field_group_placeholder = '';
                                                                      if ( isset( $field_group['size'] ) ) {
                                                                        $field_group_class[] = 'twer-form-group--' . $field_group['size'];
                                                                      }

                                                                      if ( isset( $field_group['placeholder'] ) ) {
                                                                        $field_group_placeholder = $field_group['placeholder'];
                                                                      }
                                                                      if ( isset( $field_group['postfix'] ) ) {
                                                                        $field_group_class[] = 'twer-form-group--append';
                                                                      }

                                                                      $isset_id = isset( $field_group['id'] ) ? $field_group['id'] : '';

                                                                      if ( $isset_id ) {
                                                                        $element_id = $isset_id;
                                                                      }

                                                                      ?>
                                                                        <div class="<?php echo esc_attr( implode( ' ', $field_group_class ) ); ?>">
                                                                            <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                                                   id="<?php echo esc_attr( $element_id ); ?>"
                                                                                   name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                                   class="large-text"
                                                                              <?php echo $data_template; ?>
                                                                                   value="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                                                   placeholder="<?php echo esc_attr( $field_group_placeholder ); ?>">
                                                                          <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                                              <div class="twer-form-group-append">
                                                                                  <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                                              </div>
                                                                          <?php } ?>
                                                                        </div>
                                                                    <?php } elseif ( 'select' === $field_group['type'] ) { ?>
                                                                        <div class="twer-form-group twer-form-group--select">
                                                                            <select name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                                    class="large-select"
                                                                              <?php echo $data_template; ?>
                                                                                    id="<?php echo esc_attr( $element_id ); ?>-select">
                                                                              <?php foreach ( $field_group['value'] as $data ) { ?>
                                                                                  <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                                              <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    <?php } elseif ( 'colorpicker' === $field_group['type'] ) {
                                                                      ?>
                                                                        <div class="js-twer-color-picker-wrap twer-color-picker-wrap" <?php echo $data_template; ?>>
                                                                            <div class="map-text-color js-twer-color-picker">
                                                                                    <span class="color-holder"
                                                                                          style="background-color:<?php echo esc_attr( $field_group['value'] ) ?>;"></span>
                                                                                <input type="button"
                                                                                       class="text-color-picker-btn"
                                                                                       value="<?php echo esc_attr__( 'Select Color',
                                                                                         'treweler' ); ?>">
                                                                            </div>
                                                                            <!-- .color-picker-text-descr -->
                                                                            <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                                                 acp-color="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                                                 acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                                                 default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                                                 acp-show-rgb="no"
                                                                                 acp-show-hsl="no"
                                                                                 acp-palette-editable>
                                                                            </div>
                                                                            <input type="hidden"
                                                                                   name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                                   class="input-color input-color-field"

                                                                                   id="<?php echo esc_attr( $field_group['id'] ); ?>"
                                                                                   value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                                                        </div>
                                                                      <?php
                                                                    } elseif ( 'textarea' === $field_group['type'] ) { ?>
                                                                        }
                                                                        <div class="twer-form-group twer-form-group--text">
                                                            <textarea class="large-text"
                                                                      name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                      id="<?php echo esc_attr( $element_id ); ?>"
                                                                      cols="30"
                                                                      <?php echo $data_template; ?>
                                                                      rows="6"><?php echo esc_attr( $field_group['value'] ) ?></textarea>
                                                                        </div>
                                                                    <?php }
                                                                    ?>
                                                                  </div>
                                                              <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                  </div>
                                              </td>
                                          </tr>
                                      <?php } ?>
                                    </table>
                                </div>
                            </div>



                            <div class="tab-pane fade" id="twer-nav-general" role="tabpanel" aria-labelledby="twer-nav-general-tab">
                                <?php
                                $generalFields = getMarkerGeneralSettings();
                                theMarkerFields($generalFields);
                                ?>
                            </div>

                            <div class="tab-pane fade" id="twer-nav-popup" role="tabpanel" aria-labelledby="twer-nav-popup-tab">
                              <?php
                              $popupStylesFields = getMarkerPopupStylesSettings();
                              theMarkerFields($popupStylesFields);
                              ?>
                            </div>

                            <div class="tab-pane fade" id="twer-nav-labels" role="tabpanel" aria-labelledby="twer-nav-labels-tab"><?php twerGoToProNotice(); ?></div>

                            <div class="tab-pane fade" id="twer-nav-custom-fields" role="tabpanel" aria-labelledby="twer-nav-custom-fields-tab"><?php twerGoToProNotice(); ?></div>

                            <div class="tab-pane fade" id="twer-nav-template" role="tabpanel" aria-labelledby="twer-nav-template-tab"><?php twerGoToProNotice(); ?></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

