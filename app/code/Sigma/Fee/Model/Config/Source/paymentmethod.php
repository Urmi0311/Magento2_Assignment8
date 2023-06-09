<?php
namespace Sigma\Fee\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Payment\Model\Config;

class paymentmethod implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $appConfigScopeConfigInterface;
    protected $paymentModelConfig;

    public function __construct(
        ScopeConfigInterface $appConfigScopeConfigInterface,
        Config $paymentModelConfig
    ) {
        $this->appConfigScopeConfigInterface = $appConfigScopeConfigInterface;
        $this->paymentModelConfig = $paymentModelConfig;
    }

    public function toOptionArray()
    {
        $payments = $this->paymentModelConfig->getActiveMethods();
        $methods = [];

        foreach ($payments as $paymentCode => $paymentModel) {
            $paymentTitle = $this->appConfigScopeConfigInterface
                ->getValue('payment/' . $paymentCode . '/title');

            $methods[] = [
                'label' => $paymentTitle,
                'value' => $paymentCode
            ];
        }

        return $methods;
    }
}
