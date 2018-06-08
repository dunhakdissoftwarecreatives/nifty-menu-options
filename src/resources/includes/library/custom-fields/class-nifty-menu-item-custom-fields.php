<?php
/**
 * Custom Walker Class for Menu Editor
 *
 * The class that loads the custom menu fields.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Nifty_Menu_Item_Custom_Fields
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
 * The class that loads the custom menu fields.
 *
 * @category NiftyMenuOptions\Nifty_Menu_Item_Custom_Fields
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
if ( ! class_exists( 'Nifty_Menu_Item_Custom_Fields' ) ) :
	/**
	 * Menu Item Custom Fields Loader
	 */
	class Nifty_Menu_Item_Custom_Fields {

		/**
		 * Add filter
		 *
		 * @since 1.0.0
		 * @wp_hook action wp_loaded
		 * @return void
		 */
		public static function load() {
			add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, 'nifty_filter_walker' ), 99 );
		}


		/**
		 * Does not replace the default menu editor walker
		 * and just append the additional setting of the plugin.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @wp_hook filter wp_edit_nav_menu_walker
		 * @param   string $walker Walker class name.
		 * @return  string $walker class name.
		 */
		public static function nifty_filter_walker( $walker ) {
			$walker = 'DSC\NiftyMenuOptions\Nifty_Menu_Item_Custom_Fields_Walker';

			if ( ! class_exists( $walker ) ) {
				require_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/resources/includes/library/custom-fields/class-nifty-menu-item-custom-fields-walker.php';
			}

			return $walker;
		}
	}
	add_action( 'wp_loaded', array( 'DSC\NiftyMenuOptions\Nifty_Menu_Item_Custom_Fields', 'load' ), 9 );
endif;
