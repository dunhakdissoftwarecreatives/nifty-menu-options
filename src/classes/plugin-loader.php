<?php
/**
 * This class loads all the dependencies needed by the plugin.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Loader
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
 * This class loads all the dependencies needed by the plugin.
 *
 * @category NiftyMenuOptions\Loader
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class Loader
{
    /**
     * The loader is the one who regesters the handles the hooks of the plugin
     *
     * @since  1.0.0
     * @access protected
     * @var    Hooks    $loader    Handles and registers all hooks
     *                                         for the plugin.
     */
    protected $loader;

    /**
     * This is the unique indentifier of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $plugin_name    The string the plugin uses to identify
     *                                      the plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * This method is used to set the value of the properties and initialize
     * the methods listed below.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->plugin_name = NIFTY_MENU_OPTION_NAME;
        $this->version = NIFTY_MENU_OPTION_VERSION;

        $this->loadDependencies();
        $this->setLocale();
        $this->setAdminHooks();
        $this->setPublicHooks();
        return;
    }

    /**
     * This method is used to load all the dependencies needed by the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function loadDependencies()
    {
        /**
         * Includes the class that handles the actions and filters of the plugin.
         */
        include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/classes/plugin-hooks.php';

        /**
         * This class handles the localization functionality of the plugin.
         */
        include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/classes/plugin-i18n.php';
        /**
         * This class handles the registers the plugin metaboxes.
         */
        include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/classes/plugin-metabox.php';
        /**
         * This class handles the registers the plugin icon picker.
         */
        include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/resources/includes/library/custom-fields/nifty-menu-item-custom-fields.php';
        /**
         * This class handles the registers the plugin icon picker.
         */
        include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/resources/class-menu-icon-picker.php';
        /**
         * This class handles all the defined hooks in the WordPress backend.
         */
        include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/classes/plugin-admin.php';

        /**
         * This class handles all the defined hooks in the WordPress frontend.
         */
        include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/classes/plugin-public.php';

        $this->loader = new \DSC\NiftyMenuOptions\Hooks();

        new \DSC\NiftyMenuOptions\Language();

        new \DSC\NiftyMenuOptions\Metabox();

        return;
    }

    /**
     * This method is used to load the localization file of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function setLocale()
    {
    }

    /**
     * This method is used to load all the actions and filters hooks in the
     * WordPress backend.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function setAdminHooks()
    {
        $plugin_admin = new \DSC\NiftyMenuOptions\Admin(
            $this->getName(),
            $this->getVersion(),
            $this->getLoader()
        );
        $plugin_metabox = new \DSC\NiftyMenuOptions\Metabox(
            $this->getName(),
            $this->getVersion(),
            $this->getLoader()
        );
        $plugin_menu_icon_picker = new \DSC\NiftyMenuOptions\MenuIconPicker(
            $this->getName(),
            $this->getVersion(),
            $this->getLoader()
        );
        $this->loader->addAction(
            'load-nav-menus.php',
            $plugin_admin,
            'enqueueScripts',
            1
        );
        $this->loader->addAction(
            'load-nav-menus.php',
            $plugin_admin,
            'enqueueStyles',
            1
        );
        $this->loader->addAction(
            'init',
            $plugin_admin,
            'initAjax',
            1
        );

        $this->loader->addAction(
            'plugins_loaded',
            $plugin_metabox,
            'Init'
        );
        $this->loader->addAction(
            'plugins_loaded',
            $plugin_menu_icon_picker,
            'Init'
        );
        return;
    }
    /**
     * This method is used to load all the actions and filters hooks in the
     * frontend.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function setPublicHooks()
    {
        $plugin_public = new \DSC\NiftyMenuOptions\PublicPages(
            $this->getName(),
            $this->getVersion(),
            $this->getLoader()
        );
        $this->loader->addAction(
            'wp_enqueue_scripts',
            $plugin_public,
            'setEnqueueStyles'
        );
        $this->loader->addAction(
            'wp_enqueue_scripts',
            $plugin_public,
            'setEnqueueScripts'
        );
        $this->loader->addAction(
            'wp_enqueue_scripts',
            $plugin_public,
            'setLocalizeScripts'
        );
        return;
    }
    /**
     * Run the loader to execute all of in the hooks plugin to WordPress.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function runner()
    {
        $this->loader->runner();
        return;
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @access public
     * @return string $plugin_name The name of the plugin.
     */
    public function getName()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return string loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return string version The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }
}
