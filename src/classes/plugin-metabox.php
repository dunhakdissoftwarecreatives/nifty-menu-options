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
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

namespace DSC\NiftyMenuOptions;

if (! defined('ABSPATH')) {
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
final class Metabox
{
    /**
     * Default meta value
     *
     * @since  1.0.0
     * @const string METAKEY
     */
    const METAKEY = 'nifty-menu-options-meta-key';

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
    public static function Init() {
        add_filter( 'is_protected_meta', array( __CLASS__, 'ProtectedMetaKey' ), 10, 3 );

        /**
         * @todo uncomment this action to add the Plugin Settin Metabox for the icon type.
         */
        // add_action( 'load-nav-menus.php', array( __CLASS__, 'LoadMetaBox' ), 1 );
        return;
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
	public static function ProtectedMetaKey( $protected_meta, $meta_key, $meta_type ) {
		if ( self::METAKEY === $meta_key ) {
			$protected_meta = true;
		}

		return $protected;
	}

    /**
     * Loads Metabox
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function LoadMetaBox() {
        self::AddMetaBox();
        return;
    }

    /**
     * Add metabox
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private static function AddMetaBox() {
        add_meta_box(
            'nifty_menu_options_settings_field',
            __( 'Nifty Menu Options Settings', 'nifty-menu-options' ),
            array( __CLASS__, 'MetaBoxIconsSet' ),
            'nav-menus',
            'side',
            'low',
            array()
        );
        return;
    }

    /**
     * Settings metabox
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function MetaBoxIconsSet() {
        dump( 'hello' );
        return;
    }

    /**
     * Get menu item meta value
     *
     * @since  1.0.0
     * @access public
     * @param  int    $id       Menu item ID.
     * @return string $menu_icon
     */
    public static function GetMenuIcon( $id ) {
        $menu_icon = '';

        if ( ! empty ( $id ) ) {
            $menu_icon = get_post_meta( $id, self::METAKEY, true );
        }

        return $menu_icon;
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
    public static function UpdateMenuIcon( $id, $value ) {

        // Update
        if ( ! empty( $value ) ) {
            update_post_meta( $id, self::METAKEY, $value );
        } else {
            delete_post_meta( $id, self::METAKEY );
        }
        return;
    }
}
