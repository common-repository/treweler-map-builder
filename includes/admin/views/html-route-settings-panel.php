<?php
/**
 * Route settings meta box.
 *
 * @package Treweler/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$tmp_post = $post;
$post_id = isset( $post->ID ) ? $post->ID : '';

$setMap = get_post_meta( $post_id, '_treweler_route_map_id', true );

$maps_posts = get_posts( [
  'post_type'      => 'map',
  'post_status'    => 'publish',
  'posts_per_page' => - 1,
  'orderby'        => 'title',
  'order'          => 'ASC'
] );
$maps = [];
if ( ! empty( $maps_posts ) ) {
  foreach ( $maps_posts as $post ) {
    setup_postdata( $post );
    $postId = get_the_ID();
    $post_title = get_the_title();
    $map_style = trim( get_post_meta( $postId, '_treweler_map_custom_style',
      true ) ) != "" ? get_post_meta( $postId, '_treweler_map_custom_style',
      true ) : get_post_meta( $postId, '_treweler_map_styles', true );

    $mapProjection = get_post_meta($postId, '_treweler_map_projection', true);
    $mapProjection = !empty($mapProjection) ? $mapProjection : 'mercator';

	  $mapLightPreset = get_post_meta($postId, '_treweler_map_light_preset', true);
	  $mapLightPreset = !empty($mapLightPreset) ? $mapLightPreset : 'day';

    $maps[ $postId ] = [
      'title' => $post_title,
      'style' => $map_style,
      'projection' => $mapProjection,
      'light_preset' => $map_style === twerGetDefaultMapStyle() ? $mapLightPreset : ''
    ];
  }
  wp_reset_postdata();
}


$post = $tmp_post;

if ( is_array( $setMap ) && ! empty( $setMap ) ) {
  $maps_sorted = [];
  foreach ( $setMap as $mapKey ) {
    if('publish' !== get_post_status($mapKey)) continue;

    $maps_sorted[ $mapKey ] = $maps[ $mapKey ];
    unset( $maps[ $mapKey ] );
  }
  $maps = $maps_sorted + $maps;
}


$cust = get_post_meta( $post_id );

$routeLineWidth   = ( isset( $cust["_treweler_route_line_width"] ) && trim( $cust["_treweler_route_line_width"][0] ) != "" ) ? $cust["_treweler_route_line_width"][0] : 3;
$routeLineOpacity = ( isset( $cust["_treweler_route_line_opacity"] ) && trim( $cust["_treweler_route_line_opacity"][0] ) != "" ) ? $cust["_treweler_route_line_opacity"][0] : 1;
$routeLineDash    = ( isset( $cust["_treweler_route_line_dash"] ) && trim( $cust["_treweler_route_line_dash"][0] ) != "" ) ? $cust["_treweler_route_line_dash"][0] : 1;
$routeLineGap     = ( isset( $cust["_treweler_route_line_gap"] ) && trim( $cust["_treweler_route_line_gap"][0] ) != "" ) ? $cust["_treweler_route_line_gap"][0] : 0;

$route_latlng   = isset( $cust["_treweler_route_map_latlng"] ) ? $cust["_treweler_route_map_latlng"][0] : '{0.1,0.1}';
$route_zoom     = isset( $cust["_treweler_route_map_zoom"] ) ? $cust["_treweler_route_map_zoom"][0] : 0;
$route_color    = isset( $cust["_treweler_route_line_color"] ) ? $cust["_treweler_route_line_color"][0] : '#438EE4';
$route_coords   = isset( $cust["_treweler_route_line_coords"] ) ? $cust["_treweler_route_line_coords"][0] : '';
$route_gpx      = isset( $cust["_treweler_route_gpx_file"] ) ? $cust["_treweler_route_gpx_file"][0] : '';
$route_gpx_name = isset( $cust["_treweler_route_gpx_file_name"] ) ? $cust["_treweler_route_gpx_file_name"][0] : '';

$custom_color  = get_option( 'treweler_mapbox_colorpicker_custom_color' );
$defaultColors = "#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|";
?>

<div class="treweler-controls twer-route-settings">
    <p class="post-attributes-label-wrapper">
        <label class="post-attributes-label">
			<?php echo esc_html__( 'Route Maps', 'treweler' ); ?>
        </label>
    </p>
    <p style="margin-bottom: 0px">

        <input type="hidden" name="_treweler_route_map_id" value="">
        <select name="_treweler_route_map_id[]" id="map_id" class="large-select js-twer-select-2" multiple="multiple">
            <option value=""><?php echo esc_html__( 'No maps selected', 'treweler' ); ?></option>
          <?php
          if ( ! empty( $maps ) ) {
            foreach ( $maps as $map_id => $map_data ) {
              $selected = '';
              if ( is_array( $setMap ) ) {
                $selected = in_array( $map_id, $setMap ) ? 'selected' : '';
              } else {
                $selected = $setMap == $map_id ? 'selected' : '';
              }
              echo '<option value="' . esc_attr( $map_id ) . '" data-map-light-preset="' . esc_attr( $map_data['light_preset'] ) . '" data-map_style="' . esc_attr( $map_data['style'] ) . '" data-map-projection="' . esc_attr( $map_data['projection'] ) . '" ' . $selected . '>' . esc_html( $map_data['title'] ) . '</option>';
            }
          }

          ?>
        </select>
    </p>
    <?php
    // @TODO: Delete After Finish Migrate Fields

    if(isset($_GET['twer-debug-show'])): ?>
    <p class="post-attributes-label-wrapper">
        <label class="post-attributes-label">
			<?php echo esc_html__( "Route line color", 'treweler' ); ?>
        </label>
    </p>
    <div class="clr-picker">
        <span class="color-holder" style="background-color:<?php echo esc_attr( $route_color ); ?>;"></span>
        <input type="button" id="color-picker-btn" value="<?php echo esc_attr__( 'Select Color', 'treweler' ); ?>">
    </div>
    <div class="color-picker"
         acp-color="<?php echo esc_attr( $route_color ); ?>"
         acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
         default-palette="<?php echo esc_attr( $defaultColors ); ?>"
         acp-show-rgb="no"
         acp-show-hsl="no"
         acp-palette-editable>
    </div>
    <hr/>

    <p class="post-attributes-label-wrapper"><label
                class="post-attributes-label"><?php echo esc_html__( "Route line width, px", 'treweler' ); ?></label>
    </p>
    <p><input type="text" name="_treweler_route_line_width" id="route_line_width" class="large-text"
              value="<?php echo esc_attr( $routeLineWidth ); ?>"></p>
    <hr/>

    <p class="post-attributes-label-wrapper"><label
                class="post-attributes-label"><?php echo esc_html__( "Route line opacity", 'treweler' ); ?></label></p>
    <p>
        <input type="text" name="_treweler_route_line_opacity" id="route_line_opacity" class="large-text"
               value="<?php echo esc_attr( $routeLineOpacity ); ?>">
        <small><?php echo esc_html__( 'Value between 0 and 1 (Example 0.8)', 'treweler' ); ?></small>
    </p>
    <hr/>



    <p class="post-attributes-label-wrapper"><label class="post-attributes-label"><?php echo esc_html__( "Dash and gap",
				'treweler' ); ?></label></p>
    <p>
        <input type="text" name="_treweler_route_line_dash" id="route_line_dash" class="half-text alignleft"
               value="<?php echo esc_attr( $routeLineDash ); ?>"
               placeholder="<?php echo esc_attr__( 'Dash', 'treweler' ); ?>">
        <input type="text" name="_treweler_route_line_gap" id="route_line_gap" class="half-text alignright"
               value="<?php echo esc_attr( $routeLineGap ); ?>"
               placeholder="<?php echo esc_attr__( 'Gap', 'treweler' ); ?>">
    </p>
    <?php endif; ?>

    <input type="hidden" name="addCustomColor" id="addCustomColor" value="<?php echo esc_attr( $custom_color ); ?>"/>
    <input type="hidden" name="_treweler_route_line_color" id="routeColor"
           value="<?php echo esc_attr( $route_color ); ?>"/>
    <input type="hidden" name="_treweler_route_map_zoom" id="setZoom" value="<?php echo esc_attr( $route_zoom ); ?>"/>
    <input type="hidden" name="_treweler_route_map_latlng" id="latlng"
           value="<?php echo esc_attr( $route_latlng ); ?>"/>
    <input type="hidden" name="_treweler_route_line_coords" id="routeCoords"
           value="<?php echo esc_attr( $route_coords ); ?>"/>
    <input type="hidden" name="_treweler_route_gpx_file" id="routeGPXFile"
           value="<?php echo esc_attr( $route_gpx ); ?>"/>
    <input type="hidden" name="_treweler_route_gpx_file_name" id="routeGPXFileName"
           value="<?php echo esc_attr( $route_gpx_name ); ?>"/>
</div>
