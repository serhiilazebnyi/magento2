<?php

namespace Serj\VoucherApi\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Serj\VoucherApi\Api\Data\VoucherInterface;
use Serj\VoucherApi\Api\VoucherRepositoryInterface;
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
     * @var SourceRepositoryInterface
     */
    private $voucherRepository;

    /**
     * @param Context $context
     * @param SourceRepositoryInterface $sourceRepository
     */
    public function __construct(
        Context $context,
        voucherRepositoryInterface $voucherRepository
    ) {
        parent::__construct($context);
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        $voucherId = $this->getRequest()->getParam(VoucherInterface::ID);
        try {
            $voucher = $this->voucherRepository->getById($voucherId);

            /** @var Page $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $result->setActiveMenu('Serj_VoucherApi::vouchers')
                ->addBreadcrumb(__('Edit Voucher'), __('Edit Voucher'));
            $result->getConfig()
                ->getTitle()
                ->prepend(__('Edit Voucher: %code', ['code' => $voucher->getVoucherCode()]));
        } catch (NoSuchEntityException $e) {
            /** @var Redirect $result */
            $result = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(
                __('Vouchers with id "%id" does not exist.', ['id' => $voucherId])
            );
            $result->setPath('*/*');
        }

        return $result;
    }
}
