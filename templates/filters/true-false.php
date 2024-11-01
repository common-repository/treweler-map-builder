<?php
/**
 * Filter: True / False
 * This template can be overridden by copying it to yourtheme/treweler/filters/true-false.php.
 * HOWEVER, on occasion Treweler will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.treweler.com/document/template-structure/
 * @package     Treweler\Templates
 * @version     1.13
 */
?>
  <template id="js-twer-filter-true-false">
      <div class="twer-filter-true-false form-group js-twer-filter-form-true-false">
          <div class="form-row align-items-center">
              <div class="col">
                  <label class="twer-filter-label js-twer-filter-label"></label>
              </div>
              <div class="col-auto d-flex justify-content-end">
                  <div class="custom-control custom-switch custom-switch-fixed">
                      <input type="hidden" class="js-twer-filter-true-false-hidden-checkbox" value="">
                      <input type="checkbox" class="custom-control-input js-twer-filter-true-false-checkbox" value="no">
                      <label class="custom-control-label js-twer-filter-switcher-label"></label>
                  </div>
              </div>
          </div>
      </div>
  </template>
