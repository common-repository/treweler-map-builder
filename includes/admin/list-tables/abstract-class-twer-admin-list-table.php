<?php
/**
 * List tables.
 *
 * @package  Treweler/Admin
 * @version  0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'TWER_Admin_List_Table', false ) ) {
	return;
}

/**
 * TWER_Admin_List_Table Class.
 */
abstract class TWER_Admin_List_Table {

	/**
	 * Post type.
	 *
	 * @var string
	 */
	protected $list_table_type = '';

	/**
	 * Object being shown on the row.
	 *
	 * @var object|null
	 */
	protected $object = null;

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( $this->list_table_type ) {
			add_filter( 'view_mode_post_types', [ $this, 'disable_view_mode' ] );
      add_action( 'restrict_manage_posts', [ $this, 'restrict_manage_posts' ] );
			add_filter( 'default_hidden_columns', [ $this, 'default_hidden_columns' ], 10, 2 );
			add_filter( 'bulk_actions-edit-' . $this->list_table_type, [ $this, 'define_bulk_actions' ] );
			add_filter( 'handle_bulk_actions-edit-' . $this->list_table_type, [ $this, 'handle_bulk_actions' ], 10, 3 );
			add_filter( 'manage_edit-' . $this->list_table_type . '_sortable_columns', [ $this, 'define_sortable_columns' ] );
			add_filter( 'post_row_actions', [ $this, 'row_actions' ], 100, 2 );
			add_filter( 'list_table_primary_column', [ $this, 'list_table_primary_column' ], 10, 2 );
			add_filter( 'manage_' . $this->list_table_type . '_posts_columns', [ $this, 'define_columns' ] );
			add_action( 'manage_' . $this->list_table_type . '_posts_custom_column', [ $this, 'render_columns' ], 10, 2 );
		}
	}

	/**
	 * Define which columns to show on this screen.
	 *
	 * @param  array  $columns  Existing columns.
	 *
	 * @return array
	 */
	public function define_columns( $columns ) {
		return $columns;
	}

	/**
	 * Define bulk actions.
	 *
	 * @param  array  $actions  Existing actions.
	 *
	 * @return array
	 */
	public function define_bulk_actions( $actions ) {
		return $actions;
	}

	/**
	 * Render individual columns.
	 *
	 * @param  string  $column  Column ID to render.
	 * @param  int  $post_id  Post ID being shown.
	 */
	public function render_columns( $column, $post_id ) {
		$this->prepare_row_data( $post_id );

		if ( ! $this->object ) {
			return;
		}

		if ( is_callable( [ $this, 'render_' . $column . '_column' ] ) ) {
			$this->{"render_{$column}_column"}();
		}
	}

	/**
	 * Pre-fetch any data for the row each column has access to it.
	 *
	 * @param  int  $post_id  Post ID being shown.
	 */
	protected function prepare_row_data( $post_id ) {
	}

	/**
	 * Removes this type from list of post types that support "View Mode" switching.
	 * View mode is seen on posts where you can switch between list or excerpt. Our post types don't support
	 * it, so we want to hide the useless UI from the screen options tab.
	 *
	 * @param  array  $post_types  Array of post types supporting view mode.
	 *
	 * @return array Array of post types supporting view mode, without this type.
	 */
	public function disable_view_mode( $post_types ) {
		unset( $post_types[ $this->list_table_type ] );

		return $post_types;
	}

  /**
   * See if we should render search filters or not.
   */
  public function restrict_manage_posts() {
    global $typenow;

    if ( $this->list_table_type === $typenow ) {
      $this->render_filters();
    }
  }

  /**
   * Render any custom filters and search inputs for the list table.
   */
  protected function render_filters() {}


	/**
	 * Set row actions.
	 *
	 * @param  array  $actions  Array of actions.
	 * @param  WP_Post  $post  Current post object.
	 *
	 * @return array
	 */
	public function row_actions( $actions, $post ) {
		if ( $this->list_table_type === $post->post_type ) {
			return $this->get_row_actions( $actions, $post );
		}

		return $actions;
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
		return $actions;
	}

	/**
	 * Adjust which columns are displayed by default.
	 *
	 * @param  array  $hidden  Current hidden columns.
	 * @param  object  $screen  Current screen.
	 *
	 * @return array
	 */
	public function default_hidden_columns( $hidden, $screen ) {
		if ( isset( $screen->id ) && 'edit-' . $this->list_table_type === $screen->id ) {
			$hidden = array_merge( $hidden, $this->define_hidden_columns() );
		}

		return $hidden;
	}

	/**
	 * Define hidden columns.
	 *
	 * @return array
	 */
	protected function define_hidden_columns() {
		return [];
	}

	/**
	 * Set list table primary column.
	 *
	 * @param  string  $default  Default value.
	 * @param  string  $screen_id  Current screen ID.
	 *
	 * @return string
	 */
	public function list_table_primary_column( $default, $screen_id ) {
		if ( 'edit-' . $this->list_table_type === $screen_id && $this->get_primary_column() ) {
			return $this->get_primary_column();
		}

		return $default;
	}

	/**
	 * Define primary column.
	 *
	 * @return string
	 */
	protected function get_primary_column() {
		return '';
	}

	/**
	 * Define which columns are sortable.
	 *
	 * @param  array  $columns  Existing columns.
	 *
	 * @return array
	 */
	public function define_sortable_columns( $columns ) {
		return $columns;
	}


	/**
	 * Handle bulk actions.
	 *
	 * @param  string  $redirect_to  URL to redirect to.
	 * @param  string  $action  Action name.
	 * @param  array  $ids  List of ids.
	 *
	 * @return string
	 */
	public function handle_bulk_actions( $redirect_to, $action, $ids ) {
		return esc_url_raw( $redirect_to );
	}
}
