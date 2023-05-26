<?php

namespace Sigma\ShippingAddress\Plugin\Checkout\Block;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ){

        $customMiddleNameCode = 'middle_name';

        $customField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'tooltip' => [
                    'description' => 'This is Middle name field',
                ],
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' .$customMiddleNameCode,
            'label' => 'Middle Name',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'sortOrder' => 25,
            'value' => ''
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customMiddleNameCode] = $customField;

        return $jsLayout;
    }
}
