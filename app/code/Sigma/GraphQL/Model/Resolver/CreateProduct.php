<?php

namespace Sigma\GraphQL\Model\Resolver;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;

class CreateProduct implements ResolverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductFactory
     */
    private $productFactory;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductFactory $productFactory
    ) {
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $productData = $args['product'];

        try {
            // Create a new product with the provided data
            $product = $this->productFactory->create();
            $product->setAttributeSetId(4);
            $product->setSku($productData['sku']);
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);
            // Add any additional required attributes for the product

            // Save the product
            $product = $this->productRepository->save($product);


            // Get the saved product by SKU to ensure all data is loaded correctly
            $product = $this->productRepository->get($product->getSku());

            // Return the created product
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice()
            ];
        } catch (InputException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        } catch (CouldNotSaveException $e) {
            throw new GraphQlAuthorizationException(__($e->getMessage()));
        }
    }
}
