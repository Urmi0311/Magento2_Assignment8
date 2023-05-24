<?php
namespace Sigma\FreeShippingBar\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;

class Freeshipping extends Template
{
    protected $scopeConfig;
    protected $checkoutSession;
    protected $priceHelper;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        Session $checkoutSession,
        PricingHelper $priceHelper,
        array $data = []
    ){
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    public function displayMessage()
    {
        if ($this->isFreeEnabled()) {
            $subtotal = $this->gettotal();
            $cutoffAmount = $this->getCutoff();
            if ($subtotal >= $cutoffAmount) {
                $message = __('Congratulations! You are eligible for free shipping.');
            } else {
                $remainingAmount = $cutoffAmount - $subtotal;
                $message = __('You are %1 away from free shipping.', $this->priceHelper->currency($remainingAmount, true, false));
            }
            return $message;
        }
        return false;
    }

    public function gettotal()
    {
        return $this->checkoutSession->getQuote()->getSubtotal();
    }

    public function isFreeEnabled()
    {
        return $this->scopeConfig->isSetFlag('sigma_freeshippingbar/general/enable_disable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getCutoff()
    {
        return $this->scopeConfig->getValue('sigma_freeshippingbar/general/free_shipping_cutoff', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}

