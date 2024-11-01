<?php
/**
 * The Template for displaying map page
 * This template can be overridden by copying it to yourtheme/treweler/page-map.php.
 * HOWEVER, on occasion Treweler will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.treweler.com/document/template-structure/
 * @package     Treweler\Templates
 * @version     1.13
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

//get_header( 'treweler' ); ?>

<!doctype html>
<?php

$htmlClass = [ 'no-js' ];

if ( is_admin_bar_showing() ) {
  $htmlClass[] = twer_is_map_iframe() ? 'twer-html-page-iframe-map' : 'twer-html-page-fullscreen-map';
}

?>
<html class="<?php echo  esc_attr(implode(' ', $htmlClass )); ?>" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php endif; ?>

  <?php twer_wp_head(); ?>
    <style>
      .twer-map-wrap {
        display: flex;
        height: 100vh;
      }

      .twer-map-container {
        position: relative;
        flex-basis: 0;
        flex-grow: 1;
        max-width: 100%;
      }
    </style>

</head>

<?php


$post_id = get_the_ID();
$map_id = get_post_meta( $post_id, '_treweler_cpt_dd_box_fullscreen', true );

if ( twer_is_map_iframe() ) {
  $map_id = twer_get_iframe_map_id();
}

$meta = get_post_meta( $map_id );
$meta_data = twer_get_data( $map_id );

$tourShowMarkerNames = twer_get_meta( 'tour_show_marker_names', $map_id );
if ( is_array( $tourShowMarkerNames ) ) {
  $tourShowMarkerNames = reset( $tourShowMarkerNames );
}
$tour_show_name = empty( $tourShowMarkerNames ) ? false : true;

$nonce = isset( $meta['_treweler_noncefield'][0] ) ? true : false;

if ( ! $nonce ) {
  $latlng = unserialize( $meta['_treweler_map_latlng'][0] );
} else {
  $_treweler_map_initial_point = unserialize( $meta['_treweler_map_initial_point'][0] );
  $latlng = [
    $_treweler_map_initial_point['lat'],
    $_treweler_map_initial_point['lon'],
  ];

}

if ( is_array( $latlng ) && ! empty( $latlng ) ) {
  foreach ( $latlng as $k => $v ) {
    ${"ll$k"} = $v;
  }
} else {
  $ll0 = 40.730610;
  $ll1 = - 73.935242;
}

$logo = isset( $meta_data->map_main_logo ) ? $meta_data->map_main_logo : '';
if ( is_numeric( $logo ) ) {
  $logo = wp_get_attachment_image_src( $logo, 'full' );
  $logo = isset( $logo[0] ) ? $logo[0] : $logo;
}

$category_loaded = false;
$title_loaded = false;
$tour_loaded = false;

$mapClass = $meta['_treweler_map_css_class'][0] ?? '';

?>
<body <?php body_class($mapClass); ?> id="js-twer-root">
<?php do_action( 'twerBodyOpen' ); ?>

<?php
/**
 * twer_before_main_content hook.
 *
 * @hooked twer_output_content_wrapper - 10 (outputs opening divs for the content)
 */
do_action( 'twer_before_main_content' );
?>



<?php

/**
 * twer_before_map hook.
 *
 * @hooked twer_output_store_locator - 10 (outputs extended store locator)
 */
do_action( 'twer_left_sidebar_map' );

?>

<div class="twer-map-wrap__cell twer-map-container">

    <div id="twer-map" data-map-id="<?php echo esc_attr($map_id) ?>"></div>


  <?php
  // Output gradient element
  if ( ! empty( $meta_data->widgets_gradient ) && ! empty( $meta_data->widgets_gradient_position ) && ! empty( $meta_data->widgets_gradient_color ) ) {
    $gradient_pos = $meta_data->widgets_gradient_position;
    $gradient_hex = $meta_data->widgets_gradient_color;
    $gradient_rgba_1 = twer_hex_to_rgb( $gradient_hex, true, 0.5 );
    $gradient_rgba_2 = twer_hex_to_rgb( $gradient_hex, true, 0 );
    $gradient_opacity = isset( $meta_data->widgets_gradient_opacity ) ? $meta_data->widgets_gradient_opacity : '1';
    $gradient_style = 'background:linear-gradient(%sdeg, %s 0%%, %s 48.16%%, %s 100%%); opacity:' . $gradient_opacity . ';';
    switch ( $gradient_pos ) {
      case 'left' :
      case 'right' :
        $gradient_deg = 'left' === $gradient_pos ? '90' : '-90';
        $gradient_style = sprintf( $gradient_style, $gradient_deg, $gradient_hex, $gradient_rgba_1,
          $gradient_rgba_2 );
        echo sprintf( '<div class="twer-gradient twer-gradient--%s" style="%s"></div>', $gradient_pos,
          $gradient_style );
        break;
      case 'left-right' :
        $gradient_pos_inner = explode( '-', $gradient_pos );
        foreach ( $gradient_pos_inner as $gradient_position ) {
          $gradient_deg = 'left' === $gradient_position ? '90' : '-90';
          $gradient_style_inner = sprintf( $gradient_style, $gradient_deg, $gradient_hex, $gradient_rgba_1,
            $gradient_rgba_2 );
          echo sprintf( '<div class="twer-gradient twer-gradient--%s" style="%s"></div>', $gradient_position,
            $gradient_style_inner );
        }
        break;
    }
  } ?>

  <?php
  // Output widgets
  if ( ! empty( $meta_data->widgets_show ) ) {

  foreach ( $meta_data->widgets as $widget_position => $widget ) {
  if ( $widget ) { ?>
    <div class="twer-widget twer-widget-location twer-<?php echo esc_attr( str_ireplace( '_', '-',
      $widget_position ) ); ?>">

        <ul>
          <?php

          $c_top_title = ! empty( $meta_data->show_map_desc ) && str_ireplace( '_', '-', $widget_position ) === str_ireplace( '_', '-',
              $meta['_treweler_map_details_position'][0] ) && strpos( $widget_position,
              'top' ) !== false && ( ! empty( $meta_data->widgets_show ) && $meta['_treweler_map_details_name'][0] != "" || $meta['_treweler_map_details_description'][0] != "" || $logo != "" );
          $c_top_category = str_ireplace( '_', '-', $widget_position ) === str_ireplace( '_', '-',
              $meta_data->category_position ) && strpos( $widget_position,
              'top' ) !== false && ! empty( $meta_data->category_filter );
          $c_top_tour = str_ireplace( '_', '-', $widget_position ) === str_ireplace( '_', '-',
              $meta_data->tour_arrows_position ) && strpos( $widget_position,
              'top' ) !== false && ! empty( $meta_data->enable_tour );
          if ( $c_top_title ): ?>
            <li class="<?php echo $c_top_category ? 'before-filter-cat' : '' ?>">
                <div class="under-widget treweler-map-details logo">
                    <div class="logo-tw">
                      <?php

                      if ( $logo ) {
                      $logo_size = isset( $meta['_treweler_map_details_logo_size'][0] ) ? $meta['_treweler_map_details_logo_size'][0] : '40';

                      if ( ! is_numeric( $logo_size ) && empty( $logo_size ) ) {
                        $logo_size = '40';
                      }
                      $style_logo = '';
                      if ( $logo_size ) {
                        $style_logo = 'style="height:' . esc_attr( $logo_size ) . 'px;"';
                      }

                      $logo_url = isset( $meta['_treweler_map_logo_url'][0] ) ? $meta['_treweler_map_logo_url'][0] : '';
                      $logo_target = isset( $meta['_treweler_map_logo_target'][0] ) ? $meta['_treweler_map_logo_target'][0] : '';
                      if ( ! empty( $logo_target ) ) {
                        $logo_target = 'target="_blank"';
                      }
                      $tag_logo = 'div';
                      if ( ! empty( $logo_url ) ) {
                        $tag_logo = 'a';
                        $logo_url = 'href="' . esc_url( $logo_url ) . '"';
                      }

                      ?>
                        <<?php echo esc_html( $tag_logo ); ?> <?php echo $style_logo; ?> <?php echo $logo_url; ?> <?php echo $logo_target; ?> class="logo-icon" >
                        <img <?php echo $style_logo; ?> src="<?php echo esc_url( $logo ); ?>"
                                                        alt="<?php echo esc_attr__( 'Treweler', 'treweler' ); ?>">
                    </<?php echo esc_html( $tag_logo ); ?>>
                  <?php } ?>

                  <?php if ( $meta['_treweler_map_details_name'][0] != "" || $meta['_treweler_map_details_description'][0] != "" ) { ?>
                      <div class="logo-text">
                        <?php if ( $meta['_treweler_map_details_name'][0] != "" ) {
                          $style = ' style="';
                          $style .= ! empty( $meta['_treweler_map_details_name_color'][0] ) ? 'color:' . esc_attr( $meta['_treweler_map_details_name_color'][0] ) . ';' : '';
                          $style .= ! empty( $meta['_treweler_map_name_font_size'][0] ) ? 'font-size:' . esc_attr( $meta['_treweler_map_name_font_size'][0] ) . 'px;' : '';
                          $style .= ! empty( $meta['_treweler_map_name_font_weight'][0] ) ? 'font-weight:' . esc_attr( $meta['_treweler_map_name_font_weight'][0] ) . ';' : '';
                          $style .= '" ';
                          ?>

                            <div class="twer-logo-text-head" <?php echo $style; ?>><?php echo esc_html( trim( $meta['_treweler_map_details_name'][0] ) ); ?></div>
                        <?php } ?>
                        <?php if ( $meta['_treweler_map_details_description'][0] != "" ) {

                          $style_desc = ' style="';
                          $style_desc .= ! empty( $meta['_treweler_map_details_description_color'][0] ) ? 'color:' . esc_attr( $meta['_treweler_map_details_description_color'][0] ) . ';' : '';
                          $style_desc .= ! empty( $meta['_treweler_map_desc_font_size'][0] ) ? 'font-size:' . esc_attr( $meta['_treweler_map_desc_font_size'][0] ) . 'px;' : '';
                          $style_desc .= ! empty( $meta['_treweler_map_desc_font_weight'][0] ) ? 'font-weight:' . esc_attr( $meta['_treweler_map_desc_font_weight'][0] ) . ';' : '';
                          $style_desc .= '" ';
                          ?>

                            <span <?php echo $style_desc; ?>><?php echo esc_html( trim( $meta['_treweler_map_details_description'][0] ) ); ?></span>
                        <?php } ?>
                      </div>
                  <?php } ?>


                </div>
    </div>


    </li>
  <?php
  $title_loaded = true;
  endif; ?>

  <?php if ( $c_top_category ): ?>
    <li>
        <div class="map-category">
            <div class="twer-mobile-cat">
                <button class="twer-mobile-menu" type="button">
                    <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="11" height="1" fill="#1F2B49"/>
                        <rect y="4" width="11" height="1" fill="#1F2B49"/>
                        <rect y="8" width="11" height="1" fill="#1F2B49"/>
                    </svg>
                </button>
            </div>
          <?php

          twerMapCategorySelect( $map_id );
          $category_loaded = true; ?>
        </div>
    </li>
  <?php endif; ?>

  <?php if ( $c_top_tour ): ?>
    <li>
        <div class="tour-wrapper">
          <?php TWER_Screen_Map::tourWidgetElement( $meta_data->tour_arrows_position,
            $meta_data->tour_start_message, $tour_show_name );
          $tour_loaded = true; ?>
        </div>
    </li>
  <?php endif; ?>

  <?php

  $widgets_font_weight = isset( $meta_data->widgets_font_weight ) ? $meta_data->widgets_font_weight : '400';
  $widgetHasBackground = isset( $meta_data->widgets_bg ) ? $meta_data->widgets_bg : true;


  if ( $widgets_font_weight ) {
    $widgets_font_weight = 'font-weight:' . esc_attr( $widgets_font_weight ) . ';';
  }
  ?>
  <?php //if(!empty($widget[0]['value']) || !empty($widget[0]['description'])) {  ?>
    <li class="clearfix">
        <div class="twer-widgets-list <?php echo $widgetHasBackground ? 'twer-widget-has-bg' : 'twer-widget-no-bg'; ?>">
          <?php foreach ( $widget as $widget_data ) { ?>
              <div class="twer-widgets-list__item" style="border-color: <?php echo $meta_data->widgets_color; ?>; ">
                <?php if ( $widget_data['value'] ) { ?>
                    <h3 class="twer-outdoor-color" style="<?php echo $widgets_font_weight; ?><?php echo ! empty( $meta_data->widgets_color ) ? 'color:' . $meta_data->widgets_color . ';' : ''; ?>"><?php echo esc_html( $widget_data['value'] ); ?></h3>
                <?php } ?>
                <?php if ( $widget_data['description'] ) { ?>
                    <h4 class="twer-outdoor-color" <?php echo ! empty( $meta_data->widgets_color ) ? 'style="' . $widgets_font_weight . ' color:' . $meta_data->widgets_color . ';"' : ''; ?>><?php echo esc_html( $widget_data['description'] ); ?></h4>
                <?php } ?>
              </div>
          <?php } ?>
        </div>

    </li>
  <?php //} ?>


  <?php
  $c_bottom_category = $category_loaded === false && str_ireplace( '_', '-',
      $widget_position ) === str_ireplace( '_', '-',
      $meta_data->category_position ) && strpos( $widget_position,
      'top' ) === false && ! empty( $meta_data->category_filter );
  $c_bottom_tour = $tour_loaded === false && str_ireplace( '_', '-',
      $widget_position ) === str_ireplace( '_', '-',
      $meta_data->tour_arrows_position ) && strpos( $widget_position,
      'top' ) === false && ! empty( $meta_data->enable_tour );

  if ( ! empty( $meta_data->show_map_desc ) && str_ireplace( '_', '-', $widget_position ) === str_ireplace( '_', '-',
    $meta['_treweler_map_details_position'][0] ) && strpos( $widget_position,
    'top' ) === false && ( ! empty( $meta_data->widgets_show ) && $meta['_treweler_map_details_name'][0] != "" || $meta['_treweler_map_details_description'][0] != "" || $logo != "" ) ):
  $title_loaded = true;
  ?>
    <li class="<?php echo $c_bottom_category ? 'before-filter-cat' : '' ?>">
        <div class="under-widget treweler-map-details logo">
            <div class="logo-tw">
              <?php


              if ( $logo ) {
              $logo_size = isset( $meta['_treweler_map_details_logo_size'][0] ) ? $meta['_treweler_map_details_logo_size'][0] : '40';
              if ( ! is_numeric( $logo_size ) && empty( $logo_size ) ) {
                $logo_size = '40';
              }
              $style_logo = '';
              if ( $logo_size ) {
                $style_logo = 'style="height:' . esc_attr( $logo_size ) . 'px;"';
              }
              $logo_url = isset( $meta['_treweler_map_logo_url'][0] ) ? $meta['_treweler_map_logo_url'][0] : '';
              $logo_target = isset( $meta['_treweler_map_logo_target'][0] ) ? $meta['_treweler_map_logo_target'][0] : '';
              if ( ! empty( $logo_target ) ) {
                $logo_target = 'target="_blank"';
              }
              $tag_logo = 'div';
              if ( ! empty( $logo_url ) ) {
                $tag_logo = 'a';
                $logo_url = 'href="' . esc_url( $logo_url ) . '"';
              }


              ?>
                <<?php echo esc_html( $tag_logo ); ?> <?php echo $style_logo; ?> <?php echo $logo_url; ?> <?php echo $logo_target; ?> class="logo-icon" >
                <img <?php echo $style_logo; ?> src="<?php echo esc_url( $logo ); ?>"
                                                alt="<?php echo esc_attr__( 'Treweler', 'treweler' ); ?>">
            </<?php echo esc_html( $tag_logo ); ?>>
          <?php } ?>

          <?php if ( $meta['_treweler_map_details_name'][0] != "" || $meta['_treweler_map_details_description'][0] != "" ) { ?>
              <div class="logo-text">
                <?php if ( $meta['_treweler_map_details_name'][0] != "" ) {
                  $style = ' style="';
                  $style .= ! empty( $meta['_treweler_map_details_name_color'][0] ) ? 'color:' . esc_attr( $meta['_treweler_map_details_name_color'][0] ) . ';' : '';
                  $style .= ! empty( $meta['_treweler_map_name_font_size'][0] ) ? 'font-size:' . esc_attr( $meta['_treweler_map_name_font_size'][0] ) . 'px;' : '';
                  $style .= ! empty( $meta['_treweler_map_name_font_weight'][0] ) ? 'font-weight:' . esc_attr( $meta['_treweler_map_name_font_weight'][0] ) . ';' : '';
                  $style .= '" ';
                  ?>

                    <div class="twer-logo-text-head" <?php echo $style; ?>><?php echo esc_html( trim( $meta['_treweler_map_details_name'][0] ) ); ?></div>
                <?php } ?>
                <?php if ( $meta['_treweler_map_details_description'][0] != "" ) {

                  $style_desc = ' style="';
                  $style_desc .= ! empty( $meta['_treweler_map_details_description_color'][0] ) ? 'color:' . esc_attr( $meta['_treweler_map_details_description_color'][0] ) . ';' : '';
                  $style_desc .= ! empty( $meta['_treweler_map_desc_font_size'][0] ) ? 'font-size:' . esc_attr( $meta['_treweler_map_desc_font_size'][0] ) . 'px;' : '';
                  $style_desc .= ! empty( $meta['_treweler_map_desc_font_weight'][0] ) ? 'font-weight:' . esc_attr( $meta['_treweler_map_desc_font_weight'][0] ) . ';' : '';
                  $style_desc .= '" ';
                  ?>

                    <span <?php echo $style_desc; ?>><?php echo esc_html( trim( $meta['_treweler_map_details_description'][0] ) ); ?></span>
                <?php } ?>
              </div>
          <?php } ?>


        </div>
</div>


</li>
<?php endif; ?>

<?php if ( $c_bottom_category ): ?>
<li>
    <div class="map-category">
        <div class="twer-mobile-cat">
            <button class="twer-mobile-menu" type="button">
                <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="11" height="1" fill="#1F2B49"/>
                    <rect y="4" width="11" height="1" fill="#1F2B49"/>
                    <rect y="8" width="11" height="1" fill="#1F2B49"/>
                </svg>
            </button>
        </div>
      <?php twerMapCategorySelect( $map_id );
      $category_loaded = true; ?>
    </div>
</li>
<?php endif; ?>

<?php if ( $c_bottom_tour ): ?>
<li>
    <div class="tour-wrapper">
      <?php TWER_Screen_Map::tourWidgetElement( $meta_data->tour_arrows_position,
        $meta_data->tour_start_message, $tour_show_name );
      $tour_loaded = true; ?>
    </div>
</li>
<?php endif; ?>

</ul>
</div>
<?php
}
}

} ?>


<!-- TT v2 -->
<?php
$c_category_in_title = $category_loaded === false && ! empty( $meta_data->category_filter ) && str_ireplace( '_', '-',
    $meta_data->category_position ) === str_ireplace( '_', '-', $meta['_treweler_map_details_position'][0] );
$c_tour_in_title = $tour_loaded === false && ! empty( $meta_data->enable_tour ) && str_ireplace( '_', '-',
    $meta_data->tour_arrows_position ) === str_ireplace( '_', '-', $meta['_treweler_map_details_position'][0] );
if ( ! empty( $meta_data->show_map_desc ) && $title_loaded === false && ( $meta['_treweler_map_details_name'][0] != "" || $meta['_treweler_map_details_description'][0] != "" || $logo != "" ) ) { ?>
<div class="twer-widget twer-widget-location twer-<?php echo esc_attr( str_ireplace( '_', '-',
  $meta['_treweler_map_details_position'][0] ) ); ?>">
    <ul>
        <li class="<?php echo $c_category_in_title ? 'before-filter-cat' : '' ?>">
            <div class="under-widget treweler-map-details logo">
                <div class="logo-tw">
                  <?php


                  if ( $logo ) {
                  $logo_size = isset( $meta['_treweler_map_details_logo_size'][0] ) ? $meta['_treweler_map_details_logo_size'][0] : '40';

                  if ( ! is_numeric( $logo_size ) && empty( $logo_size ) ) {
                    $logo_size = '40';
                  }

                  $style_logo = '';

                  if ( $logo_size ) {
                    $style_logo = 'style="height:' . esc_attr( $logo_size ) . 'px;"';
                  }

                  $logo_url = isset( $meta['_treweler_map_logo_url'][0] ) ? $meta['_treweler_map_logo_url'][0] : '';
                  $logo_target = isset( $meta['_treweler_map_logo_target'][0] ) ? $meta['_treweler_map_logo_target'][0] : '';
                  if ( ! empty( $logo_target ) ) {
                    $logo_target = 'target="_blank"';
                  }
                  $tag_logo = 'div';
                  if ( ! empty( $logo_url ) ) {
                    $tag_logo = 'a';
                    $logo_url = 'href="' . esc_url( $logo_url ) . '"';
                  }

                  ?>
                    <<?php echo esc_html( $tag_logo ); ?> <?php echo $style_logo; ?> <?php echo $logo_url; ?> <?php echo $logo_target; ?> class="logo-icon" >
                    <img <?php echo $style_logo; ?> src="<?php echo esc_url( $logo ); ?>"
                                                    alt="<?php echo esc_attr__( 'Treweler', 'treweler' ); ?>">
                </<?php echo esc_html( $tag_logo ); ?>>
              <?php } ?>

              <?php if ( $meta['_treweler_map_details_name'][0] != "" || $meta['_treweler_map_details_description'][0] != "" ) { ?>
                  <div class="logo-text">
                    <?php if ( $meta['_treweler_map_details_name'][0] != "" ) {
                      $style = ' style="';
                      $style .= ! empty( $meta['_treweler_map_details_name_color'][0] ) ? 'color:' . esc_attr( $meta['_treweler_map_details_name_color'][0] ) . ';' : '';
                      $style .= ! empty( $meta['_treweler_map_name_font_size'][0] ) ? 'font-size:' . esc_attr( $meta['_treweler_map_name_font_size'][0] ) . 'px;' : '';
                      $style .= ! empty( $meta['_treweler_map_name_font_weight'][0] ) ? 'font-weight:' . esc_attr( $meta['_treweler_map_name_font_weight'][0] ) . ';' : '';
                      $style .= '" ';
                      ?>

                        <div class="twer-logo-text-head" <?php echo $style; ?>><?php echo esc_html( trim( $meta['_treweler_map_details_name'][0] ) ); ?></div>
                    <?php } ?>
                    <?php if ( $meta['_treweler_map_details_description'][0] != "" ) {

                      $style_desc = ' style="';
                      $style_desc .= ! empty( $meta['_treweler_map_details_description_color'][0] ) ? 'color:' . esc_attr( $meta['_treweler_map_details_description_color'][0] ) . ';' : '';
                      $style_desc .= ! empty( $meta['_treweler_map_desc_font_size'][0] ) ? 'font-size:' . esc_attr( $meta['_treweler_map_desc_font_size'][0] ) . 'px;' : '';
                      $style_desc .= ! empty( $meta['_treweler_map_desc_font_weight'][0] ) ? 'font-weight:' . esc_attr( $meta['_treweler_map_desc_font_weight'][0] ) . ';' : '';
                      $style_desc .= '" ';
                      ?>

                        <span <?php echo $style_desc; ?>><?php echo esc_html( trim( $meta['_treweler_map_details_description'][0] ) ); ?></span>
                    <?php } ?>
                  </div>
              <?php } ?>

            </div>
</div>

</li>
<?php if ( $c_category_in_title ) { ?>
<li>
    <div class="map-category">
        <div class="twer-mobile-cat">
            <button class="twer-mobile-menu" type="button">
                <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="11" height="1" fill="#1F2B49"/>
                    <rect y="4" width="11" height="1" fill="#1F2B49"/>
                    <rect y="8" width="11" height="1" fill="#1F2B49"/>
                </svg>
            </button>
        </div>
      <?php twerMapCategorySelect( $map_id );
      $category_loaded = true; ?>
    </div>
</li>
<?php } ?>

<?php if ( $c_tour_in_title ) { ?>
<li>
    <div class="tour-wrapper">
      <?php TWER_Screen_Map::tourWidgetElement( $meta_data->tour_arrows_position,
        $meta_data->tour_start_message, $tour_show_name );
      $tour_loaded = true; ?>
    </div>
</li>
<?php } ?>

</ul>

</div>
<?php $title_loaded = true;
} ?>
<!-- end of TT v2 -->

<!-- start tour & category -->
<?php
$c_tour_in_category = $tour_loaded === false && ! empty( $meta_data->enable_tour ) && str_ireplace( '_', '-',
    $meta_data->tour_arrows_position ) === str_ireplace( '_', '-', $meta_data->category_position );
if ( $category_loaded === false && ! empty( $meta_data->category_filter ) ) { ?>
<div class="twer-widget twer-widget-location twer-<?php echo esc_attr( str_ireplace( '_', '-',
  $meta_data->category_position ) ); ?>">
    <ul>

        <li>
            <div class="map-category">
                <div class="twer-mobile-cat">
                    <button class="twer-mobile-menu" type="button">
                        <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="11" height="1" fill="#1F2B49"/>
                            <rect y="4" width="11" height="1" fill="#1F2B49"/>
                            <rect y="8" width="11" height="1" fill="#1F2B49"/>
                        </svg>
                    </button>
                </div>
              <?php twerMapCategorySelect( $map_id );
              $category_loaded = true; ?>
            </div>
        </li>

      <?php if ( $c_tour_in_category ) { ?>
          <li>
              <div class="tour-wrapper">
                <?php TWER_Screen_Map::tourWidgetElement( $meta_data->tour_arrows_position,
                  $meta_data->tour_start_message, $tour_show_name );
                $tour_loaded = true; ?>
              </div>
          </li>
      <?php } ?>

    </ul>

</div>
<?php } ?>

<!-- end of tour & category -->


<?php if ( $tour_loaded === false && ! empty( $meta_data->enable_tour ) ) { ?>
<div class="twer-tour-control twer-tour-location tour-<?php echo esc_attr( str_ireplace( '_', '-',
  $meta_data->tour_arrows_position ) ); ?>">
    <div class="tour-wrapper">
      <?php TWER_Screen_Map::tourWidgetElement( $meta_data->tour_arrows_position, $meta_data->tour_start_message, $tour_show_name );
      $tour_loaded = true; ?>
    </div>
</div>
<?php } ?>


</div>

<?php
/**
 * twer_after_main_content hook.
 *
 * @hooked twer_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'twer_after_main_content' );
?>


<?php
/**
 * twer_map_elements_templates hook.
 *
 * @hooked twer_output_store_locator_cards - 10 (outputs different templates for dynamic content e.g: cards for store locator etc.)
 * @hooked twer_output_custom_fields - 11 (outputs templates for custom fields.)
 * @hooked twer_output_filters - 12 (outputs templates for filters.)
 */
do_action( 'twer_map_elements_templates' );
?>



<?php if ( ! empty( $meta_data->enable_preloader ) ) { ?>
<div class="twer-preloader"
     style="background-color: <?php echo esc_html( $meta_data->preloader_background_color ); ?>;">
    <div class="inner-container"
         style="margin-top: <?php echo $meta_data->preloader_popup_image ? '40vh' : '47vh' ?>;">
      <?php
      $preloader_img = isset( $meta_data->preloader_popup_image ) ? $meta_data->preloader_popup_image : '';
      if ( is_numeric( $preloader_img ) ) {
        $preloader_img = wp_get_attachment_image_src( $preloader_img, 'full' );
        $preloader_img = isset( $preloader_img[0] ) ? $preloader_img[0] : $preloader_img;
      }
      if ( $preloader_img ) { ?>
          <img class="img-progress" src="<?php echo esc_url( $preloader_img ); ?>" alt="<?php _e( 'Loading...', 'treweler' ); ?>">
      <?php } ?>

      <?php if ( $meta_data->preloader_text ) { ?>
          <h4 class="title-progress"
              style="color: <?php echo esc_html( $meta_data->preloader_text_color ); ?>;"><?php echo esc_html( $meta_data->preloader_text ); ?></h4>
      <?php } ?>

      <?php if ( ! empty( $meta_data->preloader_enable_percentage ) ) { ?>
          <span class="loading-progress"
                style="color: <?php echo esc_html( $meta_data->preloader_percentage_color ); ?>;">0%</span>
      <?php } ?>
    </div>
</div>
<?php } ?>


<template id="js-twer-marker-label">
    <div class="twer-marker-label"></div>
</template>


<?php twer_wp_footer(); ?>

<div class="select2-map-filter"></div>


</body>
    </html>






<?php
//get_footer( 'treweler' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
