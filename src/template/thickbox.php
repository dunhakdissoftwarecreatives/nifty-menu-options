<?php
/**
 * Create ThickBox
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\ThickBox
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
 * The class that handles Menu Icon picker.
 *
 * @category NiftyMenuOptions\ThickBox
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
class ThickBox
{
    /**
     * The arguments for the ThickBox.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $id    The current version of the plugin.
     */
    public static $args = array();

    /**
	 * Constructor of the class
	 *
	 * @since  1.0.0
	 * @access public
	 *
     * @param  array    $set_args The Arguments for the tickbox component
     * @uses   add_filter() Calls 'DSC/NiftyMenuOptions/ThickBox/defaults_args' hook
     *
	 * @return void
	 */
    public function __construct( $set_args = array() )
    {
        $filtered_args = '';
        apply_filters(
            'DSC/NiftyMenuOptions/ThickBox/defaults_args',
            $defaults_args = array(
                'id'    => esc_attr( 'thickbox-selector' ),
                'class'  => esc_attr( 'thickbox-container' ),
                'content_class'  => esc_attr( 'thickbox-content-container' ),
                'button_class'  => esc_attr( 'thickbox-btn' ),
                'show'  => false,
                'type' => esc_attr( 'inline' ),
                'width' => esc_attr( '600' ),
                'height' => esc_attr( '550' ),
                'url' => '#',
                'link_text' => esc_html__( 'Click to View', 'nifty-menu-options' ),
                'link_text_before' => '',
                'link_text_after' => '',
            )
        );

        $filtered_args = array_replace_recursive( $defaults_args, $set_args );

        self::$args = $filtered_args;

        return;
    }

    /**
	 * Displays the Thichbox
	 *
	 * @since  1.0.0
	 * @access public
	 *
     * @param  string   $thickbox_content The content for the thickbox component
     *
	 * @return void
	 */
    public static function getThickBox( $thickbox_content = '' )
    { ?>
        <?php
                $link = '';
                $args = self::getArgs();

                if ( 'inline' === $args[ 'type' ] ) {
                    $link = '#TB_inline?width='. esc_attr( absint( $args[ 'width' ] ) ) .'&height='. esc_attr( absint( $args[ 'height' ] ) ) .'&inlineId='. esc_attr( $args[ 'id' ] );
                }
                if ( 'iframe' === $args[ 'type' ] ) {
                    $link = esc_url( $args[ 'url' ] ) .'?TB_iframe=true&width='. esc_attr( absint( $args[ 'width' ] ) ) .'&height='. esc_attr( absint( $args[ 'height' ] ) );
                }
            ?>

            <div id="<?php echo esc_attr( $args['id'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>" <?php echo self::isDisplayed(); ?> >
                <div class="thickbox-content <?php echo esc_attr( $args['content_class'] ); ?>">
                    <?php echo $thickbox_content; ?>
                </div>
            </div>

            <a href="<?php echo $link; ?>" class="thickbox <?php echo esc_attr( $args['button_class'] ); ?>">
                <?php echo $args[ 'link_text_before' ]; ?>
                <span class="thickbox-link-text"><?php echo esc_html( $args[ 'link_text' ] ); ?></span>
                <?php echo $args[ 'link_text_after' ]; ?>
            </a>
        <?php
        return;
    }

    /**
     * Get the ID
     *
     * @since  1.0.0
     * @access public
     * @return array args   Returns the arguments for the thickbox.
     */
    public static function getArgs()
    {
        return self::$args;
    }

    /**
     * Check if the thickbox set to be displayed.
     *
     * @since  1.0.0
     * @access public
     * @return string Returns display none.
     */
    public static function isDisplayed()
    {
        $args = self::getArgs();

        if ( false === $args['show'] ) {
            return 'style="display: none;"';
        }

        return;
    }
}
