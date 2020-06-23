<?php

namespace Serj\VoucherApi\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Registry;
use Serj\VoucherApi\Api\VoucherRepositoryInterface;
use Serj\VoucherApi\Model\ResourceModel\VoucherStatus\CollectionFactory as VoucherStatusCollection;

/**
 * VoucherDataProvider class
 */
class VoucherDataProvider implements ArgumentInterface
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var VoucherRepositoryInterface
     */
    private $voucherRepository;
    /**
     * @var VoucherStatusCollection
     */
    private $voucherStatusCollection;

    /**
     * @param Registry                   $registry
     * @param VoucherRepositoryInterface $voucherRepository
     * @param VoucherStatusCollection    $voucherStatusCollection
     */
    public function __construct(
        Registry $registry,
        VoucherRepositoryInterface $voucherRepository,
        VoucherStatusCollection $voucherStatusCollection
    ) {
        $this->registry = $registry;
        $this->voucherRepository = $voucherRepository;
        $this->voucherStatusCollection = $voucherStatusCollection;
    }

    /**
     * @param  int    $customerId
     * @return Serj\VoucherApi\Model\ResourceModel\Voucher\Collection
     */
    public function getCustomerVouchers(int $customerId)
    {
        return $this->voucherRepository->getByCustomerId($customerId);
    }

    /**
     * Gets voucher statuses for <select> when creating or editing voucher
     * @return array
     */
    public function getStatusesForSelect()
    {
        $collection = $this->voucherStatusCollection->create();
        $statusesSelect = [];
        foreach ($collection as $voucherStatus) {
            $statusesSelect[$voucherStatus->getId()] = $voucherStatus->getStatusCode();
        }
        return $statusesSelect;
    }

    /**
     * Gets voucher data for edit from
     * @return Serj\VoucherApi\Api\Data\VoucherInterface
     */
    public function getEditData()
    {
        $id = $this->registry->registry('editRecordId');
        $voucher = $this->voucherRepository->getById($id);
        return $voucher;
    }
}
