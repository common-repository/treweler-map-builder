<?php
/**
 * Treweler Admin
 *
 * @class    TWER_Admin
 * @package  Treweler/Admin
 * @version  0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * TWER_Admin class.
 */
class TWER_Admin {

  /**
   * Constructor.
   */
  public function __construct() {


    add_action( 'init', [ $this, 'includes' ] );
    add_action( 'admin_init', [ $this, 'register_settings' ] );


    add_action( 'wp_ajax_treweler_get_admin_token', [ $this, 'get_admin_token' ] );
    add_action( 'wp_ajax_treweler_add_colorpicker_custom_color', [ $this, 'add_colorpicker_custom_color' ] );



    add_action( 'admin_menu', [ $this, 'admin_menu' ], 9 );
    add_action( 'admin_menu', [ $this, 'settings_menu' ], 50 );
    add_action( 'admin_menu', [ $this, 'menu_order_count' ], 60 );
    add_filter( 'custom_menu_order', [ $this, 'custom_menu_order' ] );


    if(TWER_IS_FREE) {
      add_action( 'admin_menu', [ $this, 'free_menu' ], 55 );
      add_action( 'admin_menu', [ $this, 'addTrewelerWebsiteMenuItem' ], 65 );
    }

    // Add body class for detect special treweler pages.
    add_filter( 'admin_body_class', array( $this, 'include_admin_body_class' ), 9999 );
  }

  public function include_admin_body_class( $classes ) {
    $screen = get_current_screen();
    $screen_id = $screen ? $screen->id : '';

    $pluginClasses = [ 'treweler-active' ];
    $pluginClasses[] = TWER_IS_FREE ? 'treweler-free' : 'treweler-pro';

    if ( TWER_IS_FREE && in_array( $screen_id, twer_get_free_screen_ids() ) ) {
      $pluginClasses[] = 'treweler-is-free-page';
    }

    $classes .= ' ' . implode( ' ', $pluginClasses );

    return $classes;
  }

  /**
   * Include any classes we need within admin.
   */
  public function includes() {
    include_once dirname( __FILE__ ) . '/twer-admin-functions.php';
    include_once dirname( __FILE__ ) . '/class-twer-admin-post-types.php';
    include_once dirname( __FILE__ ) . '/class-twer-admin-assets.php';
  }



  /**
   * Add menu items.
   */
  public function admin_menu() {
    global $menu;

    $treweler_icon = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4NCjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBkPSJNOSAwQzEzLjk3MDYgMCAxOCA0LjAyOTQ0IDE4IDlDMTggMTMuOTcwNiAxMy45NzA2IDE4IDkgMThDNC4wMjk0NCAxOCAwIDEzLjk3MDYgMCA5QzAgNC4wMjk0NCA0LjAyOTQ0IDAgOSAwWk05LjUzNTcxIDQuNDI4MDdDOS40NzM1IDQuMjY3OTIgOS4yOTMxMyA0LjE4MTUyIDkuMTI0MDYgNC4yMzQxOEM5LjAyMTQ3IDQuMjY2MTQgOC45NDEwOCA0LjM0NDY3IDguOTA4MzcgNC40NDQ4OUw3Ljk0NTA0IDcuMzk2NjNDNy44OTIyNCA3LjQzMjExIDcuODI4OSA3LjQ1MjM3IDcuNzYxOTMgNy40NTIzN0g0LjgyNjg1TDQuODA5NDkgNy40NTI4MkM0LjYzNzA1IDcuNDYxNzggNC41IDcuNjAzNTMgNC41IDcuNzc3MDdDNC41IDcuODgwMzkgNC41NDk1IDcuOTc3NTUgNC42MzMzMSA4LjAzODczTDcuMDE5OTkgOS43ODA5M0w3LjAzNjk2IDkuNzk0MkM3LjA3NTMzIDkuODI2MjYgNy4xMDQ5NyA5Ljg2NTk3IDcuMTI0NzMgOS45MDk4Mkw3LjEyMTY1IDkuOTE5MDVMNi4wOTA4IDEzLjA3NjZMNi4wODU4OCAxMy4wOTMyQzYuMDQxMzQgMTMuMjU5MSA2LjEzNzIzIDEzLjQzMTkgNi4zMDY0OCAxMy40ODQ2QzYuNDExMzQgMTMuNTE3MyA2LjUyNTk0IDEzLjQ5NzEgNi42MTI1NiAxMy40MzA4TDkuMDE5OTYgMTEuNTg3TDkuMDM1OTQgMTEuNTc1NUM5LjE1NTAyIDExLjQ5NSA5LjMxNDk0IDExLjQ5ODggOS40MzAxMiAxMS41ODdMMTEuODM3NSAxMy40MzA4TDExLjg1MjcgMTMuNDQxOEMxMS45OTYzIDEzLjUzOTYgMTIuMTk0OCAxMy41MTE5IDEyLjMwNDIgMTMuMzc1NkMxMi4zNzIxIDEzLjI5MSAxMi4zOTI3IDEzLjE3OTEgMTIuMzU5MyAxMy4wNzY2TDkuNTQxNzIgNC40NDQ4OUw5LjUzNTcxIDQuNDI4MDdaIiBmaWxsPSJ3aGl0ZSIvPg0KPC9zdmc+DQo=';

    if ( current_user_can( 'edit_treweler' ) ) {
      $menu[] = array( '', 'read', 'separator-treweler', '', 'wp-menu-separator treweler' ); // WPCS: override ok.
    }

    add_menu_page( __( 'Treweler', 'treweler' ), __( 'Treweler', 'treweler' ), 'edit_treweler', 'treweler', null, $treweler_icon, '55.5' );

    do_action('twerAdminMenu');
  }


  /**
   * Adds the order processing count to the menu.
   */
  public function menu_order_count() {
    global $submenu;

    if ( isset( $submenu['treweler'] ) ) {
      $menu_order = apply_filters('twerMainMenuOrder', [ 0, 1, 2, 3, 5, 6, 7, 8, 9, 4], $submenu['treweler'] );
      uksort( $submenu['treweler'], function( $key1, $key2 ) use ( $menu_order ) {
        return ( ( array_search( $key1, $menu_order, true ) > array_search( $key2, $menu_order, true ) ) ? 1 : - 1 );
      } );
      // Remove 'Treweler' sub menu item.
      unset( $submenu['treweler']['0'] );
    }
  }


  /**
   * Custom menu order.
   *
   * @param bool $enabled Whether custom menu ordering is already enabled.
   *
   * @return bool
   */
  public function custom_menu_order( $enabled ) {
    return $enabled || current_user_can( 'edit_treweler' );
  }


  /**
   * Save custom colors added by user - Colorpicker
   */
  public function add_colorpicker_custom_color() {
    $color = trim( $_POST['cust_color'] );
    update_option( 'treweler_mapbox_colorpicker_custom_color', $color );
    echo get_option( 'treweler_mapbox_colorpicker_custom_color' );
    exit;
  }

  public function addTrewelerWebsiteMenuItem() {
    global $submenu;
    $permalinkLabel = sprintf( '<span style="color:#7ab44b;">%s</span>', esc_html__( 'Treweler Pro', 'treweler' ) );
    $submenu['treweler'][] = [ $permalinkLabel, 'edit_treweler', 'https://treweler.com' ];
  }

  /**
   * Add menu item.
   */
  public function settings_menu() {

    $settings_page = add_submenu_page( 'treweler', esc_html__( 'Treweler Settings', 'treweler' ),
      esc_html__( 'Settings', 'treweler' ), 'edit_treweler', 'treweler-settings', [ $this, 'settings_page' ] );

    add_action( 'load-' . $settings_page, [ $this, 'settings_page_init' ] );
  }

  public function free_menu() {
    $menuItems = [
      [
        'slug'  => 'shapes',
        'label' => esc_html__( 'Shapes', 'treweler' ),
      ],
      [
        'slug'  => 'categories',
        'label' => esc_html__( 'Categories', 'treweler' ),
      ],
      [
        'slug'  => 'custom-fields',
        'label' => esc_html__( 'Custom Fields', 'treweler' ),
      ],
      [
        'slug'  => 'templates',
        'label' => esc_html__( 'Templates', 'treweler' ),
      ],
      [
        'slug'  => 'import',
        'label' => esc_html__( 'Import', 'treweler' ),
      ]
    ];

    foreach ( $menuItems as $menuItem ) {
      add_submenu_page( 'treweler', $menuItem['label'], $menuItem['label'], 'edit_treweler', 'treweler-' . $menuItem['slug'],  'twerGoToProNotice' );
    }

  }

  /**
   * Init the settings page.
   */
  public function settings_page() {
    $smarty = new TWER_Smarty();
	  $options = get_option( 'treweler' );
    $css = isset( $options['css'] ) ? $options['css'] : '';

    $smarty->assign( 'css', $css );
    $smarty->display( 'settings.tpl' );
  }


  /**
   * Other methods into memory for use within settings.
   */
  public function settings_page_init() {
    do_action( 'treweler_settings_page_init' );
  }


  public function register_settings() {

    register_setting(
      'treweler-options', // Option group
      'treweler', // Option name
	    array('sanitize_callback' => array($this, 'sanitize' ))
    );

    add_settings_section(
      'treweler-section', // ID
      '', // Title
      null, // Callback
      'treweler-settings' // Page
    );

    add_settings_field(
      'api_key',
      esc_html__( 'Mapbox Access Token', 'treweler' ),
      [ $this, 'api_key_cb' ],
      'treweler-settings',
      'treweler-section',
      [
        'label_for' => 'api_key'
      ]
    );

    if(TWER_IS_FREE) {
      add_settings_field(
        'google_sheets_api_json',
        esc_html__( 'Google Sheets Credentials ', 'treweler' ),
        [ $this, 'google_sheets_api_json_cb' ],
        'treweler-settings',
        'treweler-section',
      );
    }

  }


  public function google_sheets_api_json_cb() { ?>
      <div class="form-row align-items-stretch">
          <div class="form-group col">
              <div class="twer-attach">
                  <div class="twer-attach__thumb js-twer-attach-thumb">
                      <button type="button" class="btn btn-outline-light twer-attach__add-media" style="display:block;"><?php _e('Select JSON File','treweler'); ?></button>
                  </div>
              </div>
          </div>
      </div>
    <?php


    echo '<p style="font-size: 14px; margin-bottom: 0; margin-top: 5px;" class="description">';
    echo sprintf( '%s %s%s%s %s %s%s%s %s',
      esc_html__( 'Upload a valid', 'treweler' ),
      '<a  style="text-decoration: underline;" href="https://www.youtube.com/watch?v=k_Y4aiz1nt8" target="_blank">',
      esc_html__( 'Google Sheets API JSON File', 'treweler' ),
      '</a>',
      esc_html__( 'to enable the', 'treweler' ),
      '<a style="text-decoration: underline;" href="' . admin_url( 'edit.php?post_type=treweler-import' ) . '" target="_blank">',
      esc_html__( 'Import', 'treweler' ),
      '</a>',
      esc_html__( 'functionality.', 'treweler' ),
    );
    echo '</p>';
  }


  /**
   * Get the settings option array and print one of its values
   */
  public function api_key_cb() {
	  $options = get_option( 'treweler' );

      ?>
    <div class="form-row align-items-stretch">
      <div class="form-group col">
        <?php
        printf(
            '<input type="text" id="api_key" name="treweler[api_key]" value="%s" class="form-control form-control-sm">',
            isset($options['api_key'] ) ? esc_attr( $options['api_key'] ) : ''
        );

        echo '<p style="font-size: 14px; margin-bottom: 0; margin-top: 5px;" class="description">';
        echo sprintf( '%s %s%s%s %s',
	        esc_html__( 'Enter a valid', 'treweler' ),
	        '<a style="text-decoration: underline;" href="https://account.mapbox.com/access-tokens/" target="_blank">',
	        esc_html__( 'Mapbox Access Token', 'treweler' ),
	        '</a>',
	        esc_html__('to enable all plugin features.', 'treweler')
        );
        echo '</p>';
        ?>
      </div>
    </div>
<?php
  }

  public function sanitize( $input ) {
    $new_input = [];
    $error = '';

    if ( isset( $input['api_key'] ) ) {
      $is_valid = true;

	    $input['api_key'] = trim( $input['api_key'] );

      if ( ! empty( $input['api_key'] ) ) {
        $response = wp_remote_get( 'https://api.mapbox.com/tokens/v2?access_token=' . $input['api_key'] );
        if ( is_wp_error( $response ) ) {
          echo $response->get_error_message();
          add_settings_error( 'treweler-options', 'treweler_error', sprintf( esc_html__( 'Something went wrong: %s', 'treweler' ), $response->get_error_message() ) );
        } elseif ( wp_remote_retrieve_response_code( $response ) === 200 ) {
          $body = json_decode( wp_remote_retrieve_body( $response ), true );
          $code = isset( $body['code'] ) ? $body['code'] : '';
          if ( $code !== 'TokenValid' ) {
            $is_valid = false;
            add_settings_error( 'treweler-options', 'treweler_invalid_api', esc_html__( 'Enter a valid Mapbox Access Token.', 'treweler' ) );
          }
        }
      } else {
        add_settings_error( 'treweler-options', 'treweler_invalid_api', esc_html__( 'API key cannot be empty.', 'treweler' ) );
      }

//
    }

    if ( isset( $input['css'] ) ) {
	    $input['css'] = $input['css'];
    }

    do_action('twerSettingsValidation', $input);

    return $input;
  }


  public function get_admin_token() {
    $api_key = twer_get_api_key();
    echo base64_encode( "###" . $api_key . "###" );
    exit;
  }

}

return new TWER_Admin();
