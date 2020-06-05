<?php

namespace Serj\VoucherApi\Api;

use Serj\VoucherApi\Api\Data\VoucherStatusInterface;

/**
 * Interface VoucherStatusRepositoryInterface
 * @package Serj\Api
 * @api
 */
interface VoucherStatusRepositoryInterface
{
    /**
     * Create new voucher status
     * @param \Serj\VoucherApi\Api\Data\VoucherStatusInterface $voucherStatus
     * @return mixed
     */
    public function save(VoucherStatusInterface $voucherStatus);

    /**
     * Delete voucher status
     * @param int $voucherStatusId
     * @return mixed
     */
	public function delete(int $voucherStatusId);

    /**
	 * Get all voucher statuses
	 * @return mixed
	 */
    public function getList();
}
