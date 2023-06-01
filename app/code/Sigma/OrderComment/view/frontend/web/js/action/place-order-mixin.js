define([
    'jquery',
    'mage/utils/wrapper',
    'Sigma_OrderComment/js/action/shipping-comment-process'
], function (
    $,
    wrapper,
    shippingCommentProcessor
){
    'use strict';

    return function (placeOrderAction) {
        return wrapper.wrap(placeOrderAction, function (
            originalAction,
            paymentData,
            messageContainer
        ){
           shippingCommentProcessor(paymentData);

           return originalAction(paymentData, messageContainer);
        });
    }
});
