<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sigma\CustomForm\Model;
use Brick\Math\BigInteger;
use FG\ASN1\Universal\Integer;
use Magento\Framework\Model\AbstractModel;
use Sigma\CustomForm\Api\Data\FormInterface;

class Form extends \Magento\Framework\Model\AbstractModel implements FormInterface {
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'custom_contactus_form';
    /**
     * @var string
     */
    protected $_cacheTag = 'custom_contactus_form';
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'custom_contactus_form';
    protected function _construct() {
        $this->_init('Sigma\CustomForm\Model\ResourceModel\Form');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }
    /**
     * Set Id.
     */
    public function setId($Id)
    {
        return $this->setData(self::ID, $Id);
    }
    /**
     * Get Name
     *
     * @return varchar
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }
    /**
     * Set Title.
     */
    public function setName($Name)
    {
        return $this->setData(self::NAME, $Name);
    }
    /**
     * Get getContent.
     *
     * @return varchar
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }
    /**
     * Set Content.
     */
    public function setEmail($Email)
    {
        return $this->setData(self::EMAIL, $Email);
    }
    /**
     * Get PublishDate.
     *
     * @return varchar
     */
    public function getMessage()
    {
        return $this->getMessage(self::MESSAGE);
    }
    /**
     * Set PublishDate.
     */
    public function setMessage($Message)
    {
        return $this->setData(self::MESSAGE, $Message);
    }
    /**
     * Get UpdatedAt.
     *
     * @return varchar
     */
    public function getUpdatedAt()
    {
        return $this->getUpdatedAt(self::UPDATED_AT);
    }
    /**
     * Set UpdatedAt.
     */
    public function setUpdatedAt($UpdatedAt)
    {
        return $this->setUpdatedAt(self::UPDATED_AT, $UpdatedAt);
    }
    /**
     * Get Contact_Number.
     *
     * @return BigInteger
     */
    public function getContact_Number()
    {
        return $this->getContact_Number(self::CONTACT_NUMBER);
    }
    /**
     * Set UpdatedAt.
     */
    public function setContact_Number($Contact_Number)
    {
        return $this->setContact_Number(self::CONTACT_NUMBER, $Contact_Number);
    }
    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }
    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($CreatedAt)
    {
        return $this->setData(self::CREATED_AT, $CreatedAt);
    }
}
