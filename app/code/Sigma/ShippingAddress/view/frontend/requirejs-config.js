var config = {
    // config : {
    //     mixins: {
    //         'Magento_Checkout/js/action/set-shipping-information': {
    //             'Sigma_ShippingAddress/js/action/set-shipping-information-mixin': true
    //         }
    //     }
    // },
    "map" : {
        "*": {
            'Magento_Checkout/js/model/shipping-save-processor/default' : 'Sigma_ShippingAddress/js/model/shipping-save-processor/default',
            'Magento_Checkout/template/shipping-information/address-renderer/default.html' : 'Sigma_ShippingAddress/template/shipping-information/address-renderer/default.html'
        }
    }
}
