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

    public function __construct( $set_args = array() )
    {
        $filtered_args = '';
        $defaults_args = array(
            'id'    => esc_attr( 'menu-icon-selector' ),
            'class'  => esc_attr( 'thickbox-container' ),
            'show'  => false,
            'type' => esc_attr( 'inline' ),
            'width' => esc_attr( '600' ),
            'height' => esc_attr( '550' ),
            'url' => '#',
            'link_text' => esc_html__( 'Click to View', 'nifty-menu-options' )
        );

        $filtered_args = array_replace_recursive( $defaults_args, $set_args );

        self::$args = $filtered_args;
    }

    public static function getThickBox()
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
            <div class="thickbox-content">
                <?php self::setThickBoxContent(); ?>
            </div>
        </div>

        <a href="<?php echo $link; ?>" class="thickbox"><?php echo esc_html( $args[ 'link_text' ] ); ?></a>
    <?php }

    /**
     * Get the ID
     *
     * @since  1.0.0
     * @access public
     * @return array args   Returns the arguments for the thickbox.
     */
    public static function setThickBoxContent( $content = '' )
    {
        echo $content;
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
     * Get the ID
     *
     * @since  1.0.0
     * @access public
     * @return boolean args   Returns the arguments for the thickbox.
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
