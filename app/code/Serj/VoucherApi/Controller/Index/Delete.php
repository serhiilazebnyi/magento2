<?php

namespace Serj\VoucherApi\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Form\FormKey\Validator;
use Serj\VoucherApi\Api\VoucherRepositoryInterface as VoucherRepository;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var PageFactory
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
     * @var VoucherRepository
     */
    private $voucherRepository;

    /**
     * @param Context           $context
     * @param PageFactory       $pageFactory
     * @param Http              $request
     * @param VoucherRepository $voucherRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Http $request,
        Validator $validator,
        VoucherRepository $voucherRepository
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_request = $request;
        $this->validator = $validator;
        $this->voucherRepository = $voucherRepository;
        return parent::__construct($context);
    }

    /**
     * Deletes the voucher and redirects to voucher index page
     */
    public function execute()
    {
        $request = $this->getRequest();
        if ($this->validator->validate($request) && $request->isPost()) {
            try {
                $id = $this->_request->getParam('id');
                $this->voucherRepository->delete($id);
                $this->messageManager->addSuccessMessage('Voucher deleted!');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            return $this->_redirect('vouchers/index/index');
        }
    }
}
