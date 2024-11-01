<?php

function theMarkerFields($fields_popup) {
  global $post;
  $post_id = isset( $post->ID ) ? $post->ID : 0;

  $meta_data = twer_get_data( $post_id );

  $current_template = isset( $meta_data->templates ) ? $meta_data->templates : 'none';

    ?>
    <div class="table-responsive">
        <table class="table twer-table twer-table--cells-2">
            <tbody>
            <?php foreach ( $fields_popup as $field ) {
              $element_id = trim( str_replace( '_', '-', $field['name'] ), '-' );

              $tr_class = [ 'twer-tr-toggle' ];
              $tr_atts = [];

              if ( isset( $field['toggle_row'] ) ) {
                $tr_class[] = 'js-twer-tr-toggle';


                if ( isset( $field['toggle_row']['related_id'] ) ) {
                  $tr_atts[] = 'id="' . $field['toggle_row']['related_id'] . '-toggle"';
                }

                if ( isset( $field['toggle_row']['trigger'] ) ) {
                  $tr_atts[] = 'data-trigger="' . $field['toggle_row']['trigger'] . '"';
                }
              }

              if ( ! empty( $field['toggle-row'] ) ) {
                if ( ! empty( $field['toggle-row']['show'] ) ) {
                  $tr_class[] = 'js-toggle-row';
                } else {
                  $tr_class[] = 'js-toggle-row  d-none';
                }
                $tr_atts[] = 'data-related-id="' . esc_attr( $field['toggle-row']['related'] ) . '"';
                $att_value = $field['toggle-row']['value'];
                if ( is_array( $att_value ) ) {
                  $att_value = implode( ',', $att_value );
                } else {
                  $att_value = (string) $att_value;
                }
                $tr_atts[] = 'data-related-val="' . esc_attr( $att_value ) . '"';
              }

              $isPro = isset($field['isPro']) ? $field['isPro'] : false;

              if($isPro) {
                $tr_class[] = 'twer-default-row twer-is-pro-field';
              }

              ?>
                <tr class="<?php echo esc_attr( implode( ' ',
                  $tr_class ) ); ?>" <?php echo implode( ' ', $tr_atts ); ?>>
                    <th class="th-<?php echo esc_attr( $element_id ); ?>">
                        <label for="<?php echo esc_attr( $element_id ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
                    </th>
                    <td>
                      <?php
                      $data_template = isset( $field['data_template'] ) ? implode( ' ', $field['data_template'] ) : '';
                      ?>
                        <div class="twer-wrap-fields">
                          <?php template_locks( $current_template, $field, $meta_data ); ?>

                          <?php if ( 'select' === $field['type'] ) { ?>
                              <div class="twer-form-group twer-form-group--select">
                                  <select name="<?php echo esc_attr( $field['name'] ); ?>"
                                          class="large-select"
                                    <?php echo $data_template; ?>
                                          id="<?php echo esc_attr( $element_id ); ?>">
                                    <?php foreach ( $field['value'] as $data ) { ?>
                                        <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                          <?php } elseif ( 'checkbox' === $field['type'] ) { ?>
                              <input type="hidden"
                                     name="<?php echo esc_attr( $field['name'] ); ?>"
                                     value="">
                            <?php foreach ( $field['value'] as $data ) { ?>
                                  <label for="<?php echo esc_attr( $element_id ) ?>" class="twer-switcher" <?php echo $data_template; ?> >
                                      <input type="checkbox"
                                             name="<?php echo esc_attr( $field['name'] ); ?>[]"
                                             id="<?php echo esc_attr( $element_id ); ?>"
                                             value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                      <div class="twer-switcher__slider"></div>
                                  </label>
                            <?php } ?>
                          <?php } elseif ( 'colorpicker' === $field['type'] ) { ?>
                              <div class="js-twer-color-picker-wrap twer-color-picker-wrap" <?php echo $data_template; ?>>
                                  <div class="map-text-color js-twer-color-picker">
                                                                <span class="color-holder"
                                                                      style="background-color:<?php echo esc_attr( $field['value'] ) ?>;"></span>
                                      <input type="button" class="text-color-picker-btn"
                                             value="<?php echo esc_attr__( 'Select Color',
                                               'treweler' ); ?>">
                                  </div>
                                  <!-- .color-picker-text-descr -->
                                  <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                       acp-color="<?php echo esc_attr( $field['value'] ) ?>"
                                       acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                       default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                       acp-show-rgb="no"
                                       acp-show-hsl="no"
                                       acp-palette-editable>
                                  </div>
                                  <input type="hidden"
                                         name="<?php echo esc_attr( $field['name'] ); ?>"
                                         class="input-color input-color-field"
                                         value="<?php echo esc_attr( $field['value'] ) ?>">
                              </div>
                          <?php } elseif ( 'text' === $field['type'] || 'url' === $field['type'] ) {

                            $field_class = [ 'twer-form-group twer-form-group--text' ];
                            $field_placeholder = '';
                            if ( isset( $field['size'] ) ) {
                              $field_class[] = 'twer-form-group--' . $field['size'];
                            }

                            if ( isset( $field['placeholder'] ) ) {
                              $field_placeholder = $field['placeholder'];
                            }
                            if ( isset( $field['postfix'] ) ) {
                              $field_class[] = 'twer-form-group--append';
                            }

                            ?>
                              <div class="<?php echo esc_attr( implode( ' ', $field_class ) ); ?>">
                                  <input type="<?php echo esc_attr( $field['type'] ); ?>"
                                         id="<?php echo esc_attr( $element_id ); ?>"
                                         name="<?php echo esc_attr( $field['name'] ); ?>"
                                         class="large-text"
                                    <?php echo $data_template; ?>
                                         value="<?php echo esc_attr( $field['value'] ) ?>"
                                         placeholder="<?php echo esc_attr( $field_placeholder ); ?>">
                                <?php if ( isset( $field['postfix'] ) ) { ?>
                                    <div class="twer-form-group-append">
                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field['postfix'] ); ?></span>
                                    </div>
                                <?php } ?>
                              </div>
                          <?php } elseif ( 'textarea' === $field['type'] ) { ?>
                              <div class="twer-form-group twer-form-group--text">
                                                            <textarea class="large-text"
                                                                      name="<?php echo esc_attr( $field['name'] ); ?>"
                                                                      id="<?php echo esc_attr( $element_id ); ?>"
                                                                      cols="30"
                                                                      <?php echo $data_template; ?>
                                                                      rows="6"><?php echo esc_attr( $field['value'] ) ?></textarea>
                              </div>
                          <?php } elseif ( 'image' === $field['type'] ) { ?>
                              <div class="twer-attach js-twer-attach-wrap" <?php echo $data_template; ?>>

                                  <div class="twer-attach__thumb js-twer-attach-thumb">
                                    <?php if ( $field['value'] ) { ?>
                                        <img src="<?php echo esc_url( $field['value'] ); ?>"
                                             alt="">
                                    <?php } ?>
                                      <button type="button"
                                              id="<?php echo esc_attr( $element_id ); ?>"
                                              style="<?php echo ! empty( $field['value'] ) ? 'display:none;' : 'display:block'; ?>"
                                              class="twer-attach__add-media js-twer-attach-add"><?php echo esc_html__( 'Select Image',
                                          'treweler' ); ?></button>

                                      <input type="hidden"
                                             name="<?php echo esc_attr( $field['name'] ); ?>"
                                             value="<?php echo esc_attr( $field['value'] ) ?>">
                                  </div>

                                  <div class="twer-attach__actions js-twer-attach-actions"
                                       style="<?php echo ! empty( $field['value'] ) ? 'display:block;' : 'display:none'; ?>">
                                      <button type="button"
                                              class="button js-twer-attach-remove"><?php echo esc_html__( 'Remove',
                                          'treweler' ); ?></button>
                                      <button type="button"
                                              class="button js-twer-attach-add"><?php echo esc_html__( 'Change image',
                                          'treweler' ); ?></button>
                                  </div>
                              </div>
                          <?php } elseif ( 'gallery' === $field['type'] ) { ?>
                              <div class="twer-attach-gallery js-twer-attach-gallery-wrap" <?php echo $data_template; ?>>

                                <?php
                                $gallery_value = [];
                                if ( ! empty( $field['value'] ) ) {

                                  if ( filter_var( $field['value'], FILTER_VALIDATE_URL ) ) {
                                    $attachment_id = attachment_url_to_postid( $field['value'] );
                                    $field['value'] = $attachment_id;
                                    $thumbnail_img = wp_get_attachment_image( $attachment_id, 'full' );
                                    if ( $thumbnail_img ) {
                                      $gallery_value[] = $attachment_id;
                                      echo '<div class="twer-attach-gallery__thumb" data-id="' . esc_attr( $attachment_id ) . '"><a href="#" class="twer-attach-gallery__remove js-twer-attach-gallery-remove" title="' . __( 'Remove', 'treweler' ) . '"></a>' . $thumbnail_img . '</div>';
                                    }
                                  } else {
                                    $thumbnails_ids = explode( ',', $field['value'] );
                                    if ( ! empty( $thumbnails_ids ) && is_array( $thumbnails_ids ) ) {
                                      foreach ( $thumbnails_ids as $thumbnail_id ) {
                                        $thumbnail_img = wp_get_attachment_image( $thumbnail_id, 'full' );
                                        if ( $thumbnail_img ) {
                                          $gallery_value[] = $thumbnail_id;
                                          echo '<div class="twer-attach-gallery__thumb" data-id="' . esc_attr( $thumbnail_id ) . '"><a href="#" class="twer-attach-gallery__remove js-twer-attach-gallery-remove" title="' . __( 'Remove', 'treweler' ) . '"></a>' . $thumbnail_img . '</div>';
                                        }
                                      }
                                    }
                                  }
                                } ?>

                                  <button type="button" class="twer-attach-gallery__add-media js-twer-attach-gallery-add"></button>

                                  <input type="hidden" id="<?php echo esc_attr( $field['id'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>" value="<?php echo esc_attr( implode( ',', $gallery_value ) ) ?>">
                              </div>
                          <?php } elseif ( 'group' === $field['type'] ) { ?>
                              <div class="twer-group-elements">
                                <?php

                                $rowClass = isset($field['row_class']) ? $field['row_class'] : 'row';

                                ?>
                                  <div class="<?php echo $rowClass; ?>">
                                    <?php foreach ( $field['value'] as $field_group ) {

                                      $element_id_group = trim( str_replace( '_', '-',
                                        $field['name'] . '_' . $field_group['name'] ),
                                        '-' );
                                      $field_group['name'] = $field['name'] . '[' . $field_group['name'] . ']';

                                      $field_class = [];
                                      if ( isset( $field_group['postfix'] ) ) {
                                        $field_class[] = 'twer-form-group--append';
                                      }

                                      $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';


                                      $groupClass = 'colorpicker' === $field_group['type'] ? 'col-simple' : 'col-fixed';

                                      if(isset($field_group['group_class'] ) ) {
                                        $groupClass = $field_group['group_class'];
                                      }

                                      ?>
                                        <div class="<?php echo $groupClass; ?>">
                                          <?php if(isset($field_group['label'])) { ?>
                                              <label for="<?php echo esc_attr( $element_id_group ); ?>"><?php echo esc_attr( $field_group['label'] ); ?></label>
                                          <?php } ?>
                                          <?php if(isset($field_group['label_inline'])) { ?>
                                              <label class="d-inline-block mb-0 mr-1" for="<?php echo esc_attr( $element_id_group ); ?>"><?php echo esc_attr( $field_group['label_inline'] ); ?></label>
                                          <?php } ?>
                                          <?php if ( 'text' === $field_group['type'] || 'url' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--text <?php echo esc_attr( implode( ' ', $field_class ) ); ?>">
                                                  <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                         id="<?php echo esc_attr( $element_id_group ); ?>"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         placeholder="<?php echo esc_attr( $field_group['placeholder'] ); ?>"
                                                         class="large-text"
                                                    <?php echo $data_template; ?>
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                                <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                    <div class="twer-form-group-append">
                                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                    </div>
                                                <?php } ?>
                                              </div>


                                          <?php } elseif ( 'select' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--select">
                                                  <select name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                          class="large-select"
                                                    <?php echo $data_template; ?>
                                                          id="<?php echo esc_attr( $element_id_group ); ?>">
                                                    <?php foreach ( $field_group['value'] as $data ) { ?>
                                                        <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                    <?php } ?>
                                                  </select>
                                              </div>


                                          <?php } elseif ( 'colorpicker' === $field_group['type'] ) { ?>
                                              <div class="js-twer-color-picker-wrap twer-color-picker-wrap" <?php echo $data_template; ?>>
                                                  <div class="map-text-color js-twer-color-picker">
                                                                                    <span class="color-holder"
                                                                                          style="background-color:<?php echo esc_attr( $field_group['value'] ) ?>;"></span>
                                                      <input type="button"
                                                             class="text-color-picker-btn"
                                                             value="<?php echo esc_attr__( 'Select Color',
                                                               'treweler' ); ?>">
                                                  </div>
                                                  <!-- .color-picker-text-descr -->
                                                  <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                       acp-color="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                       acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                       default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                       acp-show-rgb="no"
                                                       acp-show-hsl="no"
                                                       acp-palette-editable>
                                                  </div>
                                                  <input type="hidden"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="input-color input-color-field"
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                              </div>
                                          <?php } elseif ( 'checkbox' === $field_group['type'] ) { ?>
                                              <input type="hidden" name="<?php echo esc_attr( $field_group['name'] ); ?>" value="">
                                            <?php foreach ( $field_group['value'] as $data ) { ?>
                                                  <label for="<?php echo esc_attr( $element_id_group ) ?>" <?php echo $data_template; ?> class="twer-switcher">
                                                      <input type="checkbox"
                                                             name="<?php echo esc_attr( $field_group['name'] ); ?>[]"
                                                             id="<?php echo esc_attr( $element_id_group ); ?>"
                                                             value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                      <div class="twer-switcher__slider"></div>
                                                  </label>
                                            <?php } ?>
                                          <?php } ?>
                                        </div>
                                    <?php } ?>
                                  </div>
                              </div>
                          <?php } elseif ( 'group_simple' === $field['type'] ) { ?>
                              <div class="twer-group-elements">
                                  <div class="row">
                                    <?php
                                    $simple_counter = 0;
                                    foreach ( $field['value'] as $field_group ) {
                                      $simple_counter ++;
                                      $class_simple = '';
                                      switch ( $simple_counter ) {
                                        case '1' :
                                          $class_simple = 'col-fixed--260';
                                          break;
                                        case '2' :
                                          $class_simple = 'col-fixed--130';
                                          break;
                                        case '3' :
                                          $class_simple = 'col-fixed--200';
                                          break;
                                      }

                                      $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';
                                      ?>
                                        <div class="<?php echo 'colorpicker' === $field_group['type'] ? 'col-simple' : 'col-fixed ' . $class_simple ?>">
                                          <?php if ( 'text' === $field_group['type'] || 'url' === $field_group['type'] ) {

                                            $field_group_class = [ 'twer-form-group twer-form-group--text' ];
                                            $field_group_placeholder = '';
                                            if ( isset( $field_group['size'] ) ) {
                                              $field_group_class[] = 'twer-form-group--' . $field_group['size'];
                                            }

                                            if ( isset( $field_group['placeholder'] ) ) {
                                              $field_group_placeholder = $field_group['placeholder'];
                                            }
                                            if ( isset( $field_group['postfix'] ) ) {
                                              $field_group_class[] = 'twer-form-group--append';
                                            }

                                            ?>
                                              <div class="<?php echo esc_attr( implode( ' ', $field_group_class ) ); ?>">
                                                  <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                         id="<?php echo esc_attr( $element_id ); ?>"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="large-text"
                                                    <?php echo $data_template; ?>
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                         placeholder="<?php echo esc_attr( $field_group_placeholder ); ?>">
                                                <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                    <div class="twer-form-group-append">
                                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                    </div>
                                                <?php } ?>
                                              </div>
                                          <?php } elseif ( 'select' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--select">
                                                  <select name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                          class="large-select"
                                                    <?php echo $data_template; ?>
                                                          id="<?php echo esc_attr( $element_id ); ?>">
                                                    <?php foreach ( $field_group['value'] as $data ) { ?>
                                                        <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                    <?php } ?>
                                                  </select>
                                              </div>
                                          <?php } elseif ( 'textarea' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--text">
                                                            <textarea class="large-text"
                                                                      name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                      id="<?php echo esc_attr( $element_id ); ?>"
                                                                      cols="30"
                                                                      <?php echo $data_template; ?>
                                                                      rows="6"><?php echo esc_attr( $field_group['value'] ) ?></textarea>
                                              </div>
                                          <?php }
                                          ?>
                                        </div>
                                    <?php } ?>
                                  </div>
                              </div>
                          <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}


function thePopupCustomFields( $customFieldsListNamePostfix = '' ) {
  global $post;
  $prefix = '_treweler_';
  $post_id = isset( $post->ID ) ? $post->ID : '';
  $meta_data = twer_get_data( $post_id );

  $custom_color = get_option( 'treweler_mapbox_colorpicker_custom_color' );
  $defaultColors = '#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|';


  $template_data = [];
  $current_template = isset( $meta_data->templates ) ? $meta_data->templates : 'none';
  if ( 'none' !== $current_template && ! empty( $current_template ) ) {
    $template_data = template_meta_diff( twer_get_data( $current_template ) );
  }


// Get all custom fields
  $all_custom_fields = get_posts( [
    'post_status'    => 'publish',
    'post_type'      => 'twer-custom-fields',
    'numberposts'    => - 1,
    'posts_per_page' => - 1,
    'order'          => 'ASC',
  ] );

  $customFieldsListName = 'custom_fields_list' . $customFieldsListNamePostfix;

  $current_custom_fields_ids = isset( $meta_data->$customFieldsListName ) ? $meta_data->$customFieldsListName : '';

// Get all includes/saved custom fields and save it to array
  $includes_custom_fields_posts = ! empty( $current_custom_fields_ids ) ? get_posts( [
    'post_status' => 'publish',
    'post_type'   => 'twer-custom-fields',
    'orderby'     => 'post__in',
    'include'     => $current_custom_fields_ids
  ] ) : [];


  $fieldNameShowCustomFields = 'custom_field_show' . $customFieldsListNamePostfix;
  $fields_custom_list = template_apply( [

    [
      'type'  => 'checkbox',
      'name'  => $prefix . 'custom_field_show' . $customFieldsListNamePostfix,
      'label' => esc_html__( 'Show Custom Fields', 'treweler' ),
      'value' => [
        [
          'label'   => '',
          'checked' => in_array( $fieldNameShowCustomFields, isset( $meta_data->$fieldNameShowCustomFields ) ? (array) $meta_data->$fieldNameShowCustomFields : [] ),
          'value'   => $fieldNameShowCustomFields
        ]
      ]
    ],
    [
      'tr-class' => 'd-none',
      'label'    => 'fields',
      'type'     => 'text',
      'subtype'  => 'hidden',
      'class'    => 'js-twer-custom-fields-list',
      'name'     => $prefix . 'custom_fields_list' . $customFieldsListNamePostfix,
      'value'    => isset( $meta_data->$customFieldsListName ) ? $meta_data->$customFieldsListName : '',
    ],
  ], $meta_data, $template_data );

  $fields_custom = array_merge(
    $fields_custom_list,
    fill_custom_fields( $includes_custom_fields_posts, $prefix, $meta_data, false, $customFieldsListNamePostfix, 'close' ),
    fill_custom_fields( $all_custom_fields, $prefix, $meta_data, true, $customFieldsListNamePostfix, 'close' )
  );


// Get all excluded/not saved custom fields and save it to array
  $excluded_custom_fields_posts = get_posts( [
    'post_status'    => 'publish',
    'post_type'      => 'twer-custom-fields',
    'posts_per_page' => - 1,
    'numberposts'    => - 1,
    'exclude'        => $current_custom_fields_ids
  ] );


  $select_fields = [
    [
      'label'    => __( 'Select a Field', 'treweler' ),
      'selected' => false,
      'default'  => true,
      'value'    => 'none'
    ]
  ];

  foreach ( $excluded_custom_fields_posts as $excluded_custom_field_post ) {
    $id = isset( $excluded_custom_field_post->ID ) ? $excluded_custom_field_post->ID : 0;
    $label = isset( $excluded_custom_field_post->post_title ) ? $excluded_custom_field_post->post_title : '';
    $meta = twer_get_data( $id );

    if ( empty( $label ) ) {
      $label = sprintf( __( 'Field: %d' ), $id );
    }
    if ( $id ) {
      $select_fields[] = [
        'label'    => $label,
        'selected' => false,
        'value'    => $id
      ];
    }
  }

  $cf_class = '';
  if ( 'none' !== $current_template ) {
    $cf_class = 'd-none';
  }

  $fields_custom[] = [
    'type'     => 'group_simple',
    'tr-class' => $cf_class,
    'name'     => $prefix . 'custom_field_add',
    'label'    => esc_html__( 'Add fields', 'treweler' ),
    'value'    => [
      [
        'type'        => 'select',
        'class_value' => 'col-fixed--200',
        'id'          => uniqid( 'all-custom-fields-' ),
        'name'        => $prefix . 'custom_fields_all',
        'class'       => 'js-custom-fields-list',
        'value'       => $select_fields
      ],
      [
        'type'  => 'button',
        'class' => 'js-add-custom-field',
        'id'    => uniqid( 'add-new-custom-field-' ),
        'label' => __( 'Add Field', 'treweler' )
      ],
    ]
  ];

  ?>
    <div class="table-responsive">
        <table class="table twer-table twer-table--cells-2">
            <tbody class="js-ui-slider-wrap">
            <?php foreach (
              $fields_custom

              as $field
            ) {
              $element_id = isset( $field['id'] ) ? $field['id'] : trim( str_replace( '_', '-', $field['name'] ), '-' );


              $tr_class = [ 'twer-tr-toggle' ];
              $tr_atts = [];

              if ( isset( $field['toggle_row'] ) ) {
                $tr_class[] = 'js-twer-tr-toggle';


                if ( isset( $field['toggle_row']['related_id'] ) ) {
                  $tr_atts[] = 'id="' . $field['toggle_row']['related_id'] . '-toggle"';
                }

                if ( isset( $field['toggle_row']['trigger'] ) ) {
                  $tr_atts[] = 'data-trigger="' . $field['toggle_row']['trigger'] . '"';
                }
              }

              if ( isset( $field['tr-class'] ) ) {
                $tr_class[] = $field['tr-class'];
              }

              $tr_id = '';
              if ( isset( $field['tr-id'] ) ) {
                $tr_id = 'data-id="' . $field['tr-id'] . '"';
              }

              $disableVisibilityField = '';

              if ( in_array( 'js-hidden-item d-none', $tr_class, true ) ) {
                $disableVisibilityField = 'disabled';
              }

              $classFieldType = isset( $field['type'] ) ? $field['type'] : '';
              if ( $classFieldType === 'textarea' ) {
                $classFieldTh = isset( $field['classFieldTh'] ) ? $field['classFieldTh'] : '';
                $tr_class[] = $classFieldTh;
              }

              ?>
                <tr <?php echo $tr_id; ?> class="<?php echo esc_attr( implode( ' ',
                  $tr_class ) ); ?>" <?php echo implode( ' ', $tr_atts ); ?>>
                    <th class="th-<?php echo esc_attr( $element_id ); ?>">
                        <label for="<?php echo esc_attr( $element_id ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
                    </th>
                    <td>
                      <?php
                      $data_template = isset( $field['data_template'] ) ? implode( ' ', $field['data_template'] ) : '';
                      ?>
                        <div class="twer-wrap-fields twer-wrap-fields--sm">

                          <?php if ( isset( $field['tr-id'] ) ) {

                            $action_class = 'none' === $current_template ? '' : 'd-none';
                            $action_style = 'none' === $current_template ? '' : 'style="right:0;"';
                            echo '<a href="#" class="js-twer-ui-del-tr twer-ui-del-tr ' . $action_class . '"></a>';
                            echo '<a href="#" class="js-twer-ui-sort-tr twer-ui-sort-tr ' . $action_class . '"></a>';


                            if ( ! empty( $field['lock_fields'] ) ) {

                              if ( isset( $field['lock_open'] ) ) {
                                $locked = $field['lock_open'] ? 'twer-lock--open' : '';

                                ?>
                                  <div class="twer-defaults d-none" <?php echo $action_style; ?>>
                                    <?php for ( $i = 0; $i < $field['lock_fields']; $i ++ ) {
                                      ?>
                                        <a href="#" class="twer-lock <?php echo esc_attr( $locked ); ?> js-twer-lock" title=""></a>
                                    <?php } ?>
                                  </div>
                                <?php
                              } else {
                                $field_gr = $field['value'];
                                ?>
                                  <div class="twer-defaults d-none" <?php echo $action_style; ?>>
                                    <?php foreach ( $field_gr as $gr ) {
                                      $locked = $gr['lock_open'] ? 'twer-lock--open' : '';
                                      ?>
                                        <a href="#" class="twer-lock <?php echo esc_attr( $locked ); ?> js-twer-lock" title=""></a>
                                    <?php } ?>
                                  </div>
                                <?php
                              }
                            }
                          } else {

                            template_locks( $current_template, $field, $meta_data );
                          } ?>
                          <?php
                          if ( 'select' === $field['type'] ) { ?>
                              <div class="twer-form-group twer-form-group--select">
                                  <select name="<?php echo esc_attr( $field['name'] ); ?>"
                                          class="large-select"
                                    <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?>
                                          id="<?php echo esc_attr( $element_id ); ?>">
                                    <?php foreach ( $field['value'] as $data ) { ?>
                                        <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                          <?php } elseif ( 'checkbox' === $field['type'] ) { ?>
                              <input type="hidden"
                                     name="<?php echo esc_attr( $field['name'] ); ?>"
                                     value="">
                            <?php foreach ( $field['value'] as $data ) { ?>

                                  <label for="<?php echo esc_attr( $element_id ) ?>" <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?> class="twer-switcher">
                                      <input type="checkbox"
                                             name="<?php echo esc_attr( $field['name'] ); ?>[]"
                                             id="<?php echo esc_attr( $element_id ); ?>"
                                             value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                      <div class="twer-switcher__slider"></div>
                                  </label>
                            <?php } ?>
                          <?php } elseif ( 'number' === $field['type'] || 'text' === $field['type'] || 'url' === $field['type'] || 'email' === $field['type'] || 'tel' === $field['type'] ) {

                            $field_class = [ 'twer-form-group twer-form-group--text' ];
                            $field_placeholder = '';
                            if ( isset( $field['size'] ) ) {
                              $field_class[] = 'twer-form-group--' . $field['size'];
                            }

                            if ( isset( $field['placeholder'] ) ) {
                              $field_placeholder = $field['placeholder'];
                            }
                            if ( isset( $field['postfix'] ) ) {
                              $field_class[] = 'twer-form-group--append';
                            }

                            $class = 'large-text';
                            if ( isset( $field['class'] ) ) {
                              $class .= ' ' . $field['class'];
                            }

                            $subtype = '';
                            if ( isset( $field['subtype'] ) ) {
                              $subtype = $field['subtype'];
                            } else {
                              $subtype = $field['type'];
                            }

                            $field_disabled = isset( $field['disabled'] ) ? $field['disabled'] : '';
                            $field_readonly = isset( $field['readonly'] ) ? $field['readonly'] : '';
                            $data_values = isset( $field['data_atts'] ) ? $field['data_atts'] : '';
                            ?>
                              <div class="<?php echo esc_attr( implode( ' ', $field_class ) ); ?>">

                                <?php if ( ! empty( $field['lock_fields'] ) ) { ?>
                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field['lock_name'] ); ?>" value="<?php echo esc_attr( $field['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                <?php } ?>
                                  <input type="<?php echo esc_attr( $subtype ); ?>"
                                         id="<?php echo esc_attr( $element_id ); ?>"
                                         name="<?php echo esc_attr( $field['name'] ); ?>"
                                         class="<?php echo esc_attr( $class ); ?>"
                                         value="<?php echo esc_attr( $field['value'] ) ?>"
                                    <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?>

                                         placeholder="<?php echo esc_attr( $field_placeholder ); ?>" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?>

                                    <?php echo $data_values; ?>
                                  >
                                <?php if ( isset( $field['postfix'] ) ) { ?>
                                    <div class="twer-form-group-append">
                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field['postfix'] ); ?></span>
                                    </div>
                                <?php } ?>
                              </div>
                          <?php } elseif ( 'textarea' === $field['type'] ) {

                            $field_class = [ 'twer-form-group twer-form-group--fwtextarea' ];
                            $field_placeholder = '';

                            if ( isset( $field['placeholder'] ) ) {
                              $field_placeholder = $field['placeholder'];
                            }

                            $class = 'large-text1';
                            if ( isset( $field['class'] ) ) {
                              $class .= ' ' . $field['class'];
                            }

                            $field_disabled = isset( $field['disabled'] ) ? $field['disabled'] : '';
                            $field_readonly = isset( $field['readonly'] ) ? $field['readonly'] : '';
                            $data_values = isset( $field['data_atts'] ) ? $field['data_atts'] : '';
                            ?>
                              <div class="<?php echo esc_attr( implode( ' ', $field_class ) ); ?>">

                                <?php if ( ! empty( $field['lock_fields'] ) ) { ?>
                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field['lock_name'] ); ?>" value="<?php echo esc_attr( $field['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                <?php } ?>
                                  <textarea
                                          id="<?php echo esc_attr( $element_id ); ?>"
                                          name="<?php echo esc_attr( $field['name'] ); ?>"
                                          class="<?php echo esc_attr( $class ); ?>"

                                                                  <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?> cols="61" rows="4"
                                          placeholder="<?php echo esc_attr( $field_placeholder ); ?>" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?>

                                    <?php echo $data_values; ?>
                                                                ><?php echo esc_attr( $field['value'] ) ?></textarea>

                              </div>
                          <?php } elseif ( 'group' === $field['type'] ) {

                            ?>
                              <div class="twer-group-elements">

                                  <div class="row">
                                    <?php foreach ( $field['value'] as $field_group ) {

                                      $element_id_group = isset( $field_group['id'] ) ? $field_group['id'] : trim( str_replace( '_', '-',
                                        $field['name'] . '_' . $field_group['name'] ),
                                        '-' );
                                      $field_group['name'] = $field['name'] . '[' . $field_group['name'] . ']';

                                      $field_class = [];
                                      if ( isset( $field_group['postfix'] ) ) {
                                        $field_class[] = 'twer-form-group--append';
                                      }
                                      $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';

                                      $colClass = [ 'col-fixed' ];


                                      if ( 'colorpicker' === $field_group['type'] || 'textarea' === $field_group['type'] ) {
                                        $colClass = [ 'col-simple' ];
                                      } else {
                                        if ( isset( $field_group['isMultiselect'] ) ) {
                                          $colClass = [ 'col-simple w-445' ];
                                        }
                                      }
                                      ?>
                                        <div class="<?php echo esc_attr( implode( ' ', $colClass ) ); ?>">
                                          <?php if ( ! empty( $field_group['label'] ) ) {
                                            $class = '';
                                            if ( $field_group['place'] === 'inline' ) {
                                              $class = 'class="d-inline-block mb-0 mr-1"';
                                            }
                                            ?>
                                              <label <?php echo $class; ?> for="<?php echo esc_attr( $element_id_group ); ?>"><?php echo esc_attr( $field_group['label'] ); ?></label>
                                          <?php } ?>
                                          <?php if ( 'number' === $field_group['type'] || 'text' === $field_group['type'] || 'url' === $field_group['type'] || 'email' === $field_group['type'] || 'tel' === $field_group['type'] ) {
                                            $field_placeholder = '';
                                            if ( isset( $field_group['placeholder'] ) ) {
                                              $field_placeholder = $field_group['placeholder'];
                                            }

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>
                                              <div class="twer-form-group twer-form-group--text <?php echo esc_attr( implode( ' ', $field_class ) ); ?>">

                                                <?php
                                                if ( ! empty( $field_group['lock_fields'] ) ) {

                                                  ?>
                                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                                <?php } ?>

                                                  <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                         id="<?php echo esc_attr( $element_id_group ); ?>"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="large-text"
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                         placeholder="<?php echo esc_attr( $field_placeholder ); ?>"
                                                    <?php echo $field_disabled; ?>
                                                    <?php echo $data_values; ?>
                                                    <?php echo $field_readonly; ?>
                                                    <?php echo $data_template; ?>
                                                  >
                                                <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                    <div class="twer-form-group-append">
                                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                    </div>
                                                <?php } ?>
                                              </div>


                                          <?php } elseif ( 'textarea' === $field_group['type'] ) {
                                            $field_placeholder = '';
                                            if ( isset( $field_group['placeholder'] ) ) {
                                              $field_placeholder = $field_group['placeholder'];
                                            }

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>
                                              <div class="twer-form-group twer-form-group--fwtextarea">

                                                <?php
                                                if ( ! empty( $field_group['lock_fields'] ) ) {

                                                  ?>
                                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                                <?php } ?>

                                                  <textarea
                                                          id="<?php echo esc_attr( $element_id_group ); ?>"
                                                          name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                          class="large-text" cols="61" rows="13"
                                                          placeholder="<?php echo esc_attr( $field_placeholder ); ?>"
                                  <?php echo $field_disabled; ?>
                                                    <?php echo $data_values; ?>
                                                    <?php echo $field_readonly; ?>
                                                    <?php echo $data_template; ?>
                                ><?php echo $field_group['value'] ?></textarea>
                                              </div>

                                            <?php
                                          } elseif ( 'select' === $field_group['type'] ) {

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>

                                            <?php
                                            if ( ! empty( $field_group['lock_fields'] ) ) {

                                              ?>
                                                <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                            <?php } ?>


                                              <div class="twer-form-group twer-form-group--select">
                                                <?php if ( isset( $field_group['isMultiselect'] ) ) { ?>
                                                    <input type="hidden"
                                                           name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                           value="" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?> <?php echo $data_values; ?>>
                                                <?php } ?>

                                                <?php $slectName = $field_group['name'];

                                                if ( isset( $field_group['isMultiselect'] ) ) {

                                                  $slectName .= '[]';
                                                }
                                                $cls = isset( $field_group['class'] ) ? implode( ' ', $field_group['class'] ) : ''

                                                ?>
                                                  <select name="<?php echo esc_attr( $slectName ); ?>"
                                                          class="large-select <?php echo esc_attr( $cls ); ?>"


                                                    <?php echo $field_disabled; ?>
                                                    <?php echo $data_values; ?>
                                                    <?php echo $field_readonly; ?>


                                                    <?php echo $data_template; ?>
                                                    <?php echo 'id="' . esc_attr( $element_id_group ) . '"'; ?>>
                                                    <?php foreach ( $field_group['value'] as $data ) { ?>
                                                        <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                    <?php } ?>
                                                  </select>
                                              </div>


                                          <?php } elseif ( 'colorpicker' === $field_group['type'] ) { ?>
                                              <div class="js-twer-color-picker-wrap twer-color-picker-wrap" <?php echo $data_template; ?>>
                                                  <div class="map-text-color js-twer-color-picker">
                                                                                    <span class="color-holder"
                                                                                          style="background-color:<?php echo esc_attr( $field_group['value'] ) ?>;"></span>
                                                      <input type="button"
                                                             class="text-color-picker-btn"
                                                             value="<?php echo esc_attr__( 'Select Color',
                                                               'treweler' ); ?>">
                                                  </div>
                                                  <!-- .color-picker-text-descr -->
                                                  <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                       acp-color="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                       acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                       default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                       acp-show-rgb="no"
                                                       acp-show-hsl="no"
                                                       acp-palette-editable>
                                                  </div>
                                                  <input type="hidden"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="input-color input-color-field"
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                              </div>
                                          <?php } elseif ( 'checkbox' === $field_group['type'] ) {

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>
                                            <?php if ( ! empty( $field_group['lock_fields'] ) ) { ?>
                                                  <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                            <?php } ?>

                                              <input type="hidden"
                                                     name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                     value="" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?> <?php echo $data_values; ?>>
                                            <?php foreach ( $field_group['value'] as $data ) { ?>

                                                  <label for="<?php echo esc_attr( $element_id_group ) ?>" <?php echo $data_template; ?>
                                                         class="twer-switcher">
                                                      <input type="checkbox"
                                                        <?php echo $data_values; ?>
                                                        <?php echo $field_disabled; ?>
                                                        <?php echo $field_readonly; ?>
                                                             name="<?php echo esc_attr( $field_group['name'] ); ?>[]"
                                                             id="<?php echo esc_attr( $element_id_group ); ?>"
                                                             value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                      <div class="twer-switcher__slider"></div>
                                                  </label>
                                            <?php } ?>
                                          <?php } ?>
                                        </div>
                                    <?php } ?>
                                  </div>
                              </div>
                          <?php } elseif ( 'group_simple' === $field['type'] ) { ?>
                              <div class="twer-group-elements">
                                  <div class="row">
                                    <?php
                                    $simple_counter = 0;
                                    foreach ( $field['value'] as $field_group ) {
                                      $simple_counter ++;
                                      $class_simple = '';


                                      if ( isset( $field_group['class_value'] ) ) {
                                        $class_simple = $field_group['class_value'];
                                      } else {
                                        switch ( $simple_counter ) {
                                          case '1' :
                                            $class_simple = 'col-fixed--130';
                                            break;
                                          case '2' :
                                            $class_simple = 'col-fixed--200';
                                            break;
                                          case '3' :
                                            $class_simple = 'col-fixed--200';
                                            break;
                                        }
                                      }
                                      $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';
                                      ?>
                                        <div class="<?php echo 'colorpicker' === $field_group['type'] ? 'col-simple' : 'col-fixed ' . $class_simple ?>">
                                          <?php

                                          if ( 'button' === $field_group['type'] ) {

                                            echo '<a href="#" class="button button-primary ' . esc_attr( $field_group['class'] ) . '" title="' . esc_attr( $field_group['label'] ) . '">' . esc_html( $field_group['label'] ) . '</a>';
                                          } elseif ( 'text' === $field_group['type'] || 'url' === $field_group['type'] ) {

                                            $field_group_class = [ 'twer-form-group twer-form-group--text' ];
                                            $field_group_placeholder = '';
                                            if ( isset( $field_group['size'] ) ) {
                                              $field_group_class[] = 'twer-form-group--' . $field_group['size'];
                                            }

                                            if ( isset( $field_group['placeholder'] ) ) {
                                              $field_group_placeholder = $field_group['placeholder'];
                                            }
                                            if ( isset( $field_group['postfix'] ) ) {
                                              $field_group_class[] = 'twer-form-group--append';
                                            }

                                            ?>
                                              <div class="<?php echo esc_attr( implode( ' ', $field_group_class ) ); ?>">
                                                  <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                         id="<?php echo esc_attr( $element_id ); ?>"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="large-text"
                                                    <?php echo $data_template; ?>
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                         placeholder="<?php echo esc_attr( $field_group_placeholder ); ?>">
                                                <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                    <div class="twer-form-group-append">
                                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                    </div>
                                                <?php } ?>
                                              </div>
                                          <?php } elseif ( 'select' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--select">
                                                <?php $classSelect = isset( $field_group['class'] ) ? $field_group['class'] : ''; ?>
                                                <?php $idSelect = isset( $field_group['id'] ) ? $field_group['id'] : $element_id; ?>
                                                  <select name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                          class="large-select <?php echo esc_attr( $classSelect ); ?>"
                                                    <?php echo $data_template; ?>
                                                          id="<?php echo esc_attr( $idSelect ); ?>">
                                                    <?php foreach ( $field_group['value'] as $data ) {
                                                      if ( isset( $data['default'] ) ) {
                                                        ?>
                                                          <option value="<?php echo esc_attr( $data['value'] ) ?>"><?php echo esc_html( $data['label'] ); ?></option>
                                                        <?php
                                                      } else {
                                                        ?>
                                                          <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                        <?php
                                                      }
                                                    } ?>
                                                  </select>
                                              </div>
                                          <?php } elseif ( 'textarea' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--text">
                                                            <textarea class="large-text"
                                                                      name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                      id="<?php echo esc_attr( $element_id ); ?>"
                                                                      cols="30"
                                                                      rows="6"><?php echo esc_attr( $field_group['value'] ) ?></textarea>
                                              </div>
                                          <?php }
                                          ?>
                                        </div>
                                    <?php } ?>
                                  </div>
                              </div>
                          <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
  <?php
}

function theUniqueCustomFields($customFieldsListNamePostfix = '') {
  global $post;
  $prefix = '_treweler_';
  $post_id = isset( $post->ID ) ? $post->ID : '';
  $meta_data = twer_get_data( $post_id );

  $current_template = twerGetTemplateIdForPost();

  $data = [];
  if ( 'yes' === twerIsPostTemplateApplied() ) {
    $data = template_meta_diff( twer_get_data( $current_template ) );
    $uniqueCustomFieldsIds = twerGetUniqueCustomFieldsIds( $current_template );
  } else {
    $uniqueCustomFieldsIds = twerGetUniqueCustomFieldsIds($post_id);
  }
    // Get all custom fields
  $all_custom_fields = get_posts( [
    'post_status'    => 'publish',
    'post_type'      => 'twer-custom-fields',
    'numberposts'    => - 1,
    'posts_per_page' => - 1,
    'order'          => 'ASC',
  ] );


  $customFieldsListNameUnique = 'custom_fields_list_unique';

// Get all includes/saved custom fields and save it to array
  $includes_custom_fields_posts = ! empty( $uniqueCustomFieldsIds ) ? get_posts( [
    'post_status' => 'publish',
    'post_type'   => 'twer-custom-fields',
    'orderby'     => 'post__in',
    'include'     => $uniqueCustomFieldsIds
  ] ) : [];


  $fields_custom_list = template_apply( [
    [
      'tr-class' => 'd-none',
      'label'    => 'fields',
      'type'     => 'text',
      'subtype'  => 'hidden',
      'class'    => 'js-twer-custom-fields-list',
      'name'     => $prefix . 'custom_fields_list_unique',
      'value'    => isset( $meta_data->$customFieldsListNameUnique ) ? $meta_data->$customFieldsListNameUnique : '',
    ],
  ], $meta_data, $data );

  $fields_custom = array_merge(
    $fields_custom_list,
    fill_custom_fields( $includes_custom_fields_posts, $prefix, $meta_data, false, $customFieldsListNamePostfix ),
    fill_custom_fields( $all_custom_fields, $prefix, $meta_data, true, $customFieldsListNamePostfix )
  );


// Get all excluded/not saved custom fields and save it to array
  $excluded_custom_fields_posts = get_posts( [
    'post_status'    => 'publish',
    'post_type'      => 'twer-custom-fields',
    'posts_per_page' => - 1,
    'numberposts'    => - 1,
    'exclude'        => $uniqueCustomFieldsIds
  ] );


  $select_fields = [
    [
      'label'    => __( 'Select a Field', 'treweler' ),
      'selected' => false,
      'default'  => true,
      'value'    => 'none'
    ]
  ];

  foreach ( $excluded_custom_fields_posts as $excluded_custom_field_post ) {
    $id = isset( $excluded_custom_field_post->ID ) ? $excluded_custom_field_post->ID : 0;
    $label = isset( $excluded_custom_field_post->post_title ) ? $excluded_custom_field_post->post_title : '';
    $meta = twer_get_data( $id );

    if ( empty( $label ) ) {
      $label = sprintf( __( 'Field: %d' ), $id );
    }
    if ( $id ) {
      $select_fields[] = [
        'label'    => $label,
        'selected' => false,
        'value'    => $id
      ];
    }
  }

  $fields_custom[] = [
    'type'     => 'group_simple',
    'tr-class' => 'd-none d-none-hard',
    'name'     => $prefix . 'custom_field_add',
    'label'    => esc_html__( 'Add fields', 'treweler' ),
    'value'    => [
      [
        'type'        => 'select',
        'class_value' => 'col-fixed--200',
        'id'    => uniqid( 'all-custom-fields-' ),
        'name'        => $prefix . 'custom_fields_all',
        'class' => 'js-custom-fields-list',
        'value'       => $select_fields
      ],
      [
        'type'  => 'button',
        'class' => 'js-add-custom-field',
        'id'    => uniqid( 'add-new-custom-field-' ),
        'label' => __( 'Add Field', 'treweler' )
      ],
    ]
  ];

  ?>
    <div class="table-responsive">
        <table class="table twer-table twer-table--cells-2">
            <tbody class="js-ui-slider-wrap">
            <?php foreach (
              $fields_custom

              as $field
            ) {
              $element_id = isset($field['id']) ? $field['id'] : trim( str_replace( '_', '-', $field['name'] ), '-' );


              $tr_class = [ 'twer-tr-toggle' ];
              $tr_atts = [];

              if ( isset( $field['toggle_row'] ) ) {
                $tr_class[] = 'js-twer-tr-toggle';


                if ( isset( $field['toggle_row']['related_id'] ) ) {
                  $tr_atts[] = 'id="' . $field['toggle_row']['related_id'] . '-toggle"';
                }

                if ( isset( $field['toggle_row']['trigger'] ) ) {
                  $tr_atts[] = 'data-trigger="' . $field['toggle_row']['trigger'] . '"';
                }
              }

              if ( isset( $field['tr-class'] ) ) {
                $tr_class[] = $field['tr-class'];
              }

              $tr_id = '';
              if ( isset( $field['tr-id'] ) ) {
                $tr_id = 'data-id="' . $field['tr-id'] . '"';
              }

              $disableVisibilityField = '';

              if ( in_array( 'js-hidden-item d-none', $tr_class, true ) ) {
                $disableVisibilityField = 'disabled';
              }

              $classFieldType = isset( $field['type'] ) ? $field['type'] : '';
              if ( $classFieldType === 'textarea' ) {
                $classFieldTh = isset( $field['classFieldTh'] ) ? $field['classFieldTh'] : '';
                $tr_class[] = $classFieldTh;
              }

              ?>
                <tr <?php echo $tr_id; ?> class="<?php echo esc_attr( implode( ' ',
                  $tr_class ) ); ?>" <?php echo implode( ' ', $tr_atts ); ?>>
                    <th class="th-<?php echo esc_attr( $element_id ); ?>">
                        <label for="<?php echo esc_attr( $element_id ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
                    </th>
                    <td>
                      <?php
                      $data_template = isset( $field['data_template'] ) ? implode( ' ', $field['data_template'] ) : '';
                      ?>
                        <div class="twer-wrap-fields">

                          <?php if ( isset( $field['tr-id'] ) ) {

                            $action_class = 'none' === $current_template ? '' : 'd-none';
                            $action_style = 'none' === $current_template ? '' : 'style="right:0;"';
                            echo '<a href="#" class="js-twer-ui-del-tr twer-ui-del-tr ' . $action_class . '"></a>';
                            echo '<a href="#" class="js-twer-ui-sort-tr twer-ui-sort-tr ' . $action_class . '"></a>';


                            if ( ! empty( $field['lock_fields'] ) ) {

                              if ( isset( $field['lock_open'] ) ) {
                                $locked = $field['lock_open'] ? 'twer-lock--open' : '';

                                ?>
                                  <div class="twer-defaults" <?php echo $action_style; ?>>
                                    <?php for ( $i = 0; $i < $field['lock_fields']; $i ++ ) {
                                      ?>
                                        <a href="#" class="twer-lock <?php echo esc_attr( $locked ); ?> js-twer-lock" title=""></a>
                                    <?php } ?>
                                  </div>
                                <?php
                              } else {
                                $field_gr = $field['value'];
                                ?>
                                  <div class="twer-defaults" <?php echo $action_style; ?>>
                                    <?php foreach ( $field_gr as $gr ) {
                                      $locked = $gr['lock_open'] ? 'twer-lock--open' : '';
                                      ?>
                                        <a href="#" class="twer-lock <?php echo esc_attr( $locked ); ?> js-twer-lock" title=""></a>
                                    <?php } ?>
                                  </div>
                                <?php
                              }
                            }
                          } else {

                            template_locks( $current_template, $field, $meta_data );
                          } ?>
                          <?php
                          if ( 'select' === $field['type'] ) { ?>
                              <div class="twer-form-group twer-form-group--select">
                                  <select name="<?php echo esc_attr( $field['name'] ); ?>"
                                          class="large-select"
                                    <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?>
                                          id="<?php echo esc_attr( $element_id ); ?>">
                                    <?php foreach ( $field['value'] as $data ) { ?>
                                        <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                          <?php } elseif ( 'checkbox' === $field['type'] ) { ?>
                              <input type="hidden"
                                     name="<?php echo esc_attr( $field['name'] ); ?>"
                                     value="">
                            <?php foreach ( $field['value'] as $data ) { ?>

                                  <label for="<?php echo esc_attr( $element_id ) ?>" <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?> class="twer-switcher">
                                      <input type="checkbox"
                                             name="<?php echo esc_attr( $field['name'] ); ?>[]"
                                             id="<?php echo esc_attr( $element_id ); ?>"
                                             value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                      <div class="twer-switcher__slider"></div>
                                  </label>
                            <?php } ?>
                          <?php } elseif ( 'number' === $field['type'] || 'text' === $field['type'] || 'url' === $field['type'] || 'email' === $field['type'] || 'tel' === $field['type'] ) {

                            $field_class = [ 'twer-form-group twer-form-group--text' ];
                            $field_placeholder = '';
                            if ( isset( $field['size'] ) ) {
                              $field_class[] = 'twer-form-group--' . $field['size'];
                            }

                            if ( isset( $field['placeholder'] ) ) {
                              $field_placeholder = $field['placeholder'];
                            }
                            if ( isset( $field['postfix'] ) ) {
                              $field_class[] = 'twer-form-group--append';
                            }

                            $class = 'large-text';
                            if ( isset( $field['class'] ) ) {
                              $class .= ' ' . $field['class'];
                            }

                            $subtype = '';
                            if ( isset( $field['subtype'] ) ) {
                              $subtype = $field['subtype'];
                            } else {
                              $subtype = $field['type'];
                            }

                            $field_disabled = isset( $field['disabled'] ) ? $field['disabled'] : '';
                            $field_readonly = isset( $field['readonly'] ) ? $field['readonly'] : '';
                            $data_values = isset( $field['data_atts'] ) ? $field['data_atts'] : '';
                            ?>
                              <div class="<?php echo esc_attr( implode( ' ', $field_class ) ); ?>">

                                <?php if ( ! empty( $field['lock_fields'] ) ) { ?>
                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field['lock_name'] ); ?>" value="<?php echo esc_attr( $field['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                <?php } ?>
                                  <input type="<?php echo esc_attr( $subtype ); ?>"
                                         id="<?php echo esc_attr( $element_id ); ?>"
                                         name="<?php echo esc_attr( $field['name'] ); ?>"
                                         class="<?php echo esc_attr( $class ); ?>"
                                         value="<?php echo esc_attr( $field['value'] ) ?>"
                                    <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?>

                                         placeholder="<?php echo esc_attr( $field_placeholder ); ?>" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?>

                                    <?php echo $data_values; ?>
                                  >
                                <?php if ( isset( $field['postfix'] ) ) { ?>
                                    <div class="twer-form-group-append">
                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field['postfix'] ); ?></span>
                                    </div>
                                <?php } ?>
                              </div>
                          <?php } elseif ( 'textarea' === $field['type'] ) {

                            $field_class = [ 'twer-form-group twer-form-group--fwtextarea' ];
                            $field_placeholder = '';

                            if ( isset( $field['placeholder'] ) ) {
                              $field_placeholder = $field['placeholder'];
                            }

                            $class = 'large-text1';
                            if ( isset( $field['class'] ) ) {
                              $class .= ' ' . $field['class'];
                            }

                            $field_disabled = isset( $field['disabled'] ) ? $field['disabled'] : '';
                            $field_readonly = isset( $field['readonly'] ) ? $field['readonly'] : '';
                            $data_values = isset( $field['data_atts'] ) ? $field['data_atts'] : '';
                            ?>
                              <div class="<?php echo esc_attr( implode( ' ', $field_class ) ); ?>">

                                <?php if ( ! empty( $field['lock_fields'] ) ) { ?>
                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field['lock_name'] ); ?>" value="<?php echo esc_attr( $field['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                <?php } ?>
                                  <textarea
                                          id="<?php echo esc_attr( $element_id ); ?>"
                                          name="<?php echo esc_attr( $field['name'] ); ?>"
                                          class="<?php echo esc_attr( $class ); ?>"

                                                                  <?php echo isset( $field['tr-id'] ) ? '' : $data_template; ?> cols="61" rows="4"
                                          placeholder="<?php echo esc_attr( $field_placeholder ); ?>" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?>

                                    <?php echo $data_values; ?>
                                                                ><?php echo esc_attr( $field['value'] ) ?></textarea>

                              </div>
                          <?php } elseif ( 'group' === $field['type'] ) {

                            ?>
                              <div class="twer-group-elements">

                                  <div class="row">
                                    <?php foreach ( $field['value'] as $field_group ) {

                                      $element_id_group = isset($field_group['id'] ) ? $field_group['id'] : trim( str_replace( '_', '-',
                                        $field['name'] . '_' . $field_group['name'] ),
                                        '-' );
                                      $field_group['name'] = $field['name'] . '[' . $field_group['name'] . ']';

                                      $field_class = [];
                                      if ( isset( $field_group['postfix'] ) ) {
                                        $field_class[] = 'twer-form-group--append';
                                      }
                                      $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';

                                      $colClass = [ 'col-fixed' ];


                                      if ( 'colorpicker' === $field_group['type'] || 'textarea' === $field_group['type'] ) {
                                        $colClass = [ 'col-simple' ];
                                      } else {
                                        if ( isset( $field_group['isMultiselect'] ) ) {
                                          $colClass = [ 'col-simple w-445' ];
                                        }
                                      }
                                      ?>
                                        <div class="<?php echo esc_attr( implode( ' ', $colClass ) ); ?>">
                                          <?php if ( ! empty( $field_group['label'] ) ) {
                                            $class = '';
                                            if ( $field_group['place'] === 'inline' ) {
                                              $class = 'class="d-inline-block mb-0 mr-1"';
                                            }
                                            ?>
                                              <label <?php echo $class; ?> for="<?php echo esc_attr( $element_id_group ); ?>"><?php echo esc_attr( $field_group['label'] ); ?></label>
                                          <?php } ?>
                                          <?php if ( 'number' === $field_group['type'] || 'text' === $field_group['type'] || 'url' === $field_group['type'] || 'email' === $field_group['type'] || 'tel' === $field_group['type'] ) {
                                            $field_placeholder = '';
                                            if ( isset( $field_group['placeholder'] ) ) {
                                              $field_placeholder = $field_group['placeholder'];
                                            }

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>
                                              <div class="twer-form-group twer-form-group--text <?php echo esc_attr( implode( ' ', $field_class ) ); ?>">

                                                <?php
                                                if ( ! empty( $field_group['lock_fields'] ) ) {

                                                  ?>
                                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                                <?php } ?>

                                                  <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                         id="<?php echo esc_attr( $element_id_group ); ?>"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="large-text"
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                         placeholder="<?php echo esc_attr( $field_placeholder ); ?>"
                                                    <?php echo $field_disabled; ?>
                                                    <?php echo $data_values; ?>
                                                    <?php echo $field_readonly; ?>
                                                    <?php echo $data_template; ?>
                                                  >
                                                <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                    <div class="twer-form-group-append">
                                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                    </div>
                                                <?php } ?>
                                              </div>


                                          <?php }  elseif ( 'textarea' === $field_group['type'] ) {
                                            $field_placeholder = '';
                                            if ( isset( $field_group['placeholder'] ) ) {
                                              $field_placeholder = $field_group['placeholder'];
                                            }

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>
                                              <div class="twer-form-group twer-form-group--fwtextarea">

                                                <?php
                                                if ( ! empty( $field_group['lock_fields'] ) ) {

                                                  ?>
                                                    <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                                <?php } ?>

                                                  <textarea
                                                          id="<?php echo esc_attr( $element_id_group ); ?>"
                                                          name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                          class="large-text" cols="61" rows="13"
                                                          placeholder="<?php echo esc_attr( $field_placeholder ); ?>"
                                  <?php echo $field_disabled; ?>
                                                    <?php echo $data_values; ?>
                                                    <?php echo $field_readonly; ?>
                                                    <?php echo $data_template; ?>
                                ><?php echo $field_group['value'] ?></textarea>
                                              </div>

                                            <?php
                                          } elseif ( 'select' === $field_group['type'] ) {

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>

                                            <?php
                                            if ( ! empty( $field_group['lock_fields'] ) ) {

                                              ?>
                                                <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                            <?php } ?>


                                              <div class="twer-form-group twer-form-group--select">
                                                <?php if ( isset( $field_group['isMultiselect'] ) ) { ?>
                                                    <input type="hidden"
                                                           name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                           value="" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?> <?php echo $data_values; ?>>
                                                <?php } ?>

                                                <?php $slectName = $field_group['name'];

                                                if ( isset( $field_group['isMultiselect'] ) ) {

                                                  $slectName .= '[]';
                                                }
                                                $cls = isset( $field_group['class'] ) ? implode( ' ', $field_group['class'] ) : ''

                                                ?>
                                                  <select name="<?php echo esc_attr( $slectName ); ?>"
                                                          class="large-select <?php echo esc_attr( $cls ); ?>"


                                                    <?php echo $field_disabled; ?>
                                                    <?php echo $data_values; ?>
                                                    <?php echo $field_readonly; ?>


                                                    <?php echo $data_template; ?>
                                                    <?php echo 'id="' . esc_attr( $element_id_group ) . '"'; ?>>
                                                    <?php foreach ( $field_group['value'] as $data ) { ?>
                                                        <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                    <?php } ?>
                                                  </select>
                                              </div>


                                          <?php } elseif ( 'colorpicker' === $field_group['type'] ) { ?>
                                              <div class="js-twer-color-picker-wrap twer-color-picker-wrap" <?php echo $data_template; ?>>
                                                  <div class="map-text-color js-twer-color-picker">
                                                                                    <span class="color-holder"
                                                                                          style="background-color:<?php echo esc_attr( $field_group['value'] ) ?>;"></span>
                                                      <input type="button"
                                                             class="text-color-picker-btn"
                                                             value="<?php echo esc_attr__( 'Select Color',
                                                               'treweler' ); ?>">
                                                  </div>
                                                  <!-- .color-picker-text-descr -->
                                                  <div class="js-twer-color-picker-palette twer-color-picker-palette"
                                                       acp-color="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                       acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                       default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                       acp-show-rgb="no"
                                                       acp-show-hsl="no"
                                                       acp-palette-editable>
                                                  </div>
                                                  <input type="hidden"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="input-color input-color-field"
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                              </div>
                                          <?php } elseif ( 'checkbox' === $field_group['type'] ) {

                                            $field_disabled = isset( $field_group['disabled'] ) ? $field_group['disabled'] : '';
                                            $field_readonly = isset( $field_group['readonly'] ) ? $field_group['readonly'] : '';
                                            $data_values = isset( $field_group['data_atts'] ) ? $field_group['data_atts'] : '';
                                            ?>
                                            <?php if ( ! empty( $field_group['lock_fields'] ) ) { ?>
                                                  <input type="hidden" class="js-twer-lock-status" name="<?php echo esc_attr( $field_group['lock_name'] ); ?>" value="<?php echo esc_attr( $field_group['lock_value'] ) ?>" <?php echo $field_disabled; ?>>
                                            <?php } ?>

                                              <input type="hidden"
                                                     name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                     value="" <?php echo $field_disabled; ?> <?php echo $field_readonly; ?> <?php echo $data_values; ?>>
                                            <?php foreach ( $field_group['value'] as $data ) { ?>

                                                  <label for="<?php echo esc_attr( $element_id_group ) ?>" <?php echo $data_template; ?>
                                                         class="twer-switcher">
                                                      <input type="checkbox"
                                                        <?php echo $data_values; ?>
                                                        <?php echo $field_disabled; ?>
                                                        <?php echo $field_readonly; ?>
                                                             name="<?php echo esc_attr( $field_group['name'] ); ?>[]"
                                                             id="<?php echo esc_attr( $element_id_group ); ?>"
                                                             value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                      <div class="twer-switcher__slider"></div>
                                                  </label>
                                            <?php } ?>
                                          <?php } ?>
                                        </div>
                                    <?php } ?>
                                  </div>
                              </div>
                          <?php } elseif ( 'group_simple' === $field['type'] ) { ?>
                              <div class="twer-group-elements">
                                  <div class="row">
                                    <?php
                                    $simple_counter = 0;
                                    foreach ( $field['value'] as $field_group ) {
                                      $simple_counter ++;
                                      $class_simple = '';


                                      if ( isset( $field_group['class_value'] ) ) {
                                        $class_simple = $field_group['class_value'];
                                      } else {
                                        switch ( $simple_counter ) {
                                          case '1' :
                                            $class_simple = 'col-fixed--130';
                                            break;
                                          case '2' :
                                            $class_simple = 'col-fixed--200';
                                            break;
                                          case '3' :
                                            $class_simple = 'col-fixed--200';
                                            break;
                                        }
                                      }
                                      $data_template = isset( $field_group['data_template'] ) ? implode( ' ', $field_group['data_template'] ) : '';
                                      ?>
                                        <div class="<?php echo 'colorpicker' === $field_group['type'] ? 'col-simple' : 'col-fixed ' . $class_simple ?>">
                                          <?php

                                          if ( 'button' === $field_group['type'] ) {

                                            echo '<a href="#" class="button button-primary ' . esc_attr( $field_group['class'] ) . '" title="' . esc_attr( $field_group['label'] ) . '">' . esc_html( $field_group['label'] ) . '</a>';
                                          } elseif ( 'text' === $field_group['type'] || 'url' === $field_group['type'] ) {

                                            $field_group_class = [ 'twer-form-group twer-form-group--text' ];
                                            $field_group_placeholder = '';
                                            if ( isset( $field_group['size'] ) ) {
                                              $field_group_class[] = 'twer-form-group--' . $field_group['size'];
                                            }

                                            if ( isset( $field_group['placeholder'] ) ) {
                                              $field_group_placeholder = $field_group['placeholder'];
                                            }
                                            if ( isset( $field_group['postfix'] ) ) {
                                              $field_group_class[] = 'twer-form-group--append';
                                            }

                                            ?>
                                              <div class="<?php echo esc_attr( implode( ' ', $field_group_class ) ); ?>">
                                                  <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                         id="<?php echo esc_attr( $element_id ); ?>"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                         class="large-text"
                                                    <?php echo $data_template; ?>
                                                         value="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                         placeholder="<?php echo esc_attr( $field_group_placeholder ); ?>">
                                                <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                    <div class="twer-form-group-append">
                                                        <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                    </div>
                                                <?php } ?>
                                              </div>
                                          <?php } elseif ( 'select' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--select">
                                                <?php $classSelect = isset($field_group['class']) ? $field_group['class'] : ''; ?>
                                                <?php $idSelect = isset($field_group['id']) ? $field_group['id'] : $element_id; ?>
                                                  <select name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                          class="large-select <?php echo esc_attr( $classSelect ); ?>"
                                                    <?php echo $data_template; ?>
                                                          id="<?php echo esc_attr( $idSelect ); ?>">
                                                    <?php foreach ( $field_group['value'] as $data ) {
                                                      if ( isset( $data['default'] ) ) {
                                                        ?>
                                                          <option value="<?php echo esc_attr( $data['value'] ) ?>"><?php echo esc_html( $data['label'] ); ?></option>
                                                        <?php
                                                      } else {
                                                        ?>
                                                          <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                        <?php
                                                      }
                                                    } ?>
                                                  </select>
                                              </div>
                                          <?php } elseif ( 'textarea' === $field_group['type'] ) { ?>
                                              <div class="twer-form-group twer-form-group--text">
                                                            <textarea class="large-text"
                                                                      name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                      id="<?php echo esc_attr( $element_id ); ?>"
                                                                      cols="30"
                                                                      rows="6"><?php echo esc_attr( $field_group['value'] ) ?></textarea>
                                              </div>
                                          <?php }
                                          ?>
                                        </div>
                                    <?php } ?>
                                  </div>
                              </div>
                          <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
  <?php
}

