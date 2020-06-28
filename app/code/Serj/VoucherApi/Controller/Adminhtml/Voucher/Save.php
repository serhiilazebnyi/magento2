<?php

declare(strict_types=1);

namespace Serj\VoucherApi\Controller\Adminhtml\Voucher;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validation\ValidationException;
use Serj\VoucherApi\Api\Data\VoucherInterface;
use Serj\VoucherApi\Api\VoucherRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Save Controller
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Serj_VoucherApi::vouchers';

    /**
     * @var VoucherRepositoryInterface
     */
    private $voucherRepository;

    /**
     * @param Context $context
     * @param StockSaveProcessor $stockSaveProcessor
     */
    public function __construct(
        Context $context,
        VoucherRepositoryInterface $voucherRepository
    ) {
        parent::__construct($context);
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $request = $this->getRequest();
        $requestData = $request->getParams();
        if (!$request->isPost() || empty($requestData['general'])) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));
            $this->processRedirectAfterFailureSave($resultRedirect);
            return $resultRedirect;
        }
        
        return $this->processSave($requestData, $request, $resultRedirect);
    }

    /**
     * @param array $requestData
     * @param RequestInterface $request
     * @param Redirect $resultRedirect
     * @return ResultInterface
     */
    private function processSave(
        array $requestData,
        RequestInterface $request,
        Redirect $resultRedirect
    ): ResultInterface {
        try {
            $voucherId = isset($requestData['general'][VoucherInterface::ID])
                ? (int)$requestData['general'][VoucherInterface::ID]
                : null;
            $voucher = $this->voucherRepository->buildVoucher($requestData['general']);
            $this->voucherRepository->save($voucher);

            $this->messageManager->addSuccessMessage(__('The Voucher has been saved.'));
            $this->processRedirectAfterSuccessSave($resultRedirect, (int)$voucher->getId());
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('The Voucher does not exist.'));
            $this->processRedirectAfterFailureSave($resultRedirect);
        } catch (ValidationException $e) {
            foreach ($e->getErrors() as $localizedError) {
                $this->messageManager->addErrorMessage($localizedError->getMessage());
            }
            $this->processRedirectAfterFailureSave($resultRedirect, $voucherId);
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->processRedirectAfterFailureSave($resultRedirect, $voucherId);
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->processRedirectAfterFailureSave($resultRedirect, $voucherId);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Could not save Voucher.'));
            $this->processRedirectAfterFailureSave($resultRedirect, $voucherId ?? null);
        }
        return $resultRedirect;
    }

    /**
     * @param Redirect $resultRedirect
     * @param int $stockId
     *
     * @return void
     */
    private function processRedirectAfterSuccessSave(Redirect $resultRedirect, int $voucherId)
    {
        if ($this->getRequest()->getParam('back')) {
            $resultRedirect->setPath('*/*/edit', [
                VoucherInterface::ID => $voucherId,
                '_current' => true,
            ]);
        } elseif ($this->getRequest()->getParam('redirect_to_new')) {
            $resultRedirect->setPath('*/*/new', [
                '_current' => true,
            ]);
        } else {
            $resultRedirect->setPath('*/*/');
        }
    }

    /**
     * @param Redirect $resultRedirect
     * @param int|null $stockId
     *
     * @return void
     */
    private function processRedirectAfterFailureSave(Redirect $resultRedirect, int $voucherId = null)
    {
        if (null === $voucherId) {
            $resultRedirect->setPath('*/*/new');
        } else {
            $resultRedirect->setPath('*/*/edit', [
                VoucherInterface::ID => $voucherId,
                '_current' => true,
            ]);
        }
    }
}
