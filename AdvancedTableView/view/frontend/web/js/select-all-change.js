define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {
        var itemsDataRole = '[data-role="select-product"]',
            prop = 'checked';

        $(element).on('change', function () {
            var self = $(this);

            $(itemsDataRole, '.products-table table').filter(':enabled')
                .prop('checked', self.prop(prop));
        });

        $(itemsDataRole).on('change', function () {
            var items = $(itemsDataRole),
                checkedItems = items.filter(':checked');

            if (items.length === checkedItems.length && !$(element).prop(prop)) {
                $(element).prop(prop, prop);
            } else if ($(element).prop(prop)) {
                $(element).prop(prop, '');
            }
        });
    };
});
