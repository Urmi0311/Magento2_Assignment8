<?php

namespace Sigma\Fee\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class PercentageOptions implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        for ($i = 5; $i <= 60; $i += 5) {
            $options[] = ['value' => $i, 'label' => $i . '%'];
        }
        return $options;
    }
}
