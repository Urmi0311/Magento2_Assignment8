<?php

namespace Sigma\ShippingAddress\Plugin\Ui\Component\Listing\Column;



use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Ui\Component\Listing\Column\Address;

class Adress
{
    public function __construct(
        private OrderFactory $orderFactory
    )
    {
    }

    public function afterPrepareDataSource(
        Address $subject,
        array $dataSource
    ){
        foreach ($dataSource['data']['items'] as &$item) {
            $orderId = $item['entity_id'];

            //getting data from order_sales
            $orderData = $this->orderFactory->create()->load($orderId);

            $customerFullName = $orderData['customer_firstname'] . ' ' . $orderData['middle_name'] . ' ' . $orderData['customer_lastname'];

            //setting shipping_name to firstname-customMiddleName-lastname
            $item['shipping_name'] = $customerFullName;
        }

        return $dataSource;
    }
}
