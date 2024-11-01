<?php
/**
 * Extended Store Locator: Section Panel
 * This template can be overridden by copying it to yourtheme/treweler/store-locator/section.php.
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

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
?>

<?php if('middle' === twerGetStoreLocatorSidebarOpenButtonPosition()) { ?>
    <button type="button" class="twer-store-locator-panel-btn-toggle <?php printf('twer-store-locator-panel-btn-toggle--%s', twerStoreLocatorGetSidebarPosition()); ?>" id="js-twer-store-locator-panel-btn-open"></button>
<?php } ?>

<aside <?php twerStoreLocatorSidebarClass(); ?> id="js-twer-store-locator-panel">
    <div class="twer-store-locator-panel__container">
        <div class="twer-store-locator-preloader" id="js-twer-store-locator-preloader"><div class="twer-store-locator-preloader__icon"></div></div>
        <div class="twer-store-locator-panel__overlap hide" id="js-twer-store-locator-card-detail-area"></div>
        <div class="twer-store-locator-panel__header" id="js-twer-store-locator-header">
            <div class="mapboxgl-control-container">
                <div class="mapboxgl-ctrl-top-left">
                    <div id="js-twer-extended-store-locator"></div>
                </div>
            </div>
        </div>
        <div class="twer-store-locator-panel__body" id="js-twer-store-locator-cards-area">
            <button type="button" class="twer-store-locator-panel-btn-toggle twer-store-locator-panel-btn-toggle--simple <?php printf('twer-store-locator-panel-btn-toggle--simple--%s', twerStoreLocatorGetSidebarPosition()); ?>" id="js-twer-store-locator-panel-btn-close"></button>
          <?php
          /**
           * twer_extended_store_locator_body hook.
           *
           * @hooked twer_output_store_locator_no_results_message - 10 (outputs no results message)
           */
          do_action( 'twer_extended_store_locator_body' );
          ?>
        </div>
        <section class="twer-store-locator-panel__filters <?php echo twerGetFiltersShowType() !== 'details' ? 'hide' : ''; ?>" id="js-twer-store-locator-filters-area">
            <form action="/" method="post" class="twer-filters" id="js-twer-filters-form">
                <header class="twer-filters__header <?php echo twerGetFiltersShowType() === 'details' ? 'hide' : ''; ?>" id="js-twer-filters-header">
                    <button type="button" class="twer-btn-close" id="js-twer-filters-close"></button>
                </header>
                <div class="twer-filters__body" id="js-twer-filters">
                    <div class="twer-store-locator-no-results-message p-0 pt-4">
                        <div class="twer-store-locator-no-results-message__title m-0"><?php echo esc_html__( 'Filters not found', 'treweler' ); ?></div>
                    </div>
                </div>
                <footer class="twer-filters__footer">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-black btn-sm" id="js-twer-filters-reset"><?php _e( 'Clear All', 'treweler' ); ?></button>
                        </div>
                        <div class="col-6 d-flex align-items-center justify-content-end">
                          <div class="twer-filters-results"><span id="js-twer-filter-results-counter">0</span>&nbsp;<?php _e( 'Results Found', 'treweler' ); ?></div>
                        </div>
                    </div>
                </footer>
            </form>
        </section>
    </div>
</aside>
