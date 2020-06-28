<?php

declare(strict_types=1);

namespace Serj\VoucherApi\Controller\Adminhtml\Status;

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
use Serj\VoucherApi\Api\Data\VoucherStatusInterface;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;
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
     * @var VoucherStatusRepositoryInterface
     */
    private $voucherStatusRepository;

    /**
     * @param Context $context
     * @param StockSaveProcessor $stockSaveProcessor
     */
    public function __construct(
        Context $context,
        VoucherStatusRepositoryInterface $voucherStatusRepository
    ) {
        parent::__construct($context);
        $this->voucherStatusRepository = $voucherStatusRepository;
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
            $voucherStatusId = isset($requestData['general'][VoucherStatusInterface::ID])
                ? (int)$requestData['general'][VoucherStatusInterface::ID]
                : null;

            if (!$voucherStatusId) {
                unset($requestData['general']['entity_id']);
            }

            $voucherStatus = $this->voucherStatusRepository->buildVoucherStatus($requestData['general']);

            $this->voucherStatusRepository->saveEntity($voucherStatus);

            $this->messageManager->addSuccessMessage(__('The Voucher has been saved.'));
            $this->processRedirectAfterSuccessSave($resultRedirect, (int)$voucherStatus->getId());
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('The Voucher does not exist.'));
            $this->processRedirectAfterFailureSave($resultRedirect);
        } catch (ValidationException $e) {
            foreach ($e->getErrors() as $localizedError) {
                $this->messageManager->addErrorMessage($localizedError->getMessage());
            }
            $this->processRedirectAfterFailureSave($resultRedirect, $voucherStatusId);
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->processRedirectAfterFailureSave($resultRedirect, $voucherStatusId);
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->processRedirectAfterFailureSave($resultRedirect, $voucherStatusId);
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
    private function processRedirectAfterSuccessSave(Redirect $resultRedirect, int $voucherStatusId)
    {
        if ($this->getRequest()->getParam('back')) {
            $resultRedirect->setPath('*/*/edit', [
                VoucherStatusInterface::ID => $voucherStatusId,
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
    private function processRedirectAfterFailureSave(Redirect $resultRedirect, int $voucherStatusId = null)
    {
        if (null === $voucherId) {
            $resultRedirect->setPath('*/*/new');
        } else {
            $resultRedirect->setPath('*/*/edit', [
                VoucherStatusInterface::ID => $voucherStatusId,
                '_current' => true,
            ]);
        }
    }
}
