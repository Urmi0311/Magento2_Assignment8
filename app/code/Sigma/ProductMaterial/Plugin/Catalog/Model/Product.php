<?php
namespace Sigma\ProductMaterial\Plugin\Catalog\Model;

class Product extends \Magento\Catalog\Model\Product
{

    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
    {
        $title = $result;
        //$title = '';
        $attributeText = $subject->getAttributeText('material');
        if ($attributeText) {
            $result = $title . " - " . $attributeText;
        }

        return $result;
    }
}

