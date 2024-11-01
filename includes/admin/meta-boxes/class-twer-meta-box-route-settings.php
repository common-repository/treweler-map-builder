<?php
/**
 * Route Settings
 * Display the route settings meta box.
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
 * TWER_Meta_Box_Route_Settings Class.
 */
class TWER_Meta_Box_Route_Settings {

  protected static $fields = [];


  public static function initFields() {
    self::$fields = apply_filters(
      'treweler_admin_route_settings_fields',
      [
        [
          'type'        => 'selectNew',
          'name'        => 'route_map_id',
          'class'       => 'form-control form-control-sm js-map-multiselect',
          'isMultiple'  => true,
          'group_class' => 'form-group col',
          'label'       => esc_html__( 'Route Maps', 'treweler' ),
          'options'     => twerGetAllPublishedMaps(),
        ],
      ]
    );
  }


  /**
   * Output the metabox.
   *
   * @param WP_Post $post
   */
  public static function output( $post ) {
    self::initFields();

    twerOutputTemplateElements( [
      'fields'          => self::$fields,
      'oldViewFilename' => 'html-route-settings-panel'
    ], [
      'root_id'        => 'treweler-route-settings-root',
      'table_class'    => 'table table--vertical',
      'table_th_class' => 'col-12 d-flex align-items-center twer-cell twer-cell--th',
      'table_td_class' => 'col-12 twer-cell twer-cell--td'
    ] );
  }

}
