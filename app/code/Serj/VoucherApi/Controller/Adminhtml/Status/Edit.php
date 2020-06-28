<?php

namespace Serj\VoucherApi\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Serj\VoucherApi\Api\Data\VoucherStatusInterface;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Edit Controller
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Serj_VoucherApi::vouchers';

    /**
     * @var VoucherStatusRepositoryInterface
     */
    private $voucherStatusRepository;

    /**
     * @param Context $context
     * @param VoucherStatusRepositoryInterface $voucherStatusRepository
     */
    public function __construct(
        Context $context,
        VoucherStatusRepositoryInterface $voucherStatusRepository
    ) {
        parent::__construct($context);
        $this->voucherStatusRepository = $voucherStatusRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        $voucherStatusId = $this->getRequest()->getParam(VoucherStatusInterface::ID);
        try {
            $voucherStatus = $this->voucherStatusRepository->getById($voucherStatusId);

            /** @var Page $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $result->setActiveMenu('Serj_VoucherApi::vouchers')
                ->addBreadcrumb(__('Edit Voucher'), __('Edit Voucher Status'));
            $result->getConfig()
                ->getTitle()
                ->prepend(__('Edit Voucher: %code', ['code' => $voucherStatus->getStatusCode()]));
        } catch (NoSuchEntityException $e) {
            /** @var Redirect $result */
            $result = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(
                __('Vouchers with id "%id" does not exist.', ['id' => $voucherStatusId])
            );
            $result->setPath('*/*');
        }

        return $result;
    }
}
