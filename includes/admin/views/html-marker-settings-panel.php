<?php
/**
 * Marker settings meta box.
 *
 * @package Treweler/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
global $post;
$tmp_post = $post;
$post_id = isset( $post->ID ) ? $post->ID : '';

$setMap = get_post_meta( $post_id, '_treweler_marker_map_id', true );


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


$marker_ll = isset( $cust["_treweler_marker_latlng"] ) ? unserialize( $cust["_treweler_marker_latlng"][0] ) : [];
if ( ! empty( $marker_ll ) ) {
  foreach ( $marker_ll as $k => $v ) {
    ${"ll$k"} = $v;
  }
}
if ( ( isset( $ll0 ) && trim( $ll0 ) == "" ) || ! isset( $ll0 ) ) {
  $ll0 = 0;
}
if ( ( isset( $ll1 ) && trim( $ll1 ) == "" ) || ! isset( $ll1 ) ) {
  $ll1 = 0;
}

$marker_zoom = isset( $cust["_treweler_marker_zoom"] ) ? $cust["_treweler_marker_zoom"][0] : 0;

$marker_color = isset( $cust["_treweler_marker_color"] ) ? $cust["_treweler_marker_color"][0] : '#4b7715';

$custom_color = get_option( 'treweler_mapbox_colorpicker_custom_color' );
$defaultColors = "#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|";

$markerIconSize = isset( $cust["_treweler_marker_icon_size"] ) ? $cust["_treweler_marker_icon_size"][0] : "";
?>

<div class="treweler-controls">
    <p class="post-attributes-label-wrapper">
        <label class="post-attributes-label">
          <?php echo esc_html__( "Marker Maps", 'treweler' ); ?>
        </label>
    </p>
    <p>
        <input type="hidden" name="_treweler_marker_map_id" value="">
        <select name="_treweler_marker_map_id[]" id="map_id" class="large-select js-twer-select-2" multiple="multiple">
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
              echo '<option value="' . esc_attr( $map_id ) . '" data-map-light-preset="' . esc_attr( $map_data['light_preset'] ) . '" data-map-projection="' . esc_attr( $map_data['projection'] ) . '" data-map_style="' . esc_attr( $map_data['style'] ) . '" ' . $selected . '>' . esc_html( $map_data['title'] ) . '</option>';
            }
          }

          ?>
        </select>
    </p>

    <hr/>
    <p class="post-attributes-label-wrapper"><label
                class="post-attributes-label"><?php echo esc_html__( "Marker Coordinates", 'treweler' ); ?></label></p>
    <p><input type="text" name="_treweler_marker_latlng[0]" id="latitude" class="large-text"
              value="<?php echo esc_attr( $ll0 ); ?>"
              placeholder="<?php echo esc_attr__( "Latitude ", 'treweler' ); ?>"/></p>
    <p><input type="text" name="_treweler_marker_latlng[1]" id="longitude" class="large-text"
              value="<?php echo esc_attr( $ll1 ); ?>"
              placeholder="<?php echo esc_attr__( "Longitude", 'treweler' ); ?>"/></p>

    <input type="hidden" name="_treweler_marker_icon_size" id="marker_icon_size"
           value="<?php echo esc_attr( $markerIconSize ); ?>">
    <input type="hidden" name="_treweler_marker_zoom" id="setZoom" value="<?php echo esc_attr( $marker_zoom ); ?>"/>
</div>
