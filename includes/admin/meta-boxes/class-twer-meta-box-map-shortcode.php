<?php
/**
 * Map Shortcode Settings
 * Display the Map Shortcode settings meta box.
 *
 * @author      Aisconverse
 * @category    Admin
 * @package     Treweler/Admin/Meta Boxes
 * @version     1.11
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( class_exists( 'TWER_Meta_Box_Map_Shortcode', false ) ) {
  return;
}

if ( ! class_exists( 'TWER_Meta_Boxes', false ) ) {
  include_once 'abstract-class-twer-meta-boxes.php';
}

/**
 * TWER_Meta_Box_Map_Shortcode Class.
 */
class TWER_Meta_Box_Map_Shortcode extends TWER_Meta_Boxes {

  protected function setNestedFields() {

  }

  protected function setNestedTabs() {
  }
  protected function set_tabs() {
  }

  protected function set_fields() {

    $this->fields = [
      [
        'type'  => 'group',
        'name'  => 'shortcode',
        'group' => [
          [
            'type'         => 'checkbox',
            'name'         => 'fullwidth',
            'group_class'  => 'form-group col-12',
            'style'        => 'default',
            'label_inline' => esc_html__( 'Fullwidth Map', 'treweler' ),
            'checked'      => false
          ],
          [
            'type'         => 'checkbox',
            'style'        => 'default',
            'name'         => 'disable_zoom',
            'group_class'  => 'form-group col-12',
            'label_inline' => esc_html__( 'Disable scroll zoom', 'treweler' ),
            'checked'      => false
          ],
          [
            'type'        => 'number',
            'name'        => 'width',
            'group_class' => 'form-group col',
            'atts'        => [ 'min="0"', 'step="1"' ],
            'placeholder' => esc_html__( 'Width', 'treweler' ),
            'value'       => '',
          ],
          [
            'type'        => 'select',
            'name'        => 'width_unit',
            'group_class' => 'form-group col-80',
            'options'     => [
              '%'  => esc_html__( '%', 'treweler' ),
              'px' => esc_html__( 'px', 'treweler' ),
              'em' => esc_html__( 'em', 'treweler' ),
            ],
            'selected'    => '%'
          ],
          [
            'type' => 'divider',
            'name' => 'divider',
            'style' => ''
          ],
          [
            'type'        => 'number',
            'name'        => 'height',
            'group_class' => 'form-group col',
            'atts'        => [ 'min="0"', 'step="1"' ],
            'placeholder' => esc_html__( 'Height', 'treweler' ),
            'value'       => '',
          ],
          [
            'type'        => 'select',
            'name'        => 'height_unit',
            'group_class' => 'form-group col-80',
            'options'     => [
              'px' => esc_html__( 'px', 'treweler' ),
              'em' => esc_html__( 'em', 'treweler' ),
            ],
            'selected'    => 'px'
          ],
        ]
      ],

      [
        'type'  => 'group',
        'name'  => 'shortcode_initial_point',
        'label' => esc_html__( 'Initial Point', 'treweler' ),
        'group' => [
          [
            'type'  => 'number',
            'name'  => 'lat',
            'atts' => ['min="-85"', 'max="85"', 'step=".00000000000000001"'],
            'group_class' => 'form-group col-12',
            'value' => '',
            'placeholder' => esc_html__('Latitude', 'treweler')
          ],
          [
            'type'  => 'number',
            'name'  => 'lon',
            'group_class' => 'form-group col-12',
            'atts' => ['min="-180"', 'max="180"', 'step=".00000000000000001"'],
            'value' => '',
            'placeholder' => esc_html__('Longitude', 'treweler')
          ],
        ]
      ],


      [
        'type'  => 'group',
        'name'  => 'shortcode_zoom',
        'label' => esc_html__( 'Initial Zoom Level', 'treweler' ),
        'group' => [
          [
            'type'  => 'range',
            'name'  => 'level',
            'class' => '',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"'],
            'group_class' => 'form-group col d-flex flex-wrap align-items-center',
            'label' => esc_html__( 'Initial Zoom Level', 'treweler' ),
            'value' => '0'
          ],
          [
            'type'  => 'number',
            'name'  => 'number',
            'atts'        => [ 'min="0"', 'step="0.01"', 'max="24"'],
            'group_class' => 'form-group col-80',
            'value' => ''
          ],
        ]
      ],
      [
        'type'  => 'group',
        'name'  => 'shortcode',
        'label' => esc_html__( 'Shortcode', 'treweler' ),
        'group' => [
          [
            'type'  => 'textarea',
            'name'  => 'code',
            'atts'  => [ 'readonly', 'rows="5"', 'onfocus="this.select();"', 'autocomplete="off"' ],
            'group_class' => 'form-group col-12',
            'value' => '[treweler map-id="' . get_the_id() . '"]'
          ],
          [
            'type'         => 'button',
            'name'         => 'copy',
            'group_class'  => 'form-group col-auto',
            'class'        =>  'js-twer-copy-text btn btn-outline-primary btn-sm',
            'label_inline' => __( 'Copy to Clipboard', 'treweler' )
          ],
        ]
      ],

      [
        'type'  => 'message',
        'name'  => 'message',
        'label' => '',
        'style' => 'style="padding-top:13px;padding-bottom:17px;"',
        'value' => esc_html__( 'Use the page settings to add a fullscreen map.', 'treweler' )
      ],

    ];
  }

}
