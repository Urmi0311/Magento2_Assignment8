<?php
namespace Sigma\GraphQL\Model\Resolver;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetSpecialPriceProducts implements ResolverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function resolve($field, $context, $info, array $value = null, array $args = null)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('special_price', null, 'notnull')
            ->create();

        $searchResults = $this->productRepository->getList($searchCriteria);
        $specialPriceProducts = [];

        foreach ($searchResults->getItems() as $product) {
            $specialPriceProducts[] = $product->getSku();
        }

        return ['products_skus' => $specialPriceProducts];
    }
}
