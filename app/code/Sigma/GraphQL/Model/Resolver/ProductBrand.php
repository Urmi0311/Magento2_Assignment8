<?php

namespace Sigma\GraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductBrand implements ResolverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $searchTerm = $args['search'];
        $pageSize = $args['pageSize'];

        // Perform the product search query
        $productSearchResult = $this->productRepository->getList();

        // Prepare the result data
        $totalCount = $productSearchResult->getTotalCount();
        $items = [];
        foreach ($productSearchResult->getItems() as $product) {
            $item = [
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'brand' => $product->getAttributeText('brand'),
                'price_range' => [
                    'minimum_price' => [
                        'regular_price' => [
                            'value' => $product->getPrice(),
                            'currency' => $product->getCurrencyCode()
                        ]
                    ]
                ]
            ];
            $items[] = $item;
        }

        // Prepare the page info
        $pageSize = $productSearchResult->getPageSize();
        $currentPage = $productSearchResult->getCurPage();

        $result = [
            'total_count' => $totalCount,
            'items' => $items,
            'page_info' => [
                'page_size' => $pageSize,
                'current_page' => $currentPage
            ]
        ];

        return $result;
    }
}
