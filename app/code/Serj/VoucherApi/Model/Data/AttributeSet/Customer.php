<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Serj\VoucherApi\Model\Data\AttributeSet;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Customer\Model\GroupFactory;

/**
 * Customer group attribute source
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Customer extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerCollectionFactory;
    /**
     * @var GroupFactory
     */
    private $groupFactory;
    /**
     * @var \Magento\Framework\Convert\DataObject
     */
    protected $_converter;

    /**
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory
     * @param GroupManagementInterface $groupManagement
     * @param GroupFactory $groupFactory
     * @param \Magento\Framework\Convert\DataObject $converter
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        CollectionFactory $customerCollectionFactory,
        GroupFactory $groupFactory,
        \Magento\Framework\Convert\DataObject $converter
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->groupFactory = $groupFactory;
        $this->_converter = $converter;
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
    }

    /**
     * @inheritdoc
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        if (!$this->_options) {
            $customers = $this->customerCollectionFactory->create();

            $groupId = $this->groupFactory
                ->create()
                ->load('Privileged Customers', 'customer_group_code')
                ->getId();

            $this->_options = [['label' => '', 'value' => '']];

            foreach ($customers as $customer) {
                if ($customer->getGroupId() == $groupId) {
                    $this->_options[] = [
                        'label' => $customer->getName(),
                        'value' => $customer->getId()
                    ];
                }
            }
        }

        return $this->_options;
    }
}
