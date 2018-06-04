jQuery(document).ready( function($) {
    "use strict";

    $( 'body' ).on( 'click', '#TB_ajaxContent .nifty-icon-selector', function(e) {
       var $selected_icon = $(this).attr('value');
       var $selected_icon_id = $(this).attr('data-id');

       $( '.nifty-icon-label' ).removeClass( 'selected' );
       $( this ).parent().addClass( 'selected' );
       $( '.nifty-icon-selected-' + $selected_icon_id ).text( $selected_icon );

        $( '#TB_window' ).fadeOut( 'fast', function() {
           $( '#TB_window, #TB_overlay, #TB_HideSelect' ).trigger( 'tb_unload' ).unbind().remove();
           $( 'body' ).trigger( 'thickbox:removed' );
           $( 'body' ).removeClass( 'modal-open' );
           $(document).unbind('.thickbox');
        });
    });

    $('.nifty-remove-icon').on( 'click', function(e) {
        e.preventDefault();
        $( this ).siblings('.nifty-icon-picker').find('.thickbox-link-text').text( nifty_menu_options_admin_object.add_icon );
        $( this ).siblings('.nifty-icon-picker').find('.nifty-icon-selected').text('');
        $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').val('');
        $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected').removeClass('selected');
    });

    $('.nifty-icon-picker').on( 'click', function(e) {
        e.preventDefault();
        var new_selected_icon = '';
        var $menu_id = $( this ).siblings('.nifty-menu-settings').find('.nifty-menu-id').attr('value');
        var $selected_icon = $( this ).find('.nifty-icon-selected').text();
        var data_value = $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').attr('data-value');

        $( this ).find('.thickbox-link-text').text( nifty_menu_options_admin_object.change_icon );
        $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').val(data_value);

        $.ajax({
            type: 'POST',

            dataType: 'json',

            url: nifty_menu_options_admin_object.ajaxurl,

            data: {
                'action': 'niftyAdminAjax', //calls niftyAdminAjax

                'nifty-setting': 'nifty-icon-picker',

                'nifty-menu-id': $menu_id,

                'selected-icon': $selected_icon,
            },

            beforeSend: function(){
                setTimeout(function(){
                    $('#TB_title').addClass('nifty-thickbox-title');
                    $('#TB_ajaxWindowTitle').append(nifty_menu_options_admin_object.thickbox_title);
                }, 2000);
                $(this).siblings('.nifty-thickbox-container').find('.nifty-thickbox-content').addClass('loading').html(nifty_menu_options_admin_object.loading);
            },

            success: function( response ) {

                // console.log( response.status );
                if ( response.status == 202 ) {
                    $( '#TB_ajaxContent .nifty-thickbox-content' ).removeClass( 'loading' ).html( response.nifty_icon_picker_list );

                    new_selected_icon = $( '#TB_ajaxContent .nifty-thickbox-content' ).find( '.nifty-icon-label.selected .nifty-displayed-icon' ).text();

                    $( this ).siblings('.nifty-icon-picker').find('.nifty-icon-selected').text(new_selected_icon);
                } else {
                }
            }

        });
    });

    $( '.nifty-icon-color-picker' ).wpColorPicker();
    // $('.nifty-icon-color-picker').parents('.wp-picker-container').on( 'click', function(e) {
    //     e.preventDefault();
    //     console.log( $(this).find('.wp-color-result').attr('style', 'background-color') );
    //     console.log( $(this).find('.nifty-icon-color-picker').attr('name') );
    //     console.log( $(this).find('.nifty-icon-color-picker').attr('name') );
    //     console.log( $(this).find('.nifty-icon-color-picker').val() );
    // });
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

});
