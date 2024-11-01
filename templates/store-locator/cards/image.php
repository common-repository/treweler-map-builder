<?php
/**
 * Extended Store Locator: Card with Image
 * This template can be overridden by copying it to yourtheme/treweler/store-locator/cards/image.php.
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

<template id="js-twer-store-locator-image-card">
    <figure class="twer-store-locator-card twer-store-locator-card--has-media hide js-twer-store-locator-card">
        <button type="button" class="twer-btn-close js-twer-store-locator-card-close"></button>
        <div class="twer-store-locator-card__image">
            <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="js-twer-store-locator-image" alt="">
        </div>
        <figcaption>
            <div class="twer-custom-fields js-twer-store-locator-custom-fields"></div>
        </figcaption>
    </figure>
</template>
