<?php

namespace Sigma\GraphQL\Model\Resolver;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CustomStoreConfig implements ResolverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * StoreConfig constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $storeConfigData = $this->getAllStoreConfigValues();

        return $storeConfigData;
    }

    /**
     * Fetch all system configuration values
     *
     * @return array
     */
    private function getAllStoreConfigValues(): array
    {
        $storeConfigData = [];

        $configPaths = [
            'custom_group/custom_field/website_default_title',
            'custom_group/custom_field/website_default_index',
        ];

        foreach ($configPaths as $path) {
            $value = $this->scopeConfig->getValue($path);
            $storeConfigData[$this->getConfigKeyFromPath($path)] = $value;
        }

        return $storeConfigData;
    }

    /**
     * Get the configuration key from the configuration path
     *
     * @param string $path
     * @return string
     */
    private function getConfigKeyFromPath(string $path): string
    {
        $pathParts = explode('/', $path);
        return end($pathParts);
    }
}
