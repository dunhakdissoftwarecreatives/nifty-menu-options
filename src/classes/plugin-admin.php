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
final class Admin
{
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
     * @var      string    $name       The name of this plugin.
     * @var      string    $version    The version of this plugin.
     */
    public $loader;

    /**
     * Class constructor
     */
    public function __construct( $name, $version, $loader )
    {
        $this->name = $name;
        $this->version = $version;
        $this->loader = $loader;
    }

    public function enqueueScripts()
    {
        wp_register_script(
            $this->name,
            plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/admin-nifty-menu-options.js',
            array('jquery'),
            $this->version,
            false
        );
        wp_enqueue_script($this->name);
        add_thickbox();
    }

    /**
    * Enqueues the wp_enqueue_media() to the Wordpress Dashboad.
    *
    * @since  1.0.0
    * @access public
    * @return void
    */
    public function enqueueWPMedia()
    {
        wp_enqueue_media();

        return;
    }
}
