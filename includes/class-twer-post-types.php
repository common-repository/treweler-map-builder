<?php
/**
 * Post Types
 * Registers post types and taxonomies.
 *
 * @package Treweler/Classes/PostTypes
 * @version 0.24
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types Class.
 */
class TWER_Post_Types {

  /**
   * Hook in methods.
   */
  public static function init() {
    add_action( 'init', [ __CLASS__, 'register_taxonomies' ], 5 );
    add_action( 'init', [ __CLASS__, 'register_post_types' ], 5 );
    add_action( 'restrict_manage_posts', [ __CLASS__, 'add_dropdown_filter_map' ] );
    add_filter( 'term_updated_messages', [ __CLASS__, 'updated_term_messages' ] );
    add_action( 'parse_query', [ __CLASS__, 'filter_map_query' ], 15 );
    add_action( 'save_post', [ __CLASS__, 'clear_map_list_cache' ] );
    add_action( 'treweler_after_register_post_type', [ __CLASS__, 'maybe_flush_rewrite_rules' ] );
    add_action( 'treweler_flush_rewrite_rules', [ __CLASS__, 'flush_rewrite_rules' ] );
    add_filter( 'gutenberg_can_edit_post_type', [ __CLASS__, 'gutenberg_can_edit_post_type' ], 10, 2 );
    add_filter( 'use_block_editor_for_post_type', [ __CLASS__, 'gutenberg_can_edit_post_type' ], 10, 2 );
  }

  /**
   * Register core taxonomies.
   */
  public static function register_taxonomies() {
    if ( ! is_blog_installed() ) {
      return;
    }

    do_action( 'treweler_register_taxonomy' );

    do_action( 'treweler_after_register_taxonomy' );
  }


  /**
   * Register core post types.
   */
  public static function register_post_types() {
    if ( ! is_blog_installed() ||
         post_type_exists( 'marker' ) ||
         post_type_exists( 'route' ) ||
         post_type_exists( 'map' )
    ) {
      return;
    }

    // If theme support changes, we may need to flush permalinks since some are changed based on this flag.
    $theme_support = current_theme_supports( 'treweler' ) ? 'yes' : 'no';
    if ( get_option( 'current_theme_supports_treweler' ) !== $theme_support && update_option( 'current_theme_supports_treweler', $theme_support ) ) {
      update_option( 'treweler_queue_flush_rewrite_rules', 'yes' );
    }

    do_action( 'treweler_register_post_type' );

    register_post_type(
      'map',
      apply_filters(
        'treweler_register_post_type_map',
        [
          'labels'              => [
            'name'               => esc_html_x( 'Maps', 'Post type general name', 'treweler' ),
            'singular_name'      => esc_html_x( 'Map', 'Post type singular name', 'treweler' ),
            'add_new'            => esc_html__( 'Add New', 'treweler' ),
            'add_new_item'       => esc_html__( 'Add New Map', 'treweler' ),
            'edit_item'          => esc_html__( 'Edit Map', 'treweler' ),
            'new_item'           => esc_html__( 'New Map', 'treweler' ),
            'view_item'          => esc_html__( 'View Map', 'treweler' ),
            'all_items'          => esc_html__( 'Maps', 'treweler' ),
            'search_items'       => esc_html__( 'Search Maps', 'treweler' ),
            'not_found'          => esc_html__( 'No Maps found.', 'treweler' ),
            'not_found_in_trash' => esc_html__( 'No Maps found in Trash.', 'treweler' ),
            'menu_name'          => esc_html_x( 'Maps', 'map', 'treweler' ),
            'name_admin_bar'     => esc_html_x( 'Map', 'Add New on Toolbar', 'treweler' ),
            'parent_item_colon'  => esc_html__( 'Parent Maps:', 'treweler' ),

            'featured_image'        => esc_html_x( 'Map Logo', 'treweler' ),
            'set_featured_image'    => esc_html_x( 'Upload map logo', 'treweler' ),
            'remove_featured_image' => esc_html_x( 'Remove map logo', 'treweler' ),
            'use_featured_image'    => esc_html_x( 'Use as map logo', 'treweler' ),

            'archives'              => esc_html_x( 'Map archives',
              'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4',
              'treweler' ),
            'insert_into_item'      => esc_html_x( 'Insert into map',
              'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4',
              'treweler' ),
            'uploaded_to_this_item' => esc_html_x( 'Uploaded to this map',
              'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4',
              'treweler' ),
            'filter_items_list'     => esc_html_x( 'Filter Maps list',
              'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4',
              'treweler' ),
            'items_list_navigation' => esc_html_x( 'Maps list navigation',
              'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4',
              'treweler' ),
            'items_list'            => esc_html_x( 'Maps list',
              'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4',
              'treweler' ),
          ],
          'description'         => esc_html__( 'Describe travels, routes, locations and other interesting events that can be described using maps.',
            'treweler' ),
          'capability_type'     => 'treweler',
          'hierarchical'        => false,
          'can_export'          => true,
          'show_in_menu'        => current_user_can( 'edit_treweler' ) ? 'treweler' : true,
          'menu_position'       => null,
          'public'              => false,  // it's not public, it shouldn't have it's own permalink, and so on
          'publicly_queryable'  => true,  // you should be able to query it
          'show_ui'             => true,  // you should be able to edit it in wp-admin
          'exclude_from_search' => true,  // you should exclude it from search results
          'show_in_nav_menus'   => false,  // you shouldn't be able to add it to menus
          'has_archive'         => false,  // it shouldn't have archive page
          'rewrite'             => [ 'slug' => 'treweler-map', 'with_front' => false ],
          'supports'            => [ 'title', 'page-attributes' ],
          'taxonomies'          => [ 'map-category' ]
        ]
      )
    );

    register_post_type(
      'marker',
      apply_filters(
        'treweler_register_post_type_marker',
        [
          'labels'              => [
            'name'                  => esc_html_x( 'Markers', 'Post type general name', 'treweler' ),
            'singular_name'         => esc_html_x( 'Marker', 'Post type singular name', 'treweler' ),
            'add_new'               => esc_html__( 'Add New', 'treweler' ),
            'add_new_item'          => esc_html__( 'Add New Marker', 'treweler' ),
            'edit_item'             => esc_html__( 'Edit Marker', 'treweler' ),
            'new_item'              => esc_html__( 'New Marker', 'treweler' ),
            'view_item'             => esc_html__( 'View Marker', 'treweler' ),
            'all_items'             => esc_html__( 'Markers', 'treweler' ),
            'search_items'          => esc_html__( 'Search Markers', 'treweler' ),
            'not_found'             => esc_html__( 'No Markers found.', 'treweler' ),
            'not_found_in_trash'    => esc_html__( 'No Markers found in Trash.', 'treweler' ),
            'menu_name'             => esc_html_x( 'Treweler', 'marker', 'treweler' ),
            'name_admin_bar'        => esc_html_x( 'Marker', 'Add New on Toolbar', 'treweler' ),
            'parent_item_colon'     => esc_html__( 'Parent Markers:', 'treweler' ),
            'featured_image'        => esc_html_x( 'Custom Marker', 'treweler' ),
            'set_featured_image'    => esc_html_x( 'Upload custom marker', 'treweler' ),
            'remove_featured_image' => esc_html_x( 'Remove custom marker', 'treweler' ),
            'use_featured_image'    => esc_html_x( 'Use as marker icon', 'treweler' ),
            'archives'              => esc_html_x( 'Marker archives',
              'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4',
              'treweler' ),
            'insert_into_item'      => esc_html_x( 'Insert into marker',
              'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4',
              'treweler' ),
            'uploaded_to_this_item' => esc_html_x( 'Uploaded to this marker',
              'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4',
              'treweler' ),
            'filter_items_list'     => esc_html_x( 'Filter Markers list',
              'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4',
              'treweler' ),
            'items_list_navigation' => esc_html_x( 'Markers list navigation',
              'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4',
              'treweler' ),
            'items_list'            => esc_html_x( 'Markers list',
              'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4',
              'treweler' ),
          ],
          'description'         => esc_html__( 'Describe travels, routes, locations and other interesting events that can be described using maps.',
            'treweler' ),
          'public'              => false,
          'publicly_queryable'  => false,
          'query_var'           => true,
          'show_ui'             => true,
          'show_in_menu'        => current_user_can( 'edit_treweler' ) ? 'treweler' : true, //'edit.php?post_type=map',
          'show_in_nav_menus'   => true,
          'capability_type'     => 'treweler',
          'has_archive'         => false,
          'hierarchical'        => false,
          'can_export'          => true,
          'menu_position'       => null,
          'rewrite'             => [ 'slug' => null, 'with_front' => false ],
          'exclude_from_search' => true,
          'supports'            => [ 'title', 'page-attributes' ],
          'taxonomies'          => [ 'map-category' ]
        ]
      )
    );

    register_post_type(
      'route',
      apply_filters(
        'treweler_register_post_type_route',
        [
          'labels'              => [
            'name'                  => esc_html_x( 'Routes', 'Post type general name', 'treweler' ),
            'singular_name'         => esc_html_x( 'Route', 'Post type singular name', 'treweler' ),
            'add_new'               => esc_html__( 'Add New', 'treweler' ),
            'add_new_item'          => esc_html__( 'Add New Route', 'treweler' ),
            'edit_item'             => esc_html__( 'Edit Route', 'treweler' ),
            'new_item'              => esc_html__( 'New Route', 'treweler' ),
            'view_item'             => esc_html__( 'View Route', 'treweler' ),
            'all_items'             => esc_html__( 'Routes', 'treweler' ),
            'search_items'          => esc_html__( 'Search Routes', 'treweler' ),
            'not_found'             => esc_html__( 'No Routes found.', 'treweler' ),
            'not_found_in_trash'    => esc_html__( 'No Routes found in Trash.', 'treweler' ),
            'menu_name'             => esc_html_x( 'Treweler', 'route', 'treweler' ),
            'name_admin_bar'        => esc_html_x( 'Route', 'Add New on Toolbar', 'treweler' ),
            'parent_item_colon'     => esc_html__( 'Parent Routes:', 'treweler' ),
            'featured_image'        => esc_html_x( 'Import a GPS File', 'treweler' ),
            'set_featured_image'    => esc_html_x( 'Upload file here', 'treweler' ),
            'remove_featured_image' => esc_html_x( 'Remove this file', 'treweler' ),
            'use_featured_image'    => esc_html_x( 'Use as route', 'treweler' ),
            'archives'              => esc_html_x( 'Route archives',
              'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4',
              'treweler' ),
            'insert_into_item'      => esc_html_x( 'Insert into route',
              'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4',
              'treweler' ),
            'uploaded_to_this_item' => esc_html_x( 'Uploaded to this route',
              'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4',
              'treweler' ),
            'filter_items_list'     => esc_html_x( 'Filter Routes list',
              'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4',
              'treweler' ),
            'items_list_navigation' => esc_html_x( 'Routes list navigation',
              'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4',
              'treweler' ),
            'items_list'            => esc_html_x( 'Routes list',
              'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4',
              'treweler' ),
          ],
          'description'         => esc_html__( 'Describe travels, routes, locations and other interesting events that can be described using maps.',
            'treweler' ),
          'public'              => false,
          'publicly_queryable'  => false,
          'query_var'           => true,
          'show_ui'             => true,
          'show_in_menu'        => current_user_can( 'edit_treweler' ) ? 'treweler' : true, //'edit.php?post_type=map',
          'show_in_nav_menus'   => true,
          'capability_type'     => 'treweler',
          'has_archive'         => false,
          'hierarchical'        => false,
          'can_export'          => true,
          'menu_position'       => null,
          'rewrite'             => [ 'slug' => null, 'with_front' => false ],
          'exclude_from_search' => true,
          'supports'            => [ 'title', 'page-attributes' ],
          'taxonomies'          => [ 'map-category' ]
        ]
      )
    );

    do_action( 'treweler_after_register_post_type' );
  }


  /**
   * Flush rules if the event is queued.
   *
   * @since 1.0.3
   */
  public static function maybe_flush_rewrite_rules() {
    if ( 'yes' === get_option( 'treweler_queue_flush_rewrite_rules' ) ) {
      update_option( 'treweler_queue_flush_rewrite_rules', 'no' );
      self::flush_rewrite_rules();
    }
  }

  /**
   * Flush rewrite rules.
   */
  public static function flush_rewrite_rules() {
    flush_rewrite_rules();
  }

  public static function add_dropdown_filter_map() {

    $cpt = 'pages';

    if ( isset( $_GET['post_type'] ) ) {
      $cpt = $_GET['post_type'];
    }

    if ( get_post_type() === 'marker' || get_post_type() === 'route' || $cpt === 'marker' || $cpt === 'route' || get_post_type() === 'twer-shapes' || $cpt === 'twer-shapes' ) {
      $map_filter = 'map_filter';
      $selected = '';
      if ( isset( $_REQUEST[ $map_filter ] ) ) {
        $selected = $_REQUEST[ $map_filter ];
      }


      wp_dropdown_cpt( array(
        'selected'  => $selected,
        'post_type' => 'map'
      ) );

    }
  }

  public static function filter_map_query( $query ) {
    $prefix = '_treweler_';
    $type = 'post';

    if ( isset( $_GET['post_type'] ) ) {
      $type = $_GET['post_type'];
    }

    if ( ! isset( $_GET['map_filter'] ) || $_GET['map_filter'] == 0 ) {
      return;
    }

    if ( get_post_type() === 'marker' || get_post_type() === 'route' || $type === 'marker' || $type === 'route' ||  get_post_type() === 'twer-shapes' || $type === 'twer-shapes' ) {


      if ( isset( $_GET['map_filter'] ) && $_GET['map_filter'] != '' ) {
        $map_id = (int) $_GET['map_filter'];
      }

      $meta_query = array();

      if ( isset( $map_id ) && $type === 'route' ) {
        $meta_query['relation'] = 'OR';
        $meta_query[] = array(
          'key'     => $prefix . 'route_map_id',
          'value'   => $map_id,
          'compare' => '=',
          'type'    => 'NUMERIC',
        );
        $meta_query[] = [
          'key'     => $prefix . 'route_map_id',
          'value'   => serialize( strval( $map_id ) ),
          'compare' => 'LIKE'
        ];
      }

      if ( isset( $map_id ) && $type === 'twer-shapes' ) {
        $meta_query['relation'] = 'OR';
        $meta_query[] = array(
          'key'     => $prefix . 'map_id',
          'value'   => $map_id,
          'compare' => '=',
          'type'    => 'NUMERIC',
        );
        $meta_query[] = [
          'key'     => $prefix . 'map_id',
          'value'   => serialize( strval( $map_id ) ),
          'compare' => 'LIKE'
        ];
      }

      if ( isset( $map_id ) && $type === 'marker' ) {
        $meta_query['relation'] = 'OR';
        $meta_query[] = array(
          'key'     => $prefix . 'marker_map_id',
          'value'   => $map_id,
          'compare' => '=',
          'type'    => 'NUMERIC',
        );

        $meta_query[] = [
          'key'     => $prefix . 'marker_map_id',
          'value'   => serialize( strval( $map_id ) ),
          'compare' => 'LIKE'
        ];
      }


      $query->set( 'meta_query', $meta_query );

    }
  }


  /**
   * Customize taxonomies update messages.
   *
   * @param $messages
   * @since 1.12
   *
   * @return mixed
   */
  public static function updated_term_messages( $messages ) {
    return apply_filters('treweler_term_messages', $messages);
  }


  public static function clear_map_list_cache( $post_id ) {
    delete_transient( 'twer_cpt_map__list' );
    delete_transient( 'twer_cpt_marker__list' );
    delete_transient( 'twer_cpt_route__list' );
  }

  /**
   * Disable Gutenberg for custom post types.
   *
   * @param bool $can_edit Whether the post type can be edited or not.
   * @param string $post_type The post type being checked.
   *
   * @return bool
   */
  public static function gutenberg_can_edit_post_type( $can_edit, $post_type ) {
    $disabledGutenbergPostTypes = apply_filters( 'twerDisabledGutenbergPostTypes', [ 'marker', 'route', 'map' ], $can_edit, $post_type );
    return in_array( $post_type, $disabledGutenbergPostTypes, true ) ? false : $can_edit;
  }
}

TWER_Post_types::init();
