jQuery(document).ready( function($) {
    "use strict";

    $( '.nifty-icon-color-picker' ).wpColorPicker();
    // $( '.nifty-icon-color-picker' ).each(function() {
    //
	// 	var block	= $( this ).parents( 'div.gppro-input' );
	// 	var target	= $( block ).find( 'input.gppro-color-value' ).data( 'target' );
	// 	var type	= $( block ).find( 'input.gppro-color-value' ).data( 'type' );
	// 	var view	= $( block ).find( 'input.gppro-color-value' ).data( 'view' );
    //
	// 	$( this ).wpColorPicker({
	// 		palettes:   true,
	// 		change:		function( event, ui ) {
	// 			var hexcolor = $( this ).wpColorPicker( 'color' );
	// 			$( block ).find( 'input.gppro-color-value' ).val( hexcolor );
	// 			// trigger the preview set
	// 			if ( $( 'div.gppro-frame-wrap' ).is( ':visible' ) )
	// 				gppro_color_preview( target, type, view, hexcolor );
	// 		}
	// 	});
    //
    //
	// });

    $( 'body' ).on( 'click', '#TB_ajaxContent .nifty-icon-selector', function(e) {
       var $selected_icon = $(this).attr('value');
       var $selected_icon_id = $(this).attr('data-id');

       $( '.nifty-icon-label' ).removeClass( 'selected' );
       $( this ).parent().addClass( 'selected' );
       $( '.nifty-icon-selected-' + $selected_icon_id ).text( $selected_icon );

        $( '#TB_window' ).fadeOut( 'fast', function() {
           $( '#TB_window, #TB_overlay, #TB_HideSelect' ).trigger( 'tb_unload' ).unbind().remove();
           $( 'body' ).trigger( 'thickbox:removed' );
           $(document).unbind('.thickbox');
        });
    });

    $('.nifty-icon-picker').on( 'click', function(e) {
        e.preventDefault();
        var $menu_id = $( this ).siblings('.nifty-menu-settings').find('.nifty-menu-id').attr('value');
        var $selected_icon = $( this ).find('.nifty-icon-selected').text();

        $.ajax({
            type: 'POST',

            dataType: 'json',

            url: nifty_menu_options_admin_object.ajaxurl,

            data: {
                'action': 'niftyAdminAjax', //calls niftyAdminAjax

                'nifty-menu-id': $menu_id,

                'selected-icon': $selected_icon,
            },

            beforeSend: function(){
                $('.nifty-thickbox-content').addClass('loading').html(nifty_menu_options_admin_object.loading);
            },

            success: function( response ) {

                // console.log( response.status );
                if ( response.status == 202 ) {
                    $( '#TB_ajaxContent .nifty-thickbox-content' ).removeClass( 'loading' ).html( response.nifty_icon_picker_list );

                    // $('#confirmed_amount').text(response.confirmed_amount);
                    //
                    // $('.feedback-response-link').text(response.message);
                    //
                    // console.log(response.message);

                } else {

                    console.log(response.message);

                }
            }

        });
    });

});
