<?php

declare(strict_types=1);

namespace Serj\VoucherApi\Controller\Adminhtml\Voucher;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * NewAction Controller
 */
class NewAction extends Action implements HttpGetActionInterface
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Serj_VoucherApi::vouchers';

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Serj_VoucherApi::vouchers');
        $resultPage->getConfig()->getTitle()->prepend(__('New Voucher'));

        return $resultPage;
    }
}
