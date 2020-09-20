<?php
/**
 * Plugin Name:  Nifty Menu Options
 * Plugin URI:   https://wordpress.org/plugins/nifty-menu-options/
 * Description:  Adds beautiful icons to your WordPress menu items. More menu item options are coming soon!
 * Version:      1.0.2
 * Author:       Dunhakdis
 * Contributors: dunhakdis, wpjasper
 * Author URI:   https://profiles.wordpress.org/dunhakdis/
 * Text Domain:  nifty-menu-options
 * Domain Path:  /languages
 * Requires at least: 4.5
 * Tested up to: 4.9.6
 * Requires PHP: 5.4
 * Stable tag: 1.0.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * PHP Version 5.4
 *
 * @category Nifty Menu Options
 * @package  nifty-menu-options
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

// Setup plugin Constants.
define( 'NIFTY_MENU_OPTION_NAME', 'nifty_menu_options' );

define( 'NIFTY_MENU_OPTION_VERSION', '1.0.23kkkkk2' );

define( 'NIFTY_MENU_OPTION_TRAIL_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

define( 'NIFTY_MENU_OPTION_DIR_PATH', plugin_dir_path( __FILE__ ) );

define( 'NIFTY_MENU_OPTION_REALPATH', realpath( dirname( __FILE__ ) . '/..' ) );

define( 'NIFTY_MENU_OPTION_DIRNAME_PATH', plugin_dir_path( dirname( __FILE__ ) ) );

// Require the plugin config file.
require_once NIFTY_MENU_OPTION_DIR_PATH . 'config/config.php';

// Require the plugin activation class.
require_once NIFTY_MENU_OPTION_DIR_PATH . 'src/classes/class-activator.php';

// Require the loader class.
require_once NIFTY_MENU_OPTION_DIR_PATH . 'src/classes/class-loader.php';

// Require the helper class.
require_once NIFTY_MENU_OPTION_DIR_PATH . 'src/classes/class-helper.php';

// The template tags.
require_once NIFTY_MENU_OPTION_DIR_PATH . 'src/template-tags/template-tags.php';

// Setup activation hooks.
register_activation_hook( __FILE__, 'nifty_menu_options_activate' );

/**
 * Set default value for the Nifty Menu Options Settings
 *
 * @return void
 */

function nifty_menu_options_activate() {
	$plugin = new \DSC\NiftyMenuOptions\Activator();
	$plugin->activate();
}

// Bootstrap the plugin.

$plugin = new \DSC\NiftyMenuOptions\Loader();

$plugin->runner();
