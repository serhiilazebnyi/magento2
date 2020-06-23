<?php

namespace Serj\VoucherApi\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Registry;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;

/**
 * VoucherStatusDataProvider class
 */
class VoucherStatusDataProvider implements ArgumentInterface
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var VoucherRepositoryInterface
     */
    private $voucherStatusRepository;

    /**
     * @param Registry                   $registry
     * @param VoucherRepositoryInterface $voucherRepository
     */
    public function __construct(
        Registry $registry,
        VoucherStatusRepositoryInterface $voucherStatusRepository
    ) {
        $this->registry = $registry;
        $this->voucherStatusRepository = $voucherStatusRepository;
    }

    public function getVoucherStatuses()
    {
        return $this->voucherStatusRepository->getList();
    }

    /**
     * Gets voucher data for edit from
     * @return Serj\VoucherApi\Api\Data\VoucherInterface
     */
    public function getEditData()
    {
        $id = $this->registry->registry('editRecordId');
        $voucherStatus = $this->voucherStatusRepository->getById($id);
        return $voucherStatus;
    }
}
