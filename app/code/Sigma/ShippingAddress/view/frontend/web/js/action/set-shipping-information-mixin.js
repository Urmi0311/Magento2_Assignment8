define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function (
    $,
    wrapper,
    quote
) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();

            // shipping address information
            console.log(shippingAddress);

            if(shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            var attribute= shippingAddress.customAttributes.find(
                function (element) {
                    return element.attribute_code === 'middle_name';
                }
            )

            shippingAddress['extension_attributes']['middle_name'] = attribute.value;

            return originalAction();
        })
    }
})
