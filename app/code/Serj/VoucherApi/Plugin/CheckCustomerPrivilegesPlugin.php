<?php

namespace  Serj\VoucherApi\Plugin;

use Serj\VoucherApi\Api\VoucherRepositoryInterface as Subject;
use Serj\VoucherApi\Api\Data\VoucherInterface as Voucher;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\GroupFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * CheckCustomerPrivileges plugin
 */
class CheckCustomerPrivilegesPlugin
{
    private $customerFactory;
    private $groupFactory;

    public function __construct(
        CustomerFactory $customerFactory,
        GroupFactory $groupFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->groupFactory = $groupFactory;
    }

    /**
     * @param  Subject $subject
     * @param Voucher $voucher
     */
    public function beforeSave(Subject $subject, Voucher $voucher)
    {
        $groupId = $this->groupFactory
            ->create()
            ->load('Privileged Customers', 'customer_group_code')
            ->getId();
        $customer = $this->customerFactory
            ->create()
            ->load($voucher->getCustomerId());

        if ($groupId != $customer->getGroupId()) {
            throw  new LocalizedException(__('Customer isn\'t in a privileged group'));
        }
    }
}
