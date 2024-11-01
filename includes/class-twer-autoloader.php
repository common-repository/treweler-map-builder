<?php
/**
 * Treweler Autoloader.
 *
 * @package Treweler/Classes
 * @version 1.14
 */

defined( 'ABSPATH' ) || exit;

/**
 * Autoloader class.
 */
class TWER_Autoloader {

	/**
	 * Path to the includes directory.
	 *
	 * @var string
	 */
	private $include_path;

  private $include_path_pro;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		if ( function_exists( '__autoload' ) ) {
			spl_autoload_register( '__autoload' );
		}

		spl_autoload_register( [ $this, 'autoload' ] );

		$this->include_path = untrailingslashit( plugin_dir_path( TWER_PLUGIN_FILE ) ) . '/includes/';
    $this->include_path_pro = untrailingslashit( plugin_dir_path( TWER_PLUGIN_FILE ) ) . '/pro/includes/';
	}

	/**
	 * Auto-load TWER classes on demand to reduce memory consumption.
	 *
	 * @param  string  $class  Class name.
	 */
	public function autoload( $class ) {
		$class = strtolower( $class );

		if (strpos($class, 'twer_') === false ) {
			return;
		}

		$file = $this->get_file_name_from_class( $class );
		$path = '';


		if (strpos($class, 'twer_shortcode_') !== false ) {
			$path = $this->getPathByClassName($class, 'shortcodes/');
		} elseif ( strpos($class, 'twer_meta_box') !== false ) {
			$path = $this->getPathByClassName($class, 'admin/meta-boxes/');
		} elseif (strpos($class, 'twer_admin') !== false ) {
			$path = $this->getPathByClassName($class, 'admin/');
		}

		if ( empty( $path ) || ! $this->load_file( $path . $file ) ) {
      $loadedPath = $this->getClassPath($class);
			$this->load_file( $loadedPath . $file );
		}
	}

  public function isProClass( string $className ): string {
    return strpos( $className, 'trewelerpro' ) !== false;
  }

  public function getClassPath( string $className ): string {
    return $this->isProClass( $className ) ? $this->include_path_pro : $this->include_path;
  }

  public function getPathByClassName( string $className, string $destination ) : string {
    return $this->getClassPath( $className ) . $destination;
  }

	/**
	 * Take a class name and turn it into a file name.
	 *
	 * @param  string  $class  Class name.
	 *
	 * @return string
	 */
	private function get_file_name_from_class( $class ) {
    $array = explode( '\\', $class );
    $className = end( $array );

		return 'class-' . str_replace( '_', '-', $className ) . '.php';
	}

	/**
	 * Include a class file.
	 *
	 * @param  string  $path  File path.
	 *
	 * @return bool Successful or not.
	 */
	private function load_file( $path ) {
		if ( $path && is_readable( $path ) ) {
			include_once $path;

			return true;
		}

		return false;
	}
}

new TWER_Autoloader();
