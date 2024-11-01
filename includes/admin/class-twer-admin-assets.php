<?php
/**
 * Load assets
 *
 * @package Treweler/Admin
 * @version 0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( 'TWER_Admin_Assets', false ) ) :

  /**
   * TWER_Admin_Assets Class.
   */
  class TWER_Admin_Assets {

    /**
     * Hook in tabs.
     */
    public function __construct() {
      add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ] );
      add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
      add_action( 'admin_footer', [ $this, 'print_uploader_scripts' ], 1 );
      add_action( 'admin_head', [ $this, 'printAdminHeadStyles' ], 1 );

      add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts_unloader' ], 999 );
    }

    function admin_scripts_unloader() {
      $screen = get_current_screen();
      $screen_id = $screen->id ?? '';

      if ( in_array( $screen_id, twer_get_screen_ids(), true ) ) {
        wp_dequeue_style( 'select2' );
        wp_deregister_style( 'select2' );

        wp_dequeue_script( 'select2' );
        wp_deregister_script( 'select2' );

      }
    }

    function printAdminHeadStyles() {
      $screen = get_current_screen();
      $screen_id = $screen ? $screen->id : '';

      if ( $screen_id === 'plugins' && TWER_IS_FREE ) { ?>
          <style>
            [data-slug="treweler"] .row-actions {
              white-space: nowrap;
            }
          </style>
        <?php
      }
    }

    function print_uploader_scripts() {
      $screen = get_current_screen();
      $screen_id = $screen ? $screen->id : '';

      if ( $screen_id === 'map' ) {
        ?>
          <div id="twer-hidden-wp-editor" style="display: none;">
            <?php wp_editor( '', 'twer_content' ); ?>
          </div>
        <?php
      }
    }


    /**
     * Enqueue styles.
     */
    public function admin_styles() {
      global $wp_scripts;

      $screen = get_current_screen();
      $screen_id = $screen ? $screen->id : '';
      $suffix = defined( 'STYLE_DEBUG' ) && STYLE_DEBUG ? '' : '.min';


      if ( in_array( $screen_id, twerGetScreenIdsUsedMapbox(), true ) ) {
        wp_enqueue_style( 'treweler-mapbox-lib-style', 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.5/mapbox-gl.css', [], TWER_VERSION );
        wp_enqueue_style( 'treweler-mapbox-lib-geocoder-style', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css', [], TWER_VERSION );
        wp_enqueue_style( 'treweler-mapbox-lib-draw-style', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.2/mapbox-gl-draw.css', [], TWER_VERSION );
      }

      if ( TWER_IS_FREE && in_array( $screen_id, twer_get_free_screen_ids() ) ) {
        wp_enqueue_style( 'treweler-free', TWER()->plugin_url() . '/assets/css/treweler-free' . $suffix . '.css', [], TWER_VERSION );
      }

      if ( in_array( $screen_id, twerGetScreenIdsUsedMaterialIcons(), true ) ) {
        wp_enqueue_style( 'treweler-icons', 'https://fonts.googleapis.com/css2?family=Material+Icons&display=block', [], TWER_VERSION );
      }

      if ($screen_id === 'page' ) {
        wp_enqueue_style( 'treweler-style', TWER()->plugin_url() . '/assets/css/treweler-admin-new' . $suffix . '.css', [], TWER_VERSION );
      }

      if ( $screen_id === 'marker' ) {
        wp_enqueue_style( 'treweler-style', TWER()->plugin_url() . '/assets/css/treweler-admin-markers' . $suffix . '.css', [], TWER_VERSION );
      }

      if ( $screen_id === 'treweler_page_treweler-settings' ) {
        wp_enqueue_style( 'treweler-style', TWER()->plugin_url() . '/assets/css/treweler-admin-new' . $suffix . '.css', [], TWER_VERSION );
      }

      // Register admin styles.
      if ( $screen_id === 'map' || $screen_id === 'route' || $screen_id === 'marker' ) {
          wp_enqueue_style( 'treweler-style', TWER()->plugin_url() . '/assets/css/treweler-admin' . $suffix . '.css', [], TWER_VERSION );
      }
    }


    /**
     * Enqueue scripts.
     */
    public function admin_scripts() {

      $screen = get_current_screen();
      $screen_id = $screen->id ?? '';
      $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

      $custom_color = get_option( 'treweler_mapbox_colorpicker_custom_color' );
      $defaultColors = '#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|';


      $wp_localize_script = [
        'url'              => admin_url( 'admin-ajax.php' ),
        'api_key'          => twer_get_api_key(),
        'post_id'          => get_the_ID(),
        'data'             => TWER()->plugin_url() . '/assets/data/',
        'api_key_is_valid' => twer_is_valid_apikey(),
        'fonts_url'        => TWER()->plugin_url() . '/assets/fonts/',
        'strings'          => [
          'unlim' => esc_html__( 'Unlimited', 'treweler' )
        ],
        'custom_colors'    => $custom_color,
        'default_colors'   => $defaultColors
      ];

	    if ( in_array( $screen_id, twerGetScreenIdsUsedMapbox(), true ) ) {

            wp_enqueue_script( 'treweler-mapbox-lib', 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.5/mapbox-gl.js', [ 'jquery' ], TWER_VERSION, true );

		    wp_enqueue_script( 'treweler-mapbox-lib-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js', [ 'jquery' ], TWER_VERSION, true );
		    wp_enqueue_script( 'treweler-mapbox-lib-draw', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.2/mapbox-gl-draw.js', [ 'jquery' ], TWER_VERSION, true );
	    }

      // Register scripts.
      if ( in_array( $screen_id, twer_get_screen_ids() ) ) {

        wp_enqueue_media();
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'jquery-ui-sortable' );


        if ( $screen_id !== 'twer-custom-fields' && $screen_id !== 'treweler_page_treweler-settings' ) {
          //wp_enqueue_script( 'treweler-mapbox', TWER()->plugin_url() . '/assets/js/treweler-mapbox' . $suffix . '.js', [ 'jquery' ], TWER_VERSION, true );

        }

        if ( $screen_id !== 'twer-shapes' && $screen_id !== 'treweler_page_treweler-settings' ) {
          wp_enqueue_script( 'treweler-helpers', TWER()->plugin_url() . '/assets/js/treweler-helpers' . $suffix . '.js', [ 'jquery' ], TWER_VERSION, true );
        }

        if ( $screen_id === 'map' ) {
          wp_enqueue_script( 'treweler-script', TWER()->plugin_url() . '/assets/js/treweler-map' . $suffix . '.js', [ 'jquery', 'jquery-ui-sortable' ], TWER_VERSION, true );
          wp_enqueue_script( 'treweler-shortcode', TWER()->plugin_url() . '/assets/js/treweler-manage-shortcode' . $suffix . '.js', [ 'treweler-script' ], TWER_VERSION, true );
        } elseif ( $screen_id === 'marker' ) {

          $cpt_templates = get_posts( [
            'post_status'    => 'publish',
            'post_type'      => 'twer-templates',
            'numberposts'    => - 1,
            'posts_per_page' => - 1,
            'order'          => 'ASC',
          ] );

          if ( ! empty( $cpt_templates ) ) {
            $templates = [];
            foreach ( $cpt_templates as $template ) {
              $id = isset( $template->ID ) ? $template->ID : 0;
              $meta = twer_get_data( $id );
              $meta->uniqueTemplateCustomFieldsIds = twerGetUniqueCustomFieldsIds( $id );
              $templates[ $id ] = $meta;
            }

            $wp_localize_script['templates'] = $templates;
          }

          wp_enqueue_script( 'treweler-script', TWER()->plugin_url() . '/assets/js/treweler-marker' . $suffix . '.js', [ 'jquery', 'jquery-ui-sortable' ], TWER_VERSION, true );
        } elseif ( $screen_id === 'route' ) {
          //wp_enqueue_script( 'treweler-mapbox-draw', TWER()->plugin_url() . '/assets/js/treweler-mapbox-draw' . $suffix . '.js', [ 'jquery' ], TWER_VERSION, true );
          wp_enqueue_script( 'treweler-script', TWER()->plugin_url() . '/assets/js/treweler-manage-routes' . $suffix . '.js', [ 'jquery', 'jquery-ui-slider', 'jquery-ui-sortable', 'wp-i18n' ], TWER_VERSION, true );
        } elseif ( $screen_id === 'treweler_page_treweler-settings' ) {
          wp_enqueue_script( 'treweler-script', TWER()->plugin_url() . '/assets/js/treweler-settings' . $suffix . '.js', [ 'jquery', 'wp-i18n' ], TWER_VERSION, true );
        }



        wp_localize_script( 'treweler-script', 'twer_ajax', $wp_localize_script );

        wp_set_script_translations( 'treweler-script', 'treweler', TWER()->plugin_path() . '/languages' );
      }


      // Register Admin script for Category Page under custom post type map
      if ( $screen->id === 'edit-map-category' && $screen->post_type === 'map' ) {
        wp_enqueue_script( 'treweler-helpers', TWER()->plugin_url() . '/assets/js/treweler-helpers' . $suffix . '.js', [ 'jquery' ], TWER_VERSION, true );
        wp_localize_script( 'treweler-helpers', 'twer_taxonomy', [
          'default_id' => (int) get_option( 'default_map_category' ),
        ] );
      }


      if ( $screen_id === 'page' ) {
        wp_enqueue_script( 'treweler-script', TWER()->plugin_url() . '/assets/js/treweler-manage-page-map' . $suffix . '.js', [ 'jquery', 'wp-i18n' ], TWER_VERSION, true );
      }


      wp_set_script_translations( 'treweler-script', 'treweler' );
    }


  }

endif;

return new TWER_Admin_Assets();
