<?php
/**
 * The class that handles WordPress Admin hooks and settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Admin
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

namespace DSC\NiftyMenuOptions;

require_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/resources/class-menuiconpicker.php';

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The class that handles the WordPress Admin hooks and settings.
 *
 * @category NiftyMenuOptions\Admin
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $loader      Holds the hooks.
	 */
	public $loader;

	/**
	 * Class constructor
	 *
	 * @param string $name       Holds the plugin name.
	 * @param string $version    Holds the plugin version.
	 * @param string $loader     Holds the class and set its properties.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function __construct( $name, $version, $loader ) {
		$this->name    = $name;
		$this->version = $version;
		$this->loader  = $loader;
	}

	/**
	 * Enqueues the Admins Script
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function enqueue_scripts() {
		add_thickbox();

		// Add the color picker css file.
		wp_enqueue_style( 'wp-color-picker' );

		wp_register_script(
			$this->name,
			plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/admin-nifty-menu-options.js',
			array( 'jquery', 'wp-color-picker' ),
			$this->version,
			false
		);
		wp_enqueue_script( $this->name );

		wp_localize_script(
			$this->name,
			$this->name . '_admin_object',
			array(
				'ajaxurl'              => admin_url( 'admin-ajax.php' ),
				'loading'              => '<div class="loading-wrapper"><span class="loading"></span></div>',
				'thickbox_title'       => '<h2>' . __( 'Select Icon', 'nifty-menu-options' ) . '</h2>',
				'add_icon'             => __( 'Add Icon', 'nifty-menu-options' ),
				'change_icon'          => __( 'Change Icon', 'nifty-menu-options' ),
				'search_nothing_found' => '<p class="nifty-message nothing-found-here warning">' . __( 'Oops, no icons matched with "<strong class="search-icon-name"></strong>" under "<strong class="search-icon-category"></strong>"! Try searching another icon.', 'nifty-menu-options' ) . '</p>',
				'search_invalid'       => '<p class="nifty-message invalid">' . __( 'Oops, "<strong class="search-icon-name"></strong>" is invalid! Try typing a valid icon name.', 'nifty-menu-options' ) . '</p>',
			)
		);
	}

	/**
	 * Enqueues the Admins Ajax
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function init_ajax() {
		add_action(
			'wp_ajax_nifty_admin_ajax',
			array(
				$this,
				'nifty_admin_ajax',
			)
		);
		add_action(
			'wp_ajax_nopriv_nifty_admin_ajax',
			array(
				$this,
				'nifty_admin_ajax',
			)
		);
	}


	/**
	 * Enqueues the Admins Stylesheet
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			$this->name,
			plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/admin-nifty-menu-options.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Enqueues the wp_enqueue_media() to the WordPress Dashboad.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_wpmedia() {
		wp_enqueue_media();
	}


	/**
	 * This method initialize admin ajax.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function nifty_admin_ajax() {
		header( 'Content-Type: application/json' );

		$nifty_setting = filter_input(
			INPUT_POST,
			'nifty-setting',
			FILTER_SANITIZE_STRING
		);

		$nifty_menu_id = filter_input(
			INPUT_POST,
			'nifty-menu-id',
			FILTER_SANITIZE_NUMBER_INT
		);

		$selected_icon = filter_input(
			INPUT_POST,
			'selected-icon',
			FILTER_SANITIZE_STRING
		);

		if ( 'nifty-icon-picker' === $nifty_setting ) {
			echo wp_json_encode(
				array(
					'status'                 => 202,
					'nifty_setting'          => $nifty_setting,
					'nifty_icon_picker_list' => MenuIconPicker::set_menu_icon_picker_contents( $nifty_menu_id, $selected_icon ),
					'selected_icon'          => $selected_icon,
				)
			);
		}

		die();
	}
}
