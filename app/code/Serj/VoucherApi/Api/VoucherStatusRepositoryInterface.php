<?php

namespace Serj\VoucherApi\Api;

use Serj\VoucherApi\Api\Data\VoucherStatusInterface;

/**
 * Interface VoucherStatusRepositoryInterface
 * @api
 */
interface VoucherStatusRepositoryInterface
{
    /**
     * Create new voucher status
     * @param string $voucherStatus
     * @return mixed
     */
    public function save(string $statusCode);

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
