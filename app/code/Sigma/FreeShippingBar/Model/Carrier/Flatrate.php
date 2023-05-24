<?php

namespace Sigma\FreeShippingBar\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\OfflineShipping\Model\Carrier\Flatrate\ItemPriceCalculator;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory as MethodFactoryAlias;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class Flatrate extends \Magento\OfflineShipping\Model\Carrier\Flatrate
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Threshold configuration path
     */
    const XML_PATH_THRESHOLD_LIMIT = 'sigma_freeshippingbar/general/free_shipping_cutoff';

    /**
     * @var ErrorFactory
     */
    private $rateErrorFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var MethodFactoryAlias
     */
    private $rateMethodFactory;

    /**
     * @var ItemPriceCalculator
     */
    private $itemPriceCalculator;

    /**
     * @var array
     */
    private $data;

    /**
     * Flatrate constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactoryAlias $rateMethodFactory
     * @param ItemPriceCalculator $itemPriceCalculator
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactoryAlias $rateMethodFactory,
        ItemPriceCalculator $itemPriceCalculator,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->rateErrorFactory = $rateErrorFactory;
        $this->logger = $logger;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->itemPriceCalculator = $itemPriceCalculator;
        $this->data = $data;

        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $rateResultFactory,
            $rateMethodFactory,
            $itemPriceCalculator,
            $data
        );
    }

    /**
     * Collect and calculate shipping rates.
     *
     * @param RateRequest $request
     * @return bool|Result
     */
    public function collectRates(RateRequest $request)
    {
        // Call the parent collectRates method to calculate the original shipping rates
        $result = parent::collectRates($request);

        // Check if the order price exceeds the threshold
        $storeScope = ScopeInterface::SCOPE_STORE;
        $threshold = $this->scopeConfig->getValue(self::XML_PATH_THRESHOLD_LIMIT, $storeScope);
        $orderPrice = $request->getBaseSubtotalInclTax();

        if ($orderPrice >= $threshold) {
            // Set the shipping price to zero
            foreach ($result->getAllRates() as $rate) {
                $rate->setPrice(0);
            }
        }

        return $result;
    }
}
