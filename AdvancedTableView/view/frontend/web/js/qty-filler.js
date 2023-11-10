define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {

        $(element).on('change', function () {
            const item = $(element).parents('.item');

            item.find('.product-item-inner .qty').val($( this ).val());

            if(config.checkboxAutoSelect) {
                item.find('.product-item-checkbox').prop('checked', true)
            };
        });
    };
});
