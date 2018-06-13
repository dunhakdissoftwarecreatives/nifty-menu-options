<?php
/**
 * The class that handles all the metabox used by the plugin.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Metabox
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
 * The class that handles all the metabox used by the plugin.
 *
 * @category NiftyMenuOptions\Metabox
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class Metabox {

	/**
	 * Default meta value
	 *
	 * @since  1.0.0
	 * @const string METAKEY
	 */
	const METAKEY = 'nifty-menu-options-meta-key';

	/**
	 * Default cache value
	 *
	 * @since  1.0.0
	 * @const string WPCACHEKEY
	 */
	const CACHEKEY = 'nifty_menu_options_meta_key';

	/**
	 * Default meta value
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array
	 */
	protected static $defaults = array(
		'type' => '',
		'icon' => '',
		'url'  => '',
	);

	/**
	 * Initialize metabox
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public static function init_metabox() {
		add_filter( 'is_protected_meta', array( __CLASS__, 'protected_metakey' ), 10, 3 );
		/**
		 * Reapply this action if Icon Library is already develop.
		 *
		 * @todo uncomment this action to add the Plugin Settin Metabox for the icon type.
		 */
		// Apply add_action() to 'load-nav-menus.php' to hook array( __CLASS__, 'load_metabox' ) priority '1'.
	}


	/**
	 * Protect the meta key for the icon picker
	 *
	 * This prevents the icon picker meta key from displaying on the Custom Fields meta box.
	 *
	 * @since   1.0.0
	 * @wp_hook filter is_protected_meta
	 * @param   bool   $protected_meta        Protection status.
	 * @param   string $meta_key              Meta key.
	 * @param   string $meta_type             Meta type.
	 * @return  bool   Protection status.
	 */
	public static function protected_metakey( $protected_meta, $meta_key, $meta_type ) {
		if ( self::METAKEY === $meta_key ) {
			$protected_meta = true;
		}

		return $protected_meta;
	}

	/**
	 * Loads Metabox
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public static function load_metabox() {
		self::add_metabox();
	}

	/**
	 * Add metabox
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private static function add_metabox() {
		add_meta_box(
			'nifty_menu_options_settings_field',
			__( 'Nifty Menu Options Settings', 'nifty-menu-options' ),
			array( __CLASS__, 'set_metabox_icon_libraries' ),
			'nav-menus',
			'side',
			'low',
			array()
		);
	}

	/**
	 * Displays the Settings metabox
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public static function set_metabox_icon_libraries() {
		// Use this to display a setting to enable Icon Libraries.
	}

	/**
	 * Get menu item icon
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int $id           Menu item ID.
	 * @return string $menu_icon Returns the menu icon.
	 */
	public static function get_menu_icon( $id ) {
		$get_menu_icon_meta = '';
		$menu_icon          = '';

		if ( ! empty( $id ) ) {
			$get_menu_icon_meta = get_post_meta( $id, self::METAKEY, true );
		}
		if ( ! empty( $get_menu_icon_meta['icon_name'] ) ) {
			$menu_icon = $get_menu_icon_meta['icon_name'];
		}
		return $menu_icon;
	}

	/**
	 * Get menu item icon color
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int $id       Menu item ID.
	 * @return string $menu_icon_color
	 */
	public static function get_menu_icon_color( $id ) {
		$get_menu_icon_meta = '';
		$menu_icon_color    = '';

		if ( ! empty( $id ) ) {
			$get_menu_icon_meta = get_post_meta( $id, self::METAKEY, true );
		}
		if ( ! empty( $get_menu_icon_meta['icon_color'] ) ) {
			$menu_icon_color = $get_menu_icon_meta['icon_color'];
		}
		return $menu_icon_color;
	}

	/**
	 * Get menu item icon gutter
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int $id       Menu item ID.
	 * @return array $returned_values
	 */
	public static function get_menu_icon_position( $id ) {
		$get_menu_icon_meta          = '';
		$menu_icon_position          = '';
		$default_positions           = array(
			'top',
			'right',
			'bottom',
			'left',
		);
		$filtered_menu_icon_position = array();
		$gutter                      = '';
		$returned_values             = array();

		if ( ! empty( $id ) ) {
			$get_menu_icon_meta = get_post_meta( $id, self::METAKEY, true );
		}

		if ( ! empty( $get_menu_icon_meta['icon_position'] ) ) {
			$menu_icon_position = $get_menu_icon_meta['icon_position'];
		}

		if ( ! empty( $menu_icon_position ) ) {

			foreach ( $menu_icon_position as $icon_position => $position ) {

				foreach ( $default_positions as $default_position ) {
					if ( ! array_key_exists( $default_position, $menu_icon_position ) ) {
						$filtered_menu_icon_position[ $default_position ] = '';
					}
				}

				if ( is_numeric( $position ) ) {
					$filtered_menu_icon_position[ $icon_position ] = $position;

					$position = $icon_position . ': ' . $position . 'px; ';
				}

				$gutter .= $position . ' ';
			}

			$returned_values = array(
				'position' => $filtered_menu_icon_position,
				'css'      => $gutter,
			);

			return $returned_values;
		}
	}

	/**
	 * Get menu item icon size
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int $id       Menu item ID.
	 * @return array $returned_values
	 */
	public static function get_menu_icon_size( $id ) {
		$get_menu_icon_meta = '';
		$menu_icon_size     = '';
		$menu_icon_size_css = '';
		$returned_values    = '';

		if ( ! empty( $id ) ) {
			$get_menu_icon_meta = get_post_meta( $id, self::METAKEY, true );
		}

		if ( is_numeric( $get_menu_icon_meta['icon_size'] ) ) {
			$menu_icon_size = $get_menu_icon_meta['icon_size'];

			if ( is_numeric( $menu_icon_size ) ) {
				$menu_icon_size_css = $menu_icon_size . 'px';
			}

			$returned_values = array(
				'size' => $menu_icon_size,
				'css'  => $menu_icon_size_css,
			);
			return $returned_values;
		}
	}

	/**
	 * Update menu item metadata
	 *
	 * @since 1.0.0
	 * @access public
	 * @param int   $id    Menu item ID.
	 * @param mixed $value Metadata value.
	 *
	 * @return void
	 */

	public static function update_menu_icon( $id, $value ) {
		// Update the menu icon.
		$menu_icon = array();

		if ( ! empty( $value ) ) {
			update_post_meta( $id, self::METAKEY, $value );

			$menu_icon[$id][] = $value;

		} else {
			$menu_icon[$id] = array();
			delete_post_meta( $id, self::METAKEY );
		}



	}
}
