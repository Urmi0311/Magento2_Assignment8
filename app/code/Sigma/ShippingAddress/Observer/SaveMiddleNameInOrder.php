<?php

namespace Sigma\ShippingAddress\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveMiddleNameInOrder implements ObserverInterface
{

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();


        $order->setData('middle_name', $quote->getMiddleName());

        return $this;
    }
}
