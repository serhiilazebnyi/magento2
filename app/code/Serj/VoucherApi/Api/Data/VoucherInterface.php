<?php
namespace Serj\VoucherApi\Api\Data;

/**
* Interface VoucherInterface
* @package VoucherApi\Api\Data
* @api
 */
interface VoucherInterface
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
    * @return string
    */
    public function getCustomerId();

    /**
    * @param string $customerName
    * @return $this
    */
    public function setCustomerId(string $customerName);

    /**
    * @return string
    */
   public function getStatusId();

   /**
    * @param string $statusCode
    * @return $this
    */
   public function setStatusId(string $statusCode);

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
}
