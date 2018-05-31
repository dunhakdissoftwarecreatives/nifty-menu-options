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
        $get_menu_icon = Metabox::GetMenuIcon( $id );
        $link_text = esc_html__( 'Change Icon:', 'nifty-menu-options' );

        if ( empty ( $get_menu_icon ) ) {
            $link_text = esc_html__( 'Add Icon: Select Here', 'nifty-menu-options' );
        }

        $thickbox_args = array(
            'id'    => esc_attr( 'nifty-icon-selector-' . $id ),
            'class'  => esc_attr( 'nifty-thickbox-container' ),
            'content_class'  => esc_attr( 'nifty-thickbox-content' ),
            'button_class'  => esc_attr( 'nifty-icon-picker' ),
            'show'  => false,
            'type' => esc_attr( 'inline' ),
            'width' => esc_attr( '600' ),
            'height' => esc_attr( '550' ),
            'link_text' => $link_text,
            'link_text_after' => '<i class="material-icons nifty-icon-selected nifty-icon-selected-'. esc_attr( $id ) .'">' . esc_html( $get_menu_icon ) . '</i>',
        );

        $thickbox_class = new ThickBox( $thickbox_args );

        do_action( 'nifty_menu_options_before_fields' ); ?>

        <div class="nifty-menu-options-settings-container description-wide">
            <p class="description">
                <label><?php echo esc_html__( 'Nifty Menu Options', 'nifty-menu-options' ); ?></label>
            </p>
            <div class="nifty-menu-options-settings-inner">
                <div class="nifty-icon-selector-wrap nifty-section">
                    <?php $thickbox_class->getThickBox(); ?>
                    <div class="_settings hidden nifty-menu-settings">
                        <input type="text" class="nifty-menu-id" name="nifty-menu-id" value="<?php echo esc_attr( $id ); ?>">
                    </div>
                </div>
                <div class="nifty-icon-color-picker-wrap nifty-section">
                    <label><?php echo esc_html__( 'Select Icon Color:', 'nifty-menu-options' ); ?></label>
                    <input type="text" value="#bada55" class="nifty-icon-color-picker" data-default-color="#effeff" id="nifty-menu-color-<?php echo esc_attr( $id ); ?>" name="nifty-menu-color-<?php echo esc_attr( $id ); ?>" />
                </div>
            </div>
        </div>

        <?php do_action( 'nifty_menu_options_after_fields' );
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
    public function setMenuIconPickerContents( $id = '', $selected_icon = '' )
    {
        $content = '';
        $icons = IconLibrary::GetIcons();
        $get_menu_icon = '';
        $is_selected = '';
        if ( !empty( $id ) ) {

            if ( !empty( $selected_icon ) ) {
                $get_menu_icon = $selected_icon;
            } else {
                $get_menu_icon = Metabox::GetMenuIcon( $id );
            }

            $content .= '<ul class="nifty-icon-selector-container">';
                foreach ( $icons as $icon => $icon_value ) {

                    if ( $icon_value === $get_menu_icon ) {
                        $is_selected = 'selected';
                    } else {
                        $is_selected = '';
                    }

                    $content .= '<li class="nifty-icon-item">';
                        $content .= '<label class="nifty-icon-label ' . esc_attr( $is_selected ) . '">';
                            $content .= '<input type="radio" class="nifty-icon-selector" ' . checked( $icon_value, $get_menu_icon, false ) . ' value="' . esc_attr( $icon_value ) . '" name="nifty-menu-options-icon-' . esc_attr( $id ) . '" data-id="' . esc_attr( $id ) . '" />';
                            $content .= '<i class="material-icons nifty-displayed-icon" data-id="' . esc_attr( $id ) . '">' . esc_html( $icon_value ) . '</i>';
                        $content .= '</label>';
                    $content .= '</li>';
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
        $nifty_icon_save_meta = array();

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

        $nifty_icon_save_meta = array(
            'icon_name' => $sanitized_menu_icon,
            'icon_library' => '',
            'icon_category' => '',
            'icon_position' => '',
            'icon_color' => '',
            'icon_size' => ''
        );
        if ( array_key_exists( $menu_icon_name, $_POST ) ) {
            Metabox::UpdateMenuIcon( $menu_item_db_id, $nifty_icon_save_meta );
        }

        return;
    }
}
