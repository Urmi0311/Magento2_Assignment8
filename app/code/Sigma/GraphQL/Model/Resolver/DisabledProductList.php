<?php
namespace Sigma\GraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class DisabledProductList implements ResolverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    private $categoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->categoryRepository = $categoryRepository;
    }

    public function resolve($field, $context, $info, array $value = null, array $args = null)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED, 'eq')
            ->create();

        $searchResults = $this->productRepository->getList($searchCriteria);
        $disabledProducts = [];

        foreach ($searchResults->getItems() as $product) {
            $disabledProducts[] = [
                'entityId' => $product->getId(),
                'proName' => $product->getName(),
                'sku' => $product->getSku(),
                'category' => $this->getProductCategories($product),
                'weight' => $product->getWeight()
            ];
        }

        return $disabledProducts;
    }

    private function getProductCategories($product)
    {
        $categoryIds = $product->getCategoryIds();
        $categories = [];

        foreach ($categoryIds as $categoryId) {
            $category = $this->categoryRepository->get($categoryId);
            $categoryName = $category->getName();

            $categories[] = $categoryName;
        }

        return implode(", ", $categories);
    }
}
