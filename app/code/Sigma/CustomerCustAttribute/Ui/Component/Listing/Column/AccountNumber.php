<?php

namespace Sigma\CustomerCustAttribute\Ui\Component\Listing\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class AccountNumber extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $objectManager = ObjectManager::getInstance();
                $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($item['entity_id']);
                $item[$this->getData('name')] = $customer->getDeptorAccountNumber();
            }
        }
        return $dataSource;
    }
}
