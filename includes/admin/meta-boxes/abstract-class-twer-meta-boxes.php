<?php
/**
 * MetaBoxes.
 *
 * @package  Treweler/Admin
 * @version  1.05
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( class_exists( 'TWER_Meta_Boxes', false ) ) {
  return;
}

/**
 * TWER_Admin_List_Table Class.
 */
abstract class TWER_Meta_Boxes {

  protected $unique_field_key;

  protected $position_options;

  protected $font_weight_options;

  protected $colorpicker_default_colors;
  protected $colorpicker_custom_colors;
  protected $colorpicker_extend_colors;

  protected $metabox = '';

  protected $meta_box_id = '';

  protected $fields = [];

  protected $nestedFields = [];

  protected $tabs = [];

  protected $nestedTabs = [];

  protected $meta_box_settings = [];

  abstract protected function setNestedTabs();

  abstract protected function set_fields();

  abstract protected function setNestedFields();

  abstract protected function set_tabs();

  public function __get( $property ) {
    switch ( $property ) {
      case 'meta_box_id':
        return $this->meta_box_id;
    }
  }

  public function __isset( $name ) {
    $getter = 'get' . ucfirst( $name );

    return method_exists( $this, $getter ) && ! is_null( $this->$getter() );
  }

  public function __set( $property, $value ) {
    switch ( $property ) {
      case 'meta_box_id':
        $this->meta_box_id = $value;
        break;
    }
  }

  public function add_meta_box( $id, $title, $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null ) {
    $current_screen = get_current_screen();
    $current_screen_id = $current_screen ? $current_screen->id : '';

    if ( $current_screen_id === $screen && $id === $this->meta_box_id ) {
      $this->set_tabs();
      $this->setNestedTabs();

      $this->pre_init();

      $this->set_fields();
      $this->setNestedFields();

      $this->fields = $this->prepare( $this->fields );
      $this->nestedFields = $this->prepare( $this->nestedFields );

      if ( ! empty( $this->tabs ) ) {
        $sorted_fields = [];

        foreach ( $this->fields as $field ) {
          $sorted_fields[ $field['tab'] ][] = $field;
        }

        $this->fields = $sorted_fields;
      }

      if ( ! empty( $this->nestedTabs ) ) {
        $sorted_fields = [];

        foreach ( $this->nestedFields as $field ) {
          $sorted_fields[ $field['tab'] ][] = $field;
        }

        $this->nestedFields = $sorted_fields;
      }

      $this->meta_box_settings = $this->set_meta_box_settings($context, $id);
      add_meta_box( $id, $title, [ $this, $callback ], $screen, $context, $priority, $callback_args );
    }
  }

  protected function set_meta_box_settings($context = 'normal', $id = '') {
    if('side' === $context) {
      $this->meta_box_settings['table_class'] = 'table table--vertical';
      $this->meta_box_settings['table_th_class'] = 'col-12 d-flex align-items-center twer-cell twer-cell--th';
      $this->meta_box_settings['table_td_class'] = 'col-12 twer-cell twer-cell--td';
    }
    if(!empty($id)) {
      $this->meta_box_settings['root_id'] = $id.'-root';
    }

    return wp_parse_args( $this->meta_box_settings, [
      'root_id' => 'twer-root',
      'table_class' => 'table',
      'table_th_class' => 'col-260 d-flex align-items-center twer-cell twer-cell--th',
      'table_td_class' => 'col twer-cell twer-cell--td',
    ] );
  }

  /**
   * Constructor.
   */
  public function __construct() {
    $screen = get_current_screen();
    $screen_id = $screen ? $screen->id : '';

    if ( $screen_id === $this->metabox ) {
      $this->set_tabs();
      $this->setNestedTabs();

      $this->pre_init();

      $this->set_fields();
      $this->setNestedFields();
      $this->fields = $this->prepare( $this->fields );
      $this->nestedFields = $this->prepare( $this->nestedFields );

      $this->meta_box_settings = $this->set_meta_box_settings();
    }
  }

  public function get_unique_field_key() {
    global $post;

    $post_id = isset( $post->ID ) ? $post->ID : 0;
    $current_size = strlen( (string) abs( $post_id ) );
    $unique_size = 7;
    $secret_key = 'uni';
    $secret_iv = 'fresh';

    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    $output = strtolower( base64_encode( openssl_encrypt( $post_id, $encrypt_method, $key, 0, $iv ) ) );

    if ( $current_size < $unique_size ) {
      $post_id .= mb_substr( $output, 0, $unique_size - $current_size );
    }
    $this->unique_field_key = "field-{$post_id}";

    return "field-{$post_id}";
  }

  public function tabs_mapping( array $fields, $tab_name ) {
    return array_map( function( $field ) use ( $tab_name ) {
      $field['tab'] = $tab_name;

      return $field;
    }, $fields );
  }

  public function pre_init() {
    $this->unique_field_key = $this->get_unique_field_key();

    $this->position_options = [
      'left'         => esc_html__( 'Left', 'treweler' ),
      'right'        => esc_html__( 'Right', 'treweler' ),
      'top'          => esc_html__( 'Top', 'treweler' ),
      'top_left'     => esc_html__( 'Top Left', 'treweler' ),
      'top_right'    => esc_html__( 'Top Right', 'treweler' ),
      'bottom'       => esc_html__( 'Bottom', 'treweler' ),
      'bottom_left'  => esc_html__( 'Bottom Left', 'treweler' ),
      'bottom_right' => esc_html__( 'Bottom Right', 'treweler' ),
      'center'       => esc_html__( 'Center', 'treweler' ),
    ];

    $this->font_weight_options = [
      '100' => esc_html__( 'Thin 100', 'treweler' ),
      '200' => esc_html__( 'Extra Light 200', 'treweler' ),
      '300' => esc_html__( 'Light 300', 'treweler' ),
      '400' => esc_html__( 'Regular 400', 'treweler' ),
      '500' => esc_html__( 'Medium 500', 'treweler' ),
      '600' => esc_html__( 'Semi Bold 600', 'treweler' ),
      '700' => esc_html__( 'Bold 700', 'treweler' ),
      '800' => esc_html__( 'Extra Bold 800', 'treweler' ),
      '900' => esc_html__( 'Black 900', 'treweler' ),
    ];


    $this->colorpicker_custom_colors = get_option( 'treweler_mapbox_colorpicker_custom_color' );
    $this->colorpicker_default_colors = '#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|';
    $this->colorpicker_extend_colors = $this->colorpicker_default_colors . $this->colorpicker_custom_colors;
  }

  protected function class_mapping( $element, array $default_classes ) {
    if ( isset( $element['class'] ) ) {
      if ( is_array( $element['class'] ) ) {
        $default_classes = array_merge( $default_classes, $element['class'] );
      } else {
        $default_classes = explode( ' ', $element['class'] );
      }
    }

    return implode( ' ', $default_classes );
  }

  public function prepare( array $fields = [], $params = [] ) {
    $meta = twer_get_data();

    foreach ( $fields as &$field ) {


      $is_group = isset( $params['is_group'] ) ? $params['is_group'] : false;
      $group_name = isset( $params['group_name'] ) ? $params['group_name'] : '';

      // Build key => value for get meta params
      $meta_name = $is_group ? [ $group_name => $field['name'] ] : [ $field['name'] => '' ];
      $meta_key = array_keys( $meta_name )[0];
      $meta_value = reset( $meta_name );


      if ( ! isset( $field['row_id'] ) ) {
        $field['row_id'] = $field['name'];
      }

      if ( isset( $field['group_class'] ) ) {
        if ( is_array( $field['group_class'] ) ) {
          $field['group_class'] = implode( ' ', array_merge( [ 'form-group col' ], $field['group_class'] ) );
        }
      }

      switch ( $field['type'] ) {
        case 'button' :
          $field['class'] = $this->class_mapping( $field, [ 'btn', 'btn-primary', 'btn-sm' ] );
          break;
        case 'select' :
          if ( isset( $meta->$meta_key ) ) {
            if ( $is_group ) {
              $value = isset( $meta->$meta_key[ $meta_value ] ) ? $meta->$meta_key[ $meta_value ] : $field['selected'];
            } else {
              $atts = isset($field['atts']) ? $field['atts'] : [];
              if(in_array('multiple', $atts, true)) {
                $value = is_array( $meta->$meta_key ) ? $meta->$meta_key : $field['selected'];
              } else {
                $value = ! is_array( $meta->$meta_key ) ? $meta->$meta_key : $field['selected'];
              }
            }
          } else {
            $value = $field['selected'];
          }

          $field['selected'] = $value;
          $field['class'] = $this->class_mapping( $field, [ 'form-control form-control-sm' ] );
          break;
        case 'text' :
        case 'hidden' :
        case 'url' :
        case 'tel' :
        case 'email' :
        case 'number' :
        case 'textarea' :
        case 'range' :
        case 'colorpicker' :
        case 'iconpicker' :
          if ( isset( $meta->$meta_key ) ) {
            if ( $is_group ) {
              $value = isset( $meta->$meta_key[ $meta_value ] ) ? $meta->$meta_key[ $meta_value ] : $field['value'];
            } else {
              $value = ! is_array( $meta->$meta_key ) ? $meta->$meta_key : $field['value'];
            }
          } else {
            $value = $field['value'];
          }

          if($field['type'] === 'number') {
            $value = str_replace(',', '.', $value);
          }

          $field['value'] = $value;

          $field['class'] = $this->class_mapping( $field, [ 'form-control form-control-sm' ] );
          break;
        case 'image' :
          if ( isset( $meta->$meta_key ) ) {
            if ( $is_group ) {
              $value = isset( $meta->$meta_key[ $meta_value ] ) ? $meta->$meta_key[ $meta_value ] : $field['value'];
            } else {
              $value = ! is_array( $meta->$meta_key ) ? $meta->$meta_key : $field['value'];
            }
          } else {
            $value = $field['value'];
          }

          $image = wp_get_attachment_image_src( $value, 'full' );

          if ( $image ) {
            $image = $image[0];
          }

          $field['image'] = $image;
          $field['value'] = $value;
          $field['class'] = $this->class_mapping( $field, [ 'form-control form-control-sm' ] );
          break;
        case 'gallery' :
          if ( isset( $meta->$meta_key ) ) {
            if ( $is_group ) {
              $value = isset( $meta->$meta_key[ $meta_value ] ) ? $meta->$meta_key[ $meta_value ] : $field['value'];
            } else {
              $value = ! is_array( $meta->$meta_key ) ? $meta->$meta_key : $field['value'];
            }
          } else {
            $value = $field['value'];
          }
          $gallery_value = [];
          if ( ! empty( $value ) ) {

            if ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
              $attachment_id = attachment_url_to_postid( $value );
              $value = $attachment_id;
              $thumbnail_img = wp_get_attachment_image_src( $attachment_id, 'full' );
              if ( $thumbnail_img ) {
                $gallery_value[ $thumbnail_img[0] ] = $attachment_id;
              }
            } else {
              $thumbnails_ids = explode( ',', $value );
              if ( ! empty( $thumbnails_ids ) && is_array( $thumbnails_ids ) ) {
                foreach ( $thumbnails_ids as $thumbnail_id ) {
                  $thumbnail_img = wp_get_attachment_image_src( $thumbnail_id, 'full' );

                  if ( $thumbnail_img ) {
                    $gallery_value[ $thumbnail_img[0] ] = $thumbnail_id;
                  }
                }
              }
            }
          }

          $field['gallery_images'] = $gallery_value;
          $field['value'] = implode( ',', $gallery_value );
          $field['class'] = $this->class_mapping( $field, [ 'form-control form-control-sm' ] );


          if ( isset( $field['extra'] ) ) {
            $field['extra'] = $this->prepare( $field['extra'], [ 'is_group' => true, 'group_name' => $field['name'] . '_extra', 'group_row_id' => $field['row_id'] ] );
          }
          break;
        case 'radios' :

          if ( isset( $meta->$meta_key ) ) {
            if ( $is_group ) {
              $checked = isset( $meta->$meta_key[ $meta_value ] ) ? $meta->$meta_key[ $meta_value ] : $field['selected'];
            } else {
              $checked = $meta->$meta_key;
            }
          } else {
            $checked = $field['selected'];
          }

          $field['selected'] = is_array( $checked ) ? reset( $checked ) : $checked;
          break;
        case 'checkbox' :

          if ( isset( $meta->$meta_key ) ) {
            if ( $is_group ) {
              $checked = isset( $meta->$meta_key[ $meta_value ] ) ? $meta->$meta_key[ $meta_value ] : $field['checked'];
            } else {
              $checked = $meta->$meta_key;
            }
          } else {
            $checked = $field['checked'];
          }

          $field['checked'] = is_array( $checked ) ? reset( $checked ) : $checked;

          $field['class'] = $this->class_mapping( $field, [ 'twer-switcher' ] );
          break;
        case 'group' :
          $field['group'] = $this->prepare( $field['group'], [ 'is_group' => true, 'group_name' => $field['name'], 'group_row_id' => $field['row_id'] ] );
          break;
      }


      if ( $is_group ) {
        $field['name'] = '_treweler_' . $params['group_name'] . '[' . $field['name'] . ']';
      } else {
        $field['name'] = '_treweler_' . $field['name'];
      }

      if ( $is_group ) {
        $id = sanitize_html_class( $params['group_row_id'] . '_' . $field['row_id'] );
      } else {
        $id = sanitize_html_class( $field['row_id'] );
      }


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

        $field['row_class'] = 'twer-row js-twer-row ' . implode( ' ', $tr_class );
        $field['row_atts'] = implode( ' ', $tr_atts );
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

        $field['row_class'] = 'twer-row js-twer-row ' . implode( ' ', $tr_class );
        $field['row_atts'] = implode( ' ', $tr_atts );
      }


      $field = wp_parse_args( $field, [
        'tab'            => '',
        'append'         => '',
        'atts'           => [],
        'row_id'         => 'field-row-id',
        'row_class'      => 'twer-row js-twer-row',
        'group_class'    => 'form-group col col-220',
        'class'          => 'form-control form-control-sm',
        'checkbox_class' => 'twer-switcher',
        'option_disabled' => null,
        'option_hidden' => null,
        'help'           => '',
        'note'           => '',
        'bottom_note'           => '',
        'id'             => $id,
        'placeholder'    => '',
        'label_inline'   => '',
        'row_atts'       => '',
        'style' => '',
        'label_colorpicker' => esc_html__( 'Select Color', 'treweler' ),
        'colors'            => $this->colorpicker_default_colors,
        'extends_colors'    => $this->colorpicker_extend_colors,
        'custom_colors'     => $this->colorpicker_custom_colors,

        'label_image_remove' => esc_html__( 'Remove', 'treweler' ),
        'label_image_change' => esc_html__( 'Change image', 'treweler' ),
        'label_image_add'    => esc_html__( 'Select Image', 'treweler' ),
        'gallery_images'     => [],

        'row_controls' => [],
        'labelThDescription' => '',
        'labelThClass' => ''
      ] );
    }
    unset( $field );

    return $fields;
  }


  public function output() {
    $smarty = new TWER_Smarty();
    wp_nonce_field( 'treweler_save_data', 'treweler_meta_nonce');

    $smarty->assign( 'nestedTabs', apply_filters( $this->metabox . '_assign_nestedTabs', $this->nestedTabs, $this->metabox ) );
    $smarty->assign( 'tabs', apply_filters( $this->metabox . '_assign_tabs', $this->tabs, $this->metabox ) );
    $smarty->assign( 'fields', apply_filters( $this->metabox . '_assign_fields', $this->fields, $this->metabox ) );
    $smarty->assign( 'nestedFields', apply_filters( $this->metabox . '_assign_nestedFields', $this->nestedFields, $this->metabox ) );
    $smarty->assign( 'settings', apply_filters( $this->metabox . '_assign_settings', $this->meta_box_settings, $this->metabox ) );
    $smarty->display( 'metabox.tpl' );
  }
}
