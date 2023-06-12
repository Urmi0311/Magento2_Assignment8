<?php

namespace Sigma\GraphQL\Model\Resolver;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;


class OrderDetails implements ResolverInterface
{

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    )
    {
        $startDate = $args['startDate'];
        $endDate = $args['endDate'];

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(OrderInterface::CREATED_AT, $startDate, 'gteq')
            ->addFilter(OrderInterface::CREATED_AT, $endDate, 'lteq')
            ->create();

        $orders = $this->orderRepository->getList($searchCriteria)->getItems();


        $orderDetails = [];

        foreach ($orders as $order) {
            $orderDetails[] = [
                'order_id' => $order->getQuoteId(),
                'increment_id' => $order->getIncrementId(),
                'items' => $this->getOrderdDetails($order)
            ];
        }

        return $orderDetails;
    }

    /**
     * @param OrderInterface $order
     * @return array
     */
    public function getOrderdDetails(OrderInterface $order) {
        $items = [];

        foreach ($order->getItems() as $item) {
            $items[] = [
                'item_id' => $item->getProductId(),
                'item_name' => $item->getName(),
                'qty' => $item->getQtyOrdered(),
            ];
        }
        return $items;
    }
}
