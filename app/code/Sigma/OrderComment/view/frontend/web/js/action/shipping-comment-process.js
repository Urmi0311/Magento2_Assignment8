define([
    'jquery'
], function (
    $
) {
   'use strict';

   return function (paymentData) {
     if(paymentData['extension_attributes'] === undefined) {
         paymentData['extension_attributes'] = {};
     }

     paymentData['extension_attributes']['comment'] = $('[name="shipping_comment"]').val();

     console.log(paymentData);
   };
});

