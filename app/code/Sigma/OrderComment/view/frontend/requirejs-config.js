var config = {
    // config : {
    //     mixins: {
    //         "Magento_Checkout/js/action/place-order" : {
    //             "Sigma_OrderComment/js/action/place-order-mixin": true
    //         }
    //     }
    // },
    "map" : {
        "*" : {
            "Magento_Checkout/js/model/shipping-save-processor/default" : "Sigma_OrderComment/js/model/shipping-save-processor/default"
        }
    }
}
