<?php

namespace Serj\VoucherApi\Model;

use Magento\Customer\Model\CustomerFactory;
use Serj\VoucherApi\Api\Data\VoucherInterface;
use Serj\VoucherApi\Api\VoucherRepositoryInterface;
use Serj\VoucherApi\Model\VoucherFactory;
use Serj\VoucherApi\Model\ResourceModel\Voucher as VoucherResource;
use Serj\VoucherApi\Model\ResourceModel\Voucher\CollectionFactory as VoucherCollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class VoucherRepository implements VoucherRepositoryInterface
{
    private $voucherResource;
    private $customerFactory;
    private $voucherFactory;
    private $voucherCollectionFactory;

    public function __construct(
        VoucherResource $voucherResource,
        CustomerFactory $customerFactory,
        VoucherFactory $voucherFactory,
        VoucherCollectionFactory $voucherCollectionFactory
    ) {
        $this->voucherResource = $voucherResource;
        $this->voucherFactory = $voucherFactory;
        $this->customerFactory = $customerFactory;
        $this->voucherCollectionFactory = $voucherCollectionFactory;
    }

    /**
    * @param \Serj\VoucherApi\Api\Data\VoucherInterface $voucher
    * @return array
    */
    public function save(VoucherInterface $voucher)
    {
        try {
            $this->voucherResource->save($voucher);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return ['status' => 'success'];
    }

    /**
     * DELETE delete
     * @param int $voucherId
     * @return array
     */
	public function delete(int $voucherId)
    {
        $voucher = $this->voucherFactory->create()
            ->load($voucherId);

        if (empty($voucher->getData())) {
            throw new LocalizedException(__('Voucher not found!',
                ['voucher_id' => $voucherId]));
        }

        try {
            $this->voucherResource->delete($voucher);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return ['status' => 'success'];
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
        ])->filterByCustomerId($customerId)->getData();

        if (empty($data)) {
            throw new LocalizedException(
                __('Customer has no vouchers!', ['customer_id' => $customerId])
            );
        }

        return $data;
    }
}
