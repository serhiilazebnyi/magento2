<?php

namespace Serj\VoucherApi\Controller\Status;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface as VoucherStatusRepository;

class Save extends Action implements HttpPostActionInterface
{
    private $pageFactory;
    private $validator;
    private $voucherStatusRepository;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Validator $validator,
        VoucherStatusRepository $voucherStatusRepository
    ) {
        $this->pageFactory = $pageFactory;
        $this->validator = $validator;
        $this->voucherStatusRepository = $voucherStatusRepository;
        return parent::__construct($context);
    }

    /**
     * Saves voucher and redirect to index page
     */
    public function execute()
    {
        $request = $this->getRequest();
        if ($this->validator->validate($request) && $request->isPost()) {
            $postData = $request->getPostValue();

            if ($postData['entity_id'] == null) {
                unset($postData['entity_id']);
            }

            try {
                $voucherStatus = $this->voucherStatusRepository->buildVoucherStatus($postData);
                $this->voucherStatusRepository->saveEntity($voucherStatus);
                $this->messageManager->addSuccessMessage('Voucher status saved!');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            return $this->_redirect('vouchers/status/index');
        }
    }
}
