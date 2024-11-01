<?php
/**
 * Extended Store Locator: No Results Message Panel
 * This template can be overridden by copying it to yourtheme/treweler/store-locator/no-results-message.php.
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


<div class="twer-store-locator-no-results-message" id="js-twer-store-locator-no-results-message">
    <img alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzEiIGhlaWdodD0iMzEiIHZpZXdCb3g9IjAgMCAzMSAzMSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3QgeD0iMC41IiB5PSIwLjUiIHdpZHRoPSIyOC4wMjc4IiBoZWlnaHQ9IjI4LjAyNzgiIHJ4PSIxNC4wMTM5IiBzdHJva2U9ImJsYWNrIi8+CjxwYXRoIGQ9Ik0yNS40MjI5IDI0LjcxNTlMMjUuMDY5MyAyNC4zNjI0TDI0LjM2MjIgMjUuMDY5NUwyNC43MTU4IDI1LjQyM0wyNS40MjI5IDI0LjcxNTlaTTI5LjY0NjMgMzAuMzUzNkMyOS44NDE2IDMwLjU0ODggMzAuMTU4MiAzMC41NDg4IDMwLjM1MzQgMzAuMzUzNkMzMC41NDg3IDMwLjE1ODMgMzAuNTQ4NyAyOS44NDE3IDMwLjM1MzQgMjkuNjQ2NUwyOS42NDYzIDMwLjM1MzZaTTI0LjcxNTggMjUuNDIzTDI5LjY0NjMgMzAuMzUzNkwzMC4zNTM0IDI5LjY0NjVMMjUuNDIyOSAyNC43MTU5TDI0LjcxNTggMjUuNDIzWiIgZmlsbD0iYmxhY2siLz4KPHBhdGggZD0iTTkuNzc3ODMgOS43Nzc4M0wxOS41NTU2IDE5LjU1NTYiIHN0cm9rZT0iYmxhY2siIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTkuNTU1NiA5Ljc3NzgzTDkuNzc3ODMgMTkuNTU1NiIgc3Ryb2tlPSJibGFjayIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+Cjwvc3ZnPgo="/>
    <div class="twer-store-locator-no-results-message__title"><?php echo esc_html__( 'No Results Found', 'treweler' ); ?></div>
    <div class="twer-store-locator-no-results-message__description">
        <p><?php echo esc_html__( 'Try adjusting your search radius or changing or removing some of your filters.', 'treweler' ); ?></p>
    </div>
</div>

