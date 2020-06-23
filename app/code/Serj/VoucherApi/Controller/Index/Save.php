<?php

namespace Serj\VoucherApi\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Serj\VoucherApi\Api\VoucherRepositoryInterface as VoucherRepository;
use Serj\VoucherApi\Api\Data\VoucherInterfaceFactory as VoucherFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var Page
     */
    private $pageFactory;
    /**
     * @var Validator
     */
    private $vaidator;
    /**
     * @var VoucherInterfaceFactory
     */
    private $voucherFactory;
    /**
     * @var VoucherRepositoryInterface
     */
    private $voucherRepository;

    /**
     * @param Context           $context
     * @param PageFactory       $pageFactory
     * @param VoucherRepository $voucherRepository
     * @param VoucherFactory    $voucherFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Validator $validator,
        VoucherRepository $voucherRepository,
        VoucherFactory $voucherFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->validator = $validator;
        $this->voucherRepository = $voucherRepository;
        $this->voucherFactory = $voucherFactory;
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
                $voucher = $this->voucherRepository->buildVoucher($postData);
                $this->voucherRepository->save($voucher);
                $this->messageManager->addSuccessMessage('Voucher saved!');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            return $this->_redirect('vouchers/index/index');
        }
    }
}
