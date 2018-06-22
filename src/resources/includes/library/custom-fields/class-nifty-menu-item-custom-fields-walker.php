<?php
/**
 * Custom Walker Class for Menu Editor
 *
 * The Walker_Nav_Menu_Edit Class of WordPress is loaded only
 * on the wp-admin/nav-menus.php page. You need to separate it
 * to create and extend the Walker class.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Nifty_Menu_Item_Custom_Fields_Walker
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
 * The class that handles Menu Icon picker.
 *
 * @category NiftyMenuOptions\Nifty_Menu_Item_Custom_Fields_Walker
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
class Nifty_Menu_Item_Custom_Fields_Walker extends \Walker_Nav_Menu_Edit {


	/**
	 * Initialize the output of the element.
	 *
	 * Append the custom fields after the div.submitbox
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @since 1.0.0
	 * @since 1.0.0 Update regex pattern to support WordPress 4.7's markup.
	 *
	 * @param string $output Used to insert additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   Menu item args.
	 * @param int    $id     Navigation menu ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_output = '';

		parent::start_el( $item_output, $item, $depth, $args, $id );

		$output .= preg_replace(
			// NOTE: Check this regex from time to time!
			'/(?=<(fieldset|p)[^>]+class="[^"]*field-move)/',
			$this->get_fields( $item, $depth, $args ),
			$item_output
		);
	}


	/**
	 * Get custom fields
	 *
	 * @access protected
	 * @since 1.0.0
	 * @uses add_action() Calls 'menu_item_custom_fields' hook
	 *
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item.
	 * @param array  $args   Menu item args.
	 * @param int    $id     Nav menu ID.
	 *
	 * @return string Form fields
	 */
	protected function get_fields( $item, $depth, $args = array(), $id = 0 ) {
		ob_start();

		/**
		 * Get menu item custom fields from plugins/themes
		 *
		 * @since 1.0.0 Pass correct parameters.
		 *
		 * @param int    $item_id  Menu item ID.
		 * @param object $item     Menu item data object.
		 * @param int    $depth    Depth of menu item. Used for padding.
		 * @param array  $args     Menu item args.
		 * @param int    $id       Nav menu ID.
		 *
		 * @return string Custom fields HTML.
		 */
		do_action( 'wp_nav_menu_item_custom_fields', $item->ID, $item, $depth, $args, $id );

		return ob_get_clean();
	}
}
