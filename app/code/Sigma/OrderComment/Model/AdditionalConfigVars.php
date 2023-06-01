<?php

namespace Sigma\OrderComment\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Sigma\OrderComment\Block\OrderConfiguration;

class AdditionalConfigVars implements ConfigProviderInterface
{
    public function __construct(
        private OrderConfiguration $orderConfiguration
    )
    {
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        /** @var $commentTitle $commentTitle */
        $commentTitle = $this->orderConfiguration->getCustomerCommentTitle();

        /** @var $commentDescription $commentDescription */
        $commentDescription = $this->orderConfiguration->getCustomerCommentDescription();

        $additionalVariables['commentTitle'] = $commentTitle;
        $additionalVariables['commentDescription'] = $commentDescription;

        return $additionalVariables;
    }
}
