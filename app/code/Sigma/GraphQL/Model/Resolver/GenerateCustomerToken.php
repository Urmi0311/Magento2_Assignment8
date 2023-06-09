<?php

namespace Sigma\GraphQL\Model\Resolver;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GenerateCustomerToken implements ResolverInterface
{
    /**
     * @var AccountManagementInterface
     */
    private $accountManagement;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var GroupRepositoryInterface
     */
    private $customerGroupRepository;

    public function __construct(
        AccountManagementInterface $accountManagement,
        CustomerRepositoryInterface $customerRepository,
        GroupRepositoryInterface $customerGroupRepository
    ) {
        $this->accountManagement = $accountManagement;
        $this->customerRepository = $customerRepository;
        $this->customerGroupRepository = $customerGroupRepository;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $email = $args['email'] ?? null;
        $password = $args['password'] ?? null;

        if (!$email || !$password) {
            throw new GraphQlInputException(__('Email and password are required fields.'));
        }

        try {
            $customer = $this->accountManagement->authenticate($email, $password);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__('Invalid login credentials.'));
        }

        $customerId = $customer->getId();
        $customerGroup = $this->getCustomerGroup($customerId);
        $newsletterSubscribe = $this->isCustomerSubscribed($customer) ? 'true' : 'false';
        $token = $this->generateToken($context->getUserId());

        return [
            'token' => $token,
            'customer_id' => $customerId,
            'group' => $customerGroup,
            'newsletter_subscribe' => $newsletterSubscribe,
        ];
    }

    private function getCustomerGroup($customerId)
    {
        try {
            $customer = $this->customerRepository->getById($customerId);
            $groupId = $customer->getGroupId();
            $group = $this->customerGroupRepository->getById($groupId)->getCode();
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__('Could not retrieve customer group.'));
        }

        return $group;
    }

    private function isCustomerSubscribed($customer)
    {
        $extensionAttributes = $customer->getExtensionAttributes();
        if ($extensionAttributes === null || !$extensionAttributes->getIsSubscribed()) {
            return false;
        }

        return true;
    }

    private function generateToken($sessionId)
    {
        // Generate a unique token based on the session ID
        // You can use any token generation logic that suits your needs
        $token = md5($sessionId . uniqid());

        return $token;
    }
}
