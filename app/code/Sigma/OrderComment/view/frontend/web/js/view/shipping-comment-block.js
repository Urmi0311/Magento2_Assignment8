define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Checkout/js/model/quote'
], function(
    $,
    ko,
    Component,
    quote
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Sigma_OrderComment/shipping-comment-block'
        },
        initObservable: function () {
            console.log("Shipping Comment Block Called!!!");

            this.commentTitle = ko.observable(this.setCommentTitle());
            this.commentDescription = ko.observable(this.setCommentDescription());

            // this.selectedMethod = ko.computed(function () {
            //     var method = quote.shippingMethod();
            //     var selectedMethod = method != null ? method.method_code : null;
            //     return selectedMethod;
            // }, this);
            return this;
        },
        setCommentTitle: function () {
            return window.checkoutConfig.commentTitle;
        },
        setCommentDescription: function () {
            return window.checkoutConfig.commentDescription;
        }
    });
});
