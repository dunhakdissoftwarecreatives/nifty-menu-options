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
    const METAKEY = 'nifty-menu-options';

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
     * Plugin metabox class constructor
     */
    public function __construct()
    {
    }

    /**
     * Initialize metabox
     *
     * @since  1.0.0
     * @access public
     */
    public static function Init() {
        add_filter( 'is_protected_meta', array( __CLASS__, 'ProtectedMetaKey' ), 10, 3 );
        add_action( 'load-nav-menus.php', array( __CLASS__, 'LoadMetaBox' ), 1 );
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
     *  @since  1.0.0
     * @access public
     */
    public static function LoadMetaBox() {
        self::AddMetaBox();
    }

    /**
     * Settings metabox
     *
     * @since  1.0.0
     * @access private
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
    }

    /**
     * Settings metabox
     *
     * @since  1.0.0
     * @access private
     */
    public static function MetaBoxIconsSet() {
        dump( 'hello' );
    }

    /**
     * Get menu item meta value
     *
     * @since  1.0.0
     * @since  1.0.0  Add $defaults parameter for the meta.
     * @param  int    $id       Menu item ID.
     * @param  array  $defaults Optional setting.
     * @return array
     */
    public static function GetMenuIcon( $id, $defaults = array() ) {
        $defaults = wp_parse_args( $defaults, self::$defaults );
        $value    = get_post_meta( $id, self::METAKEY, true );
        $value    = wp_parse_args( (array) $value, $defaults );

        // Backward-compatibility.
        if ( empty( $value['icon'] ) &&
            ! empty( $value['type'] ) &&
            ! empty( $value[ "{$value['type']}-icon" ] )
        ) {
            $value['icon'] = $value[ "{$value['type']}-icon" ];
        }

        if ( ! empty( $value['width'] ) ) {
            $value['svg_width'] = $value['width'];
        }
        unset( $value['width'] );

        if ( isset( $value['position'] ) &&
            ! in_array( $value['position'], array( 'before', 'after' ), true )
        ) {
            $value['position'] = $defaults['position'];
        }

        if ( isset( $value['size'] ) && ! isset( $value['font_size'] ) ) {
            $value['font_size'] = $value['size'];
            unset( $value['size'] );
        }

        // The values below will NOT be saved
        if ( ! empty( $value['icon'] ) &&
            in_array( $value['type'], array( 'image', 'svg' ), true )
        ) {
            $value['url'] = wp_get_attachment_image_url( $value['icon'], 'thumbnail', false );
        }

        return $value;
    }


    /**
     * Update menu item metadata
     *
     * @since 1.0.0
     *
     * @param int   $id    Menu item ID.
     * @param mixed $value Metadata value.
     *
     * @return void
     */
    public static function UpdateMenuIcon( $id, $value ) {

        // Don't bother saving if `type` or `icon` is not set.
        if ( empty( $value['type'] ) || empty( $value['icon'] ) ) {
            $value = false;
        }

        // Update
        if ( ! empty( $value ) ) {
            update_post_meta( $id, self::METAKEY, $value );
        } else {
            delete_post_meta( $id, self::METAKEY );
        }
    }
}
