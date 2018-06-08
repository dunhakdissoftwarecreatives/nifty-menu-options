<?php
/**
 * Plugin Template Tags
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

if (! defined('ABSPATH')) {
    return;
}

function niftyDump( $content, $display_type = '' )
{
    if ( ! empty( $content ) ) {
        if ( empty( $display_type ) ) {
            $display_type = 'print_r';
        }
        echo '<pre>';
            if ( 'echo' === $display_type ) {
                echo $content;
            }
            if ( 'print_r' === $display_type ) {
                print_r( $content );
            }
            if ( 'var_dump' === $display_type ) {
                var_dump( $content );
            }
        echo '</pre>';
    }

    return;
}

function nifty_sanity_check( $mixed_data ) {
	if ( ! empty ( $mixed_data ) ) {
		return $mixed_data;
	}
	return "";
}

function nifty_default_color() {
    $color = apply_filters( 'filter_nifty_default_color', '#9e9e9e' );

    return $color;
}
function nifty_default_position_min() {
    $min = apply_filters( 'filter_nifty_default_position_min', '-200' );

    return $min;
}
