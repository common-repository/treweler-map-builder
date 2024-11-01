/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

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
  !*** ./src/js/front/treweler-directions.js ***!
  \*********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");




class TrewelerDirections {
  getInitialMarkerType() {
    return TWER.data.directions.startDirectionsMarker || 'user-geolocation';
  }

  constructor() {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "startCoordinates", []);

    this.directions = new MapboxDirections({
      accessToken: mapboxgl.accessToken,
      unit: 'metric',
      profile: `mapbox/${TWER.data.directions.profile}`,
      interactive: false,
      controls: false,
      flyTo: true,
      styles: [{
        'id': 'directions-route-line-alt',
        'type': 'line',
        'source': 'directions',
        'layout': {
          'line-cap': 'round',
          'line-join': 'round'
        },
        'paint': {
          'line-color': '#bbb',
          'line-width': 4
        },
        'filter': ['all', ['in', '$type', 'LineString'], ['in', 'route', 'alternate']]
      }, {
        'id': 'directions-route-line-casing',
        'type': 'line',
        'source': 'directions',
        'layout': {
          'line-cap': 'round',
          'line-join': 'round'
        },
        'paint': {
          'line-color': '#2d5f99',
          'line-width': 0
        },
        'filter': ['all', ['in', '$type', 'LineString'], ['in', 'route', 'selected']]
      }, {
        'id': 'directions-route-line',
        'type': 'line',
        'source': 'directions',
        'layout': {
          'line-cap': 'butt',
          'line-join': 'round'
        },
        'paint': {
          'line-color': {
            'property': 'congestion',
            'type': 'categorical',
            'default': '#18af1f',
            'stops': [['unknown', '#18af1f'], ['low', '#18af1f'], ['moderate', '#18af1f'], ['heavy', '#18af1f'], ['severe', '#18af1f']]
          },
          'line-width': 3
        },
        'filter': ['all', ['in', '$type', 'LineString'], ['in', 'route', 'selected']]
      }, {
        'id': 'directions-origin-point',
        'type': 'circle',
        'source': 'directions',
        'paint': {
          'circle-opacity': 0,
          'circle-stroke-opacity': 0
        },
        'filter': ['all', ['in', '$type', 'Point'], ['in', 'marker-symbol', 'A']]
      }, {
        'id': 'directions-origin-label',
        'type': 'symbol',
        'source': 'directions',
        'layout': {
          'text-field': 'A',
          'text-font': ['Open Sans Bold', 'Arial Unicode MS Bold'],
          'text-size': 0
        },
        'paint': {
          'text-color': '#fff'
        },
        'filter': ['all', ['in', '$type', 'Point'], ['in', 'marker-symbol', 'A']]
      }, {
        'id': 'directions-destination-point',
        'type': 'circle',
        'source': 'directions',
        'paint': {
          'circle-opacity': 0,
          'circle-stroke-opacity': 0
        },
        'filter': ['all', ['in', '$type', 'Point'], ['in', 'marker-symbol', 'B']]
      }, {
        'id': 'directions-destination-label',
        'type': 'symbol',
        'source': 'directions',
        'layout': {
          'text-field': 'B',
          'text-font': ['Open Sans Bold', 'Arial Unicode MS Bold'],
          'text-size': 0
        },
        'paint': {
          'text-color': '#fff'
        },
        'filter': ['all', ['in', '$type', 'Point'], ['in', 'marker-symbol', 'B']]
      }]
    });
    this.directions.on('route', e => {
      document.getElementById('js-twer-directions').classList.remove('d-none');
    });
    TWER.map.addControl(this.directions, 'top-left');
    TWER.map.addControl(this.resetIcon(), TWER.data.directions.resetIconPosition);
    TWER.map.on('load', () => {
      switch (this.getInitialMarkerType()) {
        case 'user-geolocation':
          window.TWER_GEOLOCATE.on('geolocate', event => {
            this.setStartCoordinates([event.coords.longitude, event.coords.latitude]);
          });
          break;

        case 'manual-location':
          this.setStartCoordinates(TWER.data.center);
          break;
      }

      if (typeof TWER.storeLocator !== 'undefined') {
        TWER.storeLocator.on('result', e => {
          this.setStartCoordinates(e.result.center);
        });
      }
    });
    TWER.map.on('click', event => {
      let coordinates = event.lngLat.toArray();
      const $target = event.originalEvent.target;
      if (this.isUserLocationMarker($target)) return false;

      if (this.isMarker($target)) {
        for (const feature of TWER.clusterData.features) {
          const $marker = this.getMarkerByTarget($target);
          const $markerId = parseInt($marker.id.replace('twer-popup-id-', ''));

          if ($markerId === feature.properties.id) {
            coordinates = feature.geometry.coordinates;
          }
        }

        this.makeDirection(coordinates);
      } else {
        if (this.getInitialMarkerType() === 'manual-location') {
          this.setStartCoordinates(coordinates);
        }
      }
    });
  }

  removeAllDirections() {
    this.directions.removeRoutes();
    this.setStartCoordinates(this.startCoordinates);
  }

  makeDirection(endCoordinates) {
    if (lodash.isEmpty(this.startCoordinates)) return false;
    this.directions.setOrigin(this.startCoordinates);
    this.directions.setDestination(endCoordinates);
  }

  setStartCoordinates(coordinates) {
    this.startCoordinates = coordinates;

    if (!lodash.isEmpty(this.directions.getDestination())) {
      this.directions.setOrigin(coordinates);
    }
  }

  getMarkerByTarget(target) {
    let $wrap = target.closest('.js-twer-marker');
    return $wrap === null ? target : $wrap;
  }

  isUserLocationMarker(target) {
    var _target$closest;

    let isMarker = false;

    if (target.classList.contains('mapboxgl-user-location') || (_target$closest = target.closest('.mapboxgl-user-location')) !== null && _target$closest !== void 0 && _target$closest.classList.contains('js-twer-marker')) {
      isMarker = true;
    }

    return isMarker;
  }

  isMarker(target) {
    var _target$closest2;

    let isMarker = false;

    if (target.classList.contains('js-twer-marker') || target.classList.contains('treweler-marker') || (_target$closest2 = target.closest('.js-twer-marker')) !== null && _target$closest2 !== void 0 && _target$closest2.classList.contains('js-twer-marker')) {
      isMarker = true;
    }

    return isMarker;
  }

  resetIcon(options) {
    const scope = this;
    return {
      onAdd(map) {
        this._map = map;

        let _this = this;

        this._btn = document.createElement('button');
        this._btn.className = 'btn btn-outline-dark twer-directions__reset-btn d-flex align-items-center justify-content-center';
        this._btn.type = 'button';
        this._btn.innerHTML = `<svg class="twer-svg-icon" width="18" height="17"><use xlink:href="#reset-directions"></use></svg>`;

        this._btn.onclick = e => {
          e.preventDefault();

          if (!lodash.isEmpty(scope.directions.getDestination())) {
            scope.removeAllDirections();
            document.getElementById('js-twer-directions').classList.add('d-none');
          }
        };

        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl-group mapboxgl-ctrl twer-directions d-none';
        this._container.id = 'js-twer-directions';

        this._container.appendChild(this._btn);

        return this._container;
      },

      onRemove() {
        this._container.parentNode.removeChild(this._container);

        this._map = undefined;
      }

    };
  }

}

!(() => {
  window.addEventListener('load', () => {
    new TrewelerDirections();
  });
})();
}();
/******/ })()
;