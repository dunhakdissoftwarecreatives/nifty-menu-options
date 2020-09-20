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
 * Sanitize and return number float value.
 *
 * @param mixed $value The data to Sanitize.
 *
 * @since  1.0.0
 * @return float $sanitized_value Return the sanitized value.
 */
function nifty_menu_options_sanitize_float( $value ) {
	$sanitized_value = '';

	if ( ! empty ( $value ) ) {
		$sanitized_value = filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	}

	return $sanitized_value;
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

/**
 * Filters the icon library and exclude defined icons.
 *
 *	@param array  $default_libraries 	The default icon libraries.
 *	@param string $target_icon_library	The target icon library to filter.
 *	@param array  $icons_to_remove		The icons to remove on the target library.
 *
 * @since  1.0.0
 * @return array $filtered_libraries Return the filtered icon library.
 */
function nifty_menu_options_remove_icons_from_library( $default_libraries, $target_icon_library, $icons_to_remove ) {
	$helper = '';
	$filtered_libraries = array();

	if ( ! empty( $default_libraries ) ) {
		$helper = new DSC\NiftyMenuOptions\Helper();
		if ( ! empty( $target_icon_library ) && ! empty( $icons_to_remove ) ) {
			$filtered_libraries = $helper->remove_icon_from_library( $default_libraries, $target_icon_library, $icons_to_remove );
			return $filtered_libraries;
		} else {
			return $default_libraries;
		}
	}
}

/**
 * Filters the icon library and exclude defined icons.
 *
 * @param array  $default_libraries 	The default icon libraries.
 * @param string $target_icon_library	The target icon library to filter.
 * @param string $target_icon_category The target category to remove on the target library.
 *
 * @since  1.0.0
 * @return array $filtered_libraries Return the filtered icon library.
 */
function nifty_menu_options_remove_icons_by_category_from_library( $default_libraries, $target_icon_library, $target_icon_category ) {
	$helper = '';
	$filtered_libraries = array();

	if ( ! empty( $default_libraries ) ) {
		$helper = new DSC\NiftyMenuOptions\Helper();
		if ( ! empty( $target_icon_library ) && ! empty( $target_icon_category ) ) {
			$filtered_libraries = $helper->remove_icon_by_category_from_library( $default_libraries, $target_icon_library, $target_icon_category );
			return $filtered_libraries;
		} else {
			return $default_libraries;
		}
	}
}

/**
 * Filters the icon library and exclude defined icons category.
 *
 * @param array  $default_libraries 	The default icon libraries.
 * @param string $target_icon_library	The target icon library to filter.
 * @param string $target_icon_categories The target category to remove on the target library.
 *
 * @since  1.0.0
 * @return array $filtered_libraries Return the filtered icon library.
 */
function nifty_menu_options_remove_icons_by_categories_from_library( $default_libraries, $target_icon_library, $target_icon_categories ) {
	$helper = '';
	$filtered_libraries = array();

	if ( ! empty( $default_libraries ) ) {
		$helper = new DSC\NiftyMenuOptions\Helper();
		if ( ! empty( $target_icon_library ) && ! empty( $target_icon_categories ) ) {
			$filtered_libraries = $helper->remove_icon_by_categories_from_library( $default_libraries, $target_icon_library, $target_icon_categories );
			return $filtered_libraries;
		} else {
			return $default_libraries;
		}
	}
}

/**
 * Filters the icon library and exclude defined icons category.
 *
 * @param int    $menu_id       The menu id.
 * @param int    $menu_item_id	The menu item id.
 *
 * @since  1.0.0
 * @return array $get_menu_icon_data Return the menu icon cache data.
 */
function nifty_menu_options_get_data( $menu_id, $menu_item_id ) {
	$helper = '';
	$get_menu_icon_data = array();

	if ( ! empty( $menu_id ) && ! empty( $menu_item_id ) ) {
		$helper = new DSC\NiftyMenuOptions\Helper();
		$get_menu_icon_data = $helper->get_unserialize_nifty_menu_icons( $menu_id );
        if ( ! empty( $get_menu_icon_data[$menu_item_id] ) ) {
		    return $get_menu_icon_data[$menu_item_id];
        }
	}

	return $get_menu_icon_data;
}


add_filter( 'nifty_menu_options_add_icon_library_filter', 'nifty_menu_options_remove_broken_material_icons' );

function nifty_menu_options_remove_broken_material_icons( $default_libraries ) {
	$target_icon_library = 'material_icons';

	$icons_to_remove = array(
		'all_inbox',
		'desktop_access_disabled',
		'battery_20',
		'battery_30',
		'battery_50',
		'battery_60',
		'battery_80',
		'battery_90',
		'battery_charging_20',
		'battery_charging_30',
		'battery_charging_50',
		'battery_charging_60',
		'battery_charging_80',
		'battery_charging_90',
		'signal_cellular_0_bar',
		'signal_cellular_1_bar',
		'signal_cellular_2_bar',
		'signal_cellular_3_bar',
		'signal_cellular_connected_no_internet_0_bar',
		'signal_cellular_connected_no_internet_1_bar',
		'signal_cellular_connected_no_internet_2_bar',
		'signal_cellular_connected_no_internet_3_bar',
		'signal_wifi_0_bar',
		'signal_wifi_1_bar',
		'signal_wifi_1_bar_lock',
		'signal_wifi_2_bar',
		'signal_wifi_2_bar_lock',
		'signal_wifi_3_bar',
		'signal_wifi_3_bar_lock',
		'signal_wifi_4_bar',
		'signal_wifi_4_bar_lock',
		'toggle_off',
		'toggle_on',
	);

	if ( ! empty( $default_libraries ) ) {
		$default_libraries = nifty_menu_options_remove_icons_from_library( $default_libraries, $target_icon_library, $icons_to_remove );
	}

	return $default_libraries;
}
