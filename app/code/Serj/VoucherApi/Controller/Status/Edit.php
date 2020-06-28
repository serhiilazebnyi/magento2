<?php

namespace Serj\VoucherApi\Controller\Status;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\Http;

class Edit extends Action implements HttpGetActionInterface
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
     * @param Context     $context
     * @param PageFactory $pageFactory
     * @param Http        $request
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Http $request
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        return parent::__construct($context);
    }

    /**
     * Creates voucher status edit page
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
