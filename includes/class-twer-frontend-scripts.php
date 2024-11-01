<?php
/**
 * Handle frontend scripts
 *
 * @package Treweler/Classes
 * @version 0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Frontend scripts class.
 */
class TWER_Frontend_Scripts {

	/**
	 * Contains an array of script handles registered by TWER.
	 *
	 * @var array
	 */
	private static array $scripts = [];

	/**
	 * Contains an array of script handles registered by TWER.
	 *
	 * @var array
	 */
	private static array $styles = [];


	/**
	 * Contains an array of script handles localized by TWER.
	 *
	 * @var array
	 */
	private static array $wp_localize_scripts = array();


	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'load_scripts' ], 999 );
		//add_filter( 'script_loader_tag', [ __CLASS__, 'add_defer_attr' ], 10, 2 );
		add_action( 'wp_print_scripts', [ __CLASS__, 'localize_printed_scripts' ], 5 );
		add_action( 'wp_print_footer_scripts', [ __CLASS__, 'localize_printed_scripts' ], 5 );
	}


	public static function add_defer_attr( $tag, $handle ) {
		// add script handles to the array below
		$scripts_to_defer = self::get_scripts();

		foreach ( $scripts_to_defer as $defer_script ) {
			if ( $defer_script === $handle ) {
				return str_replace( ' src', ' async defer src', $tag );
			}
		}

		return $tag;
	}

	/**
	 * Get sCripts for the frontend.
	 *
	 * @return array
	 */
	public static function get_scripts() {
		return apply_filters( 'treweler_enqueue_scripts', self::$scripts );
	}

	/**
	 * Get styles for the frontend.
	 *
	 * @return array
	 */
	public static function get_styles() {
		return apply_filters( 'treweler_enqueue_styles', self::$styles );
	}

	/**
	 * Register/queue frontend scripts.
	 */
	public static function load_scripts() {
		global $post;
		if ( ! did_action( 'before_treweler_init' ) ) {
			return;
		}

		self::register_styles();
		self::register_scripts();


		if ( twer_is_map_in_page() && twer_is_valid_apikey() ) {
			$map_id = twer_get_map_id();

			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );

			self::enqueue_style( 'treweler-mapbox-lib' );
			self::enqueue_style( 'treweler-mapbox-lib-geocoder' );
			self::enqueue_style( 'treweler-mapbox-lib-draw' );
			self::enqueue_style( 'treweler-icons' );
      self::enqueue_style( 'treweler-fancybox-style' );

			// Include scripts for fullscreen map
			self::enqueue_script( 'treweler-mapbox-lib' );
			self::enqueue_script( 'treweler-mapbox-lib-geocoder' );
			self::enqueue_script( 'treweler-mapbox-lib-draw' );
			self::enqueue_script( 'treweler-mapbox-lib-language' );
			self::enqueue_script( 'treweler-libs' );
      self::enqueue_script( 'treweler-fancybox-script' );
			self::enqueue_script( 'treweler' );

			// Include boundaries scripts
			if ( get_post_meta( $map_id, '_treweler_boundaries', true ) ) {
				self::enqueue_script( 'treweler-boundaries' );
			}

			if ( twer_map_has_routes( $map_id ) ) {
				self::enqueue_script( 'treweler-routes' );
			}

			if ( twer_map_has_shapes( $map_id ) ) {
				self::enqueue_script( 'treweler-shapes' );
			}

			wp_add_inline_script( 'treweler', TWER_Screen_Map::generate_map_js() );


			if ( 'yes' === twerIsEnableGeolocation( $map_id ) || twerIsEnableStoreLocator( $map_id ) ) {
				self::enqueue_script( 'treweler-user-location-script' );
			}

			// Include store locator scripts
			if ( twerIsEnableStoreLocator( $map_id ) ) {
				self::enqueue_script( 'treweler-store-locator-script' );
			}


			if ( twerIsEnableDirections( $map_id ) ) {
				self::enqueue_script( 'treweler-mapbox-lib-directions-script-improved' );
				self::enqueue_script( 'treweler-directions-script' );

				self::enqueue_style( 'treweler-mapbox-lib-directions-style' );
				self::enqueue_style( 'treweler-directions-style' );
			}

			self::enqueue_style( 'treweler-style' );


			// Placeholder style.
			wp_register_style( 'treweler-inline', false ); // phpcs:ignore
			wp_enqueue_style( 'treweler-inline' );

			$treweler_options = get_option( 'treweler' );
			$inline_css       = isset( $treweler_options['css'] ) ? $treweler_options['css'] : '';
			if ( ! empty( $inline_css ) ) {
				wp_add_inline_style( 'treweler-inline', $inline_css );
			}
		}

		$contentHasShortcode = ( ! empty( $post->post_content ) && strpos( $post->post_content, '[treweler' ) !== false );
		if ( $contentHasShortcode || apply_filters( 'twer_force_include_shortcode_styles', false ) ) {
			self::enqueue_style( 'treweler-shortcode' );
		}


		wp_set_script_translations( 'treweler', 'treweler', plugin_basename( dirname( TWER_PLUGIN_FILE ) ) . '/languages/js' );
		wp_set_script_translations( 'treweler-store-locator-script', 'treweler', plugin_basename( dirname( TWER_PLUGIN_FILE ) ) . '/languages/js' );

	}

	/**
	 * Register all TWER sty;es.
	 */
	private static function register_styles() {
		$suffix = defined( 'STYLE_DEBUG' ) && STYLE_DEBUG ? '' : '.min';

		$register_styles = [
			'treweler-mapbox-lib'                  => [
				//'src'     => self::get_asset_url( 'assets/css/treweler-mapbox' . $suffix . '.css' ),
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.5/mapbox-gl.css',
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
			'treweler-mapbox-lib-geocoder'         => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css',
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
			'treweler-mapbox-lib-draw'             => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.2/mapbox-gl-draw.css',
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
			'treweler-style'                       => [
				'src'     => self::get_asset_url( 'assets/css/treweler-style' . $suffix . '.css' ),
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
			'treweler-mapbox-lib-directions-style' => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v' . TWER_MAPBOX_LIB_DIRECTIONS_VERSION . '/mapbox-gl-directions.css',
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
			'treweler-directions-style'            => [
				'src'     => self::get_asset_url( 'assets/css/treweler-directions' . $suffix . '.css' ),
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
			'treweler-shortcode'                   => [
				'src'     => self::get_asset_url( 'assets/css/treweler-shortcode' . $suffix . '.css' ),
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
			'treweler-icons'                       => [
				'src'     => 'https://fonts.googleapis.com/css2?family=Material+Icons&display=block',
				'deps'    => [],
				'version' => TWER_VERSION,
				'has_rtl' => false,
			],
      'treweler-fancybox-style' => [
        'src'     => 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.31/dist/fancybox.css',
        'deps'    => [],
        'version' => TWER_VERSION,
        'has_rtl' => false,
      ]
		];
		foreach ( $register_styles as $name => $props ) {
			self::register_style( $name, $props['src'], $props['deps'], $props['version'], 'all', $props['has_rtl'] );
		}
	}

	/**
	 * Return asset URL.
	 *
	 * @param string $path Assets path.
	 *
	 * @return string
	 */
	private static function get_asset_url( $path ) {
		return apply_filters( 'treweler_get_asset_url', plugins_url( $path, TWER_PLUGIN_FILE ), $path );
	}

	/**
	 * Register a style for use.
	 *
	 * @param string $handle Name of the stylesheet. Should be unique.
	 * @param string $path Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
	 * @param string[] $deps An array of registered stylesheet handles this stylesheet depends on.
	 * @param string $version String specifying stylesheet version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
	 * @param string $media The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
	 * @param boolean $has_rtl If has RTL version to load too.
	 *
	 * @uses   wp_register_style()
	 */
	private static function register_style(
		$handle,
		$path,
		$deps = [],
		$version = TWER_VERSION,
		$media = 'all',
		$has_rtl = false
	) {
		self::$styles[] = $handle;
		wp_register_style( $handle, $path, $deps, $version, $media );

		if ( $has_rtl ) {
			wp_style_add_data( $handle, 'rtl', 'replace' );
		}
	}

	/**
	 * Register all TWER scripts.
	 */
	private static function register_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$register_scripts = [
			'treweler-mapbox-lib'                            => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.5/mapbox-gl.js',
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler-mapbox-lib-geocoder'                   => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js',
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler-mapbox-lib-draw'                       => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.2/mapbox-gl-draw.js',
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler-mapbox-lib-language'                   => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v1.0.0/mapbox-gl-language.js',
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler-libs'                                  => [
				'src'     => self::get_asset_url( 'assets/js/treweler-libs' . $suffix . '.js' ),
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler-shapes'                                => [
				'src'     => self::get_asset_url( 'assets/js/treweler-shapes' . $suffix . '.js' ),
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler-boundaries'                            => [
				'src'     => self::get_asset_url( 'assets/js/treweler-boundaries' . $suffix . '.js' ),
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler-routes'                                => [
				'src'     => self::get_asset_url( 'assets/js/treweler-routes' . $suffix . '.js' ),
				'deps'    => [ 'jquery', 'lodash', ],
				'version' => TWER_VERSION,
			],
			'treweler'                                       => [
				'src'     => self::get_asset_url( 'assets/js/treweler' . $suffix . '.js' ),
				'deps'    => [ 'jquery', 'lodash', 'wp-i18n' ],
				'version' => TWER_VERSION,
			],
			'treweler-store-locator-script'                  => [
				'src'     => self::get_asset_url( 'assets/js/treweler-store-locator' . $suffix . '.js' ),
				'deps'    => [ 'treweler', 'jquery', 'lodash', 'wp-i18n', 'jquery-ui-slider', 'jquery-touch-punch' ],
				'version' => TWER_VERSION,
			],
			'treweler-mapbox-lib-directions-script'          => [
				'src'     => 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v' . TWER_MAPBOX_LIB_DIRECTIONS_VERSION . '/mapbox-gl-directions.js',
				'deps'    => [],
				'version' => TWER_VERSION,
			],
			'treweler-mapbox-lib-directions-script-improved' => [
				'src'     => self::get_asset_url( 'assets/external-libs/mapbox-directions.js' ),
				'deps'    => [],
				'version' => TWER_VERSION,
			],
			'treweler-directions-script'                     => [
				'src'     => self::get_asset_url( 'assets/js/treweler-directions' . $suffix . '.js' ),
				'deps'    => [ 'treweler', 'treweler-store-locator-script', 'jquery', 'lodash', 'wp-i18n' ],
				'version' => TWER_VERSION,
			],
			'treweler-user-location-script'                  => [
				'src'     => self::get_asset_url( 'assets/js/treweler-user-location' . $suffix . '.js' ),
				'deps'    => [ 'treweler', 'jquery', 'lodash', 'wp-i18n' ],
				'version' => TWER_VERSION,
			],
      'treweler-fancybox-script'                  => [
        'src'     => 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.31/dist/fancybox.umd.js',
        'deps'    => [ 'jquery', 'lodash', 'wp-i18n' ],
        'version' => TWER_VERSION,
      ]
		];

		foreach ( $register_scripts as $name => $props ) {
			self::register_script( $name, $props['src'], $props['deps'], $props['version'] );
		}
	}

	/**
	 * Register a script for use.
	 *
	 * @param string $handle Name of the script. Should be unique.
	 * @param string $path Full URL of the script, or path of the script relative to the WordPress root directory.
	 * @param string[] $deps An array of registered script handles this script depends on.
	 * @param string $version String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
	 * @param boolean $in_footer Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
	 *
	 * @uses   wp_register_script()
	 */
	private static function register_script( $handle, $path, $deps = [], $version = TWER_VERSION, $in_footer = true ) {
		self::$scripts[] = $handle;
		wp_register_script( $handle, $path, $deps, $version, $in_footer );
	}

	/**
	 * Register and enqueue a styles for use.
	 *
	 * @param string $handle Name of the stylesheet. Should be unique.
	 * @param string $path Full URL of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
	 * @param string[] $deps An array of registered stylesheet handles this stylesheet depends on.
	 * @param string $version String specifying stylesheet version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
	 * @param string $media The media for which this stylesheet has been defined. Accepts media types like 'all', 'print' and 'screen', or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
	 * @param boolean $has_rtl If has RTL version to load too.
	 *
	 * @uses   wp_enqueue_style()
	 */
	private static function enqueue_style(
		$handle,
		$path = '',
		$deps = [],
		$version = TWER_VERSION,
		$media = 'all',
		$has_rtl = false
	) {
		if ( ! in_array( $handle, self::$styles, true ) && $path ) {
			self::register_style( $handle, $path, $deps, $version, $media, $has_rtl );
		}
		wp_enqueue_style( $handle );
	}

	/**
	 * Register and enqueue a script for use.
	 *
	 * @param string $handle Name of the script. Should be unique.
	 * @param string $path Full URL of the script, or path of the script relative to the WordPress root directory.
	 * @param string[] $deps An array of registered script handles this script depends on.
	 * @param string $version String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes. If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added.
	 * @param boolean $in_footer Whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
	 *
	 * @uses   wp_enqueue_script()
	 */
	private static function enqueue_script(
		$handle,
		$path = '',
		$deps = [],
		$version = TWER_VERSION,
		$in_footer = true
	) {
		if ( ! in_array( $handle, self::$scripts, true ) && $path ) {
			self::register_script( $handle, $path, $deps, $version, $in_footer );
		}
		wp_enqueue_script( $handle );
	}

	/**
	 * Localize a TWER script once.
	 *
	 * @since 2.3.0 this needs less wp_script_is() calls due to https://core.trac.wordpress.org/ticket/28404 being added in WP 4.0.
	 *
	 * @param string $handle Script handle the data will be attached to.
	 */
	private static function localize_script( $handle ) {
		if ( ! in_array( $handle, self::$wp_localize_scripts, true ) && wp_script_is( $handle ) ) {
			$data = self::get_script_data( $handle );

			if ( ! $data ) {
				return;
			}

			$name                        = str_replace( '-', '_', $handle ) . '_params';
			self::$wp_localize_scripts[] = $handle;
			wp_localize_script( $handle, $name, apply_filters( $name, $data ) );
		}
	}

	/**
	 * Return data for script handles.
	 *
	 * @param string $handle Script handle the data will be attached to.
	 *
	 * @return array|bool
	 */
	private static function get_script_data( $handle ) {
		global $wp;

		switch ( $handle ) {
			case 'treweler':
				$params = array(
					'ajax_url'        => TWER()->ajax_url(),
					'data'            => TWER()->plugin_url() . '/assets/data/',
					'i18n_categories' => [
						'all'          => esc_html__( 'All categories', 'treweler' ),
						'selected'     => esc_html__( 'Categories selected', 'treweler' ),
						'one_selected' => esc_html__( 'Category selected', 'treweler' ),
						'no_selected'  => esc_html__( 'No category selected', 'treweler' ),
						'not_found'    => esc_html__( 'No Categories Found', 'treweler' )
					],
					'i18n'            => [
						'select_items' => esc_html__( 'Select Items', 'treweler' ),
						'filters'      => esc_html__( 'Filters', 'treweler' )
					]
				);
				break;
			default:
				$params = false;
		}

		$params = apply_filters_deprecated( $handle . '_params', array( $params ), '1.13', 'twer_get_script_data' );

		return apply_filters( 'twer_get_script_data', $params, $handle );
	}

	/**
	 * Localize scripts only when enqueued.
	 */
	public static function localize_printed_scripts() {
		foreach ( self::$scripts as $handle ) {
			self::localize_script( $handle );
		}
	}
}

TWER_Frontend_Scripts::init();
