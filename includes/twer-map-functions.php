<?php
/**
 * Treweler Map
 * Functions for the map system.
 *
 * @package  Treweler\Functions
 * @version  1.13
 */

defined( 'ABSPATH' ) || exit;

use \Symfony\Component\DomCrawler\Crawler;

function twerGetFiltersShowType($mapId = null) : string {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }
  $storeLocatorFilters = get_post_meta( $mapId, '_treweler_store_locator_filters', true );
  switch ($storeLocatorFilters) {
    case 'yes' :
      $storeLocatorFilters = 'standard';
        break;
    case 'no' :
      $storeLocatorFilters = 'none';
      break;
  }
  return $storeLocatorFilters;
}

if ( ! function_exists( 'twerGetCategories' ) ) {
  /**
   * Get All Treweler Categories For Map
   * Can accept custom arguments to extract terms
   *
   * @param int|null $mapId
   * @param array $args
   *
   * @return array
   */
  function twerGetCategories( int $mapId, array $args = [] ): array {
      if(TWER_IS_FREE)  return [];
    $args = wp_parse_args( $args, [
      'taxonomy'   => 'map-category',
      'hide_empty' => true,
    ] );
    $categories = get_terms( $args );
    $mapCategoriesIds = [];
    $uncategorizedId = (int) get_option( 'default_map_category' );
    $showUncategorized = twerGetNormalMetaCheckboxValue( get_post_meta( $mapId, '_treweler_show_uncategorized', true ) );

    $markersIds = twerGetMarkersForMap( $mapId, [ 'fields' => 'ids' ] );
    $routesIds = twerGetRoutesForMap( $mapId, [ 'fields' => 'ids' ] );

    $markersAndRoutesIds = array_merge( $markersIds, $routesIds );

    if ( ! empty( $markersAndRoutesIds ) ) {
      foreach ( $markersAndRoutesIds as $postId ) {
        foreach ( $categories as $category ) {
          if ( has_term( $category->term_id, 'map-category', $postId ) && ! in_array( $category->term_id, $mapCategoriesIds, true ) ) {
            $mapCategoriesIds[] = $category->term_id;
          }
        }
      }
    }


    if ( ! empty( $categories ) ) {
      foreach ( $categories as $index => $category ) {
        if ( ( 'no' === $showUncategorized && $category->term_id === $uncategorizedId ) || ! in_array( $category->term_id, $mapCategoriesIds, true ) ) {
          unset( $categories[ $index ] );
        }
      }
    }

    return apply_filters( 'twerSetOutputCategories', $categories, $mapId, $args );
  }
}

function twerMapCategorySelect(int $mapId) {
  $categories = twerGetCategories( $mapId );

  if ( ! empty( $categories ) ) {
    echo '<div class="map-category-container"><select class="map-category-field" id="mapCatField" multiple="multiple">';

    foreach ( $categories as $cat ) {
      echo sprintf( '<option  class="slug-%s" value="%s" data-routes="%s" selected="selected">%s</option>',
        $cat->slug, $cat->term_id, twerGetRouteInfo( $mapId, $cat->term_id ), $cat->name );
    }
  }

  echo '</select></div>';
}

/**
 * Get Current Store Locator type for Map (extended or simple)
 *
 * @param $mapId
 *
 * @return mixed
 */
function twerGetStoreLocatorType( $mapId = null ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }

  return get_post_meta( $mapId, '_treweler_store_locator_type', true );
}
if ( ! function_exists( 'twerGetRoutesForMap' ) ) {
  /**
   * Get all routes for specific map
   *
   * @param int $mapId
   * @param array $args
   *
   * @return array
   */
  function twerGetRoutesForMap( int $mapId, array $args = [] ): array {
    $args = wp_parse_args( $args, [
      'post_type'      => 'route',
      'post_status'    => 'publish',
      'posts_per_page' => - 1,
      'meta_query'     => [
        'relation' => 'OR',
        [
          'key'     => TWER_META_PREFIX . 'route_map_id',
          'value'   => $mapId,
          'compare' => '='
        ],
        [
          'key'     => TWER_META_PREFIX . 'route_map_id',
          'value'   => serialize( strval( $mapId ) ),
          'compare' => 'LIKE'
        ]
      ]
    ] );
    $routes = get_posts( $args );

    return apply_filters('twerOutputRoutesForMap', $routes, $args, $mapId);
  }
}

function twerGetMarkersForMap( $mapId = null, $customQueryParams = [] ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }


  $markers = get_posts( wp_parse_args( $customQueryParams, [
    'post_type'      => 'marker',
    'post_status'    => 'publish',
    'posts_per_page' => '-1',
    'meta_query'     => [
      'relation' => 'OR',
      [
        'key'     => '_treweler_marker_map_id',
        'value'   => $mapId,
        'compare' => '='
      ],
      [
        'key'     => '_treweler_marker_map_id',
        'value'   => serialize( strval( $mapId ) ),
        'compare' => 'LIKE'
      ]
    ]
  ] ) );


  if ( ! isset( $customQueryParams['fields'] ) ) {
    foreach ( $markers as &$marker ) {
      $marker->metaData = get_post_meta( $marker->ID );
    }
    unset( $marker );
  }

  return $markers;
}

function twerGetStoreLocatorFiltersForMap( $mapId = null ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }

  return get_post_meta( $mapId, '_treweler_filters_list', true );
}

function twerOutputPopupCustomFields( $markerMetaData, $marker ) {
  $mapMarkerId = $marker['id'] ?? 0;
  $popupStyle = $markerMetaData->popup_style ?? 'light';
  if ( empty( $mapMarkerId ) ) {
    return false;
  }
  $popupCustomFields = twerGetCustomFieldsForMarker( $mapMarkerId );

  if ( ! empty( $popupCustomFields ) ) {
    echo '<div class="twer-custom-fields">';
    foreach ( $popupCustomFields as $fieldData ) {
      $id = $fieldData['id'];
      $type = $fieldData['type'];
      $name = $fieldData['name'];
      $showName = $fieldData['showName'];
      $value = $fieldData['value'];

      switch ( $type ) {
        case 'number' :

          $atts = $fieldData['atts'];

          $attsLine = '';
          $nameFieldWidth = '';
          if ( ! empty( $atts ) && is_array( $atts ) ) {
            foreach ( $atts as $valueAttr => $valueAttrValue ) {
              if($valueAttr === 'data-name-width') {
                $nameFieldWidth = sprintf('style="max-width: %d%%;flex:0 0 %d%%;"', $valueAttrValue, $valueAttrValue);
              } else {
                $attsLine .= ' ' . $valueAttr . '="' . $valueAttrValue . '" ';
              }
            }
          }

            ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?> <?php echo 'no' === $showName ? 'twer-custom-field--one-col' : ''; ?>">
                <div class="twer-custom-field-number"  <?php printf( '%s', $attsLine ); ?>>
                  <?php if ( $showName === 'yes' ) { ?>
                      <div class="twer-custom-field-number__name"  <?php printf( '%s', $nameFieldWidth ); ?>><?php printf( '%s', $name ); ?></div>
                  <?php } ?>
                    <div class="twer-custom-field-number__value"><?php printf( '%s', $value ); ?></div>
                </div>
            </div>
          <?php
          break;
        case 'html' :
          $atts = $fieldData['atts'];

          $attsLine = '';
          if ( ! empty( $atts ) && is_array( $atts ) ) {
            foreach ( $atts as $valueAttr => $valueAttrValue ) {
              $attsLine .= ' ' . $valueAttr . '="' . $valueAttrValue . '" ';
            }
          }
          if (twer_is_map_iframe()) {
            $crawler = new Crawler($value);

	          $linksWithoutTarget = $crawler->filter('a:not([target])');

	          $linksWithoutTarget->each(function (Crawler $node, $i) {
		          $domNode = $node->getNode(0);
		          if ($domNode) {
			          $domNode->setAttribute('target', '_parent');
		          }
	          });


	          $value = $crawler->html();
          }
          ?>
            <div class="twer-custom-field <?php echo 'no' === $showName ? 'twer-custom-field--one-col' : ''; ?>">
                <div class="twer-custom-field-html" <?php printf( '%s', $attsLine ); ?>>
                  <?php if ( $showName === 'yes' ) { ?>
                      <div class="twer-custom-field-html__name"><?php printf( '%s', $name ); ?></div>
                  <?php } ?>
                    <div class="twer-custom-field-html__value"><?php printf( '%s',   $value ); ?></div>
                </div>
            </div>
          <?php break;
        case 'multiselect' :
          $atts = $fieldData['atts'];
          $align = $fieldData['align'];

          $attsLine = '';
          if ( ! empty( $atts ) && is_array( $atts ) ) {
            foreach ( $atts as $valueAttr => $valueAttrValue ) {
              $attsLine .= ' ' . $valueAttr . '="' . $valueAttrValue . '" ';
            }
          }
          ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?>">
                <div class="twer-custom-field-multiselect" <?php printf( '%s', $attsLine ); ?>>
                  <?php if ( $showName === 'yes' ) { ?>
                      <div class="twer-custom-field-multiselect__name"><?php printf( '%s', $name ); ?></div>
                  <?php } ?>
                    <div class="twer-custom-field-multiselect__value">
                      <?php if ( ! empty( $value ) && is_array( $value ) ) { ?>
                          <div class="twer-custom-field-multiselect__list" style="justify-content: <?php echo $align; ?>">
                            <?php foreach ( $value as $valueTag ) { ?>
                                <div class="twer-custom-field-multiselect__list__item"><?php printf( '%s', $valueTag ); ?></div>
                            <?php } ?>
                          </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
          <?php
          break;
        case 'line' :
          $attsLine = '';
          if ( ! empty( $value ) && is_array( $value ) ) {
            foreach ( $value as $valueAttr => $valueAttrValue ) {
              $attsLine .= ' ' . $valueAttr . '=" ' . $valueAttrValue . '" ';
            }
          }
          ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?>">
                <div class="twer-custom-field-line" <?php printf( '%s', $attsLine ); ?>></div>
            </div>
          <?php
          break;
        case 'link-universal' :
          $subtype = $fieldData['subtype'];
          $atts = $fieldData['atts'];

          $attsLine = '';
          $attsStyle = '';
          $nameFieldWidth = '';
          if ( ! empty( $atts ) && is_array( $atts ) ) {
            foreach ( $atts as $valueAttr => $valueAttrValue ) {
              if ( $valueAttr === 'data-align' ) {
                $attsStyle = 'text-align:' . $valueAttrValue . ';';
              } elseif ( $valueAttr === 'data-name-width' ) {
                $nameFieldWidth = sprintf( 'style="max-width: %d%%;flex:0 0 %d%%;"', $valueAttrValue, $valueAttrValue );
              } else {
                $attsLine .= ' ' . $valueAttr . '="' . $valueAttrValue . '" ';
              }
            }
          }


          if (strpos($attsLine, 'target') === false && twer_is_map_iframe()) {
            $attsLine .= ' target="_parent" ';
          }


          $attsLine .= ' class="twer-custom-field-link" ';
          $attsLine = str_replace( "twer-custom-field-link", 'twer-custom-field-' . $subtype, $attsLine );
          ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?> <?php echo 'no' === $showName ? 'twer-custom-field--one-col' : ''; ?>">
                <div class="twer-custom-field-link-universal">
                  <?php if ( $showName === 'yes' ) { ?>
                      <div class="twer-custom-field-link-universal__name" <?php printf( '%s', $nameFieldWidth ); ?>><?php printf( '%s', $name ); ?></div>
                  <?php } ?>
                    <div class="twer-custom-field-link-universal__value js-twer-custom-field-value" style="<?php printf('%s', $attsStyle); ?>">
                        <a <?php printf( '%s', $attsLine ); ?> ><?php printf( '%s', $value ); ?></a>
                    </div>
                </div>
            </div>
          <?php
          break;
        case 'text' :
          $atts = $fieldData['atts'];

          $attsLine = '';
          $nameFieldWidth = '';
          if ( ! empty( $atts ) && is_array( $atts ) ) {
            foreach ( $atts as $valueAttr => $valueAttrValue ) {
                if($valueAttr === 'data-name-width') {
                  $nameFieldWidth = sprintf('style="max-width: %d%%;flex:0 0 %d%%;"', $valueAttrValue, $valueAttrValue);
                } else {
                  $attsLine .= ' ' . $valueAttr . '="' . $valueAttrValue . '" ';
                }
            }
          }

          $showAsTitle = $fieldData['showAsTitle'];

          ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?> <?php echo 'no' === $showName ? 'twer-custom-field--one-col' : ''; ?>">
                <div class="twer-custom-field-text <?php echo $showAsTitle === 'yes' ? 'twer-custom-field-text--as-title' : ''; ?>" <?php printf( '%s', $attsLine ); ?>>
                  <?php if ( $showName === 'yes' ) { ?>
                      <div class="twer-custom-field-text__name" <?php printf( '%s', $nameFieldWidth ); ?>><?php printf( '%s', $name ); ?></div>
                  <?php } ?>
                    <div class="twer-custom-field-text__value"><?php printf( '%s', $value ); ?></div>
                </div>
            </div>
          <?php
          break;
        case 'separator' :
          $attsLine = '';
          if ( ! empty( $value ) && is_array( $value ) ) {
            foreach ( $value as $valueAttr => $valueAttrValue ) {
              $attsLine .= ' ' . $valueAttr . '=" ' . $valueAttrValue . '" ';
            }
          }
          ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?>">
                <div class="twer-custom-field-separator" <?php printf( '%s', $attsLine ); ?>></div>
            </div>
          <?php
          break;
        case 'true_false' :
          ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?> <?php echo 'no' === $showName ? 'twer-custom-field--one-col' : ''; ?>">
                <div class="twer-custom-field-true-false">
                  <?php if ( $showName === 'yes' ) { ?>
                      <div class="twer-custom-field-true-false__name"><?php printf( '%s', $name ); ?></div>
                  <?php } ?>
                    <div class="twer-custom-field-true-false__value <?php echo 'yes' === $value ? 'twer-custom-field-true-false__value--checked' : ''; ?>"></div>
                </div>
            </div>
          <?php
          break;
        case 'category' :
          $atts = $fieldData['atts'];
          $outputType = $fieldData['outputType'];
          $align = $fieldData['align'];

          $attsLine = '';
          if ( ! empty( $atts ) && is_array( $atts ) ) {
            foreach ( $atts as $valueAttr => $valueAttrValue ) {
              $attsLine .= ' ' . $valueAttr . '="' . $valueAttrValue . '" ';
            }
          }
          ?>
            <div class="twer-custom-field twer-custom-field--<?php echo esc_attr( $popupStyle ); ?>">
                <div class="twer-custom-field-category  twer-custom-field-category--as-<?php echo $outputType; ?>" <?php printf( '%s', $attsLine ); ?>>
                  <?php if ( $showName === 'yes' ) { ?>
                      <div class="twer-custom-field-category__name"><?php printf( '%s', $name ); ?></div>
                  <?php } ?>

                    <div class="twer-custom-field-category__value">
                      <?php if ( 'tags' === $outputType ) {
                        if ( ! empty( $value ) && is_array( $value ) ) { ?>
                            <div class="twer-custom-field-multiselect__list" style="justify-content: <?php echo $align; ?>">
                              <?php foreach ( $value as $valueTag ) { ?>
                                  <div class="twer-custom-field-multiselect__list__item"><?php printf( '%s', $valueTag ); ?></div>
                              <?php } ?>
                            </div>
                        <?php }
                      } else {
                        printf( '%s', $value );
                      } ?>
                    </div>
                </div>
            </div>
          <?php
          break;
      }
    }
    echo '</div>';
  }
}

function twerGetStoreLocatorRadiusParams( $mapId = null ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }

  return get_post_meta( $mapId, '_treweler_store_locator_radius', true );
}

function twerGetStoreLocatorRadiusDistance( $mapId = null, $shortForm = true ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }

  $radiusParams = twerGetStoreLocatorRadiusParams( $mapId );
  $radiusDistance = $radiusParams['distance'] ?? 'kilometers';

  switch ( $radiusDistance ) {
    case 'kilometers' :
      $radiusDistance = $shortForm ? esc_html__( 'km', 'treweler' ) : esc_html__( 'kilometers', 'treweler' );
      break;
    case 'miles' :
      $radiusDistance = $shortForm ? esc_html__( 'mi', 'treweler' ) : esc_html__( 'miles', 'treweler' );
      break;
  }

  return $radiusDistance;
}

function twerGetStoreLocatorRadiusSize( $mapId = null ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }
  $radiusParams = twerGetStoreLocatorRadiusParams( $mapId );
  $radiusSizes = $radiusParams['size'] ?? [ 'unlim', 1, 5, 10, 25, 50, 100, 500 ];
  if ( ! empty( $radiusSizes ) && is_array( $radiusSizes ) ) {
    foreach ( $radiusSizes as &$size ) {
      $size = is_numeric( $size ) ? (int) $size : $size;
    }
    unset( $size );
  }

  return $radiusSizes;
}

function twerGetDefaultRadiusSize( $mapId = null ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }

  $defaultRadiusSize = get_post_meta( $mapId, '_treweler_store_locator_radius_default', true );

  if ( is_numeric( $defaultRadiusSize ) && ! empty( $defaultRadiusSize ) ) {
    $defaultRadiusSize = (int) $defaultRadiusSize;
  } elseif ( empty( $defaultRadiusSize ) ) {
    $defaultRadiusSize = 10;
  }

  return apply_filters( 'twerSetDefaultRadiusSize', $defaultRadiusSize, $mapId );
}


function twerGetStoreLocatorRadiusForSelect( $mapId = null, $showWithDistance = true ) {
  if ( empty( $mapId ) ) {
    $mapId = twer_get_map_id();
  }

  $radiusDistance = twerGetStoreLocatorRadiusDistance( $mapId );
  $radiusSizes = twerGetStoreLocatorRadiusSize( $mapId );

  if ( ! empty( $radiusSizes ) && is_array( $radiusSizes ) ) {
    foreach ( $radiusSizes as &$size ) {

      $label = $size === 'unlim' ? esc_html__( 'Unlimited', 'treweler' ) : $size;

      if ( $showWithDistance && $size !== 'unlim' ) {
        $label = sprintf( '%d %s', $size, $radiusDistance );
      }
      $size = [
        'value' => $size,
        'label' => $label
      ];

    }
    unset( $size );
  }

  return $radiusSizes;
}



function twerGetFilteredCustomFieldsForMarker( int $markerId ) {
  if ( 'yes' === twerIsPostTemplateApplied( $markerId ) ) {
    $templateId = twerGetTemplateIdForPost( $markerId );
    $customFieldsIds = twerGetUniqueCustomFieldsIds( $templateId );
  } else {
    $customFieldsIds = twerGetUniqueCustomFieldsIds( $markerId );
  }

  $filteredFieldsIds = [];

  if ( ! empty( $customFieldsIds ) ) {
    foreach ( $customFieldsIds as $fieldId ) {
      $field = twerGetCustomFieldPost( $fieldId );
      if ( 'yes' === twerIsMarkerHasCustomFieldId( $markerId, $fieldId ) && ( $field['type'] === 'number' || $field['type'] === 'true_false' || $field['type'] === 'multiselect' ) ) {

        $filteredFieldsIds[] = [
          'name'  => $field['name'],
          'key'   => $field['key'],
          'value' => twerGetCustomFieldValueInMarker( $fieldId, $markerId )
        ];
      }
    }
  }


  return $filteredFieldsIds;
}


//var_dump(twerGetFilteredCustomFieldsForMarker(1065));
function twerIsCustomFieldLocked( int $fieldId, int $markerId ): string {
  $field = twerGetCustomFieldPost( $fieldId );
  $lockStatus = get_post_meta( $markerId, '_treweler_' . $field['key'] . '_lock', true );

  if(empty($lockStatus)) return 'yes';

  switch ( $field['type'] ) {
    case 'number' :
      $lockStatus = $lockStatus['number'];
      break;
    case 'multiselect' :
      $lockStatus = $lockStatus['multiselect'];
      break;
    case 'true_false' :
      $lockStatus = $lockStatus['true_false'];
      break;
  }


  return $lockStatus === 'open' ? 'no' : 'yes';
}

function twerGetCustomFieldValueInMarker( int $fieldId, int $markerId ) {
  $defaultCustomField = twerGetCustomFieldPost( $fieldId );

  if ( 'yes' === twerIsPostTemplateApplied( $markerId ) ) {
    if ( 'yes' === twerIsCustomFieldLocked( $fieldId, $markerId ) ) {
      if ( $defaultCustomField['type'] === 'multiselect' ) {
        $customFieldMarkerValue = $defaultCustomField['selectedCleaned'];
      } else {
        $customFieldMarkerValue = $defaultCustomField['value'];
      }
    } else {
      $customFieldMarkerValue = get_post_meta( $markerId, '_treweler_' . $defaultCustomField['key'], true );
      $customFieldMarkerValue = $customFieldMarkerValue[ $defaultCustomField['type'] ];
    }
  } else {
    if ( 'yes' === twerIsCustomFieldLocked( $fieldId, $markerId ) ) {
      if ( $defaultCustomField['type'] === 'multiselect' ) {
        $customFieldMarkerValue = $defaultCustomField['selectedCleaned'];
      } else {
        $customFieldMarkerValue = $defaultCustomField['value'];
      }
    } else {
      $customFieldMarkerValue = get_post_meta( $markerId, '_treweler_' . $defaultCustomField['key'], true );
      $customFieldMarkerValue = $customFieldMarkerValue[ $defaultCustomField['type'] ];
    }
  }

  switch ( $defaultCustomField['type'] ) {
    case 'number' :
      $customFieldMarkerValue = round( str_replace( ',', '.', $customFieldMarkerValue ) );
      break;
    case 'multiselect' :
      $customFieldMarkerValue = ! empty( $customFieldMarkerValue ) ? array_map( 'intval', $customFieldMarkerValue ) : [];
      break;
    case 'true_false' :
      $customFieldMarkerValue = twerGetNormalMetaCheckboxValue( $customFieldMarkerValue );
      break;
  }

  return $customFieldMarkerValue;
}

//var_dump( twerGetCustomFieldValueInMarker( 1032, 975 ) );

function twerGetMinAndMaxNumberValueCustomFieldFromMarkers( int $fieldId, int $mapId ): array {
  $allNumberValues = [];

  $markers = twerGetMarkersForMap( $mapId, [ 'fields' => 'ids' ] );

  if ( ! empty( $markers ) ) {
    foreach ( $markers as $markerId ) {
      if ( 'yes' === twerIsMarkerHasCustomFieldId( $markerId, $fieldId ) ) {

        $allNumberValues[] = twerGetCustomFieldValueInMarker( $fieldId, $markerId );
      }
    }
  }

  return apply_filters( 'twerSetMinAndMaxNumberValueCustomFieldFromMarkers', [
    'min' => min( $allNumberValues ),
    'max' => max( $allNumberValues )
  ], $fieldId, $allNumberValues, $markers );
}


function twerGetDefaultRangeNumberValueCustomFieldFromMarkers( int $fieldId, int $mapId ): array {
  $defaultRangeValues = twerGetMinAndMaxNumberValueCustomFieldFromMarkers( $fieldId, $mapId );

  return apply_filters( 'twerSetDefaultRangeNumberValueCustomFieldFromMarkers', $defaultRangeValues, $fieldId );
}

function twerGetFilterBasedFromCustomField( $fieldId, $mapId = 0 ) {
  $field = twerGetCustomFieldPost( $fieldId );

  $filter = [
    'name' => $field['name'],
    'key'  => $field['key'],
  ];
  switch ( $field['type'] ) {
    case 'number' :
      $filter = wp_parse_args( [
        'type'              => 'range',
        'prefix'            => $field['prefix'],
        'suffix'            => $field['suffix'],
        'defaultRangeValue' => twerGetDefaultRangeNumberValueCustomFieldFromMarkers( $fieldId, $mapId ),
        'value'             => twerGetMinAndMaxNumberValueCustomFieldFromMarkers( $fieldId, $mapId )
      ], $filter );
      break;
    case 'multiselect' :
      $filter = wp_parse_args( [
        'type'  => $field['type'],
        'value' => $field['valueCleaned']
      ], $filter );
      break;
    case 'true_false' :
      $filter = wp_parse_args( [
        'type'  => $field['type'],
        'value' => $field['value']
      ], $filter );
      break;
  }


  return $filter;
}


function twerGetRouteInfo( $map_id, $cat_id ) {
  $prefix = '_treweler_';
  $args_routes = [
    'post_type'      => 'route',
    'post_status'    => 'publish',
    'posts_per_page' => '-1',
    'tax_query'      => [
      [
        'taxonomy' => 'map-category',
        'field'    => 'term_id',
        'terms'    => $cat_id
      ]
    ],
    'meta_query'     => [
      'relation' => 'OR',
      [
        'key'     => $prefix . 'route_map_id',
        'value'   => $map_id,
        'compare' => '='
      ],
      [
        'key'     => $prefix . 'route_map_id',
        'value'   => serialize( strval( $map_id ) ),
        'compare' => 'LIKE'
      ]
    ]
  ];


  $get_routes = new WP_Query( $args_routes );
  $col_routes_id = [];


  if ( $get_routes->post_count > 0 ) {
    foreach ( $get_routes->posts as $p => $s ) {
      $col_routes_id[] = $s->ID;
    }
  } else {
    $col_routes_id[] = 0;
  }

  $classes = [];
  if ( $col_routes_id >= 1 ) {
//			$classes = [ 'twer-route-toggle' ];
    foreach ( $col_routes_id as $c ) {
      $classes[] = 'route-' . $c;
    }
  } else {
    $classes = [ 'twer-no-route-toggle' ];
  }


  return implode( ' ', $classes );

}
