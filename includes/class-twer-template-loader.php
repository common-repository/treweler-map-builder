<?php
/**
 * Template Loader
 *
 * @package Treweler\Classes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Template loader class.
 */
class TWER_Template_Loader {

	/**
	 * Hook in methods.
	 */
	public static function init() {
    add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
	}

	/**
	 * Load a template.
	 *
	 * Handles template usage so that we can use our own templates instead of the theme's.
	 *
	 * Templates are in the 'templates' folder. Treweler looks for theme
	 * overrides in /theme/treweler/ by default.
	 *
	 * For beginners, it also looks for a treweler.php template first. If the user adds
	 * this to the theme (containing a treweler() inside) this will be used for all
	 * Treweler templates.
	 *
	 * @param string $template Template to load.
	 * @return string
	 */
	public static function template_loader( $template ) {
		if ( is_embed() ) {
			return $template;
		}

		$default_file = self::get_template_loader_default_file();

		if ( $default_file ) {
			/**
			 * Filter hook to choose which files to find before Treweler does it's own logic.
			 *
			 * @since 3.0.0
			 * @var array
			 */
			$search_files = self::get_template_loader_files( $default_file );
			$template     = locate_template( $search_files );

			if ( ! $template || TWER_TEMPLATE_DEBUG_MODE ) {
				if ( false !== strpos( $default_file, 'map-category' )  ) {
					$cs_template = str_replace( '_', '-', $default_file );
					$template    = TWER()->plugin_path() . '/templates/' . $cs_template;
				} else {
					$template = TWER()->plugin_path() . '/templates/' . $default_file;
				}
			}
		}

		return $template;
	}

	/**
	 * Checks whether a block template with that name exists.
	 *
	 * **Note: ** This checks both the `templates` and `block-templates` directories
	 * as both conventions should be supported.
	 *
	 * @since  5.5.0
	 * @param string $template_name Template to check.
	 * @return boolean
	 */
	private static function has_block_template( $template_name ) {
		if ( ! $template_name ) {
			return false;
		}

		$has_template            = false;
		$template_filename       = $template_name . '.html';
		// Since Gutenberg 12.1.0, the conventions for block templates directories have changed,
		// we should check both these possible directories for backwards-compatibility.
		$possible_templates_dirs = array( 'templates', 'block-templates' );

		// Combine the possible root directory names with either the template directory
		// or the stylesheet directory for child themes, getting all possible block templates
		// locations combinations.
		$filepath        = DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template_filename;
		$legacy_filepath = DIRECTORY_SEPARATOR . 'block-templates' . DIRECTORY_SEPARATOR . $template_filename;
		$possible_paths  = array(
			get_stylesheet_directory() . $filepath,
			get_stylesheet_directory() . $legacy_filepath,
			get_template_directory() . $filepath,
			get_template_directory() . $legacy_filepath,
		);

		// Check the first matching one.
		foreach ( $possible_paths as $path ) {
			if ( is_readable( $path ) ) {
				$has_template = true;
				break;
			}
		}

		/**
		 * Filters the value of the result of the block template check.
		 *
		 * @since x.x.x
		 *
		 * @param boolean $has_template value to be filtered.
		 * @param string $template_name The name of the template.
		 */
		return (bool) apply_filters( 'treweler_has_block_template', $has_template, $template_name );
	}

	/**
	 * Get the default filename for a template except if a block template with
	 * the same name exists.
	 *
	 * @since  3.0.0
	 * @since  5.5.0 If a block template with the same name exists, return an
	 * empty string.
	 * @since  6.3.0 It checks custom product taxonomies
	 * @return string
	 */
	private static function get_template_loader_default_file() {
		if ( twer_is_map_in_page() && twer_is_valid_apikey() && ! self::has_block_template( 'page-map' ) ) {
			$default_file = 'page-map.php';
		} else {
      $default_file = '';
    }

		return $default_file;
	}

	/**
	 * Get an array of filenames to search for a given template.
	 *
	 * @since  3.0.0
	 * @param  string $default_file The default file name.
	 * @return string[]
	 */
	private static function get_template_loader_files( $default_file ) {
		$templates   = apply_filters( 'treweler_template_loader_files', array(), $default_file );
		$templates[] = 'treweler.php';

		if ( is_page_template() ) {
			$page_template = get_page_template_slug();

			if ( $page_template ) {
				$validated_file = validate_file( $page_template );
				if ( 0 === $validated_file ) {
					$templates[] = $page_template;
				} else {
					error_log( "Treweler: Unable to validate template path: \"$page_template\". Error Code: $validated_file." ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
				}
			}
		}

		if ( twer_is_map_in_page() && twer_is_valid_apikey() ) {
			$object       = get_queried_object();
      if($object) {
        $name_decoded = urldecode( $object->post_name );
        if ( $name_decoded !== $object->post_name ) {
          $templates[] = "page-{$name_decoded}.php";
        }

        $templates[] = "page-{$object->post_name}.php";
      }
		}


		$templates[] = $default_file;

		$templates[] = TWER()->template_path() . $default_file;

		return array_unique( $templates );
	}

}

add_action( 'init', array( 'TWER_Template_Loader', 'init' ) );
