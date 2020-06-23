<?php

namespace Serj\VoucherApi\Api;

use Serj\VoucherApi\Api\Data\VoucherInterface;

/**
 * Interface VoucherRepositoryInterface
 * @api
 */
interface VoucherRepositoryInterface
{
    /**
     * POST save
	 * @param \Serj\VoucherApi\Api\Data\VoucherInterface $voucher
	 * @return array
	 */
    public function save(VoucherInterface $voucher);

    /**
     * DELETE delete
     * @param int $id
     * @return array
     */
	public function delete(int $voucherId);

	/**
	 * GET getList
	 * @return array
	 */
    public function getList();

    /**
     * GET getByCustomerId
     * @param int $customerId
     * @return array
     */
	public function getByCustomerId(int $customerId);

    /**
     * Gets voucher by id
     * @param  int $voucherId
     * @return VoucherInterface
     */
    public function getById(int $voucherId = null);

    /**
     * Builds voucher based on data
     * @param  array $data
     * @return VoucherInterface $voucher
     */
    public function buildVoucher($data = []);
}
