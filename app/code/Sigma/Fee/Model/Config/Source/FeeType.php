<?php

namespace Sigma\Fee\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class FeeType implements ArrayInterface
{
    /**
     * Retrieve fee types
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 'percentage',
                'label' => __('Percentage')
            ],
            [
                'value' => 'fixed',
                'label' => __('Fixed')
            ]
        ];
    }
}
