<?php

namespace Serj\VoucherApi\Model;

use Magento\Framework\Model\AbstractModel;
use Serj\VoucherApi\Api\Data\VoucherStatusInterface;
use Serj\VoucherApi\Model\ResourceModel\VoucherStatus as ResourceModel;

/**
 * Class VoucherStatus
 */
class VoucherStatus extends AbstractModel implements VoucherStatusInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = VoucherStatusInterface::ID;

    protected function _construct()
    {
    	$this->_init(ResourceModel::class);
    }

    /**
     * getId
     * @return int
     */
    public function getId()
    {
       return $this->getData(VoucherStatusInterface::ID);
    }

   /**
    * setId
    * @param int $id
    * @return $this
    */
   public function setId($id)
   {
       $this->setData(VoucherStatusInterface::ID, $id);
       return $this;
   }

    /**
     * getStatusCode
     * @return string
     */
    public function getStatusCode()
    {
        return $this->getData(VoucherStatusInterface::STATUS_CODE);
    }

    /**
     * setStatusCode
     * @param string $statusCode
     * @return $this
     */
    public function setStatusCode(string $statusCode)
    {
        $this->setData(VoucherStatusInterface::STATUS_CODE, $statusCode);
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(VoucherStatusInterface::CREATED_AT);
    }

    /**
     * setCreatedAt
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->setData(VoucherStatusInterface::CREATED_AT, $createdAt);
        return $this;
    }

    /**
     * getUpdatedAt
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(VoucherStatusInterface::UPDATED_AT);
    }

    /**
     * setUpdatedAt
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt)
    {
        $this->setData(VoucherStatusInterface::UPDATED_AT, $updatedAt);
        return $this;
    }
}
