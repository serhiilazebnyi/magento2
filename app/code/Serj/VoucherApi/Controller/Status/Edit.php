<?php

namespace Serj\VoucherApi\Controller\Status;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Registry;

class Edit extends Action
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
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @param Context     $context
     * @param PageFactory $pageFactory
     * @param Http        $request
     * @param Registry    $coreRegistry
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Http $request,
        Registry $coreRegistry
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->coreRegistry = $coreRegistry;
        return parent::__construct($context);
    }

    /**
     * Creates voucher status edit page
     */
    public function execute()
    {
        $id = $this->request->getParam('id');
        $this->coreRegistry->register('editRecordId', $id);
        return $this->pageFactory->create();
    }
}
