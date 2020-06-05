<?php

namespace Serj\VoucherApi\Model;

use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;
use Serj\VoucherApi\Api\Data\VoucherStatusInterface;
use Serj\VoucherApi\Model\VoucherStatusFactory;
use Serj\VoucherApi\Model\ResourceModel\VoucherStatus as ResourceModel;
use Serj\VoucherApi\Model\ResourceModel\VoucherStatus\CollectionFactory as VoucherStatusCollectionFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class VoucherStatusRepository
 * @package Serj\VoucherApi\Model
 */

class VoucherStatusRepository implements VoucherStatusRepositoryInterface
{
    private $voucherStatusCollectionFactory;
    private $voucherStatusFactory;
    private $resourceModel;

    public function __construct(
        VoucherStatusCollectionFactory $voucherStatusCollectionFactory,
        VoucherStatusFactory $voucherStatusFactory,
        ResourceModel $resourceModel
    ) {
        $this->voucherStatusCollectionFactory = $voucherStatusCollectionFactory;
        $this->voucherStatusFactory = $voucherStatusFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * Create new voucher status
     * @param \Serj\VoucherApi\Api\Data\VoucherStatusInterface $voucherStatus
     * @return array
     */
    public function save(VoucherStatusInterface $voucherStatus)
    {
        try {
            $this->resourceModel->save($voucherStatus);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return ['status' => 'success'];
    }

    /**
     * Delete voucher status
     * @param int $voucherStatusId
     * @return array
     */
    public function delete(int $voucherStatusId)
    {
        $voucherStatus = $this->voucherStatusFactory->create()
            ->load($voucherStatusId);

        if (empty($voucherStatus->getData())) {
            throw new LocalizedException(
                __('Voucher status not found!', ['status_id' => $voucherStatusId])
            );
        }

        try {
            $this->resourceModel->delete($voucherStatus);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return ['status' => 'success'];
    }

    /**
	 * Get all voucher statuses
	 * @return array
	 */
    public function getList()
    {
        $voucherStatusCollection = $this->voucherStatusCollectionFactory->create();
        $data = $voucherStatusCollection->addFieldToSelect([
            VoucherStatusInterface::ID,
            VoucherStatusInterface::STATUS_CODE
        ])->setOrder(VoucherStatusInterface::ID, 'ASC')->getData();

        if (empty($data)) {
            throw new LocalizedException(__('There is no any voucher status yet!'));
        }

        return $data;
    }
}
