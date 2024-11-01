<?php
/**
 * Treweler Template Hooks
 *
 * Action/filter hooks used for Treweler functions/templates.
 *
 * @package Treweler\Templates
 * @version 1.13
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'body_class', 'twer_body_class' );

/**
 * WP Header.
 *
 * @see twer_generator_tag()
 */
add_filter( 'get_the_generator_html', 'twer_generator_tag', 10, 2 );
add_filter( 'get_the_generator_xhtml', 'twer_generator_tag', 10, 2 );

/**
 * Content Map Wrappers.
 *
 * @see twer_output_content_wrapper()
 * @see twer_output_content_wrapper_end()
 */
add_action( 'twer_before_main_content', 'twer_output_content_wrapper', 10 );
add_action( 'twer_after_main_content', 'twer_output_content_wrapper_end', 10 );


/**
 * Map Sidebar Elements.
 */
add_action( 'twer_left_sidebar_map', 'twer_output_store_locator', 10 );


/**
 * Map dynamic templates
 */
add_action('twer_map_elements_templates', 'twer_output_store_locator_cards');
add_action('twer_map_elements_templates', 'twer_output_custom_fields', 11);
add_action('twer_map_elements_templates', 'twer_output_filters', 12);


/**
 * Map Store Locator Elements
 */
add_action('twer_extended_store_locator_body', 'twer_output_store_locator_no_results_message', 10);





add_action('twerBodyOpen', 'twerOutputSvgSprites', 15);
