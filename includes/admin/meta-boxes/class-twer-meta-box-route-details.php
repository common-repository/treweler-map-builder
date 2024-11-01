<?php
/**
 * Route Details
 * Display the route settings details meta box.
 *
 * @author      Aisconverse
 * @category    Admin
 * @package     Treweler/Admin/Meta Boxes
 * @version     1.13
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/**
 * TWER_Meta_Box_Route_Details Class.
 */
class TWER_Meta_Box_Route_Details {

  protected static $tabs = [];

  protected static $fields = [];

  public static function initTabs() {
    self::$tabs = apply_filters(
      'treweler_admin_route_tabs',
      [
        'styles'    => esc_html__( 'Styles', 'treweler' ),
        'importGPX' => esc_html__( 'Import GPX', 'treweler' ),
      ]
    );
  }

  public static function initFields() {
    $fieldsForStyle = apply_filters(
      'treweler_admin_route_details_style_fields',
      [
        [
          'type'         => 'colorpicker',
          'name'         => 'route_line_color',
          'group_class'  => 'form-group col-auto',
          'label'        => esc_html__( 'Route line color', 'treweler' ),
          'value'        => '#438ee4',
        ],
        [
          'type'         => 'number',
          'name'         => 'route_line_width',
          'atts'         => [ 'min="0"', 'step="1"' ],
          'append'       => 'px',
          'placeholder'  => '3',
          'group_class'  => [ 'col-150' ],
          'label'        => esc_html__( 'Route Line Width', 'treweler' ),
        ],
        [

          'type'         => 'number',
          'name'         => 'route_line_opacity',
          'group_class'  => [ 'col-150 d-flex align-items-center flex-nowrap' ],
          'atts'         => [ 'min="0"', 'step="0.1"', 'max="1"' ],
          'placeholder'  => '1',
          'label'        => esc_html__( 'Route Line Opacity', 'treweler' ),
          'help'         => esc_html__( 'Value between 0 and 1 (Example 0.8).', 'treweler' ),
        ],
        [
          'type'  => 'group',
          'name'  => 'route_line',
          'label' => esc_html__( 'Dash and Gap', 'treweler' ),
          'group' => [
            [
              'type'         => 'number',
              'name'         => 'dash',
              'atts'         => [ 'min="0"', 'step="1"' ],
              'placeholder'  => '1',
              'group_class'  => [ 'col-150' ],
            ],
            [
              'type'         => 'number',
              'name'         => 'gap',
              'atts'         => [ 'min="0"', 'step="1"' ],
              'placeholder'  => '0',
              'group_class'  => [ 'col-150' ],
            ],
          ]
        ],
      ],
      'styles'
    );

    $fieldsForImportGPX = apply_filters(
      'treweler_admin_route_details_importGPX_fields',
      [
        [
          'type'  => 'image',
          'name'  => 'route_gpx_file',
          'label' => esc_html__( 'GPX File', 'treweler' ),
        ],
      ],
      'importGPX'
    );

    self::$fields = array_merge( $fieldsForStyle, $fieldsForImportGPX );
  }

  /**
   * Output the metabox.
   *
   * @param WP_Post $post
   */
  public static function output( $post ) {
    add_filter( 'treweler_admin_route_details_style_fields', 'twerApplyTabForFields', 10, 2 );
    add_filter( 'treweler_admin_route_details_importGPX_fields', 'twerApplyTabForFields', 10, 2 );

    self::initTabs();
    self::initFields();

    twerOutputTemplateElements( [
      'tabs'            => self::$tabs,
      'fields'          => self::$fields,
      'oldViewFilename' => 'html-route-details-panel' . TWER_FREE_FILE_SUFFIX
    ] );
  }

}
