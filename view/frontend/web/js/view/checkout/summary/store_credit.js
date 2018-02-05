/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'jquery',
        'ko',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/totals',
        'Exto_StoreCredit/js/action/apply-store-credit'
    ],
    function ($, ko, Component, quote, priceUtils, totals, applyStoreCreditAction) {
        "use strict";
        var isLoading = ko.observable(false);
        return Component.extend({
            defaults: {
                isFullTaxSummaryDisplayed: window.checkoutConfig.isFullTaxSummaryDisplayed || false,
                template: 'Exto_StoreCredit/checkout/summary/store_credit'
            },
            totals: quote.getTotals(),
            isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,
            isDisplayed: function() {
                return this.isFullMode();
            },
            getValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = totals.getSegment('store_credit').value;
                }
                return this.getFormattedPrice(price);
            },
            getPoints: function() {
                var points = 0;
                if (this.totals()) {
                    points = totals.getSegment('store_credit').value;
                }
                return points;
            },
            getBaseValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = this.totals().base_fee;
                }
                return priceUtils.formatPrice(price, quote.getBasePriceFormat());
            },
            apply: function() {
                if (this.validate()) {
                    isLoading(true);
                    var pointsAmount = $('#store-credit-points').val();
                    applyStoreCreditAction(pointsAmount, isLoading);
                }
            },
            validate: function() {
                var form = '#store-credit-form';
                return $(form).validation() && $(form).validation('isValid');
            }
        });
    }
);