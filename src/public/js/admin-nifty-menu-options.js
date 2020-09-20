jQuery(document).ready(function ($) {
    "use strict";

    $('body').on('click', '#TB_ajaxContent .nifty-icon-selector', function (e) {
        var data_icon_name = $(this).attr('data-icon-name');
        var data_icon_library = $(this).attr('data-icon-library');
        var data_icon_category = $(this).attr('data-icon-category');
        var data_menu_item_id = $(this).attr('data-menu-item-id');
        var input_icon_field_id = '#nifty-menu-options-icon-' + data_menu_item_id;
        var input_icon_library_field_id = '#nifty-menu-options-icon-library-' + data_menu_item_id;
        var input_icon_category_field_id = '#nifty-menu-options-icon-category-' + data_menu_item_id;

        $(input_icon_field_id).attr('value', data_icon_name);
        $(input_icon_library_field_id).attr('value', data_icon_library);
        $(input_icon_category_field_id).attr('value', data_icon_category);

        $('.thickbox-link-text-' + data_menu_item_id).text(nifty_menu_options_admin_object.change_icon);

        $('.nifty-icon-label').removeClass('selected');
        $(this).parent().addClass('selected');
        $('.nifty-icon-selected-' + data_menu_item_id).text(data_icon_name);

        $('#TB_window').fadeOut('fast', function () {
            $('#TB_window, #TB_overlay, #TB_HideSelect').trigger('tb_unload').unbind().remove();
            $('body').trigger('thickbox:removed');
            $('body').removeClass('modal-open');
            $(document).unbind('.thickbox');
        });
    });

    $(document).on('change', '.nifty-icon-category', function () {
        var $selected_category = $(this).find('option:selected').attr('value');
        var $list = $(this).parents('.nifty-header-wrapper').siblings('.nifty-icon-selector-container');
        var $items = $list.find('.nifty-icon-item');
        var $item_category = $items.attr('data-icon-category');
        var $selected_items = $list.find('.nifty-icon-item[data-icon-category="' + $selected_category + '"]');

        $items.addClass('hide');

        if ('all' === $selected_category) {
            $items.removeClass('hide');
        }

        $selected_items.removeClass('hide');
    });

    $(document).on('change paste keyup', ".nifty-icon-search", function () {
        var searched_item = '';
        var searched_item_regex = '';
        var searched_result = '';
        var searched_value = $(this).attr('value');
        var $parent = $(this).parents('.nifty-header-wrapper');
        var $parent_sibling = $parent.siblings('.nifty-icon-selector-container');
        var items = $parent_sibling.find(".nifty-icon-item"); //contain all unfiltered items

        var $selected_category = $parent.find('.nifty-icon-category').attr('value');
        var $item_category = '';

        $.each(items, function (index, item) {
            $(item).addClass('hide');
        }); //hide all items

        searched_item = $(this).attr('value'); //get entered value of input field

        if (nifty_alpha_numeric(searched_value) || '' == searched_value) {

            searched_item_regex = new RegExp(searched_item, "i"); //convert search value into RegExp
            searched_result = $.grep(items, function (n) {
                // console.log(n.attributes['NamedNodeMap']);
                return searched_item_regex.test(n.attributes.getNamedItem('data-icon-name').value);
            }); //Returns array that matches search value

        }

        if ($.isEmptyObject(searched_result)) {
            if ('' == searched_value) {
                $('.nifty-message-wrapper').hide();
            } else {
                $('.nifty-message-wrapper').html(nifty_menu_options_admin_object.search_nothing_found).hide().fadeIn();
                $('.nifty-message').find('.search-icon-name').text(searched_value);
                $('.nifty-message').find('.search-icon-category').text($selected_category);
            }

            if (false == nifty_alpha_numeric(searched_value)) {
                $('.nifty-message-wrapper').html(nifty_menu_options_admin_object.search_invalid).hide().fadeIn();
                $('.nifty-message').find('.search-icon-name').text(searched_value);
            } else {
                if (false == $.isEmptyObject(searched_result)) {
                    $('.nifty-message-wrapper').html(nifty_menu_options_admin_object.search_nothing_found).hide().fadeIn();
                    $('.nifty-message').find('.search-icon-name').text(searched_value);
                    $('.nifty-message').find('.search-icon-category').text($selected_category);
                }
            }
        }
        if (false === $.isEmptyObject(searched_result)) {
            $('.nifty-message-wrapper').hide();
        }

        $.each(searched_result, function (index, item) {
            var $item_category = $(item).attr('data-icon-category');

            $('.nifty-message-wrapper').hide();

            if ('all' === $selected_category) {
                $(item).removeClass('hide');
            }
            if ($item_category === $selected_category) {
                $(item).removeClass('hide');
            }
        }); //show matched search value
    });

    $('body').on('click', '#menu-to-edit .nifty-remove-icon', function (e) {
        e.preventDefault();
        $(this).siblings('.nifty-icon-picker').find('.thickbox-link-text').text(nifty_menu_options_admin_object.add_icon);
        $(this).siblings('.nifty-icon-picker').find('.nifty-icon-selected').text('');
        $(this).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').val('');
        $(this).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected').removeClass('selected');
        $(this).siblings('.nifty-menu-settings').find('.nifty-remove-icon-field').attr('value', 'true');
        $(this).siblings('.nifty-menu-settings').find('.nifty-menu-options-icon-field').attr('value', '');
        $(this).siblings('.nifty-menu-settings').find('.nifty-menu-options-icon-library-field').attr('value', '');
        $(this).siblings('.nifty-menu-settings').find('.nifty-menu-options-icon-category-field').attr('value', '');
    });

    $('body').on('click', '#menu-to-edit .nifty-icon-picker', function (e) {
        e.preventDefault();
        var new_selected_icon = '';
        var $menu_id = $(this).siblings('.nifty-menu-settings').find('.nifty-menu-id').attr('value');
        var $selected_icon = $(this).find('.nifty-icon-selected').text();
        var data_value = $(this).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').attr('data-value');

        $(this).siblings('.nifty-menu-settings').find('.nifty-remove-icon-field').attr('value', 'false');

        $(this).siblings('.nifty-thickbox-container').find('.nifty-icon-label.selected .nifty-icon-selector').val(data_value);

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

            beforeSend: function () {
                setTimeout(function () {
                    $('#TB_ajaxContent').addClass('nifty-thickbox-modal');
                    $('#TB_title').addClass('nifty-thickbox-title');
                    $('#TB_ajaxWindowTitle').append(nifty_menu_options_admin_object.thickbox_title);
                    $('#TB_ajaxContent .nifty-thickbox-content').addClass('loading').html(nifty_menu_options_admin_object.loading);
                }, 100);
            },

            success: function (response) {
                // console.log( response.status );
                if (response.status == 202) {
                    setTimeout(function () {

                        $('#TB_ajaxContent .nifty-thickbox-content').removeClass('loading').html(response.nifty_icon_picker_list);
                        new_selected_icon = $('#TB_ajaxContent .nifty-thickbox-content').find('.nifty-icon-label.selected .nifty-displayed-icon').text();
                        $(this).siblings('.nifty-icon-picker').find('.nifty-icon-selected').text(new_selected_icon);
                        $(this).siblings('.nifty-menu-settings').find('.nifty-menu-options-icon-field').text(new_selected_icon);
                    }, 102);

                }
            },
            error: function () {
                console.log(response);
            }

        });
    });

    $('.nifty-icon-color-picker').wpColorPicker({
        defaultColor: true,
        // a callback to fire whenever the color changes to a valid color
        change: function (event, ui) {
            var hexcolor = $(this).wpColorPicker('color');
            $(this).parents('.nifty-icon-color-picker-wrap').siblings('.nifty-icon-selector-wrap').find('.nifty-icon-selected').css('color', hexcolor);
        }
    });

    $('.submit-add-to-menu').on('click', function () {
        var fixColorPicker__Cron = setInterval(function () {
            $.each($('.nifty-icon-color-picker'), function () {
                if (!$(this).hasClass('wp-color-picker')) {
                    $(this).wpColorPicker({
                        defaultColor: true,
                        // a callback to fire whenever the color changes to a valid color
                        change: function (event, ui) {
                            var hexcolor = $(this).wpColorPicker('color');
                            $(this).parents('.nifty-icon-color-picker-wrap').siblings('.nifty-icon-selector-wrap').find('.nifty-icon-selected').css('color', hexcolor);
                        }
                    });
                }
            });
        }, 500);

        var idle_time = 5000; // 5 Seconds.
        setTimeout(function () {
            window.clearTimeout(fixColorPicker__Cron);
        }, idle_time);
    });

    function nifty_alpha_numeric(txt) {
        var alphanumeric = /^[a-z\d\-_\s]+$/i;  // Allow only alphanumeric and space

        if (txt.match(alphanumeric)) {
            return true;
        } else {
            return false;
        }
    }
});
