<?php
/**
 * Shortcodes
 *
 * @package Treweler/Classes
 * @version 0.24
 */

defined( 'ABSPATH' ) || exit;

/**
 * Treweler Shortcodes class.
 */
class TWER_Shortcodes {

	/**
	 * Init shortcodes.
	 */
	public static function init() {
		$shortcodes = [
			'treweler' => __CLASS__ . '::treweler'
		];

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}

		add_filter( 'the_content', [ __CLASS__, 'shortcode_filter' ] );
	}

	/**
	 * Add unique shortcode indexes
	 *
	 * @param $content
	 *
	 * @return string|string[]
	 */
	public static function shortcode_filter( $content ) {
		$pattern = get_shortcode_regex( [ 'treweler' ] );
		if ( preg_match_all( '/' . $pattern . '/s', $content, $matches ) && array_key_exists( 2,
				$matches ) && in_array( 'treweler', $matches[2] ) ) {
			if ( $matches[0] ) {
				$i = 0;
				foreach ( $matches[0] as $shortcode ) {
					$i ++;
					$shortcode_indexed = preg_replace( '/\[treweler/ims', '[treweler index="' . $i . '"', $shortcode );
					$content           = str_replace( $shortcode, $shortcode_indexed, $content );
				}
			}
		}

		return $content;
	}


	/**
	 * Shortcode for treweler plugin
	 * `[treweler map-id='1']`
	 * Attributes:
	 * - map-id: (*required) Map ID to choose map to show in front-side.
	 * - height: Treweler map height. default, 100px;
	 * - width: Treweler map width. default, 100%;
	 * - type: `fullwidth`, used for fullwidth map outside container and blocks. default value `null`.
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function treweler( $atts ) {
		global $post;


		// Get all shortcode params
		$atts = wp_parse_args( $atts, [
			'index'      => '1',
			'map-id'     => '0',
			'height'     => '500px',
			'type'       => 'default',
			'scrollzoom' => 'yes',
			'width'      => '',
      'lat' => '',
      'lon' => '',
      'zoom' => '',
			'root-id' => $post->ID ?? 0,
		] );

		$prefix = 'twer-';

		$newArray = [];
		foreach ($atts as $key => $value) {
			$newKey = $prefix . $key;
			$newArray[$newKey] = $value;
		}

		$newArray['tw'] = 'iframe';

		$style = [];
		$class = [ 'twer-map-wrapper' ];

		$style[] = ! empty( $atts['width'] ) ? 'max-width:' . esc_attr( $atts['width'] ) . ';' : '';
		$style[] = ! empty( $atts['height'] ) ? 'height:' . esc_attr( $atts['height'] ) . ';' : '';


		//$class[] = ( ( $atts['type'] === 'fullwidth' ) || ( $atts['type'] !== 'fullwidth' && !empty($atts['width'])  ) ) ? 'treweler-map-fw' : '';
		$class[] = $atts['type'] === 'fullwidth' ? 'treweler-map-fw' : '';


		$html = '';
		if ( $atts['map-id'] ) {
			$html .= '<div class="' . implode( ' ' ,$class) . '" >';
			$html .= '<div class="twer-iframe-embed" style="' . implode( $style ) . '">';
			$html .= '<iframe loading="lazy" class="twer-iframe" src="' . esc_url( add_query_arg( $newArray, get_permalink( $newArray['twer-map-id'] ) ) ) . '"  frameborder="0" title="' . esc_attr__( 'Treweler Map',
					'treweler' ) . '"></iframe>';
			$html .= '</div></div>';
		}

		return $html;
	}
}
