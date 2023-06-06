<?php

namespace Sigma\CustomerCustAttribute\Block\Widget;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Block\Widget\AbstractWidget;
use Magento\Customer\Helper\Address;
use Magento\Customer\Model\Options;
use Magento\Framework\View\Element\Template\Context;

class AccountNumber extends AbstractWidget
{
    const ATTRIBUTE_CODE = 'deptor_account_number';

    public function __construct(
        Context $context,
        Address $addressHelper,
        CustomerMetadataInterface $customerMetadata,
        protected Options $options,
        protected AddressMetadataInterface $addressMetadata,
        array $data = []
    )
    {
        parent::__construct($context, $addressHelper, $customerMetadata, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('Sigma_CustomerCustAttribute::widget/deptorAccountNumber.phtml');
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->_getAttribute(self::ATTRIBUTE_CODE) ? (bool)$this->_getAttribute(self::ATTRIBUTE_CODE)->isVisible() : false;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->_getAttribute(self::ATTRIBUTE_CODE) ? (bool)$this->_getAttribute(self::ATTRIBUTE_CODE)->isRequired() : false;
    }

    /**
     * @return mixed|null
     */
    public function getDeptorAccountNumber()
    {
        return $this->_getData(self::ATTRIBUTE_CODE);
    }


    /**
     * @param $number
     * @return $this
     */
    public function setDeptorAccountNumber($number) {
        $this->deptorAccountNumber = $number;
        return $this;
    }
}
