<?php

namespace Serj\VoucherApi\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\GroupFactory;
use Serj\VoucherApi\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollectionFactory;
use Serj\VoucherApi\Model\ResourceModel\Voucher as VoucherResource;
use Serj\VoucherApi\Api\Data\VoucherInterface as Voucher;

/**
 * CustomerAfterSave observer
 */
class CustomerSaveAfter implements ObserverInterface
{
    private $groupFactory;
    private $voucherResource;
    private $voucherCollectionFactory;

    public function __construct(
        GroupFactory $groupFactory,
        VoucherResource $voucherResource,
        VoucherCollectionFactory $voucherCollectionFactory
    ) {
        $this->groupFactory = $groupFactory;
        $this->voucherResource = $voucherResource;
        $this->voucherCollectionFactory = $voucherCollectionFactory;
    }

    /**
     * @param  Observer $observer
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getData('customer_data_object');

        $groupId = $this->groupFactory
            ->create()
            ->load('Privileged Customers', 'customer_group_code')
            ->getId();

        if ($customer->getGroupId() != $groupId) {
            $voucherCollection = $this->voucherCollectionFactory
                ->create()
                ->addFieldToFilter(Voucher::CUSTOMER_ID, $customer->getId());

            foreach ($voucherCollection as $voucher) {
                $this->voucherResource->delete($voucher);
            }
        }
    }
}
