<?php

namespace Serj\VoucherApi\Api;

use Serj\VoucherApi\Api\Data\VoucherInterface;

interface VoucherRepositoryInterface
{
    /**
	 * @param \Serj\VoucherApi\Api\Data\VoucherInterface $voucher
	 * @return mixed
	 */
    public function save(VoucherInterface $voucher);

    /**
     * DELETE delete
     * @param int $id
     * @return mixed
     */
	public function delete(int $voucherId);

	/**
	 * GET getList
	 * @return mixed
	 */
    public function getList();

    /**
     * GET getByCustomerId
     * @param int $customerId
     * @return mixed
     */
	public function getByCustomerId(int $customerId);
}
