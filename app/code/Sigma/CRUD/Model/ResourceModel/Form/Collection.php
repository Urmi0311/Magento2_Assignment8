<?php

namespace Sigma\CRUD\Model\ResourceModel\Form;



class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Sigma\CRUD\Model\Form', 'Sigma\CRUD\Model\ResourceModel\Form');
    }
}
