<?php

namespace Serj\VoucherApi\Model;

use Magento\Framework\Model\AbstractModel;
use Serj\VoucherApi\Api\Data\VoucherInterface;
use Serj\VoucherApi\Model\ResourceModel\Voucher as ResourceModel;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Serj\VoucherApi\Model\ResourceModel\VoucherStatus\CollectionFactory as VoucherStatusCollectionFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Class Voucher
 */
class Voucher extends AbstractModel implements VoucherInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = VoucherInterface::ID;
    private $customerCollectionFactory;
    private $voucherStatusCollectionFactory;

    public function __construct(
        CustomerCollectionFactory $customerCollectionFactory,
        VoucherStatusCollectionFactory $voucherStatusCollectionFactory,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->voucherStatusCollectionFactory = $voucherStatusCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

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
    * @return string
    */
    public function getCustomerId()
    {
        return $this->getData(VoucherInterface::CUSTOMER_ID);
    }

    /**
     * setCustomerId
    * @param string $customerName
    * @return $this
    */
    public function setCustomerId(string $customerName)
    {
        $customerCollection = $this->customerCollectionFactory->create();
        $customerId = $customerCollection->addNameToSelect()
            ->addFieldToFilter('name', $customerName)
            ->getFirstItem()
            ->getId();

        $this->setData(VoucherInterface::CUSTOMER_ID, $customerId);
        return $this;
    }

    /**
     * getStatusId
    * @return string
    */
    public function getStatusId()
    {
        return $this->getData(VoucherInterface::STATUS_ID);
    }

    /**
     * setStatusId
    * @param string $statusCode
    * @return $this
    */
    public function setStatusId(string $statusCode)
    {
        $voucherStatusCollection = $this->voucherStatusCollectionFactory->create();
        $statusId = $voucherStatusCollection->filterByStatusCode($statusCode)
            ->getFirstItem()
            ->getId();

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
}
