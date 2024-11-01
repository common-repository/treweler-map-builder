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
/*!**************************************************!*\
  !*** ./src/js/admin/treweler-manage-page-map.js ***!
  \**************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");



const {
  __
} = wp.i18n;
/**
 * Init All Shortcode Admin Side
 */

class TWER_PAGE_MAP {
  constructor() {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$page_map_zoom_level", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$page_map_zoom_number", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$page_map_custom", null);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "$page_map_initial_point_lat", null);

    this.$page_map_zoom_level = document.getElementById('page_map_zoom_level');
    this.$page_map_zoom_number = document.getElementById('page_map_zoom_number');
    this.$page_map_custom = document.getElementById('page_map_custom');
    this.$page_map_initial_point_lat = document.getElementById('page_map_initial_point_lat'); // Sync zoom range input with zoom range number input

    [this.$page_map_zoom_level, this.$page_map_zoom_number].map(($element, index, array) => {
      const currentId = $element.id;

      if (currentId === 'page_map_zoom_number') {
        if ($element.value === '') {
          this.$page_map_zoom_level.value = 0;
        } else {
          this.$page_map_zoom_level.value = $element.value;
        }
      }

      if (currentId === 'page_map_zoom_level') {
        if (this.$page_map_zoom_number.value === '') {
          $element.value = 0;
        } else {
          $element.value = this.$page_map_zoom_number.value;
        }
      }
    }); // Shortcode settings watch

    [this.$page_map_zoom_level, this.$page_map_zoom_number, this.$page_map_initial_point_lat, this.$page_map_custom].map(($element, index, array) => {
      const elementType = $element.type;

      switch (elementType) {
        case 'checkbox':
          if ($element.checked) {
            this.$page_map_zoom_level.closest('.js-twer-row').classList.remove('d-none');
            this.$page_map_initial_point_lat.closest('.js-twer-row').classList.remove('d-none');
          } else {
            this.$page_map_zoom_level.closest('.js-twer-row').classList.add('d-none');
            this.$page_map_initial_point_lat.closest('.js-twer-row').classList.add('d-none');
          }

          $element.addEventListener('change', e => {
            if ($element.checked) {
              this.$page_map_zoom_level.closest('.js-twer-row').classList.remove('d-none');
              this.$page_map_initial_point_lat.closest('.js-twer-row').classList.remove('d-none');
            } else {
              this.$page_map_zoom_level.closest('.js-twer-row').classList.add('d-none');
              this.$page_map_initial_point_lat.closest('.js-twer-row').classList.add('d-none');
            }
          });
          break;

        case 'number':
          $element.addEventListener('keyup', e => {
            if (e.target.id === 'page_map_zoom_number') {
              if (e.target.value === '') {
                this.$page_map_zoom_level.value = 0;
              } else {
                this.$page_map_zoom_level.value = e.target.value;
              }
            }
          });
          break;

        case 'range':
          $element.addEventListener('input', e => {
            this.$page_map_zoom_number.value = e.target.value;
          });
          break;
      }
    });
  }

}

window.addEventListener('DOMContentLoaded', () => {
  new TWER_PAGE_MAP();
});
}();
/******/ })()
;
//# sourceMappingURL=treweler-manage-page-map.js.map