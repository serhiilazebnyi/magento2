<?php
namespace Serj\VoucherApi\Api\Data;

/**
 * Interface VoucherStatusInterface
 * @api
 */
interface VoucherStatusInterface
{
    /**
     * Constants
     * @var string
     */
    const ID = 'entity_id';
    const STATUS_CODE = 'status_code';
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
    public function getStatusCode();

    /**
     * @param string $statusCode
     * @return $this
     */
    public function setStatusCode(string $statusCode);

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
