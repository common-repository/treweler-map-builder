/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/front/modules/addons.js":
/*!****************************************!*\
  !*** ./src/js/front/modules/addons.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);

/**
 * Init Addons Logic
 */

class TWER_ADDONS {
  /**
   * Сonstructor
   *
   * @param props
   */
  constructor(props) {
    let $btnCatMobile = jQuery('.twer-mobile-menu');
    let $mobileCatMenu = jQuery('.twer-mobile-cat');
    let $select2Container = jQuery('.map-category-container');
    const $selectMapCat = jQuery('#mapCatField');
    var width = jQuery(window).width();
    jQuery(window).on('resize', function () {
      if (jQuery(this).width() !== width) {
        width = jQuery(this).width();

        if (width > 650) {
          $select2Container.show();
          $btnCatMobile.hide();
        } else {
          $select2Container.hide();
          $btnCatMobile.show();
        }
      }
    });
    $btnCatMobile.on('click', function () {
      if (jQuery(window).width() > 650) return false;
      $select2Container.show();
      $selectMapCat.select2('open');
    });
    $selectMapCat.on('select2:open', function (e) {
      if (jQuery(window).width() > 650) return false;
      $mobileCatMenu.hide();
    });
    $selectMapCat.on('select2:close', function (e) {
      if (jQuery(window).width() > 650) return false;
      $select2Container.hide();
      $mobileCatMenu.show();
    });
    /**
     * Fix Height Issue on mobile
     */

    function setDocHeight() {
      document.documentElement.style.setProperty('--vh', `${window.visualViewport.height / 100}px`);
    }
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_ADDONS);

/***/ }),

/***/ "./src/js/front/modules/category-switcher.js":
/*!***************************************************!*\
  !*** ./src/js/front/modules/category-switcher.js ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);

/**
 * Init Category Switcher Logic
 */

class TWER_CATEGORY_SWITCHER {
  /**
   * Сonstructor
   *
   * @param props
   */
  constructor(props) {
    const i18n_categories = treweler_params.i18n_categories;
    const select2Options = {
      selectionCssClass: 'select2-map-filter-select',
      dropdownCssClass: "select2-map-filter-ddl",
      minimumResultsForSearch: Infinity,
      closeOnSelect: false,
      dropdownParent: jQuery('.select2-map-filter'),
      placeholder: i18n_categories.all,
      language: {
        'noResults': function () {
          return i18n_categories.not_found;
        }
      }
    };
    const $selectMapCat = jQuery('#mapCatField');
    const $parentWidget = $selectMapCat.closest('.twer-widget');
    let ddlShowAbove = false;

    if ($parentWidget.hasClass('twer-bottom-right') || $parentWidget.hasClass('twer-bottom-left')) {
      ddlShowAbove = true;
    }

    if (ddlShowAbove) {
      select2Options.dropdownPosition = 'above';
    }

    $selectMapCat.select2(select2Options);
    jQuery('.select2-search.select2-search--inline').html('<span class="category-label">' + i18n_categories.all + '</span>');
    $selectMapCat.on('change', function (e) {
      let inLabel = jQuery('.select2-search .category-label');
      let count = $selectMapCat.select2('data').length;
      let countOptions = jQuery('.select2-results__options .select2-results__option').length;

      if (count === 0) {
        inLabel.html('<span class="category-label">' + i18n_categories.no_selected + '</span>');
      } else if (count === 1) {
        inLabel.html('<span class="category-label">1 ' + i18n_categories.one_selected + '</span>');
      } else if (count > 1 && countOptions !== count) {
        inLabel.html('<span class="category-label">' + count + ' ' + i18n_categories.selected + '</span>');
      } else {
        inLabel.html('<span class="category-label">' + i18n_categories.all + '</span>');
      }
    });
    let select2Main = jQuery('.select2.select2-container');
    select2Main.has('.select2-dropdown--below').addClass('select2-is-dropdown-below');
    select2Main.has('.select2-dropdown--above').addClass('select2-is-dropdown-above');
    /**
     * Map Category Filter
     */

    $selectMapCat.on('select2:unselect', event => {
      let categoryId = parseInt(event.params.data.id) || 0;
      const options = document.getElementById('mapCatField').options;
      const optionsData = {};

      for (let i = 0; i < options.length; i++) {
        if (categoryId === parseInt(options[i].value)) {
          optionsData[options[i].value] = false;
        } else {
          optionsData[options[i].value] = options[i].selected;
        }
      }

      if (TWER.fitBounds) {
        TWER.map.fitBounds(TWER.boundsData, {
          linear: true
        });
      }

      if (!window.TWER.data.allowStoreLocator) {
        // Run code if clusters disabled
        if (!TWER.allowCluster) {
          for (let i = 0; i < TWER.markers.length; i++) {
            const $markerElement = TWER.markers[i].element._element;

            if ($markerElement.classList.contains(`category-${categoryId}`)) {
              TWER.markers[i].show = false;
              TWER.markers[i].element._element.style.display = 'none';
            }
          }
        } else {
          TWER.globalClusterStatus = false;
          const removedIndexesFeatures = [];
          const removedIndexesMarkers = [];
          const removedCats = [];

          if (!TWER.isEmpty(TWER.clusterData)) {
            if (TWER.clusterData.features.length > 0) {
              for (let i = 0; i < TWER.clusterData.features.length; i++) {
                const props = TWER.clusterData.features[i].properties;
                const categories = JSON.parse(props.cat_ids);

                if (categories.length <= 1) {
                  if (categories.includes(categoryId)) {
                    removedCats.push(categoryId);
                    removedIndexesFeatures.push(i);
                    TWER.clusterDataDump.push(TWER.clusterData.features[i]);
                  }
                } else {
                  let globalApprove = 0;

                  for (let j = 0; j < categories.length; j++) {
                    if (!optionsData[categories[j]]) {
                      globalApprove++;
                    }
                  }

                  if (globalApprove === categories.length) {
                    if (categories.includes(categoryId)) {
                      removedCats.push(categoryId);
                      removedIndexesFeatures.push(i);
                      TWER.clusterDataDump.push(TWER.clusterData.features[i]);
                    }
                  }
                }
              }

              if (removedIndexesFeatures.length > 0) {
                const indexSet = new Set(removedIndexesFeatures);
                TWER.clusterData.features = TWER.clusterData.features.filter((value, i) => !indexSet.has(i));
              }

              for (let i = 0; i < TWER.markers.length; i++) {
                const props = TWER.markers[i].feature.properties;
                const markerCategories = JSON.parse(props.cat_ids);

                if (markerCategories.length <= 1) {
                  if (markerCategories.some(item => removedCats.includes(item))) {
                    removedIndexesMarkers.push(i);
                    TWER.markersDataDump.push(TWER.markers[i]);
                  }
                } else {
                  let globalApprove1 = 0;

                  for (let j = 0; j < markerCategories.length; j++) {
                    if (!optionsData[markerCategories[j]]) {
                      globalApprove1++;
                    }
                  }

                  if (globalApprove1 === markerCategories.length) {
                    if (markerCategories.some(item => removedCats.includes(item))) {
                      removedIndexesMarkers.push(i);
                      TWER.markersDataDump.push(TWER.markers[i]);
                    }
                  }
                }
              }

              if (removedIndexesMarkers.length > 0) {
                for (let i = 0; i < removedIndexesMarkers.length; i++) {
                  TWER.markers[removedIndexesMarkers[i]].element.remove();
                }

                const indexSet1 = new Set(removedIndexesMarkers);
                TWER.markers = TWER.markers.filter((value, i) => !indexSet1.has(i));
                TWER.map.getSource('locations').setData(TWER.clusterData);
              }
            }
          }

          if (TWER.markersIgnoredClusters.length > 0) {
            for (let i = 0; i < TWER.markersIgnoredClusters.length; i++) {
              const $markerElement = TWER.markersIgnoredClusters[i].element._element;

              if ($markerElement.classList.contains(`category-${categoryId}`)) {
                TWER.markersIgnoredClusters[i].show = false;
                TWER.markersIgnoredClusters[i].element._element.style.display = 'none';
              }
            }
          }
        }
      }

      let lRoutesRaw = event.params.data.element.dataset.routes.split(' ');
      let routeAnyChecked = false;
      let ids = [];

      for (let i = 0; i < lRoutesRaw.length; i++) {
        if (jQuery("#mapCatField option[value!='" + categoryId + "'][data-routes*='" + lRoutesRaw[i] + "']").is(':checked')) {
          routeAnyChecked = true;
          continue;
        }

        ids.push(lRoutesRaw[i]);
      }

      for (let iw = 0; iw < ids.length; iw++) {
        if (ids[iw] && ids[iw] !== 'route-0') {
          TWER.map.setLayoutProperty(ids[iw], 'visibility', 'none');
        }
      }
    });
    $selectMapCat.on('select2:select', event => {
      if (!window.TWER.data.allowStoreLocator) {
        let categoryId = parseInt(event.params.data.id) || 0;

        if (TWER.fitBounds) {
          TWER.map.fitBounds(TWER.boundsData, {
            linear: true
          });
        } // Run code if clusters disabled


        if (!TWER.allowCluster) {
          for (let i = 0; i < TWER.markers.length; i++) {
            const $markerElement = TWER.markers[i].element._element;

            if ($markerElement.classList.contains(`category-${categoryId}`)) {
              TWER.markers[i].show = true;
              TWER.markers[i].element._element.style.display = 'block';
            }
          }
        } else {
          TWER.globalClusterStatus = false;
          const removedIndexesFeatures = [];
          const removedIndexesMarkers = [];
          const removedCats = [];

          if (!TWER.isEmpty(TWER.clusterDataDump)) {
            if (TWER.clusterDataDump.length > 0) {
              for (let i = 0; i < TWER.clusterDataDump.length; i++) {
                const props = TWER.clusterDataDump[i].properties;
                const categories = JSON.parse(props.cat_ids);

                if (categories.includes(categoryId)) {
                  removedCats.push(categoryId);
                  removedIndexesFeatures.push(i);
                  TWER.clusterData.features.push(TWER.clusterDataDump[i]);
                }
              }

              const indexSet = new Set(removedIndexesFeatures);
              TWER.clusterDataDump = TWER.clusterDataDump.filter((value, i) => !indexSet.has(i));

              for (let i = 0; i < TWER.markersDataDump.length; i++) {
                const props = TWER.markersDataDump[i].feature.properties;
                const markerCategories = JSON.parse(props.cat_ids);

                if (markerCategories.some(item => removedCats.includes(item))) {
                  removedIndexesMarkers.push(i);
                  TWER.markers.push(TWER.markersDataDump[i]);
                }
              }

              for (let i = 0; i < removedIndexesMarkers.length; i++) {
                const coords = TWER.markersDataDump[removedIndexesMarkers[i]].feature.geometry.coordinates;
                const props = TWER.markersDataDump[removedIndexesMarkers[i]].feature.properties;
                const desc = props === null || props === void 0 ? void 0 : props.description;
                props.showPopup = false;
                const markerElement = TWER.createNewMarker(props, coords, desc);
                TWER.markersDataDump[removedIndexesMarkers[i]].element = new mapboxgl.Marker(markerElement).setLngLat(coords).addTo(TWER.map);

                TWER.__afterCreateNewMarker(markerElement, props);
              }

              const indexSet1 = new Set(removedIndexesMarkers);
              TWER.markersDataDump = TWER.markersDataDump.filter((value, i) => !indexSet1.has(i));
              TWER.map.getSource('locations').setData(TWER.clusterData);
            }
          }

          if (TWER.markersIgnoredClusters.length > 0) {
            for (let i = 0; i < TWER.markersIgnoredClusters.length; i++) {
              const $markerElement = TWER.markersIgnoredClusters[i].element._element;

              if ($markerElement.classList.contains(`category-${categoryId}`)) {
                TWER.markersIgnoredClusters[i].show = true;
                TWER.markersIgnoredClusters[i].element._element.style.display = 'block';
              }
            }
          }
        }
      }

      let lRoutesRaw = event.params.data.element.dataset.routes.split(' ');

      for (let i = 0; i < lRoutesRaw.length; i++) {
        if (lRoutesRaw[i] && lRoutesRaw[i] !== 'route-0') {
          TWER.map.setLayoutProperty(lRoutesRaw[i], 'visibility', 'visible');
        }
      }
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_CATEGORY_SWITCHER);

/***/ }),

/***/ "./src/js/front/modules/gallery.js":
/*!*****************************************!*\
  !*** ./src/js/front/modules/gallery.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);


Fancybox.defaults.Hash = false;
/**
 * Init Gallery Logic
 */

class TWER_GALLERY {
  /**
   * Сonstructor
   *
   * @param props
   */
  constructor(props) {
    Fancybox.bind('[data-fancybox]', {
      closeButton: 'outside',
      template: {
        closeButton: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1.00146L22.9988 23.0008" stroke="white" stroke-linecap="round"/><path d="M23 1L1.00094 22.9991" stroke="white" stroke-linecap="round"/></svg>'
      },
      dragToClose: false,
      Image: {
        zoom: false,
        click: null,
        wheel: null
      },
      Toolbar: {
        items: {
          place: {
            type: 'div',
            class: "fancybox__place js-fancybox-twer-place",
            label: "Place",
            tabindex: -1,
            html: '',
            position: 'left'
          },
          prev: {
            type: "button",
            class: "fancybox__button--prev",
            label: "PREV",
            html: '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.82572 12.6514L1.00003 6.82569L6.82572 1" stroke="white"/></svg>',
            click: function (event) {
              event.preventDefault();
              this.fancybox.prev();
            },
            position: 'right'
          },
          next: {
            type: "button",
            class: "fancybox__button--next",
            label: "NEXT",
            html: '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.17428 12.6514L6.99997 6.82569L1.17428 1" stroke="white"/></svg>',
            click: function (event) {
              event.preventDefault();
              this.fancybox.next();
            },
            position: 'right'
          }
        },
        display: ['place', 'prev', 'next']
      },
      Carousel: {
        Navigation: false
      },
      keyboard: {
        Escape: "close",
        Delete: "close",
        Backspace: "close",
        PageUp: false,
        PageDown: false,
        ArrowUp: false,
        ArrowDown: false,
        ArrowRight: false,
        ArrowLeft: false
      },
      on: {
        'Carousel.change': fancybox => {
          const $toolbar = fancybox.plugins.Toolbar.$container;
          const placeValue = fancybox.items[0].$trigger.dataset.place.trim();
          const $placeElement = $toolbar.getElementsByClassName('js-fancybox-twer-place')[0];
          const infoValue = fancybox.getSlide().caption;
          let separator = '';

          if (infoValue.length > 0) {
            separator = '<div class="place-separator"></div>';
          }

          $placeElement.innerHTML = `${placeValue}${separator}${infoValue}`;
        },
        'ready': fancybox => {
          const $toolbar = fancybox.plugins.Toolbar.$container;
          const placeValue = fancybox.items[0].$trigger.dataset.place.trim();
          const $placeElement = $toolbar.getElementsByClassName('js-fancybox-twer-place')[0];
          const infoValue = fancybox.items[0].$trigger.getElementsByTagName('img')[0].alt.trim();
          let separator = '';

          if (infoValue.length > 0) {
            separator = '<div class="place-separator"></div>';
          }

          $placeElement.innerHTML = `${placeValue}${separator}${infoValue}`;
        }
      },
      Thumbs: false,
      hash: false
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_GALLERY);

/***/ }),

/***/ "./src/js/front/modules/layers.js":
/*!****************************************!*\
  !*** ./src/js/front/modules/layers.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");




class TwerLayers {
  constructor(data) {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "layerMappings", {
      place_labels: 'showPlaceLabels',
      road_labels: 'showRoadLabels',
      points_of_interest: 'showPointOfInterestLabels',
      transit_labels: 'showTransitLabels'
    });

    this.mapStyle = data.style;
    this.activeLayers = data.layers;
    this.layersTypes = ['showPlaceLabels', 'showRoadLabels', 'showPointOfInterestLabels', 'showTransitLabels'];
    TWER.map.on('style.load', () => {
      if (data.customStyle === '') {
        this.handleStyleLoad();
      }
    });
  }

  handleStyleLoad() {
    if (this.mapStyle === 'mapbox://styles/mapbox/standard-beta') {
      this.layersTypes.forEach(item => {
        TWER.map.setConfigProperty('basemap', item, this.activeLayers.includes(item));
      });
    } else {
      this.updateMapLayers();
    }
  }

  setLayerVisibility(layerId, visibility) {
    TWER.map.setLayoutProperty(layerId, 'visibility', visibility ? 'visible' : 'none');
  }

  updateLayerVisibility(layers, activeLayers, layerType) {
    layers.forEach(layerId => {
      this.setLayerVisibility(layerId, activeLayers.includes(layerType));
    });
  }

  updateMapLayers() {
    const layerGroups = {
      showPlaceLabels: ['continent-label', 'country-label', 'state-label', 'settlement-major-label', 'settlement-minor-label', 'settlement-subdivision-label'],
      showRoadLabels: ['road-exit-shield', 'road-label-simple', 'road-exit-shield-navigation', 'road-number-shield', 'road-number-shield-navigation', 'road-label-navigation', 'road-label', 'road-intersection'],
      showPointOfInterestLabels: ['poi-label'],
      showTransitLabels: ['airport-label', 'transit-label', 'ferry-aerialway-label'],
      boundaries: ['admin-0-boundary-disputed', 'admin-0-boundary', 'admin-1-boundary', 'admin-0-boundary-bg', 'admin-1-boundary-bg'],
      building_labels: ['block-number-label', 'building-number-label', 'building-entrance'],
      buildings: ['building', 'building-underground', 'building-outline'],
      natural_features: ['water-point-label', 'water-line-label', 'natural-point-label', 'natural-line-label', 'waterway-label'],
      pedestrian_labels: ['golf-hole-label', 'path-pedestrian-label'],
      pedestrian_roads: ['bridge-pedestrian', 'bridge-steps', 'bridge-path', 'bridge-pedestrian-case', 'bridge-steps-bg', 'bridge-path-bg', 'golf-hole-line', 'road-pedestrian', 'road-steps', 'road-path', 'road-pedestrian-case', 'road-steps-bg', 'road-path-bg', 'road-pedestrian-polygon-pattern', 'road-pedestrian-polygon-fill', 'tunnel-pedestrian', 'tunnel-steps', 'tunnel-path', 'gate-label', 'bridge-path-cycleway-piste', 'bridge-path-trail', 'road-path-cycleway-piste', 'road-path-trail', 'tunnel-path-cycleway-piste', 'tunnel-path-trail'],
      transit: ['aerialway', 'bridge-rail-tracks', 'bridge-rail', 'road-rail-tracks', 'road-rail', 'ferry-auto', 'ferry', 'aeroway-line', 'aeroway-polygon'],
      roads: ["bridge-oneway-arrow-white", "bridge-oneway-arrow-blue", "bridge-motorway-trunk-2", "bridge-major-link-2", "bridge-motorway-trunk-2-case", "bridge-major-link-2-case", "bridge-motorway-trunk", "bridge-primary", "bridge-secondary-tertiary", "bridge-street-low", "bridge-street", "bridge-major-link", "bridge-minor-link", "bridge-minor", "bridge-construction", "bridge-motorway-trunk-case", "bridge-major-link-case", "bridge-primary-case", "bridge-secondary-tertiary-case", "bridge-minor-link-case", "bridge-street-case", "bridge-minor-case", "crosswalks", "road-oneway-arrow-white", "road-oneway-arrow-blue", "level-crossing", "road-motorway-trunk", "road-primary", "road-secondary-tertiary", "road-street-low", "road-street", "road-major-link", "road-minor-link", "road-minor", "road-construction", "turning-feature", "road-motorway-trunk-case", "road-major-link-case", "road-primary-case", "road-secondary-tertiary-case", "road-minor-link-case", "road-street-case", "road-minor-case", "turning-feature-outline", "road-polygon", "tunnel-oneway-arrow-white", "tunnel-oneway-arrow-blue", "tunnel-motorway-trunk", "tunnel-primary", "tunnel-secondary-tertiary", "tunnel-street-low", "tunnel-street", "tunnel-major-link", "tunnel-minor-link", "tunnel-minor", "tunnel-construction", "tunnel-motorway-trunk-case", "tunnel-major-link-case", "tunnel-primary-case", "tunnel-secondary-tertiary-case", "tunnel-minor-link-case", "tunnel-street-case", "tunnel-minor-case", "bridge-simple", "bridge-case-simple", "road-simple", "tunnel-simple", "incident-startpoints-navigation", "incident-endpoints-navigation", "incident-closure-line-highlights-navigation", "incident-closure-lines-navigation", "traffic-bridge-oneway-arrow-white-navigation", "traffic-bridge-oneway-arrow-blue-navigation", "traffic-road-oneway-arrow-white-navigation", "traffic-road-oneway-arrow-blue-navigation", "traffic-tunnel-oneway-arrow-white-navigation", "traffic-tunnel-oneway-arrow-blue-navigation", "traffic-level-crossing-navigation", "traffic-bridge-road-motorway-trunk-navigation", "traffic-bridge-road-motorway-trunk-case-navigation", "traffic-bridge-road-major-link-navigation", "traffic-bridge-road-primary-navigation", "traffic-bridge-road-secondary-tertiary-navigation", "traffic-bridge-road-street-navigation", "traffic-bridge-road-minor-navigation", "traffic-bridge-road-link-navigation", "bridge-motorway-trunk-2-navigation", "bridge-major-link-2-navigation", "bridge-motorway-trunk-2-case-navigation", "bridge-major-link-2-case-navigation", "bridge-motorway-trunk-navigation", "bridge-primary-navigation", "bridge-secondary-tertiary-navigation", "bridge-street-navigation", "bridge-minor-navigation", "bridge-major-link-navigation", "bridge-construction-navigation", "bridge-motorway-trunk-case-navigation", "bridge-major-link-case-navigation", "bridge-primary-case-navigation", "bridge-secondary-tertiary-case-navigation", "bridge-street-case-navigation", "bridge-street-low-navigation", "bridge-minor-case-navigation", "turning-feature-navigation", "level-crossing-navigation", "traffic-tunnel-motorway-trunk-navigation", "road-motorway-trunk-navigation", "traffic-tunnel-major-link-navigation", "road-motorway-trunk-case-low-navigation", "traffic-tunnel-primary-navigation", "road-primary-navigation", "traffic-tunnel-secondary-tertiary-navigation", "road-secondary-tertiary-navigation", "traffic-tunnel-street-navigation", "road-street-navigation", "traffic-tunnel-minor-navigation", "traffic-tunnel-link-navigation", "road-minor-navigation", "road-major-link-navigation", "road-construction-navigation", "road-motorway-trunk-case-navigation", "road-major-link-case-navigation", "road-primary-case-navigation", "road-secondary-tertiary-case-navigation", "road-street-case-navigation", "road-street-low-navigation", "road-minor-case-navigation", "turning-feature-outline-navigation", "tunnel-motorway-trunk-navigation", "tunnel-primary-navigation", "tunnel-secondary-tertiary-navigation", "tunnel-street-navigation", "tunnel-minor-navigation", "tunnel-major-link-navigation", "tunnel-construction-navigation", "tunnel-motorway-trunk-case-navigation", "tunnel-major-link-case-navigation", "tunnel-primary-case-navigation", "tunnel-secondary-tertiary-case-navigation", "tunnel-street-case-navigation", "tunnel-street-low-navigation", "tunnel-minor-case-navigation"],
      land_structure: ["land-structure-line", "land-structure-polygon", "pitch-outline", "landuse", "national-park", "landcover", "national-park_tint-band", "cliff", "wetland-pattern", "wetland"],
      hillshade: ['hillshade'],
      water_depth: ['water-depth'],
      contour_lines: ['contour-label', 'contour-line']
    };
    TWER.map.getStyle().layers.map(layer => {
      for (const [layerType, layerIds] of Object.entries(layerGroups)) {
        if (layerIds.includes(layer.id)) {
          this.setLayerVisibility(layer.id, this.activeLayers.includes(layerType));
          break;
        }
      }
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TwerLayers);

/***/ }),

/***/ "./src/js/front/modules/preloader.js":
/*!*******************************************!*\
  !*** ./src/js/front/modules/preloader.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");

/**
 * Init Preload Logic
 */



class TWER_PRELOADER {
  constructor() {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$preloader", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$counter", null);

    this.$preloader = document.getElementsByClassName('twer-preloader');
    this.$counter = document.querySelectorAll('.twer-preloader .loading-progress');

    if (!TWER.data.boundaries) {
      this.initPreloader();
    }

    TWER.map.on('idle', e => {
      if (!TWER.data.boundaries) {
        // HIDE Preloader when map idle
        this.hide();
      }
    });
  }

  initPreloader() {
    if (this.$preloader.length > 0) {
      let plr = 0;

      if (plr === 0) {
        plr = 1;
        let percent = 1;
        const id = setInterval(() => {
          let maxPercent = Math.floor(Math.random() * (99 - 95 + 1) + 95);

          if (percent >= maxPercent) {
            clearInterval(id);
            plr = 0;
          } else {
            percent++;

            if (this.$counter.length > 0) {
              this.$counter[0].innerHTML = `${percent}%`;
            }
          }
        }, 10);
      }
    }
  }

  hide() {
    if (this.$preloader.length > 0) {
      setTimeout(() => {
        this.$preloader[0].classList.add('twer-preloader--hide');
      }, 500);
    }
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_PRELOADER);

/***/ }),

/***/ "./src/js/front/modules/tour.js":
/*!**************************************!*\
  !*** ./src/js/front/modules/tour.js ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);

/**
 * Init Tour Logic
 */

class TWER_TOUR {
  /**
   * Сonstructor
   *
   * @param data
   */
  constructor(data) {
    TWER.tour = data.allowTour;
    TWER.tourAutoRun = data.allowTour;

    if (data.allowTour) {
      localStorage.setItem('toggleTourTag', 1);
      localStorage.setItem('toggleTourEnd', 1);
      localStorage.setItem('toggleTourNeverRunning', 1);
      let mainTourData = {
        'tourData': data.tourData,
        'tourPopUp': data.tourPopUp,
        'tourType': data.tourType,
        'tourFlySpeed': data.tourFlySpeed,
        'tourFlyCurve': data.tourFlyCurve,
        'tourLabelMarker': data.tourLabelMarker
      };
      this.tourHandler(mainTourData);

      if (data.tourAutoRun) {
        TWER.map.once('idle', () => {
          setTimeout(() => {
            document.getElementById('btn-tour-right').click();
          }, 200);
        });
      }
    } else {
      localStorage.setItem('toggleTourTag', 0);
      localStorage.setItem('toggleTourEnd', 1);
      localStorage.setItem('toggleTourNeverRunning', 1);
    }
  }

  tourHandler(mainTourData) {
    let arr = JSON.parse(mainTourData.tourData);
    let tourPopUpGlobal = mainTourData.tourPopUp;
    let i = -1;
    let tourNumberContainer = document.getElementsByClassName('twer-tour-number-container-js');
    let tourNumber = document.getElementsByClassName('twer-tour-number');
    let tourNumberLabel = document.getElementsByClassName('twer-tour-number-label');
    const tourTextLabel = document.getElementsByClassName('text-label');
    let countedTour = arr.length;

    if (countedTour === 0) {
      return;
    }

    function twerStrInt(numInt) {
      return numInt.toLocaleString('en-US', {
        minimumIntegerDigits: 2,
        useGrouping: false
      });
    }

    function nextItem() {
      i = i + 1;
      i = i % arr.length;
      return {
        ix: i,
        data: arr[i]
      };
    }

    function prevItem() {
      if (i <= 0) {
        // i would become 0
        i = arr.length; // so put it at the other end of the array
      }

      i = i - 1; // decrease by one

      return {
        ix: i,
        data: arr[i]
      };
    }

    document.getElementById('btn-tour-left').addEventListener('click', e => {
      let prev = prevItem();
      if (typeof prev.data === 'undefined') return;
      TWER.tourInProgress = true;
      let prevData = prev.data;
      let idx = prev.ix + 1;
      let tourPopUpMarker = prevData.showPopUp;
      let advancedSettingsMarker = prevData.advanced_settings;
      console.log(tourTextLabel.length);

      if (!mainTourData.tourLabelMarker && tourTextLabel.length > 0) {
        tourTextLabel[0].style.display = 'none';
      }

      if (typeof tourNumberContainer[0] !== 'undefined') {
        tourNumberContainer[0].classList.add('with-number');
        tourNumber[0].innerHTML = twerStrInt(idx) + '/' + twerStrInt(countedTour);

        if (mainTourData.tourLabelMarker) {
          tourNumberLabel[0].innerHTML = prevData.title;
        }
      }

      if (mainTourData.tourType === 'jump') {
        TWER.map.jumpTo({
          center: [prevData.geo.lang, prevData.geo.lat],
          zoom: prevData.zoom,
          pitch: prevData.pitch,
          bearing: prevData.bearing,
          padding: {
            top: prevData.tourOffsets.top,
            bottom: prevData.tourOffsets.bottom,
            left: prevData.tourOffsets.left,
            right: prevData.tourOffsets.right
          }
        });
      } else if (mainTourData.tourType === 'fly') {
        TWER.map.flyTo({
          center: [prevData.geo.lang, prevData.geo.lat],
          zoom: prevData.zoom,
          speed: parseFloat(prevData.flySpeed),
          curve: parseFloat(prevData.flyCurve),
          pitch: prevData.pitch,
          bearing: prevData.bearing,
          padding: {
            top: prevData.tourOffsets.top,
            bottom: prevData.tourOffsets.bottom,
            left: prevData.tourOffsets.left,
            right: prevData.tourOffsets.right
          }
        });
      } // If enable tourPopUpGlobal popups


      if (tourPopUpGlobal) {
        if (!advancedSettingsMarker || tourPopUpMarker) {
          // Close all popups except current popup
          TWER.closePopups([], {
            except: [prevData.id]
          });
        } else {
          // Close all popups
          TWER.closePopups();
        }

        if (!advancedSettingsMarker || advancedSettingsMarker && tourPopUpMarker) {
          // Open current popup with disable toggle
          let event = {};
          let coords = JSON.parse(prevData.geo.str);
          event.target = document.getElementById(`twer-popup-id-${prevData.id}`);
          TWER.openPopup(event, coords, {
            toggle: false
          });
        }
      } else {
        if (advancedSettingsMarker && tourPopUpMarker) {
          // Close all popups except current popup
          TWER.closePopups([], {
            except: [prevData.id]
          }); // Open current popup with disable toggle

          let event = {};
          let coords = JSON.parse(prevData.geo.str);
          event.target = document.getElementById(`twer-popup-id-${prevData.id}`);
          TWER.openPopup(event, coords, {
            toggle: false
          });
        } else {
          // Close all popups if global tour popup disabled
          TWER.closePopups();
        }
      }
    });
    document.getElementById('btn-tour-right').addEventListener('click', e => {
      let next = nextItem();
      if (typeof next.data === 'undefined') return;
      TWER.tourInProgress = true; // the e here is the event itself

      let nextData = next.data;
      let idx = next.ix + 1;
      let tourPopUpMarker = nextData.showPopUp;
      let advancedSettingsMarker = nextData.advanced_settings;

      if (!mainTourData.tourLabelMarker && tourTextLabel.length > 0) {
        tourTextLabel[0].style.display = 'none';
      }

      if (typeof tourNumberContainer[0] !== 'undefined') {
        tourNumberContainer[0].classList.add('with-number');
        tourNumber[0].innerHTML = twerStrInt(idx) + '/' + twerStrInt(countedTour);

        if (mainTourData.tourLabelMarker) {
          tourNumberLabel[0].innerHTML = nextData.title;
        }
      }

      if (mainTourData.tourType === 'jump') {
        TWER.map.jumpTo({
          center: [nextData.geo.lang, nextData.geo.lat],
          zoom: nextData.zoom,
          pitch: nextData.pitch,
          bearing: nextData.bearing,
          padding: {
            top: nextData.tourOffsets.top,
            bottom: nextData.tourOffsets.bottom,
            left: nextData.tourOffsets.left,
            right: nextData.tourOffsets.right
          }
        });
      } else if (mainTourData.tourType === 'fly') {
        TWER.map.flyTo({
          center: [nextData.geo.lang, nextData.geo.lat],
          padding: {
            top: nextData.tourOffsets.top,
            bottom: nextData.tourOffsets.bottom,
            left: nextData.tourOffsets.left,
            right: nextData.tourOffsets.right
          },
          zoom: nextData.zoom,
          speed: parseFloat(nextData.flySpeed),
          curve: parseFloat(nextData.flyCurve),
          pitch: nextData.pitch,
          bearing: nextData.bearing
        });
      } // If enable tourPopUpGlobal popups


      if (tourPopUpGlobal) {
        if (!advancedSettingsMarker || tourPopUpMarker) {
          // Close all popups except current popup
          TWER.closePopups([], {
            except: [nextData.id]
          });
        } else {
          // Close all popups
          TWER.closePopups();
        }

        if (!advancedSettingsMarker || advancedSettingsMarker && tourPopUpMarker) {
          // Open current popup with disable toggle popups
          let event = {};
          let coords = JSON.parse(nextData.geo.str);
          event.target = document.getElementById(`twer-popup-id-${nextData.id}`);
          TWER.openPopup(event, coords, {
            toggle: false
          });
        }
      } else {
        if (advancedSettingsMarker && tourPopUpMarker) {
          // Close all popups except current popup
          TWER.closePopups([], {
            except: [nextData.id]
          }); // Open current popup with disable toggle popups

          let event = {};
          let coords = JSON.parse(nextData.geo.str);
          event.target = document.getElementById(`twer-popup-id-${nextData.id}`);
          TWER.openPopup(event, coords, {
            toggle: false
          });
        } else {
          // Close all popups if global tour popup disabled
          TWER.closePopups();
        }
      }
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_TOUR);

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _defineProperty; }
/* harmony export */ });
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************************!*\
  !*** ./src/js/front/treweler.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_preloader__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/preloader */ "./src/js/front/modules/preloader.js");
/* harmony import */ var _modules_gallery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/gallery */ "./src/js/front/modules/gallery.js");
/* harmony import */ var _modules_category_switcher__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/category-switcher */ "./src/js/front/modules/category-switcher.js");
/* harmony import */ var _modules_addons__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/addons */ "./src/js/front/modules/addons.js");
/* harmony import */ var _modules_tour__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/tour */ "./src/js/front/modules/tour.js");
/* harmony import */ var _modules_layers__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./modules/layers */ "./src/js/front/modules/layers.js");









window.TWER = {
  clusterDataDump: [],
  storeLocatorDataDump: [],
  clusterData: {},
  clusterDataSources: {},
  routeData: {},
  map: {},
  popups: [],
  globalClusterStatus: true,
  data: {},
  clusterColor: '#4b7715',
  markersDataDump: [],
  markers: [],
  markersIgnoredClusters: [],
  boundsData: [],
  fitBounds: true,
  animationDelayClose: 400,
  animationDelayOpen: 250,
  tour: false,
  tourAutoRun: false,
  tourInProgress: false,
  geolocateControl: false,
  ajaxLoading: false,
  currentMapPageId: 0,
  allMapMarkers: [],
  markerLocation: false,
  markerLocationProps: {
    id: 0,
    marker_style: 'default',
    point_halo_color: '#fff',
    point_halo_opacity: 0.5,
    point_color: '#4b7715',
    custom_marker_img: '',
    cursor: 'pointer',
    anchor: 'center'
  },
  initAllMapMarkers: function () {
    const data = new FormData();
    data.append('action', 'twer_loadMapMarkers');
    data.append('mapId', this.currentMapPageId);
    fetch(treweler_params.ajax_url, {
      method: "POST",
      credentials: 'same-origin',
      body: data
    }).then(response => response.json()).then(data => {
      if (data) {
        this.allMapMarkers = data;
      }
    }).catch(error => {
      console.error(error);
    });
  },
  initMap: function (data) {
    // Set data global
    TWER.data = data;
    TWER.clusterDataSources = TWER.clusterData.features;
    this.currentMapPageId = data.mapPageId; //this.initAllMapMarkers();
    // Parse access token from php

    mapboxgl.accessToken = data.accessToken; // Set global cluster variable

    TWER.clusterColor = data.clusterColor;
    TWER.allowCluster = data.allowCluster;
    const params = {
      container: 'twer-map',
      style: data.style,
      center: data.center,
      minZoom: data.minZoom,
      maxZoom: data.maxZoom,
      zoom: data.zoom,
      bearing: data.iniBearing,
      pitch: data.iniPitch,
      maxPitch: data.maxPitch,
      minPitch: data.minPitch,
      attributionControl: false,
      logoPosition: data.wordmarkPosition,
      projection: {
        name: data.projection
      },
      fadeDuration: 0 // Disable fade animation for clusters

    }; // Add Restrict map panning to an area

    if (data.restrictPanning) {
      params.maxBounds = data.restrictPanningData;
    } // Init map by values from php


    TWER.map = new mapboxgl.Map(params);
    new _modules_layers__WEBPACK_IMPORTED_MODULE_5__["default"](data);
    TWER.map.on('style.load', () => {
      TWER.map.setFog({});

      if (data.style === 'mapbox://styles/mapbox/standard-beta') {
        if (data.mapLightPreset) {
          TWER.map.setConfigProperty('basemap', 'lightPreset', data.mapLightPreset);
        }
      }
    }); // Disables the "drag to pan" interaction.

    if (data.disableDragPan) {
      TWER.map.dragPan.disable();
    } // Add Attribution Compact Control param


    TWER.map.addControl(new mapboxgl.AttributionControl({
      compact: data.compactAttribution
    }), data.attributionPosition); // Languanges Config

    if (data.mapLanguange !== 'browser') {
      mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js');
      TWER.map.addControl(new MapboxLanguage({
        defaultLanguage: data.mapLanguange
      }));
      setTimeout(function () {
        TWER.map.setLayoutProperty('country-label', 'text-field', ['get', 'name_' + data.mapLanguange]);
      }, 200);
    }

    if (!data.allowBearing) {
      TWER.map.dragRotate.disable();
      TWER.map.touchZoomRotate.disableRotation();
    } // Add additional controls (parse data from php)


    if (data.scaleControl) {
      TWER.map.addControl(new mapboxgl.ScaleControl({
        maxWidth: 100,
        unit: data.scaleControlUnit ? data.scaleControlUnit : 'imperial'
      }), data.scaleControlPosition);
    } // Add fullscreen control button


    if (data.fullscreenControl) {
      TWER.map.addControl(new mapboxgl.FullscreenControl(), data.fullscreenControlPosition);
    } // Add search control field


    if (data.searchControl) {
      TWER.MapboxGeocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        zoom: 14,
        placeholder: data.searchControlPlaceholder,
        mapboxgl: mapboxgl,
        marker: false
      });
      TWER.map.addControl(TWER.MapboxGeocoder, data.searchControlPosition);
    } // Add zoom controls for map


    if (data.zoomControl) {
      TWER.map.addControl(new mapboxgl.NavigationControl(), data.zoomControlPosition);
    } // Enable/disable shortcode scrollzoom


    if (!data.scrollZoom) {
      TWER.map.scrollZoom.disable();
    } //if (!data.allowStoreLocator) {
    // Call another handlers after main init method


    TWER.onLoadMap();

    if (data.allowCluster) {
      TWER.clustersHandlers();
    }

    TWER.onClickMap(); //}
    // Init fitbounds settings

    TWER.boundsData = TWER.map.getBounds().toArray();
    TWER.fitBounds = data.fitBounds;
    TWER.map.setRenderWorldCopies(data.worldCopy); // Tour logic

    new _modules_tour__WEBPACK_IMPORTED_MODULE_4__["default"](data); // Call categories switcher handlers

    new _modules_category_switcher__WEBPACK_IMPORTED_MODULE_2__["default"](); // Addons code

    new _modules_addons__WEBPACK_IMPORTED_MODULE_3__["default"](); // Gallery

    new _modules_gallery__WEBPACK_IMPORTED_MODULE_1__["default"](); // Call preloader handlers

    new _modules_preloader__WEBPACK_IMPORTED_MODULE_0__["default"]();
    jQuery(document).on('click', '.js-twer-close-popup-btn', e => {
      e.preventDefault();
      const match = e.target.closest('.js-twer-popup').classList.value.match(/twer-popup-id-\d+/gm);
      const matchedId = match[0] !== undefined ? parseInt(match[0].replace(/^\D+/g, '')) : '';

      if (matchedId !== '') {
        TWER.closePopups([matchedId]);
      }
    });
  },
  onLoadMap: function () {
    TWER.map.on('load', async () => {
      // Add overlay for map
      const alpha = TWER.data.bgOverlay.replace(/^.*,(.+)\)/, '$1');
      const isAlpha = isNaN(parseFloat(alpha)) ? 1 : parseFloat(alpha);

      if (TWER.data.bgOverlay && isAlpha !== 0) {
        TWER.map.addLayer({
          id: 'bg-layer',
          type: 'background',
          paint: {
            'background-color': TWER.data.bgOverlay
          }
        });
      }

      if (!TWER.isEmpty(TWER.clusterData)) {
        // Add source data
        TWER.map.addSource('locations', {
          type: 'geojson',
          data: TWER.clusterData,
          generateId: true,
          cluster: true,
          clusterMaxZoom: TWER.data.clusterMaxZoom,
          clusterRadius: 50
        }); // Add clusters layer

        TWER.map.addLayer({
          id: 'clusters',
          type: 'circle',
          source: 'locations',
          filter: ['has', 'point_count'],
          paint: {
            'circle-color': '#fff',
            'circle-radius': 40,
            'circle-stroke-color': '#ac2929',
            'circle-opacity': 0,
            'circle-stroke-opacity': 0
          }
        }); // Add numbers for clusters

        TWER.map.addLayer({
          id: 'markerPnt',
          type: 'symbol',
          source: 'locations',
          filter: ['has', 'point_count'],
          layout: {
            'text-field': '{point_count_abbreviated}',
            'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
            'text-size': 0
          }
        }); // Add default layer points (aka markers in code)

        TWER.map.addLayer({
          id: 'unclustered-point',
          type: 'circle',
          source: 'locations',
          filter: ['!', ['has', 'point_count']],
          paint: {
            'circle-color': '#22b719',
            'circle-radius': 15,
            'circle-stroke-width': 1,
            'circle-stroke-color': '#fff',
            'circle-stroke-opacity': 0,
            'circle-opacity': 0
          }
        }); // Add static markers to map

        if (TWER.clusterData.features.length > 0) {
          let i = 0;
          const markersIdsRemoved = [];

          for (const feature of TWER.clusterData.features) {
            const marker = {};
            const coords = feature.geometry.coordinates;
            const props = feature.properties;
            const desc = props === null || props === void 0 ? void 0 : props.description;
            const markerElement = TWER.createNewMarker(props, coords, desc);
            marker.element = new mapboxgl.Marker(markerElement).setLngLat(coords).addTo(TWER.map);

            TWER.__afterCreateNewMarker(markerElement, props, coords);

            marker.feature = feature;
            marker.show = true; // Remove marker from clusterData if it ignored cluster

            if (!props.allowMarkerCluster && TWER.allowCluster) {
              markersIdsRemoved.push(i); // Push current markers to array

              TWER.markersIgnoredClusters.push(marker);
            } else {
              // Push current markers to array
              TWER.markers.push(marker);
            }

            i++;
          }

          if (markersIdsRemoved.length > 0) {
            const indexSet = new Set(markersIdsRemoved);
            let inClusterFeatures = [];
            let outClusterFeatures = [];
            TWER.clusterData.features.filter((value, i) => {
              if (!indexSet.has(i)) {
                inClusterFeatures.push(value);
              } else {
                outClusterFeatures.push(value);
              }
            });
            TWER.clusterData.features = TWER.clusterData.features.filter((value, i) => !indexSet.has(i));
            TWER.outClusterFeatures = outClusterFeatures;
            TWER.map.getSource('locations').setData(TWER.clusterData);
          }
        }

        let notClustersData = [];
        let clustersData = [];
        let viewPortMarkersData = [];
        let markersInViewPort = [];
        let clusters = [];

        function markerExists(id, array) {
          return array.some(function (marker) {
            return marker.id === id;
          });
        }

        TWER.map.on('render', () => {
          if (!TWER.map.isSourceLoaded('locations') || !TWER.allowCluster) return; //console.log('render TW');

          notClustersData = [];
          clustersData = [];
          viewPortMarkersData = [];
          markersInViewPort = [];
          const viewPortMarkers = TWER.map.querySourceFeatures('locations', {
            sourceLayer: ['unclustered-point']
          });
          const featuresNotClusters = TWER.map.querySourceFeatures('locations', {
            filter: ['!', ['has', 'point_count']],
            sourceLayer: ['unclustered-point']
          });
          const featuresClusters = TWER.map.querySourceFeatures('locations', {
            filter: ['has', 'point_count'],
            sourceLayer: ['unclustered-point']
          });

          if (viewPortMarkers.length > 0) {
            for (let i = 0; i < viewPortMarkers.length; i++) {
              if (!markerExists(viewPortMarkers[i].id, viewPortMarkersData)) {
                viewPortMarkersData.push(viewPortMarkers[i]);
              }
            }
          }

          if (featuresNotClusters.length > 0) {
            for (let i = 0; i < featuresNotClusters.length; i++) {
              if (!markerExists(featuresNotClusters[i].id, notClustersData)) {
                notClustersData.push(featuresNotClusters[i]);
              }
            }
          }

          if (featuresClusters.length > 0) {
            for (let i = 0; i < featuresClusters.length; i++) {
              if (!markerExists(featuresClusters[i].id, clustersData)) {
                clustersData.push(featuresClusters[i]);
              }
            }
          } // Detect if clusters show


          if (clustersData.length !== 0 && TWER.markers.length > 0) {
            //console.log('TW 1');
            // Get only show in viewport static markers
            for (let i = 0; i < TWER.markers.length; i++) {
              if (TWER.map.getBounds().contains(TWER.markers[i].element.getLngLat())) {
                markersInViewPort.push(TWER.markers[i]);
              }
            }

            for (let i = 0; i < markersInViewPort.length; i++) {
              let notClustersMarkersIds = [];
              let viewPortMarkersIds = markersInViewPort[i].feature.properties.id;

              for (let j = 0; j < notClustersData.length; j++) {
                notClustersMarkersIds.push(notClustersData[j].properties.id);
              }

              if (notClustersMarkersIds.includes(viewPortMarkersIds)) {
                markersInViewPort[i].show = true;
                markersInViewPort[i].element._element.style.display = 'block';
              } else {
                // Trick if cluster enabled and we in tour progress
                if (!TWER.tourInProgress) {
                  TWER.closePopups([markersInViewPort[i].feature.properties.id]);
                }

                markersInViewPort[i].show = false;
                markersInViewPort[i].element._element.style.display = 'none';
              }
            } // Check if show only one cluster


            const clustersDataLength = clustersData.length;
            const clustersLength = clusters.length;
            let onlyOneClusterFlag = false;

            if (!onlyOneClusterFlag) {
              const currentClustersIds = [];

              for (let j = 0; j < clustersData.length; j++) {
                currentClustersIds.push(clustersData[j].id);
              }

              if (clusters.length !== 0) {
                const clustersIdsRemoved = [];

                for (let i = 0; i < clusters.length; i++) {
                  if (!currentClustersIds.includes(clusters[i].feature.id)) {
                    clusters[i].feature = {};
                    clusters[i].element.remove();
                    clusters[i].show = false;
                    clustersIdsRemoved.push(i);
                  }
                } //for (let i = 0; i < clustersData.length; i++) {
                //    for (let j = 0; j < clusters.length; j++) {
                //      const counterCluster = parseInt(clusters[i].element.getElement().getElementsByClassName('marker__center')[0].textContent);
                //      clustersData[i].properties.point_count
                //    }
                //}


                const indexSet = new Set(clustersIdsRemoved);
                clusters = clusters.filter((value, i) => !indexSet.has(i));
              } // Create and show clusters


              for (let i = 0; i < clustersData.length; i++) {
                let skipCluster = false;

                if (clusters.length !== 0) {
                  for (let j = 0; j < clusters.length; j++) {
                    const counterCluster = parseInt(clusters[j].element.getElement().getElementsByClassName('marker__center')[0].textContent); //  &&

                    if (clusters[j].feature.id === clustersData[i].id) {
                      skipCluster = true;

                      if (counterCluster !== clustersData[i].properties.point_count) {
                        clusters[j].element.getElement().getElementsByClassName('marker__center')[0].textContent = clustersData[i].properties.point_count;
                      } // console.log(clusters[j], clustersData[i])

                    }
                  }
                }

                if (skipCluster) continue;
                const props = clustersData[i].properties;
                const coords = clustersData[i].geometry.coordinates;
                let clusterElement = TWER.createNewCluster(props);
                let cluster = {};
                cluster.element = new mapboxgl.Marker(clusterElement).setLngLat(coords).addTo(TWER.map); //console.log(clusterElement, cluster);

                cluster.feature = clustersData[i];
                cluster.show = true;
                clusters.push(cluster);
              }
            }

            TWER.globalClusterStatus = true;
          } else {
            for (let i = 0; i < TWER.markers.length; i++) {
              if (lodash.has(TWER.markers[i], 'insideStoreLocator')) {
                if (TWER.markers[i].insideStoreLocator) {
                  if (TWER.markers[i].show === false) {
                    TWER.markers[i].show = true;
                    TWER.markers[i].element._element.style.display = 'block';
                  }

                  if (TWER.markers[i].mustShowInCluster) {
                    TWER.markers[i].element._element.style.display = 'block';
                  }
                }
              } else {
                if (TWER.markers[i].show === false) {
                  TWER.markers[i].show = true;
                  TWER.markers[i].element._element.style.display = 'block';
                }
              }
            }

            const clustersIdsRemoved1 = [];

            for (let i = 0; i < clusters.length; i++) {
              if (clusters[i].show === true) {
                clusters[i].show = false;
                clusters[i].feature = {};
                clusters[i].element.remove();
                clustersIdsRemoved1.push(i);
              }
            }

            const indexSet1 = new Set(clustersIdsRemoved1);
            clusters = clusters.filter((value, i) => !indexSet1.has(i));
          }
        });
        TWER.map.on('zoom', event => {
          if (typeof event.originalEvent !== 'undefined') {
            TWER.tourInProgress = false;
          }
        }); // Fire events after `zoomend` event

        TWER.map.on('zoomend', function (event) {
          // Check if zoom change after mousewheel or controls buttons
          if (typeof event.originalEvent !== 'undefined') {
            document.querySelectorAll('.js-twer-popup').forEach(element => {
              const match = element.classList.value.match(/twer-popup-id-\d+/gm);

              if (match[0]) {
                const $marker = document.getElementById(match[0]);

                if (!!!$marker) {
                  TWER.closePopups();
                }
              }
            });
          }
        });
      } // Set start template for Store Locator Marker


      if (TWER.data.storeLocatorMarkerTemplate) {
        this.setMarkerStyle(TWER.data.storeLocatorMarkerTemplate);
      } // Add Store Locator Marker after map load


      if (TWER.data.storeLocatorMarker) {
        let coords = TWER.data.center;
        this.addMarker(this.markerLocationProps, coords);
      }
    });
  },
  addMarker: function (props, coords) {
    const markerElement = this.createNewMarker1(props, coords, '');
    this.markerLocation = new mapboxgl.Marker(markerElement).setLngLat(coords).addTo(TWER.map);
  },
  setMarkerStyle: function (props) {
    this.markerLocationProps = { ...this.markerLocationProps,
      ...JSON.parse(props)
    };
  },
  removeMarker: function () {
    this.markerLocation.remove();
  },
  isMarker: function (target) {
    var _target$closest;

    let isMarker = false;

    if (target.classList.contains('js-twer-marker') || target.classList.contains('treweler-marker') || (_target$closest = target.closest('.js-twer-marker')) !== null && _target$closest !== void 0 && _target$closest.classList.contains('js-twer-marker')) {
      isMarker = true;
    }

    return isMarker;
  },
  isCluster: function (target) {
    var _target$closest2;

    let isCluster = false;

    if (target.classList.contains('marker__center') || target.classList.contains('marker__border') || (_target$closest2 = target.closest('.mapboxgl-marker')) !== null && _target$closest2 !== void 0 && _target$closest2.classList.contains('treweler-cluster')) {
      isCluster = true;
    }

    return isCluster;
  },
  onClickMap: function () {
    TWER.map.on('click', event => {
      if (event.originalEvent.target.classList.contains('mapboxgl-canvas')) {
        TWER.closePopups();
      }

      if (TWER.data.storeLocatorMarker && !this.isMarker(event.originalEvent.target) && !this.isCluster(event.originalEvent.target)) {
        this.removeMarker();
        this.addMarker(this.markerLocationProps, event.lngLat.wrap());
      } // Exist from tour if click on map


      TWER.tourInProgress = false;

      if (TWER.data.mapCenterOnClick && !this.isMarker(event.originalEvent.target) && !this.isCluster(event.originalEvent.target)) {
        TWER.map.flyTo({
          center: event.lngLat.wrap(),
          essential: true
        });
      }
    });
  },
  onClickMapTour: function () {
    document.getElementById('twer-map').addEventListener('click', event => {
      const $element = event.target;

      if (!!!$element.closest('.js-twer-popup') && !$element.classList.contains('js-twer-marker') && !!!$element.closest('.js-twer-marker')) {
        TWER.closeTourPopup();
      }
    });
  },
  closeTourPopup: function () {
    if (TWER.popups === undefined || TWER.popups.length === 0) return false;
    TWER.popups.forEach((popup, index, arr) => {
      if (popup._container) {
        if (popup._container.classList.contains('twer-popup--AlwaysShow')) return false;
        if (popup._container.classList.contains('twer-popup--show')) return false;
        if (popup._container.classList.contains('twer-popup--OpenDefault') && parseInt(localStorage.getItem('toggleTourNeverRunning')) === 0) return false;
        let $rootElement;

        if (popup._container.classList.contains('js-twer-popup')) {
          $rootElement = popup._container;
        }

        if (!!popup._container.closest('.js-twer-popup')) {
          $rootElement = popup._container.closest('.js-twer-popup');
        }

        $rootElement.classList.remove('twer-popup--TourShow');
        $rootElement.classList.remove('twer-popup--OpenDefault');
        setTimeout(function () {
          popup.remove();
        }, 600); // ori 250

        TWER.popups.splice(index, 1);
      }
    });
    document.querySelectorAll('.js-twer-marker').forEach(element => {
      element.classList.remove('open');
    });
  },
  closePopups: function () {
    let ids = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
    let params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    if (TWER.popups === undefined || TWER.popups.length === 0) return false;
    let exceptIds = [];

    if (params.hasOwnProperty('except')) {
      exceptIds = params.except;
    }

    TWER.popups.forEach((popup, index) => {
      // Check if popup container exist and all it`s good
      if (typeof popup._container !== 'undefined') {
        if (popup._container.classList.contains('twer-popup--AlwaysShow')) return;
        if (popup._container.classList.contains('twer-popup--TourShow')) return;
        const popupId = parseInt(popup.options.metadata.id); // Only close elements by ID else close all popups

        let idsCloseStatus = false;

        if (ids.length !== 0) {
          for (let i = 0; i < ids.length; i++) {
            if (ids[i] !== popupId) {
              idsCloseStatus = true;
            }
          }
        } // Ignore close popups by exceptIds data else close all popups


        let exceptIdsStatus = false;
        exceptIds.forEach(exceptId => {
          if (popup._container.classList.contains(`twer-popup-id-${exceptId}`)) {
            exceptIdsStatus = true;
          }
        });
        if (exceptIdsStatus) return;
        if (idsCloseStatus) return;
        popup.removeClassName('twer-popup--show');
        popup.removeClassName('twer-popup--OpenDefault'); // Set pause before remove popup

        setTimeout(() => {
          popup.remove();
        }, TWER.animationDelayClose);
        TWER.popups[index] = null;
      }
    }); // Remove all null values from array

    TWER.popups = TWER.popups.filter(function (el) {
      return el != null;
    });
    document.querySelectorAll('.js-twer-marker').forEach(element => {
      element.classList.remove('open');
    });
  },
  openPopup: function (event, coords) {
    let params = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    const $element = event.target;
    const $popup = document.getElementsByClassName($element.getAttribute('id'))[0];
    if ($popup !== undefined) return false;
    let togglePopups = true;

    if (params.hasOwnProperty('toggle')) {
      togglePopups = params.toggle;
    }

    if (togglePopups) {
      // Before open popup, close siblings popups
      TWER.closePopups();
      TWER.closeTourPopup();
    }

    if (!$element.classList.contains('open') && ($element.classList.contains('js-twer-marker') || !!$element.closest('.js-twer-marker'))) {
      let $template, $rootElement;
      const range = document.createRange();

      if ($element.classList.contains('js-twer-marker')) {
        $rootElement = $element;
        $template = $rootElement.getElementsByTagName('template')[0];
      }

      if (!!$element.closest('.js-twer-marker')) {
        $rootElement = $element.closest('.js-twer-marker');
        $template = $rootElement.getElementsByTagName('template')[0];
      }

      if (!!$template) {
        const someDiv = document.createElement('DIV');
        const documentFragment = range.createContextualFragment($template.innerHTML);
        someDiv.appendChild(documentFragment);
        const classLists = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.class;
        const id = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.idpopup;
        const borderRadius = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.borderradius;
        const minwidthalternate = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.minwidthalternate;
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-class');
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-idpopup');
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-borderradius');
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-minwidthalternate');
        const templateHtml = someDiv.innerHTML;
        $rootElement.classList.add('open');
        let offsetPopup = 14;

        if ($rootElement.classList.contains('twer-marker-type--balloon-default')) {
          offsetPopup = parseInt($rootElement.getElementsByClassName('marker-svg')[0].dataset.height) + 3;
        }

        if ($rootElement.classList.contains('twer-marker-type--triangle-default')) {
          offsetPopup = parseInt($rootElement.getElementsByClassName('marker-triangle')[0].dataset.height) + 10;
          offsetPopup = parseInt(offsetPopup / 2);
        } // Show popup after marker click


        const popup = new mapboxgl.Popup({
          closeButton: false,
          className: classLists,
          closeOnClick: false,
          focusAfterOpen: false,
          anchor: 'bottom',
          offset: offsetPopup,
          metadata: {
            id: id
          }
        }).setLngLat(coords).setHTML(templateHtml).setMaxWidth('none').addTo(TWER.map);
        popup._content.style.borderRadius = `${borderRadius}px`;

        if (minwidthalternate.length > 0) {
          const currentStyleAttrVal = popup._content.closest('.js-twer-popup').getAttribute('style');

          popup._content.closest('.js-twer-popup').setAttribute('style', `min-width:${minwidthalternate}px !important;${currentStyleAttrVal}`);
        }

        setTimeout(function () {
          popup.addClassName('twer-popup--show');
        }, TWER.animationDelayOpen);
        TWER.popups.push(popup);
      }
    }

    document.activeElement.blur();
    jQuery(window.wp.mediaelement.initialize);
  },
  clustersHandlers: function () {
    TWER.map.on('click', 'clusters', event => {
      TWER.globalClusterStatus = true;
      const features = TWER.map.queryRenderedFeatures(event.point, {
        layers: ['clusters']
      });
      const clusterId = features[0].properties.cluster_id;
      TWER.map.getSource('locations').getClusterExpansionZoom(clusterId, (err, zoom) => {
        if (err) return;
        TWER.map.easeTo({
          center: features[0].geometry.coordinates,
          zoom: zoom + 0.5
        });
      });
    });
    TWER.map.on('mouseenter', 'clusters', () => {
      TWER.map.getCanvas().style.cursor = 'pointer';
    });
    TWER.map.on('mouseleave', 'clusters', () => {
      TWER.map.getCanvas().style.cursor = '';
    });
  },
  hex2rgba: function (hex, opacity) {
    hex = hex.replace('#', '');
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);
    return `rgba(${r},${g},${b},${opacity})`;
  },
  isEmpty: function (obj) {
    for (let prop in obj) {
      if (obj.hasOwnProperty(prop)) {
        return false;
      }
    }

    return JSON.stringify(obj) === JSON.stringify({});
  },
  createNewCluster: function (props) {
    const clusterElement = document.createElement('div');
    clusterElement.innerHTML = `<div class="treweler-marker-cluster"><div class="marker marker--cluster" >
                             <div class="marker-wrap">
                             <div class="marker__shadow" style="border-color:${TWER.hex2rgba(TWER.clusterColor, 0.1)}">
                             <div class="marker__border" style="border-color:${TWER.hex2rgba(TWER.clusterColor, 0.4)}">
                             <div class="marker__center" style="background-color:${TWER.clusterColor};">${props.point_count}</div>
                             </div>
                             </div>
                             </div>
                             </div></div>`;
    clusterElement.classList.add('treweler-cluster');
    clusterElement.classList.add('trew-cluster-id-' + props.cluster_id);
    return clusterElement;
  },
  createNewMarker1: function (props, coords, desc) {
    const markerElement = document.createElement('div');

    if (props.marker_style === 'default') {
      markerElement.innerHTML = `<div class="treweler-marker"><div class="marker">
                 <div class="marker-wrap">
                 <div class="marker__shadow" style="background-color:${TWER.hex2rgba(props.point_halo_color, props.point_halo_opacity)}">
                 <div class="marker__border" style="border-color:${props.point_color};">
                 <div class="marker__center"></div>
                 </div>
                 </div>
                 </div>
                 </div></div>`;
    } else if ('dot-default' === props.marker_style) {
      let iconHtml = '';

      if (props.dot_icon_picker.length > 0 && props.dot_icon_show > 0) {
        iconHtml = `<span class="marker-dot__icon material-icons material-icons--reset" style="color:${props.dot_icon.color};font-size:${props.dot_icon.size}px;">${props.dot_icon_picker}</span>`;
      }

      markerElement.innerHTML = `<div class="treweler-marker" style="width:${props.dot.size}px;height:${props.dot.size}px;border-radius:${props.dot_corner_radius.size}${props.dot_corner_radius.units};border:${props.dot_border.size}px solid ${props.dot_border.color};background-color:${props.dot.color};">${iconHtml}</div>`;
    } else if ('triangle-default' === props.marker_style) {
      const styleTriangle = `
                        border-right-width:${props.triangle_width / 2}px;
                        border-left-width:${props.triangle_width / 2}px;
                        border-bottom-width: ${props.triangle_height}px;
                        border-bottom-color: ${props.triangle_color};
                        `;
      markerElement.innerHTML = `<div data-height="${props.triangle_height}" class="treweler-marker marker-triangle" style="${styleTriangle}"></div>`;
    } else if ('balloon-default' === props.marker_style) {
      const realMarkerSizeBalloon = props.balloon.size + (props.balloon_border.size + props.balloon_border.size);
      const x = (realMarkerSizeBalloon + realMarkerSizeBalloon - Math.sqrt(Math.pow(realMarkerSizeBalloon, 2) + Math.pow(realMarkerSizeBalloon, 2))) * (Math.sqrt(2) - 1) / 2;
      let styleBalloon = `
                        background-color: ${props.balloon.color};    
                        border: ${props.balloon_border.size}px solid ${props.balloon_border.color};
                        bottom:${x + x}px;                        
                        width: ${props.balloon.size}px;
                        height: ${props.balloon.size}px;`;
      let styleBalloonDot = `
                        width:${props.balloon_dot.size}px;
                        height:${props.balloon_dot.size}px;
                        margin-left:${props.balloon_dot.size / 2 * -1}px;
                        margin-top:${props.balloon_dot.size / 2 * -1}px;
                        background-color:${props.balloon_dot.color};
                        `;
      let iconHtml = '';

      if (props.balloon_icon_picker.length > 0 && props.balloon_icon_show > 0) {
        iconHtml = `<span class="marker-balloon__icon material-icons material-icons--reset" style="color:${props.balloon_icon.color};font-size:${props.balloon_icon.size}px;">${props.balloon_icon_picker}</span>`;
      }

      markerElement.innerHTML = `<div data-width="${props.balloon.size}" data-height="${realMarkerSizeBalloon + x + x}" class="treweler-marker marker-svg"><div class="marker-balloon" style="${styleBalloon}"><div class="marker-balloon__dot" style="${styleBalloonDot}">${iconHtml}</div></div></div>`;
      props.anchor = 'bottom';
    } else if ('custom' === props.marker_style) {
      const size = props.custom_marker_size_default !== '' ? props.custom_marker_size_default.split(';') : '42;42'.split(';');
      markerElement.className = 'treweler-marker icon';
      markerElement.style.backgroundImage = `url('${props.custom_marker_img}')`;
      markerElement.style.backgroundSize = 'contain';
      markerElement.style.backgroundRepeat = 'no-repeat';
      markerElement.style.backgroundPosition = 'center center';
      const width = parseInt(size[1]) <= 42 ? parseInt(size[1]) % 2 === 0 ? parseInt(size[1]) : parseInt(size[1]) + 1 : 42;
      const height = parseInt(size[0]) <= 42 ? parseInt(size[0]) % 2 === 0 ? parseInt(size[0]) : parseInt(size[0]) + 1 : 42;
      const finalWidth = parseInt(props.custom_marker_size) > 1 ? parseInt(props.custom_marker_size) : width;
      const finalHeight = parseInt(props.custom_marker_size) > 1 ? parseInt(props.custom_marker_size) : height;
      markerElement.style.width = `${finalWidth}px`;
      markerElement.style.height = `${finalHeight}px`;
      props.anchor = props.custom_marker_position;
    } else {
      markerElement.innerHTML = `<div class="treweler-marker"><div class="marker">
                 <div class="marker-wrap">
                 <div class="marker__shadow" style="background-color:${TWER.hex2rgba(props.point_halo_color, props.point_halo_opacity)}">
                 <div class="marker__border" style="border-color:${props.point_color};">
                 <div class="marker__center"></div>
                 </div>
                 </div>
                 </div>
                 </div></div>`;
      props.anchor = 'center';
    }

    markerElement.classList.add(`js-twer-marker`);
    markerElement.setAttribute('id', `twer-popup-id-${props.id}`); // Add marker style class

    markerElement.classList.add(`twer-cursor-${props.cursor}`); // Add type of marker

    markerElement.classList.add(`twer-marker-type--${props.marker_style}`);
    return {
      element: markerElement,
      anchor: props.anchor
    };
  },
  createNewMarker: function (props, coords, desc) {
    let showPopup = true;

    if (props.hasOwnProperty('showPopup')) {
      showPopup = props.showPopup;
    }

    const markerElement = document.createElement('div');
    let tourIndexNumberHTML = ``;

    if (props.tourIndexNumber !== '') {
      const styles = [];
      const tourNumberFontColor = TWER.data.tourNumberSettings.fontColor;
      const tourNumberFontSize = TWER.data.tourNumberSettings.fontSize;
      const tourNumberFontWeight = TWER.data.tourNumberSettings.fontWeight;
      const tourNumberOffsetTop = TWER.data.tourNumberSettings.offset.top;
      const tourNumberOffsetBottom = TWER.data.tourNumberSettings.offset.bottom;
      const tourNumberOffsetLeft = TWER.data.tourNumberSettings.offset.left;
      const tourNumberOffsetRight = TWER.data.tourNumberSettings.offset.right;
      styles.push(`color:${tourNumberFontColor};`);
      styles.push(`font-size:${tourNumberFontSize}px;`);
      styles.push(`font-weight:${tourNumberFontWeight};`);
      styles.push(`padding-top:${tourNumberOffsetTop}px;`);
      styles.push(`padding-bottom:${tourNumberOffsetBottom}px;`);
      styles.push(`padding-left:${tourNumberOffsetLeft}px;`);
      styles.push(`padding-right:${tourNumberOffsetRight}px;`);
      tourIndexNumberHTML = `<div class="twer-tour-index-number" style="${styles.join('')}">${props.tourIndexNumber}</div>`;
    }

    if (props.icon === '' || props.icon === undefined) {
      if (props.type === 'default') {
        markerElement.innerHTML = `${tourIndexNumberHTML}<div class="treweler-marker"><div class="marker">
                 <div class="marker-wrap">
                 <div class="marker__shadow" style="background-color:${TWER.hex2rgba(props.halo_color, props.halo_opacity)}">
                 <div class="marker__border" style="border-color:${props.color};">
                 <div class="marker__center"></div>
                 </div>
                 </div>
                 </div>
                 </div></div>`;
      } else if ('dot-default' === props.type) {
        let iconHtml = '';

        if (props.dot_icon.length > 0 && props.dot_icon_show > 0) {
          iconHtml = `<span class="marker-dot__icon material-icons material-icons--reset" style="color:${props.dot_icon_color};font-size:${props.dot_icon_size}px;">${props.dot_icon}</span>`;
        }

        markerElement.innerHTML = `${tourIndexNumberHTML}<div class="treweler-marker" style="width:${props.inner_size}px;height:${props.inner_size}px;border-radius:${props.corner_radius}${props.corner_radius_units};border:${props.border_width}px solid ${props.border_color};background-color:${props.dotcenter_color};">${iconHtml}</div>`;
      } else if ('triangle-default' === props.type) {
        const styleTriangle = `
                        border-right-width:${props.width_triangle / 2}px;
                        border-left-width:${props.width_triangle / 2}px;
                        border-bottom-width: ${props.height_triangle}px;
                        border-bottom-color: ${props.color_triangle};
                        `;
        markerElement.innerHTML = `${tourIndexNumberHTML}<div data-height="${props.height_triangle}" class="treweler-marker marker-triangle" style="${styleTriangle}"></div>`;
      } else if ('balloon-default' === props.type) {
        const realMarkerSizeBalloon = props.size_balloon + (props.border_width_balloon + props.border_width_balloon);
        const x = (realMarkerSizeBalloon + realMarkerSizeBalloon - Math.sqrt(Math.pow(realMarkerSizeBalloon, 2) + Math.pow(realMarkerSizeBalloon, 2))) * (Math.sqrt(2) - 1) / 2;
        let styleBalloon = `
                        background-color: ${props.color_balloon};    
                        border: ${props.border_width_balloon}px solid ${props.border_color_balloon};
                        bottom:${x + x}px;                        
                        width: ${props.size_balloon}px;
                        height: ${props.size_balloon}px;`;
        let styleBalloonDot = `
                        width:${props.dot_size}px;
                        height:${props.dot_size}px;
                        margin-left:${props.dot_size / 2 * -1}px;
                        margin-top:${props.dot_size / 2 * -1}px;
                        background-color:${props.dot_color};
                        `;
        let iconHtml = '';

        if (props.balloon_icon.length > 0 && props.balloon_icon_show > 0) {
          iconHtml = `<span class="marker-balloon__icon material-icons material-icons--reset" style="color:${props.balloon_icon_color};font-size:${props.balloon_icon_size}px;">${props.balloon_icon}</span>`;
        }

        markerElement.innerHTML = `${tourIndexNumberHTML}<div data-width="${props.size_balloon}" data-height="${realMarkerSizeBalloon + x + x}" class="treweler-marker marker-svg"><div class="marker-balloon" style="${styleBalloon}"><div class="marker-balloon__dot" style="${styleBalloonDot}">${iconHtml}</div></div></div>`;
        props.anchor = 'bottom';
      } else {
        if (props.type !== 'custom') {
          const haloColor = props.halo_color;
          const haloOpacity = props.halo_opacity;
          const borderColor = props.color;
          markerElement.innerHTML = `${tourIndexNumberHTML}<div class="treweler-marker"><div class="marker">
                 <div class="marker-wrap">
                 <div class="marker__shadow" ${haloColor && haloOpacity ? 'style="background-color:' + TWER.hex2rgba(haloColor, haloOpacity) + '"' : ''}>
                 <div class="marker__border" ${borderColor ? 'style="border-color:' + borderColor + '"' : ''}>
                 <div class="marker__center"></div>
                 </div>
                 </div>
                 </div>
                 </div></div>`;
          props.anchor = 'center';
        }
      }
    } else {
      const size = props.size !== '' ? props.size.split(';') : '42;42'.split(';');
      markerElement.className = 'treweler-marker icon';
      markerElement.style.backgroundImage = `url('${props.icon}')`;
      markerElement.style.backgroundSize = 'contain';
      markerElement.style.backgroundRepeat = 'no-repeat';
      markerElement.style.backgroundPosition = 'center center';
      const width = parseInt(size[1]) <= 42 ? parseInt(size[1]) % 2 === 0 ? parseInt(size[1]) : parseInt(size[1]) + 1 : 42;
      const height = parseInt(size[0]) <= 42 ? parseInt(size[0]) % 2 === 0 ? parseInt(size[0]) : parseInt(size[0]) + 1 : 42;
      const finalWidth = parseInt(props.markerSize) > 1 ? parseInt(props.markerSize) : width;
      const finalHeight = parseInt(props.markerSize) > 1 ? parseInt(props.markerSize) : height;
      markerElement.style.width = `${finalWidth}px`;
      markerElement.style.height = `${finalHeight}px`;
      markerElement.innerHTML = `${tourIndexNumberHTML}`;
    }

    markerElement.classList.add(`js-twer-marker`);
    markerElement.setAttribute('id', `twer-popup-id-${props.id}`); // Category Handler

    if (typeof props.category !== 'undefined') {
      markerElement.classList.add(...props.category.split(' '));
    } // Add marker style class


    markerElement.classList.add(`twer-cursor-${props.cursor}`); // Add type of marker

    markerElement.classList.add(`twer-marker-type--${props.type}`); // If description exist - add template popup to marker

    if (desc) {
      const $template = document.createElement('template');
      $template.innerHTML = desc;

      if (!!markerElement.getElementsByTagName('template')) {
        markerElement.appendChild($template);
      } // Add popup handlers if marker template / description JSON exist


      if ('hover' === props.openby) {
        markerElement.onmouseenter = event => {
          this.openPopup(event, coords);
        };

        if (props.openDefault && showPopup) {
          this.staticPopUp(markerElement, coords, 3);
        }
      } else if ('click' === props.openby) {
        markerElement.onclick = event => {
          this.openPopup(event, coords);
        };

        if (props.openDefault && showPopup) {
          this.staticPopUp(markerElement, coords, 3);
        }
      } else if ('always_open' === props.openby) {
        this.staticPopUp(markerElement, coords, 1);
      }
    } // Hide marker


    if (props.markerHide) {
      let $rootMarker = [undefined];

      if (markerElement.classList.contains('twer-marker-type--dot-default')) {
        $rootMarker = markerElement.getElementsByClassName('treweler-marker');
      } else if (markerElement.classList.contains('twer-marker-type--default')) {
        $rootMarker = markerElement.getElementsByClassName('marker');
      } else if (markerElement.classList.contains('twer-marker-type--balloon-default')) {
        $rootMarker = markerElement.getElementsByClassName('treweler-marker');
      } else if (markerElement.classList.contains('twer-marker-type--triangle-default')) {
        $rootMarker = markerElement.getElementsByClassName('treweler-marker marker-triangle');
      } else if (markerElement.classList.contains('twer-marker-type--custom')) {
        markerElement.style.backgroundImage = 'none';
      }

      if (typeof $rootMarker[0] !== 'undefined') {
        $rootMarker[0].style.visibility = 'hidden';
        $rootMarker[0].style.opacity = 0;
        $rootMarker[0].style.overflow = 'hidden';
        $rootMarker[0].style.height = 0;
        $rootMarker[0].style.width = 0;
      }
    } // Show marker labels


    if (props.markerLabelEnable) {
      const labelParams = props.label;
      const desc = labelParams.description.toString();

      if (!lodash.isEmpty(desc)) {
        const $templateLabel = document.getElementById('js-twer-marker-label');
        markerElement.appendChild(document.importNode($templateLabel.content, true));
        const $label = markerElement.getElementsByClassName('twer-marker-label')[0];
        $label.classList.add(`twer-marker-label--${labelParams.position}`);
        $label.innerHTML = desc.trim();
        $label.style.color = labelParams.font_color;
        $label.style.fontSize = `${labelParams.font_size}px`;
        $label.style.fontWeight = labelParams.font_weight;
        $label.style.letterSpacing = `${labelParams.letter_spacing}px`;
        $label.style.lineHeight = labelParams.line_height;

        if (labelParams.label_has_bg) {
          $label.classList.add(`twer-marker-label--has-bg`);
          $label.style.borderRadius = `${labelParams.label_border_radius}px`;
          $label.style.paddingTop = `${labelParams.label_padding.top}px`;
          $label.style.paddingBottom = `${labelParams.label_padding.bottom}px`;
          $label.style.paddingLeft = `${labelParams.label_padding.left}px`;
          $label.style.paddingRight = `${labelParams.label_padding.right}px`;
        }
      }
    }

    return {
      element: markerElement,
      anchor: props.anchor
    };
  },
  __afterCreateNewMarker: (marker, props, coords) => {
    if (props.markerLabelEnable && props.label.description) {
      let lineHeightDiff = 0; // Block size error due to text line-height.

      const labelParams = props.label;
      const $label = marker.element.getElementsByClassName('twer-marker-label')[0];
      const $markerInner = marker.element.getElementsByClassName('marker');
      const $markerInnerSvg = marker.element.getElementsByClassName('marker-svg');
      let $rootMarker = [undefined];
      let sizeMarker = [30, 30];
      let sizeLabel = [103, 88];

      if ($markerInner.length > 0) {
        $rootMarker = $markerInner;
      } else if ($markerInnerSvg.length > 0) {
        $rootMarker = $markerInnerSvg;
      } else {
        $rootMarker = [marker.element];
      }

      if (typeof $rootMarker[0] !== 'undefined') {
        sizeMarker[0] = $rootMarker[0].getBoundingClientRect().width;
        sizeMarker[1] = $rootMarker[0].getBoundingClientRect().height;

        if ($rootMarker[0].classList.contains('marker-svg')) {
          const bottomValue = parseInt($rootMarker[0].getElementsByClassName('marker-balloon')[0].style.bottom);
          sizeMarker[1] = sizeMarker[1] + bottomValue;
          $rootMarker[0].getElementsByClassName('marker-balloon')[0].style.bottom = 0;
        }

        $rootMarker[0].style.left = '0px';
        $rootMarker[0].style.top = '0px';
        $rootMarker[0].closest('.js-twer-marker, .treweler-marker').style.width = `${sizeMarker[0]}px`;
        $rootMarker[0].closest('.js-twer-marker, .treweler-marker').style.height = `${sizeMarker[1]}px`;
      }

      sizeLabel[0] = $label.getBoundingClientRect().width - lineHeightDiff;
      sizeLabel[1] = $label.getBoundingClientRect().height - lineHeightDiff;

      if (labelParams.position === 'top' || labelParams.position === 'bottom') {
        sizeMarker[0] = sizeMarker[0] - 1;
        sizeMarker[1] = sizeMarker[1] - 1;
      }

      if (labelParams.position === 'bottom_right' || labelParams.position === 'bottom_left' || labelParams.position === 'top_right' || labelParams.position === 'top_left') {
        if (sizeMarker[0] === 30) {
          sizeMarker[0] -= 7;
        }

        if (sizeMarker[1] === 30) {
          sizeMarker[1] -= 7;
        }
      }

      let offset = labelParams.margin - lineHeightDiff;

      switch (labelParams.position) {
        case 'left':
        case 'right':
          $label.style.marginTop = `-${sizeLabel[1] / 2}px`;
          break;

        case 'top':
        case 'bottom':
          $label.style.marginLeft = `-${sizeLabel[0] / 2}px`;
          break;

        case 'center':
          $label.style.marginLeft = `-${sizeLabel[0] / 2}px`;
          $label.style.marginTop = `-${sizeLabel[1] / 2}px`;
          break;
      }

      switch (labelParams.position) {
        case 'right':
          $label.style.left = `${offset + sizeMarker[0]}px`;
          break;

        case 'bottom_right':
          $label.style.left = `${offset + sizeMarker[0]}px`;
          $label.style.top = `${offset + sizeMarker[1]}px`;
          break;

        case 'top_right':
          $label.style.left = `${offset + sizeMarker[0]}px`;
          $label.style.bottom = `${offset + sizeMarker[1]}px`;
          break;

        case 'left':
          $label.style.right = `${offset + sizeMarker[0]}px`;
          break;

        case 'bottom_left':
          $label.style.right = `${offset + sizeMarker[0]}px`;
          $label.style.top = `${offset + sizeMarker[1]}px`;
          break;

        case 'top_left':
          $label.style.right = `${offset + sizeMarker[0]}px`;
          $label.style.bottom = `${offset + sizeMarker[1]}px`;
          break;

        case 'top':
          $label.style.bottom = `${offset + sizeMarker[1]}px`;
          break;

        case 'bottom':
          $label.style.top = `${offset + sizeMarker[1]}px`;
          break;
      }
    }

    if (props.allowMarkerCenterOnClick) {
      marker.element.addEventListener('click', event => {
        event.preventDefault();
        TWER.map.flyTo({
          center: coords,
          padding: {
            top: props.markerClickOffset.top,
            bottom: props.markerClickOffset.bottom,
            left: props.markerClickOffset.left,
            right: props.markerClickOffset.right
          }
        });
      });
    }

    if (props.markerLink.enable) {
      marker.element.addEventListener('click', event => {
        event.preventDefault();
        let target = props.markerLink.openInNewWindow ? '_blank' : '_self';

        if (TWER.isIframeMap() && !props.markerLink.openInNewWindow) {
          target = '_parent';
        }

        window.open(props.markerLink.url, target);
      });
    }
  },
  isIframeMap: function () {
    return document.body.classList.contains('twer-page-iframe-map');
  },
  staticPopUp: function (element, coords, showForever, idPop) {
    const $element = element;
    const $popup = document.getElementsByClassName($element.getAttribute('id'))[0];
    if ($popup !== undefined) return false;

    if (!$element.classList.contains('open') && ($element.classList.contains('js-twer-marker') || !!$element.closest('.js-twer-marker'))) {
      let $template, $rootElement;
      const range = document.createRange();

      if ($element.classList.contains('js-twer-marker')) {
        $rootElement = $element;
        $template = $rootElement.getElementsByTagName('template')[0];
      }

      if (!!$element.closest('.js-twer-marker')) {
        $rootElement = $element.closest('.js-twer-marker');
        $template = $rootElement.getElementsByTagName('template')[0];
      }

      if (!!$template) {
        const someDiv = document.createElement('DIV');
        const documentFragment = range.createContextualFragment($template.innerHTML);
        someDiv.appendChild(documentFragment);
        const classLists = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.class;
        const id = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.idpopup;
        const borderRadius = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.borderradius;
        const minwidthalternate = someDiv.getElementsByClassName('js-twer-popup__wrap')[0].dataset.minwidthalternate;
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-class');
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-idpopup');
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-borderradius');
        someDiv.getElementsByClassName('js-twer-popup__wrap')[0].removeAttribute('data-minwidthalternate');
        const templateHtml = someDiv.innerHTML;
        $rootElement.classList.add('open');
        let offsetPopup = 14;

        if ($rootElement.classList.contains('twer-marker-type--balloon-default')) {
          offsetPopup = parseInt($rootElement.getElementsByClassName('marker-svg')[0].dataset.height) + 3;
        }

        if ($rootElement.classList.contains('twer-marker-type--triangle-default')) {
          offsetPopup = parseInt($rootElement.getElementsByClassName('marker-triangle')[0].dataset.height) + 10;
          offsetPopup = parseInt(offsetPopup / 2);
        } // Show popup after marker click


        const popup = new mapboxgl.Popup({
          className: classLists,
          closeButton: false,
          closeOnClick: false,
          anchor: 'bottom',
          focusAfterOpen: false,
          offset: offsetPopup,
          metadata: {
            id: id
          }
        }).setLngLat(coords).setHTML(templateHtml).setMaxWidth('none').addTo(TWER.map);
        popup._content.style.borderRadius = `${borderRadius}px`;

        if (minwidthalternate.length > 0) {
          const currentStyleAttrVal = popup._content.closest('.js-twer-popup').getAttribute('style');

          popup._content.closest('.js-twer-popup').setAttribute('style', `min-width:${minwidthalternate}px !important;${currentStyleAttrVal}`);
        }

        if (showForever === 1) {
          setTimeout(function () {
            popup.addClassName('twer-popup--AlwaysShow');
          }, 110);
        } else if (showForever === 2) {
          popup.addClassName('twer-popup--TourShow');
        } else if (showForever === 3) {
          setTimeout(function () {
            popup.addClassName('twer-popup--OpenDefault');
          }, 110);
        } else {
          popup.addClassName('twer-popup--show');
        }

        TWER.popups.push(popup);
      }
    }

    document.activeElement.blur();
  }
};
}();
/******/ })()
;