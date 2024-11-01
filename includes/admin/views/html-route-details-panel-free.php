<?php
/**
 * Route GPX upload settings meta box.
 *
 * @package Treweler/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
$post_id   = isset( $post->ID ) ? $post->ID : '';

$meta_data = twer_get_data( $post_id );

$cust = get_post_meta( $post_id );

$routeLineWidth   = ( isset( $cust["_treweler_route_line_width"] ) && trim( $cust["_treweler_route_line_width"][0] ) != "" ) ? $cust["_treweler_route_line_width"][0] : '';
$routeLineOpacity = ( isset( $cust["_treweler_route_line_opacity"] ) && trim( $cust["_treweler_route_line_opacity"][0] ) != "" ) ? $cust["_treweler_route_line_opacity"][0] : '';
$routeLineDash    = ( isset( $cust["_treweler_route_line_dash"] ) && trim( $cust["_treweler_route_line_dash"][0] ) != "" ) ? $cust["_treweler_route_line_dash"][0] : '';
$routeLineGap     = ( isset( $cust["_treweler_route_line_gap"] ) && trim( $cust["_treweler_route_line_gap"][0] ) != "" ) ? $cust["_treweler_route_line_gap"][0] : '';

$route_latlng   = isset( $cust["_treweler_route_map_latlng"] ) ? $cust["_treweler_route_map_latlng"][0] : '{0.1,0.1}';
$route_zoom     = isset( $cust["_treweler_route_map_zoom"] ) ? $cust["_treweler_route_map_zoom"][0] : 0;
$route_color    = isset( $cust["_treweler_route_line_color"] ) ? $cust["_treweler_route_line_color"][0] : '#438EE4';
$route_coords   = isset( $cust["_treweler_route_line_coords"] ) ? $cust["_treweler_route_line_coords"][0] : '';
$route_gpx      = isset( $cust["_treweler_route_gpx_file"] ) ? $cust["_treweler_route_gpx_file"][0] : '';
$route_gpx_name = isset( $cust["_treweler_route_gpx_file_name"] ) ? $cust["_treweler_route_gpx_file_name"][0] : '';

$custom_color  = get_option( 'treweler_mapbox_colorpicker_custom_color' );
$defaultColors = "#F44336|#EC407A|#E046C6|#B94AEF|#8559FF|#317DFC|#426D7E|#027F71|#008A43|#238C28|#4B7715|#756B11|#C06018|#9B5A45|#505050|#00B0F6|#00C5AF|#00BC5B|#18AF1F|#5DA900|#A19100|#FF7814|#FF5D28|#FFFFFF|#000000|";

?>
<div class="twer-root">
    <div class="twer-settings">
        <div class="twer-settings__body">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-2 pr-md-0" style="padding-left: 15px;">
                        <nav class="twer-tabs">
                            <div class="nav nav-tabs" id="twer-nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="twer-nav-route-style-tab" data-toggle="tab"
                                   href="#twer-nav-route-style" role="tab" aria-controls="twer-nav-route-style"
                                   aria-selected="true"><?php echo esc_html__( 'Styles', 'treweler' ); ?></a>
                                <a class="nav-item nav-link twer-is-pro-field" id="twer-nav-route-gpx-tab" data-toggle="tab"
                                   href="#twer-nav-route-gpx" role="tab" aria-controls="twer-nav-route-gpx"
                                   aria-selected="true"><?php echo esc_html__( 'Import GPX', 'treweler' ); ?></a>
                            </div>
                        </nav>
                    </div>
                    <div class="col-md-9 col-lg-9 col-xl-10 pl-md-0" style="padding-right: 15px;">
                        <div class="tab-content" id="twer-Nav-tabContent">

                            <!-- Styles -->
                            <div class="tab-pane tab-style fade show active" id="twer-nav-route-style" role="tabpanel"
                                 aria-labelledby="twer-nav-popup-tab">
                                <div class="table-responsive">
                                    <table class="table twer-table twer-table--cells-3">
                                        <tbody>
                                        <tr class="twer-tr-route-styles">
                                            <th class="th-treweler-popup-heading">
                                                <label for="treweler-popup-heading"><?php echo esc_html__( "Route line color",
														'treweler' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="twer-color-picker-wrap">
                                                    <div class="clr-picker">
                                                        <span class="color-holder"
                                                              style="background-color:<?php echo esc_attr( $route_color ); ?>;"></span>
                                                        <input type="button" id="color-picker-btn"
                                                               value="<?php echo esc_attr__( 'Select Color',
															       'treweler' ); ?>">
                                                    </div>
                                                    <div class="color-picker"
                                                         acp-color="<?php echo esc_attr( $route_color ); ?>"
                                                         acp-palette="<?php echo esc_attr( $defaultColors . $custom_color ); ?>"
                                                         default-palette="<?php echo esc_attr( $defaultColors ); ?>"
                                                         acp-show-rgb="no"
                                                         acp-show-hsl="no"
                                                         acp-palette-editable>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="twer-tr-route-styles">
                                            <th class="th-treweler-popup-heading">
                                                <label for="treweler-popup-heading"><?php echo esc_html__( "Route Line Width",
														'treweler' ); ?></label>
                                            </th>
                                            <td>
                                                <div class="twer-form-group twer-form-group--text twer-form-group--small twer-form-group--append width-130">
                                                    <input type="text" name="_treweler_route_line_width"
                                                           id="route_line_width" class="large-text"
                                                           value="<?php echo esc_attr( $routeLineWidth ); ?>"
                                                           placeholder="3">
                                                    <div class="twer-form-group-append"><span
                                                                class="twer-form-group-append__text">px</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="twer-tr-route-styles">
                                            <th class="th-treweler-popup-heading">
                                                <label for="treweler-popup-heading">
													<?php echo esc_html__( "Route line opacity", 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <div class="twer-text-fields">
                                                    <input type="text" name="_treweler_route_line_opacity"
                                                           id="route_line_opacity" class="large-text width-130"
                                                           value="<?php echo esc_attr( $routeLineOpacity ); ?>" placeholder="1">
                                                    <a href="#" class="twer-help-tooltip" data-toggle="tooltip"
                                                       title="<?php echo esc_html__( 'Value between 0 and 1 (Example 0.8)',
														   'treweler' ); ?>">
                                                        <span class="dashicons dashicons-editor-help"></span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr class="twer-tr-route-styles">
                                            <th class="th-treweler-popup-heading">
                                                <label for="treweler-popup-heading">
													<?php echo esc_html__( "Dash and gap", 'treweler' ); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <div class="twer-text-fields" style="width: 290px">
                                                    <input type="text" name="_treweler_route_line_dash"
                                                           id="route_line_dash" class="half-text alignleft width-130"
                                                           value="<?php echo esc_attr( $routeLineDash ); ?>"
                                                           placeholder="<?php echo esc_attr__( '1',
														       'treweler' ); ?>">
                                                    <input type="text" name="_treweler_route_line_gap"
                                                           id="route_line_gap" class="half-text alignright width-130"
                                                           value="<?php echo esc_attr( $routeLineGap ); ?>"
                                                           placeholder="<?php echo esc_attr__( '0', 'treweler' ); ?>">
                                                </div>
                                            </td>
                                        </tr>


                                        </tbody>


                                    </table>
                                </div>
                            </div>
                            <!-- End of Styles -->


                            <!-- GPX -->
                            <div class="tab-pane fade" style="position: relative;" id="twer-nav-route-gpx" role="tabpanel" aria-labelledby="twer-nav-popup-tab"><?php twerGoToProNotice(); ?></div>
                            <!-- End of GPX -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

