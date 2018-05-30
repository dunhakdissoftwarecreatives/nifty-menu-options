jQuery(document).ready( function($) {
    "use strict";

    // $( '.nifty-icon-selector-container .nifty-checkbox' ).on('change', function() {
    //    $('.nifty-checkbox[type="checkbox"]').not(this).prop('checked', false);
    // });
    $('.nifty-icon-picker').on( 'click', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',

            dataType: 'json',

            url: nifty_menu_options_admin_object.ajaxurl,

            data: {
                'action': 'niftyAdminAjax', //calls niftyAdminAjax

                'nifty-menu-id': $( this ).siblings('.nifty-menu-settings').find('.nifty-menu-id').attr('value'),
            },

            beforeSend: function(){
                $('.nifty-thickbox-content').addClass('loading').html(nifty_menu_options_admin_object.loading);
            },

            success: function(response) {

                // console.log( response.status );
                if (response.status == 202) {
                    $('#TB_ajaxContent .nifty-thickbox-content').removeClass('loading').html(response.nifty_icon_picker_list);

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
