<?php
/**
 * Treweler Core Functions
 * General core functions available on both the front-end and admin.
 *
 * @package Treweler\Functions
 * @version 0.23
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Include core functions (available in both admin and frontend).
require TWER_ABSPATH . 'includes/twer-conditional-functions.php';
require TWER_ABSPATH . 'includes/twer-formatting-functions.php';

function twerGetTemplateIdForPost( int $postId = null ): int {
	global $post;
	$postId = $postId ?? $post->ID;

	$templateId = get_post_meta( $postId, '_treweler_templates', true );

	return $templateId === 'none' ? 0 : (int) $templateId;
}

function twerGetDefaultMapStyle() : string {
    return apply_filters('twerSetDefaultMapStyle', 'mapbox://styles/mapbox/standard-beta');
}
function twerIsPostTemplateApplied( int $postId = null ): string {
	global $post;
	$postId = $postId ?? $post->ID;

	$templateId = twerGetTemplateIdForPost( $postId );

	return empty( $templateId ) || 'publish' !== get_post_status( $templateId ) ? 'no' : 'yes';
}

function twerGetUniqueCustomFieldsIds( $postId, $ignoreNotEditableFields = true ) {
	if ( 'none' === $postId || empty( $postId ) || 'publish' !== get_post_status( $postId ) ) {
		return false;
	}

	$customFieldsPositions   = [ 'popup', 'locator_preview', 'locator' ];
	$templateCustomFieldsIds = [];
	foreach ( $customFieldsPositions as $customFieldsListNamePostfix1 ) {
		$prefix1 = '';
		if ( $customFieldsListNamePostfix1 !== 'popup' ) {
			$prefix1 = '_' . $customFieldsListNamePostfix1;
		}

		$meta            = get_post_meta( $postId, '_treweler_custom_fields_list' . $prefix1, true );
		$customFieldsIds = ! empty( $meta ) ? array_map( 'intval', explode( ',', $meta ) ) : [];

		if ( ! empty( $customFieldsIds ) ) {
			foreach ( $customFieldsIds as $customFieldId ) {

				if ( $ignoreNotEditableFields && ( 'category' === twerGetCustomFieldType( $customFieldId ) || 'yes' === twerIsCustomFieldTextShowAsTitle( $customFieldId ) ) ) {
					continue;
				}
				$templateCustomFieldsIds[] = $customFieldId;
			}
		}
	}

	return array_values( array_unique( $templateCustomFieldsIds, SORT_NUMERIC ) );
}


function template_locks( $current_template, $field, $lock_meta ) {
	if ( TWER_IS_FREE ) {
		return;
	}
	?>
    <div class="twer-defaults js-twer-defaults <?php echo $current_template === 'none' || 'publish' !== get_post_status( $current_template ) ? 'd-none' : ''; ?>" style="right:0;">
		<?php
		if ( $field['type'] === 'group' || $field['type'] === 'group_simple' ) {
			foreach ( $field['value'] as $group_field ) {
				$lock_input = '<input type="hidden" name="%s" value="%s">';
				$lock_link  = '<a href="#" class="twer-lock js-twer-lock-default %s" title="">%s</a>';

				$lock_name      = strpos( $group_field['name'], '_treweler_' ) !== false ? $group_field['name'] . '_lock' : $field['name'] . '_' . $group_field['name'] . '_lock';
				$lock_meta_name = str_replace( '_treweler_', '', $lock_name );

				if ( $current_template === 'none' ) {
					$lock_value = 'open';
				} else {
					$lock_value = isset( $lock_meta->$lock_meta_name ) ? $lock_meta->$lock_meta_name : 'close';
				}

				$lock_input = sprintf( $lock_input, $lock_name, $lock_value );
				echo sprintf( $lock_link, 'twer-lock--' . $lock_value, $lock_input );
			}
		} else {
			$lock_input     = '<input type="hidden" name="%s" value="%s">';
			$lock_link      = '<a href="#" class="twer-lock js-twer-lock-default %s" title="">%s</a>';
			$lock_name      = $field['name'] . '_lock';
			$lock_meta_name = str_replace( '_treweler_', '', $lock_name );

			if ( $current_template === 'none' ) {
				$lock_value = 'open';
			} else {
				$lock_value = isset( $lock_meta->$lock_meta_name ) ? $lock_meta->$lock_meta_name : 'close'; // $lock_meta->$lock_meta_name; //
			}

			$lock_input = sprintf( $lock_input, $lock_name, $lock_value );
			echo sprintf( $lock_link, 'twer-lock--' . $lock_value, $lock_input );
		} ?>
    </div>
	<?php
}


function twerIsMarkerHasCustomFieldId( int $markerId, int $fieldId ): string {
  if ( 'yes' === twerIsPostTemplateApplied( $markerId ) ) {
    $templateId = twerGetTemplateIdForPost( $markerId );
    $customFieldsIds = twerGetUniqueCustomFieldsIds( $templateId );
  } else {
    $customFieldsIds = twerGetUniqueCustomFieldsIds( $markerId );
  }

  return in_array( $fieldId, $customFieldsIds, true ) ? 'yes' : 'no';
}

function template_meta_diff( $data ) {
  $new_data = [];
  foreach ( $data as $data_key => $data_item ) {
    switch ( $data_key ) {
      case 'label_marker_hide' :
        $new_data['marker_hide'] = $data_item;
        break;
      case 'label_weight' :
        $new_data['label_font_weight'] = $data_item;
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
        $new_data['popup_open_group']['open_on'] = $data_item['action'];
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
        $new_data['dot_icon_size'] = $data_item['size'];
        break;
      case 'dot' :
        $new_data['marker_dotcenter_color'] = $data_item['color'];
        $new_data['marker_size'] = $data_item['size'];
        break;
      case 'dot_border' :
        $new_data['marker_border_color'] = $data_item['color'];
        $new_data['marker_border_width'] = $data_item['size'];
        break;
      case 'dot_corner_radius' :
        $new_data['marker_corner_radius'] = $data_item['size'];
        $new_data['marker_corner_radius_units'] = $data_item['units'];
        break;
      case 'balloon_icon_show' :
        $new_data['picker'] = $data_item;
        break;
      case 'balloon_icon' :
        $new_data['balloon_icon_color'] = $data_item['color'];
        $new_data['balloon_icon_size'] = $data_item['size'];
        break;
      case 'balloon' :
        $new_data['marker_color_balloon'] = $data_item['color'];
        $new_data['marker_size_balloon'] = $data_item['size'];
        break;
      case 'balloon_border' :
        $new_data['marker_border_color_balloon'] = $data_item['color'];
        $new_data['marker_border_width_balloon'] = $data_item['size'];
        break;
      case 'balloon_dot' :
        $new_data['marker_dot_color'] = $data_item['color'];
        $new_data['marker_dot_size'] = $data_item['size'];
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
        $new_data['thumbnail_id'] = $data_item;
        break;
      case 'custom_marker_position' :
        $new_data['marker_position'] = $data_item;
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

function template_apply( $fields, $meta_data, $template_data, $params = [] ) {
	if ( TWER_IS_FREE ) {
		return $fields;
	}

	$current_template = isset( $meta_data->templates ) ? $meta_data->templates : 'none';

	if ( 'none' !== $current_template ) {
		if ( 'publish' === get_post_status( $current_template ) ) {
			foreach ( $fields as &$field ) {
				if ( $field['type'] === 'group' || $field['type'] === 'group_simple' ) {
					$field['value'] = template_apply( $field['value'], $meta_data, $template_data, [ 'is_group' => true, 'group_name' => $field['name'] ] );
				} else {
					$group_name = isset( $params['group_name'] ) ? $params['group_name'] : '';
					$is_group   = isset( $params['is_group'] ) ? $params['is_group'] : false;
					$format     = strpos( $field['name'], '_treweler_' ) !== false && $is_group ? 'old' : 'new';

					if ( 'old' === $format && $is_group ) {
						$meta_key       = str_replace( '_treweler_', '', $field['name'] );
						$template_value = isset( $template_data->$meta_key ) ? $template_data->$meta_key : '';
						$lock_name      = $meta_key . '_lock';
						$lock_value     = isset( $meta_data->$lock_name ) ? $meta_data->$lock_name : '';
					} else if ( 'new' === $format && $is_group ) {
						$meta_name  = $is_group ? [ $group_name => $field['name'] ] : [ $field['name'] => '' ];
						$meta_key   = str_replace( '_treweler_', '', array_keys( $meta_name )[0] );
						$meta_value = reset( $meta_name );

						$template_value = isset( $template_data->$meta_key[ $meta_value ] ) ? $template_data->$meta_key[ $meta_value ] : '';

						$lock_name  = $meta_key . '_' . $meta_value . '_lock';
						$lock_value = isset( $meta_data->$lock_name ) ? $meta_data->$lock_name : 'close';
					} else {
						$meta_key       = str_replace( '_treweler_', '', $field['name'] );
						$template_value = isset( $template_data->$meta_key ) ? $template_data->$meta_key : '';
						$lock_name      = $meta_key . '_lock';
						$lock_value     = isset( $meta_data->$lock_name ) ? $meta_data->$lock_name : 'close';
					}


					if ( is_array( $template_value ) && $field['type'] === 'checkbox' ) {
						$template_value = reset( $template_value );
					}

					$atts = [ 'data-default="' . $template_value . '"' ];

					if ( $field['type'] === 'image_custom' ) {
						$attachment = wp_get_attachment_image_src( $template_value, 'full' );
						$attachment = isset( $attachment[0] ) ? $attachment[0] : $template_value;
						$atts       = [ 'data-default="' . $attachment . '"' ];
					}

					if ( 'close' === $lock_value ) {
						$atts[] = 'data-readonly="true"';
						switch ( $field['type'] ) {
							case 'checkbox' :
								$field['value'][0]['checked'] = $template_value;
								break;
							case 'select' :
								foreach ( $field['value'] as $select_key => $select_value ) {
									if ( $select_value['value'] === $template_value ) {
										$field['value'][ $select_key ]['selected'] = true;
									} else {
										$field['value'][ $select_key ]['selected'] = false;
									}
								}
								break;
							case 'image_custom' :
								$attachment     = wp_get_attachment_image_src( $template_value, 'full' );
								$field['value'] = isset( $attachment[0] ) ? $attachment[0] : $template_value;
								$atts           = [ 'data-default="' . $field['value'] . '"', 'data-readonly="true"' ];
								break;
							case 'text' :
							case 'url' :
							case 'textarea' :
							case 'colorpicker_default' :
							case 'colorpicker' :
							case 'picker' :
							case 'gallery' :
								$field['value'] = $template_value;
								break;
						}
					}

					if ( ! empty( $atts ) ) {
						$field['data_template'] = $atts;
					}


				}
			}
		}
	}

	return $fields;
}

function fill_custom_fields( $includes_custom_fields_posts, $prefix, $meta_data, $hidden = false, $customFieldsListNamePostfix = '', $locksBehaviour = 'default' ) {
	$current_custom_fields = [];
	if ( ! empty( $includes_custom_fields_posts ) ) {
		foreach ( $includes_custom_fields_posts as $field_post ) {
			$field_post_ID    = isset( $field_post->ID ) ? $field_post->ID : 0;
			$field_post_title = isset( $field_post->post_title ) ? $field_post->post_title : '';
			$meta             = twer_get_data( $field_post_ID );

			$field_post_type = isset( $meta->custom_field_type ) ? $meta->custom_field_type : 'text';
			$field_post_key  = isset( $meta->custom_field_key ) ? $meta->custom_field_key : 'field-1488228';
			//$field_post_show = isset($meta->custom_field_show) ? $meta->custom_field_show : '';


			$tr_class = ! $hidden ? 'js-ui-slider-item' : 'js-hidden-item d-none';
			$disabled = ! $hidden ? '' : 'disabled';
			switch ( $field_post_type ) {
				case 'separator' :
					$default = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : '';
					$current = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value = $locksBehaviour;
					} else {
						$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : 'close';
					}

					if ( ! $hidden && empty( $lock_value ) ) {
						$lock_value = 'open';
					}

					if ( ! $hidden && 'close' === $lock_value && $default !== $current ) {
						$current = $default;
					}

					$current_custom_fields[] = [
						'tr-class'    => $tr_class,
						'tr-id'       => $field_post_ID,
						'label'       => $field_post_title,
						'type'        => 'number',
						'postfix'     => 'px',
						'size'        => 'small-2',
						'placeholder' => '0',
						'id'          => uniqid( 'separator-' ),
						'disabled'    => $disabled,
						'readonly'    => $lock_value === 'open' ? '' : 'readonly',
						'lock_fields' => 1,
						'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock',
						'lock_value'  => $lock_value,
						'lock_open'   => $lock_value === 'open',
						'data_atts'   => 'min="0" step="1" data-default="' . $default . '" data-current=""',
						'name'        => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'value'       => $current,
					];
					break;
				case 'html' :
					$default      = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : [];
					$html_default = isset( $default['html'] ) ? $default['html'] : '';

					$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value_html = $locksBehaviour;
					} else {
						$lock_value_html = isset( $lock_value['html'] ) ? $lock_value['html'] : 'close';
					}

					$html_current = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['html'] ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix}['html'] : '';

					if ( ! $hidden && empty( $lock_value_html ) ) {
						$lock_value_html = 'open';
					}

					if ( ! $hidden && 'close' === $lock_value_html && $html_default !== $html_current ) {
						$html_current = $html_default;
					}


					$value = [
						[
							'type'        => 'textarea',
							'name'        => 'html',
							'label'       => '',
							'lock_fields' => 1,
							'size'        => 'small-1',
							'id'          => uniqid( 'html-' ),
							'disabled'    => $disabled,
							'lock_open'   => $lock_value_html === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[html]',
							'lock_value'  => $lock_value_html,
							'readonly'    => $lock_value_html === 'open' ? '' : 'readonly',
							'data_atts'   => 'data-default="' . esc_attr( $html_default ) . '" data-current=""',
							'value'       => $html_current
						],
					];

					$current_custom_fields[] = [
						'tr-class'    => $tr_class . ' vert-top-align ',
						'tr-id'       => $field_post_ID,
						'lock_fields' => count( $value ),
						'type'        => 'group',
						'name'        => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'label'       => $field_post_title,
						'value'       => $value
					];

					break;
				case 'number' :
					$default        = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : [];
					$number_default = isset( $default['number'] ) ? $default['number'] : '';

					$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value_number = $locksBehaviour;
					} else {
						$lock_value_number = isset( $lock_value['number'] ) ? $lock_value['number'] : 'close';
					}

					$number_current = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['number'] ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix}['number'] : '';

					if ( ! $hidden && empty( $lock_value_number ) ) {
						$lock_value_number = 'open';
					}

					if ( ! $hidden && 'close' === $lock_value_number && $number_default !== $number_current ) {
						$number_current = $number_default;
					}

					$number_default = str_replace( ',', '.', $number_default );

					$value = [
						[
							'type'        => 'number',
							'name'        => 'number',
							'label'       => '',
							'lock_fields' => 1,
							'id'          => uniqid( 'number-' ),
							'disabled'    => $disabled,
							'lock_open'   => $lock_value_number === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[number]',
							'lock_value'  => $lock_value_number,
							'readonly'    => $lock_value_number === 'open' ? '' : 'readonly',
							'data_atts'   => 'step="any" data-default="' . $number_default . '" data-current=""',
							'value'       => str_replace( ',', '.', $number_current )
						],
					];

					$current_custom_fields[] = [
						'tr-class'    => $tr_class,
						'tr-id'       => $field_post_ID,
						'lock_fields' => count( $value ),
						'type'        => 'group',
						'name'        => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'label'       => $field_post_title,
						'value'       => $value
					];

					break;
				case 'multiselect' :
					$default             = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : [];
					$multiselect_default = isset( $default['multiselect'] ) ? $default['multiselect'] : '';
					$multiselectList     = ! empty( $multiselect_default ) ? explode( "\n", str_replace( "\r", "", $multiselect_default ) ) : [];
					$multiselectListNew  = [];

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
								'label'    => $selectValueLabel,
								'selected' => false,
								'value'    => (int) $idSelectValue
							];
						}
					}

					$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value_multiselect = $locksBehaviour;
					} else {
						$lock_value_multiselect = isset( $lock_value['multiselect'] ) ? $lock_value['multiselect'] : 'close';
					}


					if ( ! $hidden && empty( $lock_value_multiselect ) ) {
						$lock_value_multiselect = 'open';
					}

					$multiselectCurrentIds = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['multiselect'] ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix}['multiselect'] : [];

					if ( ! empty( $multiselectCurrentIds ) ) {
						foreach ( $multiselectCurrentIds as &$multiselectCurrentId ) {
							$multiselectCurrentId = (int) $multiselectCurrentId;
						}
						unset( $multiselectCurrentId );
					}

					if ( ! $hidden && 'close' === $lock_value_multiselect && $multiselectCurrentIds !== $multiselectDefaultIds ) {
						$multiselectCurrentIds = $multiselectDefaultIds;
					}


					if ( is_array( $multiselectListNew ) && ! empty( $multiselectListNew ) ) {
						foreach ( $multiselectListNew as &$multiselectOption ) {

							if ( is_array( $multiselectCurrentIds ) && ! empty( $multiselectCurrentIds ) ) {
								if ( in_array( $multiselectOption['value'], $multiselectCurrentIds, true ) ) {
									$multiselectOption['selected'] = true;
								}
							}
						}
						unset( $multiselectOption );
					}


					$value = [
						[
							'type'          => 'select',
							'name'          => 'multiselect',
							'id'            => uniqid( 'multiselect-' ),
							'class'         => [ 'js-field-multiselect' ],
							'label'         => '',
							'lock_fields'   => 1,
							'disabled'      => $disabled,
							'lock_open'     => $lock_value_multiselect === 'open',
							'lock_name'     => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[multiselect]',
							'lock_value'    => $lock_value_multiselect,
							'readonly'      => $lock_value_multiselect === 'open' ? '' : 'readonly',
							'data_atts'     => 'multiple data-default="' . htmlspecialchars( json_encode( $multiselectDefaultIds ) ) . '" data-current=""',
							'value'         => $multiselectListNew,
							'isMultiselect' => true
						],
					];

					$current_custom_fields[] = [
						'tr-class'    => $tr_class,
						'tr-id'       => $field_post_ID,
						'lock_fields' => count( $value ),
						'type'        => 'group',
						'name'        => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'label'       => $field_post_title,
						'value'       => $value
					];


					break;
				case 'line' :
					$default               = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : [];
					$margin_top_default    = isset( $default['margin_top'] ) ? $default['margin_top'] : '';
					$margin_bottom_default = isset( $default['margin_bottom'] ) ? $default['margin_bottom'] : '';

					$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value_margin_top    = $locksBehaviour;
						$lock_value_margin_bottom = $locksBehaviour;
					} else {
						$lock_value_margin_top    = isset( $lock_value['margin_top'] ) ? $lock_value['margin_top'] : 'close';
						$lock_value_margin_bottom = isset( $lock_value['margin_bottom'] ) ? $lock_value['margin_bottom'] : 'close';
					}

					$margin_top_current    = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['margin_top'] ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix}['margin_top'] : '';
					$margin_bottom_current = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['margin_bottom'] ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix}['margin_bottom'] : '';

					if ( ! $hidden && empty( $lock_value_margin_top ) ) {
						$lock_value_margin_top = 'open';
					}

					if ( ! $hidden && empty( $lock_value_margin_bottom ) ) {
						$lock_value_margin_bottom = 'open';
					}

					if ( ! $hidden && 'close' === $lock_value_margin_top && $margin_top_default !== $margin_top_current ) {
						$margin_top_current = $margin_top_default;
					}
					if ( ! $hidden && 'close' === $lock_value_margin_bottom && $margin_bottom_default !== $margin_bottom_current ) {
						$margin_bottom_current = $margin_bottom_default;
					}

					$value = [
						[
							'type'        => 'number',
							'name'        => 'margin_top',
							'label'       => '',
							'lock_fields' => 1,
							'id'          => uniqid( 'line-margin-top', true ),
							'disabled'    => $disabled,
							'postfix'     => 'px',
							'lock_open'   => $lock_value_margin_top === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[margin_top]',
							'lock_value'  => $lock_value_margin_top,
							'readonly'    => $lock_value_margin_top === 'open' ? '' : 'readonly',
							'placeholder' => '14',
							'data_atts'   => 'step="1" data-default="' . $margin_top_default . '" data-current=""',
							'value'       => $margin_top_current
						],
						[
							'type'        => 'number',
							'name'        => 'margin_bottom',
							'disabled'    => $disabled,
							'postfix'     => 'px',
							'label'       => '',
							'lock_fields' => 1,
							'id'          => uniqid( 'line-margin-bottom', true ),
							'lock_open'   => $lock_value_margin_bottom === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[margin_bottom]',
							'lock_value'  => $lock_value_margin_bottom,
							'readonly'    => $lock_value_margin_bottom === 'open' ? '' : 'readonly',
							'placeholder' => '14',
							'data_atts'   => 'step="1" data-default="' . $margin_bottom_default . '" data-current=""',
							'value'       => $margin_bottom_current
						],
					];

					$current_custom_fields[] = [
						'tr-class'    => $tr_class,
						'tr-id'       => $field_post_ID,
						'lock_fields' => count( $value ),
						'type'        => 'group',
						'name'        => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'label'       => $field_post_title,
						'value'       => $value
					];

					break;
				case 'text' :
					$default           = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : '';
					$showAsMarkerTitle = false;
					if ( is_array( $default ) ) {
						$showAsMarkerTitle = isset( $default['showTitle'] ) ? $default['showTitle'] : '';
						$showAsMarkerTitle = is_array( $showAsMarkerTitle ) ? reset( $showAsMarkerTitle ) : $showAsMarkerTitle;
						$default           = isset( $default['text'] ) ? $default['text'] : '';
					}

					$current = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value = $locksBehaviour;
					} else {
						$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : 'close';
					}

					if ( ! $hidden && empty( $lock_value ) ) {
						$lock_value = 'open';
					}


					if ( ! $hidden && 'close' === $lock_value && $default !== $current ) {
						$current = $default;
					}

					$current_custom_fields[] = [
						'tr-class'     => $tr_class,
						'tr-id'        => $field_post_ID,
						'label'        => $field_post_title,
						'type'         => 'textarea',
						'size'         => 'small-1',
						'id'           => uniqid( 'text-' ),
						'classFieldTh' => $showAsMarkerTitle ? 'hide-lock' : 'vert-top-align',
						'lock_fields'  => 1,
						'lock_name'    => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock',
						'lock_value'   => $lock_value,
						'lock_open'    => $lock_value === 'open',
						'disabled'     => $disabled,
						'readonly'     => $lock_value === 'open' ? '' : 'readonly',
						'data_atts'    => 'data-default="' . $default . '" data-current=""',
						'name'         => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'class'        => $showAsMarkerTitle ? 'hide-field' : '',
						'value'        => $current,
					];
					break;
				case 'category' :
					$default = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : '';
					if ( is_array( $default ) ) {
						$default = isset( $default['style'] ) ? $default['style'] : '';
					}

					$current = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value = $locksBehaviour;
					} else {
						$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : 'close';
					}

					if ( ! $hidden && empty( $lock_value ) ) {
						$lock_value = 'open';
					}


					if ( ! $hidden && 'close' === $lock_value && $default !== $current ) {
						$current = $default;
					}

					$current_custom_fields[] = [
						'tr-class'     => $tr_class,
						'tr-id'        => $field_post_ID,
						'label'        => $field_post_title,
						'type'         => 'textarea',
						'size'         => 'small-1',
						'id'           => uniqid( 'category-' ),
						'classFieldTh' => 'hide-lock',
						'lock_fields'  => 1,
						'lock_name'    => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock',
						'lock_value'   => $lock_value,
						'lock_open'    => $lock_value === 'open',
						'disabled'     => $disabled,
						'readonly'     => $lock_value === 'open' ? '' : 'readonly',
						'data_atts'    => 'data-default="' . $default . '" data-current=""',
						'name'         => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'class'        => 'hide-field',
						'value'        => $current,
					];
					break;
				case 'true_false' :
					$default            = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : [];
					$true_false_default = isset( $default['true_false'] ) ? $default['true_false'] : [];
					$true_false_default = is_array( $true_false_default ) ? reset( $true_false_default ) : $true_false_default;

					$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value_true_false = $locksBehaviour;
					} else {
						$lock_value_true_false = isset( $lock_value['true_false'] ) ? $lock_value['true_false'] : 'close';
					}
					$true_false_current = in_array( 'true_false', isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['true_false'] ) ? (array) $meta_data->{$field_post_key . $customFieldsListNamePostfix}['true_false'] : [] );

					if ( ! $hidden && empty( $lock_value_true_false ) ) {
						$lock_value_true_false = 'open';
					}

					if ( ! $hidden && 'close' === $lock_value_true_false && $true_false_default !== $true_false_current ) {
						$true_false_current = $true_false_default;
					}

					$value = [
						[
							'type'        => 'checkbox',
							'name'        => 'true_false',
							'disabled'    => $disabled,
							'lock_fields' => 1,
							'id'          => uniqid( 'true-false-' ),
							'lock_open'   => $lock_value_true_false === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[true_false]',
							'lock_value'  => $lock_value_true_false,
							'readonly'    => $lock_value_true_false === 'open' ? '' : 'readonly',
							'data_atts'   => 'data-default="' . $true_false_default . '" data-current=""',
							'value'       => [
								[
									'label'   => '',
									'checked' => $true_false_current,
									'value'   => 'true_false'
								]
							]
						]
					];

					$current_custom_fields[] = [
						'tr-class'    => $tr_class,
						'tr-id'       => $field_post_ID,
						'lock_fields' => count( $value ),
						'type'        => 'group',
						'name'        => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'label'       => $field_post_title,
						'value'       => $value
					];

					break;
				case 'email' :
				case 'link' :
				case 'phone' :
				case 'button' :
					$default = isset( $meta->{$field_post_key} ) ? $meta->{$field_post_key} : [];

					$text_placeholder = esc_html__( 'URL', 'treweler' );
					$stype            = '';
					$fieldType        = '';
					$urlKey           = '';
					$targetKey        = 'target';
					if ( $field_post_type === 'email' ) {
						$stype            = $fieldType = $urlKey = 'email';
						$text_placeholder = esc_html__( 'Email', 'treweler' );
					} elseif ( $field_post_type === 'phone' ) {
						$stype            = $fieldType = $urlKey = 'tel';
						$text_placeholder = esc_html__( 'Phone Number', 'treweler' );
					} elseif ( $field_post_type === 'link' ) {
						$stype = $fieldType = $urlKey = 'url';
					} elseif ( $field_post_type === 'button' ) {
						$stype     = 'btn';
						$urlKey    = 'btn_url';
						$targetKey = 'btn_target';
						$fieldType = 'url';
					}
					$key_default = $stype . '_label';


					$text_default   = isset( $default[ $key_default ] ) ? $default[ $key_default ] : '';
					$url_default    = isset( $default[ $urlKey ] ) ? $default[ $urlKey ] : '';
					$target_default = isset( $default[ $targetKey ] ) ? $default[ $targetKey ] : [];
					$target_default = is_array( $target_default ) ? reset( $target_default ) : $target_default;

					$lock_value = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix . '_lock'} : '';

					if ( $locksBehaviour !== 'default' ) {
						$lock_value_text   = $locksBehaviour;
						$lock_value_url    = $locksBehaviour;
						$lock_value_target = $locksBehaviour;
					} else {
						$lock_value_text   = isset( $lock_value['text'] ) ? $lock_value['text'] : 'close';
						$lock_value_url    = isset( $lock_value['url'] ) ? $lock_value['url'] : 'close';
						$lock_value_target = isset( $lock_value[ $targetKey ] ) ? $lock_value[ $targetKey ] : 'close';
					}


					$text_current   = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['text'] ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix}['text'] : '';
					$url_current    = isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}['url'] ) ? $meta_data->{$field_post_key . $customFieldsListNamePostfix}['url'] : '';
					$target_current = false;
					if ( $field_post_type === 'link' ) {
						$target_current = in_array( 'target', isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}[ $targetKey ] ) ? (array) $meta_data->{$field_post_key . $customFieldsListNamePostfix}[ $targetKey ] : [] );
					} elseif ( $field_post_type === 'button' ) {
						$target_current = in_array( 'btn_target', isset( $meta_data->{$field_post_key . $customFieldsListNamePostfix}[ $targetKey ] ) ? (array) $meta_data->{$field_post_key . $customFieldsListNamePostfix}[ $targetKey ] : [] );
					}


					if ( ! $hidden && empty( $lock_value_text ) ) {
						$lock_value_text = 'open';
					}

					if ( ! $hidden && empty( $lock_value_url ) ) {
						$lock_value_url = 'open';
					}

					if ( ! $hidden && empty( $lock_value_target ) ) {
						$lock_value_target = 'open';
					}

					if ( ! $hidden && 'close' === $lock_value_text && $text_default !== $text_current ) {
						$text_current = $text_default;
					}
					if ( ! $hidden && 'close' === $lock_value_url && $url_default !== $url_current ) {
						$url_current = $url_default;
					}
					if ( ! $hidden && 'close' === $lock_value_target && $target_default !== $target_current ) {
						$target_current = $target_default;
					}

					$value = [
						[
							'type'        => 'text',
							'name'        => 'text',
							'label'       => '',
							'lock_fields' => 1,
							'disabled'    => $disabled,
							'lock_open'   => $lock_value_text === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[text]',
							'lock_value'  => $lock_value_text,
							'id'          => uniqid( 'group-', true ),
							'readonly'    => $lock_value_text === 'open' ? '' : 'readonly',
							'placeholder' => esc_html__( 'Text', 'treweler' ),
							'data_atts'   => 'data-default="' . $text_default . '" data-current=""',
							'value'       => $text_current
						],
						[
							'type'        => $fieldType,
							'name'        => 'url',
							'disabled'    => $disabled,
							'label'       => '',
							'lock_fields' => 1,
							'lock_open'   => $lock_value_url === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[url]',
							'lock_value'  => $lock_value_url,
							'id'          => uniqid( 'group-', true ),
							'readonly'    => $lock_value_url === 'open' ? '' : 'readonly',
							'placeholder' => $text_placeholder,
							'data_atts'   => 'data-default="' . $url_default . '" data-current=""',
							'value'       => $url_current
						],
					];


					if ( $field_post_type === 'link' ) {
						$value[] = [
							'type'        => 'checkbox',
							'name'        => 'target',
							'place'       => 'inline',
							'disabled'    => $disabled,
							'lock_fields' => 1,
							'id'          => uniqid( 'group-', true ),
							'lock_open'   => $lock_value_target === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[target]',
							'lock_value'  => $lock_value_target,
							'readonly'    => $lock_value_target === 'open' ? '' : 'readonly',
							'data_atts'   => 'data-default="' . $target_default . '" data-current=""',
							'label'       => esc_html__( 'Open in new tab', 'treweler' ),
							'value'       => [
								[
									'label'   => '',
									'checked' => $target_current,
									'value'   => 'target'
								]
							]
						];
					} elseif ( $field_post_type === 'button' ) {
						$value[] = [
							'type'        => 'checkbox',
							'name'        => 'btn_target',
							'place'       => 'inline',
							'disabled'    => $disabled,
							'lock_fields' => 1,
							'id'          => uniqid( 'group-', true ),
							'lock_open'   => $lock_value_target === 'open',
							'lock_name'   => $prefix . $field_post_key . $customFieldsListNamePostfix . '_lock[btn_target]',
							'lock_value'  => $lock_value_target,
							'readonly'    => $lock_value_target === 'open' ? '' : 'readonly',
							'data_atts'   => 'data-default="' . $target_default . '" data-current=""',
							'label'       => esc_html__( 'Open in new tab', 'treweler' ),
							'value'       => [
								[
									'label'   => '',
									'checked' => $target_current,
									'value'   => 'btn_target'
								]
							]
						];
					}

					$current_custom_fields[] = [
						'tr-class'    => $tr_class,
						'tr-id'       => $field_post_ID,
						'lock_fields' => count( $value ),
						'type'        => 'group',
						'name'        => $prefix . $field_post_key . $customFieldsListNamePostfix,
						'label'       => $field_post_title,
						'value'       => $value
					];
					break;
			}
		}
	}

	return $current_custom_fields;
}



function twerGetCustomFieldIdBy( string $field, string $value ) {
	global $wpdb;

	switch ($field) {
		case 'key':
			$meta_key = '_treweler_custom_field_key';
			break;
		case 'type':
			$meta_key = '_treweler_custom_field_type';
			break;
		default:
			return [];
	}

	$query = $wpdb->prepare("
        SELECT p.ID 
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type = 'twer-custom-fields' 
        AND pm.meta_key = %s 
        AND pm.meta_value = %s
    ", $meta_key, $value);

	return $field === 'key' ? $wpdb->get_var($query) : $wpdb->get_col($query);
}

function twerGetCustomFieldType( $fieldId ) {
	return get_post_meta( $fieldId, '_treweler_custom_field_type', true );
}

function twerGetCustomFieldKey( $fieldId ) {
	return get_post_meta( $fieldId, '_treweler_custom_field_key', true );
}


function twerGetShowNameStatusForCustomField( $fieldId ) {
	$showNameStatus = get_post_meta( $fieldId, '_treweler_custom_field_show', true );

	return twerGetNormalMetaCheckboxValue( $showNameStatus );
}

function twerGetWidthFieldName( $fieldId ) {
	$width = get_post_meta( $fieldId, '_treweler_custom_field_name_width', true );

	return empty( $width ) && ! is_numeric( $width ) ? twerGetDefaultCustomFieldNameWidth() : (int) $width;
}

function twerGetCustomFieldAllDefaultData( $fieldId ) {
	$fieldKey = twerGetCustomFieldKey( $fieldId );

	return get_post_meta( $fieldId, '_treweler_' . $fieldKey, true );
}

function twerGetCustomFieldMultiselectData( int $fieldId ): array {
	$fieldData                        = twerGetCustomFieldAllDefaultData( $fieldId );
	$multiselectValue                 = ! empty( $fieldData['multiselect'] ) ? explode( "\n", str_replace( "\r", "", $fieldData['multiselect'] ) ) : [];
	$multiselectSelectedValues        = [];
	$multiselectCleanedValues         = [];
	$multiselectSelectedCleanedValues = [];
	if ( is_array( $multiselectValue ) && ! empty( $multiselectValue ) ) {
		foreach ( $multiselectValue as $id => $value ) {
			$selectValueLabel = $value;
			if ( empty( $selectValueLabel ) ) {
				continue;
			}
			if ( $selectValueLabel[0] === '"' && $selectValueLabel[ strlen( $selectValueLabel ) - 1 ] === '"' ) {
				$StrRepFirst                        = substr( $selectValueLabel, 1 );
				$StrRepLast                         = substr( $StrRepFirst, 0, - 1 );
				$selectValueLabel                   = $StrRepLast;
				$multiselectCleanedValues[]         = $selectValueLabel;
				$multiselectSelectedValues[]        = [
					'label' => $selectValueLabel,
					'value' => (int) $id
				];
				$multiselectSelectedCleanedValues[] = (int) $id;
			} else {
				$multiselectCleanedValues[] = $selectValueLabel;
			}
		}
	}

	return [
		'valueCleaned'    => $multiselectCleanedValues,
		'value'           => $multiselectValue,
		'selectedCleaned' => $multiselectSelectedCleanedValues,
		'selected'        => $multiselectSelectedValues
	];
}

function twerGetNormalMetaCheckboxValue( $metaValue ) {
	$result = '';
	if ( empty( $metaValue ) ) {
		$result = 'no';
	} elseif ( is_array( $metaValue ) ) {
		$result = 'yes';
	}

	return '' === $result ? $metaValue : $result;
}


function twerGetCustomFieldPost( int $fieldId ): array {
	$fieldData            = twerGetCustomFieldAllDefaultData( $fieldId );
	$fieldType            = twerGetCustomFieldType( $fieldId );
	$showName             = twerGetShowNameStatusForCustomField( $fieldId );
	$nameWidth            = 'yes' === $showName ? twerGetWidthFieldName( $fieldId ) : twerGetDefaultCustomFieldNameWidth();
	$defaultData          = [
		'showName' => $showName,
		'key'      => twerGetCustomFieldKey( $fieldId ),
		'name'     => get_the_title( $fieldId ),
		'type'     => $fieldType
	];
	$fieldDataBasedOfType = [];
	switch ( $fieldType ) {
		case 'text' :
			$fieldDataBasedOfType = [
				'align'         => $fieldData['align'] ?? 'left',
				'value'         => $fieldData['text'] ?? '',
				'size'          => $fieldData['size'] ?? 14,
				'weight'        => $fieldData['weight'] ?? 400,
				'marginTop'     => $fieldData['marginTop'] ?? 10,
				'marginBottom'  => $fieldData['marginBottom'] ?? 10,
				'nameWidth'     => $nameWidth,
				'outputAsTitle' => twerGetNormalMetaCheckboxValue( $fieldData['showTitle'] ?? 'no' )
			];
			break;
		case 'multiselect' :
			$fieldDataBasedOfType = twerGetCustomFieldMultiselectData( $fieldId );
			break;
		case 'number' :
			$fieldDataBasedOfType = [
				'prefix'    => $fieldData['prefix'] ?? '',
				'suffix'    => $fieldData['suffix'] ?? '',
				'nameWidth' => $nameWidth,
				'value'     => $fieldData['number'] ?? 0,
			];
			break;
		case 'true_false' :
			$fieldDataBasedOfType = [
				'value' => twerGetNormalMetaCheckboxValue( $fieldData['true_false'] ?? 'no' ),
			];
			break;
	}

	return apply_filters( 'twerSetCustomFieldEntry', wp_parse_args( $fieldDataBasedOfType, $defaultData ), $fieldId, $fieldData, $fieldType );
}


/**
 * Wrapper for _doing_it_wrong().
 *
 * @param string $function Function used.
 * @param string $message Message to log.
 * @param string $version Version the message was added in.
 *
 * @since  0.23
 */
function twer_doing_it_wrong( $function, $message, $version ) {
	// @codingStandardsIgnoreStart
	$message .= esc_html__( ' Backtrace: ', 'treweler' ) . wp_debug_backtrace_summary();

	if ( is_ajax() || TWER()->is_rest_api_request() ) {
		do_action( 'doing_it_wrong_run', $function, $message, $version );
		error_log( esc_html__( "{$function} was called incorrectly. {$message}. This message was added in version {$version}." ) );
	} else {
		_doing_it_wrong( $function, $message, $version );
	}
	// @codingStandardsIgnoreEnd
}


if ( ! function_exists( 'is_ajax' ) ) {

	/**
	 * Is_ajax - Returns true when the page is loaded via ajax.
	 *
	 * @return bool
	 */
	function is_ajax() {
		return function_exists( 'wp_doing_ajax' ) ? wp_doing_ajax() : defined( 'DOING_AJAX' );
	}
}

if ( ! function_exists( 'twer_clean' ) ) {
	/**
	 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
	 * Non-scalar values are ignored.
	 *
	 * @param string|array $var Data to sanitize.
	 *
	 * @return string|array
	 */
	function twer_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'twer_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

if ( ! function_exists( 'twer_get_data' ) ) {
	/**
	 * Parse all meta data and store it
	 *
	 * @param $post_id
	 * @param string $prefix
	 *
	 * @return object
	 */
	function twer_get_data( $post_id = null, $prefix = '_treweler_' ) {
		global $post;

		if ( empty( $post_id ) ) {
			$post_id = isset( $post->ID ) ? $post->ID : 0;
		}

		$post_meta = get_post_meta( $post_id );
		$meta_data = [];

		if ( 'publish' !== get_post_status( $post_id ) ) {
			return (object) $meta_data;
		}

		if ( $post_meta ) {
			foreach ( $post_meta as $meta_key => $meta_value ) {
				if ( strpos( $meta_key, $prefix ) !== false ) {

					if ( is_array( $meta_value ) && count( $meta_value ) === 1 ) {
						$meta_value = maybe_unserialize( reset( $meta_value ) );
					}
					$meta_data[ str_replace( $prefix, '', $meta_key ) ] = $meta_value;
				}
			}
		}

		return (object) $meta_data;
	}
}

/**
 * Define a constant if it is not already defined.
 *
 * @param string $name Constant name.
 * @param mixed $value Value.
 *
 * @since 1.03
 */
function twer_maybe_define_constant( $name, $value ) {
	if ( ! defined( $name ) ) {
		define( $name, $value );
	}
}

/**
 * Wrapper for nocache_headers which also disables page caching.
 *
 * @since 1.13
 */
function twer_nocache_headers() {
	TWER_Cache_Helper::set_nocache_constants();
	nocache_headers();
}

/**
 * Flushes rewrite rules when the map page (or it's children) gets saved.
 */
function flush_rewrite_rules_on_map_page_save() {
	$screen    = get_current_screen();
	$screen_id = $screen ? $screen->id : '';

	// Check if this is the edit page.
	if ( 'page' !== $screen_id ) {
		return;
	}

	// Check if page is edited.
	if ( empty( $_GET['post'] ) || empty( $_GET['action'] ) || ( isset( $_GET['action'] ) && 'edit' !== $_GET['action'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	$post_id = intval( $_GET['post'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$setMap  = get_post_meta( $post_id, '_treweler_cpt_dd_box_fullscreen', true );

	if ( ! empty( $setMap ) ) {
		do_action( 'treweler_flush_rewrite_rules' );
	}
}

add_action( 'admin_footer', 'flush_rewrite_rules_on_map_page_save' );


if ( ! function_exists( 'twer_get_meta' ) ) {
	/**
	 * Get meta data
	 *
	 * @param string $meta_name
	 * @param string|int $post_id
	 * @param string $prefix
	 *
	 * @return mixed
	 */
	function twer_get_meta( string $meta_name, int $post_id = 0, string $prefix = '_treweler_' ) {
		return get_post_meta( $post_id, $prefix . $meta_name, true );
	}
}


if ( ! function_exists( 'twer_get_api_key' ) ) {
	/**
	 * Get Mapbox API key
	 *
	 * @return mixed
	 */
	function twer_get_api_key() {
		$option = get_option( 'treweler' );

		return isset( $option['api_key'] ) ? $option['api_key'] : '';
	}
}

if ( ! function_exists( 'twer_is_valid_apikey' ) ) {
	/**
	 * Check if current API key is valid
	 *
	 * @return bool
	 */
	function twer_is_valid_apikey() {
		$option = get_option( 'treweler' );

		return empty( $option['api_key_invalid'] );
	}
}

if ( ! function_exists( 'twer_minify_html_markup' ) ) {
	/**
	 * Minify HTML markup
	 *
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	function twer_minify_html_markup( $text ) {
		$search = array(
			'/\>[^\S ]+/s',     // strip whitespaces after tags, except space
			'/[^\S ]+\</s',     // strip whitespaces before tags, except space
			'/(\s)+/s',         // shorten multiple whitespace sequences
			'/<!--(.|\s)*?-->/' // Remove HTML comments
		);

		$replace = array(
			'>',
			'<',
			'\\1',
			''
		);

		return preg_replace( $search, $replace, $text );
	}
}

if ( ! function_exists( 'twer_fix_html_markup' ) ) {
	/**
	 * Fix HTML markup
	 *
	 * @param $text
	 *
	 * @return string|string[]
	 */
	function twer_fix_html_markup( $text ) {
		$tagstack  = array();
		$stacksize = 0;
		$tagqueue  = '';
		$newtext   = '';
		// Known single-entity/self-closing tags.
		$single_tags = array(
			'area',
			'base',
			'basefont',
			'br',
			'col',
			'command',
			'embed',
			'frame',
			'hr',
			'img',
			'input',
			'isindex',
			'link',
			'meta',
			'param',
			'source'
		);
		// Tags that can be immediately nested within themselves.
		$nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );

		// WP bug fix for comments - in case you REALLY meant to type '< !--'.
		$text = str_replace( '< !--', '<    !--', $text );
		// WP bug fix for LOVE <3 (and other situations with '<' before a number).
		$text = preg_replace( '#<([0-9]{1})#', '&lt;$1', $text );

		/**
		 * Matches supported tags.
		 * To get the pattern as a string without the comments paste into a PHP
		 * REPL like `php -a`.
		 *
		 * @see https://html.spec.whatwg.org/#elements-2
		 * @see https://w3c.github.io/webcomponents/spec/custom/#valid-custom-element-name
		 * @example
		 * ~# php -a
		 * php > $s = [paste copied contents of expression below including parentheses];
		 */
		$tag_pattern = (
			'#<' . // Start with an opening bracket.
			'(/?)' . // Group 1 - If it's a closing tag it'll have a leading slash.
			'(' . // Group 2 - Tag name.
			// Custom element tags have more lenient rules than HTML tag names.
			'(?:[a-z](?:[a-z0-9._]*)-(?:[a-z0-9._-]+)+)' .
			'|' .
			// Traditional tag rules approximate HTML tag names.
			'(?:[\w:]+)' .
			')' .
			'(?:' .
			// We either immediately close the tag with its '>' and have nothing here.
			'\s*' .
			'(/?)' . // Group 3 - "attributes" for empty tag.
			'|' .
			// Or we must start with space characters to separate the tag name from the attributes (or whitespace).
			'(\s+)' . // Group 4 - Pre-attribute whitespace.
			'([^>]*)' . // Group 5 - Attributes.
			')' .
			'>#' // End with a closing bracket.
		);

		while ( preg_match( $tag_pattern, $text, $regex ) ) {
			$full_match        = $regex[0];
			$has_leading_slash = ! empty( $regex[1] );
			$tag_name          = $regex[2];
			$tag               = strtolower( $tag_name );
			$is_single_tag     = in_array( $tag, $single_tags, true );
			$pre_attribute_ws  = isset( $regex[4] ) ? $regex[4] : '';
			$attributes        = trim( isset( $regex[5] ) ? $regex[5] : $regex[3] );
			$has_self_closer   = '/' === substr( $attributes, - 1 );

			$newtext .= $tagqueue;

			$i = strpos( $text, $full_match );
			$l = strlen( $full_match );

			// Clear the shifter.
			$tagqueue = '';
			if ( $has_leading_slash ) { // End tag.
				// If too many closing tags.
				if ( $stacksize <= 0 ) {
					$tag = '';
					// Or close to be safe $tag = '/' . $tag.

					// If stacktop value = tag close value, then pop.
				} elseif ( $tagstack[ $stacksize - 1 ] === $tag ) { // Found closing tag.
					$tag = '</' . $tag . '>'; // Close tag.
					array_pop( $tagstack );
					$stacksize --;
				} else { // Closing tag not at top, search for it.
					for ( $j = $stacksize - 1; $j >= 0; $j -- ) {
						if ( $tagstack[ $j ] === $tag ) {
							// Add tag to tagqueue.
							for ( $k = $stacksize - 1; $k >= $j; $k -- ) {
								$tagqueue .= '</' . array_pop( $tagstack ) . '>';
								$stacksize --;
							}
							break;
						}
					}
					$tag = '';
				}
			} else { // Begin tag.
				if ( $has_self_closer ) { // If it presents itself as a self-closing tag...
					// ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such
					// and immediately close it with a closing tag (the tag will encapsulate no text as a result).
					if ( ! $is_single_tag ) {
						$attributes = trim( substr( $attributes, 0, - 1 ) ) . "></$tag";
					}
				} elseif ( $is_single_tag ) { // Else if it's a known single-entity tag but it doesn't close itself, do so.
					$pre_attribute_ws = ' ';
					$attributes       .= '/';
				} else { // It's not a single-entity tag.
					// If the top of the stack is the same as the tag we want to push, close previous tag.
					if ( $stacksize > 0 && ! in_array( $tag, $nestable_tags,
							true ) && $tagstack[ $stacksize - 1 ] === $tag ) {
						$tagqueue = '</' . array_pop( $tagstack ) . '>';
						$stacksize --;
					}
					$stacksize = array_push( $tagstack, $tag );
				}

				// Attributes.
				if ( $has_self_closer && $is_single_tag ) {
					// We need some space - avoid <br/> and prefer <br />.
					$pre_attribute_ws = ' ';
				}

				$tag = '<' . $tag . $pre_attribute_ws . $attributes . '>';
				// If already queuing a close tag, then put this tag on too.
				if ( ! empty( $tagqueue ) ) {
					$tagqueue .= $tag;
					$tag      = '';
				}
			}
			$newtext .= substr( $text, 0, $i ) . $tag;
			$text    = substr( $text, $i + $l );
		}

		// Clear tag queue.
		$newtext .= $tagqueue;

		// Add remaining text.
		$newtext .= $text;

		while ( $x = array_pop( $tagstack ) ) {
			$newtext .= '</' . $x . '>'; // Add remaining tags to close.
		}

		// WP fix for the bug with HTML comments.
		$newtext = str_replace( '< !--', '<!--', $newtext );
		$newtext = str_replace( '<    !--', '< !--', $newtext );

		return $newtext;
	}
}


if ( ! function_exists( 'twer_is_map_in_page' ) ) {

	/**
	 * Is_map_on_page - Returns true when viewing the full screen map page OR iframe map.
	 *
	 * @param string $id
	 *
	 * @return bool
	 */
	function twer_is_map_in_page( $id = null ) {
		return twer_is_map_fullscreen( $id ) || twer_is_map_iframe();
	}
}

if ( ! function_exists( 'twer_is_map_fullscreen' ) ) {
	/**
	 * Check if current map is fullscreen in show on single page
	 *
	 * @param null $id
	 *
	 * @return bool
	 */
	function twer_is_map_fullscreen( $id = null ) {
		if ( ! $id ) {
			$id = get_the_ID();
		}
		$fs_meta = get_post_meta( $id, '_treweler_cpt_dd_box_fullscreen', true );

		return ( trim( $fs_meta ) !== '' && $fs_meta > 0 );
	}
}

if ( ! function_exists( 'twer_get_map_id' ) ) {
	/**
	 * Get showed current Map ID
	 *
	 * @return int
	 */
	function twer_get_map_id() {
		$map_id = 0;
		if ( twer_is_map_iframe() ) {
			$map_id = twer_get_iframe_map_id();
		} else {
			$map_id = get_post_meta( get_the_ID(), '_treweler_cpt_dd_box_fullscreen', true );
		}

		return (int) $map_id;
	}
}

if ( ! function_exists( 'twer_hex_to_rgb' ) ) {
	/**
	 * Convert HEX color to RGB(A)
	 *
	 * @param      $hex_color
	 * @param bool $normal
	 * @param int $opacity
	 *
	 * @return array|string
	 */
	function twer_hex_to_rgb( $hex_color, $normal = false, $opacity = 1 ) {
		$hex_color = $hex_color['0'] !== '#' ? '#' . $hex_color : $hex_color;
		$hex_int   = hexdec( ltrim( sanitize_hex_color( $hex_color ), '#' ) );
		$rgb       = array(
			'red'   => 0xFF & ( $hex_int >> 0x10 ),
			'green' => 0xFF & ( $hex_int >> 0x8 ),
			'blue'  => 0xFF & $hex_int
		);
		if ( $normal ) {
			$opacity_value = is_numeric( $opacity ) ? $opacity : 1;
			$rgb           = 'rgba(' . implode( ',', array_values( $rgb ) ) . ',' . $opacity_value . ')';
		}

		return $rgb;
	}
}


if ( ! function_exists( 'twer_is_map_iframe' ) ) {
	/**
	 * Check if current map show via ONLY iframe
	 *
	 * @return bool
	 */
	function twer_is_map_iframe() {
		$params    = twer_get_iframe_params();
		$is_iframe = ! empty( $params['tw'] ) ? $params['tw'] : '';

		return $is_iframe === 'iframe';
	}
}


if ( ! function_exists( 'twer_get_iframe_params' ) ) {
	/**
	 * Get all shortcode iframe params via GET request
	 *
	 * @return array
	 */
	function twer_get_iframe_params() {
		$params = [];
		if ( ! empty( $_GET ) ) {
			foreach ( $_GET as $key => $value ) {
				if ( strpos( $key, 'tw' ) !== false ) {
					$params[ str_replace( 'twer-', '', $key ) ] = $value;
				}
			}
		}

		return $params;
	}
}

if ( ! function_exists( 'twer_get_iframe_map_id' ) ) {
	/**
	 * Get map id from iframe shortcode
	 *
	 * @return mixed|string
	 */
	function twer_get_iframe_map_id() {
		$params = twer_get_iframe_params();

		return ! empty( $params['map-id'] ) ? $params['map-id'] : '';
	}
}


if ( ! function_exists( 'twer_load_template' ) ) {
	/**
	 * Loads template from `treweler` child/main theme folder, if not exist from - PLUGIN_NAME/includes/ path
	 *
	 * @param null $file
	 *
	 * @return string
	 */
	function twer_load_template( $file = null ) {
		$file_path = get_theme_file_path( 'treweler/' . $file );

		return file_exists( $file_path ) ? $file_path : untrailingslashit( plugin_dir_path( TWER_PLUGIN_FILE ) ) . '/includes/' . $file;
	}
}

if ( ! function_exists( 'twer_get_categories' ) ) {
	/**
	 * Get Category List by Post ID
	 *
	 * @return mixed
	 */
	function twer_get_categories( $post_id, $encode = true ) {
		$mask_results = [];
		$terms        = get_the_terms( $post_id, 'map-category' );
		$i            = 0;

		if ( isset( $terms ) && is_array( $terms ) ) {
			foreach ( $terms as $t ) {
				$mask_results[ $i ]['id']   = $t->term_id;
				$mask_results[ $i ]['name'] = $t->name;
				$mask_results[ $i ]['slug'] = $t->slug;
				$i ++;
			}
		} else {
			return 0;
		}


		if ( $encode ) {
			return htmlspecialchars( json_encode( $mask_results ), ENT_QUOTES, 'UTF-8' );
		}

		return $mask_results;

	}
}

if ( ! function_exists( 'twer_build_category_classes' ) ) {
	/**
	 * Build Category Classes
	 *
	 * @return mixed
	 */
	function twer_build_category_classes( $post_id, $selector = 'id', $separator = ' ' ) {

		if ( $post_id === 0 ) {
			return implode( $separator, [ 'twer-no-category' ] );
		}

		$cat = twer_get_categories( $post_id, false );

		if ( $cat >= 1 ) {
			$ids = [ 'twer-has-category' ];
			foreach ( $cat as $c ) {
				$ids[] = 'category-' . $c[ $selector ];
			}
		} else {
			$ids = [ 'twer-no-category' ];
		}


		return implode( $separator, $ids );
	}
}

if ( ! function_exists( 'twer_get_categories_ids' ) ) {
	/**
	 * Get categories id's
	 *
	 * @return mixed
	 */
	function twer_get_categories_ids( $post_id, $selector = 'id' ) {

		$ids = [];
		if ( $post_id === 0 ) {
			return '';
		}

		$cat = twer_get_categories( $post_id, false );

		if ( $cat >= 1 ) {
			foreach ( $cat as $c ) {
				$ids[] = $c[ $selector ];
			}
		}


		return wp_json_encode( $ids );
	}
}

if ( ! function_exists( 'wp_dropdown_cpt' ) ) {
	function wp_dropdown_cpt( $args = '' ) {

		$defaults = array(
			'show_option_all'       => esc_html__( "Show All Maps", 'treweler' ),
			'numberposts'           => - 1,
			'category'              => 0,
			'orderby'               => 'date',
			'order'                 => 'DESC',
			'include'               => array(),
			'exclude'               => array(),
			'meta_key'              => '',
			'meta_value'            => '',
			'post_type'             => 'map',
			'suppress_filters'      => true,
			'depth'                 => 0,
			'child_of'              => 0,
			'selected'              => 0,
			'echo'                  => 1,
			'name_filter'           => 'map_filter',
			'id'                    => '',
			'class'                 => '',
			'show_option_none'      => '',
			'show_option_no_change' => '',
			'option_none_value'     => '',
			'value_field'           => 'ID',
		);

		$parsed_args = wp_parse_args( $args, $defaults );

		$cpts = get_posts( array(
			'category'         => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post__in'         => $parsed_args['include'],
			'exclude'          => array(),
			'post_type'        => $parsed_args['post_type'],
			'post_status'      => 'publish',
			'meta_key'         => '',
			'meta_value'       => '',
			'posts_per_page'   => $parsed_args['numberposts'],
			'suppress_filters' => $parsed_args['suppress_filters'],
		) );

		// bypass if post__in parameter exist
		$cache_name = sanitize_title( 'twer_cpt_' . $parsed_args['post_type'] . '__list' );
		if ( ! isset( $parsed_args['include'] ) || isset( $_GET['post_type'] ) || isset( $_GET['map_filter'] ) ) {
			if ( isset( $cpts ) && is_array( $cpts ) ) {
				if ( count( $cpts ) >= 1 ) {
					set_transient( $cache_name, $cpts, 3500 );
				}
			}
			$cpts = get_transient( $cache_name );
		}

		$output = '';
		// Back-compat with old system where both id and name were based on $name argument.
		if ( empty( $parsed_args['id'] ) ) {
			$parsed_args['id'] = $parsed_args['name_filter'];
		}

		//if ( ! empty( $cpts ) ) {
		$class = '';
		if ( ! empty( $parsed_args['class'] ) ) {
			$class = " class='" . esc_attr( $parsed_args['class'] ) . "'";
		}
		$selected = ( '0' === (string) $parsed_args['selected'] ) ? " selected='selected'" : '';

		$output = "<select name='" . esc_attr( $parsed_args['name_filter'] ) . "'" . $class . " id='" . esc_attr( $parsed_args['id'] ) . "'>\n";
		if ( $parsed_args['show_option_all'] ) {
			$output .= "\t<option value='0'$selected>" . $parsed_args['show_option_all'] . "</option>\n";
		}

		if ( $parsed_args['show_option_no_change'] ) {
			$output .= "\t<option value=\"-1\"$selected>" . $parsed_args['show_option_no_change'] . "</option>\n";
		}
		if ( $parsed_args['show_option_none'] ) {
			$output .= "\t<option value=\"" . esc_attr( $parsed_args['option_none_value'] ) . '$selected">' . $parsed_args['show_option_none'] . "</option>\n";
		}
		$output .= walk_page_dropdown_tree( $cpts, $parsed_args['depth'], $parsed_args );
		$output .= "</select>\n";
		//}

		$html = $output;

		if ( $parsed_args['echo'] ) {
			echo $html;
		}

		return $html;
	}
}


/**
 * Isset and set default value if data empty or not valid
 *
 * @var $type string | array  | int | boolean
 * @var $return string boolean |
 */
if ( ! function_exists( 'twer_isset' ) ) {
	function twer_isset( $var = "", $default = false, $return = 'boolean', $type = 'array' ) {
		if ( $type === 'array' && is_array( $var ) ) {
			if ( isset( $var[0] ) ) {
				if ( $return === 'boolean' ) {
					return true;
				} else {
					return $var;
				}

			} else {
				return false;
			}
		} else {
			return $default;
		}

	}
}
/**
 * Internal Debugging Tools
 */

if ( ! function_exists( 'twer_write_log' ) ) {

	function twer_write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}

}

if ( ! function_exists( 'twer_untrash_post_status' ) ) {
	/**
	 * Remove trash status for some CPT
	 *
	 * @param $new_status
	 * @param $post_id
	 * @param $previous_status
	 *
	 * @return mixed|string
	 */
	function twer_untrash_post_status( $new_status, $post_id, $previous_status ) {
		$post_type = get_post_type( $post_id );
		if ( $post_type === 'twer-custom-fields' || $post_type === 'twer-templates' || $post_type === 'treweler-import' ) {
			$new_status = 'publish';
		}

		return $new_status;
	}

	add_filter( 'wp_untrash_post_status', 'twer_untrash_post_status', 3, 10 );
}

if ( ! function_exists( 'twer_implode_r' ) ) {
	/**
	 * Improved recursive function
	 *
	 * @param $glue
	 * @param array $arr
	 *
	 * @return string
	 */
	function twer_implode_r( $glue, array $arr ) {
		$ret = '';

		foreach ( $arr as $piece ) {
			if ( is_array( $piece ) ) {
				$ret .= $glue . twer_implode_r( $glue, $piece );
			} else {
				$ret .= $glue . $piece;
			}
		}

		return $ret;
	}
}

if ( ! function_exists( 'twer_get_marker_styles' ) ) {
	function twer_get_marker_styles( $post_id ) {
		$meta_data           = twer_get_data( $post_id );
		$marker_size_default = get_post_meta( $post_id, '_treweler_marker_icon_size', true );
		$marker_styles       = [];
		$need_fields         = [
			'marker_style'           => 'default',
			'point_color'            => '#4b7715',
			'point_halo_color'       => '#ffffff',
			'point_halo_opacity'     => '0.5',
			'dot_icon_show'          => false,
			'dot_icon_picker'        => '',
			'dot_icon'               => [
				'color' => '#ffffff',
				'size'  => '15',
			],
			'dot'                    => [
				'color' => '#4b7715',
				'size'  => '12',

			],
			'dot_border'             => [
				'color' => '#ffffff',
				'size'  => '0',
			],
			'dot_corner_radius'      => [
				'size'  => '50',
				'units' => '%'
			],
			'balloon_icon_show'      => false,
			'balloon_icon_picker'    => '',
			'balloon_icon'           => [
				'color' => '#ffffff',
				'size'  => '15',
			],
			'balloon'                => [
				'color' => '#4b7715',
				'size'  => '18',
			],
			'balloon_border'         => [
				'color' => '#4b7715',
				'size'  => '4',
			],
			'balloon_dot'            => [
				'color' => '#ffffff',
				'size'  => '8',
			],
			'triangle_color'         => '#4b7715',
			'triangle_width'         => '12',
			'triangle_height'        => '10',
			'custom_marker_img'      => '',
			'custom_marker_position' => 'center',
			'custom_marker_size'     => '42',
			'custom_marker_cursor'   => 'pointer',
		];


		foreach ( $need_fields as $key => $default_value ) {
			$value = isset( $meta_data->{$key} ) ? $meta_data->{$key} : '';

			if ( empty( $value ) && ! is_numeric( $value ) && ! is_bool( $value ) && ! is_array( $value ) ) {
				$value = $default_value;
			}

			if ( is_array( $value ) ) {
				foreach ( $value as $value_child_key => $value_child ) {
					if ( empty( $value_child ) && ! is_numeric( $value_child ) && ! is_bool( $value_child ) && ! is_array( $value_child ) ) {
						$default_value_child       = isset( $default_value[ $value_child_key ] ) ? $default_value[ $value_child_key ] : '';
						$value[ $value_child_key ] = $default_value_child;
					}
				}
			}

			$marker_styles[ $key ] = $value;
		}


		if ( is_numeric( $marker_styles['custom_marker_img'] ) ) {
			$data_item                          = wp_get_attachment_image_src( $marker_styles['custom_marker_img'], 'full' );
			$marker_styles['custom_marker_img'] = isset( $data_item[0] ) ? $data_item[0] : $data_item;
		}

		$marker_styles['custom_marker_size_default'] = $marker_size_default;

		return $marker_styles;
	}
}

if ( ! function_exists( 'twer_map_has_shapes' ) ) {
	/**
	 * Detect if map has any shape
	 *
	 * @param int $map_id
	 *
	 * @return bool
	 */
	function twer_map_has_shapes( int $map_id ) {
		global $post;
		$map_has_shapes = false;

		$tmp_post = $post;
		$shapes   = get_posts( [
			'posts_per_page' => - 1,
			'numberposts'    => - 1,
			'post_type'      => 'twer-shapes',
		] );
		foreach ( $shapes as $post ) {
			setup_postdata( $post );
			$shape_id = get_the_ID();

			$maps_ids = get_post_meta( $shape_id, '_treweler_map_id', true );

			if ( ! empty( $maps_ids ) && is_array( $maps_ids ) ) {
				$maps_ids = array_map( static function( $value ) {
					return (int) $value;
				}, $maps_ids );

				if ( in_array( $map_id, $maps_ids, true ) ) {
					$map_has_shapes = true;
					break;
				}
			}
		}

		$post = $tmp_post;

		return $map_has_shapes;
	}
}

if ( ! function_exists( 'twer_map_has_routes' ) ) {
	/**
	 * Detect if map has any route
	 *
	 * @param int $map_id
	 *
	 * @return bool
	 */
	function twer_map_has_routes( int $map_id ) {
		global $post;
		$map_has_routes = false;

		$tmp_post = $post;
		$routes   = get_posts( [
			'posts_per_page' => - 1,
			'numberposts'    => - 1,
			'post_type'      => 'route',
		] );
		foreach ( $routes as $post ) {
			setup_postdata( $post );
			$route_id = get_the_ID();

			$maps_ids = get_post_meta( $route_id, '_treweler_route_map_id', true );

			if ( ! empty( $maps_ids ) ) {
				if ( ! is_array( $maps_ids ) ) {
					$maps_ids = [ $maps_ids ];
				}

				$maps_ids = array_map( static function( $value ) {
					return (int) $value;
				}, $maps_ids );

				if ( in_array( $map_id, $maps_ids, true ) ) {
					$map_has_routes = true;
					break;
				}
			}
		}

		$post = $tmp_post;

		return $map_has_routes;
	}
}


function twerGetAllPublishedMaps() {
	$allMapsForOutput = [];

	$allMaps = get_posts( apply_filters( 'treweler_get_all_published_maps', [
		'post_type'      => 'map',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'fields'         => 'ids'
	] ) );

	if ( ! empty( $allMaps ) ) {
		foreach ( $allMaps as $mapId ) {
			$allMapsForOutput[ $mapId ] = get_the_title( $mapId );
		}
	}

	return $allMapsForOutput;
}

function twerGetAllPublishedMarkersIds() {
	return get_posts( apply_filters( 'treweler_get_all_published_markers_ids', [
		'post_type'      => 'marker',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
		'fields'         => 'ids'
	] ) );
}

function twerGetAllPublishedCustomFields(): array {
	return get_posts( [
		'post_status'    => 'publish',
		'post_type'      => 'twer-custom-fields',
		'numberposts'    => - 1,
		'posts_per_page' => - 1,
		'order'          => 'ASC',
		'fields'         => 'ids'
	] );

}

/**
 * Locate a template and return the path for inclusion.
 * This is the load order:
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @param string $template_name Template name.
 * @param string $template_path Template path. (default: '').
 * @param string $default_path Default path. (default: '').
 *
 * @return string
 */
function twer_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = TWER()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = TWER()->plugin_path() . '/templates/';
	}

	// Look within passed path within the theme - this is priority.
	if ( false !== strpos( $template_name, 'map-category' ) ) {
		$cs_template = str_replace( '_', '-', $template_name );
		$template    = locate_template(
			array(
				trailingslashit( $template_path ) . $cs_template,
				$cs_template,
			)
		);
	}

	if ( empty( $template ) ) {
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);
	}

	// Get default template/.
	if ( ! $template || TWER_TEMPLATE_DEBUG_MODE ) {
		if ( empty( $cs_template ) ) {
			$template = $default_path . $template_name;
		} else {
			$template = $default_path . $cs_template;
		}
	}

	// Return what we found.
	return apply_filters( 'treweler_locate_template', $template, $template_name, $template_path );
}

/**
 * Given a path, this will convert any of the subpaths into their corresponding tokens.
 *
 * @param string $path The absolute path to tokenize.
 * @param array $path_tokens An array keyed with the token, containing paths that should be replaced.
 *
 * @return string The tokenized path.
 * @since 1.13
 */
function twer_tokenize_path( $path, $path_tokens ) {
	// Order most to least specific so that the token can encompass as much of the path as possible.
	uasort(
		$path_tokens,
		function( $a, $b ) {
			$a = strlen( $a );
			$b = strlen( $b );

			if ( $a > $b ) {
				return - 1;
			}

			if ( $b > $a ) {
				return 1;
			}

			return 0;
		}
	);

	foreach ( $path_tokens as $token => $token_path ) {
		if ( 0 !== strpos( $path, $token_path ) ) {
			continue;
		}

		$path = str_replace( $token_path, '{{' . $token . '}}', $path );
	}

	return $path;
}

/**
 * Fetches an array containing all of the configurable path constants to be used in tokenization.
 *
 * @return array The key is the define and the path is the constant.
 */
function twer_get_path_define_tokens() {
	$defines = array(
		'ABSPATH',
		'WP_CONTENT_DIR',
		'WP_PLUGIN_DIR',
		'WPMU_PLUGIN_DIR',
		'PLUGINDIR',
		'WP_THEME_DIR',
	);

	$path_tokens = array();
	foreach ( $defines as $define ) {
		if ( defined( $define ) ) {
			$path_tokens[ $define ] = constant( $define );
		}
	}

	return apply_filters( 'treweler_get_path_define_tokens', $path_tokens );
}

/**
 * Add a template to the template cache.
 *
 * @param string $cache_key Object cache key.
 * @param string $template Located template.
 *
 * @since 1.12
 */
function twer_set_template_cache( $cache_key, $template ) {
	wp_cache_set( $cache_key, $template, 'treweler' );

	$cached_templates = wp_cache_get( 'cached_templates', 'treweler' );
	if ( is_array( $cached_templates ) ) {
		$cached_templates[] = $cache_key;
	} else {
		$cached_templates = array( $cache_key );
	}

	wp_cache_set( 'cached_templates', $cached_templates, 'treweler' );
}

/**
 * Given a tokenized path, this will expand the tokens to their full path.
 *
 * @param string $path The absolute path to expand.
 * @param array $path_tokens An array keyed with the token, containing paths that should be expanded.
 *
 * @return string The absolute path.
 * @since 1.13
 */
function twer_untokenize_path( $path, $path_tokens ) {
	foreach ( $path_tokens as $token => $token_path ) {
		$path = str_replace( '{{' . $token . '}}', $token_path, $path );
	}

	return $path;
}

/**
 * Get other templates (e.g. map elements) passing attributes and including the file.
 *
 * @param string $template_name Template name.
 * @param array $args Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path Default path. (default: '').
 */
function twer_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	$cache_key = sanitize_key( implode( '-', array( 'template', $template_name, $template_path, $default_path, TWER_VERSION ) ) );
	$template  = (string) wp_cache_get( $cache_key, 'treweler' );

	if ( ! $template ) {
		$template = twer_locate_template( $template_name, $template_path, $default_path );

		// Don't cache the absolute path so that it can be shared between web servers with different paths.
		$cache_path = twer_tokenize_path( $template, twer_get_path_define_tokens() );

		twer_set_template_cache( $cache_key, $cache_path );
	} else {
		// Make sure that the absolute path to the template is resolved.
		$template = twer_untokenize_path( $template, twer_get_path_define_tokens() );
	}

	// Allow 3rd party plugin filter template file from their plugin.
	$filter_template = apply_filters( 'twer_get_template', $template, $template_name, $args, $template_path, $default_path );

	if ( $filter_template !== $template ) {
		if ( ! file_exists( $filter_template ) ) {
			/* translators: %s template */
			twer_doing_it_wrong( __FUNCTION__, sprintf( __( '%s does not exist.', 'treweler' ), '<code>' . $filter_template . '</code>' ), '1.13' );

			return;
		}
		$template = $filter_template;
	}

	$action_args = array(
		'template_name' => $template_name,
		'template_path' => $template_path,
		'located'       => $template,
		'args'          => $args,
	);

	if ( ! empty( $args ) && is_array( $args ) ) {
		if ( isset( $args['action_args'] ) ) {
			twer_doing_it_wrong(
				__FUNCTION__,
				__( 'action_args should not be overwritten when calling wc_get_template.', 'woocommerce' ),
				'3.6.0'
			);
			unset( $args['action_args'] );
		}
		extract( $args ); // @codingStandardsIgnoreLine
	}

	do_action( 'treweler_before_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );

	include $action_args['located'];

	do_action( 'treweler_after_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );
}

if ( ! function_exists( 'twerGetAbsPathForUploadsFile' ) ) {
	/**
	 * Retrieves the absolute file path for an uploaded file in WordPress.
	 * This function takes a relative or absolute path and transforms it into
	 * an absolute path that points to the WordPress upload directory.
	 * It normalizes various types of paths to generate a consistent absolute path.
	 *
	 * @param string $path The relative or absolute path to the file. Examples of path:
	 * - 'https://example.com/wp-content/uploads/1993/07/scrubs.png'
	 * - 'uploads/1993/07/scrubs.png'
	 * - '/uploads/1993/07/scrubs.png'
	 * - 'example.com/wp-content/uploads/1993/07/scrubs.png'
	 * - 'www.example.com/wp-content/uploads/1993/07/scrubs.png'
	 *
	 * @return string        The absolute path to the file in the WordPress upload directory.
	 * @author Aisconverse
	 * @version 1.14
	 */
	function twerGetAbsPathForUploadsFile( string $path ): string {

		$upload_dir = wp_upload_dir( null, false );

		return rtrim( $upload_dir['basedir'], '/' ) . '/' . twerCleanUploadsFilePath($path);
	}
}

function twerCleanUploadsFilePath(string $path ) : string {
	$pattern = '/^.*?uploads\//';
	if ( preg_match( $pattern, $path ) ) {
		$path = preg_replace( $pattern, '', $path );
	}

    return $path;
}

function twerGetUploadsFileUrlFromPath( string $path) : string {
	$upload_dir = wp_upload_dir(null, false);
	$base_url = $upload_dir['baseurl'];

	return trailingslashit($base_url) . ltrim(twerCleanUploadsFilePath($path), '/');
}

function twerGetUploadsFileIdFromPath( string $path ): int {
	return attachment_url_to_postid( twerGetUploadsFileUrlFromPath( $path ) );
}


/**
 * Wrapper for set_time_limit to see if it is enabled.
 *
 * @since 1.14
 * @param int $limit Time limit.
 */
function twer_set_time_limit( $limit = 0 ) {
	if ( function_exists( 'set_time_limit' ) && false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) { // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.safe_modeDeprecatedRemoved
		@set_time_limit( $limit ); // @codingStandardsIgnoreLine
	}
}


function twerYieldLoop($array) {
	foreach ($array as $value) {
        yield $value;
	}
}

function twerGetMarkersMap( int $mapId ) : array {
	global $wpdb;
	$prefix = '_treweler_';

	$sql = $wpdb->prepare(
		"SELECT * FROM {$wpdb->posts} p
         LEFT JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id AND pm1.meta_key = %s
         LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id AND pm2.meta_key = %s
         WHERE p.post_type = 'marker'
         AND p.post_status = 'publish'
         AND (pm1.meta_value = %s OR pm2.meta_value LIKE %s)",
		$prefix . 'marker_map_id',
		$prefix . 'marker_map_id',
		$mapId,
		'%' . $wpdb->esc_like(serialize( (string) $mapId )) . '%'
	);

	return $wpdb->get_results($sql);
}
