<?php

namespace Serj\VoucherApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
* Interface VoucherInterface
* @api
 */
interface VoucherInterface extends ExtensibleDataInterface
{
    /**
     * Constants
     * @var string
     */
    const ID = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const STATUS_ID = 'status_id';
    const VOUCHER_CODE = 'voucher_code';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
    * @return int
    */
   public function getId();

   /**
    * @param int $id
    * @return $this
    */
   public function setId($id);

    /**
    * @return int
    */
    public function getCustomerId();

    /**
    * @param int $customerId
    * @return $this
    */
    public function setCustomerId(int $customerId);

    /**
    * @return int
    */
   public function getStatusId();

   /**
    * @param int $statusId
    * @return $this
    */
   public function setStatusId(int $statusId);

   /**
   * @return string
   */
  public function getVoucherCode();

  /**
   * @param string $voucherCode
   * @return $this
   */
  public function setVoucherCode(string $voucherCode);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Serj\VoucherApi\Api\Data\VoucherExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Serj\VoucherApi\Api\Data\VoucherExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Serj\VoucherApi\Api\Data\VoucherExtensionInterface $extensionAttributes
    );
}
