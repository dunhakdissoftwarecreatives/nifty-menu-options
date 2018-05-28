<?php
/**
 * The class that handles Menu Icon picker.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\MenuIconPicker
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

namespace DSC\NiftyMenuOptions;

include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/template/icon-library.php';
include_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/template/thickbox.php';

if (! defined('ABSPATH')) {
    return;
}

/**
 * The class that handles Menu Icon picker.
 *
 * @category NiftyMenuOptions\MenuIconPicker
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class MenuIconPicker
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
        add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, 'FilterWpEditNavMenuWalkerClass' ), 99 );
        add_filter( 'wp_nav_menu_item_custom_fields', array( __CLASS__, 'MenuIconPicker' ), 10, 4 );
        add_action( 'wp_update_nav_menu_item', array( __CLASS__, 'SaveMenuIcon' ), 10, 3 );
    }


	/**
	 * Custom WP Walker
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @wp_hook filter    wp_edit_nav_menu_walker
	 */
	public static function FilterWpEditNavMenuWalkerClass( $walker ) {
		// Load menu item custom fields plugin
		if ( ! class_exists( 'CustomMenuEditorWalkerFields' ) ) {
			require_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/resources/includes/library/custom-fields/walker-nav-menu-edit.php';
		}
		$walker = 'CustomMenuEditorWalkerFields';

		return $walker;
	}

    /**
	 * Print fields
	 *
	 * @since   1.0.0
	 * @access  public
	 *
     * @param int    $id    Navigation menu ID.
	 * @param object $item  Navigation menu item data object.
	 * @param int    $depth Navigation menu depth.
	 * @param array  $args  Navigation menu item args.
	 *
     * @uses    add_action() Calls 'nifty_menu_options_before_fields' hook
     * @uses    add_action() Calls 'nifty_menu_options_after_fields' hook
     * @wp_hook action       menu_item_custom_fields
     *
	 * @return string Form fields
	 */
    public static function MenuIconPicker( $id, $item, $depth, $args ) {
        $get_current_menu_id = Helper::GlobalNavMenuSelectedId();
        $input_id      = sprintf( 'nifty-menu-options-%d', $item->ID );
		$input_name    = sprintf( 'nifty-menu-options[%d]', $item->ID );
        // $menu_settings = Menu_Icons_Settings::get_menu_settings( Menu_Icons_Settings::get_current_menu_id() );
		// $meta          = Menu_Icons_Meta::get( $item->ID, $menu_settings );

        $args = array(
            'id'    => esc_attr( 'menu-icon-selector' ),
            'class'  => esc_attr( 'thickbox-container' ),
            'show'  => false,
            'type' => esc_attr( 'inline' ),
            'width' => esc_attr( '600' ),
            'height' => esc_attr( '550' ),
            'link_text' => esc_html__( 'Add Icon', 'nifty-menu-options' )
        );

        $thickbox_class = new ThickBox( $args );
        // dump($x);
        // dump($item);
        // $thickbox_class = ThickBox::getThickBox();

        $thickbox_class->setThickBoxContent();
        $thickbox_class->getThickBox( self::MenuIconPickerContent() );

        ?>
        <div class="_settings hidden">
        </div>
        <?php
    }
    public static function MenuIconPickerContent()
    {
        $content = '';
        $icon_pack = new IconLibrary();
        $icons = $icon_pack->getIcons();

        foreach ( $icons as $icon => $icon_value ) {
            $content .= '<i class="material-icons">'.$icon_value.'</i>';
        }

        return $content;
    }

    public static function SaveMenuIcon()
    {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen instanceof WP_Screen || 'nav-menus' !== $screen->id ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		// Sanitize
		if ( ! empty( $_POST['nifty-menu-options'][ $menu_item_db_id ] ) ) {
			$value = array_map(
				'sanitize_text_field',
				wp_unslash( (array) $_POST['nifty-menu-options'][ $menu_item_db_id ] )
			);
		} else {
			$value = array();
		}

		Metabox::UpdateMenuIcon( $menu_item_db_id, $value );
    }
}
