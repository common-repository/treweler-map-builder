<?php
/**
 * Filter: Range Number
 * This template can be overridden by copying it to yourtheme/treweler/filters/range.php.
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
  <template id="js-twer-filter-range">
      <div class="twer-filter-range form-group js-twer-filter-form-range">
          <label class="twer-filter-label js-twer-filter-label"></label>
          <div class="js-twer-slider"></div>
          <div class="form-row">
              <div class="col-5">
                  <div class="input-group input-group-sm input-group-merged input-group-merged-append">
                      <div class="input-group-prepend"><span class="input-group-text js-twer-filter-prefix"></span></div>
                      <input type="number" class="form-control js-twer-filter-range-value-start">
                      <div class="input-group-append"><span class="input-group-text js-twer-filter-suffix"></span></div>
                  </div>
              </div>
              <div class="col d-flex align-items-center justify-content-center"><div class="twer-filter-range__divider"></div></div>
              <div class="col-5">
                  <div class="input-group input-group-sm input-group-merged input-group-merged-append">
                      <div class="input-group-prepend"><span class="input-group-text js-twer-filter-prefix"></span></div>
                      <input type="number" class="form-control js-twer-filter-range-value-end">
                      <div class="input-group-append"><span class="input-group-text js-twer-filter-suffix"></span></div>
                  </div>
              </div>
          </div>
      </div>
  </template>
