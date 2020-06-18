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
     * @return array
     */
    public function save(string $statusCode);

    /**
     * Delete voucher status
     * @param int $voucherStatusId
     * @return array
     */
	public function delete(int $voucherStatusId);

    /**
	 * Get all voucher statuses
	 * @return array
	 */
    public function getList();
}
