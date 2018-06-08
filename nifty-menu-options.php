<?php
/**
 * Plugin Name:  Nifty Menu Options
 * Plugin URI:   https://wordpress.org/plugins/nifty-menu-options/
 * Description:  A nifty plugin that allows you to add nifty icons to your menu items.
 * Version:      1.0.0
 * Author:       Dunhakdis
 * Contributors: dunhakdis, wpjasper
 * Author URI:   https://profiles.wordpress.org/dunhakdis/
 * Text Domain:  nifty-menu-options
 * Domain Path:  /languages
 * License:      GPL2
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

define( 'NIFTY_MENU_OPTION_VERSION', '1.0.0' );

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

/**
 * This is just a test
 *
 * @todo Remove this later on releasing
 */
add_filter( 'DSC/NiftyMenuOptions/IconLibrary/add_icon_library', 'my_library' );

/**
 * This is just a test icon library
 *
 * @param array $icon_libraries collection of icons.
 * @todo Remove this later on releasing
 */
function my_library( $icon_libraries ) {
	$icon_libraries['my_library'] = array(
		'3d_rotation',
		'ac_unit',
		'access_alarm',
		'access_alarms',
		'access_time',
		'accessibility',
	);
	return $icon_libraries;
}
/**
 * This is just a test enqueue icon library
 *
 * @param array $enqueued_icon_libraries collection of icons Libraries.
 * @todo Remove this later on releasing
 */
add_filter( 'nifty_enqueued_icon_libraries', function( $enqueued_icon_libraries ) {
	$enqueued_icon_libraries['nifty-material-icon']['enqueued'] = true;
	return $enqueued_icon_libraries;
});
