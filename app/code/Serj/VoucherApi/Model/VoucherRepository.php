<?php

namespace Serj\VoucherApi\Model;

use Magento\Customer\Model\CustomerFactory;
use Serj\VoucherApi\Api\Data\VoucherInterface;
use Serj\VoucherApi\Api\VoucherRepositoryInterface;
use Serj\VoucherApi\Model\VoucherFactory;
use Serj\VoucherApi\Model\ResourceModel\Voucher as VoucherResource;
use Serj\VoucherApi\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\Session;

/**
 * class VoucherRepository
 * @api
 */
class VoucherRepository implements VoucherRepositoryInterface
{
    /**
     * @var VoucherResource
     */
    private $voucherResource;
    /**
     * @var CustomerFactory
     */
    private $customerFactory;
    /**
     * @var VoucherFactory
     */
    private $voucherFactory;
    /**
     * @var VoucherCollectionFactory
     */
    private $voucherCollectionFactory;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @param VoucherResource          $voucherResource
     * @param CustomerFactory          $customerFactory
     * @param VoucherFactory           $voucherFactory
     * @param VoucherCollectionFactory $voucherCollectionFactory
     */
    public function __construct(
        VoucherResource $voucherResource,
        CustomerFactory $customerFactory,
        VoucherFactory $voucherFactory,
        VoucherCollectionFactory $voucherCollectionFactory,
        Session $customerSession
    ) {
        $this->voucherResource = $voucherResource;
        $this->voucherFactory = $voucherFactory;
        $this->customerFactory = $customerFactory;
        $this->voucherCollectionFactory = $voucherCollectionFactory;
        $this->customerSession = $customerSession;
    }

    /**
    * @param \Serj\VoucherApi\Api\Data\VoucherInterface $voucher
    * @return array
    */
    public function save(VoucherInterface $voucher)
    {
        try {
            $customer = $this->customerFactory
                ->create()
                ->load($voucher->getCustomerId());
            $extensionAttributes = $voucher->getExtensionAttributes();
            $extensionAttributes->setCustomer($customer);
            $voucher->setExtensionAttributes($extensionAttributes);
            $this->voucherResource->save($voucher);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return ['{"status":"success"}'];
    }

    /**
     * DELETE delete
     * @param int $voucherId
     * @return array
     */
	public function delete(int $voucherId)
    {
        $voucher = $this->voucherFactory->create();
        $this->voucherResource->load($voucher, $voucherId);

        if (empty($voucher->getId())) {
            throw new LocalizedException(__('Voucher not found!',
                ['voucher_id' => $voucherId]));
        }

        try {
            $this->voucherResource->delete($voucher);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return ['{"status":"success"}'];
    }

    public function getList()
    {
        $voucherCollection = $this->voucherCollectionFactory->create();

        $data = $voucherCollection->addFieldToSelect([
            VoucherInterface::ID,
            VoucherInterface::CUSTOMER_ID,
            VoucherInterface::STATUS_ID,
            VoucherInterface::VOUCHER_CODE
        ])->getData();

        if (empty($data)) {
            throw new LocalizedException(__('There is no vouchers yet!'));
        }

        return $data;
    }

    /**
     * getByCustomerId
     * @param int $customerId
     * @return array
     */
    public function getByCustomerId(int $customerId)
    {
        $customer = $this->customerFactory->create()->load($customerId);

        if (!$customer || !$customer->getId()) {
            throw new LocalizedException(
                __('Customer not found!', ['customer_id' => $customerId])
            );
        }

        $voucherCollection = $this->voucherCollectionFactory->create();
        $data = $voucherCollection->addFieldToSelect([
            VoucherInterface::ID,
            VoucherInterface::CUSTOMER_ID,
            VoucherInterface::STATUS_ID,
            VoucherInterface::VOUCHER_CODE
        ])->filterByCustomerId($customerId);

        if (empty($data)) {
            throw new LocalizedException(
                __('Customer has no vouchers!', ['customer_id' => $customerId])
            );
        }

        return $data;
    }

    /**
     * GET getCustomerVouchers
     * @return array
     */
    public function getCustomerVouchers()
    {
        $customerId = $this->customerSession->getId();

        if (!$customerId) {
            throw new LocalizedException(
                __('You are not logged in!')
            );
        }

        $vouchers = $this->voucherCollectionFactory
            ->create()
            ->filterByCustomerId($customerId)
            ->getData();

        return $vouchers;
    }

    /**
     * Gets voucher by id
     * @param  int $voucherId
     * @return VoucherInterface
     */
    public function getById(int $voucherId = null)
    {
        $voucher = $this->voucherFactory->create();
        $this->voucherResource->load($voucher, $voucherId);

        return $voucher;
    }

    /**
     * Builds voucher based on data
     * @param  array $data
     * @return VoucherInterface $voucher
     */
    public function buildVoucher($data = [])
    {
        $voucher = $this->voucherFactory->create();
        $voucher->setData($data);

        return $voucher;
    }
}
