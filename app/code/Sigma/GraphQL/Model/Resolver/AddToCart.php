<?php
namespace Sigma\GraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class AddToCart implements ResolverInterface
{
/**
* @var CartRepositoryInterface
*/
private $cartRepository;

/**
* @var ProductRepositoryInterface
*/
private $productRepository;

public function __construct(
CartRepositoryInterface $cartRepository,
ProductRepositoryInterface $productRepository
) {
$this->cartRepository = $cartRepository;
$this->productRepository = $productRepository;
}

public function resolve(Field $field, ContextInterface $context, ResolveInfo $info, array $value = null, array $args = null)
{
$input = $args['input'];
$sku = $input['sku'];
$quantity = $input['quantity'];

$cartId = $context->getCartId();

// Retrieve the product by SKU
try {
$product = $this->productRepository->get($sku);
} catch (\Exception $e) {
// Handle product not found error
return [
'success' => false,
'message' => 'Product not found',
'cart_id' => $cartId,
];
}

// Add the product to the cart
try {
$cart = $this->cartRepository->get($cartId);
$cart->addProduct($product, $quantity);
$this->cartRepository->save($cart);
} catch (\Exception $e) {
// Handle error while adding product to the cart
return [
'success' => false,
'message' => 'Failed to add product to the cart',
'cart_id' => $cartId,
];
}

return [
'success' => true,
'message' => 'Product added to the cart successfully',
'cart_id' => $cartId,
];
}
}
