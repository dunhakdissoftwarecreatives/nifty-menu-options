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
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

namespace DSC\NiftyMenuOptions;

require_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/template/icon-library.php';
require_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/template/class-thickbox.php';

if ( ! defined( 'ABSPATH' ) ) {
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
final class MenuIconPicker {

	/**
	 * Initialize metabox
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public static function init_menu_icon_picker() {
		add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, 'filter_wp__edit_nav_menu_walker_class' ), 100 );
		add_filter( 'wp_nav_nifty_menu_item_custom_fields', array( __CLASS__, 'menu_icon_picker_option' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( __CLASS__, 'save_menu_icon' ), 10, 3 );
	}

	/**
	 * Custom WP Walker
	 *
	 * @param string $walker The walker class.
	 * @since   1.0.0
	 * @access  public
	 * @return string $walker
	 * @wp_hook filter    wp_edit_nav_menu_walker
	 */
	public static function filter_wp__edit_nav_menu_walker_class( $walker ) {
		// Load menu item custom fields plugin.
		$walker = 'DSC\NiftyMenuOptions\Nifty_Menu_Item_Custom_Fields_Walker';

		if ( ! class_exists( $walker ) ) {
			require_once NIFTY_MENU_OPTION_TRAIL_PATH . 'src/resources/includes/library/custom-fields/class-nifty-menu-item-custom-fields-walker.php';
		}

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
	 * @wp_hook action       wp_nav_nifty_menu_item_custom_fields
	 *
	 * @return void
	 */
	public static function menu_icon_picker_option( $id, $item, $depth, $args ) {
		$get_current_menu_id    = Helper::global_nav_menu_selected_id();
		$get_menu_icon          = Metabox::get_menu_icon( $id );
		$get_menu_icon_color    = Metabox::get_menu_icon_color( $id );
		$get_menu_icon_position = Metabox::get_menu_icon_position( $id );
		$icon_position          = $get_menu_icon_position['position'];
		$get_menu_icon_size     = Metabox::get_menu_icon_size( $id );
		$icon_size              = $get_menu_icon_size['size'];
		$min                    = nifty_default_position_min();
		$default_color          = nifty_default_color();

		$link_text          = esc_html__( 'Change Icon', 'nifty-menu-options' );
		$gutter_placeholder = esc_attr__( '15', 'nifty-menu-options' );
		$size_placeholder   = esc_attr__( '16', 'nifty-menu-options' );

		if ( empty( $get_menu_icon ) ) {
			$link_text = esc_html__( 'Add Icon', 'nifty-menu-options' );
		}

		$thickbox_args = array(
			'id'              => esc_attr( 'nifty-icon-selector-' . $id ),
			'class'           => esc_attr( 'nifty-thickbox-container' ),
			'content_class'   => esc_attr( 'nifty-thickbox-content' ),
			'button_class'    => esc_attr( 'nifty-icon-picker' ),
			'show'            => false,
			'type'            => esc_attr( 'inline' ),
			'width'           => esc_attr( '600' ),
			'height'          => esc_attr( '550' ),
			'link_text'       => $link_text,
			'link_text_class' => esc_attr( 'button button-small thickbox-link-text-' . $id ),
			'link_text_after' => '<i class="material-icons nifty-icon-selected nifty-icon-selected-' . esc_attr( $id ) . '" data-status="" style="color:' . esc_attr( $get_menu_icon_color ) . ';">' . esc_html( $get_menu_icon ) . '</i>',
		);

		$thickbox_class = new ThickBox( $thickbox_args );

		do_action( 'nifty_menu_options_before_fields' ); ?>

		<div class="nifty-menu-options-settings-container description-wide">
			<p class="description">
				<label><?php echo esc_html__( 'Nifty Menu Options', 'nifty-menu-options' ); ?></label>
			</p>
			<div class="nifty-menu-options-settings-inner">
				<div class="nifty-icon-selector-wrap nifty-section">
					<?php $thickbox_class->get_thickbox(); ?>

					<a href="#" class="nifty-remove-icon" title="<?php echo esc_attr__( 'Remove Icon', 'nifty-menu-options' ); ?>"><i class="dashicons-before dashicons-trash"></i></a>

					<div class="_settings hidden nifty-menu-settings">
						<input type="text" class="nifty-menu-id" name="nifty-menu-id" value="<?php echo esc_attr( $id ); ?>">
						<input type="text" class="nifty-remove-icon-field" name="nifty-remove-icon[<?php echo esc_attr( $id ); ?>]" value="">
					</div>
				</div>
				<div class="nifty-icon-color-picker-wrap nifty-section">
					<input type="text" value="<?php echo esc_attr( $get_menu_icon_color ); ?>" class="nifty-icon-color-picker" data-default-color="<?php echo esc_attr( $default_color ); ?>" id="nifty-menu-color-<?php echo esc_attr( $id ); ?>" name="nifty-menu-color[<?php echo esc_attr( $id ); ?>]" />
				</div>
				<div class="nifty-icon-gutters-wrap label_vcenter nifty-section">
					<label for="nifty-icon-gutter-top-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Top:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['top'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-top-<?php echo esc_attr( $id ); ?>" name="nifty-icon-gutter[top][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
					<label for="nifty-icon-gutter-right-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Right:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['right'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-right-<?php echo esc_attr( $id ); ?>" name="nifty-icon-gutter[right][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
					<label for="nifty-icon-gutter-bottom-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Bottom:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['bottom'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-bottom-<?php echo esc_attr( $id ); ?>" name="nifty-icon-gutter[bottom][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
					<label for="nifty-icon-gutter-left-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Left:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['left'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-left-<?php echo esc_attr( $id ); ?>" name="nifty-icon-gutter[left][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
				</div>
				<div class="nifty-icon-size-wrap label_vcenter nifty-section">
					<label for="nifty-icon-size-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Icon Size:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_size ); ?>" min="0" class="nifty-icon-size nifty-number-field small-text" id="nifty-icon-size-<?php echo esc_attr( $id ); ?>" name="nifty-icon-size[<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $size_placeholder ); ?>"/>
				</div>
			</div>
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
	 * @param  string $selected_icon    Selected icon.
	 *
	 * @uses   add_filter()    Calls 'filter_nifty_menu_icon_picker_contents' hook
	 *
	 * @return string $content    The content for the icon picker
	 */
	public function set_menu_icon_picker_contents( $id = '', $selected_icon = '' ) {
		$content       = '';
		$icons         = IconLibrary::GetIcons();
		$get_menu_icon = '';
		$is_selected   = '';
		$icon_category = '';
		if ( ! empty( $id ) ) {

			if ( ! empty( $selected_icon ) ) {
				$get_menu_icon = $selected_icon;
			}
			$icon_categories = array_unique( $icons );

			$content             .= '<div class="nifty-header-wrapper">';
				$content         .= '<div class="nifty-inner-wrap wrapper-left">';
					$content     .= '<input type="text" class="nifty-icon-search" id="nifty-icon-search[' . esc_attr( $id ) . ']" placeholder="' . esc_attr( 'Search icons...', 'nifty-menu-options' ) . '">';
				$content         .= '</div>';
				$content         .= '<div class="nifty-inner-wrap wrapper-right">';
					$content     .= '<select name="nifty-icon-category[' . esc_attr( $id ) . ']" class="nifty-icon-category nifty-select" id="nifty-icon-category[' . esc_attr( $id ) . ']">';
						$content .= '<option value="all">' . esc_html__( 'All', 'nifty-menu-options' ) . '</option>';
			foreach ( $icon_categories as $icon => $icon_category ) {
				$content .= '<option value="' . esc_attr( $icon_category ) . '">' . esc_html( $icon_category ) . '</option>';
			}
					$content .= '</select>';
				$content     .= '</div>';
			$content         .= '</div>';

			$content .= '<div class="nifty-message-wrapper">';
			$content .= '</div>';

			$content .= '<ul class="nifty-icon-selector-container">';
			foreach ( $icons as $icon_value => $icon_category ) {

				if ( $icon_value === $get_menu_icon ) {
					$is_selected = 'selected';
				} else {
					$is_selected = '';
				}

				$content         .= '<li class="nifty-icon-item nifty-tooltip" data-icon-name="' . esc_attr( $icon_value ) . '" data-icon-category="' . esc_attr( $icon_category ) . '">';
					$content     .= '<label class="nifty-icon-label ' . esc_attr( $is_selected ) . '">';
						$content .= '<input type="radio" class="nifty-icon-selector" ' . checked( $icon_value, $get_menu_icon, false ) . ' value="' . esc_attr( $icon_value ) . '" data-value="' . esc_attr( $icon_value ) . '" name="nifty-menu-options-icon[' . esc_attr( $id ) . ']" data-id="' . esc_attr( $id ) . '" />';
						$content .= '<i class="material-icons nifty-displayed-icon" data-id="' . esc_attr( $id ) . '">' . esc_html( $icon_value ) . '</i>';
					$content     .= '</label>';
				$content         .= '</li>';
			}
			$content .= '</ul>';
		}
		$content = apply_filters( 'filter_nifty_menu_icon_picker_contents', $content, $id );

		return $content;
	}

	/**
	 * Constructs the Menu Icon Picker Content
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param  int   $menu_id            Current menu ID.
	 * @param  int   $menu_item_db_id    Menu Item ID.
	 * @param  array $menu_item_args     The menu item's data.
	 *
	 * @wp_hook action       wp_update_nav_menu_item
	 *
	 * @return void
	 */
	public static function save_menu_icon( $menu_id, $menu_item_db_id, $menu_item_args ) {
		$nifty_icon_save_meta = array();

		$menu_icon              = '';
		$menu_icon_name         = 'nifty-menu-options-icon';
		$menu_icon_color        = '';
		$menu_icon_color_name   = 'nifty-menu-color';
		$menu_icon_gutter       = '';
		$menu_icon_gutter_array = array();
		$menu_icon_gutter_name  = 'nifty-icon-gutter';
		$menu_icon_size         = '';
		$menu_icon_size_name    = 'nifty-icon-size';
		$remove_icon            = '';
		$remove_icon_name       = 'nifty-remove-icon';
		$filters                = [
			$menu_icon_name        => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_color_name  => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_gutter_name => [
				'filter' => FILTER_SANITIZE_NUMBER_INT,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_size_name   => [
				'filter' => FILTER_SANITIZE_NUMBER_INT,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$remove_icon_name      => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
		];

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen instanceof \WP_Screen || 'nav-menus' !== $screen->id ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		// Sanitize input.
		if ( ! empty( $_POST[ $menu_icon_name ][ $menu_item_db_id ] ) ) {
			$menu_icon = filter_input_array( INPUT_POST, $filters );
			$menu_icon = $menu_icon[ $menu_icon_name ][ $menu_item_db_id ];
		} else {
			$menu_icon = Metabox::get_menu_icon( $menu_item_db_id );
		}

		if ( ! empty( $_POST[ $menu_icon_color_name ][ $menu_item_db_id ] ) ) {
			$menu_icon_color = filter_input_array( INPUT_POST, $filters );
			$menu_icon_color = $menu_icon_color[ $menu_icon_color_name ][ $menu_item_db_id ];
		}

		if ( ! empty( $_POST[ $menu_icon_gutter_name ]['top'][ $menu_item_db_id ] ) ) {
			$menu_icon_gutter              = filter_input_array( INPUT_POST, $filters );
			$menu_icon_gutter_array['top'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['top'][ $menu_item_db_id ];
		}

		if ( ! empty( $_POST[ $menu_icon_gutter_name ]['right'][ $menu_item_db_id ] ) ) {
			$menu_icon_gutter                = filter_input_array( INPUT_POST, $filters );
			$menu_icon_gutter_array['right'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['right'][ $menu_item_db_id ];
		}

		if ( ! empty( $_POST[ $menu_icon_gutter_name ]['bottom'][ $menu_item_db_id ] ) ) {
			$menu_icon_gutter                 = filter_input_array( INPUT_POST, $filters );
			$menu_icon_gutter_array['bottom'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['bottom'][ $menu_item_db_id ];
		}

		if ( ! empty( $_POST[ $menu_icon_gutter_name ]['left'][ $menu_item_db_id ] ) ) {
			$menu_icon_gutter               = filter_input_array( INPUT_POST, $filters );
			$menu_icon_gutter_array['left'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['left'][ $menu_item_db_id ];
		}

		if ( ! empty( $_POST[ $menu_icon_size_name ][ $menu_item_db_id ] ) ) {
			$menu_icon_size = filter_input_array( INPUT_POST, $filters );
			$menu_icon_size = $menu_icon_size[ $menu_icon_size_name ][ $menu_item_db_id ];
		}

		if ( ! empty( $_POST[ $remove_icon_name ][ $menu_item_db_id ] ) ) {
			$remove_icon = filter_input_array( INPUT_POST, $filters );
			$remove_icon = $remove_icon[ $remove_icon_name ][ $menu_item_db_id ];
		}

		if ( 'true' === $remove_icon ) {
			$menu_icon = '';
		}

		if ( ! empty( $menu_icon ) || ! empty( $menu_icon_color ) || ! empty( $menu_icon_gutter_array ) || ! empty( $menu_icon_size ) ) {
			$nifty_icon_save_meta = array(
				'menu_id'       => $menu_item_db_id,
				'icon_name'     => $menu_icon,
				'icon_color'    => $menu_icon_color,
				'icon_library'  => '',
				'icon_category' => '',
				'icon_position' => $menu_icon_gutter_array,
				'icon_size'     => $menu_icon_size,
				'display_icon'  => $remove_icon,
			);

			Metabox::update_menu_icon( $menu_item_db_id, $nifty_icon_save_meta );
		}
	}
}
