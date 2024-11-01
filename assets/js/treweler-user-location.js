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
/*!************************************************!*\
  !*** ./src/js/front/treweler-user-location.js ***!
  \************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");



window.TWER_GEOLOCATE = {};

class TrewelerUserLocation {
  constructor() {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "markerLocationProps", {
      id: 0,
      marker_style: 'default',
      point_halo_color: '#fff',
      point_halo_opacity: 0.5,
      point_color: '#4b7715',
      custom_marker_img: '',
      cursor: 'pointer',
      anchor: 'center'
    });

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "geolocateButtonPressed", false);

    this.initGeolocateControl();
    this.hideGeolocateControl();
    this.addGeolocateControlStyle();
    this.setGeolocationMarkerStyle();
    this.detectUserLocation();
  }

  setGeolocationMarkerStyle() {
    const template = this.getUserGeolocationMarkerTemplate();
    TWER.map.on('load', () => {
      if (template === 'default') return false;

      if (template) {
        this.markerLocationProps = { ...this.markerLocationProps,
          ...JSON.parse(template)
        };
        const props = this.markerLocationProps;
        const markerElement = document.createElement('div');

        if (props.marker_style === 'default') {
          window.TWER_GEOLOCATE._userLocationDotMarker._element.innerHTML = `<div class="treweler-marker"><div class="marker">
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
            iconHtml = `<span class="marker-dot__icon material-icons" style="color:${props.dot_icon.color};font-size:${props.dot_icon.size}px;">${props.dot_icon_picker}</span>`;
          }

          window.TWER_GEOLOCATE._userLocationDotMarker._element.innerHTML = `<div class="treweler-marker" style="width:${props.dot.size}px;height:${props.dot.size}px;border-radius:${props.dot_corner_radius.size}${props.dot_corner_radius.units};border:${props.dot_border.size}px solid ${props.dot_border.color};background-color:${props.dot.color};">${iconHtml}</div>`;
        } else if ('triangle-default' === props.marker_style) {
          const styleTriangle = `
                        border-right-width:${props.triangle_width / 2}px;
                        border-left-width:${props.triangle_width / 2}px;
                        border-bottom-width: ${props.triangle_height}px;
                        border-bottom-color: ${props.triangle_color};
                        `;
          window.TWER_GEOLOCATE._userLocationDotMarker._element.innerHTML = `<div data-height="${props.triangle_height}" class="treweler-marker marker-triangle" style="${styleTriangle}"></div>`;
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
            iconHtml = `<span class="marker-balloon__icon material-icons" style="color:${props.balloon_icon.color};font-size:${props.balloon_icon.size}px;">${props.balloon_icon_picker}</span>`;
          }

          window.TWER_GEOLOCATE._userLocationDotMarker._element.innerHTML = `<div data-width="${props.balloon.size}" data-height="${realMarkerSizeBalloon + x + x}" class="treweler-marker marker-svg"><div class="marker-balloon" style="${styleBalloon}"><div class="marker-balloon__dot" style="${styleBalloonDot}">${iconHtml}</div></div></div>`;
          props.anchor = 'bottom';
        } else if ('custom' === props.marker_style) {
          const size = props.custom_marker_size_default !== '' ? props.custom_marker_size_default.split(';') : '42;42'.split(';');

          window.TWER_GEOLOCATE._userLocationDotMarker._element.classList.add('treweler-marker');

          window.TWER_GEOLOCATE._userLocationDotMarker._element.classList.add('icon');

          window.TWER_GEOLOCATE._userLocationDotMarker._element.style.backgroundImage = `url('${props.custom_marker_img}')`;
          window.TWER_GEOLOCATE._userLocationDotMarker._element.style.backgroundSize = 'contain';
          window.TWER_GEOLOCATE._userLocationDotMarker._element.style.backgroundRepeat = 'no-repeat';
          window.TWER_GEOLOCATE._userLocationDotMarker._element.style.backgroundPosition = 'center center';
          const width = parseInt(size[1]) <= 42 ? parseInt(size[1]) % 2 === 0 ? parseInt(size[1]) : parseInt(size[1]) + 1 : 42;
          const height = parseInt(size[0]) <= 42 ? parseInt(size[0]) % 2 === 0 ? parseInt(size[0]) : parseInt(size[0]) + 1 : 42;
          const finalWidth = parseInt(props.custom_marker_size) > 1 ? parseInt(props.custom_marker_size) : width;
          const finalHeight = parseInt(props.custom_marker_size) > 1 ? parseInt(props.custom_marker_size) : height;
          window.TWER_GEOLOCATE._userLocationDotMarker._element.style.width = `${finalWidth}px`;
          window.TWER_GEOLOCATE._userLocationDotMarker._element.style.height = `${finalHeight}px`;
          props.anchor = props.custom_marker_position;
        } else {
          window.TWER_GEOLOCATE._userLocationDotMarker._element.innerHTML = `<div class="treweler-marker"><div class="marker">
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

        window.TWER_GEOLOCATE._userLocationDotMarker._element.classList.add(`js-twer-marker`);

        window.TWER_GEOLOCATE._userLocationDotMarker._element.setAttribute('id', `twer-popup-id-${props.id}`); // Add marker style class


        window.TWER_GEOLOCATE._userLocationDotMarker._element.classList.add(`twer-cursor-${props.cursor}`); // Add type of marker


        window.TWER_GEOLOCATE._userLocationDotMarker._element.classList.add(`twer-marker-type--${props.marker_style}`);
      } else {
        window.TWER_GEOLOCATE._userLocationDotMarker._element.classList.add('d-none');
      }
    });
  }

  detectUserLocation() {
    TWER.map.on('load', () => {
      if (this.isUserAutoGeolocation()) {
        window.TWER_GEOLOCATE.trigger();

        window.TWER_GEOLOCATE._geolocateButton.addEventListener('click', e => {
          if (this.geolocateButtonPressed) return false;
          this.geolocateButtonPressed = true;

          if (!this.isCenteredMapOnLoadUserLocation() && this.isUserAutoGeolocation()) {
            const position = window.TWER_GEOLOCATE._lastKnownPosition;
            const center = new mapboxgl.LngLat(position.coords.longitude, position.coords.latitude);
            const radius = position.coords.accuracy;
            const bearing = TWER.map.getBearing();
            const options = this.extend({
              bearing
            }, {
              maxZoom: 15
            });
            TWER.map.fitBounds(center.toBounds(radius), options, {
              geolocateSource: true
            });
            window.TWER_GEOLOCATE._watchState = 'ACTIVE_LOCK';

            window.TWER_GEOLOCATE._geolocateButton.classList.remove('mapboxgl-ctrl-geolocate-background');

            window.TWER_GEOLOCATE._geolocateButton.classList.add('mapboxgl-ctrl-geolocate-active');

            window.TWER_GEOLOCATE._updateCamera = position => {
              const center = new mapboxgl.LngLat(position.coords.longitude, position.coords.latitude);
              const radius = position.coords.accuracy;
              const bearing = TWER.map.getBearing();
              const options = this.extend({
                bearing
              }, {
                maxZoom: 15
              });
              TWER.map.fitBounds(center.toBounds(radius), options, {
                geolocateSource: true // tag this camera change so it won't cause the control to change to background state

              });
            };
          }
        });
      }
    });
  }

  extend(dest) {
    for (var _len = arguments.length, sources = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
      sources[_key - 1] = arguments[_key];
    }

    for (const src of sources) {
      for (const k in src) {
        dest[k] = src[k];
      }
    }

    return dest;
  }

  initGeolocateControl() {
    window.TWER_GEOLOCATE = new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true
      },
      showUserLocation: true,
      showAccuracyCircle: this.getUserGeolocationMarkerTemplate() === 'default' ? true : false,
      trackUserLocation: true,
      showUserHeading: true
    });
    TWER.map.addControl(window.TWER_GEOLOCATE, TWER.data.geolocateControlPosition);

    if (!this.isCenteredMapOnLoadUserLocation() && this.isUserAutoGeolocation()) {
      window.TWER_GEOLOCATE._updateCamera = position => {
        const center = TWER.map.getCenter();
        const radius = position.coords.accuracy;
        const bearing = TWER.map.getBearing();
        const options = this.extend({
          bearing
        }, {
          maxZoom: TWER.map.getZoom(),
          animate: false
        });
        TWER.map.fitBounds(center.toBounds(radius), options, {
          geolocateSource: false
        });
      };
    }
  }

  addGeolocateControlStyle() {
    if (TWER.data.geolocateControlStyle === 'treweler-style') {
      window.TWER_GEOLOCATE._container.classList.add('twer-geolocation-control');
    }
  }

  hideGeolocateControl() {
    if (this.isGeolocateControl()) return false;
    window.TWER_GEOLOCATE._container.style.display = 'none';
  }

  isEnableGeolocation() {
    return this.isUserAutoGeolocation() || this.isGeolocateControl();
  }

  isUserAutoGeolocation() {
    return TWER.data.userGeolocation;
  }

  isGeolocateControl() {
    return TWER.data.geolocateControl;
  }

  isCenteredMapOnLoadUserLocation() {
    return TWER.data.userGeolocationCenteredMapOnLoad;
  }

  getUserGeolocationMarkerTemplate() {
    return TWER.data.userGeolocationMarkerTemplate;
  }

}

window.addEventListener('load', () => {
  new TrewelerUserLocation();
});
}();
/******/ })()
;
//# sourceMappingURL=treweler-user-location.js.map