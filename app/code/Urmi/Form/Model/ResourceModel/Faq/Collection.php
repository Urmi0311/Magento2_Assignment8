<?php declare(strict_types=1);

namespace Urmi\Form\Model\ResourceModel\Faq;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Urmi\Form\Model\Faq;


class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Faq::class, \Urmi\Form\Model\ResourceModel\Faq::class);
    }
}
