/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

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
/*!*********************************************!*\
  !*** ./src/js/front/treweler-boundaries.js ***!
  \*********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _modules_preloader__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/preloader */ "./src/js/front/modules/preloader.js");




/**
 * Init All Boundaries Front End
 */

class TWER_BOUNDARIES {
  /**
   * Сonstructor
   *
   * @param props
   */
  constructor(props) {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "regions", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "regionsSelected", []);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "fillMain", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "fillHover", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "fillSelected", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "strokeColor", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "strokeWidth", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "regionsCustomColors", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "regionsHide", '');

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "worldsSlugs", ['world', 'united-states', 'united-kingdom', 'spain', 'italy', 'germany', 'france', 'canada', 'australia']);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "accuracyList", ['very_high', 'high', 'medium', 'low', 'very_low']);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "worldsGeoJson", {});

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "worldsList", {});

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$popup", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "preloader", null);

    this.regions = TWER.data.boundariesRegions;
    this.regionsSelected = TWER.data.boundariesRegionsSelected;
    this.fillMain = TWER.data.boundariesFillMain;
    this.fillHover = TWER.data.boundariesFillHover;
    this.fillSelected = TWER.data.boundariesFillSelected;
    this.strokeColor = TWER.data.boundariesStrokeColor;
    this.strokeWidth = TWER.data.boundariesStrokeWidth;
    this.boundariesAccuracy = TWER.data.boundariesAccuracy;
    this.regionsCustomColors = TWER.data.boundariesRegionsCustomColors;
    this.regionsHide = TWER.data.boundariesRegionsHide;
    this.regionsClickable = TWER.data.actionOnClickBoundaries;
    this.regionsLinks = TWER.data.boundariesLinks;
    this.regionsHoverables = TWER.data.actionOnHoverBoundaries;
    this.regionsValues = TWER.data.boundariesValues;
    this.regionsValuesPrefix = TWER.data.boundariesValuesPrefix;
    this.preloader = new _modules_preloader__WEBPACK_IMPORTED_MODULE_1__["default"]();
    this.preloader.initPreloader();
    this.worldListFill();

    if ('none' !== this.regionsHoverables) {
      this.initPopup();
    }

    let hoveredStateId = null;
    TWER.map.on('load', async () => {
      const fileName = this.getFileNameFromRegion(); //console.log(treweler_params.data, this.worldsList, this.boundariesAccuracy)

      this.fetchData().then(geoJSON => {
        this.worldsGeoJson = this.prepareGeoJson(geoJSON);
        const layer = {
          'id': 'boundaries-layer',
          'type': 'fill',
          'source': 'boundaries',
          'paint': {
            'fill-color': this.generateFeatureStateFilter(),
            'fill-outline-color': 'rgba(255, 255, 255, 0)'
          }
        };
        const layerLine = {
          'id': 'boundaries-line-layer',
          'type': 'line',
          'source': 'boundaries',
          'paint': {
            'line-width': this.strokeWidth,
            'line-color': this.strokeColor
          }
        };
        const filter = ['all'];

        if (this.regions !== 'world') {
          const regions = this.prepare_regions();
          filter.push(['==', ['get', regions.column], regions.value]);

          if (regions.admin !== '') {
            filter.push(['==', ['get', regions.admin], regions.admin_num]);
          }
        } else {
          //filter.push(['!=', 'mode', 'static']);
          filter.push(['!=', ['get', 'COUNTRY'], 'France']);
          filter.push(['!=', ['get', 'COUNTRY'], 'United States']);
          filter.push(['!=', ['get', 'COUNTRY'], 'United Kingdom']);
          filter.push(['!=', ['get', 'COUNTRY'], 'Spain']);
          filter.push(['!=', ['get', 'COUNTRY'], 'Italy']);
          filter.push(['!=', ['get', 'COUNTRY'], 'Germany']);
          filter.push(['!=', ['get', 'COUNTRY'], 'Canada']);
          filter.push(['!=', ['get', 'COUNTRY'], 'Australia']);
        }

        if (this.regionsHide !== '' && this.regionsHide.length > 0) {
          const regionsHide = JSON.parse(this.regionsHide);

          for (let i = 0; i < regionsHide.length; i++) {
            filter.push(['!=', ['id'], parseInt(regionsHide[i])]);
          }
        }

        layer.filter = filter;
        layerLine.filter = filter; // Add a source for the state polygons.

        TWER.map.addSource('boundaries', {
          type: 'geojson',
          //generateId: true,
          data: this.worldsGeoJson[this.boundariesAccuracy]
        }); // Add a layer showing the state polygons.

        TWER.map.addLayer(layer);
        TWER.map.addLayer(layerLine);
        this.selectRegions();
        TWER.map.on('mouseenter', 'boundaries-layer', () => {
          TWER.map.getCanvas().style.cursor = 'pointer';
        });
        TWER.map.on('mousemove', 'boundaries-layer', event => {
          if (event.features.length > 0 && this.isClosestHoverable(event)) {
            if (hoveredStateId !== null) {
              this.fillRegionColor(hoveredStateId, {
                action: 'unhover'
              });
            }

            hoveredStateId = event.features[0].id;
            this.fillRegionColor(hoveredStateId, {
              action: 'hover'
            });
            this.selectRegions(hoveredStateId);
            this.popup(event);
          }
        });
        TWER.map.on('mouseleave', 'boundaries-layer', e => {
          if (hoveredStateId !== null) {
            TWER.map.setFeatureState({
              source: 'boundaries',
              id: hoveredStateId
            }, {
              action: 'unhover'
            });
          }

          hoveredStateId = null;
          this.selectRegions(hoveredStateId);
          this.popup();
          TWER.map.getCanvas().style.cursor = '';
        });
        TWER.map.on('click', 'boundaries-layer', e => {
          if (e.features.length > 0) {
            const id = e.features[0].id;

            if ('none' !== this.regionsClickable && this.regionsLinks.length > 0) {
              const regionsLinks = JSON.parse(this.regionsLinks);

              for (let i = 0; i < regionsLinks.length; i++) {
                if (regionsLinks[i].id === id) {
                  if (document.body.classList.contains('twer-page-iframe-map')) {
                    window.open(regionsLinks[i].url, '_blank');
                  } else {
                    if (regionsLinks[i].target) {
                      window.open(regionsLinks[i].url, regionsLinks[i].target);
                    } else {
                      window.location.href = regionsLinks[i].url;
                    }
                  }
                }
              }
            }
          }
        });
        TWER.map.once('idle', e => {
          this.preloader.hide();
        });
        const allLayers = TWER.map.getStyle().layers;

        if (allLayers.length > 0) {
          for (let i = 0; i < allLayers.length; i++) {
            const layerId = allLayers[i].id;

            if (layerId.includes('route-') || layerId === 'line_layer' || layerId === 'polygon_layer_fill' || layerId === 'polygon_layer_stroke') {
              TWER.map.moveLayer(layerId);
            }
          }
        }
      }).catch(error => {
        console.log(error);
      });
    });
  }

  prepareGeoJson(geoJSON) {
    for (let quality in geoJSON) {
      if (geoJSON[quality].features.length > 0) {
        let geoId = 1;

        for (let u = 0; u < geoJSON[quality].features.length; u++) {
          geoJSON[quality].features[u].id = geoId;
          geoId++;
        }
      }
    }

    return geoJSON;
  }

  worldListFill() {
    for (let j = 0; j < this.accuracyList.length; j++) {
      const accuracyKey = this.accuracyList[j];
      const accuracy = accuracyKey.replace(/_/g, '-');
      this.worldsList[accuracyKey] = {
        urls: []
      };

      for (let i = 0; i < this.worldsSlugs.length; i++) {
        const slug = this.worldsSlugs[i];

        if (slug === 'world') {
          this.worldsList[accuracyKey].urls.push(`${slug}-${accuracy}.json`);
        } else {
          this.worldsList[accuracyKey].urls.push(`${slug}-${accuracy}-01.json`, `${slug}-${accuracy}-02.json`);
        }
      }
    }
  }

  async fetchData() {
    const geoJsonData = {};

    for (let q = 0; q < this.accuracyList.length; q++) {
      const quality = this.accuracyList[q];
      let sourceGeoJsonResult = await Promise.all(this.worldsList[quality].urls.map(urlJson => fetch(`${treweler_params.data}${urlJson}`).then(resp => resp.json())));
      geoJsonData[quality] = {
        type: '',
        features: []
      };

      if (sourceGeoJsonResult.length > 0) {
        for (let i = 0; i < sourceGeoJsonResult.length; i++) {
          geoJsonData[quality].type = sourceGeoJsonResult[i].type;
          geoJsonData[quality].features.push(...sourceGeoJsonResult[i].features);
        }
      }
    }

    return geoJsonData;
  }

  initPopup() {
    this.$popup = document.createElement('div');
    this.$popup.classList.add('twer-region-popup');
    const $popupTitle = document.createElement('div');
    $popupTitle.id = 'js-twer-popup-title';
    const $popupValue = document.createElement('div');
    $popupValue.id = 'js-twer-popup-value';
    $popupValue.classList.add('twer-region-popup__value');
    this.$popup.appendChild($popupTitle);
    this.$popup.appendChild($popupValue);
    document.body.appendChild(this.$popup);
  }

  isClosestHoverable(event) {
    var _event$originalEvent;

    let result = true;
    const $targetHover = event === null || event === void 0 ? void 0 : (_event$originalEvent = event.originalEvent) === null || _event$originalEvent === void 0 ? void 0 : _event$originalEvent.target;

    if ($targetHover) {
      if ($targetHover.closest('.treweler-marker-cluster') || $targetHover.closest('.js-twer-marker') || $targetHover.closest('.treweler-marker')) {
        result = false;
      }
    }

    return result;
  }

  popup(event) {
    if ('none' !== this.regionsHoverables) {
      let values = this.regionsValues.trim() === '' ? [] : JSON.parse(this.regionsValues);
      const canvas = TWER.map.getCanvas();

      if (event && typeof event !== 'undefined' && this.isClosestHoverable(event)) {
        const regionId = event.features[0].id;
        const regionName = event.features[0].properties.NAME;
        let resultValue = '';
        let resultPrefix = '';

        if ('popup_value' === this.regionsHoverables) {
          resultPrefix = `${this.regionsValuesPrefix} `;
        }

        if (values.length > 0) {
          for (let i = 0; i < values.length; i++) {
            if (values[i].id === regionId) {
              resultValue = values[i].value;
            }
          }
        }

        canvas.style.cursor = 'pointer';
        this.$popup.querySelector('#js-twer-popup-title').textContent = regionName;

        if (resultValue && 'popup_value' === this.regionsHoverables) {
          this.$popup.querySelector('#js-twer-popup-value').textContent = resultPrefix + resultValue;
        } else {
          this.$popup.querySelector('#js-twer-popup-value').textContent = '';
        }

        const popupStyles = this.$popup.getBoundingClientRect();
        const popupHeight = popupStyles.height;
        const popupWidth = popupStyles.width;
        const $adminBar = document.getElementById('wpadminbar');
        let adminBarHeight = 0;

        if ($adminBar !== null) {
          const adminBarStyles = $adminBar.getBoundingClientRect();
          adminBarHeight = adminBarStyles.height;
        }

        this.$popup.style.left = `${event.originalEvent.clientX - popupWidth / 2}px`;
        this.$popup.style.top = `${event.originalEvent.clientY - (popupHeight + 8 + adminBarHeight)}px`;
        this.$popup.style.visibility = 'visible';
        this.$popup.style.opacity = 1;
      } else {
        canvas.style.cursor = '';
        this.$popup.style.visibility = 'hidden';
        this.$popup.style.opacity = 0;
        this.$popup.querySelector('#js-twer-popup-title').textContent = '';
        this.$popup.querySelector('#js-twer-popup-value').textContent = '';
      }
    }
  }

  selectRegions() {
    let ignoreId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
    let selectedRegions = this.regionsSelected.trim() === '' ? [] : JSON.parse(this.regionsSelected);

    if (selectedRegions.length > 0 && Array.isArray(selectedRegions)) {
      for (let i = 0; i < selectedRegions.length; i++) {
        if (selectedRegions[i] !== ignoreId) {
          const selectedRegionId = selectedRegions[i];
          const selectedRegionIdChecked = this.checkIdHasCustomColor(selectedRegionId);

          if (selectedRegionIdChecked.hasColor && selectedRegionIdChecked.active) {
            this.fillRegionColor(selectedRegionId, {
              action: 'customize'
            });
          } else {
            this.fillRegionColor(selectedRegionId, {
              action: 'select'
            });
          }
        }
      }
    }
  }

  checkIdHasCustomColor(id) {
    let selectStateIdsColors = this.regionsCustomColors.trim() === '' ? [] : JSON.parse(this.regionsCustomColors);
    let hasColor = false;
    let index = 0;
    let active = false;

    if (selectStateIdsColors.length > 0) {
      for (let i = 0; i < selectStateIdsColors.length; i++) {
        if (id === selectStateIdsColors[i].id) {
          hasColor = true;
          index = i;
          active = selectStateIdsColors[i].active;
          break;
        }
      }
    }

    return {
      hasColor: hasColor,
      index: index,
      active: active
    };
  }

  generateFeatureStateFilter() {
    let settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    let selectStateIdsColors = this.regionsCustomColors.trim() === '' ? [] : JSON.parse(this.regionsCustomColors);
    const filter = ['match', ['feature-state', 'action'], 'hover', this.fillHover, 'select', this.fillSelected, 'unselect', this.fillHover, 'unhover', this.fillMain, this.fillMain];

    if (selectStateIdsColors.length > 0) {
      let spliceCounter = 0;

      for (let i = 0; i < selectStateIdsColors.length; i++) {
        if (selectStateIdsColors[i].active) {
          let splice1 = 2 + spliceCounter;
          let splice2 = 3 + spliceCounter;
          filter.splice(splice1, 0, `customize_${selectStateIdsColors[i].id}`);
          filter.splice(splice2, 0, selectStateIdsColors[i].color);
          spliceCounter = spliceCounter + 2;
        }
      }
    }

    return filter;
  }

  fillRegionColor(featureId) {
    let settings = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    const action = 'action' in settings ? settings.action : false;

    if (action) {
      let stateAction = action;

      switch (action) {
        case 'customize':
          stateAction = `customize_${featureId}`;
          break;
      }

      TWER.map.setFeatureState({
        source: 'boundaries',
        id: featureId
      }, {
        action: stateAction
      });
    }
  }

  getFileNameFromRegion() {
    const accuracy = this.boundariesAccuracy.replace(/_/g, '-');
    let filename = `world-${accuracy}.json`;

    if ('world' !== this.regions) {
      const {
        COUNTRY,
        ADMIN
      } = JSON.parse(this.regions);

      if (COUNTRY && ADMIN) {
        filename = `${COUNTRY.toLowerCase()}-${accuracy}-0${ADMIN}.json`;
      }
    }

    return filename;
  }

  prepare_regions() {
    const preparedCurrentRegion = 'world' === this.regions ? {} : JSON.parse(this.regions);
    const isEmpty = Object.keys(preparedCurrentRegion).length === 0;
    let column = '';
    let column_value = '';
    let admin_column = '';
    let admin_value = -1;

    if (!isEmpty) {
      for (let column_inner in preparedCurrentRegion) {
        if (column_inner === 'ADMIN') {
          admin_column = column_inner;
          admin_value = preparedCurrentRegion[column_inner];
        } else {
          column = column_inner;
          column_value = preparedCurrentRegion[column_inner];
        }
      }
    } else {
      column = 'world';
    }

    return {
      column: column,
      value: column_value,
      admin: admin_column,
      admin_num: parseInt(admin_value)
    };
  }

}

!(() => {
  window.addEventListener('load', () => {
    new TWER_BOUNDARIES();
  });
})();
}();
/******/ })()
;