<?php
/**
 * Plugin Template Tags
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

if (! defined('ABSPATH')) {
    return;
}

/**
 * This function allows you to dump values.
 *
 * @param string $content The content to be displayed.
 * @param string $display_type The display type of the content.
 *
 * @since  1.0.0
 * @return void
 */
function nifty_menu_options_dump( $content, $display_type = '' ) {
	$dump = '';
	if ( ! empty( $content ) ) {
		$dump = new DSC\NiftyMenuOptions\Helper();
		$dump->dump( $content, $display_type );
	}
}

/**
 * This function handle the plugin sanity check.
 *
 * @param mixed $mixed_data The data to check.
 *
 * @since  1.0.0
 * @return mixed $mixed_data Return the sanitize value.
 */
function nifty_menu_options_sanity_check( $mixed_data ) {
	if ( ! empty ( $mixed_data ) ) {
		return $mixed_data;
	}
	return "";
}

/**
 * This function that holds the default color for icon color picker.
 *
 * @since  1.0.0
 * @return string $color Return default color for color picker.
 */
function nifty_menu_options_default_color() {
    $color = apply_filters( 'nifty_menu_options_default_color_picker_color_filter', '#9e9e9e' );

    return $color;
}

/**
 * This function that holds the default min value for position fields.
 *
 * @since  1.0.0
 * @return int $min Return default min value for position fields.
 */
function nifty_menu_options_default_min_position() {
    $min = apply_filters( 'nifty_menu_options_default_min_position_filter', '-200' );

    return $min;
}
