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
}
