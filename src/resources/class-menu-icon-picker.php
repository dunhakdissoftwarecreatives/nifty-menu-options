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
     * Initialize metabox
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function Init() {
        add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, 'FilterWpEditNavMenuWalkerClass' ), 99 );
        add_filter( 'wp_nav_menu_item_custom_fields', array( __CLASS__, 'MenuIconPickerOption' ), 10, 4 );
        add_action( 'wp_update_nav_menu_item', array( __CLASS__, 'SaveMenuIcon' ), 10, 3 );
        return;
    }


	/**
	 * Custom WP Walker
	 *
	 * @since   1.0.0
	 * @access  public
	 * @return string $walker
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
	 * Display Icon Picker Fields
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
     * @wp_hook action       wp_nav_menu_item_custom_fields
     *
	 * @return string Form fields
	 */
    public static function MenuIconPickerOption( $id, $item, $depth, $args ) {
        $get_current_menu_id = Helper::GlobalNavMenuSelectedId();

        $thickbox_args = array(
            'id'    => esc_attr( 'nifty-icon-selector-' . $id ),
            'class'  => esc_attr( 'nifty-thickbox-container' ),
            'content_class'  => esc_attr( 'nifty-thickbox-content' ),
            'button_class'  => esc_attr( 'nifty-icon-picker' ),
            'show'  => false,
            'type' => esc_attr( 'inline' ),
            'width' => esc_attr( '600' ),
            'height' => esc_attr( '550' ),
            'link_text' => esc_html__( 'Add Icon', 'nifty-menu-options' ),
        );
        $thickbox_class = new ThickBox( $thickbox_args );
        $get_menu_icon = Metabox::GetMenuIcon( $id );

        do_action( 'nifty_menu_options_before_fields' );

        $thickbox_class->getThickBox();
        echo '<i class="material-icons nifty-icon-selected">' . esc_html( $get_menu_icon ) . '</i>';
        ?>
        <div class="_settings hidden nifty-menu-settings">
            <input type="text" class="nifty-menu-id" name="nifty-menu-id" value="<?php echo $id; ?>">
        </div>
        <?php
        do_action( 'nifty_menu_options_after_fields' );
    }

    /**
	 * Constructs the Menu Icon Picker Content
	 *
	 * @since  1.0.0
	 * @access private
	 *
     * @param  int    $id    Navigation menu ID.
	 *
     * @uses   add_filter() Calls 'DSC/NiftyMenuOptions/MenuIconPicker/setMenuIconPickerContent' hook
     *
	 * @return string $content The content for the icon picker
	 */
    public function setMenuIconPickerContents( $id = '' )
    {
        $content = '';
        $icons = IconLibrary::GetIcons();
        $get_menu_icon = '';
        if ( !empty( $id ) ) {

            $get_menu_icon = Metabox::GetMenuIcon( $id );

            $content .= '<ul class="nifty-icon-selector-container">';
            foreach ( $icons as $icon => $icon_value ) {
                $content .= '<label class="nifty-icon-item">';
                $content .= '<input type="radio" class="nifty-icon-selector"' . checked( $icon_value, $get_menu_icon, false ) . ' value="' . esc_attr( $icon_value ) . '" name="nifty-menu-options-icon-' . esc_attr( $id ) . '" />';
                $content .= '<i class="material-icons">' . esc_html( $icon_value ) . '</i>';
                $content .= '</label>';
            }
            $content .= '</ul>';
        }
        $content = apply_filters( 'DSC/NiftyMenuOptions/MenuIconPicker/setMenuIconPickerContents', $content, $id );

        return $content;
    }

    /**
	 * Constructs the Menu Icon Picker Content
	 *
	 * @since  1.0.0
	 * @access public
	 *
     * @param  int      $menu_id            Current menu ID.
     * @param  int      $menu_item_db_id    Menu Item ID.
     * @param  array    $menu_item_args     The menu item's data.
	 *
     * @wp_hook action       wp_update_nav_menu_item
     *
	 * @return void
	 */
    public static function SaveMenuIcon( $menu_id, $menu_item_db_id, $menu_item_args )
    {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen instanceof \WP_Screen || 'nav-menus' !== $screen->id ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

        $menu_icon_name = 'nifty-menu-options-icon-' . $menu_item_db_id;
        $sanitized_menu_icon = filter_input( INPUT_POST, $menu_icon_name, FILTER_SANITIZE_STRING );

        if ( array_key_exists( $menu_icon_name, $_POST ) ) {
            Metabox::UpdateMenuIcon( $menu_item_db_id, $sanitized_menu_icon );
        }

        return;
    }
}
