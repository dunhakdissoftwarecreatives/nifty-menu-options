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
		$get_menu_icon          = Metabox::get_menu_icon( $get_current_menu_id, $id );
		$get_menu_icon_library  = Metabox::get_menu_icon_library( $get_current_menu_id, $id );
		$get_menu_icon_category  = Metabox::get_menu_icon_category( $get_current_menu_id, $id );
		$get_menu_icon_color    = Metabox::get_menu_icon_color( $get_current_menu_id, $id );
		$get_menu_icon_position = Metabox::get_menu_icon_position( $get_current_menu_id, $id );
		$icon_position          = $get_menu_icon_position['position'];
		$get_menu_icon_size     = Metabox::get_menu_icon_size( $get_current_menu_id, $id );
		$icon_size              = $get_menu_icon_size['size'];
		$min                    = nifty_menu_options_default_min_position();
		$default_color          = nifty_menu_options_default_color();

		$link_text          = esc_html__( 'Change Icon', 'nifty-menu-options' );
		$gutter_placeholder = esc_attr__( '0', 'nifty-menu-options' );
		$size_placeholder   = esc_attr__( '24', 'nifty-menu-options' );

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

		do_action( 'nifty_menu_options_before_menu_item_settings_field' ); ?>

		<div class="nifty-menu-options-settings-container description-wide">
			<p class="description">
				<label><?php echo esc_html__( 'Nifty Menu Options', 'nifty-menu-options' ); ?></label>
			</p>
			<div class="nifty-menu-options-settings-inner">
				<div class="nifty-icon-selector-wrap nifty-section">
					<?php $thickbox_class->get_thickbox(); ?>

					<a href="#" class="nifty-remove-icon" title="<?php echo esc_attr__( 'Remove Icon', 'nifty-menu-options' ); ?>"><i class="dashicons-before dashicons-trash"></i></a>

					<div class="_settings hidden nifty-menu-settings">
						<input type="hidden" class="nifty-menu-options-icon-field" id="nifty-menu-options-icon-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $get_menu_icon ); ?>">
						<input type="hidden" class="nifty-menu-options-icon-library-field" id="nifty-menu-options-icon-library-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-library[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $get_menu_icon_library ); ?>">
						<input type="hidden" class="nifty-menu-options-icon-category-field" id="nifty-menu-options-icon-category-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-category[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $get_menu_icon_category ); ?>">
						<input type="hidden" class="nifty-menu-id" name="nifty-menu-options-menu-id" value="<?php echo esc_attr( $id ); ?>">
						<input type="hidden" class="nifty-remove-icon-field" name="nifty-menu-options-remove-icon[<?php echo esc_attr( $id ); ?>]" value="">
					</div>
				</div>
				<div class="nifty-icon-color-picker-wrap nifty-section">
					<input type="text" value="<?php echo esc_attr( $get_menu_icon_color ); ?>" class="nifty-icon-color-picker" data-default-color="<?php echo esc_attr( $default_color ); ?>" id="nifty-menu-color-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-color[<?php echo esc_attr( $id ); ?>]" />
				</div>
				<div class="nifty-icon-gutters-wrap label_vcenter nifty-section">
					<label for="nifty-icon-gutter-top-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Top:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['top'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-top-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-gutter[top][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
					<label for="nifty-icon-gutter-right-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Right:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['right'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-right-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-gutter[right][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
					<label for="nifty-icon-gutter-bottom-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Bottom:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['bottom'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-bottom-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-gutter[bottom][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
					<label for="nifty-icon-gutter-left-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Left:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_position['left'] ); ?>" min="<?php echo esc_attr( $min ); ?>" class="nifty-icon-gutter nifty-number-field small-text" id="nifty-icon-gutter-left-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-gutter[left][<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $gutter_placeholder ); ?>"/>
				</div>
				<div class="nifty-icon-size-wrap label_vcenter nifty-section">
					<label for="nifty-icon-size-<?php echo esc_attr( $id ); ?>"><?php echo esc_html__( 'Icon Size:', 'nifty-menu-options' ); ?></label>
					<input type="number" value="<?php echo esc_attr( $icon_size ); ?>" min="0" class="nifty-icon-size nifty-number-field small-text" id="nifty-icon-size-<?php echo esc_attr( $id ); ?>" name="nifty-menu-options-icon-size[<?php echo esc_attr( $id ); ?>]" placeholder="<?php echo esc_attr( $size_placeholder ); ?>"/>
				</div>
			</div>
		</div>

		<?php
		do_action( 'nifty_menu_options_after_menu_item_settings_field' );
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
	 * @uses   add_filter()    Calls 'nifty_menu_options_default_icon_library_filter' hook
	 * @uses   add_filter()    Calls 'nifty_menu_options_icon_picker_contents_filter' hook
	 *
	 * @return string $content    The content for the icon picker
	 */
	public function set_menu_icon_picker_contents( $id = '', $selected_icon = '', $icon_library = '' ) {
		$content       = '';
		$icons         = '';
		$get_menu_icon = '';
		$get_icon_library = '';
		$is_selected   = '';
		$icon_category = '';
		if ( ! empty( $id ) ) {

			if ( ! empty( $selected_icon ) ) {
				$get_menu_icon = $selected_icon;
			}

			if ( empty( $icon_library ) ) {
				$icon_library = 'material_icons';
				$get_icon_library = apply_filters( 'nifty_menu_options_default_icon_library_filter', $icon_library );
			}

			$icons = IconLibrary::GetIcons( $get_icon_library );
			$libraries = IconLibrary::getLibrariesNames( $get_icon_library );

			$icon_categories = array_unique( $icons );

			$content             .= '<div class="nifty-header-wrapper">';
				$content         .= '<div class="nifty-inner-wrap wrapper-left">';
					$content     .= '<input type="text" class="nifty-icon-search" id="nifty-icon-search[' . esc_attr( $id ) . ']" placeholder="' . esc_attr( 'Search icons...', 'nifty-menu-options' ) . '">';
				$content         .= '</div>';
				$content         .= '<div class="nifty-inner-wrap wrapper-center">';
					$content     .= '<select name="nifty-menu-options-icon-category[' . esc_attr( $id ) . ']" class="nifty-icon-category nifty-select" id="nifty-icon-category[' . esc_attr( $id ) . ']">';
						$content .= '<option value="all">' . esc_html__( 'All', 'nifty-menu-options' ) . '</option>';
							foreach ( $icon_categories as $icon => $icon_category ) {
								$content .= '<option value="' . esc_attr( $icon_category ) . '">' . esc_html( $icon_category ) . '</option>';
							}
					$content .= '</select>';
				$content     .= '</div>';
				$content         .= '<div class="nifty-inner-wrap wrapper-right">';
					$content     .= '<select name="nifty-menu-options-icon-library[' . esc_attr( $id ) . ']" class="nifty-icon-library nifty-select" id="nifty-icon-library[' . esc_attr( $id ) . ']">';
							foreach ( $libraries as $library ) {
								$content .= '<option value="' . esc_attr( $library['value'] ) . '">' . esc_html( $library['name'] ) . '</option>';
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

				$content         .= '<li class="nifty-icon-item nifty-menu-item-icon-selector nifty-tooltip" data-icon-name="' . esc_attr( $icon_value ) . '">';
					$content     .= '<label class="nifty-icon-label ' . esc_attr( $is_selected ) . '">';
						$content .= '<input type="radio" class="nifty-icon-selector" ' . checked( $icon_value, $get_menu_icon, false ) . ' value="' . esc_attr( $icon_value ) . '" name="nifty-menu-options-icon-picker[' . esc_attr( $id ) . ']" data-menu-item-id="' . esc_attr( $id ) . '" data-icon-name="' . esc_attr( $icon_value ) . '" data-icon-category="' . esc_attr( $icon_category ) . '" data-icon-library="' . esc_attr( $get_icon_library ) . '" />';
						$content .= '<i class="material-icons nifty-displayed-icon" data-id="' . esc_attr( $id ) . '">' . esc_html( $icon_value ) . '</i>';
					$content     .= '</label>';
				$content         .= '</li>';
			}
			$content .= '</ul>';
		}
		$content = apply_filters( 'nifty_menu_options_icon_picker_contents_filter', $content, $id );

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

		$nifty_menu_options_db_item = array();
		$nifty_icon_save_meta = array();

		$base_id                  = 'menu-item-db-id';
		$menu_icon                = '';
		$menu_icon_name           = 'nifty-menu-options-icon';
		$menu_icon_library        = '';
		$menu_icon_library_name   = 'nifty-menu-options-icon-library';
		$menu_icon_category       = '';
		$menu_icon_category_name  = 'nifty-menu-options-icon-category';
		$menu_icon_color          = '';
		$menu_icon_color_name     = 'nifty-menu-options-icon-color';
		$menu_icon_gutter         = '';
		$menu_icon_gutter_array   = array(
			'top'    => '',
			'right'  => '',
			'bottom' => '',
			'left'   => '',
		);
		$menu_icon_gutter_name    = 'nifty-menu-options-icon-gutter';
		$menu_icon_size           = '';
		$menu_icon_size_name      = 'nifty-menu-options-icon-size';
		$remove_icon              = '';
		$remove_icon_name         = 'nifty-menu-options-remove-icon';

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! $screen instanceof \WP_Screen || 'nav-menus' !== $screen->id ) {
			return;
		}

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		$filters                  = [
			$menu_icon_name          => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_library_name  => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_category_name => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_color_name    => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_gutter_name   => [
				'filter' => FILTER_SANITIZE_NUMBER_INT,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$menu_icon_size_name     => [
				'filter' => FILTER_SANITIZE_NUMBER_INT,
				'flags'  => FILTER_FORCE_ARRAY,
			],
			$remove_icon_name        => [
				'filter' => FILTER_SANITIZE_STRING,
				'flags'  => FILTER_FORCE_ARRAY,
			],
		];

		$nifty_menu_options_item_ids = isset ( $_POST[$base_id] ) ? $_POST[$base_id]: '';

		foreach( $nifty_menu_options_item_ids as $key )  {
			$item_id              =  isset ( $_POST[$base_id][$key] ) ? $_POST[$base_id][$key]: '';
			$item_icon            =  isset ( $_POST[$menu_icon_name][$key] ) ? $_POST[$menu_icon_name][$key]: '';
			$item_library         =  isset ( $_POST[$menu_icon_library_name][$key] ) ? $_POST[$menu_icon_library_name][$key]: '';
			$item_category        =  isset ( $_POST[$menu_icon_category_name][$key] ) ? $_POST[$menu_icon_category_name][$key]: '';
			$item_color           =  isset ( $_POST[$menu_icon_color_name][$key] ) ? $_POST[$menu_icon_color_name][$key]: '';

			$item_position_top    =  isset ( $_POST[$menu_icon_gutter_name]['top'][$key] ) ? $_POST[$menu_icon_gutter_name]['top'][$key]: '';
			$item_position_right  =  isset ( $_POST[$menu_icon_gutter_name]['right'][$key] ) ? $_POST[$menu_icon_gutter_name]['right'][$key]: '';
			$item_position_bottom =  isset ( $_POST[$menu_icon_gutter_name]['bottom'][$key] ) ? $_POST[$menu_icon_gutter_name]['bottom'][$key]: '';
			$item_position_left   =  isset ( $_POST[$menu_icon_gutter_name]['left'][$key] ) ? $_POST[$menu_icon_gutter_name]['left'][$key]: '';

			$item_size            =  isset ( $_POST[$menu_icon_size_name][$key] ) ? $_POST[$menu_icon_size_name][$key]: '';
			$item_display         =  isset ( $_POST[$remove_icon_name][$key] ) ? $_POST[$remove_icon_name][$key]: '';

			if ( ! empty( $item_icon ) ) {
				$menu_icon = filter_input_array( INPUT_POST, $filters );
				$menu_icon = $menu_icon[ $menu_icon_name ][ $key ];
			}

			if ( ! empty( $item_library ) ) {
				$menu_icon_library = filter_input_array( INPUT_POST, $filters );
				$menu_icon_library = $menu_icon_library[ $menu_icon_library_name ][ $key ];
			}

			if ( ! empty( $item_category ) ) {
				$menu_icon_category = filter_input_array( INPUT_POST, $filters );
				$menu_icon_category = $menu_icon_category[ $menu_icon_category_name ][ $key ];
			}

			if ( ! empty( $item_color ) ) {
				$menu_icon_color = filter_input_array( INPUT_POST, $filters );
				$menu_icon_color = $menu_icon_color[ $menu_icon_color_name ][ $key ];
			}

			if ( is_numeric( $item_position_top ) ) {
				$menu_icon_gutter              = filter_input_array( INPUT_POST, $filters );
				$menu_icon_gutter_array['top'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['top'][ $key ];
			}

			if ( is_numeric( $item_position_right ) ) {
				$menu_icon_gutter                = filter_input_array( INPUT_POST, $filters );
				$menu_icon_gutter_array['right'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['right'][ $key ];
			}

			if ( is_numeric( $item_position_bottom ) ) {
				$menu_icon_gutter                 = filter_input_array( INPUT_POST, $filters );
				$menu_icon_gutter_array['bottom'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['bottom'][ $key ];
			}

			if ( is_numeric( $item_position_left ) ) {
				$menu_icon_gutter               = filter_input_array( INPUT_POST, $filters );
				$menu_icon_gutter_array['left'] = $menu_icon_gutter[ $menu_icon_gutter_name ]['left'][ $key ];
			}

			if ( is_numeric( $item_size ) ) {
				$menu_icon_size = filter_input_array( INPUT_POST, $filters );
				$menu_icon_size = $menu_icon_size[ $menu_icon_size_name ][ $key ];
			}

			if ( ! empty( $item_display ) ) {
				$remove_icon = filter_input_array( INPUT_POST, $filters );
				$remove_icon = $remove_icon[ $remove_icon_name ][ $key ];
			}

			if ( 'true' === $remove_icon ) {
				$menu_icon = '';
			}

			$nifty_menu_options_db_item[$key] = array(
				$base_id                 => $item_id,
				$menu_icon_name          => $menu_icon,
				$menu_icon_library_name  => $menu_icon_library,
				$menu_icon_category_name => $menu_icon_category,
				$menu_icon_color_name    => $menu_icon_color,
				$menu_icon_gutter_name   => array(
					'top'    => $menu_icon_gutter_array['top'],
					'right'  => $menu_icon_gutter_array['right'],
					'bottom' => $menu_icon_gutter_array['bottom'],
					'left'   => $menu_icon_gutter_array['left'],
				),
				$menu_icon_size_name => $menu_icon_size,
				$remove_icon_name => $remove_icon,
			);
		}
		$get_menu_icon_meta = get_post_meta( $menu_id, 'nifty-menu-options-meta-key', true );

		Metabox::update_menu_icon( $menu_id, $nifty_menu_options_db_item );
	}
}
