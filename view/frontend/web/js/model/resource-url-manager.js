/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/url-builder',
        'mageUtils'
    ],
    function(customer, urlBuilder, utils) {
        "use strict";
        return {
            getApplyPointsUrl: function(pointsAmount, quoteId) {
                var params = {};
                var urls = {
                    'default': '/storecredit/applypoints/points/' + pointsAmount
                };
                return urlBuilder.createUrl(urls, params);
            }
        };
    }
);
