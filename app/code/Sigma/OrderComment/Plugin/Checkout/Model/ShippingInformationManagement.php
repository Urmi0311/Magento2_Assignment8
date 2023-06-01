<?php

namespace Sigma\OrderComment\Plugin\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteRepository;
use Sigma\OrderComment\Plugin\Checkout\Model\CartTotalRepositoryInterface;

class ShippingInformationManagement
{
    /**
     * @param QuoteRepository $quoteRepository
     * @param CartTotalRepositoryInterface $cartTotalRepository
     */
    public function __construct(
        private QuoteRepository $quoteRepository,
        private CartRepositoryInterface $cartRepository
    )
    {
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        if(!$addressInformation->getExtensionAttributes()) {
            return;
        }

        $quote = $this->cartRepository->getActive($cartId);

        $shipping_information_comment = $addressInformation->getExtensionAttributes()->getComment();
        $quote->setComment($shipping_information_comment);
        $this->cartRepository->save($quote);

        return [$cartId, $addressInformation];
    }
}
