/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/admin/modules/controls.js":
/*!******************************************!*\
  !*** ./src/js/admin/modules/controls.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);


const {
  __
} = wp.i18n;
/**
 * Init All Controls Logic
 */

class TWER_CONTROLS {
  /**
   * Controls constructor
   *
   * @param props
   */
  constructor(props) {
    // Init JQuery
    this.$ = $ = props; // Toggle TR table row after controls change

    const toggleElements = document.querySelectorAll('.js-twer-tr-toggle');
    const toggleControls = []; // Load status show/hide

    toggleElements.forEach(element => {
      const $toggleControl = document.getElementById(element.getAttribute('id').replace('-toggle', ''));
      toggleControls.push($toggleControl);
      const toggleControlValue = $toggleControl.options[$toggleControl.selectedIndex].value;
      const triggerValue = element.dataset.trigger;

      if (toggleControlValue === triggerValue) {
        element.classList.add('twer-tr-toggle--show');
        element.classList.remove('twer-tr-toggle--hide');
      } else {
        element.classList.remove('twer-tr-toggle--show');
        element.classList.add('twer-tr-toggle--hide');
      }
    }); // Change status

    toggleControls.forEach(element => {
      element.addEventListener('change', event => {
        const $toggleElement = document.getElementById(event.target.getAttribute('id') + '-toggle');
        const toggleControlValue = event.target.value;
        const triggerValue = $toggleElement.dataset.trigger;

        if (toggleControlValue === triggerValue) {
          $toggleElement.classList.add('twer-tr-toggle--show');
          $toggleElement.classList.remove('twer-tr-toggle--hide');
        } else {
          $toggleElement.classList.remove('twer-tr-toggle--show');
          $toggleElement.classList.add('twer-tr-toggle--hide');
        }
      });
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_CONTROLS);

/***/ }),

/***/ "./src/js/admin/modules/custom-fields.js":
/*!***********************************************!*\
  !*** ./src/js/admin/modules/custom-fields.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);


const {
  __
} = wp.i18n;
/**
 * Init All Custom Fields Logic
 */

class TWER_CUSTOM_FIELDS {
  elementCount(arr, element) {
    return arr.filter(currentElement => currentElement == element).length;
  }
  /**
   * Uploads constructor
   *
   * @param props
   */


  constructor(props) {
    // Init JQuery
    this.$ = $ = props;
    const scope = this;
    $('.js-ui-slider-wrap').each((index, element) => {
      const $sortableList = $(element);
      $sortableList.sortable({
        cursor: 'move',
        placeholder: 'ui-sortable-placeholder twer-tr-toggle js-ui-slider-item',
        forcePlaceholderSize: true,
        forceHelperSize: true,
        scroll: true,
        revert: false,
        tolerance: 'pointer',
        handle: '.js-twer-ui-sort-tr',
        items: '> .js-ui-slider-item',
        create: function () {
          const $input = $sortableList.find('input.js-twer-custom-fields-list');
          let ids = [];
          $sortableList.children('.js-ui-slider-item').each(function (divIndex, div) {
            ids.push($(div).data('id'));
          }); //console.log(ids);

          $input.val(ids.join(','));
        },
        update: function (event, ui) {
          const $input = $sortableList.find('input.js-twer-custom-fields-list');
          let ids = [];
          $sortableList.children('.js-ui-slider-item').each(function (divIndex, div) {
            ids.push($(div).data('id'));
          }); //console.log(ids);

          $input.val(ids.join(','));
        }
      }).disableSelection();
    });
    $('select, input:checkbox').each(function () {
      const readOnly = $(this).attr('readonly');

      if (readOnly === 'readonly') {
        $(this).closest('.col-simple, .col-fixed').css({
          pointerEvents: "none"
        });
        $(this).closest('.col-simple, .col-fixed').addClass('penoneSelect');
      }
    });
    $(document).on('click', '.js-twer-ui-del-tr', function (e) {
      e.preventDefault();
      const $removeButton = $(this);
      const $sortableList = $removeButton.closest('.js-ui-slider-wrap');
      const $input = $sortableList.find('input.js-twer-custom-fields-list');
      const $select = $sortableList.find('.js-custom-fields-list');
      const ids = [];
      const id = parseInt($removeButton.closest('.js-ui-slider-item').data('id'));
      const label = $removeButton.closest('.js-ui-slider-item').find('th label').text();

      if (0 === $select.find('option[value=' + id + ']').length && !isNaN(id)) {
        $select.append(`<option value="${id}">${label}</option>`);
      }

      $removeButton.closest('.js-ui-slider-item').remove();
      $sortableList.children('.js-ui-slider-item').each(function (divIndex, div) {
        ids.push($(div).data('id'));
      });
      $input.val(ids.join(','));
      const popupIds = $('#treweler-custom-fields-list').val().trim() !== '' ? $('#treweler-custom-fields-list').val().split(',').map(id => parseInt(id)) : [];
      const locatorPreviewIds = $('#treweler-custom-fields-list-locator-preview').val().trim() !== '' ? $('#treweler-custom-fields-list-locator-preview').val().split(',').map(id => parseInt(id)) : [];
      const locatorIds = $('#treweler-custom-fields-list-locator').val().trim() !== '' ? $('#treweler-custom-fields-list-locator').val().split(',').map(id => parseInt(id)) : [];
      const allCustomFieldsIds = [...popupIds, ...locatorPreviewIds, ...locatorIds];
      setTimeout(function () {
        if ($removeButton.closest('.tab-pane').attr('id') !== 'twer-nav-custom-fields-wo-template' && scope.elementCount(allCustomFieldsIds, id) === 0) {
          const $uniqueInput = $('#treweler-custom-fields-list-unique');
          const $uniqueInputWrapper = $uniqueInput.closest('.js-ui-slider-wrap');
          const $uniqueRow = $uniqueInputWrapper.find('.js-ui-slider-item[data-id="' + id + '"]');
          $uniqueRow.find('.js-twer-ui-del-tr').trigger('click');
        }
      }, 500);
      setTimeout(() => {
        scope.toggleNotEditableFieldsNotice();
      }, 600);
    });
    $(document).on('click', '.js-add-custom-field', function (e) {
      e.preventDefault();
      const $addButton = $(this);
      const $sortableWrap = $addButton.closest('.js-ui-slider-wrap');
      const $select = $sortableWrap.find('.js-custom-fields-list');
      const selectedId = $select.val();

      if ('none' !== selectedId) {
        const $row = $sortableWrap.find('.js-hidden-item[data-id="' + selectedId + '"]').clone();
        const ids = [];
        $row.find('select.js-field-multiselect').select2({
          placeholder: 'No values selected',
          width: '100%',
          minimumResultsForSearch: -1
        });
        $row.toggleClass('d-none js-ui-slider-item');
        $row.removeClass('js-hidden-item');
        $row.find('textarea:not(.select2-search__field), input:not(:checkbox):not(.js-twer-lock-status)').each(function () {
          const $input = $(this);
          $input.prop('disabled', false);
          $input.prop('readonly', true);
          $input.val($input.data('default'));
          $input.attr('value', $input.data('default'));
        });
        $row.find('input.js-twer-lock-status').each(function () {
          const $input = $(this);
          $input.prop('disabled', false);
          $input.prop('readonly', false);
          $input.val('close');
          $input.attr('value', 'close');
        });
        $row.find('.js-twer-lock').removeClass('twer-lock--open');
        $row.find('input:checkbox').each(function () {
          const $input = $(this);
          $input.prop('disabled', false);
          $input.prop('readonly', true);
          $input.prop("checked", $input.data('default'));
          $input.closest('.col-fixed').css({
            pointerEvents: "none"
          });
        });
        $row.find('select').each(function () {
          const $input = $(this);
          $input.prop('disabled', false);
          $input.prop('readonly', true);
          let defaultValue = $input.data('default');

          if (defaultValue === '') {
            defaultValue = null;
          } else {
            defaultValue = typeof defaultValue === 'string' ? JSON.parse(defaultValue) : defaultValue;
          }

          $input.val(defaultValue).trigger('change');
          $input.closest('.col-simple').css({
            pointerEvents: "none"
          });
          $input.closest('.col-simple').addClass('penoneSelect');
        });
        $row.insertBefore($sortableWrap.find('.js-hidden-item:first'));
        $select.find('option:selected').remove();
        const $sortableList = $(this).closest('.js-ui-slider-wrap');
        const $input = $sortableList.find('input.js-twer-custom-fields-list');
        $sortableList.sortable('refresh');
        $sortableList.sortable('refreshPositions');
        $sortableList.children('.js-ui-slider-item').each(function (divIndex, div) {
          ids.push($(div).data('id'));
        });
        $input.val(ids.join(','));
        setTimeout(function () {
          if ($addButton.closest('.tab-pane').attr('id') !== 'twer-nav-custom-fields-wo-template') {
            const $uniqueInput = $('#treweler-custom-fields-list-unique');
            const $uniqueInputWrapper = $uniqueInput.closest('.js-ui-slider-wrap');
            console.log(selectedId);
            $uniqueInputWrapper.find('.js-custom-fields-list').val(selectedId);
            $uniqueInputWrapper.find('.js-add-custom-field').trigger('click');
          }
        }, 500);
      }

      setTimeout(() => {
        scope.toggleNotEditableFieldsNotice();
      }, 700);
    });
    $(document).on('click', '.js-twer-lock', function (e) {
      e.preventDefault();
      const $lock = $(this);
      const index = $lock.index();
      const lockStatus = $lock.hasClass('twer-lock--open') ? 'open' : 'close';
      let $field = $lock.closest('.twer-wrap-fields').find('.twer-group-elements .row');

      if ($field.length > 0) {
        $field = $field.children().eq(index);
      } else {
        $field = $lock.closest('.twer-wrap-fields').find('.twer-form-group');
      }

      if ('open' === lockStatus) {
        const $input = $field.find('textarea:not(.select2-search__field), input:not(.js-twer-lock-status):not(:checkbox)');
        $input.prop('readonly', true);
        $input.data('current', $input.val());
        $input.val($input.data('default'));
        $input.attr('value', $input.data('default'));
        $lock.removeClass('twer-lock--open');
        $field.find('.js-twer-lock-status').val('close');
        $field.find('.js-twer-lock-status').attr('value', 'close');
        const $checkbox = $field.find('input:checkbox');
        $checkbox.prop('disabled', false);
        $checkbox.prop('readonly', true);
        $checkbox.data('current', $checkbox.is(':checked'));
        $checkbox.prop("checked", $input.data('default'));
        $checkbox.closest('.col-fixed').css({
          pointerEvents: "none"
        });
        const $select = $field.find('select');
        $select.prop('disabled', false);
        $select.prop('readonly', true);
        $select.data('current', JSON.stringify($select.val()));
        let defaultValue = $select.data('default');

        if (defaultValue === '') {
          defaultValue = null;
        } else {
          defaultValue = typeof defaultValue === 'string' ? JSON.parse(defaultValue) : defaultValue;
        }

        $select.val(defaultValue).trigger('change');
        $select.closest('.col-simple').css({
          pointerEvents: "none"
        });
        $select.closest('.col-simple').addClass('penoneSelect');
      }

      if ('close' === lockStatus) {
        const $input = $field.find('textarea:not(.select2-search__field), input:not(.js-twer-lock-status):not(:checkbox)');
        $input.prop('readonly', false);
        $input.val($input.data('current'));
        $input.attr('value', $input.data('current'));
        $lock.addClass('twer-lock--open');
        $field.find('.js-twer-lock-status').val('open');
        $field.find('.js-twer-lock-status').attr('value', 'open');
        const $checkbox = $field.find('input:checkbox');
        $checkbox.prop('disabled', false);
        $checkbox.prop('readonly', false);
        $checkbox.prop("checked", $checkbox.data('current'));
        $checkbox.closest('.col-fixed').css({
          pointerEvents: "auto"
        });
        const $select = $field.find('select');
        $select.prop('disabled', false);
        $select.prop('readonly', false);
        let currentValue = $select.data('current');

        if (currentValue === '') {
          currentValue = null;
        } else {
          currentValue = typeof currentValue === 'string' ? JSON.parse(currentValue) : currentValue;
        }

        $select.val(currentValue).trigger('change');
        $select.closest('.col-simple').css({
          pointerEvents: "auto"
        });
        $select.closest('.col-simple').removeClass('penoneSelect');
      }
    });
  }

  toggleNotEditableFieldsNotice() {
    const $notEditableCustomFieldsNotice = $('#js-twer-not-fields-message');

    if ($notEditableCustomFieldsNotice.length > 0) {
      const allTrLength = $notEditableCustomFieldsNotice.closest('.tab-pane').find('tr').length;
      const allTrHiddenLength = $notEditableCustomFieldsNotice.closest('.tab-pane').find('tr.d-none').length;
      const allTrHiddenHardLength = $notEditableCustomFieldsNotice.closest('.tab-pane').find('tr.d-none-hard:not(.d-none)').length;
      const allTrHide = allTrHiddenLength + allTrHiddenHardLength;

      if (allTrLength === allTrHide) {
        $notEditableCustomFieldsNotice.removeClass('d-none');
      } else {
        $notEditableCustomFieldsNotice.addClass('d-none');
      }
    }
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_CUSTOM_FIELDS);

/***/ }),

/***/ "./src/js/admin/modules/uploads.js":
/*!*****************************************!*\
  !*** ./src/js/admin/modules/uploads.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);


const {
  __
} = wp.i18n;

class TWER_UPLOADS {
  /**
   * Uploads constructor
   *
   * @param props
   */
  constructor(props) {
    // Init JQuery
    this.$ = $ = props;
    const $addAttach = document.querySelectorAll('.js-twer-attach-add');
    const $removeAttach = document.querySelectorAll('.js-twer-attach-remove'); // Click on Upload attach button in metabox

    $addAttach.forEach(element => {
      element.addEventListener('click', event => {
        var _$attachWrap$dataset, _$attachWrap$dataset2, _$attachWrap$dataset3, _$attachWrap$dataset4;

        event.preventDefault();
        const $btn = event.target;
        const $attachWrap = $btn.closest('.js-twer-attach-wrap');
        let xmlFrame;

        if (xmlFrame) {
          xmlFrame.open();
          return;
        }

        xmlFrame = wp.media({
          title: ($attachWrap === null || $attachWrap === void 0 ? void 0 : (_$attachWrap$dataset = $attachWrap.dataset) === null || _$attachWrap$dataset === void 0 ? void 0 : _$attachWrap$dataset.title) || __('Select image', 'treweler'),
          button: {
            text: ($attachWrap === null || $attachWrap === void 0 ? void 0 : (_$attachWrap$dataset2 = $attachWrap.dataset) === null || _$attachWrap$dataset2 === void 0 ? void 0 : _$attachWrap$dataset2.buttonText) || __('Upload image', 'treweler')
          },
          library: {
            type: ($attachWrap === null || $attachWrap === void 0 ? void 0 : (_$attachWrap$dataset3 = $attachWrap.dataset) === null || _$attachWrap$dataset3 === void 0 ? void 0 : (_$attachWrap$dataset4 = _$attachWrap$dataset3.libraryType) === null || _$attachWrap$dataset4 === void 0 ? void 0 : _$attachWrap$dataset4.split(',')) || ['image']
          },
          multiple: false
        });
        xmlFrame.on('select', () => {
          const xmlFrameFile = xmlFrame.state().get('selection').first().toJSON();
          const xmlUrl = xmlFrameFile.url;
          const xmlId = xmlFrameFile.id;
          const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb')[0];

          if (xmlFrameFile.type === 'application') {
            var _$attachWrap$getEleme;

            const $div = document.createElement('div');
            $div.style.whiteSpace = 'nowrap';
            $div.className = 'twer-app-file';
            $div.innerText = xmlFrameFile.filename;
            (_$attachWrap$getEleme = $attachWrap.getElementsByClassName('twer-app-file')[0]) === null || _$attachWrap$getEleme === void 0 ? void 0 : _$attachWrap$getEleme.remove();
            $thumbWrap.appendChild($div);
          } else {
            var _$attachWrap$getEleme2;

            const $img = document.createElement('img');
            $img.setAttribute('src', xmlUrl);
            $img.setAttribute('alt', xmlFrameFile.title);
            (_$attachWrap$getEleme2 = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme2 === void 0 ? void 0 : _$attachWrap$getEleme2.remove();
            $thumbWrap.appendChild($img);
          }

          if (!$btn.classList.contains('button')) {
            $btn.style.display = 'none';
          }

          $thumbWrap.nextElementSibling.style.display = 'block';
          $attachWrap.getElementsByTagName('input')[0].value = xmlId;
          $(document).trigger('twer-attach-add', [xmlFrame]);
        });
        xmlFrame.open();
      });
    }); // Click on Remove attach button in metabox

    $removeAttach.forEach(element => {
      element.addEventListener('click', event => {
        event.preventDefault();
        const $btn = event.target;
        const $attachWrap = $btn.closest('.js-twer-attach-wrap');
        const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb')[0];

        if ($attachWrap.getElementsByClassName('twer-app-file')) {
          $attachWrap.getElementsByClassName('twer-app-file')[0].remove();
        } else {
          var _$attachWrap$getEleme3;

          (_$attachWrap$getEleme3 = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme3 === void 0 ? void 0 : _$attachWrap$getEleme3.remove();
        }

        $attachWrap.getElementsByTagName('input')[0].value = '';
        $btn.closest('.js-twer-attach-actions').style.display = 'none';
        $thumbWrap.getElementsByClassName('js-twer-attach-add')[0].style.display = 'block';
        $(document).trigger('twer-attach-remove');
      });
    });
    const $addAttachGallery = document.querySelectorAll('.js-twer-attach-gallery-add');
    $('.js-twer-attach-gallery-wrap').each((index, element) => {
      const $sortableList = $(element);
      $sortableList.sortable({
        cursor: 'move',
        placeholder: 'twer-attach-gallery__thumb',
        forcePlaceholderSize: true,
        forceHelperSize: true,
        scroll: true,
        revert: false,
        tolerance: 'pointer',
        items: '> div',
        update: function (event, ui) {
          const $input = $sortableList.find('input');
          const ids = [];
          $sortableList.children('div').each(function (divIndex, div) {
            ids.push($(div).data('id'));
          });
          $input.val(ids.join(','));
        }
      }).disableSelection();
    });
    $(document).on('click', '.js-twer-attach-gallery-remove', function (e) {
      e.preventDefault();
      const $sortableList = $(this).closest('.js-twer-attach-gallery-wrap');
      const $input = $sortableList.find('input');
      const ids = [];
      $(this).closest('.twer-attach-gallery__thumb').remove();
      $sortableList.children('div').each(function (divIndex, div) {
        ids.push($(div).data('id'));
      });
      $input.val(ids.join(','));
    }); // Click on Upload attach gallery button in metabox

    $addAttachGallery.forEach(element => {
      element.addEventListener('click', event => {
        event.preventDefault();
        const $btn = event.target;
        let xmlFrame;

        if (xmlFrame) {
          xmlFrame.open();
          return;
        }

        xmlFrame = wp.media({
          title: __('Select images', 'treweler'),
          button: {
            text: __('Upload images', 'treweler')
          },
          library: {
            type: ['image']
          },
          multiple: 'add'
        });
        xmlFrame.on('open', () => {
          const $attachWrap = $btn.closest('.js-twer-attach-gallery-wrap');
          const attachIds = $attachWrap.getElementsByTagName('input')[0].value;
          let selection = xmlFrame.state().get('selection');

          if (attachIds.length > 0) {
            let ids = attachIds.split(',');
            ids.forEach(function (id) {
              let attachment = wp.media.attachment(id);
              attachment.fetch();
              selection.add(attachment ? [attachment] : []);
            });
          }
        });
        xmlFrame.on('select', () => {
          const selection = xmlFrame.state().get('selection');
          const $attachWrap = $btn.closest('.js-twer-attach-gallery-wrap');
          const attachIds = [];
          const elements = $attachWrap.getElementsByClassName('twer-attach-gallery__thumb');

          while (elements.length > 0) {
            elements[0].parentNode.removeChild(elements[0]);
          } //let index = 0;


          selection.map(function (attachment) {
            attachment = attachment.toJSON();
            let $divThumb = document.createElement('div');
            $divThumb.setAttribute('class', 'twer-attach-gallery__thumb');
            $divThumb.setAttribute('data-id', attachment.id); //$divThumb.setAttribute('data-index', index++);

            let $imgThumb = document.createElement('img');
            $imgThumb.setAttribute('src', attachment.url);
            $imgThumb.setAttribute('alt', attachment.title);
            let $close = document.createElement('a');
            $close.setAttribute('href', '#');
            $close.setAttribute('title', __('Remove', 'treweler'));
            $close.setAttribute('class', 'twer-attach-gallery__remove js-twer-attach-gallery-remove');
            $divThumb.appendChild($imgThumb);
            $divThumb.appendChild($close);
            $attachWrap.insertBefore($divThumb, $btn); //console.log($attachWrap, $divThumb, $btn);

            attachIds.push(attachment.id);
          });
          $attachWrap.getElementsByTagName('input')[0].value = attachIds.join(',');
        });
        xmlFrame.open();
      });
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_UPLOADS);

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
/*!*****************************************!*\
  !*** ./src/js/admin/treweler-marker.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_uploads__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/uploads */ "./src/js/admin/modules/uploads.js");
/* harmony import */ var _modules_controls__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/controls */ "./src/js/admin/modules/controls.js");
/* harmony import */ var _modules_custom_fields__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/custom-fields */ "./src/js/admin/modules/custom-fields.js");





jQuery(document).ready(function ($) {
  new _modules_uploads__WEBPACK_IMPORTED_MODULE_0__["default"]($);
  new _modules_controls__WEBPACK_IMPORTED_MODULE_1__["default"]($);
  new _modules_custom_fields__WEBPACK_IMPORTED_MODULE_2__["default"]($);
});
var tp = '';
var map;
var geo;
var marker;
jQuery.noConflict();

const pickerMapApply = (toggleElementIds, pickerIds, colorsIds, sizeIds) => {
  for (let i = 0; i < toggleElementIds.length; i++) {
    const showIcon = document.getElementById(toggleElementIds[i]);
    const style = document.getElementById('marker_style');
    const markerBalloon = document.getElementsByClassName('marker-balloon__dot');
    const markerDot = document.getElementsByClassName('marker--dot-solid');
    let currentMarkerId = '';

    if (markerBalloon.length > 0 && 'balloon-default' === style.value) {
      currentMarkerId = 'treweler-picker';
    }

    if (markerDot.length > 0 && 'dot-default' === style.value) {
      currentMarkerId = 'treweler-picker-dot';
    } //console.log(currentMarkerId, showIcon.id);


    if (currentMarkerId !== showIcon.id) continue;
    const icon = document.getElementById(pickerIds[i]).value;
    const color = document.getElementById(colorsIds[i]).value;
    const size = Number.isNaN(parseFloat(document.getElementById(sizeIds[i]).value)) ? 15 : parseFloat(document.getElementById(sizeIds[i]).value);

    if (showIcon.checked) {
      if (markerBalloon.length > 0) {
        if (icon.length > 0) {
          markerBalloon[0].innerHTML = `<span class="marker-balloon__icon material-icons" style="color:${color};font-size:${size}px;">${icon}</span>`;
        } else {
          markerBalloon[0].innerHTML = '';
        }
      }

      if (markerDot.length > 0) {
        if (icon.length > 0) {
          markerDot[0].innerHTML = `<span class="marker-dot__icon material-icons" style="color:${color};font-size:${size}px;">${icon}</span>`;
        } else {
          markerDot[0].innerHTML = '';
        }
      }
    } else {
      if (markerBalloon.length > 0) {
        markerBalloon[0].innerHTML = '';
      }

      if (markerDot.length > 0) {
        markerDot[0].innerHTML = '';
      }
    }
  }
};

function toggleNotEditableFieldsNotice() {
  const $notEditableCustomFieldsNotice = $('#js-twer-not-fields-message');

  if ($notEditableCustomFieldsNotice.length > 0) {
    const allTrLength = $notEditableCustomFieldsNotice.closest('.tab-pane').find('tr').length;
    const allTrHiddenLength = $notEditableCustomFieldsNotice.closest('.tab-pane').find('tr.d-none').length;
    const allTrHiddenHardLength = $notEditableCustomFieldsNotice.closest('.tab-pane').find('tr.d-none-hard:not(.d-none)').length;
    const allTrHide = allTrHiddenLength + allTrHiddenHardLength;

    if (allTrLength === allTrHide) {
      $notEditableCustomFieldsNotice.removeClass('d-none');
    } else {
      $notEditableCustomFieldsNotice.addClass('d-none');
    }
  }
}

(function ($) {
  $(function () {
    toggleNotEditableFieldsNotice();
    const markerStyle = $('#marker_style');
    const markerStyleVal = markerStyle.val();
    const colorPicker = $('.color-picker');
    const markerPosition = $('#marker_position').val();
    const markerSize = $('#treweler-marker-img-size').val();
    /**
     * Get mapbox token
     */

    function getToken() {
      if (tp.length === 0) {
        jQuery.ajax({
          url: twer_ajax.url,
          type: 'GET',
          data: {
            action: 'treweler_get_admin_token'
          },
          success: function (response) {
            try {
              const res = atob(response).replace('###', '');
              tp = res.replace('###', '');
            } catch (e) {
              tp = twer_ajax.api_key;
            }

            init_map();
          }
        });
      }
    }

    function hex2rgba(hex, opacity) {
      opacity = parseFloat(opacity);
      hex = hex.replace('#', '');
      const r = parseInt(hex.substring(0, 2), 16);
      const g = parseInt(hex.substring(2, 4), 16);
      const b = parseInt(hex.substring(4, 6), 16);
      return `rgba(${r},${g},${b},${opacity})`;
    }
    /**
     * Initialize map
     * MarkerIcon 1
     */


    function init_map() {
      $('.twer-root').each(function () {
        $(this).find('[data-toggle="tooltip"]').tooltip({
          container: $(this).closest('.twer-root')
        });
      });
      $('#marker_map').html('');

      if (tp.length !== 0) {
        let lat = $('#latitude').val().trim() !== '' && $('#latitude').val() !== 0 ? $('#latitude').val().trim() : 0.1,
            lng = $('#longitude').val().trim() !== '' && $('#longitude').val() !== 0 ? $('#longitude').val().trim() : 0.1,
            zoom = $('#setZoom').val().trim() !== '' ? $('#setZoom').val() : 0.00,
            map_style = $('#map_id option:selected').toArray().map(item => item.dataset.map_style),
            mapProjection = $('#map_id option:selected').toArray().map(item => item.dataset.mapProjection),
            mapLightPreset = $('#map_id option:selected').toArray().map(item => item.dataset.mapLightPreset),
            color = $('#markerColor').val(),
            halo_opacity = Number.isNaN(parseFloat($('#treweler-marker-halo-opacity').val())) ? 0.5 : parseFloat($('#treweler-marker-halo-opacity').val()),
            halo_color = hex2rgba($('#marker_halo_color').val(), halo_opacity),
            markerInnerSize = Number.isNaN(parseFloat($('#treweler-marker-size').val())) ? 12 : parseFloat($('#treweler-marker-size').val()),
            marker_dotcenter_color = hex2rgba($('#marker_dotcenter_color').val(), 1),
            borderColor = hex2rgba($('#marker_border_color').val(), 1),
            borderWidth = Number.isNaN(parseFloat($('#treweler-marker-border-width').val())) ? 0 : parseFloat($('#treweler-marker-border-width').val()),
            markerInnerSizeMargins = (markerInnerSize + borderWidth + borderWidth) / 2 * -1,
            cornerRadius = Number.isNaN(parseFloat($('#treweler-marker-corner-radius-group').val())) ? 50 : parseFloat($('#treweler-marker-corner-radius-group').val()),
            cornerRadiusUnits = Number.isNaN($('#treweler-marker-corner-radius-group-select').val()) ? '%' : $('#treweler-marker-corner-radius-group-select').val(),
            markerColorBalloon = hex2rgba($('#marker_color_balloon').val(), 1),
            markerSizeBalloon = Number.isNaN(parseFloat($('#treweler-marker-size-balloon').val())) ? 18 : parseFloat($('#treweler-marker-size-balloon').val()),
            borderColorBalloon = hex2rgba($('#marker_border_color_balloon').val(), 1),
            borderWidthBalloon = Number.isNaN(parseFloat($('#treweler-marker-border-width-balloon').val())) ? 4 : parseFloat($('#treweler-marker-border-width-balloon').val()),
            dotColor = hex2rgba($('#marker_dot_color').val(), 1),
            dotSize = Number.isNaN(parseFloat($('#treweler-marker-dot-size').val())) ? 8 : parseFloat($('#treweler-marker-dot-size').val()),
            markerColorTriangle = hex2rgba($('#marker_color_triangle').val(), 1),
            markerWidthTriangle = Number.isNaN(parseFloat($('#treweler-marker-width-triangle').val())) ? 12 : parseFloat($('#treweler-marker-width-triangle').val()),
            markerHeightTriangle = Number.isNaN(parseFloat($('#treweler-marker-height-triangle').val())) ? 10 : parseFloat($('#treweler-marker-height-triangle').val());

        if (map_style.length <= 0) {
          map_style = ['mapbox://styles/mapbox/standard-beta'];
        }

        if (mapProjection.length <= 0) {
          mapProjection = ['mercator'];
        }

        if (lng === '0') {
          lng = 0.1;
        }

        if (lat === '0') {
          lat = 0.1;
        }

        mapboxgl.accessToken = tp;
        map = new mapboxgl.Map({
          container: 'marker_map',
          style: map_style[0],
          center: [lng, lat],
          zoom: zoom,
          minZoom: 0,
          maxZoom: 24,
          projection: {
            name: mapProjection[0]
          }
        });
        map.on('style.load', () => {
          if (map_style[0] === 'mapbox://styles/mapbox/standard-beta') {
            let mapLightPresetString = mapLightPreset[0] ? mapLightPreset[0] : 'day';
            map.setConfigProperty('basemap', 'lightPreset', mapLightPresetString);
          }
        });
        /**
         * Mapbox Geocoder
         */

        let geocoder = new MapboxGeocoder({
          accessToken: mapboxgl.accessToken,
          mapboxgl: mapboxgl,
          marker: false
        });
        geocoder.on('result', function (e) {
          $('#latitude').val(e.result.center[1]);
          $('#longitude').val(e.result.center[0]);
          setTimeout(function () {
            addHTMLMarker();
          }, 200);
        });
        map.addControl(geocoder);

        if ($('#marker_style').val() !== 'custom') {
          var markerEle = document.createElement('div');
          let defaultAnchor = markerPosition;
          markerEle.className = 'treweler-marker';

          if (markerStyleVal === 'default') {
            markerEle.innerHTML = '<div class="marker"><div class="marker-wrap"><div class="marker__shadow" style="background-color:' + halo_color + ';"><div class="marker__border" style="border-color:' + color + ';"><div class="marker__center"></div></div></div></div></div>';
          } else if ('dot-default' === markerStyleVal) {
            markerEle.innerHTML = `<div class="marker marker--dot-solid" style="margin-left:${markerInnerSizeMargins}px;margin-top:${markerInnerSizeMargins}px;border:${borderWidth}px solid ${borderColor};border-radius: ${cornerRadius}${cornerRadiusUnits};width:${markerInnerSize}px;height:${markerInnerSize}px;background-color:${marker_dotcenter_color};"></div>`;
            defaultAnchor = 'center';
          } else if ('balloon-default' === markerStyleVal) {
            let styleBalloon = `
                        background-color: ${markerColorBalloon};    
                        border: ${borderWidthBalloon}px solid ${borderColorBalloon};
                        width: ${markerSizeBalloon}px;
                        height: ${markerSizeBalloon}px;`;
            let styleBalloonDot = `
                        width:${dotSize}px;
                        height:${dotSize}px;
                        margin-left:${dotSize / 2 * -1}px;
                        margin-top:${dotSize / 2 * -1}px;
                        background-color:${dotColor};
                        `;
            markerEle.innerHTML = `<div class="treweler-marker marker-balloon" style="${styleBalloon}"><div class="marker-balloon__dot" style="${styleBalloonDot}"></div></div>`;
            defaultAnchor = 'bottom';
          } else if ('triangle-default' === markerStyleVal) {
            const styleTriangle = `
                        
                        border-right-width:${markerWidthTriangle / 2}px;
                        border-left-width:${markerWidthTriangle / 2}px;
                        border-bottom-width: ${markerHeightTriangle}px;
                        border-bottom-color: ${markerColorTriangle};
                        
                        `;
            markerEle.innerHTML = `<div class="treweler-marker marker-triangle" style="${styleTriangle}"></div>`;
            defaultAnchor = 'center';
          }

          marker = new mapboxgl.Marker(markerEle, {
            draggable: true,
            anchor: defaultAnchor
          }).setLngLat([lng, lat]).addTo(map);

          if ('balloon-default' === markerStyleVal) {
            const $marker = document.getElementsByClassName('marker-balloon')[0];
            const rotateHeight = $marker.getBoundingClientRect().height;
            const rotateMarkerSizeBalloon = Number.isNaN(parseFloat($('#treweler-marker-size-balloon').val())) ? 18 : parseFloat($('#treweler-marker-size-balloon').val());
            const rotateBorderWidthBalloon = Number.isNaN(parseFloat($('#treweler-marker-border-width-balloon').val())) ? 4 : parseFloat($('#treweler-marker-border-width-balloon').val());
            $('.marker-balloon').css('bottom', (rotateHeight - (rotateMarkerSizeBalloon + rotateBorderWidthBalloon + rotateBorderWidthBalloon)) / 2);
          }
        } else {
          let imgURL = $('.js-twer-attach-wrap-custom img').attr('src'),
              anchorV = $('#marker_position').val(),
              imgSize = $('#marker_icon_size').val() != '' ? $('#marker_icon_size').val().split(';') : '42;42'.split(';');
          let iHeight = parseInt(imgSize[0]) <= 42 ? parseInt(imgSize[0]) % 2 == 0 ? parseInt(imgSize[0]) : parseInt(imgSize[0]) + 1 : 42;
          let iWidth = parseInt(imgSize[1]) <= 42 ? parseInt(imgSize[1]) % 2 == 0 ? parseInt(imgSize[1]) : parseInt(imgSize[1]) + 1 : 42;
          let markerSizeR = Number.isNaN(parseInt($('#treweler-marker-img-size').val())) ? 42 : parseInt($('#treweler-marker-img-size').val());
          var markerEle = document.createElement('div');
          markerEle.className = 'treweler-marker icon';
          markerEle.style.backgroundImage = 'url(' + imgURL + ')';
          markerEle.style.backgroundSize = 'contain';
          markerEle.style.backgroundRepeat = 'no-repeat';
          markerEle.style.backgroundPosition = 'center center';
          markerEle.style.width = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : parseInt(iWidth) + 'px';
          markerEle.style.height = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : parseInt(iHeight) + 'px';
          marker = new mapboxgl.Marker(markerEle, {
            draggable: true,
            anchor: anchorV
          }).setLngLat([lng, lat]).addTo(map);
        }
        /**
         * Change marker position on drag
         */


        marker.on('dragend', function (e) {
          let ll = marker.getLngLat();
          $('#latitude').val(ll.lat);
          $('#longitude').val(ll.lng);
        });
        /**
         * Change marker position on click
         */

        map.on('click', function (e) {
          marker.setLngLat([e.lngLat.lng, e.lngLat.lat]).addTo(map);
          $('#latitude').val(e.lngLat.lat);
          $('#longitude').val(e.lngLat.lng);
        });
        /**
         * Change zoom value
         */

        map.on('zoom', function (e) {
          let zoomV = map.getZoom().toFixed(2);
          $('#setZoom').val(zoomV);
        });
      } else {
        $('#marker_map').append('<p class="notice notice-error settings-error is-dismissible">Mapbox access token is required.</p>');
      }

      pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
    }
    /**
     * Add HTML Marker
     */


    function addHTMLMarker() {
      let lat = $('#latitude').val().trim() != '' && $('#latitude').val() != 0 ? $('#latitude').val().trim() : 0.1,
          lng = $('#longitude').val().trim() != '' && $('#longitude').val() != 0 ? $('#longitude').val().trim() : 0.1,
          color = $('#markerColor').val(),
          markerStyleVal = $('#marker_style').val(),
          halo_opacity = Number.isNaN(parseFloat($('#treweler-marker-halo-opacity').val())) ? 0.5 : parseFloat($('#treweler-marker-halo-opacity').val()),
          halo_color = hex2rgba($('#marker_halo_color').val(), halo_opacity),
          markerInnerSize = Number.isNaN(parseFloat($('#treweler-marker-size').val())) ? 12 : parseFloat($('#treweler-marker-size').val()),
          borderColor = hex2rgba($('#marker_border_color').val(), 1),
          borderWidth = Number.isNaN(parseFloat($('#treweler-marker-border-width').val())) ? 0 : parseFloat($('#treweler-marker-border-width').val()),
          markerInnerSizeMargins = (markerInnerSize + borderWidth + borderWidth) / 2 * -1,
          cornerRadius = Number.isNaN(parseFloat($('#treweler-marker-corner-radius-group').val())) ? 50 : parseFloat($('#treweler-marker-corner-radius-group').val()),
          marker_dotcenter_color = hex2rgba($('#marker_dotcenter_color').val(), 1),
          cornerRadiusUnits = Number.isNaN($('#treweler-marker-corner-radius-group-select').val()) ? '%' : $('#treweler-marker-corner-radius-group-select').val(),
          markerColorBalloon = hex2rgba($('#marker_color_balloon').val(), 1),
          markerSizeBalloon = Number.isNaN(parseFloat($('#treweler-marker-size-balloon').val())) ? 18 : parseFloat($('#treweler-marker-size-balloon').val()),
          borderColorBalloon = hex2rgba($('#marker_border_color_balloon').val(), 1),
          borderWidthBalloon = Number.isNaN(parseFloat($('#treweler-marker-border-width-balloon').val())) ? 4 : parseFloat($('#treweler-marker-border-width-balloon').val()),
          dotColor = hex2rgba($('#marker_dot_color').val(), 1),
          dotSize = Number.isNaN(parseFloat($('#treweler-marker-dot-size').val())) ? 8 : parseFloat($('#treweler-marker-dot-size').val()),
          markerColorTriangle = hex2rgba($('#marker_color_triangle').val(), 1),
          markerWidthTriangle = Number.isNaN(parseFloat($('#treweler-marker-width-triangle').val())) ? 12 : parseFloat($('#treweler-marker-width-triangle').val()),
          markerHeightTriangle = Number.isNaN(parseFloat($('#treweler-marker-height-triangle').val())) ? 10 : parseFloat($('#treweler-marker-height-triangle').val());
      let defaultAnchor = markerPosition;
      /* remove marker */

      marker.remove();
      /* Add Marker */

      /* MarkerIcon 2 */

      const markerEle = document.createElement('div');
      markerEle.className = 'treweler-marker';

      if ('default' === markerStyleVal) {
        markerEle.innerHTML = '<div class="marker"><div class="marker-wrap"><div class="marker__shadow" style="background-color:' + halo_color + ';"><div class="marker__border" style="border-color:' + color + ';"><div class="marker__center"></div></div></div></div></div>';
      } else if ('dot-default' === markerStyleVal) {
        markerEle.innerHTML = `<div class="marker marker--dot-solid" style="margin-left:${markerInnerSizeMargins}px;margin-top:${markerInnerSizeMargins}px;border:${borderWidth}px solid ${borderColor};border-radius: ${cornerRadius}${cornerRadiusUnits};width:${markerInnerSize}px;height:${markerInnerSize}px;background-color:${marker_dotcenter_color};"></div>`;
        defaultAnchor = 'center';
      } else if ('balloon-default' === markerStyleVal) {
        let styleBalloon = `
                        background-color: ${markerColorBalloon};    
                        border: ${borderWidthBalloon}px solid ${borderColorBalloon};
                        width: ${markerSizeBalloon}px;
                        height: ${markerSizeBalloon}px;`;
        let styleBalloonDot = `
                        width:${dotSize}px;
                        height:${dotSize}px;
                        margin-left:${dotSize / 2 * -1}px;
                        margin-top:${dotSize / 2 * -1}px;
                        background-color:${dotColor};
                        `;
        markerEle.innerHTML = `<div class="treweler-marker marker-balloon" style="${styleBalloon}"><div class="marker-balloon__dot" style="${styleBalloonDot}"></div></div>`;
        defaultAnchor = 'bottom';
      } else if ('triangle-default' === markerStyleVal) {
        const styleTriangle = `
                        
                        border-right-width:${markerWidthTriangle / 2}px;
                        border-left-width:${markerWidthTriangle / 2}px;
                        border-bottom-width: ${markerHeightTriangle}px;
                        border-bottom-color: ${markerColorTriangle};
                        
                        `;
        markerEle.innerHTML = `<div class="treweler-marker marker-triangle" style="${styleTriangle}"></div>`;
        defaultAnchor = 'center';
      }

      marker = new mapboxgl.Marker(markerEle, {
        draggable: true,
        anchor: defaultAnchor
      }).setLngLat([lng, lat]).addTo(map);

      if ('balloon-default' === markerStyleVal) {
        const $marker = document.getElementsByClassName('marker-balloon')[0];
        const rotateHeight = $marker.getBoundingClientRect().height;
        const rotateMarkerSizeBalloon = Number.isNaN(parseFloat($('#treweler-marker-size-balloon').val())) ? 18 : parseFloat($('#treweler-marker-size-balloon').val());
        const rotateBorderWidthBalloon = Number.isNaN(parseFloat($('#treweler-marker-border-width-balloon').val())) ? 4 : parseFloat($('#treweler-marker-border-width-balloon').val());
        $('.marker-balloon').css('bottom', (rotateHeight - (rotateMarkerSizeBalloon + rotateBorderWidthBalloon + rotateBorderWidthBalloon)) / 2);
      }
      /**
       * Change marker position on drag
       */


      marker.on('dragend', function (e) {
        let ll = marker.getLngLat();
        $('#latitude').val(ll.lat);
        $('#longitude').val(ll.lng);
      });
    }

    if ($('#marker_map').length) {
      setTimeout(function () {
        getToken();
      }, 1000);
      /**
       * On change of latlng value
       */

      $('#latitude, #longitude').on('change input', function () {
        if ($('#latitude').val().trim() != '' && $('#longitude').val().trim() != '') {
          marker.setLngLat([$('#longitude').val(), $('#latitude').val()]).addTo(map);
          map.setCenter([$('#longitude').val(), $('#latitude').val()]);
        }
      });
      /**
       * On change of `map`, set `map` style
       */

      let defaultMapStyle = '';
      let defaultMapProjection = '';
      let defaultMapLightPreset = '';
      $('.js-twer-select-2').on('select2:select.bsnselect', function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger('change');
        let styleV = $('#map_id option:selected').toArray().map(item => item.dataset.map_style);
        let mapProjection = $('#map_id option:selected').toArray().map(item => item.dataset.mapProjection);
        let mapLightPreset = $('#map_id option:selected').toArray().map(item => item.dataset.mapLightPreset);

        if (styleV.length <= 0) {
          styleV = ['mapbox://styles/mapbox/standard-beta'];
        }

        if (mapProjection.length <= 0) {
          mapProjection = ['mercator'];
        }

        defaultMapStyle = styleV[0];
        map.setStyle(styleV[0]);
        defaultMapProjection = mapProjection[0];
        map.setProjection(mapProjection[0]);

        if (styleV[0] === 'mapbox://styles/mapbox/standard-beta') {
          map.on('style.load', () => {
            let mapLightPresetString = mapLightPreset[0] ? mapLightPreset[0] : 'day';
            map.setConfigProperty('basemap', 'lightPreset', mapLightPresetString);
          });
        }
      });
      $('.js-twer-select-2').on('change', function () {
        let styleV = $('#map_id option:selected').toArray().map(item => item.dataset.map_style);
        let mapProjection = $('#map_id option:selected').toArray().map(item => item.dataset.mapProjection);
        let mapLightPreset = $('#map_id option:selected').toArray().map(item => item.dataset.mapLightPreset);

        if (styleV.length <= 0) {
          styleV = ['mapbox://styles/mapbox/standard-beta'];
          map.setStyle(styleV[0]);
        }

        if (styleV.length > 0 && !styleV.includes(defaultMapStyle)) {
          defaultMapStyle = styleV[0];
          map.setStyle(defaultMapStyle);
        }

        if (mapProjection.length <= 0) {
          mapProjection = ['mercator'];
          map.setProjection(mapProjection[0]);
        }

        if (mapProjection.length > 0 && !mapProjection.includes(defaultMapProjection)) {
          defaultMapProjection = mapProjection[0];
          map.setProjection(defaultMapProjection);
        }

        if (styleV[0] === 'mapbox://styles/mapbox/standard-beta') {
          map.on('style.load', () => {
            let mapLightPresetString = mapLightPreset[0] ? mapLightPreset[0] : 'day';
            map.setConfigProperty('basemap', 'lightPreset', mapLightPresetString);
          });
        }
      });
      /**
       * Change marker on change of style
       * MarkerIcon 3
       */

      markerStyle.on('change', function () {
        if ($('.js-twer-attach-wrap-custom input[type="hidden"]').val() >= 1) {
          return;
        }

        let lat = $('#latitude').val().trim() != '' && $('#latitude').val() != 0 ? $('#latitude').val().trim() : 0.1,
            lng = $('#longitude').val().trim() != '' && $('#longitude').val() != 0 ? $('#longitude').val().trim() : 0.1,
            color = $('#markerColor').val(),
            halo_opacity = Number.isNaN(parseFloat($('#treweler-marker-halo-opacity').val())) ? 0.5 : parseFloat($('#treweler-marker-halo-opacity').val()),
            halo_color = hex2rgba($('#marker_halo_color').val(), halo_opacity),
            markerInnerSize = Number.isNaN(parseFloat($('#treweler-marker-size').val())) ? 12 : parseFloat($('#treweler-marker-size').val()),
            borderColor = hex2rgba($('#marker_border_color').val(), 1),
            borderWidth = Number.isNaN(parseFloat($('#treweler-marker-border-width').val())) ? 0 : parseFloat($('#treweler-marker-border-width').val()),
            markerInnerSizeMargins = (markerInnerSize + borderWidth + borderWidth) / 2 * -1,
            marker_dotcenter_color = hex2rgba($('#marker_dotcenter_color').val(), 1),
            cornerRadius = Number.isNaN(parseFloat($('#treweler-marker-corner-radius-group').val())) ? 50 : parseFloat($('#treweler-marker-corner-radius-group').val()),
            cornerRadiusUnits = Number.isNaN($('#treweler-marker-corner-radius-group-select').val()) ? '%' : $('#treweler-marker-corner-radius-group-select').val(),
            markerColorBalloon = hex2rgba($('#marker_color_balloon').val(), 1),
            markerSizeBalloon = Number.isNaN(parseFloat($('#treweler-marker-size-balloon').val())) ? 18 : parseFloat($('#treweler-marker-size-balloon').val()),
            borderColorBalloon = hex2rgba($('#marker_border_color_balloon').val(), 1),
            borderWidthBalloon = Number.isNaN(parseFloat($('#treweler-marker-border-width-balloon').val())) ? 4 : parseFloat($('#treweler-marker-border-width-balloon').val()),
            dotColor = hex2rgba($('#marker_dot_color').val(), 1),
            dotSize = Number.isNaN(parseFloat($('#treweler-marker-dot-size').val())) ? 8 : parseFloat($('#treweler-marker-dot-size').val()),
            markerColorTriangle = hex2rgba($('#marker_color_triangle').val(), 1),
            markerWidthTriangle = Number.isNaN(parseFloat($('#treweler-marker-width-triangle').val())) ? 12 : parseFloat($('#treweler-marker-width-triangle').val()),
            markerHeightTriangle = Number.isNaN(parseFloat($('#treweler-marker-height-triangle').val())) ? 10 : parseFloat($('#treweler-marker-height-triangle').val());
        let defaultAnchor = markerPosition;
        marker.remove();
        var markerEle = document.createElement('div');
        let markerSelector = $(this).val();
        markerEle.className = 'treweler-marker';

        if (markerSelector === 'default') {
          markerEle.innerHTML = '<div class="marker"><div class="marker-wrap"><div class="marker__shadow" style="background-color:' + halo_color + ';"><div class="marker__border" style="border-color:' + color + ';"><div class="marker__center"></div></div></div></div></div>';
        } else if ('dot-default' === markerSelector) {
          markerEle.innerHTML = `<div class="marker marker--dot-solid" style="margin-left:${markerInnerSizeMargins}px;margin-top:${markerInnerSizeMargins}px;border:${borderWidth}px solid ${borderColor};border-radius: ${cornerRadius}${cornerRadiusUnits};width:${markerInnerSize}px;height:${markerInnerSize}px;background-color:${marker_dotcenter_color};"></div>`;
          defaultAnchor = 'center';
        } else if ('balloon-default' === markerSelector) {
          let styleBalloon = `
                        background-color: ${markerColorBalloon};    
                        border: ${borderWidthBalloon}px solid ${borderColorBalloon};
                        width: ${markerSizeBalloon}px;
                        height: ${markerSizeBalloon}px;`;
          let styleBalloonDot = `
                        width:${dotSize}px;
                        height:${dotSize}px;
                        margin-left:${dotSize / 2 * -1}px;
                        margin-top:${dotSize / 2 * -1}px;
                        background-color:${dotColor};
                        `;
          markerEle.innerHTML = `<div class="treweler-marker marker-balloon" style="${styleBalloon}"><div class="marker-balloon__dot" style="${styleBalloonDot}"></div></div>`;
          defaultAnchor = 'bottom';
        } else if ('triangle-default' === markerSelector) {
          const styleTriangle = `
                        
                        border-right-width:${markerWidthTriangle / 2}px;
                        border-left-width:${markerWidthTriangle / 2}px;
                        border-bottom-width: ${markerHeightTriangle}px;
                        border-bottom-color: ${markerColorTriangle};
                        
                        `;
          markerEle.innerHTML = `<div class="treweler-marker marker-triangle" style="${styleTriangle}"></div>`;
          defaultAnchor = 'center';
        }

        marker = new mapboxgl.Marker(markerEle, {
          draggable: true,
          anchor: defaultAnchor
        }).setLngLat([lng, lat]).addTo(map);

        if ('balloon-default' === markerSelector) {
          const $marker = document.getElementsByClassName('marker-balloon')[0];
          const rotateHeight = $marker.getBoundingClientRect().height;
          const rotateMarkerSizeBalloon = Number.isNaN(parseFloat($('#treweler-marker-size-balloon').val())) ? 18 : parseFloat($('#treweler-marker-size-balloon').val());
          const rotateBorderWidthBalloon = Number.isNaN(parseFloat($('#treweler-marker-border-width-balloon').val())) ? 4 : parseFloat($('#treweler-marker-border-width-balloon').val());
          $('.marker-balloon').css('bottom', (rotateHeight - (rotateMarkerSizeBalloon + rotateBorderWidthBalloon + rotateBorderWidthBalloon)) / 2);
        }

        marker.on('dragend', function (e) {
          let ll = marker.getLngLat();
          $('#latitude').val(ll.lat);
          $('#longitude').val(ll.lng);
        });
        /*----------------*/

        if (markerSelector === 'custom') {
          let selectedImg = {
            url: $('.js-twer-attach-thumb-custom input[type="hidden"]').val()
          };

          if (selectedImg.url.length > 0) {
            let lat = $('#latitude').val().trim() != '' && $('#latitude').val() != 0 ? $('#latitude').val().trim() : 0.1,
                lng = $('#longitude').val().trim() != '' && $('#longitude').val() != 0 ? $('#longitude').val().trim() : 0.1,
                anchorV = $('#marker_position').val();
            let iHeight = 42,
                iWidth = 42;
            let markerSizeR = Number.isNaN(parseInt($('#treweler-marker-img-size').val())) ? 42 : parseInt($('#treweler-marker-img-size').val());
            /* remove marker */

            marker.remove();
            /* add icon */

            var markerEle = document.createElement('div');
            markerEle.className = 'treweler-marker icon';
            markerEle.style.backgroundImage = 'url(' + selectedImg.url + ')';
            markerEle.style.backgroundSize = 'contain';
            markerEle.style.backgroundRepeat = 'no-repeat';
            markerEle.style.backgroundPosition = 'center center';
            markerEle.style.width = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : iWidth + 'px';
            markerEle.style.height = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : iHeight + 'px';
            marker = new mapboxgl.Marker(markerEle, {
              draggable: true,
              anchor: anchorV
            }).setLngLat([lng, lat]).addTo(map);
            /**
             * Change marker position on drag
             */

            marker.on('dragend', function (e) {
              let ll = marker.getLngLat();
              $('#latitude').val(ll.lat);
              $('#longitude').val(ll.lng);
            }); //$('#marker_icon_size').val(iHeight + ';' + iWidth);
          }
        }
        /*----------------*/


        pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
      });
      const $addAttach = document.querySelectorAll('.js-twer-attach-add-custom');
      const $removeAttach = document.querySelectorAll('.js-twer-attach-remove-custom');
      let xmlFrame; // Click on Upload attach button in metabox

      $addAttach.forEach(element => {
        element.addEventListener('click', event => {
          event.preventDefault();
          const $btn = event.target;

          if (xmlFrame) {
            xmlFrame.open();
            return;
          }

          xmlFrame = wp.media({
            title: 'Select file',
            button: {
              text: 'Upload file'
            },
            library: {
              type: ['image']
            },
            multiple: false
          });
          xmlFrame.on('select', () => {
            var _$attachWrap$getEleme;

            const xmlFrameFile = xmlFrame.state().get('selection').first();
            const xmlUrl = xmlFrameFile.toJSON().url;
            const xmlName = xmlFrameFile.attributes.filename;
            const $attachWrap = $btn.closest('.js-twer-attach-wrap-custom');
            const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb-custom')[0];
            const $img = document.createElement('IMG');
            $img.setAttribute('src', xmlUrl);
            $img.setAttribute('alt', xmlFrameFile.changed.title);
            (_$attachWrap$getEleme = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme === void 0 ? void 0 : _$attachWrap$getEleme.remove();
            $thumbWrap.appendChild($img);

            if (!$btn.classList.contains('button')) {
              $btn.style.display = 'none';
            }

            $thumbWrap.nextElementSibling.style.display = 'block';
            $attachWrap.getElementsByTagName('input')[0].value = xmlUrl;
            let selectedImg = xmlFrame.state().get('selection').first().toJSON();
            /* selectedImg.url */

            let lat = $('#latitude').val().trim() != '' && $('#latitude').val() != 0 ? $('#latitude').val().trim() : 0.1,
                lng = $('#longitude').val().trim() != '' && $('#longitude').val() != 0 ? $('#longitude').val().trim() : 0.1,
                anchorV = $('#marker_position').val();

            if (selectedImg.subtype === 'svg+xml') {
              jQuery.ajax({
                type: 'GET',
                url: selectedImg.url,
                success: function (data) {
                  let svgEle = document.createElement('div');
                  svgEle.innerHTML = new XMLSerializer().serializeToString(data.documentElement);
                  let svgH = parseInt($(svgEle).find('svg').attr('height')),
                      svgW = parseInt($(svgEle).find('svg').attr('width'));
                  let iHeight = svgH <= 42 ? svgH % 2 === 0 ? svgH : svgH + 1 : 42,
                      iWidth = svgW <= 42 ? svgW % 2 === 0 ? svgW : svgW + 1 : 42;
                  let markerSizeR = Number.isNaN(parseInt($('#treweler-marker-img-size').val())) ? 42 : parseInt($('#treweler-marker-img-size').val());
                  /* remove marker */

                  marker.remove();
                  /* add icon */

                  var markerEle = document.createElement('div');
                  markerEle.className = 'treweler-marker icon';
                  markerEle.style.backgroundImage = 'url(' + selectedImg.url + ')';
                  markerEle.style.backgroundSize = 'contain';
                  markerEle.style.backgroundRepeat = 'no-repeat';
                  markerEle.style.backgroundPosition = 'center center';
                  markerEle.style.width = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : iWidth + 'px';
                  markerEle.style.height = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : iHeight + 'px';
                  marker = new mapboxgl.Marker(markerEle, {
                    draggable: true,
                    anchor: anchorV
                  }).setLngLat([lng, lat]).addTo(map);
                  /**
                   * Change marker position on drag
                   */

                  marker.on('dragend', function (e) {
                    let ll = marker.getLngLat();
                    $('#latitude').val(ll.lat);
                    $('#longitude').val(ll.lng);
                  });
                  $('#marker_icon_size').val(iHeight + ';' + iWidth);
                }
              });
            } else {
              let iHeight = selectedImg.height <= 42 ? selectedImg.height % 2 === 0 ? selectedImg.height : selectedImg.height + 1 : 42,
                  iWidth = selectedImg.width <= 42 ? selectedImg.width % 2 === 0 ? selectedImg.width : selectedImg.width + 1 : 42;
              let markerSizeR = Number.isNaN(parseInt($('#treweler-marker-img-size').val())) ? 42 : parseInt($('#treweler-marker-img-size').val());
              /* remove marker */

              marker.remove();
              /* add icon */

              var markerEle = document.createElement('div');
              markerEle.className = 'treweler-marker icon';
              markerEle.style.backgroundImage = 'url(' + selectedImg.url + ')';
              markerEle.style.backgroundSize = 'contain';
              markerEle.style.backgroundRepeat = 'no-repeat';
              markerEle.style.backgroundPosition = 'center center';
              markerEle.style.width = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : iWidth + 'px';
              markerEle.style.height = parseInt(markerSizeR) > 1 ? parseInt(markerSizeR) + 'px' : iHeight + 'px';
              marker = new mapboxgl.Marker(markerEle, {
                draggable: true,
                anchor: anchorV
              }).setLngLat([lng, lat]).addTo(map);
              /**
               * Change marker position on drag
               */

              marker.on('dragend', function (e) {
                let ll = marker.getLngLat();
                $('#latitude').val(ll.lat);
                $('#longitude').val(ll.lng);
              });
              $('#marker_icon_size').val(iHeight + ';' + iWidth);
            }
          });
          xmlFrame.open();
        });
      }); // Click on Remove attach button in metabox

      $removeAttach.forEach(element => {
        element.addEventListener('click', event => {
          var _$attachWrap$getEleme2;

          event.preventDefault();
          const $btn = event.target;
          const $attachWrap = $btn.closest('.js-twer-attach-wrap-custom');
          const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb-custom')[0];
          (_$attachWrap$getEleme2 = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme2 === void 0 ? void 0 : _$attachWrap$getEleme2.remove();
          $attachWrap.getElementsByTagName('input')[0].value = '';
          $btn.closest('.js-twer-attach-actions-custom').style.display = 'none';
          $thumbWrap.getElementsByClassName('js-twer-attach-add-custom')[0].style.display = 'block';
          addHTMLMarker();
          $('#marker_icon_size').val('');
        });
      });
    }

    $('#color-picker-btn, .clr-picker span').on('click', function () {
      let mrkrStyle = $('#marker_style').val();

      if (colorPicker.find('.a-color-picker').length === 0) {
        TWER_HELPERS.AColorPicker.from('.color-picker').on('change', (picker, color) => {
          // Handling Onchange color in editor
          if (['default'].includes(mrkrStyle)) {
            $('.treweler-marker .marker .marker__border').css('border-color', picker.color);
          } else if (['dot-default'].includes(mrkrStyle)) {
            $('.treweler-marker .marker').css('background-color', picker.color);
          }

          $('.clr-picker span').css('background-color', picker.color);
          $('#markerColor').val(picker.color);
          colorPicker.attr('acp-color', picker.color);
        }).on('coloradd', (picker, color) => {
          let cca = $('#addCustomColor');

          if (cca.val().indexOf('|' + color) === -1) {
            cca.val(cca.val() + '|' + color);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: cca.val()
              },
              success: function (response) {
                let eleCP = colorPicker,
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        }).on('colorremove', (picker, color) => {
          let ccr = $('#addCustomColor');

          if (ccr.val().indexOf('|' + color) !== -1) {
            let sc = ccr.val().replace('|' + color, '');
            ccr.val(sc);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: ccr.val()
              },
              success: function (response) {
                let eleCP = colorPicker,
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        });
      } else {
        colorPicker.find('.a-color-picker').remove();
      }
    }); // Universal init color pickers

    $('.js-twer-color-picker').on('click', function (event) {
      event.stopPropagation();
      var $colorPicker = $(this);
      var $colorPickerCell = $colorPicker.children('span');
      var $colorPickerWrap = $colorPicker.closest('.js-twer-color-picker-wrap');
      var $palette = $colorPickerWrap.find('.js-twer-color-picker-palette');
      var $colorInput = $colorPickerWrap.find('input[type="hidden"]');

      if ($palette.find('.a-color-picker').length === 0) {
        TWER_HELPERS.AColorPicker.from($palette[0]).on('change', (picker, color) => {
          $colorPickerCell.css('background-color', picker.color);
          $colorInput.val(picker.color);
          $palette.attr('acp-color', picker.color);

          switch ($colorInput.attr('id')) {
            case 'marker_dotcenter_color':
              $('.marker.marker--dot-solid').css('background-color', hex2rgba(picker.color, 1));
              break;

            case 'marker_halo_color':
              let opacityHalo = $('#treweler-marker-halo-opacity').val();
              opacityHalo = Number.isNaN(parseFloat(opacityHalo)) ? 0.5 : parseFloat(opacityHalo);
              $('.treweler-marker .marker .marker__shadow').css('background-color', hex2rgba(picker.color, opacityHalo));
              break;

            case 'marker_border_color':
              $('.treweler-marker .marker').css('border-color', hex2rgba(picker.color, 1));
              break;

            case 'marker_dot_color':
              $('.treweler-marker.marker-balloon .marker-balloon__dot').css('background-color', hex2rgba(picker.color, 1));
              break;

            case 'marker_color_balloon':
              $('.treweler-marker.marker-balloon').css('background-color', hex2rgba(picker.color, 1));
              break;

            case 'marker_border_color_balloon':
              $('.treweler-marker.marker-balloon').css('border-color', hex2rgba(picker.color, 1));
              break;

            case 'marker_color_triangle':
              $('.treweler-marker.marker-triangle').css('border-bottom-color', hex2rgba(picker.color, 1));
              break;

            case 'balloon_icon_color':
              pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
              break;

            case 'dot_icon_color':
              pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
              break;
          }
        }).on('coloradd', (picker, color) => {
          let cca = $('#addCustomColor');

          if (cca.val().indexOf('|' + color) === -1) {
            cca.val(cca.val() + '|' + color);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: cca.val()
              },
              success: function (response) {
                let defaultCP = $palette.attr('default-palette');
                $palette.attr('acp-palette', defaultCP + '' + response);
                $palette.attr('acp-palette', defaultCP + '' + response);
                colorPicker.attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        }).on('colorremove', (picker, color) => {
          let ccr = $('#addCustomColor');

          if (ccr.val().indexOf('|' + color) !== -1) {
            let sc = ccr.val().replace('|' + color, '');
            ccr.val(sc);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: ccr.val()
              },
              success: function (response) {
                let defaultCP = $palette.attr('default-palette');
                $palette.attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        });
      } else {
        $palette.find('.a-color-picker').remove();
      }
    });
    $('.js-twer-color-picker-palette').on('click', function (event) {
      event.stopPropagation();
    });
    $('#treweler-marker-corner-radius-group-select').on('change', function () {
      let cornerRadiusUnitsSe1 = Number.isNaN(parseFloat($('#treweler-marker-corner-radius-group').val())) ? 50 : parseFloat($('#treweler-marker-corner-radius-group').val());
      const value = Number.isNaN(this.value) ? '%' : this.value;
      $('.treweler-marker .marker').css('borderRadius', `${cornerRadiusUnitsSe1}${value}`);
    });
    $(['#treweler-marker-halo-opacity', '#treweler-marker-size', '#treweler-marker-border-width', '#treweler-marker-corner-radius-group', '#treweler-marker-size-balloon', '#treweler-marker-border-width-balloon', '#treweler-marker-dot-size', '#treweler-marker-width-triangle', '#treweler-marker-height-triangle', '#treweler-balloon-icon-size', '#treweler-dot-icon-size'].join()).on('keyup change', function () {
      let value = $(this).val();
      const $marker = $('.treweler-marker .marker');

      switch (this.id) {
        case 'treweler-balloon-icon-size':
          pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
          break;

        case 'treweler-dot-icon-size':
          pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
          break;

        case 'treweler-marker-width-triangle':
          if ($('.treweler-marker.marker-triangle').length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 12 : parseFloat(value);
            $('.treweler-marker.marker-triangle').css({
              borderRightWidth: `${value / 2}px`,
              borderLeftWidth: `${value / 2}px`
            });
          }

          break;

        case 'treweler-marker-height-triangle':
          if ($('.treweler-marker.marker-triangle').length) {
            value = Number.isNaN(parseFloat(value)) ? 10 : parseFloat(value);
            $('.treweler-marker.marker-triangle').css({
              borderBottomWidth: `${value}px`
            });
          }

          break;

        case 'treweler-marker-size-balloon':
          if ($('.treweler-marker.marker-balloon').length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 18 : parseFloat(value);
            $('.treweler-marker.marker-balloon').css({
              width: `${value}px`,
              height: `${value}px`
            });
            const $marker1 = document.getElementsByClassName('marker-balloon');

            if ($marker1.length > 0) {
              const rotateHeight = $marker1[0].getBoundingClientRect().height;
              const rotateBorderWidthBalloon = Number.isNaN(parseFloat($('#treweler-marker-border-width-balloon').val())) ? 4 : parseFloat($('#treweler-marker-border-width-balloon').val());
              $('.treweler-marker.marker-balloon').css({
                bottom: (rotateHeight - (value + rotateBorderWidthBalloon + rotateBorderWidthBalloon)) / 2
              });
            }
          }

          break;

        case 'treweler-marker-border-width-balloon':
          if ($('.treweler-marker.marker-balloon').length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 4 : parseFloat(value);
            $('.treweler-marker.marker-balloon').css({
              borderWidth: `${value}px`
            });
            const $marker2 = document.getElementsByClassName('marker-balloon');

            if ($marker2.length > 0) {
              const rotateHeight2 = $marker2[0].getBoundingClientRect().height;
              const rotateBorderWidthBalloon2 = Number.isNaN(parseFloat($('#treweler-marker-size-balloon').val())) ? 18 : parseFloat($('#treweler-marker-size-balloon').val());
              $('.treweler-marker.marker-balloon').css({
                bottom: (rotateHeight2 - (rotateBorderWidthBalloon2 + value + value)) / 2
              });
            }
          }

          break;

        case 'treweler-marker-dot-size':
          if ($('.treweler-marker.marker-balloon .marker-balloon__dot').length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 8 : parseFloat(value);
            $('.treweler-marker.marker-balloon .marker-balloon__dot').css({
              width: `${value}px`,
              height: `${value}px`,
              marginLeft: `${value / 2 * -1}px`,
              marginTop: `${value / 2 * -1}px`
            });
          }

          break;

        case 'treweler-marker-halo-opacity':
          if ($('.treweler-marker .marker .marker__shadow').length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 0.5 : parseFloat(value);
            $('.treweler-marker .marker .marker__shadow').css('background-color', hex2rgba($('#marker_halo_color').val(), value));
          }

          break;

        case 'treweler-marker-size':
          if ($marker.length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 12 : parseFloat(value);
            const realBrd = Number.isNaN(parseFloat($('#treweler-marker-border-width').val())) ? 0 : parseFloat($('#treweler-marker-border-width').val());
            $('.treweler-marker .marker.marker--dot-solid').css({
              width: `${value}px`,
              height: `${value}px`,
              marginLeft: `${(value + realBrd + realBrd) / 2 * -1}px`,
              marginTop: `${(value + realBrd + realBrd) / 2 * -1}px`
            });
          }

          break;

        case 'treweler-marker-border-width':
          if ($marker.length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 0 : parseFloat(value);
            const realSize = Number.isNaN(parseFloat($('#treweler-marker-size').val())) ? 12 : parseFloat($('#treweler-marker-size').val());
            $('.treweler-marker .marker.marker--dot-solid').css({
              width: `${realSize}px`,
              height: `${realSize}px`,
              borderWidth: `${value}px`,
              marginLeft: `${(realSize + value + value) / 2 * -1}px`,
              marginTop: `${(realSize + value + value) / 2 * -1}px`
            });
          }

          break;

        case 'treweler-marker-corner-radius-group':
          if ($marker.length > 0) {
            value = Number.isNaN(parseFloat(value)) ? 50 : parseFloat(value);
            let cornerRadiusUnitsSe = Number.isNaN($('#treweler-marker-corner-radius-group-select').val()) ? '%' : $('#treweler-marker-corner-radius-group-select').val();
            $('.treweler-marker .marker.marker--dot-solid').css('borderRadius', `${value}${cornerRadiusUnitsSe}`);
          }

          break;
      }
    });
    $(window).on('click', function () {
      $('.js-twer-color-picker-palette').find('.a-color-picker').remove();
    });
    $(window).on('click', function (event) {
      if (!$(event.target).hasClass('a-color-picker') && $(event.target).parents('.a-color-picker').length === 0 && $(event.target).attr('id') !== 'color-picker-btn' && !$(event.target).hasClass('color-holder') && !$(event.target).hasClass('a-color-picker-palette-color')) {
        colorPicker.find('.a-color-picker').remove();
      }
    });
    $(document).on('change', '#marker_position,#treweler-marker-img-size', function () {
      let imgObj = $('.js-twer-attach-wrap-custom img');

      if (imgObj.length !== undefined && imgObj.length > 0) {
        let lat = $('#latitude').val().trim() !== '' && $('#latitude').val() !== 0 ? $('#latitude').val().trim() : 0.1,
            lng = $('#longitude').val().trim() !== '' && $('#longitude').val() !== 0 ? $('#longitude').val().trim() : 0.1,
            imgURL = $('.js-twer-attach-wrap-custom img').attr('src'),
            anchorV = $('#marker_position').val(),
            markerImgSize = Number.isNaN(parseInt($('#treweler-marker-img-size').val())) ? 42 : parseInt($('#treweler-marker-img-size').val()),
            imgSize = $('#marker_icon_size').val() !== '' ? $('#marker_icon_size').val().split(';') : '42;42'.split(';');
        let iHeight = parseInt(imgSize[0]) <= 42 ? parseInt(imgSize[0]) % 2 === 0 ? parseInt(imgSize[0]) : parseInt(imgSize[0]) + 1 : 42;
        let iWidth = parseInt(imgSize[1]) <= 42 ? parseInt(imgSize[1]) % 2 === 0 ? parseInt(imgSize[1]) : parseInt(imgSize[1]) + 1 : 42;
        /* remove marker */

        marker.remove();
        /* Add Marker */

        var markerEle = document.createElement('div');
        markerEle.className = 'treweler-marker icon';
        markerEle.style.backgroundImage = 'url(' + imgURL + ')';
        markerEle.style.backgroundSize = 'contain';
        markerEle.style.backgroundRepeat = 'no-repeat';
        markerEle.style.backgroundPosition = 'center center';
        markerEle.style.width = parseInt(markerImgSize) > 1 ? parseInt(markerImgSize) + 'px' : parseInt(iWidth) + 'px';
        markerEle.style.height = parseInt(markerImgSize) > 1 ? parseInt(markerImgSize) + 'px' : parseInt(iHeight) + 'px';
        /*	markerEle.style.imageRendering = '-webkit-optimize-contrast'; */

        marker = new mapboxgl.Marker(markerEle, {
          draggable: true,
          anchor: anchorV
        }).setLngLat([lng, lat]).addTo(map);
        /**
         * Change marker position on drag
         */

        marker.on('dragend', function (e) {
          let ll = marker.getLngLat();
          $('#latitude').val(ll.lat);
          $('#longitude').val(ll.lng);
        });
      }
    });
    const $picker = jQuery('#treweler-balloon-icon-picker').fontIconPicker({
      iconGenerator: function (icon) {
        return '<i class="material-icons">' + icon + '</i>';
      }
    });
    $picker.on('change', function () {
      pickerMapApply(['treweler-picker'], ['treweler-balloon-icon-picker'], ['balloon_icon_color'], ['treweler-balloon-icon-size']);
    });
    const xhr = new XMLHttpRequest();
    xhr.open('GET', twer_ajax.fonts_url + 'material-icons.json');
    xhr.send();

    xhr.onload = () => {
      if (xhr.status >= 200 && xhr.status < 300) {
        const icons = xhr.response;

        if (icons) {
          $picker.setIcons(JSON.parse(icons));
        }
      } else {
        console.log(`Error: ${xhr.status}: ${xhr.statusText}`);
      }
    };

    xhr.onerror = () => console.log(xhr.statusText);

    window.TWER_FONTPICKERS = $picker;
    const $picker1 = jQuery('#treweler-dot-icon-picker').fontIconPicker({
      iconGenerator: function (icon) {
        return '<i class="material-icons">' + icon + '</i>';
      }
    });
    $picker1.on('change', function () {
      pickerMapApply(['treweler-picker-dot'], ['treweler-dot-icon-picker'], ['dot_icon_color'], ['treweler-dot-icon-size']);
    });
    const xhr1 = new XMLHttpRequest();
    xhr1.open('GET', twer_ajax.fonts_url + 'material-icons.json');
    xhr1.send();

    xhr1.onload = () => {
      if (xhr1.status >= 200 && xhr1.status < 300) {
        const icons = xhr1.response;

        if (icons) {
          $picker1.setIcons(JSON.parse(icons));
        }
      } else {
        console.log(`Error: ${xhr1.status}: ${xhr1.statusText}`);
      }
    };

    xhr1.onerror = () => console.log(xhr1.statusText);

    window.TWER_FONTPICKERS1 = $picker1;
    let attachPromise;

    function hasAttr($element) {
      var _$element$get;

      let attr = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'data-current';
      return $element === null || $element === void 0 ? void 0 : (_$element$get = $element.get(0)) === null || _$element$get === void 0 ? void 0 : _$element$get.hasAttribute(attr);
    }

    function template_apply(selector, elementType, value, event) {
      const $element = $(selector);

      if ('checkbox' === elementType) {
        if ('reset' === event) {
          value = $element.attr('data-current');
        }

        if ('set' === event) {
          const checkboxVal = $element.is(':checked');
          $element.closest('.twer-switcher').attr('data-default', value);
          $element.closest('.twer-switcher').attr('data-readonly', 'true');

          if (!hasAttr($element.closest('.twer-switcher'))) {
            $element.closest('.twer-switcher').attr('data-current', checkboxVal ? '1' : '0');
          }

          $element.prop('checked', parseInt(value));
        }
      } else if ('colorpicker' === elementType) {
        if ('reset' === event) {
          value = $element.closest('.twer-color-picker-wrap').attr('data-current');
        }

        if ('set' === event) {
          const colorpickerVal = $element.val();

          if (!hasAttr($element.closest('.twer-color-picker-wrap'))) {
            $element.closest('.twer-color-picker-wrap').attr('data-current', colorpickerVal);
          }

          $element.val(value);
          $element.attr('value', value);
          $element.closest('.twer-color-picker-wrap').attr('data-default', value);
          $element.closest('.twer-color-picker-wrap').attr('data-readonly', 'true');
          $element.closest('.twer-color-picker-wrap').find('.color-holder').css('background-color', value);
          $element.closest('.twer-color-picker-wrap').find('.twer-color-picker-palette').attr('acp-color', value);
        }
      } else if ('text' === elementType || 'number' === elementType || 'url' === elementType) {
        if ('reset' === event) {
          value = $element.attr('data-current');
        }

        if ('set' === event) {
          const inputVal = $element.val();

          if (!hasAttr($element)) {
            $element.attr('data-current', inputVal);
          }

          $element.attr('data-default', value);
          $element.val(value);
          $element.attr('value', value);
          $element.attr('data-readonly', 'true');
        }
      } else if ('select' === elementType) {
        if ('reset' === event) {
          value = $element.attr('data-current');
        }

        if ('set' === event) {
          const selectVal = $element.val();

          if (!hasAttr($element)) {
            $element.attr('data-current', selectVal);
          }

          $element.attr('data-default', value);
          $element.val(value);
          $element.attr('data-readonly', 'true');
        }
      } else if ('iconpicker' === elementType) {
        if ('reset' === event) {
          value = $element.attr('data-current');
        }

        if ('set' === event) {
          const iconVal = $element.val();
          $element.prev('.icons-selector').attr('data-readonly', 'true');

          if (!hasAttr($element)) {
            $element.attr('data-current', iconVal);
          }

          $element.attr('data-default', value);
          $element.val(value);
          $element.attr('value', value);

          if ($element.attr('id') === 'treweler-balloon-icon-picker') {
            window.TWER_FONTPICKERS.setIcon(value);
          }

          if ($element.attr('id') === 'treweler-dot-icon-picker') {
            window.TWER_FONTPICKERS1.setIcon(value);
          }
        }
      } else if ('image' === elementType) {
        if ('reset' === event) {
          value = $element.attr('data-current');
        }

        if ('set' === event) {
          const attachVal = $element.val();
          $('.js-twer-attach-remove-custom').trigger('click');
          $element.closest('.js-twer-attach-wrap-custom').attr('data-readonly', 'true');

          if (!hasAttr($element.closest('.js-twer-attach-wrap-custom'))) {
            $element.closest('.js-twer-attach-wrap-custom').attr('data-current', attachVal);
          }

          attachPromise = wp.media.attachment(value).fetch().then(function (data) {
            var _$attachWrap$getEleme3;

            let url = wp.media.attachment(value).get('url');
            $(selector).val(url);
            $(selector).attr('value', url);
            $element.closest('.js-twer-attach-wrap-custom').attr('data-default', url);
            let $attachWrap = $('.js-twer-attach-wrap-custom')[0];
            const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb-custom')[0];
            const $btn = $('.js-twer-attach-add-custom')[0];
            const $img = document.createElement('IMG');
            $img.setAttribute('src', url);
            (_$attachWrap$getEleme3 = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme3 === void 0 ? void 0 : _$attachWrap$getEleme3.remove();
            $thumbWrap.appendChild($img);

            if (!$btn.classList.contains('button')) {
              $btn.style.display = 'none';
            }

            $thumbWrap.nextElementSibling.style.display = 'block';
            $attachWrap.getElementsByTagName('input')[0].value = url;
          });
        }
      } else if ('gallery' === elementType) {
        if ('reset' === event) {
          value = $element.attr('data-current');
        }

        if ('set' === event) {
          const galleryVal = $element.val();

          if (!hasAttr($element.closest('.twer-attach-gallery'))) {
            $element.closest('.twer-attach-gallery').attr('data-current', galleryVal);
          }

          $element.closest('.twer-attach-gallery').attr('data-default', value);
          $element.val(value);
          $element.attr('value', value);
          $element.closest('.twer-attach-gallery').attr('data-readonly', 'true');
          $('.twer-attach-gallery__thumb').remove();

          if ($element.val()) {
            let ids = $element.val().split(',');

            for (let i = 0; i < ids.length; i++) {
              wp.media.attachment(ids[i]).fetch().then(function (data) {
                let url = wp.media.attachment(ids[i]).get('url');
                let $divThumb = document.createElement('div');
                $divThumb.setAttribute('class', 'twer-attach-gallery__thumb');
                $divThumb.setAttribute('data-id', ids[i]);
                let $imgThumb = document.createElement('img');
                $imgThumb.setAttribute('src', url);
                let $close = document.createElement('a');
                $close.setAttribute('href', '#');
                $close.setAttribute('class', 'twer-attach-gallery__remove js-twer-attach-gallery-remove');
                $divThumb.appendChild($imgThumb);
                $divThumb.appendChild($close);
                $('.js-twer-attach-gallery-wrap')[0].insertBefore($divThumb, $('.js-twer-attach-gallery-add')[0]);
              });
            }
          }
        }
      }
    }

    $('.icons-selector').each(function () {
      let readOnly = $(this).next().attr('data-readonly');

      if (typeof readOnly !== 'undefined' && readOnly !== false) {
        $(this).attr('data-readonly', 'true');
      }
    });
    $(document).on('click', '.js-twer-lock-default', function (e) {
      e.preventDefault();
      const $lock = $(this);
      const $lockInput = $(this).find('input');
      const index = $lock.index();
      const lockStatus = $lock.hasClass('twer-lock--open') ? 'open' : 'close';
      let $field = $lock.closest('.twer-wrap-fields').find('.twer-group-elements .row');

      if ($field.length > 0) {
        $field = $field.children().eq(index);
      } else {
        $field = $lock.closest('.twer-wrap-fields');
      }

      if ('open' === lockStatus) {
        $lockInput.attr('value', 'close');
        $lockInput.val('close');
        $lock.removeClass('twer-lock--open');
        const $select = $field.find('select');
        const selectVal = $select.val();
        $select.attr('data-readonly', 'true');
        $select.attr('data-current', selectVal);
        $select.val($select.attr('data-default'));
        $select.trigger('change'); // Checkbox logic

        const $checkboxWrap = $field.find('.twer-switcher');
        const $checkbox = $checkboxWrap.find('input:checkbox');
        const checkboxVal = $checkbox.is(':checked');
        $checkboxWrap.attr('data-readonly', 'true');
        $checkboxWrap.attr('data-current', checkboxVal ? '1' : '0');
        $checkbox.prop('checked', parseInt($checkboxWrap.attr('data-default')));
        $checkbox.trigger('change'); // Icon picker logic

        const $iconsWrap = $field.find('.icons-selector');
        const $iconInput = $iconsWrap.next('input');
        const iconValue = $iconInput.val();
        const iconDefault = $iconInput.attr('data-default');

        if ($iconInput.attr('id') === 'treweler-balloon-icon-picker') {
          window.TWER_FONTPICKERS.setIcon(iconDefault);
        }

        if ($iconInput.attr('id') === 'treweler-dot-icon-picker') {
          window.TWER_FONTPICKERS1.setIcon(iconDefault);
        }

        $iconsWrap.attr('data-readonly', 'true');
        $iconInput.attr('data-readonly', 'true');
        $iconInput.attr('data-current', iconValue); // ColorPicker logic

        const $colorPickerWrap = $field.find('.twer-color-picker-wrap');
        const $colorPickerInput = $colorPickerWrap.find('.input-color-field');
        const colorValue = $colorPickerInput.val();
        const $holder = $colorPickerWrap.find('.color-holder');
        const $palette = $colorPickerWrap.find('.twer-color-picker-palette');
        const colorDefault = $colorPickerWrap.attr('data-default');
        $colorPickerInput.val(colorDefault);
        $colorPickerInput.attr('value', colorDefault);
        $holder.css('background-color', colorDefault);
        $palette.attr('acp-color', colorDefault);
        $colorPickerWrap.attr('data-readonly', 'true');
        $colorPickerWrap.attr('data-current', colorValue); // Text fields logic

        const $input = $field.find('.large-text');
        const inputValue = $input.val();
        const inputDefault = $input.attr('data-default');
        $input.val(inputDefault);
        $input.attr('value', inputDefault);
        $input.attr('data-readonly', 'true');
        $input.attr('data-current', inputValue); // Attach field

        const $attachWrap = $field.find('.twer-attach');
        const $attachInput = $attachWrap.find('input[type="hidden"]');
        const attachValue = $attachInput.val();
        const attachDefault = $attachWrap.attr('data-default');
        $attachInput.val(attachDefault);
        $attachInput.attr('value', attachDefault);
        $attachWrap.attr('data-readonly', 'true');
        $attachWrap.attr('data-current', attachValue);

        if (attachDefault !== attachValue) {
          var _$attachWrap1$getElem;

          $('.js-twer-attach-remove-custom').trigger('click');
          let url = attachDefault;
          let $attachWrap1 = $attachWrap[0];
          const $thumbWrap = $attachWrap1.getElementsByClassName('js-twer-attach-thumb-custom')[0];
          const $btn = $('.js-twer-attach-add-custom')[0];
          const $img = document.createElement('IMG');
          $img.setAttribute('src', url);
          (_$attachWrap1$getElem = $attachWrap1.getElementsByTagName('img')[0]) === null || _$attachWrap1$getElem === void 0 ? void 0 : _$attachWrap1$getElem.remove();
          $thumbWrap.appendChild($img);

          if (!$btn.classList.contains('button')) {
            $btn.style.display = 'none';
          }

          $thumbWrap.nextElementSibling.style.display = 'block';
          $attachWrap1.getElementsByTagName('input')[0].value = url;
        } // Gallery fields


        const $galleryWrap = $field.find('.js-twer-attach-gallery-wrap');
        const $galleryInput = $galleryWrap.find('input[type="hidden"]');
        const galleryValue = $galleryInput.val();
        const galleryDefault = $galleryWrap.attr('data-default');
        $galleryInput.val(galleryDefault);
        $galleryInput.attr('value', galleryDefault);
        $galleryWrap.attr('data-readonly', 'true');
        $galleryWrap.attr('data-current', attachValue);

        if (galleryDefault !== galleryValue) {
          $('.twer-attach-gallery__thumb').remove();

          if ($galleryInput.val()) {
            let ids = $galleryInput.val().split(',');

            for (let i = 0; i < ids.length; i++) {
              wp.media.attachment(ids[i]).fetch().then(function (data) {
                let url = wp.media.attachment(ids[i]).get('url');
                let $divThumb = document.createElement('div');
                $divThumb.setAttribute('class', 'twer-attach-gallery__thumb');
                $divThumb.setAttribute('data-id', ids[i]);
                let $imgThumb = document.createElement('img');
                $imgThumb.setAttribute('src', url);
                let $close = document.createElement('a');
                $close.setAttribute('href', '#');
                $close.setAttribute('class', 'twer-attach-gallery__remove js-twer-attach-gallery-remove');
                $divThumb.appendChild($imgThumb);
                $divThumb.appendChild($close);
                $('.js-twer-attach-gallery-wrap')[0].insertBefore($divThumb, $('.js-twer-attach-gallery-add')[0]);
              });
            }
          }
        }
      }

      if ('close' === lockStatus) {
        $lockInput.attr('value', 'open');
        $lockInput.val('open');
        $lock.addClass('twer-lock--open'); // Select logic

        const $select = $field.find('select');
        const selectVal = $select.val();
        const selectCurrent = $select.attr('data-current');

        if (hasAttr($select)) {
          $select.val(selectCurrent);
        }

        $select.removeAttr('data-readonly');
        $select.attr('data-current', selectVal);
        $select.trigger('change'); // Checkbox logic

        const $checkboxWrap = $field.find('.twer-switcher');
        const $checkbox = $checkboxWrap.find('input:checkbox');
        const checkboxVal = $checkbox.is(':checked');
        const checkboxCurrent = $checkboxWrap.attr('data-current');

        if (hasAttr($checkboxWrap)) {
          $checkbox.prop('checked', parseInt(checkboxCurrent));
        }

        $checkboxWrap.removeAttr('data-readonly');
        $checkboxWrap.attr('data-current', checkboxVal ? '1' : '0');
        $checkbox.trigger('change'); // Icon picker logic

        const $iconsWrap = $field.find('.icons-selector');
        const $iconInput = $iconsWrap.next('input');
        const iconValue = $iconInput.val();
        const iconCurrent = $iconInput.attr('data-current');

        if (hasAttr($iconInput)) {
          $iconInput.val(iconCurrent);
          $iconInput.attr('value', iconCurrent);

          if ($iconInput.attr('id') === 'treweler-balloon-icon-picker') {
            window.TWER_FONTPICKERS.setIcon(iconCurrent);
          }

          if ($iconInput.attr('id') === 'treweler-dot-icon-picker') {
            window.TWER_FONTPICKERS1.setIcon(iconCurrent);
          }
        }

        $iconsWrap.removeAttr('data-readonly');
        $iconInput.removeAttr('data-readonly');
        $iconInput.attr('data-current', iconValue); // ColorPicker logic

        const $colorPickerWrap = $field.find('.twer-color-picker-wrap');
        const $colorPickerInput = $colorPickerWrap.find('.input-color-field');
        const colorValue = $colorPickerInput.val();
        const $holder = $colorPickerWrap.find('.color-holder');
        const $palette = $colorPickerWrap.find('.twer-color-picker-palette');
        const colorCurrent = $colorPickerWrap.attr('data-current');

        if (hasAttr($colorPickerWrap)) {
          $colorPickerInput.val(colorCurrent);
          $colorPickerInput.attr('value', colorCurrent);
          $holder.css('background-color', colorCurrent);
          $palette.attr('acp-color', colorCurrent);
        }

        $colorPickerWrap.removeAttr('data-readonly');
        $colorPickerWrap.attr('data-current', colorValue); // Text fields logic

        const $input = $field.find('.large-text');
        const inputValue = $input.val();
        const inputCurrent = $input.attr('data-current');

        if (hasAttr($input)) {
          $input.val(inputCurrent);
          $input.attr('value', inputCurrent);
        }

        $input.removeAttr('data-readonly');
        $input.attr('data-current', inputValue); // Attach field

        const $attachWrap = $field.find('.twer-attach');
        const $attachInput = $attachWrap.find('input[type="hidden"]');
        const attachValue = $attachInput.val();
        const attachCurrent = $attachWrap.attr('data-current');

        if (hasAttr($attachWrap)) {
          $attachInput.val(attachCurrent);
          $attachInput.attr('value', attachCurrent);
          $attachWrap.find('img').attr('src', attachCurrent);
        }

        $attachWrap.removeAttr('data-readonly');
        $attachWrap.attr('data-current', attachValue); // Gallery fields

        const $galleryWrap = $field.find('.js-twer-attach-gallery-wrap');
        const $galleryInput = $galleryWrap.find('input[type="hidden"]');
        const galleryValue = $galleryInput.val();
        const galleryCurrent = $galleryWrap.attr('data-current');

        if (hasAttr($galleryWrap)) {
          $galleryInput.val(galleryCurrent);
          $galleryInput.attr('value', galleryCurrent);
        }

        $galleryWrap.removeAttr('data-readonly');
        $galleryWrap.attr('data-current', galleryValue);
      }

      $('#marker_style').trigger('change');
    });
    $(document).on('change', '#treweler-templates', function (e) {
      const $thisSelect = $(this);
      const id = $thisSelect.val();
      const templates = twer_ajax.templates;
      let event = 'none' === id ? 'reset' : 'set';
      const $defaultLocks = $('.js-twer-defaults');
      const $cf_wrap = $('.js-ui-slider-wrap');
      const $customFieldsTabs = $('.js-custom-fields-tabs'); // marker has template

      if ('none' !== id) {
        $customFieldsTabs.addClass('d-none');
        $('#twer-nav-custom-fields-wo-template-tab').tab('show');
        document.getElementById('twer-nav-template-tab').classList.add('nav-link--has-icon');
        const templateData = templates[id];
        $defaultLocks.removeClass('d-none');
        $defaultLocks.find('input').val('close');
        $defaultLocks.find('input').attr('value', 'close');
        $defaultLocks.find('a').removeClass('twer-lock--open');
        $cf_wrap.find('.js-custom-fields-list').closest('tr').addClass('d-none');
        $cf_wrap.find('.js-twer-ui-del-tr, .js-twer-ui-sort-tr, .js-twer-ui-disable-tr').addClass('d-none');
        $cf_wrap.find('.twer-defaults').css('right', 0);

        for (const property in templateData) {
          const name = property;
          const value = templateData[property];

          switch (name) {
            case 'balloon_icon_show':
              template_apply('#treweler-picker', 'checkbox', value, event);
              break;

            case 'custom_field_show_locator':
              template_apply('#treweler-custom-field-show-locator', 'checkbox', value, event);
              break;

            case 'custom_field_show_locator_preview':
              template_apply('#treweler-custom-field-show-locator-preview', 'checkbox', value, event);
              break;

            case 'custom_field_show':
              template_apply('#treweler-custom-field-show', 'checkbox', value, event);
              break;

            case 'uniqueTemplateCustomFieldsIds':
              const $wrapper1 = $('#treweler-custom-fields-list-unique').closest('.js-ui-slider-wrap');
              const inputVal = $('#treweler-custom-fields-list-unique').val();

              if (!hasAttr($('#treweler-custom-fields-list-unique'))) {
                $('#treweler-custom-fields-list-unique').attr('data-current', inputVal);
              }

              $('#treweler-custom-fields-list-unique').attr('data-readonly', 'true');
              $wrapper1.find('.js-twer-ui-del-tr').trigger('click');

              if (value.length > 0) {
                let listFields = typeof value === 'string' ? value.split(',') : value;

                for (let i = 0; i < listFields.length; i++) {
                  $wrapper1.find('.js-custom-fields-list').val(listFields[i]);
                  $wrapper1.find('.js-add-custom-field').trigger('click');
                }
              }

              $wrapper1.find('.js-ui-slider-item').each(function () {
                const $lockIU = $(this).find('.js-twer-lock');

                if ($lockIU.hasClass('twer-lock--open')) {
                  $lockIU.trigger('click');
                }
              });
              break;

            case 'custom_marker_cursor':
              template_apply('#marker_cursor', 'select', value, event);
              break;

            case 'custom_marker_position':
              template_apply('#marker_position', 'select', value, event);
              break;

            case 'custom_marker_size':
              template_apply('#treweler-marker-img-size', 'number', value, event);
              break;

            case 'dot_corner_radius':
              template_apply('#treweler-marker-corner-radius-group', 'number', value.size, event);
              template_apply('#treweler-marker-corner-radius-group-select', 'select', value.units, event);
              break;

            case 'dot_icon_show':
              template_apply('#treweler-picker-dot', 'checkbox', value, event);
              break;

            case 'label_description':
              template_apply('#treweler-label-description', 'text', value, event);
              break;

            case 'label_enable':
              template_apply('#treweler-marker-enable-labels', 'checkbox', value, event);
              break;

            case 'label_has_bg':
              template_apply('#treweler-label-has-bg', 'checkbox', value, event);
              break;

            case 'label_border_radius':
              template_apply('#treweler-label-border-radius', 'number', value, event);
              break;

            case 'label_letter_spacing':
              template_apply('#treweler-label-letter-spacing', 'number', value, event);
              break;

            case 'label_line_height':
              template_apply('#treweler-label-line-height', 'number', value, event);
              break;

            case 'label_margin':
              template_apply('#treweler-label-margin', 'number', value, event);
              break;

            case 'label_marker_hide':
              template_apply('#treweler-marker-hide', 'checkbox', value, event);
              break;

            case 'label_position':
              template_apply('#treweler-label-position', 'select', value, event);
              break;

            case 'label_size':
              template_apply('#treweler-label-font-size', 'number', value, event);
              break;

            case 'label_weight':
              template_apply('#treweler-label-font-weight', 'select', value, event);
              break;

            case 'marker_enable_clustering':
              template_apply('#treweler-marker-enable-clustering', 'checkbox', value, event);
              break;

            case 'marker_enable_center_on_click':
              template_apply('#treweler-marker-enable-center-on-click', 'checkbox', value, event);
              break;

            case 'marker_hide_in_locator':
              template_apply('#treweler-marker-hide-in-locator', 'checkbox', value, event);
              break;

            case 'marker_ignore_filters':
              template_apply('#treweler-marker-ignore-filters', 'checkbox', value, event);
              break;

            case 'marker_ignore_radius_filter':
              template_apply('#treweler-marker-ignore-radius-filter', 'checkbox', value, event);
              break;

            case 'marker_open_link_by_click':
              template_apply('#treweler-marker-open-link-by-click', 'checkbox', value, event);
              break;

            case 'marker_click_offset':
              template_apply('#treweler-marker-click-offset-top', 'number', value.top, event);
              template_apply('#treweler-marker-click-offset-bottom', 'number', value.bottom, event);
              template_apply('#treweler-marker-click-offset-left', 'number', value.left, event);
              template_apply('#treweler-marker-click-offset-right', 'number', value.right, event);
              break;

            case 'marker_icon_size':
              template_apply('#marker_icon_size', 'text', value, event);
              break;

            case 'popup_gallery':
              template_apply('#treweler-popup-gallery', 'gallery', value, event);
              break;

            case 'popup_gallery_position':
              template_apply('#treweler-popup-image-position', 'select', value, event);
              break;

            case 'popup_gallery_show':
              template_apply('#treweler-popup-gallery-show', 'checkbox', value, event);
              break;

            case 'popup_gallery_width':
              template_apply('#treweler-popup-image-width', 'number', value, event);
              break;

            case 'popup_heading':
              template_apply('[name="_treweler_popup_heading"]', 'text', value.text, event);
              template_apply('[name="_treweler_popup_heading_size"]', 'number', value.size, event);
              template_apply('[name="_treweler_popup_heading_font_weight"]', 'select', value.weight, event);
              break;

            case 'popup_description':
              template_apply('[name="_treweler_popup_description"]', 'text', value.text, event);
              template_apply('[name="_treweler_popup_description_size"]', 'number', value.size, event);
              template_apply('[name="_treweler_popup_description_font_weight"]', 'select', value.weight, event);
              break;

            case 'popup_subheading':
              template_apply('[name="_treweler_popup_subheading"]', 'text', value.text, event);
              template_apply('[name="_treweler_popup_subheading_size"]', 'number', value.size, event);
              template_apply('[name="_treweler_popup_subheading_font_weight"]', 'select', value.weight, event);
              break;

            case 'popup_button':
              template_apply('#treweler-popup-button-text', 'text', value.text, event);
              template_apply('#treweler-popup-button-url', 'url', value.url, event);
              template_apply('[name="_treweler_popup_button[color]"]', 'colorpicker', value.color, event);
              template_apply('#treweler-popup-button-target', 'checkbox', value.target, event);
              break;

            case 'popup_content_align':
              template_apply('#treweler-popup-content-align', 'select', value, event);
              break;

            case 'popup_open_on':
              template_apply('#treweler-popup-open-group-open-on', 'select', value.action, event);
              template_apply('#treweler-popup-open-group-open-default', 'checkbox', value.default, event);
              break;

            case 'popup_close_button':
              template_apply('#treweler-popup-close-button-style', 'select', value.style, event);
              template_apply('#treweler-popup-close-button-show', 'checkbox', value.show, event);
              break;

            case 'marker_link':
              template_apply('#treweler-marker-link-url', 'text', value.url, event);
              template_apply('#treweler-marker-link-target', 'checkbox', value.target, event);
              break;

            case 'popup_show':
              template_apply('#treweler-popup-show', 'checkbox', value, event);
              break;

            case 'point_halo_opacity':
              template_apply('#treweler-marker-halo-opacity', 'number', value, event);
              break;

            case 'popup_border_radius':
              template_apply('#treweler-popup-border-radius', 'number', value, event);
              break;

            case 'popup_size':
              template_apply('#treweler-popup-size-width', 'number', value.width, event);
              template_apply('#treweler-popup-size-height', 'number', value.height, event);
              break;

            case 'triangle_height':
              template_apply('#treweler-marker-height-triangle', 'number', value, event);
              break;

            case 'triangle_width':
            case 'triangle_size':
              template_apply('#treweler-marker-width-triangle', 'number', value, event);
              break;

            case 'popup_style':
              template_apply('#treweler-popup-style', 'select', value, event);
              break;

            case 'balloon':
              template_apply('#marker_color_balloon', 'colorpicker', value.color, event);
              template_apply('#treweler-marker-size-balloon', 'number', value.size, event);
              break;

            case 'balloon_border':
              template_apply('#marker_border_color_balloon', 'colorpicker', value.color, event);
              template_apply('#treweler-marker-border-width-balloon', 'number', value.size, event);
              break;

            case 'balloon_dot':
              template_apply('#marker_dot_color', 'colorpicker', value.color, event);
              template_apply('#treweler-marker-dot-size', 'number', value.size, event);
              break;

            case 'dot':
              template_apply('#marker_dotcenter_color', 'colorpicker', value.color, event);
              template_apply('#treweler-marker-size', 'number', value.size, event);
              break;

            case 'dot_border':
              template_apply('#marker_border_color', 'colorpicker', value.color, event);
              template_apply('#treweler-marker-border-width', 'number', value.size, event);
              break;

            case 'dot_icon':
              template_apply('#dot_icon_color', 'colorpicker', value.color, event);
              template_apply('#treweler-dot-icon-size', 'number', value.size, event);
              break;

            case 'label_color':
              template_apply('#twer-map-label-font-color', 'colorpicker', value, event);
              break;

            case 'point_color':
              template_apply('#markerColor', 'colorpicker', value, event);
              break;

            case 'point_halo_color':
              template_apply('#marker_halo_color', 'colorpicker', value, event);
              break;

            case 'label_padding':
              template_apply('#treweler-label-padding-top', 'number', value.top, event);
              template_apply('#treweler-label-padding-bottom', 'number', value.bottom, event);
              template_apply('#treweler-label-padding-left', 'number', value.left, event);
              template_apply('#treweler-label-padding-right', 'number', value.right, event);
              break;

            case 'triangle_color':
              template_apply('#marker_color_triangle', 'colorpicker', value, event);
              break;

            case 'balloon_icon':
              template_apply('#balloon_icon_color', 'colorpicker', value.color, event);
              template_apply('#treweler-balloon-icon-size', 'number', value.size, event);
              break;

            case 'balloon_icon_picker':
              template_apply('#treweler-balloon-icon-picker', 'iconpicker', value, event);
              break;

            case 'dot_icon_picker':
              template_apply('#treweler-dot-icon-picker', 'iconpicker', value, event);
              break;

            case 'custom_marker_img':
              template_apply('#thumbnail_id', 'image', value, event);
              break;

            case 'marker_style':
              template_apply('#marker_style', 'select', value, event);
              break;
          }
        }

        if ($('#marker_style').val() === 'custom') {
          attachPromise.then(function () {
            $('#treweler-picker-dot, #treweler-picker, #marker_style, #treweler-popup-image-position, #treweler-popup-open-group-open-on, #treweler-marker-img-size').trigger('change');
          }, function (e) {
            $('#treweler-picker-dot, #treweler-picker, #marker_style, #treweler-popup-image-position, #treweler-popup-open-group-open-on').trigger('change');
          });
        } else {
          $('#treweler-picker-dot, #treweler-picker, #marker_style, #treweler-popup-image-position, #treweler-popup-open-group-open-on').trigger('change');
        }
      } else {
        $customFieldsTabs.removeClass('d-none');
        $('#twer-nav-custom-fields-wo-template-tab').tab('show');
        document.getElementById('twer-nav-template-tab').classList.remove('nav-link--has-icon');
        $defaultLocks.addClass('d-none');
        $defaultLocks.find('input').val('open');
        $defaultLocks.find('input').attr('value', 'open');
        $defaultLocks.find('a').removeClass('twer-lock--close');
        $cf_wrap.find('.js-custom-fields-list').closest('tr').removeClass('d-none');
        $cf_wrap.find('.js-twer-ui-del-tr, .js-twer-ui-sort-tr, .js-twer-ui-disable-tr').removeClass('d-none');
        $cf_wrap.find('.twer-defaults').css('right', '80px');
        $('.js-twer-ui-del-tr').trigger('click');
        $('[data-readonly]').each(function () {
          const $element = $(this);
          $element.removeAttr('data-readonly');
          let current = $element.attr('data-current');

          if (hasAttr($element)) {
            if ($element.hasClass('large-select')) {
              $element.val(current);
            }

            if ($element.hasClass('large-text')) {
              $element.val(current);
              $element.attr('value', current);
            }

            if ($element.hasClass('twer-switcher')) {
              $element.find('input[type="checkbox"]').prop('checked', parseInt(current));
            }

            if ($element.hasClass('twer-color-picker-wrap')) {
              $element.find('.input-color-field').val(current);
              $element.find('.input-color-field').attr('value', current);
              $element.find('.color-holder').css('background-color', current);
              $element.find('.twer-color-picker-palette').attr('acp-color', current);
            }

            if ($element.hasClass('js-twer-custom-fields-list')) {
              if ($element.val()) {
                let listFields = $element.val().split(',');

                for (let i = 0; i < listFields.length; i++) {
                  $element.closest('.js-ui-slider-wrap').find('.js-custom-fields-list').val(listFields[i]);
                  $element.closest('.js-ui-slider-wrap').find('.js-add-custom-field').trigger('click');
                }
              }
            }

            if ($element.hasClass('twer-attach-gallery')) {
              $element.find('input[type="hidden"]').val(current);
              $element.find('input[type="hidden"]').attr('value', current);
              $('.twer-attach-gallery__thumb').remove();

              if (current) {
                let ids = current.split(',');

                for (let i = 0; i < ids.length; i++) {
                  wp.media.attachment(ids[i]).fetch().then(function (data) {
                    let url = wp.media.attachment(ids[i]).get('url');
                    let $divThumb = document.createElement('div');
                    $divThumb.setAttribute('class', 'twer-attach-gallery__thumb');
                    $divThumb.setAttribute('data-id', ids[i]);
                    let $imgThumb = document.createElement('img');
                    $imgThumb.setAttribute('src', url);
                    let $close = document.createElement('a');
                    $close.setAttribute('href', '#');
                    $close.setAttribute('class', 'twer-attach-gallery__remove js-twer-attach-gallery-remove');
                    $divThumb.appendChild($imgThumb);
                    $divThumb.appendChild($close);
                    $('.js-twer-attach-gallery-wrap')[0].insertBefore($divThumb, $('.js-twer-attach-gallery-add')[0]);
                  });
                }
              }
            }

            if ($element.hasClass('js-twer-attach-wrap-custom')) {
              var _$attachWrap$getEleme4;

              $('.js-twer-attach-remove-custom').trigger('click');
              let url = current;
              $element.find('input[type="hidden"]').val(current);
              $element.find('input[type="hidden"]').attr('value', current);
              let $attachWrap = $element[0];
              const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb-custom')[0];
              const $btn = $('.js-twer-attach-add-custom')[0];
              const $img = document.createElement('IMG');
              $img.setAttribute('src', url);
              (_$attachWrap$getEleme4 = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme4 === void 0 ? void 0 : _$attachWrap$getEleme4.remove();
              $thumbWrap.appendChild($img);

              if (!$btn.classList.contains('button')) {
                $btn.style.display = 'none';
              }

              $thumbWrap.nextElementSibling.style.display = 'block';
              $attachWrap.getElementsByTagName('input')[0].value = url;
            }
          }

          $element.removeAttr('data-current');
          $element.removeAttr('data-default');
        });
        $('#treweler-picker-dot, #treweler-picker, #marker_style, #treweler-popup-image-position, #treweler-popup-open-group-open-on, #treweler-marker-img-size').trigger('change');
        setTimeout(function () {
          $('#marker_style').trigger('change');
        }, 500);
      }

      setTimeout(() => {
        toggleNotEditableFieldsNotice();
      }, 600);
    });
  });
})(jQuery);

(function () {
  window.addEventListener('DOMContentLoaded', () => {
    const toggleElements = () => {
      const $toggleElements = document.getElementsByClassName('js-toggle-row');

      if ($toggleElements.length > 0) {
        for (let i = 0; i < $toggleElements.length; i++) {
          const $element = $toggleElements[i];
          let relatedVal = $element.dataset.relatedVal;
          const relatedId = $element.dataset.relatedId;
          let relatedType = undefined;

          if (relatedVal === '1' || relatedVal === '0') {
            relatedType = 'checkbox';
            relatedVal = '1' === relatedVal;
          } else {
            relatedType = 'select';
            relatedVal = relatedVal.split(',');
          }

          const $elementRelated = document.getElementById(relatedId);
          const elementRelatedVal = $elementRelated.value;

          if ($elementRelated.closest('.twer-tr-toggle').classList.contains('d-none')) {
            $element.classList.add('d-none');
          } else {
            if (relatedType === 'select') {
              if (relatedVal.includes(elementRelatedVal)) {
                $element.classList.remove('d-none');
              } else {
                $element.classList.add('d-none');
              }
            } else if (relatedType === 'checkbox') {
              if (relatedVal === $elementRelated.checked) {
                $element.classList.remove('d-none');
              } else {
                $element.classList.add('d-none');
              }
            }
          }
        }
      }
    };

    toggleElements();

    document.getElementById('treweler-marker-open-link-by-click').onchange = function () {
      toggleElements();
    };

    document.getElementById('marker_style').onchange = function () {
      toggleElements();
    };

    document.getElementById('treweler-picker').onchange = function () {
      toggleElements();
      pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
    };

    document.getElementById('treweler-picker-dot').onchange = function () {
      toggleElements();
      pickerMapApply(['treweler-picker', 'treweler-picker-dot'], ['treweler-balloon-icon-picker', 'treweler-dot-icon-picker'], ['balloon_icon_color', 'dot_icon_color'], ['treweler-balloon-icon-size', 'treweler-dot-icon-size']);
    };

    const elementExists = document.getElementById('treweler-label-has-bg') !== null;

    if (elementExists) {
      document.getElementById('treweler-label-has-bg').onchange = function () {
        toggleElements();
      };
    }
  });
  window.addEventListener('load', () => {});
})();
}();
/******/ })()
;