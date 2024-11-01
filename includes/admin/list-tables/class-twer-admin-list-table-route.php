<?php
/**
 * List tables: route.
 *
 * @package  Treweler/Admin
 * @version  0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'TWER_Admin_List_Table_Route', false ) ) {
	return;
}

if ( ! class_exists( 'TWER_Admin_List_Table', false ) ) {
	include_once 'abstract-class-twer-admin-list-table.php';
}

/**
 * TWER_Admin_List_Table_Products Class.
 */
class TWER_Admin_List_Table_Route extends TWER_Admin_List_Table {

	/**
	 * Post type.
	 *
	 * @var string
	 */
	protected $list_table_type = 'route';

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Define which columns are sortable.
	 *
	 * @param  array  $columns  Existing columns.
	 *
	 * @return array
	 */
	public function define_sortable_columns( $columns ) {
		$custom = [
			'map_name' => 'map_name',
			'name'     => 'title',
		];

		return wp_parse_args( $custom, $columns );
	}

	/**
	 * Define which columns to show on this screen.
	 *
	 * @param  array  $columns  Existing columns.
	 *
	 * @return array
	 */
	public function define_columns( $columns ) {
		if ( empty( $columns ) && ! is_array( $columns ) ) {
			$columns = [];
		}

		unset( $columns['title'], $columns['comments'], $columns['date'], $columns['categories'] );

		$show_columns                          = [];
		$show_columns['cb']                    = '<input type="checkbox" />';
		$show_columns['name']                  = esc_html__( 'Name', 'treweler' );
    if(!TWER_IS_FREE) {
      $show_columns['taxonomy-map-category'] = esc_html__( 'Categories', 'treweler' );
    }
		$show_columns['map_name']              = esc_html__( 'Route Map', 'treweler' );
		$show_columns['date']                  = esc_html__( 'Date', 'treweler' );

		return array_merge( $show_columns, $columns );
	}

	/**
	 * Define primary column.
	 *
	 * @return string
	 */
	protected function get_primary_column() {
		return 'name';
	}

	/**
	 * Get row actions to show in the list table.
	 *
	 * @param  array  $actions  Array of actions.
	 * @param  WP_Post  $post  Current post object.
	 *
	 * @return array
	 */
	protected function get_row_actions( $actions, $post ) {
		/* translators: %d: post ID. */
		return array_merge( [ 'id' => sprintf( esc_html__( 'ID: %d', 'treweler' ), $post->ID ) ], $actions );
	}

	/**
	 * Render column: name.
	 */
	protected function render_name_column() {
		global $post;

		$edit_link = get_edit_post_link( $this->object->post_id );
		$title     = _draft_or_post_title();

		echo '<strong><a class="row-title" href="' . esc_url( $edit_link ) . '">' . esc_html( $title ) . '</a>';

		_post_states( $post );

		echo '</strong>';

		$parent_id = wp_get_post_parent_id( $this->object->post_id );
		if ( $parent_id > 0 ) {
			echo '&nbsp;&nbsp;&larr; <a href="' . esc_url( get_edit_post_link( $parent_id ) ) . '">' . get_the_title( $parent_id ) . '</a>'; // @codingStandardsIgnoreLine.
		}

		get_inline_data( $post );
	}


	/**
	 * Render columm: map_name.
	 */
	protected function render_map_name_column() {
    $post_id = isset( $this->object->ID ) ? $this->object->ID : '';
    $route_map_id = get_post_meta( $post_id, '_treweler_route_map_id', true );
    if ( is_array( $route_map_id ) ) {
      $edit_links = [];
      foreach ( $route_map_id as $id ) {
        if ( 'publish' !== get_post_status( $id ) ) {
          continue;
        }
        $edit_links[] = '<a href="' . esc_url( get_edit_post_link( $id ) ) . '" title="' . get_the_title( $id ) . '">' . get_the_title( $id ) . '</a>';
      }
      echo implode( ', ', $edit_links );
    } else {
      if ( $route_map_id !== '' && 'publish' === get_post_status( $route_map_id ) ) {
        edit_post_link( get_the_title( $route_map_id ), '', '', $route_map_id );
      }
    }
	}


	/**
	 * Pre-fetch any data for the row each column has access to it. the_route global is there for bw compat.
	 *
	 * @param  int  $post_id  Post ID being shown.
	 */
	protected function prepare_row_data( $post_id ) {
		global $the_route;

		if ( empty( $this->object ) || $this->object->post_id !== $post_id ) {
			$the_route    = get_post( $post_id );
			$this->object = $the_route;
		}
	}

}
