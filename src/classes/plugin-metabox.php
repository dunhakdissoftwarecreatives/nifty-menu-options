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
        add_action( 'load-nav-menus.php', array( __CLASS__, 'LoadMetaBox' ), 1 );
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
}
