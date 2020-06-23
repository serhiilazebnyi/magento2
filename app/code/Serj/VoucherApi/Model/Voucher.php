<?php

namespace Serj\VoucherApi\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Serj\VoucherApi\Api\Data\VoucherInterface;
use Serj\VoucherApi\Model\ResourceModel\Voucher as VoucherResource;

/**
 * Class Voucher
 */
class Voucher extends AbstractExtensibleModel implements VoucherInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = VoucherInterface::ID;

	protected function _construct()
	{
		$this->_init(VoucherResource::class);
	}

    /**
     * getId
    * @return int
    */
   public function getId()
   {
       return $this->getData(VoucherInterface::ID);
   }

   /**
    * setId
    * @param int $id
    * @return $this
    */
   public function setId($id)
   {
       $this->setData(VoucherInterface::ID, $id);
       return $this;
   }

    /**
     * getCustomerId
    * @return int
    */
    public function getCustomerId()
    {
        return $this->getData(VoucherInterface::CUSTOMER_ID);
    }

    /**
     * setCustomerId
    * @param int $customerId
    * @return $this
    */
    public function setCustomerId(int $customerId)
    {
        $this->setData(VoucherInterface::CUSTOMER_ID, $customerId);
        return $this;
    }

    /**
     * getStatusId
    * @return int
    */
    public function getStatusId()
    {
        return $this->getData(VoucherInterface::STATUS_ID);
    }

    /**
     * setStatusId
    * @param int $statusCode
    * @return $this
    */
    public function setStatusId(int $statusId)
    {
        $this->setData(VoucherInterface::STATUS_ID, $statusId);
        return $this;
    }

    /**
     * getVoucherCode
    * @return string
    */
   public function getVoucherCode()
   {
       return $this->getData(VoucherInterface::VOUCHER_CODE);
   }

   /**
    * setVoucherCode
    * @param string $voucherCode
    * @return $this
    */
   public function setVoucherCode(string $voucherCode)
   {
        $this->setData(VoucherInterface::VOUCHER_CODE, $voucherCode);
        return $this;
   }

    /**
     * getCreatedAt
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(VoucherInterface::CREATED_AT);
    }

    /**
     * setCreatedAt
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->setData(VoucherInterface::CREATED_AT, $createdAt);
        return $this;
    }

    /**
     * getUpdatedAt
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(VoucherInterface::UPDATED_AT);
    }

    /**
     * setUpdatedAt
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt)
    {
        $this->setData(VoucherInterface::UPDATED_AT, $updatedAt);
        return $this;
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Serj\VoucherApi\Api\Data\VoucherExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param \Serj\VoucherApi\Api\Data\VoucherExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Serj\VoucherApi\Api\Data\VoucherExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
