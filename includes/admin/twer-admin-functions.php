<?php
/**
 * Treweler Admin Functions
 *
 * @package  Treweler/Admin/Functions
 * @version  0.24
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! function_exists( 'twer_get_screen_ids' ) ) {
  /**
   * Get all Treweler screen ids.
   *
   * @return array
   */
  function twer_get_screen_ids() {

    $twer_screen_id = sanitize_title( esc_html__( 'Treweler', 'treweler' ) );
    $screen_ids = [
      'route',
      'marker',
      'map',
      'twer-custom-fields',
      'twer-templates',
      'treweler-import',
      'twer-shapes',
      'edit-map-category',
      'treweler_page_treweler-settings'
    ];

    return apply_filters( 'treweler_screen_ids', $screen_ids );
  }
}


function twerGetScreenIdsUsedMapbox() {
  return apply_filters( 'twerSetScreenIdsUsedMapbox', [
    'route',
    'marker',
    'map'
  ] );
}

function twerGetScreenIdsUsedMaterialIcons() {
  return apply_filters( 'twerSetScreenIdsUsedMaterialIcons', [
    'marker'
  ] );
}

if ( ! function_exists( 'twer_get_free_screen_ids' ) ) {
  /**
   * Get all Treweler free screen ids.
   *
   * @return array
   */
  function twer_get_free_screen_ids() {
    $screen_ids = [
      'map',
      'marker',
      'route',
      'treweler_page_treweler-shapes',
      'treweler_page_treweler-categories',
      'treweler_page_treweler-custom-fields',
      'treweler_page_treweler-import',
      'treweler_page_treweler-templates',
      'treweler_page_treweler-settings'
    ];

    return apply_filters( 'treweler_free_screen_ids', $screen_ids );
  }
}


if ( ! function_exists( 'twer_do_settings_sections' ) ) {
  /**
   * Output Treweler settings in table
   *
   * @param $page
   *
   * @return void
   */
  function twer_do_settings_sections( $page ) {
    global $wp_settings_sections, $wp_settings_fields;

    if ( ! isset( $wp_settings_sections[ $page ] ) ) {
      return;
    }

    foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
      if ( $section['title'] ) {
        echo "<h2>{$section['title']}</h2>\n";
      }

      if ( $section['callback'] ) {
        call_user_func( $section['callback'], $section );
      }

      if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
        continue;
      }
      echo '<table class="table" role="presentation">';
      twer_do_settings_fields( $page, $section['id'] );
      echo '</table>';
    }
  }
}

function twer_do_settings_fields( $page, $section ) {
	global $wp_settings_fields;

	if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
		return;
	}

	foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $field ) {
    $classes  = ['twer-row js-twer-row'];

    $styleLabel = '';
    if(TWER_IS_FREE) {
      if($field['id'] === 'google_sheets_api_json') {
        $classes[] = 'twer-default-row twer-is-pro-field twer-is-pro-field--partially';
        $styleLabel = 'display: inline;width: auto; max-width: none;';
      }
    }

			$class = ' class="'.implode(' ', $classes ).'" ';




		echo "<tr{$class}>";

		if ( ! empty( $field['args']['label_for'] ) ) {
			echo '<th class="col-260 d-flex align-items-center twer-cell twer-cell--th" scope="row"><div style="'.$styleLabel.'" class="twer-cell__label"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label></div></th>';
		} else {
			echo '<th class="col-260 d-flex align-items-center twer-cell twer-cell--th" scope="row"><div style="'.$styleLabel.'" class="twer-cell__label"><label>' . $field['title'] . '</label></div></th>';
		}

		echo '<td class="col twer-cell twer-cell--td">';
		call_user_func( $field['callback'], $field['args'] );
		echo '</td>';
		echo '</tr>';
	}
}



function twerSetFieldsProperties( array $fields ) {
  $fields = twerSetNamesForFields( $fields );
  $fields = twerSetClassAndIdForFields( $fields );
  $fields = twerSetHTMLAttributesForFields( $fields );
  $fields = twerAddMoreDomElementsForFields( $fields );
  $fields = twerSetValueFields( $fields );

  return $fields;
}


function twerPrepareFieldsBeforeOutput( array $fields, array $tabs ) {
  $fields = twerSetFieldsProperties( $fields );

  if ( ! empty( $tabs ) ) {
    $fields = twerSetFieldsForTabs( $fields, $tabs );
  }


  return $fields;
}

function twerSetFieldsForTabs( array $fields, array $tabs ) {
  $allFields = [];
  foreach ( $tabs as $tabName => $tabLabel ) {
    foreach ( $fields as $field ) {
      if ( isset( $field['tab'] ) ) {
        if ( $field['tab'] === $tabName ) {
          $allFields[ $tabName ][] = $field;
        }
      }
    }
  }

  return $allFields;
}

function twerIsGroupField( array $field ) {
  return isset( $field['group'] );
}

function twerApplyTabForFields( array $fields, $tabKey ) {
  foreach ( $fields as &$singleField ) {
    if ( ! empty( $tabKey ) ) {
      $singleField['tab'] = $tabKey;
    }
  }
  unset( $singleField );

  return $fields;
}


function twerAppendClassForField( array $field, $defaultClass, $DOMElementType ) {
  if ( isset( $field[ $DOMElementType ] ) ) {
    $field[ $DOMElementType ] = is_string( $field[ $DOMElementType ] ) ? $field[ $DOMElementType ] : $defaultClass . ' ' . implode( ' ', $field[ $DOMElementType ] );
  }

  return $field;
}

function twerSetValueFields( array $fields ) {
  global $post;

  foreach ( $fields as &$singleField ) {
    $savedValueForField = get_post_meta( $post->ID, $singleField['name'], true );

    if ( twerIsGroupField( $singleField ) ) {
      foreach ( $singleField['group'] as &$groupField ) {
        if('TREWELER_DEFAULT_VALUE' !== $savedValueForField) {
          $groupField['value'] = $savedValueForField[ $groupField['primaryName'] ];
        }
      }
      unset( $groupField );
    } else {
      if('TREWELER_DEFAULT_VALUE' !== $savedValueForField) {
        $singleField['value'] = $savedValueForField;
      }
    }
  }
  unset( $singleField );


  return $fields;
}


function twerGetGoToProMessage() {
  return apply_filters( 'twerSetGoToProMessage', esc_html__('This feature is only available with a Treweler Pro license. Upgrade to Pro version to get access to all plugin features and premium support.', 'treweler') );
}

function twerGoToProNotice($position = 'tab') {

  $class = 'twer-gotopro--admin-fullscreen';
  if($position === 'tab') {
    $class = 'twer-gotopro--for-tab';
  }

  $smarty = new TWER_Smarty();
  $smarty->assign( 'icon', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNzIiIGhlaWdodD0iNzEiIHZpZXdCb3g9IjAgMCA3MiA3MSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik00My43MzM0IDcuOTkzN0M0MC4yMzI2IDYuNzA0MTQgMzYuNDQ4NSA2IDMyLjUgNkMxNC41NTA4IDYgMCAyMC41NTA4IDAgMzguNUMwIDU2LjQ0OTIgMTQuNTUwOCA3MSAzMi41IDcxQzUwLjQ0OTIgNzEgNjUgNTYuNDQ5MiA2NSAzOC41QzY1IDM1LjAyODQgNjQuNDU1NyAzMS42ODQgNjMuNDQ3OCAyOC41NDc0QzYzLjE0NiAyOC42OTEzIDYyLjgzODYgMjguODI1NCA2Mi41MjYxIDI4Ljk0OTNDNjMuNDgzNCAzMS45NjE3IDY0IDM1LjE3MDUgNjQgMzguNUM2NCA1NS44OTcgNDkuODk3IDcwIDMyLjUgNzBDMTUuMTAzIDcwIDEgNTUuODk3IDEgMzguNUMxIDIxLjEwMyAxNS4xMDMgNyAzMi41IDdDMzYuMjkxNSA3IDM5LjkyNjYgNy42Njk4NyA0My4yOTMzIDguODk3NzJDNDMuNDMwMSA4LjU5MDggNDMuNTc3IDguMjg5MzIgNDMuNzMzNCA3Ljk5MzdaTTQ1LjY2ODUgNTEuODM0TDQ1LjY2ODUgNTEuODMzOUwzNS4zMzI1IDIwLjkzNjdMMzUuMzMyNCAyMC45MzY1QzM0Ljk0NDggMTkuNzc4NCAzMy42ODY2IDE5LjIwMDkgMzIuNTYxMiAxOS41NDI4TDMyLjU2MSAxOS41NDI5QzMxLjg4OTggMTkuNzQ2OSAzMS4zMzk4IDIwLjI1NjQgMzEuMTEyNCAyMC45MzY3TDMxLjExMjMgMjAuOTM3TDI3LjczOTcgMzEuMDE5MkgxNy4wODc5QzE1LjkwMyAzMS4wMTkyIDE0Ljg4ODkgMzEuOTU4IDE0Ljg4ODkgMzMuMTgxNEMxNC44ODg5IDMzLjg4MjYgMTUuMjMzNCAzNC41MzA2IDE1Ljc5NzkgMzQuOTMyNkwyNC4zODQ4IDQxLjA0ODhMMjAuNzc2MyA1MS44MzM5TDIwLjc3NjIgNTEuODM0QzIwLjM4MTEgNTMuMDE1NCAyMS4wODE1IDU0LjIyMDcgMjIuMjI0OCA1NC41Njg0QzIyLjkwOTIgNTQuNzc2NSAyMy42NjA3IDU0LjY1MDkgMjQuMjM3MiA1NC4yMjAyTDI0LjIzNzIgNTQuMjIwMUwzMy4wNjg3IDQ3LjYyMDNMMzMuMDY4OCA0Ny42MjAyQzMzLjE1NTUgNDcuNTU1NCAzMy4yODkyIDQ3LjU1NTQgMzMuMzc1OSA0Ny42MjAyTDMzLjM3NiA0Ny42MjAzTDQyLjIwNzUgNTQuMjIwMUw0Mi4yMDc2IDU0LjIyMDJDNDMuMTU3MyA1NC45Mjk3IDQ0LjUyOSA1NC43ODIyIDQ1LjI5MDMgNTMuODU2OEw0NS4yOTA1IDUzLjg1NjVDNDUuNzU0NCA1My4yOTIzIDQ1LjkwMjIgNTIuNTMzIDQ1LjY2ODUgNTEuODM0Wk0yOC41MjYzIDMxLjgxOTlMMzIuMDYwNyAyMS4yNTM5QzMyLjE4MDYgMjAuODk1MSAzMi40NzU2IDIwLjYxNCAzMi44NTE5IDIwLjQ5OTZDMzMuNDkzNSAyMC4zMDQ3IDM0LjE3OTUgMjAuNjQyMyAzNC4zODQxIDIxLjI1MzlMNDQuNzIwMSA1Mi4xNTEyQzQ0Ljg0MjggNTIuNTE3OSA0NC43NjcxIDUyLjkxODYgNDQuNTE4MSA1My4yMjE1QzQ0LjEwMjUgNTMuNzI2NiA0My4zMzYxIDUzLjgxNSA0Mi44MDYxIDUzLjQxOTFMMzMuOTc0NiA0Ni44MTkzQzMzLjUzMjkgNDYuNDg5MSAzMi45MTE4IDQ2LjQ4OTEgMzIuNDcwMSA0Ni44MTkzTDIzLjYzODYgNTMuNDE5MUMyMy4zMjEgNTMuNjU2NCAyMi45MDA1IDUzLjcyODYgMjIuNTE1OSA1My42MTE2QzIxLjg3NDIgNTMuNDE2NiAyMS41MjAxIDUyLjc2MjcgMjEuNzI0NiA1Mi4xNTEyTDI1LjUwNjMgNDAuODQ4N0wyNS41MTc0IDQwLjgxNTNDMjUuNDM0NSA0MC42MzYgMjUuMzA0NCA0MC40NzYxIDI1LjEzMzMgNDAuMzU0MkwxNi4zNzggMzQuMTE4QzE2LjA3MDUgMzMuODk5IDE1Ljg4ODkgMzMuNTUxMyAxNS44ODg5IDMzLjE4MTRDMTUuODg4OSAzMi41Mzk1IDE2LjQyNTYgMzIuMDE5MiAxNy4wODc5IDMyLjAxOTJIMjcuODU1MUMyOC4xMDA1IDMyLjAxOTIgMjguMzMyOCAzMS45NDY3IDI4LjUyNjMgMzEuODE5OVoiIGZpbGw9IiM1NjlEMUEiLz4KPGNpcmNsZSBjeD0iNTciIGN5PSIxNSIgcj0iMTQuNSIgc3Ryb2tlPSIjNTY5RDFBIi8+CjxwYXRoIGQ9Ik00OS43MTkyIDE4VjEyLjU2SDUwLjYxNTJWMThINDkuNzE5MlpNNTEuNjcxMiAxNi4wNzJINTAuMzY3MlYxNS4zNTJINTEuNjIzMkM1MS45OTY1IDE1LjM1MiA1Mi4yODQ1IDE1LjI1ODcgNTIuNDg3MiAxNS4wNzJDNTIuNjg5OCAxNC44ODUzIDUyLjc5MTIgMTQuNjM0NyA1Mi43OTEyIDE0LjMyQzUyLjc5MTIgMTQgNTIuNjg5OCAxMy43NDY3IDUyLjQ4NzIgMTMuNTZDNTIuMjg0NSAxMy4zNzMzIDUyLjAwNDUgMTMuMjggNTEuNjQ3MiAxMy4yOEg1MC4zNjcyVjEyLjU2SDUxLjY1NTJDNTIuMDgxOCAxMi41NiA1Mi40NDcyIDEyLjYzMiA1Mi43NTEyIDEyLjc3NkM1My4wNjA1IDEyLjkxNDcgNTMuMjk3OCAxMy4xMTQ3IDUzLjQ2MzIgMTMuMzc2QzUzLjYyODUgMTMuNjMyIDUzLjcxMTIgMTMuOTQ0IDUzLjcxMTIgMTQuMzEyQzUzLjcxMTIgMTQuODcyIDUzLjUyNDUgMTUuMzA2NyA1My4xNTEyIDE1LjYxNkM1Mi43ODMyIDE1LjkyIDUyLjI4OTggMTYuMDcyIDUxLjY3MTIgMTYuMDcyWk01NS4wMDIgMThWMTIuNTZINTUuODk4VjE4SDU1LjAwMlpNNTcuMTIyIDE1LjYzMkg1NS42NVYxNS4wOEg1Ny4wMDJDNTcuMzM4IDE1LjA4IDU3LjU5NCAxNSA1Ny43NyAxNC44NEM1Ny45NTEzIDE0LjY3NDcgNTguMDQyIDE0LjQ1MzMgNTguMDQyIDE0LjE3NkM1OC4wNDIgMTMuOTA0IDU3Ljk1MTMgMTMuNjg4IDU3Ljc3IDEzLjUyOEM1Ny41OTQgMTMuMzYyNyA1Ny4zNDMzIDEzLjI4IDU3LjAxOCAxMy4yOEg1NS42NVYxMi41Nkg1Ny4wNDJDNTcuNjI4NiAxMi41NiA1OC4wOTUzIDEyLjcwMTMgNTguNDQyIDEyLjk4NEM1OC43ODg2IDEzLjI2MTMgNTguOTYyIDEzLjY0MjcgNTguOTYyIDE0LjEyOEM1OC45NjIgMTQuNjE4NyA1OC43OTQgMTQuOTkyIDU4LjQ1OCAxNS4yNDhDNTguMTI3MyAxNS41MDQgNTcuNjgyIDE1LjYzMiA1Ny4xMjIgMTUuNjMyWk01OC4yNzQgMThMNTcuOTQ2IDE2LjU0NEM1Ny44OTggMTYuMzM2IDU3LjgzNCAxNi4xNzg3IDU3Ljc1NCAxNi4wNzJDNTcuNjc5MyAxNS45NjUzIDU3LjU3OCAxNS44OTMzIDU3LjQ1IDE1Ljg1NkM1Ny4zMjIgMTUuODE4NyA1Ny4xNTkzIDE1LjggNTYuOTYyIDE1LjhINTUuODAyVjE1LjIyNEg1Ny4wOUM1Ny40NTI2IDE1LjIyNCA1Ny43NDYgMTUuMjU4NyA1Ny45NyAxNS4zMjhDNTguMTk5MyAxNS4zOTIgNTguMzc4IDE1LjUwNjcgNTguNTA2IDE1LjY3MkM1OC42MzQgMTUuODM3MyA1OC43MzUzIDE2LjA2OTMgNTguODEgMTYuMzY4TDU5LjIxOCAxOEg1OC4yNzRaTTYyLjg2NSAxOC4xMDRDNjIuMzI2NCAxOC4xMDQgNjEuODU5NyAxNy45OTIgNjEuNDY1IDE3Ljc2OEM2MS4wNzU3IDE3LjUzODcgNjAuNzc0NCAxNy4yMTMzIDYwLjU2MSAxNi43OTJDNjAuMzUzIDE2LjM3MDcgNjAuMjQ5IDE1Ljg2OTMgNjAuMjQ5IDE1LjI4OEM2MC4yNDkgMTQuNzA2NyA2MC4zNTMgMTQuMjA1MyA2MC41NjEgMTMuNzg0QzYwLjc3NDQgMTMuMzU3MyA2MS4wNzU3IDEzLjAyOTMgNjEuNDY1IDEyLjhDNjEuODU5NyAxMi41NzA3IDYyLjMyNjQgMTIuNDU2IDYyLjg2NSAxMi40NTZDNjMuMzk4NCAxMi40NTYgNjMuODU5NyAxMi41NzA3IDY0LjI0OSAxMi44QzY0LjY0MzcgMTMuMDI5MyA2NC45NDUgMTMuMzU3MyA2NS4xNTMgMTMuNzg0QzY1LjM2NjQgMTQuMjA1MyA2NS40NzMgMTQuNzA2NyA2NS40NzMgMTUuMjg4QzY1LjQ3MyAxNS44NjkzIDY1LjM2NjQgMTYuMzcwNyA2NS4xNTMgMTYuNzkyQzY0Ljk0NSAxNy4yMTMzIDY0LjY0MzcgMTcuNTM4NyA2NC4yNDkgMTcuNzY4QzYzLjg1OTcgMTcuOTkyIDYzLjM5ODQgMTguMTA0IDYyLjg2NSAxOC4xMDRaTTYyLjg2NSAxNy4zNTJDNjMuMjE3IDE3LjM1MiA2My41MTg0IDE3LjI2OTMgNjMuNzY5IDE3LjEwNEM2NC4wMjUgMTYuOTMzMyA2NC4yMTk3IDE2LjY5NiA2NC4zNTMgMTYuMzkyQzY0LjQ5MTcgMTYuMDgyNyA2NC41NjEgMTUuNzE0NyA2NC41NjEgMTUuMjg4QzY0LjU2MSAxNC44NTYgNjQuNDkxNyAxNC40ODUzIDY0LjM1MyAxNC4xNzZDNjQuMjE5NyAxMy44NjY3IDY0LjAyNSAxMy42MjkzIDYzLjc2OSAxMy40NjRDNjMuNTE4NCAxMy4yOTMzIDYzLjIxNyAxMy4yMDggNjIuODY1IDEzLjIwOEM2Mi41MDc3IDEzLjIwOCA2Mi4yMDEgMTMuMjkzMyA2MS45NDUgMTMuNDY0QzYxLjY5NDQgMTMuNjI5MyA2MS40OTk3IDEzLjg2NjcgNjEuMzYxIDE0LjE3NkM2MS4yMjc3IDE0LjQ4NTMgNjEuMTYxIDE0Ljg1NiA2MS4xNjEgMTUuMjg4QzYxLjE2MSAxNS43MTQ3IDYxLjIyNzcgMTYuMDgyNyA2MS4zNjEgMTYuMzkyQzYxLjQ5OTcgMTYuNjk2IDYxLjY5NDQgMTYuOTMzMyA2MS45NDUgMTcuMTA0QzYyLjIwMSAxNy4yNjkzIDYyLjUwNzcgMTcuMzUyIDYyLjg2NSAxNy4zNTJaIiBmaWxsPSIjNTY5RDFBIi8+Cjwvc3ZnPgo=' );
  $smarty->assign( 'title', esc_html__( 'Treweler Pro', 'treweler' ) );
  $smarty->assign( 'description', twerGetGoToProMessage() );
  $smarty->assign( 'class', $class );
  $smarty->assign( 'position', $position );
  $smarty->assign( 'link', [
    'title' => esc_html__( 'Upgrade Now', 'treweler' ),
    'url'   => esc_url( 'https://treweler.com/' )
  ] );
  $smarty->display( 'goto-pro-message.tpl' );
}

function twerAddMoreDomElementsForFields( array $fields ) {
  $defaultDomElementsForField = [
    'append'       => '',
    'label_inline' => '',
    'note'         => '',
    'help'         => ''
  ];

  foreach ( $fields as &$singleField ) {
    if ( twerIsGroupField( $singleField ) ) {
      $singleField['group'] = twerSetHTMLAttributesForFields( $singleField['group'] );
    } else {
      $singleField = wp_parse_args( $singleField, $defaultDomElementsForField );
    }

  }
  unset( $singleField );

  return $fields;
}


function twerSetHTMLAttributesForFields( array $fields ) {
  $defaultHTMLAttributesForField = [];

  foreach ( $fields as &$singleField ) {
    if ( twerIsGroupField( $singleField ) ) {
      $singleField['group'] = twerSetHTMLAttributesForFields( $singleField['group'] );
    } else {
      switch ( $singleField['type'] ) {
        case 'selectNew' :
        case 'select' :
          $defaultHTMLAttributesForField = [
            'selected'   => '',
            'isMultiple' => false
          ];
          break;
        case 'file' :
        case 'image' :
          $defaultHTMLAttributesForField = [
            'label_image_add'    => esc_html__( 'Select File', 'treweler' ),
            'label_image_remove' => esc_html__( 'Remove', 'treweler' ),
            'label_image_change' => esc_html__( 'Change File', 'treweler' ),
            'image'              => '',
            'value'              => '',
          ];

          break;
        case 'number' :
          $defaultHTMLAttributesForField = [
            'placeholder' => 0,
            'value'       => '',
            'atts'        => []
          ];

          break;
        case 'colorpicker' :
          $colorpicker_custom_colors = get_option( 'treweler_mapbox_colorpicker_custom_color' );
          $colorpicker_default_colors = '#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|';
          $colorpicker_extend_colors = $colorpicker_default_colors . $colorpicker_custom_colors;
          $defaultHTMLAttributesForField = [
            'label_colorpicker' => esc_html__( 'Select Color', 'treweler' ),
            'colors'            => $colorpicker_default_colors,
            'extends_colors'    => $colorpicker_extend_colors,
            'custom_colors'     => $colorpicker_custom_colors,
            'value'             => '',
          ];
          break;
      }
      $singleField = wp_parse_args( $singleField, $defaultHTMLAttributesForField );
    }

  }
  unset( $singleField );

  return $fields;
}

function twerSetClassAndIdForFields( array $fields ) {
  $defaultHTMLAttributesForRow = [
    'row_id'    => '',
    'row_class' => 'twer-row',
    'row_atts'  => '',
  ];

  $defaultHTMLAttributesForField = [
    'id'          => '',
    'class'       => 'form-control form-control-sm',
    'group_class' => 'form-group col col-220',
  ];
  foreach ( $fields as &$singleField ) {

    $defaultHTMLAttributesForRow['row_id'] = $singleField['primaryName'];

    if ( twerIsGroupField( $singleField ) ) {
      $singleField = wp_parse_args( $singleField, $defaultHTMLAttributesForRow );

      $singleField['group'] = twerSetClassAndIdForFields( $singleField['group'] );
    } else {

      $defaultHTMLAttributesForField['id'] = isset( $singleField['primaryGroupName'] ) ? $singleField['primaryGroupName'] . '_' . $singleField['primaryName'] : $singleField['primaryName'];
      $singleField = twerAppendClassForField( $singleField, 'form-group col', 'group_class' );

      $singleField = wp_parse_args( $singleField, array_merge( $defaultHTMLAttributesForRow, $defaultHTMLAttributesForField ) );
    }

  }
  unset( $singleField );

  return $fields;
}

function twerSetNamesForFields( array $fields ) {

  foreach ( $fields as &$singleField ) {
    if ( isset( $singleField['name'] ) ) {
      $singleField['primaryName'] = $singleField['name'];
      $singleField['name'] = '_treweler_' . $singleField['name'];

      if ( isset( $singleField['group'] ) ) {
        foreach ( $singleField['group'] as &$groupSingleField ) {
          if ( isset( $groupSingleField['name'] ) ) {
            $groupSingleField['primaryName'] = $groupSingleField['name'];
            $groupSingleField['primaryGroupName'] = $singleField['name'];
            $groupSingleField['name'] = $singleField['name'] . '[' . $groupSingleField['name'] . ']';
          }
        }
        unset( $groupSingleField );
      }
    }
  }

  unset( $singleField );

  return $fields;
}

function twerGetOption($optionName) {
  $option = get_option('treweler');
  return $option[ $optionName ] ?? null;
}

function twerOutputTemplateElements( array $elements, array $settings = [] ) {
  wp_nonce_field( 'treweler_save_data', 'treweler_meta_nonce' );

  if ( TWER_OUTPUT_OLD_VIEWS_FOR_METABOXES ) {
    $oldViewFilename = isset( $elements['oldViewFilename'] ) ? $elements['oldViewFilename'] : '';

    if ( ! empty( $oldViewFilename ) ) {
      include TWER()->admin_views_path() . $oldViewFilename . '.php';
    }
  } else {
    $tabs = isset( $elements['tabs'] ) ? $elements['tabs'] : [];
    $fields = isset( $elements['fields'] ) ? $elements['fields'] : [];

    $fields = twerPrepareFieldsBeforeOutput( $fields, $tabs );


    $smarty = new TWER_Smarty();

    //var_dump($fields);

    $smarty->assign( 'tabs', $tabs );
    $smarty->assign( 'fields', $fields );
    $smarty->assign( 'settings', wp_parse_args( $settings, [
      'root_id'        => 'twer-root',
      'table_class'    => 'table',
      'table_th_class' => 'col-260 d-flex align-items-center twer-cell twer-cell--th',
      'table_td_class' => 'col twer-cell twer-cell--td',
    ] ) );
    $smarty->display( 'metabox.tpl' );
  }

}

