<?php

function theStoreLocatorFields( $fields_store_locator ) {
  $custom_color = get_option( 'treweler_mapbox_colorpicker_custom_color' );
  $defaultColors = '#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|';
  ?>
    <div class="table-responsive">
        <table class="table twer-table twer-table--cells-2">
            <tbody>

            <?php foreach (
              $fields_store_locator

              as $field
            ) {
              $element_id = trim( str_replace( '_', '-', $field['name'] ), '-' );
              if ( isset( $field['id'] ) ) {
                $element_id = $field['id'];
              }

              $rowClass = isset( $field['row_class'] ) ? $field['row_class'] : '';
              ?>
                <tr class="section-<?php echo esc_attr( $element_id ); ?> <?php echo esc_attr( $rowClass ); ?>">
                  <?php if ( 'table' !== $field['type'] ) { ?>
                      <th class="th-<?php echo esc_attr( $element_id ); ?>">
                          <label for="<?php echo esc_attr( $element_id ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
                      </th>
                  <?php } ?>
                    <td <?php echo 'table' === $field['type'] ? 'colspan="2"' : ''; ?>>
                      <?php if ( 'select' === $field['type'] ) { ?>
                          <div class="twer-form-group twer-form-group--select <?php echo ! empty( $field['help'] ) ? 'twer-form-group--select-group' : ''; ?>">
                              <select name="<?php echo esc_attr( $field['name'] ); ?>"
                                      class="large-select"
                                      id="<?php echo esc_attr( $element_id ); ?>">
                                <?php foreach ( $field['value'] as $data ) { ?>
                                    <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                <?php } ?>
                              </select>

                            <?php if ( ! empty( $field['help'] ) ) { ?>
                                <a href="#" class="twer-help-tooltip"
                                   data-toggle="tooltip"
                                   title="<?php echo esc_attr( $field['help'] ); ?>"><span
                                            class="dashicons dashicons-editor-help"></span></a>
                            <?php } ?>
                          </div>
                      <?php } elseif ( 'table' === $field['type'] ) { ?>
                          <div class="twer-regions" style="margin: 0 -15px;">
                              <div class="container-fluid">
                                  <div class="table-responsive">
                                      <table id="js-twer-regions-datatable" class="table twer-table twer-table-mini table-hover" width="100%">
                                          <thead>
                                          <tr>
                                              <th class="no-sort th-all">
                                                  <label for="twer-active-all-regions" class="twer-switcher">
                                                      <input type="checkbox" class="js-twer-active-all-regions" id="twer-active-all-regions" value="active-all-regions">
                                                      <span class="twer-switcher__slider"></span>
                                                  </label>
                                              </th>
                                              <th class="th-name w-25"><?php echo esc_html__( 'Name', 'treweler' ) ?></th>
                                              <th class="w-25"><?php echo esc_html__( 'Region', 'treweler' ) ?></th>
                                              <th class="no-sort th-color"><?php echo esc_html__( 'Custom Color', 'treweler' ); ?></th>
                                              <th class="th-val no-sort"><?php echo esc_html__( 'Value', 'treweler' ) ?></th>
                                              <th class="no-sort th-all">
                                                <?php echo esc_html__( 'Hide', 'treweler' ); ?>&nbsp;
                                                  <label for="twer-hide-all-regions" class="twer-switcher">
                                                      <input type="checkbox" class="js-twer-hide-all-regions" id="twer-hide-all-regions" value="hide-all-regions">
                                                      <span class="twer-switcher__slider"></span>
                                                  </label>
                                              </th>
                                          </tr>
                                          </thead>
                                          <tbody></tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      <?php } elseif ( 'number-v2' === $field['type'] ) {
                        $num_value = $field['value']['current'] ?? '';
                        $num_min = $field['value']['min'] ?? '';
                        $num_max = $field['value']['max'] ?? '';
                        $num_step = $field['value']['step'] ?? '';
                        ?>
                          <div class="twer-form-group twer-form-group--text">
                              <input type="number"
                                     name="<?php echo esc_attr( $field['name'] ); ?>"
                                     id="<?php echo esc_attr( $element_id ); ?>"
                                     value="<?php echo esc_attr( $num_value ) ?>"
                                     step="<?php echo esc_attr( $num_step ); ?>"
                                     min="<?php echo esc_attr( $num_min ); ?>"
                                     max="<?php echo esc_attr( $num_max ); ?>"
                                     class="large-text" style="width: 90px">
                          </div>

                      <?php } elseif ( 'range' === $field['type'] ) {

                        $range_value = isset( $field['value']['current'] ) ? $field['value']['current'] : '';
                        $range_min = isset( $field['value']['min'] ) ? $field['value']['min'] : '';
                        $range_max = isset( $field['value']['max'] ) ? $field['value']['max'] : '';
                        $range_step = isset( $field['value']['step'] ) ? $field['value']['step'] : '';
                        ?>
                          <div class="twer-range js-twer-range">
                              <input type="range"
                                     step="<?php echo esc_attr( $range_step ); ?>"
                                     min="<?php echo esc_attr( $range_min ); ?>"
                                     max="<?php echo esc_attr( $range_max ); ?>"
                                     id="<?php echo esc_attr( $element_id ); ?>-range"
                                     class="large-text js-zoom-range" data-id="range"
                                     value="<?php echo esc_attr( $range_value ); ?>"/>
                              <input type="number"
                                     step="<?php echo esc_attr( $range_step ); ?>"
                                     min="<?php echo esc_attr( $range_min ); ?>"
                                     max="<?php echo esc_attr( $range_max ); ?>"
                                     name="<?php echo esc_attr( $field['name'] ); ?>"
                                     id="<?php echo esc_attr( $element_id ); ?>"
                                     data-id="range-input"
                                     class="large-text js-zoom-range-input"
                                     value="<?php echo esc_attr( $range_value ); ?>"/>
                            <?php if ( ! empty( $field['help'] ) ) { ?>
                                <a href="#" class="twer-help-tooltip"
                                   data-toggle="tooltip"
                                   title="<?php echo esc_attr( $field['help'] ); ?>"><span
                                            class="dashicons dashicons-editor-help"></span></a>
                            <?php } ?>
                          </div>
                      <?php } elseif ( 'group' === $field['type'] ) { ?>
                          <div class="twer-group-elements">
                              <div class="row">
                                <?php foreach ( $field['value'] as $field_group ) {

                                  $element_id_group = trim( str_replace( '_', '-',
                                    $field['name'] . '_' . $field_group['name'] ),
                                    '-' );
                                  $field_group['name'] = $field['name'] . '[' . $field_group['name'] . ']';

                                  $field_class = [];
                                  if ( isset( $field_group['postfix'] ) ) {
                                    $field_class[] = 'twer-form-group--append';
                                  }


                                  $field_group_placeholder = '';
                                  if ( isset( $field_group['placeholder'] ) ) {
                                    $field_group_placeholder = $field_group['placeholder'];
                                  }

                                  $group_class = isset( $field_group['class'] ) ? $field_group['class'] : 'col-fixed';
                                  ?>
                                    <div class="<?php echo 'colorpicker' === $field_group['type'] ? 'col-simple' : $group_class ?>">
                                      <?php if ( ! empty( $field_group['label'] ) ) { ?>
                                          <label for="<?php echo esc_attr( $element_id_group ); ?>"><?php echo esc_attr( $field_group['label'] ); ?></label>
                                      <?php } ?>
                                      <?php if ( 'select' === $field_group['type'] ) {
                                        $field_group_id = isset( $field_group['id'] ) ? $field_group['id'] : $element_id_group;
                                        $fields_atts = isset( $field_group['atts'] ) ? $field_group['atts'] : '';
                                        ?>
                                          <div class="twer-form-group twer-form-group--select">
                                              <select <?php echo $fields_atts; ?> name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                                                  class="large-select"
                                                                                  id="<?php echo esc_attr( $field_group_id ); ?>">
                                                <?php foreach ( $field_group['value'] as $data ) { ?>
                                                    <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                <?php } ?>
                                              </select>
                                          </div>


                                      <?php } elseif ( 'colorpicker' === $field_group['type'] ) { ?>
                                          <div class="js-twer-color-picker-wrap twer-color-picker-wrap">
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
                                                     class="input-color"
                                                     value="<?php echo esc_attr( $field_group['value'] ) ?>">
                                          </div>
                                      <?php } elseif ( 'multiple-select' === $field_group['type'] ) { ?>
                                          <div class="twer-form-group">
                                              <input type="hidden" name="<?php echo esc_attr( $field_group['name'] ); ?>" value="">
                                              <select multiple="multiple" name="<?php echo esc_attr( $field_group['name'] ); ?>[]"
                                                      class="large-select"
                                                      id="<?php echo esc_attr( $element_id_group ); ?>">
                                                <?php foreach ( $field_group['value'] as $data ) { ?>
                                                    <option value="<?php echo esc_attr( $data['value'] ) ?>" <?php selected( $data['selected'] ); ?>><?php echo esc_html( $data['label'] ); ?></option>
                                                <?php } ?>
                                              </select>
                                          </div>
                                        <?php
                                      } elseif ( 'checkbox' === $field_group['type'] ) { ?>
                                          <input type="hidden"
                                                 name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                 value="">
                                        <?php foreach ( $field_group['value'] as $data ) { ?>
                                              <label for="<?php echo esc_attr( $element_id_group ) ?>"
                                                     class="twer-switcher">
                                                  <input type="checkbox"
                                                         name="<?php echo esc_attr( $field_group['name'] ); ?>[]"
                                                         id="<?php echo esc_attr( $element_id_group ); ?>"
                                                         value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                                  <div class="twer-switcher__slider"></div>
                                              </label>
                                        <?php } ?>
                                      <?php } elseif ( 'text' === $field_group['type'] || 'url' === $field_group['type'] ) { ?>
                                          <div class="twer-form-group twer-form-group--text <?php echo esc_attr( implode( ' ', $field_class ) ); ?>">
                                              <input type="<?php echo esc_attr( $field_group['type'] ); ?>"
                                                     id="<?php echo esc_attr( $element_id_group ); ?>"
                                                     name="<?php echo esc_attr( $field_group['name'] ); ?>"
                                                     class="large-text"
                                                     value="<?php echo esc_attr( $field_group['value'] ) ?>"
                                                     placeholder="<?php echo esc_attr( $field_group_placeholder ); ?>"
                                              >
                                            <?php if ( isset( $field_group['postfix'] ) ) { ?>
                                                <div class="twer-form-group-append">
                                                    <span class="twer-form-group-append__text"><?php echo esc_html( $field_group['postfix'] ); ?></span>
                                                </div>
                                            <?php } ?>
                                          </div>


                                      <?php } ?>
                                    </div>
                                <?php } ?>
                              </div>
                          </div>
                      <?php } elseif ( 'checkbox' === $field['type'] ) { ?>
                          <input type="hidden"
                                 name="<?php echo esc_attr( $field['name'] ); ?>"
                                 value="">
                        <?php foreach ( $field['value'] as $data ) { ?>
                              <label for="<?php echo esc_attr( $element_id ) ?>"
                                     class="twer-switcher">
                                  <input type="checkbox"
                                         name="<?php echo esc_attr( $field['name'] ); ?>[]"
                                         id="<?php echo esc_attr( $element_id ); ?>"
                                         value="<?php echo esc_attr( $data['value'] ) ?>" <?php checked( $data['checked'] ); ?>><?php echo esc_html( $data['label'] ); ?>
                                  <div class="twer-switcher__slider"></div>
                              </label>
                        <?php } ?>
                      <?php } elseif ( 'colorpicker' === $field['type'] ) { ?>
                          <div class="js-twer-color-picker-wrap twer-color-picker-wrap">
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
                                     class="input-color"
                                     value="<?php echo esc_attr( $field['value'] ) ?>">
                          </div>
                      <?php } elseif ( 'text' === $field['type'] ) {

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
                              <input type="text"
                                     name="<?php echo esc_attr( $field['name'] ) ?>"
                                     id="<?php echo esc_attr( $element_id ); ?>"
                                     class="large-text"
                                     value="<?php echo esc_attr( htmlspecialchars( $field['value'] ) ) ?>"
                                     placeholder="<?php echo esc_attr( $field_placeholder ); ?>"
                              >
                            <?php if ( isset( $field['postfix'] ) ) { ?>
                                <div class="twer-form-group-append">
                                    <span class="twer-form-group-append__text"><?php echo esc_html( $field['postfix'] ); ?></span>
                                </div>
                            <?php } ?>
                            <?php if ( ! empty( $field['help'] ) ) { ?>
                                <a href="#" class="twer-help-tooltip"
                                   data-toggle="tooltip"
                                   title="<?php echo esc_attr( $field['help'] ); ?>"><span
                                            class="dashicons dashicons-editor-help"></span></a>
                            <?php } ?>
                          </div>
                      <?php } ?>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div> <?php

}

function getCustomFieldsMetaQuery() {
    return [
      'relation' => 'OR',
      [
        'key'   => '_treweler_custom_field_type',
        'value' => 'number',
      ],
      [
        'key'   => '_treweler_custom_field_type',
        'value' => 'true_false',
      ],
      [
        'key'   => '_treweler_custom_field_type',
        'value' => 'multiselect',
      ]
    ];
}

function theStoreLocatorFiltersFields( $customFieldsListNamePostfix = '' ) {
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
    'meta_query'     => getCustomFieldsMetaQuery()
  ] );

  $all_custom_fields[] = (object) [
    'ID' => -1,
    'post_title' => __('Radius', 'treweler'),
    'post_status' => 'publish',
    'post_type' => 'twer-custom-fields'
  ];

  $all_custom_fields[] = (object) [
    'ID' => -2,
    'post_title' => __('Categories', 'treweler'),
    'post_status' => 'publish',
    'post_type' => 'twer-custom-fields'
  ];


  $customFieldsListName = 'filters_list' . $customFieldsListNamePostfix;
  $current_custom_fields_ids = isset( $meta_data->$customFieldsListName ) ? $meta_data->$customFieldsListName : '';

// Get all includes/saved custom fields and save it to array
  $includes_custom_fields_posts = ! empty( $current_custom_fields_ids ) ? get_posts( [
    'post_status' => 'publish',
    'post_type'   => 'twer-custom-fields',
    'orderby'     => 'post__in',
    'include'     => $current_custom_fields_ids,
    'meta_query'     => getCustomFieldsMetaQuery()
  ] ) : [];


//  if(!empty($current_custom_fields_ids)) {
//    $current_custom_fields_idsExploded = explode(',', $current_custom_fields_ids);
//
//    if(in_array('-2', $current_custom_fields_idsExploded, true)) {
//      $key1 = array_search ('-2', $current_custom_fields_idsExploded);
//
//
//      $valie1 =  (object) [
//        'ID' => -2,
//        'post_title' => __('Categories', 'treweler'),
//        'post_status' => 'publish',
//        'post_type' => 'twer-custom-fields'
//      ];
//
//      $includes_custom_fields_posts = array_slice($includes_custom_fields_posts, 0, $key1, true) +
//                                      ['categories' => $valie1] +
//                                      array_slice($includes_custom_fields_posts, $key1, count($includes_custom_fields_posts)-$key1, true);
//
//    }
//
//
//    if(in_array('-1', $current_custom_fields_idsExploded, true)) {
//      $key = array_search ('-1', $current_custom_fields_idsExploded);
//
//
//        $valie =  (object) [
//        'ID' => -1,
//        'post_title' => __('Radius', 'treweler'),
//        'post_status' => 'publish',
//        'post_type' => 'twer-custom-fields'
//      ];
//
//      $includes_custom_fields_posts = array_slice($includes_custom_fields_posts, 0, $key, true) +
//             ['radius' => $valie] +
//             array_slice($includes_custom_fields_posts, $key, count($includes_custom_fields_posts)-$key, true);
//
//    }
//
//
//  }

  $current_custom_fields_idsExploded = explode( ',', $current_custom_fields_ids );


  if(!empty($current_custom_fields_ids)) {

    if ( in_array( '-2', $current_custom_fields_idsExploded, true ) ) {
      $includes_custom_fields_posts[] = (object) [
        'ID'          => -2,
        'post_title'  => __( 'Categories', 'treweler' ),
        'post_status' => 'publish',
        'post_type'   => 'twer-custom-fields'
      ];
    }
  }
  if(!empty($current_custom_fields_ids)) {

    if ( in_array( '-1', $current_custom_fields_idsExploded, true ) ) {
      $includes_custom_fields_posts[] = (object) [
        'ID'          => -1,
        'post_title'  => __( 'Radius', 'treweler' ),
        'post_status' => 'publish',
        'post_type'   => 'twer-custom-fields'
      ];
    }
  }

 //var_dump($includes_custom_fields_posts, $current_custom_fields_idsExploded);
  uksort($includes_custom_fields_posts, function($key1, $key2) use ($current_custom_fields_idsExploded, $includes_custom_fields_posts) {
    return (array_search($includes_custom_fields_posts[$key1]->ID, $current_custom_fields_idsExploded) > array_search($includes_custom_fields_posts[$key2]->ID, $current_custom_fields_idsExploded));
  });


  $fieldNameShowCustomFields = 'custom_field_show' . $customFieldsListNamePostfix;

  $fields_custom_list = template_apply( [
    [
      'type'  => 'select',
      'name'  => $prefix . 'store_locator_filters',
      'label' => esc_html__( 'Show Filters', 'treweler' ),
      'value' => [
        [
          'value'    => 'no',
          'label'    => esc_html__( 'None', 'treweler' ),
          'selected' => in_array( 'no', isset( $meta_data->store_locator_filters ) ? (array) $meta_data->store_locator_filters : [ 'no' ] )
        ],
        [
          'value'    => 'yes',
          'label'    => esc_html__( 'Standard', 'treweler' ),
          'selected' => in_array( 'yes', isset( $meta_data->store_locator_filters ) ? (array) $meta_data->store_locator_filters : [] )
        ],
        [
          'value'    => 'details',
          'label'    => esc_html__( 'Filters & Marker Details', 'treweler' ),
          'selected' => in_array( 'details', isset( $meta_data->store_locator_filters ) ? (array) $meta_data->store_locator_filters : [] )
        ],
      ]
    ],

    [
      'tr-class' => 'd-none',
      'label'    => 'fields',
      'type'     => 'text',
      'subtype'  => 'hidden',
      'class'    => 'js-twer-custom-fields-list',
      'name'     => $prefix . 'filters_list' . $customFieldsListNamePostfix,
      'value'    => isset( $meta_data->$customFieldsListName ) ? $meta_data->$customFieldsListName : '',
    ],
  ], $meta_data, $template_data );

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
    'exclude'        => $current_custom_fields_ids,
    'meta_query'     => getCustomFieldsMetaQuery()
  ] );


  $select_fields = [
    [
      'label'    => __( 'Select a Field', 'treweler' ),
      'selected' => false,
      'default'  => true,
      'value'    => 'none'
    ]
  ];

  if(!empty($current_custom_fields_ids)) {
    $current_custom_fields_idsExploded = explode(',', $current_custom_fields_ids);
    if(!in_array('-1', $current_custom_fields_idsExploded, true)) {
      $select_fields[] =     [
        'label'    => __( 'Radius', 'treweler' ),
        'selected' => false,
        'default'  => false,
        'value'    => -1
      ];
    }

    if(!in_array('-2', $current_custom_fields_idsExploded, true)) {
      $select_fields[] =     [
        'label'    => __( 'Categories', 'treweler' ),
        'selected' => false,
        'default'  => false,
        'value'    => -2
      ];
    }
  } else {
    $select_fields[] =     [
      'label'    => __( 'Radius', 'treweler' ),
      'selected' => false,
      'default'  => false,
      'value'    => -1
    ];
    $select_fields[] =     [
      'label'    => __( 'Categories', 'treweler' ),
      'selected' => false,
      'default'  => false,
      'value'    => -2
    ];
  }

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

              $tr_class[] =  in_array('d-none', $tr_class) ? '' : 'd-row'
              ?>
                <tr style="<?php echo in_array('d-none', $tr_class) ? '' : '' ?>" <?php echo $tr_id; ?> class="<?php echo esc_attr( implode( ' ',
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
                                  <div class="twer-defaults twer-group-elements-hide2" <?php echo $action_style; ?>>
                                    <?php for ( $i = 0; $i < $field['lock_fields']; $i ++ ) {
                                      ?>
                                        <a href="#" class="twer-lock <?php echo esc_attr( $locked ); ?> js-twer-lock" title=""></a>
                                    <?php } ?>
                                  </div>
                                <?php
                              } else {
                                $field_gr = $field['value'];
                                ?>
                                  <div class="twer-defaults twer-group-elements-hide2" <?php echo $action_style; ?>>
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

                            $field_class = [ 'twer-form-group twer-form-group--fwtextarea twer-group-elements-hide1' ];
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
                              <div class="twer-group-elements twer-group-elements-hide1">

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
                                          $colClass = [ 'col-simple w-100' ];
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
                                                          class="large-text" cols="70" rows="13"
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
