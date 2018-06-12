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
    
    public static function get_nav_menu_locations_object() {
        $theme_locations = get_nav_menu_locations();
        $menu_obj = '';
        foreach ( $theme_locations as $theme_location => $value) {
            $menu_obj[] = get_term( $theme_locations[ $theme_location ], 'nav_menu' );
        }
        
        return $menu_obj;
    }
    public static function get_menu_items_object() {
        $menus = self::get_nav_menu_locations_object();
        $menu_items = array();
        
        foreach ( $menus as $menu ) {
            $menu_items[$menu->name] = wp_get_nav_menu_items( $menu->term_id );     
        }
        return $menu_items;
    }
    public static function get_menu_items_id() {
        $menu_items = self::get_menu_items_object();
        $filtered_menu_items = array();
        
        foreach ( $menu_items as $menu_item => $menu_item_value ) {
            foreach ( $menu_item_value as $value ) {
                if ( $menu_item ) {
                    $filtered_menu_items[$menu_item][] = $value->ID;
                }
            }
        }
        return $filtered_menu_items;
    }
    public static function menu_has_icon() {
        $menus = self::get_menu_items_id();
        $has_menu_icon = array();
        
        foreach ( $menus as $menu => $menu_items ) {
            foreach ( $menu_items as $menu_item_id) {
                if ( !empty ( Metabox::get_menu_icon( $menu_item_id ) ) ) {
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
