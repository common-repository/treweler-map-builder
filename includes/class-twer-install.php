<?php
/**
 * Installation related functions and actions.
 *
 * @package Treweler\Classes
 * @version 1.03
 */

defined( 'ABSPATH' ) || exit;

/**
 * TWER_Install Class.
 */
class TWER_Install {

  private static $admin_notices = [];

  /**
   * Hook in tabs.
   */
  public static function init() {
    add_action( 'init', [ __CLASS__, 'check_version' ], 5 );
    //add_action( 'init', [ __CLASS__, 'check_smarty_folders_permissions' ], 5 );
    //add_action( 'admin_notices', [ __CLASS__, 'admin_notices' ] );

    add_filter( 'plugin_action_links_' . TWER_PLUGIN_BASENAME, [ __CLASS__, 'plugin_action_links' ] );
  }

  /**
   * Check Smarty Default Folders Permissions For Good  Work
   *
   * @return void
   */
  public static function check_smarty_folders_permissions() {
    $views_foldes = TWER()->admin_views_path();

    $right_permissions = apply_filters( 'treweler_smarty_right_permissions', [ '0700', '0770', '0777', '0740', '0755' ] );

    $check_folders = apply_filters( 'treweler_check_permissions_folders', [
      $views_foldes . 'templates_c',
      $views_foldes . 'templates',
      $views_foldes . 'cache',
    ] );

    if ( $check_folders ) {
      foreach ( $check_folders as $folder ) {
        if ( is_dir( $folder ) ) {
          $current_permissions = substr( sprintf( '%o', fileperms( $folder ) ), - 4 );
          if ( ! in_array( $current_permissions, $right_permissions ) ) {
            self::$admin_notices[] = sprintf( __( 'Error connecting to %s directory. Please change the permissions from %s to 0777', 'treweler' ), '<strong>' . $folder . '</strong>', $current_permissions );
          }

          if ( ! wp_is_writable( $folder ) ) {
            self::$admin_notices[] = sprintf( __( 'The directory  %s must be writable', 'treweler' ), '<strong>' . $folder . '</strong>' );
          }
        }
      }
    }
  }




  /**
   * Output Admin Notices
   */
  public static function admin_notices() {
    if ( self::$admin_notices ) {
      $class = 'notice notice-warning is-dismissible';
      $message = '';

      foreach ( self::$admin_notices as $notice ) {
        $message .= '<p>' . $notice . '</p>';
      }

      if ( $message ) {
        printf( '<div class="%1$s" id="treweler_folders_debug"><p>%2$s</p>%3$s</div>', esc_attr( $class ), __( 'Treweler says:', 'treweler' ), $message );
      }
    }
  }

  /**
   * Check Treweler version and run the updater is required.
   * This check is done on all requests and runs if the versions do not match.
   */
  public static function check_version() {
    if ( version_compare( get_option( 'treweler_version' ), TWER_VERSION, '<' ) ) {
      self::install();
      do_action( 'treweler_updated' );
    }
  }

  /**
   * Install TWER.
   */
  public static function install() {
    if ( ! is_blog_installed() ) {
      return;
    }

    // Check if we are not already running this routine.
    if ( 'yes' === get_transient( 'tw_installing' ) ) {
      return;
    }

    // If we made it till here nothing is running yet, lets set the transient now.
    set_transient( 'tw_installing', 'yes', MINUTE_IN_SECONDS * 10 );
    twer_maybe_define_constant( 'TWER_INSTALLING', true );

    self::create_roles();
    self::setup_environment();
    self::update_twer_version();

    delete_transient( 'tw_installing' );

    do_action( 'treweler_flush_rewrite_rules' );
    do_action( 'treweler_installed' );
  }




  /**
   * Update Treweler version to current.
   */
  private static function update_twer_version() {
    update_option( 'treweler_version', TWER_VERSION );
  }

  /**
   * Setup Treweler environment - post types, taxonomies etc.
   *
   * @since 1.03
   */
  private static function setup_environment() {
    TWER_Post_types::register_post_types();
    if(!TWER_IS_FREE) {
      TWER_Post_types::register_taxonomies();
    }
  }

  /**
   * Create roles and capabilities.
   */
  public static function create_roles() {
    global $wp_roles;

    if ( ! class_exists( 'WP_Roles' ) ) {
      return;
    }

    if ( ! isset( $wp_roles ) ) {
      $wp_roles = new WP_Roles(); // @codingStandardsIgnoreLine
    }

    $capabilities = self::get_core_capabilities();

    foreach ( $capabilities as $cap_group ) {
      foreach ( $cap_group as $cap ) {
        $wp_roles->add_cap( 'editor', $cap );
        $wp_roles->add_cap( 'administrator', $cap );
      }
    }
  }


  /**
   * Get capabilities for Treweler - these are assigned to admin/editor manager during installation or reset.
   *
   * @return array
   */
  public static function get_core_capabilities() {
    $capabilities = array();

    $capabilities['core'] = array(
      'manage_treweler',
    );

    $capability_types = array( 'treweler');

    foreach ( $capability_types as $capability_type ) {

      $capabilities[ $capability_type ] = array(
        // Post type.
        "edit_{$capability_type}",
        "read_{$capability_type}",
        "delete_{$capability_type}",
        "edit_{$capability_type}s",
        "edit_others_{$capability_type}s",
        "publish_{$capability_type}s",
        "read_private_{$capability_type}s",
        "delete_{$capability_type}s",
        "delete_private_{$capability_type}s",
        "delete_published_{$capability_type}s",
        "delete_others_{$capability_type}s",
        "edit_private_{$capability_type}s",
        "edit_published_{$capability_type}s",

        // Terms.
        "manage_{$capability_type}_terms",
        "edit_{$capability_type}_terms",
        "delete_{$capability_type}_terms",
        "assign_{$capability_type}_terms",
      );
    }

    return $capabilities;
  }

  /**
   * Remove Treweler roles.
   */
  public static function remove_roles() {
    global $wp_roles;

    if ( ! class_exists( 'WP_Roles' ) ) {
      return;
    }

    if ( ! isset( $wp_roles ) ) {
      $wp_roles = new WP_Roles(); // @codingStandardsIgnoreLine
    }

    $capabilities = self::get_core_capabilities();

    foreach ( $capabilities as $cap_group ) {
      foreach ( $cap_group as $cap ) {
        $wp_roles->remove_cap( 'editor', $cap );
        $wp_roles->remove_cap( 'administrator', $cap );
      }
    }

  }


  /**
   * Add a link to the settings on the Plugins screen.
   */
  public static function plugin_action_links( $links ) {
    $action_links = [
      'settings' => '<a href="' . admin_url( 'admin.php?page=treweler-settings' ) . '" aria-label="' . esc_attr__( 'View Settings settings', 'treweler' ) . '">' . esc_html__( 'Settings', 'treweler' ) . '</a>',
    ];

    if ( TWER_IS_FREE ) {
      $action_links['treweler-website'] = '<a href="https://treweler.com" style="color:#7ab44b;font-weight:bold;white-space:nowrap;" aria-label="' . esc_attr__( 'Go to Treweler Website', 'treweler' ) . '">' . esc_html__( 'Treweler Pro', 'treweler' ) . '</a>';
    }

    return array_merge( $links, $action_links );
  }

}

TWER_Install::init();
