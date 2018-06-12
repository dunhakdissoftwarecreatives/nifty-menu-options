<?php
/**
 * Helper class for the plugin.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Helper
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

namespace DSC\NiftyMenuOptions;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Helper class for the plugin.
 *
 * @category NiftyMenuOptions\Helper
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class Helper {

	/**
	 * Use to get the current selected navigation menu id.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object $nav_menu_selected_id Returns the global $nav_menu_selected_id.
	 */
	public static function global_nav_menu_selected_id() {
		global $nav_menu_selected_id;

		return $nav_menu_selected_id;
	}

	/**
	 * Query the menu icons and cache the icons.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array $array_remap Returns the cache menu icons.
	 */
	public static function get_nifty_menu_icons(){

		global $wpdb;

		$stmt = $wpdb->prepare("SELECT post_id, meta_key, meta_value FROM $wpdb->postmeta WHERE meta_key = %s", Metabox::METAKEY );

		$is_cached = wp_cache_get('nifty_menu_icons');

		$results = array();

		if ( $is_cached ){
			$results = $is_cached;
		} else {
			$results = $wpdb->get_results($stmt, OBJECT);
		}

		wp_cache_set('nifty_menu_icons', $results );

		$array_remap = array();

		foreach($results as $result){
			$array_remap[$result->post_id][] = $result;
		}

		return $array_remap;
	}

	/**
	 * Get the unserialize data of the menu icon.
	 *
	 * @param int $id The menu item id.
	 * @since  1.0.0
	 * @access public
	 * @return array $array_remap Returns the cache menu icons.
	 */
	public static function get_unserialize_nifty_menu_icons( $id ) {
		$icons = self::get_nifty_menu_icons();
		$icon = array();

		if ( ! empty( $icons[$id] ) ) {
			$icon[] = unserialize( $icons[$id][0]->meta_value );
			return $icon[0];
		}
	}

	/**
	 * Get menu item icon position.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $positions      Menu position.
	 * @return string $css			 CSS menu position
	 */
	public static function get_icon_css_position( $positions ) {
		$css_positions 				 = '';
		$css						 = '';

		if ( ! empty( $positions ) ) {
			$css_positions = $positions;
		}

		if ( ! empty( $css_positions ) ) {
			foreach ( $css_positions as $css_position => $position ) {

				if ( is_numeric( $position ) && ! empty( $position ) ) {
					$position = $css_position . ': ' . $position . 'px; ';
				}

				$css .= $position . ' ';
			}
			return $css;
		}
	}

    public static function get_nav_menu_locations_object() {
        $theme_locations = get_nav_menu_locations();
        $menu_collection = array();
		$term = '';

        foreach ( $theme_locations as $theme_location => $value) {
			$term = get_term( $theme_locations[ $theme_location ], 'nav_menu' );

			if  ( ! is_wp_error( $term ) ) {
				if ( ! empty(  $term ) ) {
					$menu_collection[] = $term;
				}
			}

        }
        return $menu_collection;
    }
    public static function get_menu_items_object() {
        $menus = self::get_nav_menu_locations_object();
        $menu_items = array();

		if ( ! empty ( $menus ) ) {
			foreach ( $menus as $menu ) {
				if  ( ! is_wp_error( $menu ) && ! empty($menu) ) {
					$menu_items[$menu->name] = wp_get_nav_menu_items( $menu->term_id );
				}
			}
		}
        return $menu_items;
    }
    public static function get_menu_items_id() {
        $menu_items = self::get_menu_items_object();
        $filtered_menu_items = array();
		if ( ! empty ( $menu_items ) ) {
	        foreach ( $menu_items as $menu_item => $menu_item_value ) {
				// niftyDump($menu_item_value);
	            foreach ( $menu_item_value as $value ) {
	                if ( $menu_item ) {
	                    $filtered_menu_items[$menu_item][] = $value->ID;
	                }
	            }
	        }
        }
        return $filtered_menu_items;
    }

    public static function menu_has_icon() {
        $menus = self::get_menu_items_id();
        $menu_icon = array();
        $has_menu_icon = array();

        foreach ( $menus as $menu => $menu_items ) {
            foreach ( $menu_items as $menu_item_id) {

				// Get the unserialize menu icon value.
				$menu_icon = self::get_unserialize_nifty_menu_icons( $menu_item_id );

                if ( !empty ( $menu_icon['icon_name'] ) ) {
                   $has_menu_icon[$menu] = true;
                }
            }
        }

        $has_menu_icon = array_unique($has_menu_icon);

        if ( in_array( true, $has_menu_icon ) ) {
            return $has_menu_icon;
        }
        return false;
    }
}
