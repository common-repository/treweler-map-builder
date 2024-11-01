<?php
/**
 * Taxonomy
 * Registers taxonomy.
 *
 * @package Treweler/Classes/Taxonomy
 * @version 0.43
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types Class.
 */
class TWER_Taxonomy {
	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'restrict_manage_posts', [ __CLASS__, 'add_dropdown_filter_taxonomy' ] );
		add_action( 'init', [ __CLASS__, 'insert_default_map_category_term' ], 12 );

		add_filter( 'parse_query', [ __CLASS__, 'dropdown_filter_taxonomy_query' ] );

		add_action( 'save_post_marker', [ __CLASS__, 'set_default_map_category' ], 99, 2 );
		add_action( 'save_post_route', [ __CLASS__, 'set_default_map_category' ], 99, 2 );
		add_action( 'delete_term', [ __CLASS__, 'check_post_under_term_map_category' ], 10, 3 );
	}

	public static function add_dropdown_filter_taxonomy() { // || get_post_type() === 'twer-shapes'
		if ( get_post_type() === 'marker' || get_post_type() === 'route' ||
         ( ! empty( $_REQUEST['map-category'] ) && isset($_REQUEST['post_type']) && ($_REQUEST['post_type'] === 'marker' || $_REQUEST['post_type'] === 'route' ) ) ) {
      // || $_REQUEST['post_type'] === 'twer-shapes'

			$taxonomy     = 'map-category';
			$map_taxonomy = get_taxonomy( $taxonomy );
			$selected     = '';

			if ( isset( $_REQUEST[ $taxonomy ] ) ) {
				$selected = $_REQUEST[ $taxonomy ]; //in case the current page is already filtered
			}

			wp_dropdown_categories( array(
				'show_option_all' => esc_html__( "Show All {$map_taxonomy->label}", 'treweler' ),
				'taxonomy'        => $taxonomy,
				'name'            => 'map-category',
				'orderby'         => 'name',
				'selected'        => $selected,
				'hierarchical'    => false,
				'depth'           => 3,
				'show_count'      => false,
				'hide_empty'      => false,
			) );
		}
	}

	public static function dropdown_filter_taxonomy_query( $query ) {
		global $pagenow;
		global $typenow;
		if ( $pagenow == 'edit.php' && $typenow !== 'ubicaciones'  ) {
			$filters = get_object_taxonomies( $typenow );
			foreach ( $filters as $tax_slug ) {
				$var = &$query->query_vars[ $tax_slug ];
				if ( isset( $var ) ) {
					$term = get_term_by( 'id', $var, $tax_slug );
					$var  = $term->slug ?? '';
				}
			}
		}

		return $query;
	}

	public static function insert_default_map_category_term() {
		$cat_exists = term_exists( 'uncategorized-map', 'map-category' );

		if ( ! $cat_exists ) {
			$new_cat        = wp_insert_term(
				'Uncategorized',
				'map-category',
				array(
					'description' => 'This is your default map category',
					'slug'        => 'uncategorized-map',
				)
			);
			$default_cat_id = ( $new_cat && is_array( $new_cat ) ) ? $new_cat['term_id'] : false;
		} else {
			$default_cat_id = $cat_exists;
		}

		$stored_default_cat = get_option( 'default_map_category' );

		if ( empty( $stored_default_cat ) && $default_cat_id ) {
			update_option( 'default_map_category', $default_cat_id );
		}
	}

	public static function set_default_map_category( $post_id, $post ) {
		if ( 'publish' === $post->post_status ) {
			$map_cats             = wp_get_post_terms( $post_id, 'map-category' );
			$default_map_category = (int) get_option( 'default_map_category' );

			if ( empty( $map_cats ) ) {
				wp_set_object_terms( $post_id, $default_map_category, 'map-category' );
			}
		}
	}

	/**
	 * Set default taxonomy in post when the only taxonomy deleted
	 * action wp_delete_term -
	 */
	public static function check_post_under_term_map_category(
		$term = '',
		$tt_id = '',
		$taxonomy = null,
		$deleted_term = '',
		$object_ids = ''
	) {

		// If Taxonomy not map-category, than skipped
		if ( $taxonomy != 'map-category' ) {
			return;
		}

		$default_map_category = (int) get_option( 'default_map_category' );

		$post_marker = self::get_post_without_tax( 'marker', 'map-category' );
		foreach ( $post_marker as $a ) {
			wp_set_object_terms( $a->ID, $default_map_category, 'map-category' );
		}

		$post_route = self::get_post_without_tax( 'route', 'map-category' );
		foreach ( $post_route as $b ) {
			wp_set_object_terms( $b->ID, $default_map_category, 'map-category' );
		}

	}

	public static function get_post_without_tax( $post_type, $tax_name ) {
		global $wpdb;
		$list = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT  * 
FROM    " . $wpdb->prefix . "posts p
WHERE   p.post_type = %s 
        AND p.post_status = 'publish' 
        AND NOT EXISTS
        (
        SELECT  *
        FROM    {$wpdb->prefix}term_relationships rel
        JOIN    {$wpdb->prefix}term_taxonomy tax
        ON      tax.term_taxonomy_id = rel.term_taxonomy_id 
                AND tax.taxonomy = %s 
        JOIN    {$wpdb->prefix}terms term
        ON      term.term_id = tax.term_id
        WHERE   p.ID = rel.object_id 
        ); ",
				$post_type,
				$tax_name
			)
		);

		return $list;
	}


}

TWER_Taxonomy::init();
