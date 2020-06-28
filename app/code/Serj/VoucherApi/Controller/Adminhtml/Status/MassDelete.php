<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Serj\VoucherApi\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Serj\VoucherApi\Ui\Component\MassAction\Filter;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Class MassDelete
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Serj_VoucherApi::delete';

    /**
     * @var VoucherStatusRepositoryInterface
     */
    protected $voucherStatusRepository;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param VoucherStatusRepositoryInterface $voucherStatusRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        VoucherStatusRepositoryInterface $voucherStatusRepository
    ) {
        parent::__construct($context);
        $this->voucherStatusRepository = $voucherStatusRepository;
        $this->filter = $filter;
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        if ($this->getRequest()->isPost() !== true) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));

            return $this->resultRedirectFactory->create()->setPath('*/*');
        }

        $deletedItemsCount = 0;
        foreach ($this->filter->getIds() as $id) {
            try {
                $id = (int)$id;
                $this->voucherStatusRepository->delete($id);
                $deletedItemsCount++;
            } catch (CouldNotDeleteException $e) {
                $errorMessage = __('[ID: %1] ', $id) . $e->getMessage();
                $this->messageManager->addErrorMessage($errorMessage);
            }
        }
        $this->messageManager->addSuccessMessage(__('You deleted %1 Voucher(s).', $deletedItemsCount));

        return $this->resultRedirectFactory->create()->setPath('*/*');
    }
}
