<?php

namespace Sigma\GraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Item;

class CustomCart implements ResolverInterface
{
/**
* @var Quote
*/
private $quote;

public function __construct(
Quote $quote
) {
$this->quote = $quote;
}

public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
{
$cartId = $args['cart_id'];
$cart = $this->quote->load($cartId);

$cartItems = $cart->getAllVisibleItems();

$result = [];

/** @var Item $item */
foreach ($cartItems as $item) {
$result[] = [
'item_id' => $item->getId(),
'product_id' => $item->getProductId(),
'sku' => $item->getSku(),
'name' => $item->getName(),
'price' => $item->getPrice(),
'quantity' => $item->getQty(),
'additional_data' => $this->getAdditionalData($item),
];
}

return [
'items' => $result,
];
}

private function getAdditionalData(Item $item)
{
// Implement your logic to retrieve additional data for the item
// You can use $item->getData('additional_data') to retrieve the value

return [
'field1' => 'Value 1',
'field2' => 2,
'field3' => true,
];
}
}
