<?php
/**
 * Holds the icon library.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\IconLibrary
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
 * Holds the icon library.
 *
 * @category NiftyMenuOptions\IconLibrary
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class IconLibrary
{
    /**
     * Fetch the list of icons
     *
     * @since  1.0.0
     * @uses   add_filter() Calls 'DSC/NiftyMenuOptions/IconLibrary/GetIcons' hook
     * @return array $icons List of icons.
     */
    public static function GetIcons()
    {
        $icons = array(
            '3d_rotation',
            'accessibility',
            'accessibility_new',
            'accessible',
            'accessible_forward',
            'account_balance',
            'account_balance_wallet',
            'account_box',
            'account_circle',
            'add_shopping_cart',
        );
        return apply_filters( 'DSC/NiftyMenuOptions/IconLibrary/GetIcons', $icons );
    }

}
