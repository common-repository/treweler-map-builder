<?php
/**
 * Treweler Formatting
 *
 * Functions for formatting data.
 *
 * @package Treweler\Functions
 * @version 1.14
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize phone number.
 * Allows only numbers and "+" (plus sign).
 *
 * @param string $phone Phone number.
 *
 * @return string
 * @since 1.14
 */
function twerSanitizePhoneNumber( string $phone ): string {
	return preg_replace( '/[^\d+]/', '', $phone ?? '' );
}


/**
 * Make a string lowercase.
 * Try to use mb_strtolower() when available.
 *
 * @param string $string String to format.
 *
 * @return string
 * @since 1.14
 */
function twerStrToLower( string $string ) : string {
	$string = $string ?? '';

	return function_exists( 'mb_strtolower' ) ? mb_strtolower( $string ) : strtolower( $string );
}
