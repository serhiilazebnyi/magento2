<?php

namespace Serj\VoucherApi\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\GroupFactory;
use Magento\Customer\Model\ResourceModel\Group as GroupResource;
use Magento\Framework\UrlInterface;

/**
 * CustomerDataProvider class
 */
class CustomerDataProvider implements ArgumentInterface
{
    /**
     * @var Session
     */
    private $customerSession;
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var GroupFactory
     */
    private $groupFactory;
    /**
     * @var GroupResource
     */
    private $groupResource;

    /**
     * @param Session       $customerSession
     * @param UrlInterface  $urlBuilder
     * @param GroupFactory  $groupFactory
     * @param GroupResource $groupResource
     */
    public function __construct(
        Session $customerSession,
        UrlInterface $urlBuilder,
        GroupFactory $groupFactory,
        GroupResource $groupResource
    ) {
        $this->customerSession = $customerSession;
        $this->urlBuilder = $urlBuilder;
        $this->groupFactory = $groupFactory;
        $this->groupResource = $groupResource;
    }

    /**
     * Redirects user to login screen if not logged in
     */
    public function redirectIfNotLoggedIn()
    {
        if (!$this->customerSession->isLoggedIn()) {
            $this->customerSession->setAfterAuthUrl($this->urlBuilder->getCurrentUrl());
            $this->customerSession->authenticate();
        }
    }

    /**
     * Verifies if customer logged in
     * @return boolean
     */
    public function isPrivilegedCustomer()
    {
        $group = $this->groupFactory->create();
        $this->groupResource->load($group, 'Privileged Customers', 'customer_group_code');

        $customer = $this->getCurrentCustomer();

        return $group->getId() == $customer->getGroupId();
    }

    /**
     * @return Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCurrentCustomer()
    {
        return $this->customerSession->getCustomer();
    }
}
