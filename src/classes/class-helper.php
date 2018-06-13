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
	 * Allows you to dump values.
	 *
	 * @param string $content The content to be displayed.
	 * @param string $display_type The display type of the content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dump( $content, $display_type = '' ) {
		if ( ! empty( $content ) ) {
	        if ( empty( $display_type ) ) {
	            $display_type = 'print_r';
	        }
	        echo '<pre class="nifty-dump display-'. esc_attr( $display_type ) .'">';
	            if ( 'echo' === $display_type ) {
	                echo $content;
	            }
	            if ( 'print_r' === $display_type ) {
	                print_r( $content );
	            }
	            if ( 'var_dump' === $display_type ) {
	                var_dump( $content );
	            }
	        echo '</pre>';
	    }
	}

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

				if ( is_numeric( $position ) ) {
					$position = $css_position . ': ' . $position . 'px; ';
				}

				$css .= $position . ' ';
			}
			return $css;
		}
	}

	/**
	 * Get menu assigned on Theme Location.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array $menu_collection Array that contains list of assigned menu on Theme Location.
	 */
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

	/**
	 * Get menu items on assigned menu on Theme Location.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array $menu_items Array that contains list of menu items.
	 */
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

	/**
	 * Get id of menu items.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array $filtered_menu_items Array that contains list of id for each menu items.
	 */
    public static function get_menu_items_id() {
        $menu_items = self::get_menu_items_object();
        $filtered_menu_items = array();
		if ( ! empty ( $menu_items ) ) {
	        foreach ( $menu_items as $menu_item => $menu_item_value ) {

	            foreach ( $menu_item_value as $value ) {
	                if ( $menu_item ) {
	                    $filtered_menu_items[$menu_item][] = $value->ID;
	                }
	            }
	        }
        }
        return $filtered_menu_items;
    }

	/**
	 * Checks if menu item has icons.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return boolean $has_menu_icon Returns true if menu icon has icon otherwise, false.
	 */
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

	/**
	 * Filters the icon library and exclude defined icons.
	 *
	 *	@param array  $default_libraries 	The default icon libraries.
	 *	@param string $target_icon_library	The target icon library to filter.
	 *	@param array  $icons_to_remove		The icons to remove on the target library.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array $default_libraries Return the filtered icon library.
	 */
	public function remove_icon_from_library( $default_libraries, $target_icon_library, $icons_to_remove ) {
		$remove_icons = array();

		// Checks if $default_libraries is empty.
		if ( ! empty( $default_libraries ) ) {
			if ( ! empty( $target_icon_library ) && ! empty( $icons_to_remove ) ) {
				// Set the value for the $remove_icons.
				$remove_icons = array(
					$target_icon_library => $icons_to_remove,
				);
			}

			// Checks if $remove_icons is empty.
			if ( !empty( $remove_icons ) ) {
				foreach ( $remove_icons[ $target_icon_library ] as $remove_icon ) {
					if ( ! empty( $default_libraries[ $target_icon_library ] ) ) {
						// Remove the defined icon from the icon library.
						unset( $default_libraries[ $target_icon_library ][ $remove_icon ] );
					}
				}
			}
		}

		return $default_libraries;
	}
}
