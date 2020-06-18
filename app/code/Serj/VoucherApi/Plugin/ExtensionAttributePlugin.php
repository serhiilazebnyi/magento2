<?php

namespace  Serj\VoucherApi\Plugin;

use Serj\VoucherApi\Model\Voucher as Subject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\CustomerFactory;

/**
 * ExtensionAttribute plugin
 */
class ExtensionAttributePlugin
{
    private $customerFactory;

    public function __construct(
        CustomerFactory $customerFactory
    ) {
        $this->customerFactory = $customerFactory;
    }

    /**
     * @param  Subject $subject
     */
    public function beforeBeforeSave(Subject $subject)
    {
        $subject->setCustomerId(
            $subject->getExtensionAttributes()->getCustomer()->getName()
        );
    }

    /**
     * @param  Subject $subject
     */
    public function afterAfterLoad(Subject $subject)
    {
        $customer = $this->customerFactory
            ->create()
            ->load($subject->getCustomerId());

        $extensionAttributes = $subject->getExtensionAttributes();
        $extensionAttributes->setCustomer($customer);
        $subject->setExtensionAttributes($extensionAttributes);
    }
}
