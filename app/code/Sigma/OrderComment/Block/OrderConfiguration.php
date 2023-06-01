<?php

namespace Sigma\OrderComment\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

class OrderConfiguration extends Template
{
    /**
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        private ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        parent::_construct($context, $data);
    }

    public function getCustomerCommentTitle(){
        return $this->scopeConfig->getValue('order_info_field/general/display_title', ScopeInterface::SCOPE_STORE);
    }

    public function getCustomerCommentDescription(){
        return $this->scopeConfig->getValue('order_info_field/general/display_description', ScopeInterface::SCOPE_STORE);
    }

}
