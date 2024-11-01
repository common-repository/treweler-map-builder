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
/*!***************************************************!*\
  !*** ./src/js/admin/treweler-manage-shortcode.js ***!
  \***************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");



const {
  __
} = wp.i18n;
/**
 * Init All Shortcode Admin Side
 */

class TWER_SHORTCODE {
  constructor() {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_fullwidth", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_disable_zoom", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_width", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_width_unit", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_height", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_height_unit", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_initial_point_lat", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_initial_point_lon", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_zoom_level", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_zoom_number", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$shortcode_code", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$copyBtn", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "shortcodeRawValues", {});

    // Set all settings fields to variables
    this.$shortcode_fullwidth = document.getElementById('shortcode_fullwidth');
    this.$shortcode_disable_zoom = document.getElementById('shortcode_disable_zoom');
    this.$shortcode_width = document.getElementById('shortcode_width');
    this.$shortcode_width_unit = document.getElementById('shortcode_width_unit');
    this.$shortcode_height = document.getElementById('shortcode_height');
    this.$shortcode_height_unit = document.getElementById('shortcode_height_unit');
    this.$shortcode_initial_point_lat = document.getElementById('shortcode_initial_point_lat');
    this.$shortcode_initial_point_lon = document.getElementById('shortcode_initial_point_lon');
    this.$shortcode_zoom_level = document.getElementById('shortcode_zoom_level');
    this.$shortcode_zoom_number = document.getElementById('shortcode_zoom_number');
    this.$shortcode_code = document.getElementById('shortcode_code'); // Copy 'Shortcode' button functionality

    this.$copyBtn = document.getElementsByClassName('js-twer-copy-text')[0];
    this.$copyBtn.addEventListener('click', e => {
      this.$shortcode_code.select();
      document.execCommand('copy');
    }); // Sync zoom range input with zoom range number input

    [this.$shortcode_zoom_level, this.$shortcode_zoom_number].map(($element, index, array) => {
      const currentId = $element.id;

      if (currentId === 'shortcode_zoom_number') {
        if ($element.value === '') {
          this.$shortcode_zoom_level.value = 0;
        } else {
          this.$shortcode_zoom_level.value = $element.value;
        }
      }

      if (currentId === 'shortcode_zoom_level') {
        if (this.$shortcode_zoom_number.value === '') {
          $element.value = 0;
        } else {
          $element.value = this.$shortcode_zoom_number.value;
        }
      }
    }); // Shortcode settings watch

    [this.$shortcode_fullwidth, this.$shortcode_disable_zoom, this.$shortcode_width, this.$shortcode_width_unit, this.$shortcode_height, this.$shortcode_height_unit, this.$shortcode_initial_point_lat, this.$shortcode_initial_point_lon, this.$shortcode_zoom_level, this.$shortcode_zoom_number].map(($element, index, array) => {
      const elementType = $element.type;

      switch (elementType) {
        case 'checkbox':
          this.shortcodeRawValues[$element.id] = $element.checked;
          $element.addEventListener('change', e => {
            this.shortcodeRawValues[e.target.id] = e.target.checked;
            this.makeShortcodeCode();
          });
          break;

        case 'number':
          this.shortcodeRawValues[$element.id] = $element.value;
          $element.addEventListener('keyup', e => {
            if (e.target.id === 'shortcode_zoom_number') {
              if (e.target.value === '') {
                this.$shortcode_zoom_level.value = 0;
                this.shortcodeRawValues.shortcode_zoom_level = 0;
              } else {
                this.$shortcode_zoom_level.value = e.target.value;
                this.shortcodeRawValues.shortcode_zoom_level = e.target.value;
              }
            }

            this.shortcodeRawValues[e.target.id] = e.target.value;
            this.makeShortcodeCode();
          });
          break;

        case 'select-one':
          this.shortcodeRawValues[$element.id] = $element.value;
          $element.addEventListener('change', e => {
            this.shortcodeRawValues[e.target.id] = e.target.value;
            this.makeShortcodeCode();
          });
          break;

        case 'range':
          this.shortcodeRawValues[$element.id] = $element.value;
          $element.addEventListener('input', e => {
            this.$shortcode_zoom_number.value = e.target.value;

            if (e.target.id === 'shortcode_zoom_level') {
              this.shortcodeRawValues.shortcode_zoom_number = e.target.value;
            }

            this.shortcodeRawValues[e.target.id] = e.target.value;
            this.makeShortcodeCode();
          });
          break;
      }
    });
    this.makeShortcodeCode();
  }

  makeShortcodeCode() {
    const shortcodeAtts = new Set();
    const widthUnit = this.shortcodeRawValues.shortcode_width_unit;
    const heightUnit = this.shortcodeRawValues.shortcode_height_unit;
    const width = this.shortcodeRawValues.shortcode_width;
    const height = this.shortcodeRawValues.shortcode_height;

    if (width !== '') {
      this.shortcodeRawValues.shortcode_width = `${parseFloat(width)}${widthUnit}`;
    }

    if (height !== '') {
      this.shortcodeRawValues.shortcode_height = `${parseFloat(height)}${heightUnit}`;
    }

    for (let id in this.shortcodeRawValues) {
      const elementAttr = this.idToShortcodeAttrConverter(id);
      const elementValue = this.shortcodeRawValues[id];

      switch (id) {
        case 'shortcode_fullwidth':
        case 'shortcode_disable_zoom':
          if (elementValue) {
            shortcodeAtts.add(elementAttr);
          }

          break;

        case 'shortcode_width':
        case 'shortcode_height':
        case 'shortcode_initial_point_lat':
        case 'shortcode_initial_point_lon':
        case 'shortcode_zoom_number':
          if (elementValue !== '') {
            shortcodeAtts.add(elementAttr.replace(/#value#/g, elementValue));
          }

          break;
      }
    }

    const mapId = twer_ajax.post_id;
    let mapAtts = [...shortcodeAtts].join(' ');

    if (mapAtts.trim() !== '') {
      mapAtts = ` ${mapAtts}`;
    }

    this.$shortcode_code.value = `[treweler map-id="${mapId}"${mapAtts}]`;
  }

  idToShortcodeAttrConverter(id) {
    id = id.replace(/shortcode_/g, '');
    let attr = '';

    switch (id) {
      case 'fullwidth':
        attr = 'type="fullwidth"';
        break;

      case 'disable_zoom':
        attr = 'scrollzoom="no"';
        break;

      case 'width_unit':
        attr = 'width-unit="#unit#"';
        break;

      case 'height_unit':
        attr = 'height-unit="#unit#"';
        break;

      case 'width':
        attr = 'width="#value#"';
        break;

      case 'height':
        attr = 'height="#value#"';
        break;

      case 'initial_point_lat':
        attr = 'lat="#value#"';
        break;

      case 'initial_point_lon':
        attr = 'lon="#value#"';
        break;

      case 'zoom_number':
      case 'zoom_level':
        attr = 'zoom="#value#"';
        break;
    }

    return attr;
  }

}

window.addEventListener('DOMContentLoaded', () => {
  new TWER_SHORTCODE();
});
}();
/******/ })()
;
//# sourceMappingURL=treweler-manage-shortcode.js.map