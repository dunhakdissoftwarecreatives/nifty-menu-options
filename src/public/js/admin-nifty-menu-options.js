jQuery(document).ready( function($) {
    "use strict";

    $( 'body' ).on( 'click', '#TB_ajaxContent .nifty-icon-selector', function(e) {
       var $selected_icon = $(this).attr('value');
       var $selected_icon_id = $(this).attr('data-id');

       $( '.thickbox-link-text-' + $selected_icon_id ).text( nifty_menu_options_admin_object.change_icon );

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

    $( document ).on( 'change', '.nifty-icon-category', function () {
        var $selected_category = $(this).find('option:selected').attr('value');
        var $list = $(this).parents('.nifty-header-wrapper').siblings('.nifty-icon-selector-container');
        var $items = $list.find('.nifty-icon-item');
        var $item_category = $items.attr('data-icon-category');
        var $selected_items = $list.find('.nifty-icon-item[data-icon-category="' + $selected_category + '"]');

        $items.addClass('hide');

        if ( 'all' === $selected_category ) {
            $items.removeClass('hide');
        }

        $selected_items.removeClass('hide');
    });

    $( document ).on( 'change paste keyup', ".nifty-icon-search", function() {
        var searched_item = '';
        var searched_item_regex = '';
        var searched_result = '';
        var searched_value = $(this).attr('value');
        var $parent = $(this).parents('.nifty-header-wrapper');
        var $parent_sibling = $parent.siblings('.nifty-icon-selector-container');
        var items = $parent_sibling.find(".nifty-icon-item"); //contain all unfiltered items

        var $selected_category = $parent.find('.nifty-icon-category').attr('value');
        var $item_category = '';

        $.each( items, function(index, item) {
            $(item).addClass('hide');
        }); //hide all items

        searched_item = $(this).attr('value'); //get entered value of input field

        if ( nifty_alpha_numeric( searched_value ) || '' == searched_value ) {

            searched_item_regex = new RegExp( searched_item, "i"); //convert search value into RegExp
            searched_result = $.grep(items, function (n) {
                // console.log(n.attributes['NamedNodeMap']);
                return searched_item_regex.test( n.attributes.getNamedItem('data-icon-name').value );
            }); //Returns array that matches search value

        }

        if( $.isEmptyObject( searched_result ) ) {
            if ( '' == searched_value ) {
                $('.nifty-message-wrapper').hide();
            } else {
                $('.nifty-message-wrapper').html( nifty_menu_options_admin_object.search_nothing_found ).hide().fadeIn();
                $('.nifty-message').find('.search-icon-name').text( searched_value );
                $('.nifty-message').find('.search-icon-category').text( $selected_category );
            }

            if ( false == nifty_alpha_numeric( searched_value ) ) {
                $('.nifty-message-wrapper').html( nifty_menu_options_admin_object.search_invalid ).hide().fadeIn();
                $('.nifty-message').find('.search-icon-name').text( searched_value );
            } else {
                if( false == $.isEmptyObject( searched_result ) ) {
                    $('.nifty-message-wrapper').html( nifty_menu_options_admin_object.search_nothing_found ).hide().fadeIn();
                    $('.nifty-message').find('.search-icon-name').text( searched_value );
                    $('.nifty-message').find('.search-icon-category').text( $selected_category );
                }
            }
        }
        if( false === $.isEmptyObject( searched_result ) ) {
            $('.nifty-message-wrapper').hide();
        }

        $.each( searched_result, function(index, item) {
            var $item_category = $(item).attr('data-icon-category');

            $('.nifty-message-wrapper').hide();

            if ( 'all' === $selected_category ) {
                $(item).removeClass('hide');
            }
            if ( $item_category === $selected_category ) {
                $(item).removeClass('hide');
            }
        }); //show matched search value
    });

    $('.nifty-remove-icon').on( 'click', function(e) {
        e.preventDefault();
        $( this ).siblings('.nifty-icon-picker').find('.thickbox-link-text').text( nifty_menu_options_admin_object.add_icon );
        $( this ).siblings('.nifty-icon-picker').find('.nifty-icon-selected').text( '' );
        $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').val('');
        $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected').removeClass('selected');
        $( this ).siblings('.nifty-menu-settings').find('.nifty-remove-icon-field').attr( 'value', 'true' );
    });

    $('.nifty-icon-picker').on( 'click', function(e) {
        e.preventDefault();
        var new_selected_icon = '';
        var $menu_id = $( this ).siblings('.nifty-menu-settings').find('.nifty-menu-id').attr('value');
        var $selected_icon = $( this ).find('.nifty-icon-selected').text();
        var data_value = $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').attr('data-value');

        $( this ).siblings('.nifty-menu-settings').find('.nifty-remove-icon-field').attr( 'value', 'false' );

        $( this ).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').val(data_value);

        $.ajax({
            type: 'POST',

            dataType: 'json',

            url: nifty_menu_options_admin_object.ajaxurl,

            data: {
                'action': 'nifty_admin_ajax', //calls nifty_admin_ajax

                'nifty-setting': 'nifty-icon-picker',

                'nifty-menu-id': $menu_id,

                'selected-icon': $selected_icon,
            },

            beforeSend: function(){
                setTimeout(function(){
                    $('#TB_ajaxContent').addClass('nifty-thickbox-modal');
                    $('#TB_title').addClass('nifty-thickbox-title');
                    $('#TB_ajaxWindowTitle').append(nifty_menu_options_admin_object.thickbox_title);
                }, 100);
                $(this).siblings('.nifty-thickbox-container').find('.nifty-thickbox-content').addClass('loading').html(nifty_menu_options_admin_object.loading);
            },

            success: function( response ) {

                // console.log( response.status );
                if ( response.status == 202 ) {
                    $( '#TB_ajaxContent .nifty-thickbox-content' ).removeClass( 'loading' ).html( response.nifty_icon_picker_list );

                    new_selected_icon = $( '#TB_ajaxContent .nifty-thickbox-content' ).find( '.nifty-icon-label.selected .nifty-displayed-icon' ).text();

                    $( this ).siblings('.nifty-icon-picker').find('.nifty-icon-selected').text(new_selected_icon);
                }
            }

        });
    });

    $( '.nifty-icon-color-picker' ).wpColorPicker({
        defaultColor: true,
        // a callback to fire whenever the color changes to a valid color
        change: function(event, ui) {
            var hexcolor = $( this ).wpColorPicker( 'color' );
            $( this ).parents( '.nifty-icon-color-picker-wrap' ).siblings('.nifty-icon-selector-wrap').find('.nifty-icon-selected').css( 'color', hexcolor );
        }
	});

    function nifty_alpha_numeric( txt ) {
        var alphanumeric = /^[a-z\d\-_\s]+$/i;  // Allow only alphanumeric and space

        if ( txt.match( alphanumeric ) )  {
            return true;
        } else {
            return false;
        }
    }
});
