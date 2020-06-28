<?php

namespace Serj\VoucherApi\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Request\Http;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;

/**
 * VoucherStatusDataProvider class
 */
class VoucherStatusDataProvider implements ArgumentInterface
{
    /**
     * @var Http
     */
    private $request;
    /**
     * @var VoucherRepositoryInterface
     */
    private $voucherStatusRepository;

    /**
     * @param Http                       $request
     * @param VoucherRepositoryInterface $voucherRepository
     */
    public function __construct(
        Http $request,
        VoucherStatusRepositoryInterface $voucherStatusRepository
    ) {
        $this->request = $request;
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
        $id = $this->request->getParam('id');
        $voucherStatus = $this->voucherStatusRepository->getById($id);
        return $voucherStatus;
    }
}
