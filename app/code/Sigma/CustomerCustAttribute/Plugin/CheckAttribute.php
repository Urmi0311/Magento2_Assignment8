<?php

namespace Sigma\CustomerCustAttribute\Plugin;

use Magento\Customer\Controller\Account\CreatePost;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Zend_Log_Writer_Stream;

class CheckAttribute
{
    public function __construct(
        protected ResultFactory $resultFactory,
        protected ManagerInterface $messageManager,
        protected RequestInterface $request
    )
    {
    }

    /**
     * @param CreatePost $subject
     * @return void
     * @throws LocalizedException
     * @throws \Zend_Log_Exception
     */
    public function beforeExecute(CreatePost $subject){

        $objectManager = ObjectManager::getInstance();
        $customerObj = $objectManager->create('Magento\Customer\Model\ResourceModel\Customer\Collection');
        $collection = $customerObj->addAttributeToSelect('*')
            ->addAttributeToFilter('deptor_account_number', $this->request->getParam('deptor_account_number'))->load();
        $customerData = $collection->getData();

        if(!empty($customerData)) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $this->messageManager->addErrorMessage('The value of "Deptor Account Number" already exist.');
            $resultRedirect->setPath('customer/account/');
            $this->request->setParam('form_key', '');
            return $resultRedirect;
        } else {
            return true;
        }
    }

}
