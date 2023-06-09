<?php

namespace Sigma\GraphQL\Model\Resolver;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\Exception\LocalizedException;

class GetCustomerList implements ResolverInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        GroupRepositoryInterface $groupRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->groupRepository = $groupRepository;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $pageSize = $args['pageSize'] ?? 10;
        $currentPage = $args['currentPage'] ?? 1;

        // Validate input
        if ($pageSize < 1 || $currentPage < 1) {
            throw new GraphQlInputException(__('Invalid page size or current page number.'));
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->setCurrentPage($currentPage)
            ->setPageSize($pageSize)
            ->create();

        $customerList = $this->customerRepository->getList($searchCriteria);
        $totalCustomers = $customerList->getTotalCount();

        $customers = [];
        foreach ($customerList->getItems() as $customer) {
            $groupId = $customer->getGroupId();
            $group = $this->getGroupNameById($groupId);

            $customers[] = [
                'customer_id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'group' => $group,
            ];
        }

        $totalPages = (int) ceil($totalCustomers / $pageSize);

        return [
            'success' => true,
            'message' => '',
            'total_count' => $totalCustomers,
            'items' => $customers,
            'page_info' => [
                'current_page' => $currentPage,
                'page_size' => $pageSize,
                'total_pages' => $totalPages,
            ],
        ];
    }

    private function getGroupNameById($groupId)
    {
        try {
            $group = $this->groupRepository->getById($groupId);
            return $group->getCode();
        } catch (LocalizedException $e) {
            return '';
        }
    }
}
