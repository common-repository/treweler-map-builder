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

if ( class_exists( 'TWER_Meta_Box_Page_Map', false ) ) {
  return;
}

if ( ! class_exists( 'TWER_Meta_Boxes', false ) ) {
  include_once 'abstract-class-twer-meta-boxes.php';
}

/**
 * TWER_Meta_Box_Page_Map Class.
 */
class TWER_Meta_Box_Page_Map extends TWER_Meta_Boxes {

  protected function setNestedFields() {

  }

  protected function setNestedTabs() {
  }
  protected function set_tabs() {
  }

  protected function get_maps() {
    global $post;
    $tmp_post = $post;
    $post_id = isset( $post->ID ) ? $post->ID : '';

    $setMap = get_post_meta( $post_id, '_treweler_cpt_dd_box_fullscreen', true );

    $maps_posts = get_posts( [
      'post_type'      => 'map',
      'post_status'    => 'publish',
      'posts_per_page' => - 1,
      'orderby'        => 'title',
      'order'          => 'ASC'
    ] );
    $maps = [
      '' => esc_html__( '&mdash; Select Map &mdash;', 'treweler' ),
    ];
    if ( ! empty( $maps_posts ) ) {
      foreach ( $maps_posts as $post ) {
        setup_postdata( $post );
        $postId = get_the_ID();
        $post_title = !empty(get_the_title()) ? get_the_title() : esc_html__( '(no title)', 'treweler' );


        $maps[ $postId ] = $post_title;
      }
      wp_reset_postdata();
    }


    $post = $tmp_post;

    if ( is_array( $setMap ) && ! empty( $setMap ) ) {
      $maps_sorted = [];
      foreach ( $setMap as $mapKey ) {
        if ( 'publish' !== get_post_status( $mapKey ) ) {
          continue;
        }

        $maps_sorted[ $mapKey ] = $maps[ $mapKey ];
        unset( $maps[ $mapKey ] );
      }
      $maps = $maps_sorted + $maps;
    }

    return $maps;
  }

  protected function set_fields() {

    $this->fields = [
      [
        'type'        => 'select',
        'name'        => 'cpt_dd_box_fullscreen',
        'group_class' => 'form-group col-12',
        'options'     => $this->get_maps(),
        'selected'    => ''
      ],
      [
        'type'         => 'checkbox',
        'name'         => 'page_map_custom',
        'group_class'  => 'form-group col-12',
        'style'        => 'default',
        'label_inline' => esc_html__( 'Custom Settings', 'treweler' ),
        'checked'      => false
      ],
      [
        'type'  => 'group',
        'name'  => 'page_map_initial_point',
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
        'name'  => 'page_map_zoom',
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
    ];
  }


}
