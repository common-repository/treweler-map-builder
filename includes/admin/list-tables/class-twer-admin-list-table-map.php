<?php
/**
 * List tables: map.
 *
 * @package  Treweler/Admin
 * @version  0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'TWER_Admin_List_Table_Map', false ) ) {
	return;
}

if ( ! class_exists( 'TWER_Admin_List_Table', false ) ) {
	include_once 'abstract-class-twer-admin-list-table.php';
}

/**
 * TWER_Admin_List_Table_Products Class.
 */
class TWER_Admin_List_Table_Map extends TWER_Admin_List_Table {

	/**
	 * Post type.
	 *
	 * @var string
	 */
	protected $list_table_type = 'map';

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
			'map_id' => 'map_id'
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

		unset( $columns['title'], $columns['comments'], $columns['date'], $columns['taxonomy-map-category'] );

		$show_columns          = [];
		$show_columns['cb']    = '<input type="checkbox" />';
		$show_columns['title'] = esc_html__( 'Name', 'treweler' );
		//$show_columns['categories'] = esc_html__( 'Categories', 'treweler' );
		$show_columns['map_id'] = esc_html__( 'Map ID', 'treweler' );
		$show_columns['date']   = esc_html__( 'Date', 'treweler' );

		return array_merge( $show_columns, $columns );
	}


	/**
	 * Render columm: map_id.
	 */
	protected function render_map_id_column() {
		$map_id = isset( $this->object->ID ) ? $this->object->ID : '';
		echo esc_html( $map_id );
	}


	/**
	 * Pre-fetch any data for the row each column has access to it. the_map global is there for bw compat.
	 *
	 * @param  int  $post_id  Post ID being shown.
	 */
	protected function prepare_row_data( $post_id ) {
		global $the_map;

		if ( empty( $this->object ) || $this->object->post_id !== $post_id ) {
			$the_map      = get_post( $post_id );
			$this->object = $the_map;
		}
	}

}
