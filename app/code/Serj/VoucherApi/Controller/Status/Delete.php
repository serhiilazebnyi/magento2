<?php

namespace Serj\VoucherApi\Controller\Status;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Form\FormKey\Validator;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface as VoucherStatusRepository;

class Delete extends Action implements HttpPostActionInterface
{
    /**
    * @var Page
    */
    private $pageFactory;
    /**
    * @var Http
    */
    private $request;
    /**
    * @var Validator
    */
    private $validator;
    /**
    * @var VoucherStatusRepository
    */
    private $voucherStatusRepository;

    /**
    * @param Context                 $context
    * @param PageFactory             $pageFactory
    * @param Http                    $request
    * @param VoucherStatusRepository $voucherStatusRepository
    */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Http $request,
        Validator $validator,
        VoucherStatusRepository $voucherStatusRepository
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->validator = $validator;
        $this->voucherStatusRepository = $voucherStatusRepository;
        return parent::__construct($context);
    }

    /**
     * Deletes voucher status and redirects to status index page
     */
    public function execute()
    {
        $request = $this->getRequest();
        if ($this->validator->validate($request) && $request->isPost()) {
            try {
                $id = $this->request->getParam('id');
                $this->voucherStatusRepository->delete($id);
                $this->messageManager->addSuccessMessage('Voucher status deleted!');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            return $this->_redirect('vouchers/status');
        }
    }
}
