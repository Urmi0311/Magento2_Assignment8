<?php
/**
 * Webkul_Grid Grid Interface.
 *
 * @category    Webkul
 *
 * @author      Webkul Software Private Limited
 */
namespace Sigma\CustomForm\Api\Data;

use Brick\Math\BigInteger;
use FG\ASN1\Universal\Integer;

interface FormInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const CONTACT_NUMBER = 'contact_number';
    const MESSAGE = 'message';
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getId();

    /**
     * Set EntityId.
     */
    public function setId($Id);

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getName();

    /**
     * Set Title.
     */
    public function setName($Name);

    /**
     * Get Content.
     *
     * @return varchar
     */
    public function getEmail();

    /**
     * Set Content.
     */
    public function setEmail($Email);


    /**
     * Get Content.
     *
     * @return BigInteger
     */
    public function getContact_Number();

    /**
     * Set Content.
     */
    public function setContact_Number($Contact_Number);


    /**
     * Get Publish Date.
     *
     * @return varchar
     */
    public function getMessage();

    /**
     * Set PublishDate.
     */
    public function setMessage($Message);

    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdatedAt();

    /**
     * Set UpdateTime.
     */
    public function setUpdatedAt($UpdatedAt);

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt();

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($CreatedAt);
}
