<?php
/**
 * Marker settings meta box.
 *
 * @package Treweler/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();

$setMap = get_post_meta( $post_id, '_treweler_marker_map_id', true );


$args   = [
	'post_type'      => 'map',
	'post_status'    => 'publish',
	'posts_per_page' => - 1,
	'orderby'        => 'title',
	'order'          => 'ASC'
];
$maps   = new WP_Query( $args );


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

$marker_zoom = isset( $cust["_treweler_marker_zoom"] ) ? $cust["_treweler_marker_zoom"][0] : 0.00;

$marker_color = isset( $cust["_treweler_marker_color"] ) ? $cust["_treweler_marker_color"][0] : '#4b7715';

$custom_color  = get_option( 'treweler_mapbox_colorpicker_custom_color' );
$defaultColors = "#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|";

$markerIconSize = isset( $cust["_treweler_marker_icon_size"] ) ? $cust["_treweler_marker_icon_size"][0] : "";
?>

<div class="treweler-controls">
    <p class="post-attributes-label-wrapper">
        <label class="post-attributes-label">
			<?php echo esc_html__( "Preview Map", 'treweler' ); ?>
        </label>
    </p>
    <p>
        <select name="_treweler_marker_map_id" id="map_id" class="large-select">
            <option value="">
				<?php echo esc_html__( 'No map selected', 'treweler' ); ?>
            </option>
			<?php if ( isset( $maps->posts ) && is_array( $maps->posts ) ) {
				foreach ( $maps->posts as $p ) {
					$map_style = trim( get_post_meta( $p->ID, '_treweler_map_custom_style',
						true ) ) != "" ? get_post_meta( $p->ID, '_treweler_map_custom_style',
						true ) : get_post_meta( $p->ID, '_treweler_map_styles', true );

                    $mapProjection = get_post_meta($p->ID, '_treweler_map_projection', true);
                    $mapProjection = !empty($mapProjection) ? $mapProjection : 'mercator';

					$mapLightPreset = get_post_meta($p->ID, '_treweler_map_light_preset', true);
					$mapLightPreset = !empty($mapLightPreset) ? $mapLightPreset : 'day';
					$mapLightPreset = $map_style === twerGetDefaultMapStyle() ? $mapLightPreset : ''
					?>
                    <option value="<?php echo esc_attr( $p->ID ); ?>"
                            data-map-light-preset="<?php echo esc_attr($mapLightPreset); ?>"
                            data-map-projection="<?php echo esc_attr($mapProjection); ?>"
                            data-map_style="<?php echo esc_attr( $map_style ); ?>" <?php echo( $setMap == $p->ID ? 'selected' : '' ); ?>><?php echo esc_html( $p->post_title ); ?></option>
				<?php }
			} ?>
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
