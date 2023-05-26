<?php

namespace Sigma\ShippingAddress\Plugin\Checkout\Model;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteRepository;

class ShippingInformationManagement
{
    /**
     * @param QuoteRepository $quoteRepository
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        private QuoteRepository         $quoteRepository,
        private CartRepositoryInterface $cartRepository
    )
    {
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param AddressInterface $addressInformation
     * @throws NoSuchEntityException
     * @throws \Zend_Log_Exception
     */



    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
                                                              $cartId,
        \Magento\Quote\Api\Data\AddressInterface              $addressInformation
    )
    {
        if (!$addressInformation->getExtensionAttributes()) {
            return;
        }

        $quote = $this->quoteRepository->getActive($cartId);
        $custom_middle_name_value = $addressInformation->getExtensionAttributes()->getMiddleName();
        $quote->getShippingAddress()->setMiddleName($custom_middle_name_value);
        $this->quoteRepository->save($quote);
    }
}
