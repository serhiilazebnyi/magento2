<?php

namespace Serj\VoucherApi\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Serj\VoucherApi\Api\Data\VoucherInterface;
use Serj\VoucherApi\Model\ResourceModel\Voucher as ResourceModel;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Serj\VoucherApi\Model\ResourceModel\VoucherStatus\CollectionFactory as VoucherStatusCollectionFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Voucher
 */
class Voucher extends AbstractExtensibleModel implements VoucherInterface
{
    /**
     * @var string
     */
    protected $_idFieldName = VoucherInterface::ID;
    private $customerCollectionFactory;
    private $voucherStatusCollectionFactory;
    protected $extensionAttributesFactory;
    protected $customAttributeFactory;

    public function __construct(
        CustomerCollectionFactory $customerCollectionFactory,
        VoucherStatusCollectionFactory $voucherStatusCollectionFactory,
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->voucherStatusCollectionFactory = $voucherStatusCollectionFactory;
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
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

        if ($customerId === null) {
            throw new LocalizedException(__('Customer not exists!',
                ['Customer name' => $customerName]));
        }

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

        if ($statusId === null) {
            throw new LocalizedException(__('Voucher status not exists!',
                ['Voucher status' => $statusCode]));
        }

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
