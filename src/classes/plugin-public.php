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
        $plugin_dir_url = plugin_dir_url(dirname(__FILE__)) . 'public/css/icon-stylesheet/';

        $enqueued_icon_libraries = apply_filters(
            'nifty_enqueued_icon_libraries',
            array(
                'nifty-material-icon' => array(
                    'id' => 'nifty-material-icon',
                    'src' => 'material-icon.css',
                    'enqueued' => true
                )
            )
        );

        if ( !empty( $enqueued_icon_libraries ) ) {
            foreach ( $enqueued_icon_libraries as $enqueued_icon_library ) {

                if ( empty( $enqueued_icon_library['version'] ) ) {
                    $enqueued_icon_library['version'] = $this->version;
                }

                if ( empty( $enqueued_icon_library['dependencies'] ) ) {
                    $enqueued_icon_library['dependencies'] = array();
                }

                if ( empty( $enqueued_icon_library['media'] ) ) {
                    $enqueued_icon_library['media'] = 'all';
                }

                if ( $enqueued_icon_library['enqueued'] && empty( $enqueued_icon_library['external_src'] )) {
                    wp_enqueue_style(
                        $enqueued_icon_library['id'],
                        $plugin_dir_url . $enqueued_icon_library['src'],
                        $enqueued_icon_library['dependencies'],
                        $enqueued_icon_library['version'],
                        $enqueued_icon_library['media']
                    );
                }

                if ( ! empty( $enqueued_icon_library['external_src'] ) ) {
                    wp_enqueue_style(
                        $enqueued_icon_library['id'],
                        $enqueued_icon_library['external_src'],
                        $enqueued_icon_library['dependencies'],
                        $enqueued_icon_library['version'],
                        $enqueued_icon_library['media']
                    );
                }

            }
        }

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
        $get_icon_position = Metabox::GetMenuIconPosition( $item->ID );
        $get_icon_position_css = $get_icon_position['css'];
        $get_icon_size = Metabox::GetMenuIconSize( $item->ID );
        $get_icon_size_css = $get_icon_size['css'];

        if ( !empty( $get_icon ) ) {
            $style = 'style="color:'.esc_attr($get_icon_color).'; margin:'.esc_attr($get_icon_position_css).'; font-size:'. esc_attr($get_icon_size_css) .';"';

            $args->link_before = '<i class="material-icons nifty-displayed-icon" '. $style.'>'. esc_html( $get_icon ) .'</i>';
        }

        return $title;
    }
}
