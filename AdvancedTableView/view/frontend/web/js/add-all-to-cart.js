define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'mage/translate',
    'mage/cookies',
    'jquery-ui-modules/widget'
], function ($, customer, $t) {
    'use strict';

    $.widget('mage.catalogAddAllToCart', {
        options: {
            processStart: true,
            processStop: true,
            checkboxAutoSelect: true,
            minicartSelector: '[data-block="minicart"]',
            messagesSelector: '[data-placeholder="messages"]',
            productStatusSelector: '.stock.available',
            addToCartButtonSelector: "[data-role='all-tocart']",
            addToCartButtonDisabledClass: 'disabled',
            addToCartButtonText: 'Add All to Cart',
            addToCartButtonTextWhileAdding: '',
            addToCartButtonTextAdded: '',
            addToCartButtonTextDefault: '',
            checkboxSelector: '.product-item-checkbox',
            form: '.tocart-toolbar-select',
            url: '',
        },

        _create: function () {
            if($(".col-qty .input-text").length) {
                this._bindQtyFiller();
            }
            if($(this.options.addToCartButtonSelector).length) {
                this._bindSubmit();
            }
            if($("[data-role='select-all']").length) {
                this._bindSelectAll("[data-role='select-all']");
            }
            $(this.options.addToCartButtonSelector).prop('disabled', false);
        },

        //mass add to cart button submit
        _bindSubmit: function () {
            var self = this;

            $(self.options.addToCartButtonSelector).on('click', () => {
                self.submitForm();
            })
        },

        // visible button is in the other column requiring the actual used input to be auto-filled
        _bindQtyFiller: function () {
            var self = this;

            const elements = '.col-qty .input-text';
            $(elements).each(function() {
                $(this).on('change', function() {
                    const item = $(this).parents('.item');

                    const qty = $(this).val();
                    item.find('.product-item-inner .qty').val(qty > 0 ? qty : 1);

                    // auto select checkbox when input is filled
                    if (self.options.checkboxAutoSelect) {
                        const checkbox = item.find('.product-item-checkbox');

                        if (qty > 0) {
                            checkbox.prop('checked', true);
                        } else {
                            checkbox.prop('checked', false);
                        }
                    }
                });
            });
        },

        // select/deselect all checkbox
        _bindSelectAll: function (element) {
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
        },

        // enable ajax default loader
        isLoaderEnabled: function () {
            return this.options.processStart && this.options.processStop;
        },

        // submit data handler
        submitForm: function () {
            var self = this;

            const products = [];
            $(self.options.checkboxSelector).each((i, item) => {
                const checkbox = $(item);

                if(checkbox.is(':checked')) {
                    const qtySelector = checkbox.parents('.item').find('.product-item-inner .qty');
                    products.push({
                        ids: checkbox.val(),
                        qty: qtySelector.val()
                    })
                }
            })
            
            if(!products.length) {
                alert('you must select at least one item');
                return
            }

            this.ajaxSubmit(products);
        },

        // ajax submit to module controller
        ajaxSubmit: function (products) {
            var self = this;
            self.disableAddToCartButton(self.options.form);

            const url = self.options.url;
            const data = {
                action   : "add-to-cart",
                form_key : $.mage.cookies.get('form_key'),
                products
            }

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url,
                data,

                beforeSend: function(res) {
                    if (self.isLoaderEnabled()) {
                        $('body').trigger('processStart');
                    }
                },

                complete: function (res) {
                    if (self.isLoaderEnabled()) {
                        $('body').trigger('processStop');
                    }
                    self.enableAddToCartButton(self.options.form);
                },

                success: function (res) {
                    var sections = ['cart'];
                    customer.reload(sections);
                    customer.invalidate(sections);
                },

            });
        },

        // add to cart animation
        disableAddToCartButton: function (form) {
            var addToCartButtonTextWhileAdding = this.options.addToCartButtonTextWhileAdding || $t('Adding...'),
                addToCartButton = $(form).find(this.options.addToCartButtonSelector);

            addToCartButton.addClass(this.options.addToCartButtonDisabledClass);
            addToCartButton.find('span').text(addToCartButtonTextWhileAdding);
            addToCartButton.prop('title', addToCartButtonTextWhileAdding);
        },

        // add to cart animation
        enableAddToCartButton: function (form) {
            var addToCartButtonTextAdded = this.options.addToCartButtonTextAdded || $t('Added'),
                self = this,
                addToCartButton = $(form).find(this.options.addToCartButtonSelector);

            addToCartButton.find('span').text(addToCartButtonTextAdded);
            addToCartButton.prop('title', addToCartButtonTextAdded);

            setTimeout(function () {
                var addToCartButtonTextDefault = self.options.addToCartButtonTextDefault || $t(self.options.addToCartButtonText);

                addToCartButton.removeClass(self.options.addToCartButtonDisabledClass);
                addToCartButton.find('span').text(addToCartButtonTextDefault);
                addToCartButton.prop('title', addToCartButtonTextDefault);
            }, 1000);
        }
    });

    return $.mage.catalogAddAllToCart;
});
