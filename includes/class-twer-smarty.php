<?php
/**
 * Smarty
 * Registers taxonomy.
 *
 * @package Treweler/Classes/Taxonomy
 * @version 0.43
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types Class.
 */
class TWER_Smarty extends Smarty {
	/**
	 * Hook in methods.
	 */
  public function __construct() {
    // Class Constructor.
    // These automatically get set with each new instance.
    parent::__construct();

    // Smarty setup
    $views_folder = TWER()->admin_views_path();

    // Set plugins dirs
    //$plugins_dir   = $this->getPluginsDir();
    //$plugins_dir[] = $views_folder . 'plugins';

    // Set all required directories
    $this->setTemplateDir( $views_folder . 'templates' );
    $this->setCompileDir( $views_folder . 'templates_c' );
    $this->setCacheDir( $views_folder . 'cache' );
    $this->setConfigDir( $views_folder . 'configs' );
    $this->setPluginsDir( $views_folder . 'plugins' );



//    // Enable Smarty Cache
//    if ( apply_filters( 'treweler_smarty_cache', false ) ) {
//      $this->caching = Smarty::CACHING_LIFETIME_CURRENT;
//      if ( isset( $_GET['settings-updated'] ) && treweler_is_theme_setting_page() ) {
//        self::reset_cache();
//      }
//    }

    // Enable Smarty Debug
    if ( apply_filters( 'treweler_smarty_debug', false ) ) {
      $this->debugging = true;
    }
	}



  /**
   * Install checking
   */
  public function check() {
    $this->testInstall();
  }


  /**
   * Reset Smarty cache
   */
  public function reset_cache() {
    $this->clearAllCache();
  }
}
