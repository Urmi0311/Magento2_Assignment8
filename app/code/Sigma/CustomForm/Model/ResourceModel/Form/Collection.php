<?php

namespace Sigma\CustomForm\Model\ResourceModel\Form;



class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Sigma\CustomForm\Model\Form', 'Sigma\CustomForm\Model\ResourceModel\Form');
    }
}
