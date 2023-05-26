<?php

namespace Sigma\ShippingAddress\Plugin\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteRepository;

class ShippingInformationManagement
{
    /**
     * @param QuoteRepository $quoteRepository
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        private QuoteRepository $quoteRepository,
        private CartRepositoryInterface $cartRepository
    )
    {
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param ShippingInformationInterface $addressInformation

     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation,
    ) {

        if(!$addressInformation->getExtensionAttributes())
        {
            return;
        }

        $quote = $this->cartRepository->getActive($cartId);

        $custom_middle_name_value = $addressInformation->getExtensionAttributes()->getMiddleName();
        $quote->setMiddleName($custom_middle_name_value);
        $this->cartRepository->save($quote);
        return [$cartId, $addressInformation];

    }
}
