<?php
/**
 * Treweler Conditional Functions
 * Functions for determining the current query/page.
 *
 * @package     Treweler\Functions
 * @version     1.13
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if the current theme has Treweler support or is a FSE theme.
 *
 * @return bool
 * @since x.x.x
 */
function twer_current_theme_supports_treweler_or_fse() {
	return (bool) current_theme_supports( 'treweler' ) || twer_current_theme_is_fse_theme();
}

/**
 * Check if the home URL is https. If it is, we don't need to do things such as 'force ssl'.
 *
 * @return bool
 * @since  1.13
 */
function twer_site_is_https() {
	return false !== strstr( get_option( 'home' ), 'https:' );
}


/**
 * Check if the current theme is a block theme.
 *
 * @return bool
 * @since x.x.x
 */
function twer_current_theme_is_fse_theme() {
	if ( function_exists( 'wp_is_block_theme' ) ) {
		return (bool) wp_is_block_theme();
	}
	if ( function_exists( 'gutenberg_is_fse_theme' ) ) {
		return (bool) gutenberg_is_fse_theme();
	}

	return false;
}


function twerStoreLocatorIsEnable( $mapId = null ) {
	if ( empty( $mapId ) ) {
		$mapId = twer_get_map_id();
	}
	$storeLocatorEnable = get_post_meta( $mapId, '_treweler_store_locator', true );

	return (bool) $storeLocatorEnable;
}


function twerStoreLocatorIsExtended( $mapId = null ) {
	if ( empty( $mapId ) ) {
		$mapId = twer_get_map_id();
	}

	return twerStoreLocatorIsEnable( $mapId ) && 'extended' === twerGetStoreLocatorType( $mapId );
}


function twerCustomFieldsIsExist(): bool {
	return ! empty( twerGetAllPublishedCustomFields() );
}

function twerStoreLocatorFiltersIsAvailable( $mapId = null ) {
	if ( empty( $mapId ) ) {
		$mapId = twer_get_map_id();
	}

	$storeLocatorFilters = get_post_meta( $mapId, '_treweler_store_locator_filters', true );

	return 'no' !== $storeLocatorFilters && twerStoreLocatorIsExtended( $mapId ) && twerGetStoreLocatorFiltersForMap( $mapId );
}


function twerIsCustomFieldTextShowAsTitle( int $fieldId ): string {
	$result = 'no';
	if ( 'text' === twerGetCustomFieldType( $fieldId ) ) {
		$customField = twerGetCustomFieldPost( $fieldId );
		$result      = $customField['outputAsTitle'];
	}

	return $result;
}

if ( ! function_exists( 'twerIsEnableDirections' ) ) {
	/**
	 * Checks if Directions API Enable in Map Settings
	 * Also check global constant for quick shutdown
	 *
	 * @param int $mapId
	 *
	 * @return string
	 */
	function twerIsEnableDirections( int $mapId ): string {
		return 'yes' === twerGetNormalMetaCheckboxValue( get_post_meta( $mapId, TWER_META_PREFIX . 'enable_directions', true ) ) && twerIsHasDirectionsFeature();
	}
}

if ( ! function_exists( 'twerIsEnableGeolocation' ) ) {
	/**
	 * Checks if "Use user's current location" switcher is Enable or Enable Mapbox "Geolocation" control in Map Settings
	 *
	 * @param int $mapId
	 *
	 * @return string
	 */
	function twerIsEnableGeolocation( int $mapId ): string {
		$meta_data = twer_get_data( $mapId );

		$geoPositionValue = isset( $meta_data->map_initial_point['geoposition'] ) ? $meta_data->map_initial_point['geoposition'] : '';

		if ( is_array( $geoPositionValue ) ) {
			$geoPositionValue = reset( $geoPositionValue );
		}


		$geolocate = false;

		if ( isset( $meta_data->map_controls['geolocate'] ) ) {
			$geolocate = in_array( 'geolocate', (array) $meta_data->map_controls['geolocate'] ) ? true : false;
		}

		return ! empty( $geoPositionValue ) || ! empty( $geolocate ) ? 'yes' : 'no';
	}
}


if ( ! function_exists( 'twerIsEnableStoreLocator' ) ) {
	/**
	 * Checks if Store Locator API Enable in Map Settings
	 *
	 * @param int $mapId
	 *
	 * @return string
	 */
	function twerIsEnableStoreLocator( int $mapId ): string {
		return 'yes' === twerGetNormalMetaCheckboxValue( get_post_meta( $mapId, TWER_META_PREFIX . 'store_locator', true ) );
	}
}


function twerIsHasDirectionsFeature() {
	return apply_filters( 'twerHasDirectionsFeature', false );
}


function twerIsHasImportFeature() {
	return apply_filters( 'twerHasImportFeature', true );
}

if ( ! function_exists( 'twerIsStoreLocatorSidebarCloseByDefault' ) ) {
	/**
	 * Check if the Store Locator sidebar is closed by default for a given map.
	 *
	 * @param int $mapId
	 *
	 * @return bool
	 * @since 1.14
	 * @uses twer_get_map_id() To get the current map ID if not provided.
	 * @uses twerGetNormalMetaCheckboxValue() To normalize the checkbox meta value.
	 * @uses twer_get_meta() To get meta data for the map post.
	 */
	function twerIsStoreLocatorSidebarCloseByDefault( int $mapId = 0 ): bool {
		$mapId     = empty( $mapId ) ? twer_get_map_id() : $mapId;
		$metaValue = twer_get_meta( 'store_locator_close', $mapId );

		return 'yes' === twerGetNormalMetaCheckboxValue( $metaValue );
	}
}


if ( ! function_exists( 'twerIsUploadsFileExist' ) ) {
	/**
	 * Checks if an uploaded file exists.
	 * This function verifies whether a file exists in the WordPress upload directory,
	 * based on a given path. It can accept different types of path formats and normalizes
	 * them to check for the file's existence.
	 *
	 * @param string $path The path to the file to be checked. Examples of path:
	 *                       - 'https://example.com/wp-content/uploads/1993/07/scrubs.png'
	 *                       - 'uploads/1993/07/scrubs.png'
	 *                       - '/uploads/1993/07/scrubs.png'
	 *                       - 'example.com/wp-content/uploads/1993/07/scrubs.png'
	 *                       - 'www.example.com/wp-content/uploads/1993/07/scrubs.png'
	 *
	 * @return bool         True if the file exists, False otherwise.
	 * @author Aisconverse
	 * @version 1.14
	 */
	function twerIsUploadsFileExist( string $path ): bool {
		if ( empty( $path ) ) {
			return false;
		}

		return file_exists( twerGetAbsPathForUploadsFile($path) );
	}
}

if ( ! function_exists( 'twerIsMaybeRegex' ) ) {
	/**
	 * Check if the given string could potentially be a valid regular expression.
	 *
	 * @param string $string The string to check.
	 *
	 * @return bool True if the string is potentially a regex, false otherwise.
	 */
	function twerIsMaybeRegex( string $string ): bool {
		// Try to use the string as a regex pattern with preg_match
		// If it doesn't produce any warnings, it's potentially a valid regex
		return @preg_match( $string, '' ) !== false;
	}
}
