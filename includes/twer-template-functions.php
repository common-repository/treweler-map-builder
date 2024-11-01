<?php
/**
 * Treweler Template
 * Functions for the templating system.
 *
 * @package  Treweler\Functions
 * @version  0.24
 */

defined( 'ABSPATH' ) || exit;

use \Symfony\Component\DomCrawler\Crawler;


if ( ! function_exists( 'twer_wp_head' ) ) {
	/**
	 * Output custom wp_head in map template
	 *
	 * @return void
	 */
	function twer_wp_head() {
		if ( TWER_TEMPLATE_DEBUG_MODE ) {
			do_action( 'wp_head' );
		}
		ob_start();
		do_action( 'wp_head' );
		$html = ob_get_clean();

		$crawler = new Crawler( $html );

		$selectors = [
			'[id^="treweler"]',
			'[rel^="dns-"]',
			'[id^="dashicons-"]',
			'[id^="admin-"]',
			'[id^="jquery-"]',
			'title',
			'[id^="lodash-"]',
			'meta',
			'style[media="print"]',
			'[id*="mediaelement"]'
		];

		$html_nodes = $crawler->filter( implode( ', ', $selectors ) )->each( function( Crawler $node, $i ) {
			return $node->outerHtml();
		} );

		echo implode( '', $html_nodes );
	}
}

if ( ! function_exists( 'twer_wp_footer' ) ) {
	/**
	 * Output custom wp_footer in map template
	 *
	 * @return void
	 */
	function twer_wp_footer() {
		if ( TWER_TEMPLATE_DEBUG_MODE ) {
			do_action( 'wp_footer' );
		}
		ob_start();
		do_action( 'wp_footer' );
		$html = ob_get_clean();

		$crawler = new Crawler( $html );

		$selectors = [
			'[id^="treweler"]',
			'[id^="hoverintent-"]',
			'[id^="admin-"]',
			'[id^="jquery-"]',
			'#wpadminbar',
			'[id^="wp-i18n-"]',
			'[id^="lodash-"]',
			'[id^="regenerator-runtime-"]',
			'[id^="wp-polyfill-"]',
			'[id^="wp-hooks-"]',
			'[id*="mediaelement"]'
		];

		$html_nodes = $crawler->filter( implode( ', ', $selectors ) )->each( function( Crawler $node, $i ) {
			return $node->outerHtml();
		} );

		echo implode( '', $html_nodes );
	}
}

if ( ! function_exists( 'twer_generator_tag' ) ) {
	/**
	 * Output generator tag to aid debugging.
	 *
	 * @param string $gen Generator.
	 * @param string $type Type.
	 *
	 * @return string
	 */
	function twer_generator_tag( $gen, $type ) {
		$version = TWER_VERSION;

		switch ( $type ) {
			case 'html':
				$gen .= "\n" . '<meta id="treweler-generator" name="generator" content="Treweler ' . esc_attr( $version ) . '">';
				break;
			case 'xhtml':
				$gen .= "\n" . '<meta id="treweler-generator" name="generator" content="Treweler ' . esc_attr( $version ) . '" />';
				break;
		}

		return $gen;
	}
}

if ( ! function_exists( 'twer_body_class' ) ) {
	/**
	 * Add body classes for Treweler pages.
	 *
	 * @param array $classes Body Classes.
	 *
	 * @return array
	 */
	function twer_body_class( $classes ) {
		$classes = (array) $classes;

		if ( twer_is_map_in_page() ) {

			$classes[] = twer_is_map_iframe() ? 'twer-page-iframe-map' : 'twer-page-fullscreen-map';

			if ( twerStoreLocatorIsEnable() ) {
				$classes[] = 'twer-has-store-locator twer-has-store-locator--' . twerGetStoreLocatorType();
			}
		}

		return array_unique( $classes );
	}
}

/**
 * Global
 */

if ( ! function_exists( 'twer_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 */
	function twer_output_content_wrapper() {
		twer_get_template( 'global/wrapper-start.php' );
	}
}
if ( ! function_exists( 'twer_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 */
	function twer_output_content_wrapper_end() {
		twer_get_template( 'global/wrapper-end.php' );
	}
}

if ( ! function_exists( 'twer_output_store_locator' ) ) {
	/**
	 * Output Extended Store Locator Panel
	 *
	 * @return void
	 */
	function twer_output_store_locator() {
		if ( twerStoreLocatorIsExtended() ) {
			twer_get_template( 'store-locator/section.php' );
		}
	}
}


function twer_output_store_locator_cards() {
	if ( twerStoreLocatorIsExtended() ) {
		twer_get_template( 'store-locator/cards/simple.php' );
		twer_get_template( 'store-locator/cards/image.php' );
		twer_get_template( 'store-locator/cards/gallery.php' );
	}
}

function twer_output_filters() {
	if ( twerStoreLocatorFiltersIsAvailable() ) {
		$registeredFiltersSlugs = [
			'multiselect',
			'range',
			'true-false',
			'select',
			'categories'
		];
		foreach ( $registeredFiltersSlugs as $filterSlug ) {
			twer_get_template( 'filters/' . $filterSlug . '.php' );
		}
	}
}

function twer_output_custom_fields() {
	if ( twerStoreLocatorIsExtended() ) {
		twer_get_template( 'custom-fields/section.php' );
		$registeredCustomFieldsSlugs = [
			'line',
			'link-universal',
			'multiselect',
			'number',
			'separator',
			'text',
			'true-false',
			'html',
			'category'
		];
		foreach ( $registeredCustomFieldsSlugs as $customFieldSlug ) {
			twer_get_template( 'custom-fields/elements/' . $customFieldSlug . '.php' );
		}
	}
}

function twer_output_store_locator_no_results_message() {
	if ( twerStoreLocatorIsExtended() ) {
		twer_get_template( 'store-locator/no-results-message.php' );
	}
}

function twerTemplateMetaDiff( $data ) {
	$new_data = [];
	foreach ( $data as $data_key => $data_item ) {

		switch ( $data_key ) {
			case 'label_marker_hide' :
				$new_data['marker_hide'] = $data_item;
				break;
			case 'label_weight' :
				$new_data['label_font_weight'] = $data_item;
				break;
      case 'custom_fields_font' :
        $new_data['custom_field_size'] = $data_item['size'];
        $new_data['custom_field_weight'] = $data_item['weight'];
        break;
      case 'popup_heading' :
        $new_data['popup_heading'] = $data_item['text'];
        $new_data['popup_heading_size'] = $data_item['size'];
        $new_data['popup_heading_font_weight'] = $data_item['weight'];
        break;
      case 'popup_subheading' :
        $new_data['popup_subheading'] = $data_item['text'];
        $new_data['popup_subheading_size'] = $data_item['size'];
        $new_data['popup_subheading_font_weight'] = $data_item['weight'];
        break;
      case 'popup_description' :
        $new_data['popup_description'] = $data_item['text'];
        $new_data['popup_description_size'] = $data_item['size'];
        $new_data['popup_description_font_weight'] = $data_item['weight'];
        break;
			case 'label_size' :
				$new_data['label_font_size'] = $data_item;
				break;
			case 'label_color' :
				$new_data['label_font_color'] = $data_item;
				break;
			case 'label_enable' :
				$new_data['marker_enable_labels'] = $data_item;
				break;
			case 'popup_open_on' :
				$new_data['popup_open_group']['open_on']      = $data_item['action'];
				$new_data['popup_open_group']['open_default'] = $data_item['default'];
				break;
			case 'popup_gallery' :
				$new_data['popup_image'] = $data_item;
				break;
			case 'popup_gallery_position' :
				$new_data['popup_image_position'] = $data_item;
				break;
			case 'popup_gallery_width' :
				$new_data['popup_image_width'] = $data_item;
				break;
			case 'point_color' :
				$new_data['marker_color'] = $data_item;
				break;
			case 'point_halo_color' :
				$new_data['marker_halo_color'] = $data_item;
				break;
			case 'dot_icon_show' :
				$new_data['picker_dot'] = $data_item;
				break;
			case 'dot_icon' :
				$new_data['dot_icon_color'] = $data_item['color'];
				$new_data['dot_icon_size']  = $data_item['size'];
				break;
			case 'dot' :
				$new_data['marker_dotcenter_color'] = $data_item['color'];
				$new_data['marker_size']            = $data_item['size'];
				break;
			case 'dot_border' :
				$new_data['marker_border_color'] = $data_item['color'];
				$new_data['marker_border_width'] = $data_item['size'];
				break;
			case 'dot_corner_radius' :
				$new_data['marker_corner_radius']       = $data_item['size'];
				$new_data['marker_corner_radius_units'] = $data_item['units'];
				break;
			case 'balloon_icon_show' :
				$new_data['picker'] = $data_item;
				break;
			case 'balloon_icon' :
				$new_data['balloon_icon_color'] = $data_item['color'];
				$new_data['balloon_icon_size']  = $data_item['size'];
				break;
			case 'balloon' :
				$new_data['marker_color_balloon'] = $data_item['color'];
				$new_data['marker_size_balloon']  = $data_item['size'];
				break;
			case 'balloon_border' :
				$new_data['marker_border_color_balloon'] = $data_item['color'];
				$new_data['marker_border_width_balloon'] = $data_item['size'];
				break;
			case 'balloon_dot' :
				$new_data['marker_dot_color'] = $data_item['color'];
				$new_data['marker_dot_size']  = $data_item['size'];
				break;
			case 'triangle_color' :
				$new_data['marker_color_triangle'] = $data_item;
				break;
			case 'triangle_width' :
				$new_data['marker_width_triangle'] = $data_item;
				break;
			case 'triangle_height' :
				$new_data['marker_height_triangle'] = $data_item;
				break;
			case 'custom_marker_img' :
				if ( is_numeric( $data_item ) ) {
					$data_item = wp_get_attachment_image_src( $data_item, 'full' );
					$data_item = isset( $data_item[0] ) ? $data_item[0] : $data_item;
				}
				$new_data['thumbnail_id'] = $data_item;
				break;
			case 'custom_marker_position' :
				$new_data['marker_position'] = $data_item;
				break;
			case 'custom_marker_size' :
				$new_data['marker_img_size'] = $data_item;
				break;
			case 'custom_marker_cursor' :
				$new_data['marker_cursor'] = $data_item;
				break;
			case 'point_halo_opacity' :
				$new_data['marker_halo_opacity'] = $data_item;
				break;
			default :
				$new_data[ $data_key ] = $data_item;
				break;
		}
	}

	return (object) $new_data;
}

function twerTemplateMerge( $marker_data, $template_data ) {

	foreach ( $marker_data as $key => $value ) {
		if ( strpos( $key, '_lock' ) !== false ) {
			if ( $value === 'close' ) {
				if ( $key === 'custom_fields_all_lock' || $key === 'custom_field_add__lock' ) {
					continue;
				}
				$key_value = substr( $key, 0, - 5 );

				switch ( $key_value ) {

					case 'marker_link_url' :
						$marker_data->marker_link['url'] = $template_data->marker_link['url'] ?? '';
						break;
					case 'marker_link_target' :
						$marker_data->marker_link['target'] = $template_data->marker_link['target'];
						break;
					case 'popup_close_button_show' :
						$marker_data->popup_close_button['show'] = $template_data->popup_close_button['show'];
						break;
					case 'popup_close_button_style' :
						$marker_data->popup_close_button['style'] = $template_data->popup_close_button['style'];
						break;
					case 'label_padding_top' :
						$marker_data->label_padding['top'] = $template_data->label_padding['top'];
						break;
					case 'label_padding_bottom' :
						$marker_data->label_padding['bottom'] = $template_data->label_padding['bottom'];
						break;
					case 'label_padding_left' :
						$marker_data->label_padding['left'] = $template_data->label_padding['left'];
						break;
					case 'label_padding_right' :
						$marker_data->label_padding['right'] = $template_data->label_padding['right'];
						break;
					case 'popup_size_height' :
						$marker_data->popup_size['height'] = $template_data->popup_size['height'];
						break;
					case 'popup_size_width' :
						$marker_data->popup_size['width'] = $template_data->popup_size['width'];
						break;
					case 'popup_open_group_open_on' :
						$marker_data->popup_open_group['open_on'] = $template_data->popup_open_group['open_on'];
						break;
          case 'popup_button_text' :
            $marker_data->popup_button['text'] = $template_data->popup_button['text'] ?? '';
            break;
          case 'popup_button_url' :
            $marker_data->popup_button['url'] = $template_data->popup_button['url'] ?? '';
            break;
          case 'popup_button_color' :
            $marker_data->popup_button['color'] = $template_data->popup_button['color'] ?? '';
            break;
          case 'popup_button_target' :
            $marker_data->popup_button['target'] = $template_data->popup_button['target'] ?? '';
            break;
					case 'popup_open_group_open_default' :
						$marker_data->popup_open_group['open_default'] = $template_data->popup_open_group['open_default'];
						break;
					case 'marker_click_offset_top' :
						$marker_data->marker_click_offset['top'] = $template_data->marker_click_offset['top'];
						break;
					case 'marker_click_offset_bottom' :
						$marker_data->marker_click_offset['bottom'] = $template_data->marker_click_offset['bottom'];
						break;
					case 'marker_click_offset_left' :
						$marker_data->marker_click_offset['left'] = $template_data->marker_click_offset['left'];
						break;
					case 'marker_click_offset_right' :
						$marker_data->marker_click_offset['right'] = $template_data->marker_click_offset['right'];
						break;
					default :
						$marker_data->$key_value = isset( $template_data->$key_value ) ? $template_data->$key_value : '';
						break;
				}
			}
		}
	}

	if ( ! empty( $template_data ) ) {
		foreach ( $template_data as $template_data_key => $template_data_value ) {
			if ( ! isset( $marker_data->$template_data_key ) ) {
				$marker_data->$template_data_key = $template_data_value;
			}
		}
	}

	return $marker_data;
}


function twerGetCustomFieldsForMarker( int $markerId, string $destination = '' ): array {
	$markerCustomFields = [];
	$markerMetaData     = twer_get_data( $markerId );


	$template_data    = [];
	$current_template = isset( $markerMetaData->templates ) ? $markerMetaData->templates : 'none';

	if ( 'none' !== $current_template && ! empty( $current_template ) && 'publish' === get_post_status( $current_template ) ) {
		$template_data = twerTemplateMetaDiff( twer_get_data( $current_template ) );
	}

	if ( ! empty( (array) $template_data ) ) {
		$markerMetaData = twerTemplateMerge( $markerMetaData, $template_data );

	}


	$popupStyle = $markerMetaData->popup_style ?? 'light';

	$destinationPrefix  = '';
	$destinationPrefix1 = ! empty( $destination ) ? '_' . $destination : '';


	$customFieldsShowMetaName = 'custom_field_show' . $destinationPrefix1;
	$customFieldsListMetaName = 'custom_fields_list' . $destinationPrefix1;
	$showCustomFields         = 'no';
	$customFieldsIds          = [];
	if ( 'none' !== $current_template && ! empty( $current_template ) && 'publish' === get_post_status( $current_template ) ) {
		$showCustomFields = ! empty( $template_data->$customFieldsShowMetaName ) ? 'yes' : 'no';
		$customFieldsIds  = isset( $template_data->$customFieldsListMetaName ) ? explode( ',', $template_data->$customFieldsListMetaName ) : [];
	} else {
		$showCustomFields = ! empty( $markerMetaData->$customFieldsShowMetaName ) ? 'yes' : 'no';
		$customFieldsIds  = isset( $markerMetaData->$customFieldsListMetaName ) ? explode( ',', $markerMetaData->$customFieldsListMetaName ) : [];
	}

	if ( 'yes' === $showCustomFields && ! empty( $customFieldsIds ) ) {
		foreach ( $customFieldsIds as $cf ) {

			$cf_meta = twer_get_data( $cf );

			$cf_type      = isset( $cf_meta->custom_field_type ) ? $cf_meta->custom_field_type : 'text';
			$cf_key       = isset( $cf_meta->custom_field_key ) ? $cf_meta->custom_field_key : 'field-1488228';
			$cf_show_name = ! empty( $cf_meta->custom_field_show ) ? 'yes' : 'no';


			$nameWidthValue = isset( $cf_meta->custom_field_name_width ) ? $cf_meta->custom_field_name_width : twerGetDefaultCustomFieldNameWidth();
			$cf_name_width  = empty( $nameWidthValue ) && ! is_numeric( $nameWidthValue ) ? twerGetDefaultCustomFieldNameWidth() : (int) $nameWidthValue;
			$nameWidth      = 'yes' === $cf_show_name ? $cf_name_width : twerGetDefaultCustomFieldNameWidth();

			$cf_default = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';


			$custom_field      = isset( $markerMetaData->{$cf_key . $destinationPrefix} ) ? $markerMetaData->{$cf_key . $destinationPrefix} : '';
			$custom_field_lock = isset( $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} ) ? $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} : 'close';


			$cfName = get_the_title( $cf );

			if ( 'close' === $custom_field_lock ) {
				$custom_field = $cf_default;
			}

			if ( ! empty( $custom_field ) ) {
				switch ( $cf_type ) {
					case 'number' :
						$cf_default     = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';
						$number_default = isset( $cf_default['number'] ) ? $cf_default['number'] : '';

						$custom_field_lock = isset( $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} ) ? $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} : '';

						$lock_value_number = isset( $custom_field_lock['number'] ) ? $custom_field_lock['number'] : 'close';

						$custom_field_number = isset( $custom_field['number'] ) ? $custom_field['number'] : '';

						if ( 'close' === $lock_value_number ) {
							$custom_field_number = $number_default;
						}
						$prefix = isset( $cf_default['prefix'] ) ? $cf_default['prefix'] : '';
						$suffix = isset( $cf_default['suffix'] ) ? $cf_default['suffix'] : '';

						$custom_field_number = str_replace( ',', '.', $custom_field_number );
						$decimals            = strlen( substr( strrchr( $custom_field_number, "." ), 1 ) );

						$numberValue = [
							! empty( $prefix ) ? $prefix : '',
							number_format( $custom_field_number, $decimals ),
							! empty( $suffix ) ? $suffix : '',
						];

						$atts = [];

						if ( 'yes' === $cf_show_name ) {
							$atts['data-name-width'] = $nameWidth;
						}

						$markerCustomFields[] = [
							'id'       => $cf,
							'type'     => $cf_type,
							'name'     => $cfName,
							'showName' => $cf_show_name,
							'atts'     => $atts,
							'value'    => implode( '', $numberValue )
						];
						break;
					case 'html' :
						$cf_default   = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';
						$html_default = isset( $cf_default['html'] ) ? $cf_default['html'] : '';

						$custom_field_lock = isset( $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} ) ? $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} : '';

						$lock_value_html = isset( $custom_field_lock['html'] ) ? $custom_field_lock['html'] : 'close';

						$custom_field_html = isset( $custom_field['html'] ) ? $custom_field['html'] : '';

						if ( 'close' === $lock_value_html ) {
							$custom_field_html = $html_default;
						}

						$marginTop    = isset( $cf_default['marginTop'] ) ? $cf_default['marginTop'] : '';
						$marginBottom = isset( $cf_default['marginBottom'] ) ? $cf_default['marginBottom'] : '';

						$textStyle = [];

						if ( is_numeric( $marginTop ) ) {
							$textStyle[] = sprintf( 'margin-top:%dpx;', $marginTop );
						}
						if ( is_numeric( $marginBottom ) ) {
							$textStyle[] = sprintf( 'margin-bottom:%dpx;', $marginBottom );
						}
						$atts = [];
						if ( ! empty( $textStyle ) ) {
							$atts['style'] = sprintf( '%s', esc_attr( implode( '', $textStyle ) ) );
						}


						$markerCustomFields[] = [
							'id'       => $cf,
							'type'     => $cf_type,
							'name'     => $cfName,
							'atts'     => $atts,
							'showName' => $cf_show_name,
							'value'    => apply_filters( 'the_content', $custom_field_html )
						];
						break;
					case 'multiselect' :
						$cf_default            = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';
						$multiselect_default   = isset( $cf_default['multiselect'] ) ? $cf_default['multiselect'] : '';
						$textAlign             = isset( $cf_default['multiselect_align'] ) ? $cf_default['multiselect_align'] : 'left';
						$multiselectList       = ! empty( $multiselect_default ) ? explode( "\n", str_replace( "\r", "", $multiselect_default ) ) : '';
						$multiselectListNew    = [];
						$multiselectDefaultIds = [];
						if ( is_array( $multiselectList ) && ! empty( $multiselectList ) ) {
							foreach ( $multiselectList as $idSelectValue => $selectValue ) {
								$selectValueLabel = $selectValue;
								if ( empty( $selectValueLabel ) ) {
									continue;
								}

								if ( $selectValueLabel[0] === '"' && $selectValueLabel[ strlen( $selectValueLabel ) - 1 ] === '"' ) {
									$StrRepFirst             = substr( $selectValueLabel, 1 );
									$StrRepLast              = substr( $StrRepFirst, 0, - 1 );
									$selectValueLabel        = $StrRepLast;
									$multiselectDefaultIds[] = (int) $idSelectValue;
								}

								$multiselectListNew[] = [
									'label' => $selectValueLabel,
									'value' => (int) $idSelectValue
								];
							}

						}


						$custom_field_lock        = isset( $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} ) ? $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} : '';
						$lock_value_multiselect   = isset( $custom_field_lock['multiselect'] ) ? $custom_field_lock['multiselect'] : 'close';
						$custom_field_multiselect = isset( $custom_field['multiselect'] ) ? $custom_field['multiselect'] : '';
						if ( ! empty( $custom_field_multiselect ) && is_array( $custom_field_multiselect ) ) {
							foreach ( $custom_field_multiselect as &$multiselectCurrentId ) {
								$multiselectCurrentId = (int) $multiselectCurrentId;
							}
							unset( $multiselectCurrentId );
						}
						if ( 'close' === $lock_value_multiselect ) {
							$custom_field_multiselect = $multiselectDefaultIds;
						}

						$tags = [];
						if ( is_array( $multiselectListNew ) && ! empty( $multiselectListNew ) ) {
							foreach ( $multiselectListNew as $multiselectTag ) {
								if ( is_array( $custom_field_multiselect ) ) {
									if ( in_array( $multiselectTag['value'], $custom_field_multiselect, true ) ) {
										$tags[] = esc_html( $multiselectTag['label'] );
									}
								}
							}
						}

						$textStyle = [];

						if ( ! empty( $textAlign ) ) {
							$textStyle[] = sprintf( 'text-align:%s;', $textAlign );
						}


						switch ( $textAlign ) {
							case 'left' :
								$textAlign = 'flex-start';
								break;
							case 'right' :
								$textAlign = 'flex-end';
								break;
						}


						$atts = [];
						if ( ! empty( $textStyle ) ) {
							$atts['style'] = sprintf( '%s', esc_attr( implode( '', $textStyle ) ) );
						}

						$markerCustomFields[] = [
							'id'       => $cf,
							'type'     => $cf_type,
							'name'     => $cfName,
							'atts'     => $atts,
							'align'    => $textAlign,
							'showName' => $cf_show_name,
							'value'    => $tags
						];
						break;
					case 'line' :
						$cf_default = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';

						$margin_top_default    = isset( $cf_default['margin_top'] ) ? $cf_default['margin_top'] : '';
						$margin_bottom_default = isset( $cf_default['margin_bottom'] ) ? $cf_default['margin_bottom'] : '';

						$custom_field_lock = isset( $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} ) ? $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} : '';

						$lock_value_margin_top    = isset( $custom_field_lock['margin_top'] ) ? $custom_field_lock['margin_top'] : 'close';
						$lock_value_margin_bottom = isset( $custom_field_lock['margin_bottom'] ) ? $custom_field_lock['margin_bottom'] : 'close';

						$custom_field_margin_top    = isset( $custom_field['margin_top'] ) ? $custom_field['margin_top'] : '';
						$custom_field_margin_bottom = isset( $custom_field['margin_bottom'] ) ? $custom_field['margin_bottom'] : '';

						if ( 'close' === $lock_value_margin_top ) {
							$custom_field_margin_top = $margin_top_default;
						}

						if ( 'close' === $lock_value_margin_bottom ) {
							$custom_field_margin_bottom = $margin_bottom_default;
						}

						$lineColor = isset( $cf_default['line_color'] ) ? $cf_default['line_color'] : '';

						$lineStyle = [
							$custom_field_margin_top !== '' ? sprintf( 'margin-top:%dpx;', $custom_field_margin_top ) : '',
							$custom_field_margin_bottom !== '' ? sprintf( 'margin-bottom:%dpx;', $custom_field_margin_bottom ) : '',
							sprintf( 'background-color:%s;', $lineColor ),
						];

						$atts          = [];
						$atts['style'] = implode( ' ', $lineStyle );

						$markerCustomFields[] = [
							'id'       => $cf,
							'type'     => $cf_type,
							'name'     => $cfName,
							'showName' => $cf_show_name,
							'value'    => $atts
						];

						break;
					case 'link' :
					case 'email' :
					case 'phone' :
					case 'button' :
						$stype     = '';
						$fieldType = '';
						$urlKey    = '';
						$targetKey = 'target';
						if ( $cf_type === 'email' ) {
							$stype = $fieldType = $urlKey = 'email';
						} elseif ( $cf_type === 'phone' ) {
							$stype = $fieldType = $urlKey = 'tel';
						} elseif ( $cf_type === 'link' ) {
							$stype = $fieldType = $urlKey = 'url';
						} elseif ( $cf_type === 'button' ) {
							$stype     = 'btn';
							$urlKey    = 'btn_url';
							$targetKey = 'btn_target';
							$fieldType = 'url';
						}
						$key_default = $stype . '_label';

						$cf_default = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';

						$text_default   = isset( $cf_default[ $key_default ] ) ? $cf_default[ $key_default ] : '';
						$url_default    = isset( $cf_default[ $urlKey ] ) ? $cf_default[ $urlKey ] : '';
						$target_default = isset( $cf_default[ $targetKey ] ) ? $cf_default[ $targetKey ] : [];
						$target_default = is_array( $target_default ) ? reset( $target_default ) : $target_default;

						$custom_field_lock = isset( $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} ) ? $markerMetaData->{$cf_key . $destinationPrefix . '_lock'} : '';

						$lock_value_text   = isset( $custom_field_lock['text'] ) ? $custom_field_lock['text'] : 'close';
						$lock_value_url    = isset( $custom_field_lock['url'] ) ? $custom_field_lock['url'] : 'close';
						$lock_value_target = isset( $custom_field_lock[ $targetKey ] ) ? $custom_field_lock[ $targetKey ] : 'close';

						$custom_field_text   = isset( $custom_field['text'] ) ? $custom_field['text'] : '';
						$custom_field_url    = isset( $custom_field['url'] ) ? $custom_field['url'] : '';
						$custom_field_target = isset( $custom_field[ $targetKey ] ) ? $custom_field[ $targetKey ] : '';

						if ( 'close' === $lock_value_text ) {
							$custom_field_text = $text_default;
						}

						if ( 'close' === $lock_value_url ) {
							$custom_field_url = $url_default;
						}

						if ( 'close' === $lock_value_target ) {
							$custom_field_target = $target_default;
						}

						$href   = '';
						$target = false;
						if ( $cf_type === 'link' ) {
							if ( ! empty( $custom_field_target ) ) {
								$target = true;
							}
							$href = $custom_field_url;
						} elseif ( $cf_type === 'email' ) {
							$href = 'mailto:' . sanitize_email( $custom_field_url );
						} elseif ( $cf_type === 'phone' ) {
							$href = 'tel:' . $custom_field_url;
						} elseif ( $cf_type === 'button' ) {
							if ( ! empty( $custom_field_target ) ) {
								$target = true;
							}
							$href = $custom_field_url;
						}

						$class = 'link';
						$atts  = [];

						if ( $target ) {
							$atts['target'] = "_blank";
						}

						if ( $cf_type === 'button' ) {
							$class = 'button';

							$btnBgColor     = isset( $cf_default['btn_bg_color'] ) ? $cf_default['btn_bg_color'] : '#000';
							$btnTextColor   = isset( $cf_default['btn_text_color'] ) ? $cf_default['btn_text_color'] : '#fff';
							$btnIsFullWidth = isset( $cf_default['btn_fullwidth'] ) ? $cf_default['btn_fullwidth'] : [];
							$btnIsFullWidth = is_array( $btnIsFullWidth ) ? reset( $btnIsFullWidth ) : $btnIsFullWidth;

							$width = '';
							if ( ! empty( $btnIsFullWidth ) ) {
								$width = 'width:100%;';
							}
							$styleLine     = $width . ' background-color:' . $btnBgColor . '; color:' . $btnTextColor . ';';
							$atts['style'] = esc_attr( $styleLine );
						} else {
							$atts['data-align'] = isset( $cf_default[ $stype . '_align' ] ) ? $cf_default[ $stype . '_align' ] : 'left';
							if ( 'yes' === $cf_show_name ) {
								$atts['data-name-width'] = $nameWidth;
							}
						}

						//$atts['class'] =   esc_attr( $class );
						$atts['href']  = $href;
						$atts['title'] = esc_attr( $custom_field_text );


						$markerCustomFields[] = [
							'id'       => $cf,
							'type'     => 'link-universal',
							'name'     => $cfName,
							'subtype'  => $class,
							'showName' => $cf_show_name,
							'atts'     => $atts,
							'value'    => esc_html( $custom_field_text )
						];

						break;
					case 'text' :
						$cf_default = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';

						if ( is_array( $custom_field ) ) {
							$custom_field = isset( $custom_field['text'] ) ? $custom_field['text'] : '';
						}
						$textAlign         = isset( $cf_default['align'] ) ? $cf_default['align'] : 'left';
						$textSize          = isset( $cf_default['size'] ) ? $cf_default['size'] : '';
						$textFontWeight    = isset( $cf_default['weight'] ) ? $cf_default['weight'] : '';
						$textMarginTop     = isset( $cf_default['marginTop'] ) ? $cf_default['marginTop'] : '';
						$textMarginBottom  = isset( $cf_default['marginBottom'] ) ? $cf_default['marginBottom'] : '';
						$textAsMarkerTitle = isset( $cf_default['showTitle'] ) ? $cf_default['showTitle'] : false;
						$textAsMarkerTitle = $textAsMarkerTitle ? 'yes' : 'no';
						$textStyle         = [];
						if ( is_numeric( $textSize ) ) {
							$textStyle[] = sprintf( 'font-size:%dpx;', $textSize );
						}
						if ( is_numeric( $textFontWeight ) ) {
							$textStyle[] = sprintf( 'font-weight:%d;', $textFontWeight );
						}
						if ( is_numeric( $textMarginTop ) ) {
							$textStyle[] = sprintf( 'margin-top:%dpx;', $textMarginTop );
						}
						if ( is_numeric( $textMarginBottom ) ) {
							$textStyle[] = sprintf( 'margin-bottom:%dpx;', $textMarginBottom );
						}
						if ( ! empty( $textAlign ) ) {
							$textStyle[] = sprintf( 'text-align:%s;', $textAlign );
						}


						if ( $textAsMarkerTitle === 'yes' ) {
							$custom_field = get_the_title( $markerId );
							if ( $popupStyle === 'light' && $destination === '' ) {
								$textStyle[] = 'color:#000;';
							}
							if ( $popupStyle === 'dark' && $destination === '' ) {
								$textStyle[] = 'color:#fff;';
							}

							if ( $destination !== '' ) {
								$textStyle[] = 'color:#000;';
							}
						}


						$atts = [];
						if ( ! empty( $textStyle ) ) {
							$atts['style'] = sprintf( '%s', esc_attr( implode( '', $textStyle ) ) );
						}

						if ( 'yes' === $cf_show_name ) {
							$atts['data-name-width'] = $nameWidth;
						}

						$markerCustomFields[] = [
							'id'          => $cf,
							'type'        => $cf_type,
							'name'        => $cfName,
							'atts'        => $atts,
							'showAsTitle' => $textAsMarkerTitle,
							'showName'    => $cf_show_name,
							'value'       => strip_tags( $custom_field, '<br>' )
						];

						break;
					case 'category' :
						$cf_default = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';

						$textAlign        = isset( $cf_default['category_align'] ) ? $cf_default['category_align'] : 'left';
						$style            = isset( $cf_default['style'] ) ? $cf_default['style'] : 'text';
						$textSize         = isset( $cf_default['size'] ) ? $cf_default['size'] : '';
						$textFontWeight   = isset( $cf_default['weight'] ) ? $cf_default['weight'] : '';
						$textMarginTop    = isset( $cf_default['marginTop'] ) ? $cf_default['marginTop'] : '';
						$textMarginBottom = isset( $cf_default['marginBottom'] ) ? $cf_default['marginBottom'] : '';

						$textStyle = [];
						if ( is_numeric( $textSize ) ) {
							$textStyle[] = sprintf( 'font-size:%dpx;', $textSize );
						}
						if ( is_numeric( $textFontWeight ) ) {
							$textStyle[] = sprintf( 'font-weight:%d;', $textFontWeight );
						}
						if ( is_numeric( $textMarginTop ) ) {
							$textStyle[] = sprintf( 'margin-top:%dpx;', $textMarginTop );
						}
						if ( is_numeric( $textMarginBottom ) ) {
							$textStyle[] = sprintf( 'margin-bottom:%dpx;', $textMarginBottom );
						}


						if ( ! empty( $textAlign ) ) {
							$textStyle[] = sprintf( 'text-align:%s;', $textAlign );
						}
						if ( $style === 'tags' ) {
							switch ( $textAlign ) {
								case 'left' :
									$textAlign = 'flex-start';
									break;
								case 'right' :
									$textAlign = 'flex-end';
									break;
							}
						}


						$atts = [];
						if ( ! empty( $textStyle ) ) {
							$atts['style'] = sprintf( '%s', esc_attr( implode( '', $textStyle ) ) );
						}

						$terms = get_the_terms( $markerId, 'map-category' );
						$cats  = [];
						if ( ! empty( $terms ) ) {
							foreach ( $terms as $cur_term ) {
								if ( isset( $cur_term->name ) ) {
									$cats[] = esc_html( $cur_term->name );
								}
							}
						}


						$markerCustomFields[] = [
							'id'         => $cf,
							'type'       => $cf_type,
							'name'       => $cfName,
							'atts'       => $atts,
							'outputType' => $style,
							'showName'   => $cf_show_name,
							'align'      => $textAlign,
							'value'      => $style === 'tags' ? $cats : implode( ', ', $cats )
						];

						break;
					case 'separator' :
						$atts = [];

						$atts['style'] = 'height:' . esc_attr( $custom_field ) . 'px;';

						$markerCustomFields[] = [
							'id'       => $cf,
							'type'     => $cf_type,
							'name'     => $cfName,
							'showName' => $cf_show_name,
							'value'    => $atts
						];
						break;
					case 'true_false' :
						$cf_default              = isset( $cf_meta->{$cf_key} ) ? $cf_meta->{$cf_key} : '';
						$true_false_default      = isset( $cf_default['true_false'] ) ? $cf_default['true_false'] : [];
						$true_false_default      = is_array( $true_false_default ) ? reset( $true_false_default ) : $true_false_default;
						$lock_value_true_false   = isset( $custom_field_lock['true_false'] ) ? $custom_field_lock['true_false'] : 'close';
						$custom_field_true_false = isset( $custom_field['true_false'] ) ? $custom_field['true_false'] : '';
						if ( 'close' === $lock_value_true_false ) {
							$custom_field_true_false = $true_false_default;
						}

						$checked = 'no';
						if ( ! empty( $custom_field_true_false ) ) {
							$checked = 'yes';
						}
						$markerCustomFields[] = [
							'id'       => $cf,
							'type'     => $cf_type,
							'name'     => $cfName,
							'showName' => $cf_show_name,
							'value'    => $checked
						];

						break;
				}
			}
		}
	}

	return $markerCustomFields;
}

function twerGetCustomFieldsForMarkers( array $markerIds, string $destination = '' ): array {
	$markerCustomFields = [];
	if ( ! empty( $markerIds ) ) {
		foreach ( $markerIds as $markerId ) {
			$markerCustomFields[ $markerId ] = twerGetCustomFieldsForMarker( $markerId, $destination );
		}
	}

	return $markerCustomFields;
}

function twerGetDefaultCustomFieldNameWidth() {
	return apply_filters( 'twerSetDefaultCustomFieldNameWidth', 35 );
}


function twerOutputSvgSprites() {
	twer_get_template( 'svg-sprites.php' );
}


function twerStoreLocatorGetSidebarPosition( int $mapId = 0 ): string {
	$mapId             = empty( $mapId ) ? twer_get_map_id() : $mapId;
	$defaultPosition   = 'left';
	$metaValuePosition = twer_get_meta( 'store_locator_sidebar_position', $mapId );

	return empty( $metaValuePosition ) ? $defaultPosition : $metaValuePosition;
}

function twerGetStoreLocatorSidebarOpenButtonPosition(int $mapId = 0 ) : string {
	$mapId             = empty( $mapId ) ? twer_get_map_id() : $mapId;
	$defaultPosition   = 'middle';
	$metaValuePosition = twer_get_meta( 'store_locator_sidebar_open_button_position', $mapId );
	return empty( $metaValuePosition ) ? $defaultPosition : $metaValuePosition;
}

function twerStoreLocatorGetSidebarClass( string $cssClass = '' ): array {
	$classes = [ 'twer-map-wrap__cell twer-store-locator-panel' ];

	if ( twerIsStoreLocatorSidebarCloseByDefault() ) {
		$classes[] = 'close';
	}

	$classes[] = sprintf( 'twer-store-locator-panel--%s', twerStoreLocatorGetSidebarPosition() );

	$classes = array_map( 'esc_attr', $classes );


	$classes = apply_filters( 'twerStoreLocatorSetSidebarClass', $classes, $cssClass );

	return array_unique( $classes );
}

function twerStoreLocatorSidebarClass( string $cssClass = '' ): void {
	// Separates class names with a single space, collates class names for body element.
	echo 'class="' . esc_attr( implode( ' ', twerStoreLocatorGetSidebarClass( $cssClass ) ) ) . '"';
}
