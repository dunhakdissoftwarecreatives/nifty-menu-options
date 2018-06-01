<?php
/**
 * The class that handles WordPress frontend hooks and settings.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Public
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
 * The class that handles the WordPress frontend hooks and settings.
 *
 * @category NiftyMenuOptions\Public
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class PublicPages
{
    /**
     * The loader is the one who regesters the handles the hooks of the plugin
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $loader    Handles and registers all
     *                                         hooks for the plugin.
     */
    private $loader;

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string  $name    The name of the plugin.
     * @param integer $version The version of this plugin.
     * @param string  $loader  The version of this plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __construct( $name, $version, $loader )
    {

        $this->loader = $loader;
        $this->name = $name;
        $this->version = $version;
        add_filter( 'nav_menu_item_title', array( $this, 'displayMenuIcons' ), 10, 4 );
    }

    /**
     * This method enqueue the CSS filess for the frontend of the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setEnqueueStyles()
    {
        return;
    }

    /**
     * This method enqueue the JS files for the frontend of the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setEnqueueScripts()
    {
        return;
    }

    /**
     * This method enqueue theLocalization Scripts for the frontend of the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setLocalizeScripts()
    {
        return;
    }

    /**
     * This method displays the menu icons.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function displayMenuIcons( $title, $item, $args, $depth )
    {
        $get_icon = Metabox::GetMenuIcon( $item->ID );
        $get_icon_color = Metabox::GetMenuIconColor( $item->ID );
        $args->link_before = '<i class="material-icons nifty-displayed-icon" style="color:'.$get_icon_color.'">'.$get_icon.'</i>';

        return $title;
    }
}
