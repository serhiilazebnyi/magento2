<?php

namespace Serj\VoucherApi\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;
use Magento\Framework\UrlInterface;

/**
 * Prepare grid column region.
 */
class Status extends Column
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $voucherStatusRepository;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param VoucherRepositoryInterface $customerRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        VoucherStatusRepositoryInterface $voucherStatusRepository,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->voucherStatusRepository = $voucherStatusRepository;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if ($dataSource['data']['totalRecords'] > 0) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                $voucherStatus = $this->voucherStatusRepository->getById((int)$item[$name]);

                $item[$name] = $voucherStatus->getStatusCode();
            }
        }
        return $dataSource;
    }
}
