<?php
/**
 * Treweler setup
 *
 * @package Treweler
 * @since   0.23
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Treweler Class.
 *
 * @class Treweler
 */
final class Treweler {

	/**
	 * The single instance of the class.
	 *
	 * @var Treweler
	 * @since 0.23
	 */
	protected static $_instance = null;


	/**
	 * Treweler Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define TWER Constants.
	 */
	private function define_constants() {

    $this->define( 'TWER_MAPBOX_LIB_DIRECTIONS_VERSION', '4.1.1' );
    $this->define('TWER_OLD_POPUP_FIELDS', false);
    $this->define( 'TWER_OUTPUT_OLD_VIEWS_FOR_METABOXES', true );
		$this->define( 'TWER_ABSPATH', dirname( TWER_PLUGIN_FILE ) . '/' );
		$this->define( 'TWER_PLUGIN_BASENAME', plugin_basename( TWER_PLUGIN_FILE ) );
    $this->define( 'TWER_IS_FREE', file_exists(TWER_ABSPATH . 'treweler-free.php') );
    $this->define( 'TWER_FREE_FILE_SUFFIX', TWER_IS_FREE ? '-free' : '' );
    $this->define( 'TWER_TEMPLATE_DEBUG_MODE', false );
		$this->define( 'TWER_NOTICE_MIN_PHP_VERSION', '7.0' );
		$this->define( 'TREWELER_MINIMUM_WP_VERSION', '5.0' );
		$this->define( 'TWER_PHP_MIN_REQUIREMENTS_NOTICE', 'wp_php_min_requirements_' . TWER_NOTICE_MIN_PHP_VERSION . '_' . TREWELER_MINIMUM_WP_VERSION );
    $this->define( 'TWER_META_PREFIX', '_treweler_' );
	}


	/**
	 * Define constant if not already set.
	 *
	 * @param  string  $name  Constant name.
	 * @param  string|bool  $value  Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		/**
		 * Class autoloader.
		 */
		include_once TWER_ABSPATH . 'includes/class-twer-autoloader.php';


		/**
		 * Core classes.
		 */
		include_once TWER_ABSPATH . 'includes/twer-core-functions.php';
		include_once TWER_ABSPATH . 'includes/class-twer-post-types.php';
		include_once TWER_ABSPATH . 'includes/class-twer-shortcodes.php';
    include_once TWER_ABSPATH . 'includes/class-twer-ajax.php';
    include_once TWER_ABSPATH . 'includes/class-twer-cache-helper.php';
    include_once TWER_ABSPATH . 'includes/admin/tax-order/twer-custom-taxonomy-order.php';
    include_once TWER_ABSPATH . 'includes/class-twer-install.php';

		if ( $this->is_request( 'admin' ) ) {
			include_once TWER_ABSPATH . 'includes/admin/class-twer-admin.php';
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}
	}

	/**
	 * What type of request is this?
	 *
	 * @param  string  $type  admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) && ! $this->is_rest_api_request();
		}
	}

	/**
	 * Returns true if the request is a non-legacy REST API request.
	 *
	 * Legacy REST requests should still run some extra code for backwards compatibility.
	 *
	 * @todo: replace this function once core WP function is available: https://core.trac.wordpress.org/ticket/42061.
	 *
	 * @return bool
	 */
	public function is_rest_api_request() {
		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return false;
		}

		$rest_prefix         = trailingslashit( rest_get_url_prefix() );
		$is_rest_api_request = ( false !== strpos( $_SERVER['REQUEST_URI'],
				$rest_prefix ) ); // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		return apply_filters( 'treweler_is_rest_api_request', $is_rest_api_request );
	}

	/**
	 * Include required frontend files.
	 */
	public function frontend_includes() {
    include_once TWER_ABSPATH . 'includes/twer-template-hooks.php';
    include_once TWER_ABSPATH . 'includes/twer-map-functions.php';
    include_once TWER_ABSPATH . 'includes/class-twer-template-loader.php';
		include_once TWER_ABSPATH . 'includes/class-twer-map'.TWER_FREE_FILE_SUFFIX.'.php';
		include_once TWER_ABSPATH . 'includes/class-twer-frontend-scripts.php';
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 0.23
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ], - 1 );
    add_action( 'after_setup_theme', [ $this, 'setup_environment' ] );
		add_action( 'after_setup_theme', [ $this, 'include_template_functions' ], 11 );
		add_action( 'init', [ $this, 'init' ], 0 );
		add_action( 'init', [ 'TWER_Shortcodes', 'init' ] );
	}

	/**
	 * Main Treweler Instance.
	 *
	 * Ensures only one instance of Treweler is loaded or can be loaded.
	 *
	 * @return Treweler - Main instance.
	 * @see TWER()
	 * @since 0.23
	 * @static
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

  /**
   * Ensure theme and server variable compatibility.
   */
  public function setup_environment() {

    if ( twer_is_map_iframe() ) {
      show_admin_bar( false );
    }

    /**
     * TWER_TEMPLATE_PATH constant.
     *
     * @deprecated 1.12 Use TWER()->template_path() instead.
     */
    $this->define( 'TWER_TEMPLATE_PATH', $this->template_path() );

  }

	/**
	 * Cloning is forbidden.
	 *
	 * @since 0.23
	 */
	public function __clone() {
		twer_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden.', 'treweler' ), '0.23' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 0.23
	 */
	public function __wakeup() {
		twer_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing instances of this class is forbidden.', 'treweler' ),
			'0.23' );
	}

	/**
	 * When WP has loaded all plugins, trigger the `treweler_loaded` hook.
	 *
	 * This ensures `treweler_loaded` is called only after all other plugins
	 * are loaded, to avoid issues caused by plugin directory naming changing
	 * the load order. See #21524 for details.
	 *
	 * @since 0.23
	 */
	public function on_plugins_loaded() {
		do_action( 'treweler_loaded' );
	}

	/**
	 * Function used to Init Treweler Template Functions - This makes them pluggable by plugins and themes.
	 */
	public function include_template_functions() {
		include_once TWER_ABSPATH . 'includes/twer-template-functions.php';
	}

	/**
	 * Init Treweler when WordPress Initialises.
	 */
	public function init() {
		// Before init action.
		do_action( 'before_treweler_init' );

		// Set up localisation.
		$this->load_plugin_textdomain();

		// Init action.
		do_action( 'treweler_init' );
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/treweler/treweler-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/treweler-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else {
			// @todo Remove when start supporting WP 5.0 or later.
			$locale = is_admin() ? get_user_locale() : get_locale();
		}

		$locale = apply_filters( 'plugin_locale', $locale, 'treweler' );

		unload_textdomain( 'treweler' );
		load_textdomain( 'treweler', WP_LANG_DIR . '/treweler/treweler-' . $locale . '.mo' );
		load_plugin_textdomain( 'treweler', false, plugin_basename( dirname( TWER_PLUGIN_FILE ) ) . '/languages' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', TWER_PLUGIN_FILE ) );
	}

	/**
	 * Get the admin views path
	 *
	 * @return string
	 */
	public function admin_views_path() {
		return apply_filters( 'treweler_admin_views_path', $this->plugin_path() . '/includes/admin/views/' );
	}

  /**
   * Get the template path.
   *
   * @return string
   */
  public function template_path() {
    /**
     * Filter to adjust the base templates path.
     */
    return apply_filters( 'treweler_template_path', 'treweler/' ); // phpcs:ignore Treweler.Commenting.CommentHooks.MissingSinceComment
  }

  /**
   * Get Ajax URL.
   *
   * @return string
   */
  public function ajax_url() {
    return admin_url( 'admin-ajax.php', 'relative' );
  }


  /**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( TWER_PLUGIN_FILE ) );
	}
}
